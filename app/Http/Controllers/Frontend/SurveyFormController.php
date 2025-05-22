<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Survey;
use App\Models\Question;
use App\Models\ResponseSurvey;
use App\Models\Approve;


class SurveyFormController extends Controller
{
    public function survey_form($type)
    {   
        if($type == 1){
            $survey = Survey::with('questions')->where('active','y')->where('id',13)->first();
        }elseif($type == 2){
            $survey = Survey::with('questions')->where('active','y')->where('id',14)->first();
        }elseif($type == 3){
            $survey = Survey::with('questions')->where('active','y')->where('id',16)->first();
        }
        // $survey = Survey::with('questions')->where('active','y')->first();

        if(!$survey){
            return redirect()->route('form.status')->with('message', 'ขณะนี้แบบประเมินพึงพอใจยังไม่เปิดให้ใช้งาน');
        }
        $approve = Approve::where('user_id', Auth::user()->id)
        ->where('active', 'y')
        ->latest()
        ->first();

        $surveyResponses = ResponseSurvey::where('survey_id', $survey->id)
                            ->where('user_id', Auth::user()->id)
                            ->where('approve_id', $approve->id)
                            ->exists();
        
        if ($surveyResponses) {
        return redirect()->route('form.status')->with('message', 'คุณได้ทำแบบสอบถามสำหรับคำร้องขอนี้แล้ว');
        }

        return view('page.form_meet.survey_form',compact('survey'));
    }

    public function submitSurvey(Request $request, $survey_id)
    {
        $survey = Survey::findOrFail($survey_id);
        $user_id = Auth::id();

        $approve = Approve::where('user_id', $user_id)
                    ->where('active', 'y')
                    ->latest()
                    ->first();

        if (!$approve) {
            return redirect()->back()->with('error', 'ไม่พบคำร้องขอที่เกี่ยวข้อง');
        }

        $answers = $request->input('answer', []);

        foreach ($answers as $question_id => $answer) {
            $question = Question::find($question_id);
            if (!$question) continue;

            if (is_array($answer)) {
                // Multiple choice (Likert scale: array of 1–5)
                foreach ($answer as $scale) {
                    if (in_array($scale, [1, 2, 3, 4, 5])) {
                        ResponseSurvey::create([
                            'survey_id'   => $survey_id,
                            'question_id' => $question_id,
                            'scale_value' => $scale,
                            'user_id'     => $user_id,
                            'approve_id'  => $approve->id,
                        ]);
                    }
                }
            } elseif (is_numeric($answer) && in_array($answer, [1, 2, 3, 4, 5])) {
                // Single choice (Likert scale)
                ResponseSurvey::create([
                    'survey_id'   => $survey_id,
                    'question_id' => $question_id,
                    'scale_value' => $answer,
                    'user_id'     => $user_id,
                    'approve_id'  => $approve->id,
                ]);
            } elseif (is_string($answer) && !empty(trim($answer))) {
                // Textarea answer
                ResponseSurvey::create([
                    'survey_id'   => $survey_id,
                    'question_id' => $question_id,
                    'text_answer' => $answer,
                    'user_id'     => $user_id,
                    'approve_id'  => $approve->id,
                ]);
            }
        }

        return redirect()->route('form.status')->with('message', 'บันทึกข้อมูลสำเร็จ');
    }
}
