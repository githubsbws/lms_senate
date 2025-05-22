<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions'; 

    protected $fillable = ['survey_id', 'question_text', 'question_type','stauts','question_heading_id'];


    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function heading()
    {
        return $this->belongsTo(QuestionHeading::class, 'question_heading_id');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    protected static function booted()
    {
        static::creating(function ($questions) {
            $questions->status = 'y'; 
            $questions->active = 'y';
        });
        
    }
}
