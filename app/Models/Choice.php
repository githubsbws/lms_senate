<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $table = 'choices'; 

    protected $fillable = ['question_id', 'choice_text'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
