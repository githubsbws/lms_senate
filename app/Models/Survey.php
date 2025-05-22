<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $primaryKey = 'id';

    protected $fillable = ['sur_status','survey_title','active'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id');
    }

    public function headings()
    {
        return $this->hasMany(QuestionHeading::class);
    }

    protected static function booted()
    {
        static::creating(function ($survey) {
            $survey->active = 'y';
            $survey->sur_status = 'n';
        });
    }
}
