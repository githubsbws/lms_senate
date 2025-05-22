<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\DocumentAI\V1beta3\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1beta3\RawDocument;
use Google\Cloud\DocumentAI\V1beta3\ProcessRequest;
use Illuminate\Support\Facades\Response;


class ApiocrController extends Controller
{
    public function testOcrInput(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'file' => 'required|file'
        ]);

        $inputText = $request->input('text');

        $file = $request->file('file');

        return response()->json([
            'status' => 'success',
            'message' => 'Received successfully',
            'received_text' => $inputText,
            'file_name' => $file->getClientOriginalName()
        ]);
    }

    private function convertPdfToImages($pdfPath, $outputFolder)
    {
        $imagick = new \Imagick();
        $imagick->setResolution(300, 300); // ความละเอียดในการแปลง
        $imagick->readImage($pdfPath);

        $imagePaths = [];

        foreach ($imagick as $i => $page) {
            $page->setImageFormat('png');
            $imagePath = $outputFolder . '/page_' . ($i + 1) . '.png';
            $page->writeImage($imagePath);
            $imagePaths[] = $imagePath;
        }

        $imagick->clear();
        $imagick->destroy();

        return $imagePaths;
    }

    private function processDocument($filePath)
    {
        // ตั้งค่าข้อมูลโปรเจกต์และไอดี Document Processor
        $projectId = 'summer-sun-442109-m1';
        $location = 'us'; // เช่น us, eu
        $processorId = '569840618de6925c';

        $client = new DocumentProcessorServiceClient([
            'credentials' => storage_path('app/document-ai-key.json') // ใส่ไฟล์ key ที่ใช้เชื่อมต่อ Google Cloud
        ]);

        $name = $client->processorName($projectId, $location, $processorId);

        // อ่านไฟล์และเตรียมข้อมูลสำหรับ Document AI
        $fileData = file_get_contents($filePath);
        $tmp = explode('.', basename($filePath)); // ใช้ basename เพื่อเอาชื่อไฟล์
        $fileExtension = strtolower(end($tmp)); // ตรวจสอบนามสกุลไฟล์

        $rawDocument = new RawDocument([
            'content' => $fileData,
            'mime_type' => $fileExtension === 'pdf' ? 'application/pdf' : 'image/png'
        ]);

        $request = new ProcessRequest([
            'name' => $name,
            'raw_document' => $rawDocument
        ]);

        try {
            $response = $client->processDocument($request);
            $document = $response->getDocument();
            $text = $document->getText();

            $client->close();
            return $text ?: "ไม่พบข้อความในเอกสาร";

        } catch (\Exception $e) {
            throw new \Exception("เกิดข้อผิดพลาด: " . $e->getMessage());
        }
    }
}
