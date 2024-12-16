<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Imagick;

class InetOCRController extends Controller
{
    
    public function showForm()
    {
        return view('inetupload');
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

        try {
            // แปลง PDF เป็นภาพ
            $imagePaths = $this->convertPdfToImages($filePath); // ใช้ $filePath ที่ย้ายแล้ว
            
            // สร้าง array สำหรับเก็บผลลัพธ์จาก OCR
            $ocrResults = [];

            // ส่งแต่ละหน้าของภาพไปให้ OCR
            foreach ($imagePaths as $imagePath) {
                $ocrResults[] = $this->sendOCRRequest($imagePath); // ส่งภาพไป OCR API
            }

            // กลับไปยังหน้าแสดงผล OCR
            return view('inetresult', compact('ocrResults', 'imageName'));

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

    private function sendOCRRequest($imagePath)
    {
        // อ่านภาพเป็น base64
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);

        $url = 'https://ai-api.manageai.co.th/ai/ocr/billing/api/v1/prediction';

        try {
            // ส่งคำขอ POST ไปยัง API OCR
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'manageai-key' => 'hz0vIV22kX5pyyYMjCORZn6zkBHt23Ec',
            ])->post($url, [
                'image_base64' => $base64Image,
            ]);

            // ตรวจสอบการตอบกลับจาก API
            if ($response->successful()) {
                return $response->json();
            } else {
                // เพิ่มข้อความผิดพลาดเพิ่มเติม
                throw new \Exception("OCR API returned an error: " . $response->body());
            }
        } catch (\Exception $e) {
            // จัดการข้อผิดพลาดและบันทึก log
            \Log::error('OCR request failed: ' . $e->getMessage());
            return [
                'error' => 'OCR Request failed',
                'status' => $response->status() ?? 'N/A',
                'message' => $e->getMessage(),
            ];
        }
    }
}
