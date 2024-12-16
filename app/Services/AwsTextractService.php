<?php
namespace App\Services;

use Aws\Textract\TextractClient;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AwsTextractService
{
    protected $textractClient;

    public function __construct()
    {
        $this->textractClient = new TextractClient([
            'region' => config('services.aws.region'),
            'version' => 'latest',
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);
    }

    public function extractText($filePath)
    {
        try {
            $result = $this->textractClient->DetectDocumentText([
                'Document' => [
                    'Bytes' => file_get_contents($filePath),
                ],
                'FeatureTypes' => ['TABLES', 'FORMS'],
            ]);

            return $result['Blocks'] ?? [];
        } catch (AwsException $e) {
            return null;
        }
    }

    public function extractTextFromImage($imagePath)
    {
        $imageBlob = file_get_contents($imagePath);

        // เรียกใช้ Textract สำหรับภาพ
        $response = $this->textractClient->detectDocumentText([
            'Document' => [
                'Bytes' => $imageBlob,
            ],
        ]);

        return $response['Blocks'] ?? null; // คืนค่า text blocks
    }

    public function extractTextFromPDF($filePath)
    {
        // ตรวจสอบค่า bucketName
        $bucketName = env('AWS_BUCKET');
        if (empty($bucketName)) {
            throw new \Exception('Bucket name is not set in the .env file.');
        }

        // อัปโหลดไฟล์ PDF ไปยัง S3
        $objectKey = urlencode(basename($filePath));
        // ตรวจสอบว่าไฟล์ PDF มีอยู่จริง
        if (!file_exists($filePath)) {
            throw new \Exception("File does not exist: $filePath");
        }

        // ใช้ Storage facade เพื่ออัปโหลดไฟล์
        Storage::disk('s3')->putFileAs('', new \Illuminate\Http\File($filePath), $objectKey);

        // เริ่มการประมวลผล Textract สำหรับ PDF
        $response = $this->textractClient->startDocumentTextDetection([
            'DocumentLocation' => [
                'S3Object' => [
                    'Bucket' => $bucketName,
                    'Name' => $objectKey,
                ],
            ],
        ]);

        // รอผลลัพธ์ (ตามต้องการ คุณอาจใช้ Polling หรือ SNS)
        return $this->getTextractResult($response['JobId']);
    }

    public function getTextractResult($jobId)
    {
    do {
        $response = $this->textractClient->getDocumentTextDetection([
            'JobId' => $jobId,
        ]);

        // ตรวจสอบสถานะของ job
        $status = $response['JobStatus'];
        if ($status == 'SUCCEEDED') {
            return $response; // ส่งกลับผลลัพธ์
        } elseif ($status == 'FAILED') {
            throw new \Exception('Textract job failed.');
        }

        // รอเพื่อทำการ polling ใหม่
        sleep(5); // รอ 5 วินาทีก่อนเช็คอีกครั้ง
    } while ($status == 'IN_PROGRESS');
}
}
