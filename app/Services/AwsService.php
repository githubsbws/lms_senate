<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\Textract\TextractClient;
use Aws\Exception\AwsException;

class AwsService
{
    protected $s3Client;
    protected $textractClient;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $this->textractClient = new TextractClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function uploadToS3($filePath, $fileName)
    {
        try {
            $this->s3Client->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => 'uploads/pdf/' . $fileName,
                'SourceFile' => $filePath,
                'ACL' => 'public-read', // หรือปรับตามที่ต้องการ
            ]);
            return 'uploads/pdf/' . $fileName;
        } catch (AwsException $e) {
            return null; // หรือจัดการข้อผิดพลาดตามที่ต้องการ
        }
    }

    public function analyzeDocument($s3Object)
    {
        try {
            $result = $this->textractClient->startDocumentAnalysis([
                'DocumentLocation' => [
                    'S3Object' => $s3Object,
                ],
                'FeatureTypes' => ['TABLES', 'FORMS'],
            ]);

            return $result['JobId'];
        } catch (AwsException $e) {
            return null; // หรือจัดการข้อผิดพลาดตามที่ต้องการ
        }
    }

    public function getDocumentAnalysis($jobId)
    {
        try {
            // รอการประมวลผลจนกว่าจะเสร็จสิ้น
            do {
                $result = $this->textractClient->getDocumentAnalysis(['JobId' => $jobId]);
                sleep(5); // รอ 5 วินาทีก่อนที่จะตรวจสอบอีกครั้ง
            } while ($result['JobStatus'] == 'IN_PROGRESS');

            return $result['Blocks'] ?? [];
        } catch (AwsException $e) {
            return null; // หรือจัดการข้อผิดพลาดตามที่ต้องการ
        }
    }
}
