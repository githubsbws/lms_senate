<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;
use App\Models\TextFile;
use Imagick;
use App\Events\FileUploadProgress; // Event ที่ใช้ Broadcast


class ProcessUploadedDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileId;
    protected $filePath;
    protected $uniqueFolder;

    public function __construct($fileId, $filePath, $uniqueFolder)
    {
        $this->fileId = $fileId;
        $this->filePath = $filePath;
        $this->uniqueFolder = $uniqueFolder;
    }

    public function handle(): void
    {
        // แปลง PDF เป็นรูป
        $images = $this->convertPdfToImages($this->filePath, $this->uniqueFolder);

        $totalImages = count($images);

        foreach ($images as $index => $imagePath) {
            $text = $this->processDocument($imagePath);

            $progress = (($index + 1) / $totalImages) * 100;
            broadcast(new FileUploadProgress($this->fileId, $index + 1, $progress));

            // บันทึกผล OCR
            $this->saveTextToDatabase($this->fileId, $index + 1, $text);
        }

        // ลบภาพชั่วคราว
        Storage::disk('public')->deleteDirectory(basename($this->uniqueFolder));
    }

    private function convertPdfToImages($filePath, $uniqueFolder, $batchSize = 20)
    {
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $imagick = new \Imagick();
        $imagick->pingImage($filePath);
        $totalPages = $imagick->getNumberImages();
        $images = [];

        for ($batchStart = 0; $batchStart < $totalPages; $batchStart += $batchSize) {
            $batchEnd = min($batchStart + $batchSize, $totalPages);

            for ($i = $batchStart; $i < $batchEnd; $i++) {
                $page = new \Imagick();
                $page->setResolution(300, 300);
                $page->readImage("{$filePath}[{$i}]");
                $page->setImageFormat('jpg');
                $page->setImageCompression(\Imagick::COMPRESSION_JPEG);
                $page->setImageCompressionQuality(80);

                $outputPath = "{$uniqueFolder}/pdf_page_{$i}.jpg";
                $page->writeImage($outputPath);
                $images[] = $outputPath;

                $page->clear();
                $page->destroy();
            }

            gc_collect_cycles();
        }

        return $images;
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
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $rawDocument = new RawDocument([
            'content' => $fileData,
            'mime_type' => $ext === 'pdf' ? 'application/pdf' : 'image/png'
        ]);

        try {
            $response = $client->processDocument(
                new ProcessRequest([
                    'name' => $name,
                    'raw_document' => $rawDocument
                ])
            );

            return $response->getDocument()->getText() ?: 'ไม่พบข้อความในเอกสาร';
        } catch (\Exception $e) {
            return "เกิดข้อผิดพลาด: " . $e->getMessage();
        } finally {
            $client->close();
        }
    }

    private function saveTextToDatabase($fileId, $page, $text)
    {
        $ocrText = new TextFile();
        $ocrText->file_id = $fileId;           // เชื่อมโยงกับไฟล์ที่อัปโหลด
        $ocrText->page_number = $page;   // หมายเลขหน้า
        $ocrText->text = $text;         // ข้อความ OCR
        $ocrText->save();                   // บันทึกลงฐานข้อมูล
    }
}
