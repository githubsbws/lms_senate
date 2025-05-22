<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TypeYears;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\TypePeriod;
use App\Models\Approve;
use App\Models\ResponseSurvey;

class FormController extends Controller
{
    public function form_meet()
    { 
        $period = TypePeriod::where('active','y')->get();

        $app = Approve::where('active', 'y')
                ->where('user_id', Auth::user()->id)
                ->where('status', 'waiting')
                ->latest()
                ->first(); // ใช้ first() แทน get() เพื่อดึงเพียงคำขอแรกที่เจอ

        if($app){
            return redirect()->route('form.status');
        }

        return view('page.form_meet.form_meet',compact('period'));
    }

    public function form_submit(Request $request)
    { 
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'meeting_type' => 'required|in:report_committee,meeting_report,meeting_note',
                'title' => 'required|string|max:255',
                'priority' => 'nullable',
                'meet' => 'nullable',
                'period' => 'nullable',
                'date' => 'nullable',
                'text' => 'nullable',
                'detail' => 'required',
            ]);

            if ($validator->fails()) {
                // session()->put('error', 'กรุณาใส่ข้อมูล');
                return redirect()->back()->withErrors($validator)->withInput(); // ส่งกลับไปยังหน้าก่อนหน้าพร้อมกับข้อมูลที่ผู้ใช้ป้อนเพื่อแสดงข้อผิดพลาด
            }

            $detail = $request->input('detail');
            if ($detail == 'other') {
                // ใช้ค่าในฟิลด์ 'text' สำหรับ 'other'
                $text = $request->input('text');
            } else {
                // กำหนดค่าตามที่เลือกใน 'detail'
                $text = $detail;
            }

            switch ($request->input('meeting_type')) {
                case 'report_committee':
                    // ดึงปีจากวันที่ที่ส่งมา
                    $currentDate = now();
                    $yearChristian = $currentDate->year;
                    
                    $yearBuddhist = $yearChristian + 543;

                    // นับจำนวนคำขอที่มีอยู่แล้วในปีนั้น
                    $count = Approve::where('user_id', Auth::user()->id)
                                    ->whereYear('create_date', $yearChristian) // ตรวจสอบปี ค.ศ.
                                    ->count() + 1; // นับจำนวนแล้วเพิ่ม 1

                    $requestNumber = $count . '/' . $yearBuddhist;

                    $req = new Approve;
                    $req->number = $requestNumber;
                    $req->type_detail = $request->input('title');
                    $req->priority = $request->input('priority');
                    $req->the_time = $request->input('meet');
                    $req->type_period_id = $request->input('period');
                    $req->the_date = $currentDate;
                    $req->detail = $text;
                    $req->status = 'waiting';
                    $req->type_req = $request->input('meeting_type');
                    $req->user_id = Auth::user()->id;
                    $req->create_date = $currentDate;
                    $req->save();

                    $message = "Processing: Report Committee";
                    break;
    
                case 'meeting_report':
                   // ดึงปีจากวันที่ที่ส่งมา
                   $currentDate = now();

                   $yearChristian = $currentDate->year;

                   $yearBuddhist = $yearChristian + 543;

                   // นับจำนวนคำขอที่มีอยู่แล้วในปีนั้น
                   $count = Approve::where('user_id', Auth::user()->id)
                                   ->whereYear('create_date', $yearChristian) // ตรวจสอบปี ค.ศ.
                                   ->count() + 1; // นับจำนวนแล้วเพิ่ม 1

                   $requestNumber = $count . '/' . $yearBuddhist;

                   $req = new Approve;
                   $req->number = $requestNumber;
                   $req->type_detail = $request->input('title');
                   $req->the_time = $request->input('meet');
                   $req->type_period_id = $request->input('period');
                   $req->the_date = $request->input('date');
                   $req->detail = $text;
                   $req->status = 'waiting';
                   $req->type_req = $request->input('meeting_report');
                   $req->user_id = Auth::user()->id;
                   $req->create_date = $currentDate;
                   $req->save();

                    $message = "Processing: Meeting Report";
                    break;
    
                case 'meeting_note':
                   // ดึงปีจากวันที่ที่ส่งมา
                   $currentDate = now();

                   $yearChristian = $currentDate->year;

                   $yearBuddhist = $yearChristian + 543;

                   // นับจำนวนคำขอที่มีอยู่แล้วในปีนั้น
                   $count = Approve::where('user_id', Auth::user()->id)
                                   ->whereYear('create_date', $yearChristian) // ตรวจสอบปี ค.ศ.
                                   ->count() + 1; // นับจำนวนแล้วเพิ่ม 1

                   $requestNumber = $count . '/' . $yearBuddhist;

                   $req = new Approve;
                   $req->number = $requestNumber;
                   $req->type_detail = $request->input('title');
                   $req->the_time = $request->input('meet');
                   $req->type_period_id = $request->input('period');
                   $req->the_date = $currentDate;
                   $req->detail = $text;
                   $req->status = 'waiting';
                   $req->type_req = $request->input('meeting_note');
                   $req->user_id = Auth::user()->id;
                   $req->create_date = $currentDate;
                   $req->save();
                   
                    $message = "Processing: Meeting Note";
                    break;
    
                case 'other':
                    // ดึงปีจากวันที่ที่ส่งมา
                   $currentDate = now();

                    $yearChristian = $currentDate->year;

                    $yearBuddhist = $yearChristian + 543;

                    // นับจำนวนคำขอที่มีอยู่แล้วในปีนั้น
                    $count = Approve::where('user_id', Auth::user()->id)
                                    ->whereYear('create_date', $yearChristian) // ตรวจสอบปี ค.ศ.
                                    ->count() + 1; // นับจำนวนแล้วเพิ่ม 1

                    $requestNumber = $count . '/' . $yearBuddhist;

                   $req = new Approve;
                   $req->number = $requestNumber;
                   $req->type_detail = $request->input('title');
                   $req->the_time = $request->input('meet');
                   $req->type_period_id = $request->input('period');
                   $req->the_date = $currentDate;
                   $req->detail = $text;
                   $req->status = 'waiting';
                   $req->type_req = $request->input('other');
                   $req->user_id = Auth::user()->id;
                   $req->create_date = $currentDate;
                   $req->save();
                   
                    $message = "Processing: Other Type";
                    break;
    
                default:
                    $message = "Invalid Type";
                    break;
            }

            return redirect()->route('form.status')->with('message', $message);
        }

        return redirect()->route('form.meet');
    }

    public function form_status()
    { 
        $approve = Approve::where('active','y')->where('user_id',Auth::user()->id)->get();

        $approves = Approve::where('user_id', Auth::user()->id)
            ->where('active', 'y')
            ->latest()
            ->first();
        $type_req = null;
        if ($approves) {
            if ($approves->type_req == 'report_committee') {
                $type_req = 1;
            } elseif ($approves->type_req == 'meeting_report') {
                $type_req = 2;
            } elseif ($approves->type_req == 'meeting_note') {
                $type_req = 3;
            }
        }

        $canDownload = false;
        $hasSubmittedSurvey = false;
        if ($approves) {
            if ($approves->status === 'success') {
                $hasSubmittedSurvey = ResponseSurvey::where('user_id', Auth::user()->id)
                    ->where('approve_id', $approves->id)
                    ->exists();

                if ($approves->status === 'success' && $hasSubmittedSurvey) {
                    $canDownload = true;
                }
            }
        }
        // dd(Auth::user());
        return view('page.form_meet.status_main', compact('approve', 'approves', 'canDownload', 'hasSubmittedSurvey','type_req'));
    }
}
