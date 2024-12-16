<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AwsTextractService;

class AwsOCRController extends Controller
{
    protected $textractService;

    public function __construct(AwsTextractService $textractService)
    {
        $this->textractService = $textractService;
    }

    public function showForm()
    {
        return view('awsupload');
    }
    // ประมวลผลภาพที่อัปโหลด
    public function processImage(Request $request)
    {
        // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,pdf|max:4082',
        ]);

        // รับไฟล์จากการอัปโหลด
        $file = $request->file('image');
        $imageName = $file->getClientOriginalName();

        // สร้างโฟลเดอร์เก็บไฟล์ถ้ายังไม่มี
        $uploadFolder = public_path('uploads/pdf/');
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0755, true);
        }

        // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
        $filePath = $uploadFolder . $imageName;
        if (!$file->move($uploadFolder, $imageName)) {
            return response()->json(['error' => 'File could not be moved.'], 500);
        }

        // ตรวจสอบว่าไฟล์ถูกย้ายสำเร็จ
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File does not exist.'], 404);
        }

        // ตรวจสอบนามสกุลของไฟล์
        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $textBlocks = null;

        // ประมวลผล OCR ด้วย AWS Textract
        if ($fileExtension === 'pdf') {
            // สำหรับไฟล์ PDF
            $textBlocks = $this->textractService->extractTextFromPDF($filePath);
        } else {
            // สำหรับไฟล์ภาพ
            $textBlocks = $this->textractService->extractTextFromImage($filePath);
        }
        $isPdf = $fileExtension === 'pdf';
        // ส่งผลลัพธ์ไปแสดงที่ View
        return view('awsresult', compact('textBlocks', 'imageName', 'fileExtension','isPdf'));
    }
}
