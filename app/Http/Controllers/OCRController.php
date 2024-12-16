<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;

class OCRController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'scan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4082',
        ]);

        // เก็บไฟล์ที่อัปโหลด
        $path = $request->file('scan');
        $imageName = $path->getClientOriginalName();

        // สร้างโฟลเดอร์เก็บไฟล์ถ้ายังไม่มี
        $idFolder = public_path('uploads/pdf/');
        if (!file_exists($idFolder)) {
            mkdir($idFolder, 0755, true);
        }

        // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
        if (!$path->move($idFolder, $imageName)) {
            return response()->json(['error' => 'File could not be moved.'], 500);
        }

        $filePath = $idFolder . $imageName;
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File does not exist.'], 404);
        }

        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        // ตรวจสอบประเภทไฟล์และประมวลผลข้อความ
        $text = $this->processDocument($filePath);
        $isPdf = $fileExtension === 'pdf';

        return view('result', compact('text', 'imageName', 'isPdf'));
    }

    private function processDocument($filePath)
    {
        // ตั้งค่าข้อมูลโปรเจกต์และไอดี Document Processor
        $projectId = 'summer-sun-442109-m1';
        $location = 'us'; // เช่น us, eu
        $processorId = '569840618de6925c';

        $client = new DocumentProcessorServiceClient([
            'credentials' => storage_path('app/document-ai-key.json')
        ]);

        $name = $client->processorName($projectId, $location, $processorId);

        // อ่านไฟล์และเตรียมข้อมูลสำหรับ Document AI
        $fileData = file_get_contents($filePath);
        $tmp = explode('.', basename($filePath)); // ใช้ basename เพื่อเอาชื่อไฟล์อย่างเดียว
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
            return "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }
}