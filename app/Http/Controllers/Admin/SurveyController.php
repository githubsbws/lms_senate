<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Survey;
use App\Models\Question;
use App\Models\QuestionHeading;
use App\Models\Choice;


class SurveyController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $survey = Survey::with('questions.choices')->where('active','y')->get();

            return view('admin.page.setting.survey.index',compact('survey'));
        }
        return view('admin.page.auth.login');
    }

    public function survey_create()
    {
        if(Auth::check())
        {

            return view('admin.page.setting.survey.id.index');
        }
        return view('admin.page.auth.login');
    }

    public function saveSurvey(Request $request)
    {
        // สร้าง survey หลัก
        $survey = Survey::create([
            'survey_title' => $request->input('survey_title'),
        ]);

        $headings = $request->input('headings', []);

        foreach ($headings as $headingData) {
            // สร้างหัวข้อคำถาม
            $heading = QuestionHeading::create([
                'heading_text' => $headingData['heading_text'],
                'survey_id' => $survey->id,
            ]);

            // วนลูปคำถามภายใต้หัวข้อ
            if (isset($headingData['questions']) && is_array($headingData['questions'])) {
                foreach ($headingData['questions'] as $questionData) {
                    Question::create([
                        'survey_id' => $survey->id,
                        'question_heading_id' => $heading->id,
                        'question_text' => $questionData['text'],
                        'question_type' => $questionData['type'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.survey')->with('success', 'บันทึกแบบสำรวจสำเร็จ');
    }

    public function survey_edit(Request $request, $id)
    {
        // ดึงแบบสำรวจ
        $survey = Survey::findOrFail($id);

        if ($request->isMethod('post')) {
            // อัปเดตชื่อแบบสำรวจ
            $survey->survey_title = $request->input('survey_title');
            $survey->save();

            $headingsData = $request->input('headings', []);

            foreach ($headingsData as $headingData) {
                // หา heading จาก ID หรือข้ามถ้าไม่มี
                if (!isset($headingData['id'])) continue;

                $heading = QuestionHeading::find($headingData['id']);

                if ($heading) {
                    // อัปเดตหัวข้อคำถาม
                    $heading->heading_text = $headingData['heading_text'];
                    $heading->save();

                    // ตรวจสอบและอัปเดตคำถามในหัวข้อนี้
                    if (isset($headingData['questions']) && is_array($headingData['questions'])) {
                        foreach ($headingData['questions'] as $questionData) {
                            if (!isset($questionData['id'])) continue;

                            $question = Question::find($questionData['id']);
                            if ($question) {
                                $question->question_text = $questionData['text'];
                                $question->question_type = $questionData['type'];
                                $question->save();

                                // อัปเดตคำตอบ (ถ้ามี)
                                if (isset($questionData['choices']) && is_array($questionData['choices'])) {
                                    foreach ($questionData['choices'] as $choiceData) {
                                        if (!isset($choiceData['id'])) continue;

                                        $choice = Choice::find($choiceData['id']);
                                        if ($choice) {
                                            $choice->choice_text = $choiceData['text'];
                                            $choice->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return redirect()->route('admin.survey')->with('success', 'แก้ไขแบบสำรวจสำเร็จ');
        }

        return view('admin.page.setting.survey.id.edit', compact('survey'));
    }

    public function survey_del(Request $request,$id)
    {
        $survey = Survey::findOrFail($id);

        // Update the status
        $survey->active = 'n';
        $survey->save();

        return redirect()->route('admin.survey')->with('success', 'บันทึกแบบสำรวจสำเร็จ');
    }
    public function updateStatus(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'survey_id' => 'required|exists:surveys,id',  // ตรวจสอบว่ามี survey_id ที่ตรงกับในฐานข้อมูล
                'status' => 'required|in:y,n'  // ตรวจสอบค่า status เป็น 'y' หรือ 'n'
            ]);

            // ดึงข้อมูล Survey จากฐานข้อมูล
            $survey = Survey::find($validated['survey_id']);
            if (!$survey) {
                return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลแบบสำรวจ']);
            }

            // อัพเดตสถานะ
            $survey->sur_status = strtolower($validated['status']);  // ใช้ strtolower เพื่อให้เป็นตัวพิมพ์เล็ก

            // บันทึกการเปลี่ยนแปลง
            if ($survey->save()) {
                return response()->json(['success' => true, 'message' => 'สถานะถูกอัพเดตแล้ว']);
            } else {
                return response()->json(['success' => false, 'message' => 'ไม่สามารถบันทึกการเปลี่ยนแปลงได้']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }
}