<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TextFile;
use App\Models\File;
use App\Models\TypePeriod;
use App\Models\TypeYears;
use App\Models\TypeCate;
use App\Models\TypeMeet;

class DocumentController extends Controller
{
    public function document(Request $request)
    {
        $file = TextFile::with(['years', 'period','cate','meet','file'])
                        ->where('active', 'y')
                        ->get();
        return view('admin.page.document.index',['file' => $file ]);
    }

    public function document_import(Request $request)
    {
        return view('admin.page.document.import.index');
    }

    public function document_upload(Request $request,$id)
    {
        if($request->isMethod('post')){
            $request->validate([
                'scan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4082',
            ]);
    
            // เก็บไฟล์ที่อัปโหลด
            $path = $request->file('scan');
            $imageName = $path->getClientOriginalName();
    
            $file = new File;
            $file->name_file = $imageName;
            $file->create_date = now();
            $file->create_by = '1';
            $file->active = 'y';
            $file->save();
    
            $file_id = $file->id;
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
    
            return view('admin.page.document.file.result', compact('text', 'imageName', 'isPdf','file_id','id'));
        }    
        return view('admin.page.document.file.create', compact('id'));    
    }
    public function document_save(Request $request,$file_id,$id)
    {
        $validatedData = $request->validate([
            'text' => 'nullable|string',
        ]);

        $meet = TypeMeet::findOrFail($id);
        // dd($meet->period_id);
        // สร้างหมวดหมู่ใหม่
        TextFile::create([
            'text' => $validatedData['text'],
            'file_id' => $file_id,
            'period_id' => $meet->period_id,
            'years_id' => $meet->years_id,
            'cate_id' => $meet->cate_id,
            'meet_id' => $meet->id,
        ]);
        
        return redirect()->route('admin.document');
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

    public function document_period(Request $request)
    {
        $period = TypePeriod::where('active','y')->get();
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'period' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                    
                return redirect()->back()->withErrors($validator)->withInput(); // ส่งกลับไปยังหน้าก่อนหน้าพร้อมกับข้อมูลที่ผู้ใช้ป้อนเพื่อแสดงข้อผิดพลาด
            }

            $period_create = new TypePeriod;
            $period_create->name_type_period = $request->input('period');
            $period_create->save();

            return redirect()->route('admin.document_period')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        }
        return view('admin.page.document.period.index',['period' =>  $period]);
    }

    public function document_year(Request $request,$id)
    {
        $years = TypeYears::with(['period'])
                        ->where('active', 'y')
                        ->get();
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'years' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                    
                return redirect()->back()->withErrors($validator)->withInput(); // ส่งกลับไปยังหน้าก่อนหน้าพร้อมกับข้อมูลที่ผู้ใช้ป้อนเพื่อแสดงข้อผิดพลาด
            }

            $years_create = new TypeYears;
            $years_create->name_type_years = $request->input('years');
            $years_create->period_id = $id;
            $years_create->save();

            return redirect()->route('admin.document_year',['id' => $id])->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        }
        return view('admin.page.document.year.index',['id' =>  $id,'years' => $years]);
    }

    public function document_cate(Request $request, $id)
    {
        // ดึงข้อมูลหมวดหมู่ที่ active
        $cate = TypeCate::with(['years', 'period'])
                        ->where('active', 'y')
                        ->get();

        // ตรวจสอบหากเป็น POST Method
        if ($request->isMethod('post')) {
            // Validate ข้อมูล
            $validatedData = $request->validate([
                'cate' => 'nullable|string',
            ]);

            // ดึงข้อมูลปีที่เกี่ยวข้อง
            $year = TypeYears::findOrFail($id);

            // สร้างหมวดหมู่ใหม่
            TypeCate::create([
                'name_type_cate' => $validatedData['cate'],
                'period_id' => $year->period_id,
                'years_id' => $year->id,
            ]);

            // Redirect กลับพร้อมข้อความสำเร็จ
            return redirect()
                ->route('admin.document_cate', ['id' => $id])
                ->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        }

        // ส่งข้อมูลไปยัง View
        return view('admin.page.document.cate.index', compact('id', 'cate'));
    }

    public function document_meet(Request $request, $id)
    {
        // ดึงข้อมูลหมวดหมู่ที่ active
        $meet = TypeMeet::with(['years', 'period','cate'])
                        ->where('active', 'y')
                        ->get();

        // ตรวจสอบหากเป็น POST Method
        if ($request->isMethod('post')) {
            // Validate ข้อมูล
            $validatedData = $request->validate([
                'meet' => 'nullable|string',
            ]);

            // ดึงข้อมูลปีที่เกี่ยวข้อง
            $cate = TypeCate::findOrFail($id);

            // สร้างหมวดหมู่ใหม่
            TypeMeet::create([
                'name_type_meet' => $validatedData['meet'],
                'period_id' => $cate->period_id,
                'years_id' => $cate->years_id,
                'cate_id' => $cate->id,
            ]);

            // Redirect กลับพร้อมข้อความสำเร็จ
            return redirect()
                ->route('admin.document_meet', ['id' => $id])
                ->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        }

        // ส่งข้อมูลไปยัง View
        return view('admin.page.document.meet.index', compact('id', 'meet'));
    }

    public function document_request(Request $request)
    {
        return view('admin.page.document.request.index');
    }

    public function document_approve(Request $request,$id)
    {
        return view('admin.page.document.request.index');
    }
    public function document_deny(Request $request,$id)
    {
        return view('admin.page.document.request.index');
    }

    public function document_type(Request $request)
    {
        return view('admin.page.document.type.index');
    }
}