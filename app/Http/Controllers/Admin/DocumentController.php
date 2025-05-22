<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DocumentApproved;
use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;
use Imagick;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\TextFile;
use App\Models\File;
use App\Models\TypePeriod;
use App\Models\TypeCate;
use App\Models\TypeMeet;
use App\Models\TypeCon;
use App\Models\TypeRule;
use App\Models\Approve;
use App\Models\TypeDoc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{
    public function document(Request $request)
    {
        return view('admin.page.document.index');
    }

    public function getTextData(Request $request)
    {
        $query = TextFile::with([
            'file.period:id,name_type_period', 
            'file.cate:id,name_type_cate', 
            'file.meet:id,name_type_meet', 
            'file.con:id,name_type_con', 
            'file.rule:id,name_type_rule'
        ])
        ->where('textfile.active', 'y')
        ->select('textfile.id','file_id', 'text', 'page_number'); // ระบุฟิลด์ที่ต้องการ

        return DataTables::of($query)
            ->addColumn('period_name', fn($row) => $row->file->period->name_type_period ?? '-')
            ->addColumn('years', fn($row) => $row->file->years ?? '-')
            ->addColumn('cate_name', fn($row) => $row->file->cate->name_type_cate ?? '-')
            ->addColumn('meet_name', fn($row) => $row->file->meet->name_type_meet ?? '-')
            ->addColumn('con_name', fn($row) => $row->file->con->name_type_con ?? '-')
            ->addColumn('rule_name', fn($row) => $row->file->rule->name_type_rule ?? '-')
            ->addColumn('type_name', fn($row) => $row->file->type_name ?? '-')
            ->addColumn('name_file', fn($row) => $row->file->name_file ?? '-')
            ->addColumn('actions', function($row) {
                return '
                    <a class="btn btn-warning" href="'.route('admin.document_edit', ['file_id' => $row->file_id, 'page_number' => $row->page_number ?? 1]).'">
                        <i class="fa-solid fa-pen"></i> หน้าที่ '.$row->page_number.'
                    </a>
                    <a href="'.route('admin.text_del', $row->id).'" class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?\')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function deleteText($id)
    {
        $text = TextFile::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document')->with('success', 'ลบข้อมูลสำเร็จ');
    }

    public function document_file(Request $request)
    {

        return view('admin.page.document.type');
    }

    public function getFileData(Request $request)
    {
        $query = File::where('active', 'y')
        ->select('id','period_id','years','cate_id','meet_id','con_id','rule_id','type_name','name_file','doc_id','date_meet'); // ระบุฟิลด์ที่ต้องการ
        
        return DataTables::of($query)
            ->addColumn('period_name', fn($row) => $row->period_id ?? '-')
            ->addColumn('years', fn($row) => $row->years ?? '-')
            ->addColumn('date_mmet', fn($row) => $row->date_meet ?? '-')
            ->addColumn('cate_name', fn($row) => $row->cate->name_type_cate ?? '-')
            ->addColumn('meet_name', fn($row) => $row->meet->name_type_meet ?? '-')
            ->addColumn('con_name', fn($row) => $row->con->name_type_con ?? '-')
            ->addColumn('rule_name', fn($row) => $row->rule->name_type_rule ?? '-')
            ->addColumn('type_name', fn($row) => $row->type_name ?? '-')
            ->addColumn('date_meet', function($row) {
                if ($row->date_meet) {
                    return \Carbon\Carbon::parse($row->date_meet)->addYears(543)->format('d/m/Y');
                }
                return '-';
            })
            ->addColumn('name_file', fn($row) => $row->name_file ?? '-') // ชื่อไฟล์จริง
            ->addColumn('doc_name', fn($row) => $row->doc_id ?? '-') // ชื่อเอกสารจาก `doc`
            ->addColumn('actions', function($row) {
                return '
                    <a class="btn btn-warning" href="'.route('admin.document_file_edit', ['file_id' => $row->id]).'">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="'.route('admin.file_del', $row->id).'" class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?\')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function document_file_edit(Request $request,$file_id)
    {
        $file = File::findOrfail($file_id);
        $period = TypePeriod::where('active','y')->get();
        $cate = TypeCate::where('active','y')->get();
        $meet = TypeMeet::where('active','y')->get();
        $con = TypeCon::where('active','y')->get();
        $rule = TypeRule::where('active','y')->get();
        $doc = TypeDoc::where('active','y')->get();
        if($request->isMethod('post')){
            $file = File::findOrFail($file_id);
            
            $request->validate([
                'type_name' => 'nullable',
                'period' => 'nullable',
                'year' => 'nullable',
                'meet' => 'nullable',
                'cate' => 'nullable',
                'con' => 'nullable',
                'rule' => 'nullable',
                'doc' => 'nullable',
                'date' => 'nullable|date_format:Y-m-d',
            ]);
            
            $file->type_name = $request->input('type_name');
            $file->period_id = $request->input('period');
            $file->years = $request->input('year');
            $file->meet_id = $request->input('meet');
            $file->cate_id = $request->input('cate');
            $file->con_id = $request->input('con');
            $file->rule_id = $request->input('rule');
            $file->doc_id = $request->input('doc');
            if ($request->filled('date')) {
                try {
                    $thaiDate = $request->input('date'); // เช่น 2568-04-28
                    $carbonDate = \Carbon\Carbon::createFromFormat('Y-m-d', $thaiDate)->subYears(543);
                    $file->date_meet = $carbonDate->format('Y-m-d'); // 2025-04-28
                } catch (\Exception $e) {
                    // ถ้าแปลงผิด ให้เก็บค่าว่าง หรือจัดการ error ตามที่คุณต้องการ
                    $file->date_meet = null;
                }
            } else {
                $file->date_meet = null;
            }
            $file->save();
            
            return redirect()->route('admin.document_file');
        }

        return view('admin.page.document.file_edit',compact('file','period','cate','meet','con','rule','doc'));
    }

    public function deleteFile($id)
    {
        $file = File::findOrfail($id);
        $file->active = 'n';
        $file->save();
        
        return redirect()->route('admin.document_file')->with('success', 'ลบข้อมูลสำเร็จ');
    }

    public function document_import(Request $request)
    {
        $period = TypePeriod::where('active','y')->get();
        $cate = TypeCate::where('active','y')->get();
        $meet = TypeMeet::where('active','y')->get();
        $con = TypeCon::where('active','y')->get();
        $rule = TypeRule::where('active','y')->get();
        $doc = TypeDoc::where('active','y')->get();
        if($request->isMethod('post')){
            $request->validate([
                'type_name' => 'nullable',
                'period' => 'nullable',
                'year' => 'nullable',
                'meet' => 'nullable',
                'cate' => 'nullable',
                'con' => 'nullable',
                'rule' => 'nullable',
                'doc' => 'nullable',
                'date' => 'nullable',
                'scan' => 'required|file|mimes:jpg,jpeg,png,pdf',
            ]);
            // เก็บไฟล์ที่อัปโหลด
            $path = $request->file('scan');
            $imageName = $path->getClientOriginalName();
    
            $file = new File;
            $file->name_file = $imageName;
            $file->create_date = now();
            $file->create_by = '1';
            $file->active = 'y';
            $file->period_id = $request->input('period');
            $file->years = $request->input('year');
            $file->meet_id = $request->input('meet');
            $file->cate_id = $request->input('cate');
            $file->con_id = $request->input('con');
            $file->rule_id = $request->input('rule');
            $file->date_meet = $request->input('date');
            $file->type_name = $request->input('type_name');
            $file->doc_id = $request->input('doc');
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

            $uniqueFolder = public_path('uploads/' . uniqid('user_') . '_' . $file_id);
            if (!file_exists($uniqueFolder)) {
                mkdir($uniqueFolder, 0755, true);
            }
    
            $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    
            
            // ตรวจสอบประเภทไฟล์และประมวลผลข้อความ
            // $text = $this->processDocument($filePath);
            // $images = $this->convertPdfToImages($filePath, $uniqueFolder);
            // foreach ($images as $index => $imagePath) {
            //     $text = $this->processDocument($imagePath);
    
            //     // บันทึกข้อความ OCR ลงในฐานข้อมูล
            //     $this->saveTextToDatabase($file_id, $index + 1, $text); // index + 1 เพื่อให้เริ่มจากหน้า 1
            // }
            // dispatch(fn() => Storage::disk('public')->deleteDirectory($uniqueFolder))->afterResponse();
            // $isPdf = $fileExtension === 'pdf';

            $job = new \App\Jobs\ProcessUploadedDocument($file_id, $filePath, $uniqueFolder);
            dispatch($job)->afterResponse();

            // return view('admin.page.document.file.result', compact('text', 'imageName', 'isPdf','file_id','id'));
            return redirect()->route('admin.document',compact('file_id'));
        }
        return view('admin.page.document.import.index',compact('period','cate','meet','con','rule','doc'));
    }

    public function document_upload(Request $request,$id)
    {
        if($request->isMethod('post')){
            $request->validate([
                'scan' => 'required|file|mimes:jpg,jpeg,png,pdf',
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
    
            $uniqueFolder = public_path('uploads/' . uniqid('user_') . '_' . $file_id);
            if (!file_exists($uniqueFolder)) {
                mkdir($uniqueFolder, 0755, true);
            }
            // ตรวจสอบประเภทไฟล์และประมวลผลข้อความ
            // $text = $this->processDocument($filePath);
            $images = $this->convertPdfToImages($filePath,$uniqueFolder);
            foreach ($images as $index => $imagePath) {
                $text = $this->processDocument($imagePath);
    
                // บันทึกข้อความ OCR ลงในฐานข้อมูล
                $this->saveTextToDatabase($file_id, $index + 1, $text); // index + 1 เพื่อให้เริ่มจากหน้า 1
            }
            $isPdf = $fileExtension === 'pdf';
    
            // return view('admin.page.document.file.result', compact('text', 'imageName', 'isPdf','file_id','id'));
            return redirect()->route('admin.document');
        }    
        return view('admin.page.document.file.create', compact('id'));    
    }
    private function saveTextToDatabase($file_id, $page_number, $text)
    {
        // สร้าง record สำหรับแต่ละหน้า
        $ocrText = new TextFile();
        $ocrText->file_id = $file_id;           // เชื่อมโยงกับไฟล์ที่อัปโหลด
        $ocrText->page_number = $page_number;   // หมายเลขหน้า
        $ocrText->text = $text;         // ข้อความ OCR
        $ocrText->save();                   // บันทึกลงฐานข้อมูล
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
        $cate = TypeCate::where('active','y')->get();
        $meet = TypeMeet::where('active','y')->get();
        $con = TypeCon::where('active','y')->get();
        $rule = TypeRule::where('active','y')->get();
        $doc = TypeDoc::where('active','y')->get();
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'period' => 'nullable|string',
                'meet' => 'nullable|string',
                'cate' => 'nullable|string',
                'con' => 'nullable|string',
                'rule' => 'nullable|string',
                'doc' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                    
                return redirect()->back()->withErrors($validator)->withInput(); // ส่งกลับไปยังหน้าก่อนหน้าพร้อมกับข้อมูลที่ผู้ใช้ป้อนเพื่อแสดงข้อผิดพลาด
            }

            $this->savePeriodData($request);

            return redirect()->route('admin.document_period');
        }

        return view('admin.page.document.period.index',compact('period','cate','meet','con','rule','doc'));
    }
    private function savePeriodData($request)
    {
        // ตรวจสอบและสร้าง TypePeriod
        if ($request->has('period')  && !empty($request->input('period'))) {
            $typePeriod = new TypePeriod;
            $typePeriod->name_type_period = $request->input('period');
            $typePeriod->save();
        }

        // ตรวจสอบและสร้าง TypeCate
        if ($request->has('cate')  && !empty($request->input('cate'))) {
            $typeCate = new TypeCate;
            $typeCate->name_type_cate = $request->input('cate');
            $typeCate->save();
        }

        // ตรวจสอบและสร้าง TypeMeet
        if ($request->has('meet')  && !empty($request->input('meet'))) {
            $typeMeet = new TypeMeet;
            $typeMeet->name_type_meet = $request->input('meet');
            $typeMeet->save();
        }

        // ตรวจสอบและสร้าง TypeCon
        if ($request->has('con')  && !empty($request->input('con'))) {
            $typeCon = new TypeCon;
            $typeCon->name_type_con = $request->input('con');
            $typeCon->save();
        }

        // ตรวจสอบและสร้าง TypeRule
        if ($request->has('rule')  && !empty($request->input('rule'))) {
            $typeRule = new TypeRule;
            $typeRule->name_type_rule = $request->input('rule');
            $typeRule->save();
        }

        // ตรวจสอบและสร้าง TypeDoc
        if ($request->has('doc')  && !empty($request->input('doc'))) {
            $typeDoc = new TypeDoc();
            $typeDoc->name_type_doc = $request->input('doc');
            $typeDoc->save();
        }
    }
    public function deletePeriod($id)
    {
        $text = TypePeriod::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }
    public function deleteMeet($id)
    {
        $text = TypeMeet::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }
    public function deleteCate($id)
    {
        $text = TypeCate::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }
    public function deleteCon($id)
    {
        $text = TypeCon::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }
    public function deleteRule($id)
    {
        $text = TypeRule::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }

    public function deleteDoc($id)
    {
        $text = TypeDoc::findOrfail($id);
        $text->active = 'n';
        $text->save();
        
        return redirect()->route('admin.document_period');
    }

    public function document_edit(Request $request,$file_id, $page_number)
    {
        $file = File::findOrFail($file_id);

        $textfile = TextFile::where('file_id',$file_id)
                    ->where('page_number',$page_number)
                    ->first();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'text' => 'nullable|string',
            ]);

            $textfile->text = $validatedData['text'];
            $textfile->save();

            return redirect()->route('admin.document');
        }

        return view('admin.page.document.edit',compact('textfile','file'));
    }

    public function document_request()
    {
        $approve = Approve::where('active','y')->where('status','waiting')->get();
        return view('admin.page.document.request.index',compact('approve'));
    }

    public function document_approve(Request $request,$id)
    {
            // ตรวจสอบไฟล์ที่อัปโหลด
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,pdf',
            ]);

            // เก็บไฟล์ที่อัปโหลด
            $path = $request->file('file');
            $imageName = $path->getClientOriginalName();

            // บันทึกข้อมูลไฟล์ลงฐานข้อมูล
            $file = Approve::find($id);
            $file->file_name = $imageName;
            $file->status = 'success';
            $file->save();

            // สร้างโฟลเดอร์สำหรับเก็บไฟล์
            $idFolder = public_path('uploads/approved/');
            if (!file_exists($idFolder)) {
                mkdir($idFolder, 755, true);
            }

            // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
            if (!$path->move($idFolder, $imageName)) {
                return response()->json(['error' => 'File could not be moved.'], 500);
            }

            $filePath = $idFolder . $imageName;

            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File does not exist.'], 404);
            }
            //ส่งเมลหลังจบprocess ทุกอย่าง
            Mail::to($file->user->email)->send(new DocumentApproved($file));

            return redirect()->route('admin.document_request');
    }
    public function document_deny(Request $request,$id)
    {
        $request->validate([
            'deny' => 'nullable|string',
        ]);
        // บันทึกข้อมูลไฟล์ลงฐานข้อมูล
        $file = Approve::find($id);
        if($request->input('reason') == 'other')
        {
            $file->not_approve_detail = $request->input('other_reason') ?? 'ไม่สามารถให้ไฟล์ที่ร้องขอได้';
        }else{

            $file->not_approve_detail = $request->input('reason');
        }
        $file->status = 'deny';
        $file->save();
        Mail::to($file->user->email)->send(new DocumentApproved($file));

        return redirect()->route('admin.document_request');
        
    }

    public function document_type(Request $request)
    {
        $doc = TypeDoc::where('active','y')->get();

        return view('admin.page.document.type.index',compact('doc'));
    }

    public function document_type_edit(Request $request,$id)
    {
        $type_doc = File::where('active','y')->where('doc_id',$id)->get();

        return view('admin.page.document.type.index',compact('type_doc'));
    }


    public function document_uploadLargeDocument(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // ตรวจสอบไฟล์ที่อัปโหลด
            $request->validate([
                'scan' => 'required|file|mimes:jpg,jpeg,png,pdf',
            ]);

            // เก็บไฟล์ที่อัปโหลด
            $path = $request->file('scan');
            $imageName = $path->getClientOriginalName();

            // บันทึกข้อมูลไฟล์ลงฐานข้อมูล
            $file = new File;
            $file->name_file = $imageName;
            $file->create_date = now();
            $file->create_by = '1'; // เปลี่ยนเป็น user_id ที่แท้จริง
            $file->active = 'y';
            $file->save();

            $file_id = $file->id;

            // สร้างโฟลเดอร์สำหรับเก็บไฟล์
            $idFolder = public_path('uploads/pdf/');
            if (!file_exists($idFolder)) {
                mkdir($idFolder, 755, true);
            }

            // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
            if (!$path->move($idFolder, $imageName)) {
                return response()->json(['error' => 'File could not be moved.'], 500);
            }

            $filePath = $idFolder . $imageName;

            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File does not exist.'], 404);
            }

            // แปลง PDF เป็นรูปภาพ
            $images = $this->convertPdfToImages($filePath);

            // ประมวลผลข้อความจากแต่ละหน้าของ PDF
            $allText = [];
            foreach ($images as $imagePath) {
                $text = $this->processDocument($imagePath);
                $allText[] = $text;
            }
            $isPdf = strtolower(pathinfo($imageName, PATHINFO_EXTENSION)) === 'pdf';

            return view('admin.page.document.file.result2', compact('allText', 'imageName', 'isPdf', 'file_id', 'id'));
        }

        return view('admin.page.document.file.create', compact('id'));
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

                // ล้างหน่วยความจำทุกหน้า
                $page->clear();
                $page->destroy();
            }

            // เคลียร์ Imagick ทุก Batch
            gc_collect_cycles();
        }

        return $images;
    }
    // private function convertPdfToImages($filePath, $uniqueFolder)
    // {
    //     // สร้างตัวแปร Imagick
    //     $imagick = new Imagick();
    
    //     // กำหนดความละเอียด (DPI) เพื่อให้คุณภาพดี
    //     $imagick->setResolution(300, 300); 

    //     ini_set('memory_limit', '1024M');
    //     // อ่านไฟล์ PDF
    //     $imagick->readImage($filePath. '[0-999]');
    
    //     $images = [];
    
    //     // แปลงแต่ละหน้า PDF เป็นไฟล์ภาพ (เช่น JPG หรือ PNG)
    //     foreach ($imagick as $index => $page) {
    //         // กำหนดรูปแบบเป็น JPG หรือ PNG
    //         $page->setImageFormat('jpg');
            
    //         // บันทึกรูปภาพ
    //         $outputPath = "{$uniqueFolder}/pdf_page_{$index}.jpg";
    //         $page->writeImage($outputPath);
            
    //         // เก็บที่อยู่ของไฟล์ภาพที่แปลงแล้ว
    //         $images[] = $outputPath;
    //     }
    
    //     // ล้างข้อมูลจาก Imagick
    //     $imagick->clear();
    //     $imagick->destroy();
    
    //     return $images; // คืนค่ารายการที่อยู่ของไฟล์รูปภาพทั้งหมด
    // }    

    private function processDocument2($imagePath)
    {
        $projectId = 'summer-sun-442109-m1';
        $location = 'us';
        $processorId = '569840618de6925c';

        $client = new DocumentProcessorServiceClient([
            'credentials' => storage_path('app/document-ai-key.json')
        ]);
    
        $name = $client->processorName($projectId, $location, $processorId);
    
        // อ่านไฟล์รูปภาพและเตรียมข้อมูลสำหรับ Document AI
        $fileData = file_get_contents($imagePath);
    
        $rawDocument = new RawDocument([
            'content' => $fileData,
            'mime_type' => 'image/jpeg' // หรือ 'image/png' ขึ้นอยู่กับรูปแบบที่ใช้
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