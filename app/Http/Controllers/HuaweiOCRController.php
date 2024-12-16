<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HuaweiCloud\SDK\Iam\V3\Region;
use HuaweiCloud\SDK\Core\Auth\BasicCredentials;
use HuaweiCloud\SDK\Ocr\V1\OcrClient;
use HuaweiCloud\SDK\Ocr\V1\Model\RecognizeGeneralTextRequest;
use HuaweiCloud\SDK\Ocr\V1\Model\GeneralTextRequestBody;
use HuaweiCloud\SDK\Core\Http\HttpConfig;
use HuaweiCloud\SDK\Core\Exceptions\ConnectionException;
use HuaweiCloud\SDK\Core\Exceptions\RequestTimeoutException;
use HuaweiCloud\SDK\Core\Exceptions\ServiceResponseException;
use Imagick;

class HuaweiOCRController extends Controller
{
    public function showForm()
    {
        return view('huaweiupload');
    }
    public function ocr(Request $request)
    {
        // ตรวจสอบว่าไฟล์ PDF ถูกอัปโหลด
        if (!$request->hasFile('pdf')) {
            return response()->json(['error' => 'No PDF file uploaded'], 400);
        }

        // อ่านไฟล์ PDF
        $pdfFile = $request->file('pdf');

        // ตรวจสอบว่าไฟล์ PDF สามารถเข้าถึงได้
        if (!$pdfFile->isValid()) {
            return response()->json(['error' => 'Uploaded PDF is not valid'], 400);
        }

        // กำหนดเส้นทางที่จะเก็บไฟล์ PDF ที่ย้ายไป
        $uploadFolder = public_path('uploads/pdf/');

        // สร้างโฟลเดอร์ถ้าหากยังไม่มี
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0755, true);
        }

        // ย้ายไฟล์ PDF ไปยังโฟลเดอร์ที่ถาวร
        $imageName = $pdfFile->getClientOriginalName();  // ชื่อไฟล์เดิม
        $filePath = $uploadFolder . $imageName;

        if (!$pdfFile->move($uploadFolder, $imageName)) {
            return response()->json(['error' => 'File could not be moved.'], 500);
        }

        // ตรวจสอบว่าไฟล์ถูกย้ายสำเร็จ
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File does not exist.'], 404);
        }

        // ตอนนี้ใช้ $filePath ซึ่งเป็นไฟล์ที่ย้ายแล้ว
        try {
            // แปลง PDF เป็นภาพ
            $imagePaths = $this->convertPdfToImages($filePath); // ใช้ $filePath ที่ย้ายแล้ว
            
            // สร้าง Client สำหรับ Huawei OCR
            $client = $this->createOcrClient();
            
            $ocrResults = [];

            // ส่งแต่ละหน้าของภาพไปให้ Huawei OCR
            foreach ($imagePaths as $imagePath) {
                $ocrResults[] = $this->performOcr($client, $imagePath);
                
            }
            
            // กลับไปยังหน้าแสดงผล OCR
            return view('huaweiresult',compact('ocrResults', 'imageName'));  // เปลี่ยนไปใช้ route แทนการใช้ return view

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function convertPdfToImages($pdfPath)
    {
        // สร้าง instance ของ Imagick
        $imagick = new Imagick();

        // ตรวจสอบว่าไฟล์ PDF มีอยู่หรือไม่
        if (!file_exists($pdfPath)) {
            throw new \Exception("PDF file does not exist: $pdfPath");
        }

        // อ่านไฟล์ PDF
        $imagick->readImage($pdfPath);

        // สร้าง array เก็บเส้นทางของไฟล์ภาพที่แปลงแล้ว
        $imagePaths = [];
        $uploadFolder = public_path('uploads/pdf/');  // กำหนดโฟลเดอร์สำหรับบันทึกไฟล์ภาพ
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0755, true);  // สร้างโฟลเดอร์ถ้ายังไม่มี
        }

        // แปลงทุกหน้าของ PDF ไปเป็นภาพ PNG
        foreach ($imagick as $index => $image) {
            $imagePath = $uploadFolder . "pdf_page_{$index}.png"; // ตั้งชื่อไฟล์ภาพที่แปลงแล้ว
            $image->setImageFormat('png'); // กำหนดให้เป็น PNG
            $image->writeImage($imagePath); // บันทึกไฟล์ภาพ
            $imagePaths[] = $imagePath; // เพิ่มเส้นทางไฟล์ภาพลงใน array
        }

        return $imagePaths;
    }
    private function createOcrClient()
    {
        $config = HttpConfig::getDefaultConfig();
        // กำหนด Region
        $region = new \HuaweiCloud\SDK\Core\Region\Region('ap-southeast-2', 'https://ocr.ap-southeast-2.myhuaweicloud.com');  // กำหนด region และ endpoint
        $endpoint = "https://ocr.ap-southeast-2.myhuaweicloud.com";
        // กำหนด Credentials
        $credentials = new \HuaweiCloud\SDK\Core\Auth\BasicCredentials();
        $credentials->withAk('FSOATP433QPTMB4UBS0R')  // ใส่ Access Key ของคุณ
                    ->withSk('hw6heqRIhzqdUrpxsKhdrZEHU0UcZPkVmVk7qrO6');  // ใส่ Secret Key ของคุณ

        // สร้าง Client สำหรับใช้งาน OCR
        $client = OcrClient::newBuilder(new OcrClient)
                            ->withHttpConfig($config)
                            ->withEndpoint($endpoint)
                            ->withCredentials($credentials)
                            ->build();

    
        return $client; // ส่งคืน client ที่สร้างขึ้น
    }
    private function performOcr($client, $imagePath)
    {
        
        // แปลงภาพเป็น base64
        $imageData = base64_encode(file_get_contents($imagePath));

        $body = new \HuaweiCloud\SDK\Ocr\V1\Model\GeneralTextRequestBody();
        $body->setImage($imageData); // ตั้งค่า imageData ให้กับ body
        $body->setLanguage('th'); 
        $request = new \HuaweiCloud\SDK\Ocr\V1\Model\RecognizeGeneralTextRequest();
        $request->setBody($body);

        try {
            // เรียก API OCR ด้วย client
            $response = $client->recognizeGeneralText($request);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
