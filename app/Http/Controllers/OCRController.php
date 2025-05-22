<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;
use setasign\Fpdi\Fpdi;

class OCRController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'scan' => 'required|file|mimes:jpg,jpeg,png,pdf',
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
        $isPdf = $fileExtension === 'pdf';

        if ($isPdf) {
            // แยก PDF และรวมข้อความทั้งหมด
            $splitFiles = $this->splitPdf($filePath, $idFolder);
            $texts = [];

            foreach ($splitFiles as $chunk) {
                $texts[] = $this->processDocument($chunk);
            }

            $text = implode("\n\n", $texts);
        } else {
            // ประมวลผลไฟล์ภาพ
            $text = $this->processDocument($filePath);
        }

        return view('result', compact('text', 'imageName', 'isPdf'));
    }
    private function splitPdf($filePath, $outputDir, $chunkSize = 15)
    {
        $pdf = new Fpdi();
        $pdf->setSourceFile($filePath);

        $totalPages = $pdf->getNumPages();
        $chunks = ceil($totalPages / $chunkSize);

        $splitFiles = [];

        for ($i = 0; $i < $chunks; $i++) {
            $pdf = new Fpdi();
            for ($j = 0; $j < $chunkSize; $j++) {
                $pageIndex = ($i * $chunkSize) + $j + 1;
                if ($pageIndex > $totalPages) break;

                $pdf->AddPage();
                $pdf->importPage($pageIndex);
                $pdf->useTemplate($pdf->importPage($pageIndex));
            }
            $splitFile = $outputDir . "split_" . ($i + 1) . ".pdf";
            $pdf->Output($splitFile, 'F');
            $splitFiles[] = $splitFile;
        }

        return $splitFiles;
    }
    private function processDocument($filePath)
    {
        $projectId = 'summer-sun-442109-m1';
        $location = 'us';
        $processorId = '569840618de6925c';

        $client = new DocumentProcessorServiceClient([
            'credentials' => storage_path('app/document-ai-key.json')
        ]);

        $name = $client->processorName($projectId, $location, $processorId);

        $fileData = file_get_contents($filePath);
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $rawDocument = new RawDocument([
            'content' => $fileData,
            'mime_type' => $fileExtension === 'pdf' ? 'application/pdf' : 'image/png',
        ]);

        $request = new ProcessRequest([
            'name' => $name,
            'raw_document' => $rawDocument,
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