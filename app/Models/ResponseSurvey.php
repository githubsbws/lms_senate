<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseSurvey extends Model
{
    use HasFactory;

    protected $table = 'survey_responses'; // กำหนดชื่อตาราง
    protected $fillable = [
        'survey_id',
        'question_id',
        'choice_id',
        'text_answer',
        'scale_value',
        'user_id',
        'approve_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approve()
    {
        return $this->belongsTo(Approve::class);
    }
}
