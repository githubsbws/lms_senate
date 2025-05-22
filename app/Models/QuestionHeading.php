<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionHeading extends Model
{
    use HasFactory;

    protected $table = 'question_headings'; 

    protected $fillable = ['heading_text','survey_id'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_heading_id')->where('active', 'y');
    }
}
