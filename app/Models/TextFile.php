<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TextFile extends Model
{
    use HasFactory,Searchable;

    protected $table = 'textfile'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['text', 'file_id', 'period_id', 'years_id', 'cate_id', 'meet_id']; 

    protected static function booted()
    {
        static::creating(function ($cate) {
            $cate->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $cate->update_by = auth()->id() ?? '1'; 
            $cate->active = 'y';
        });
        
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'content' => $this->text,
            'file_id' => $this->file_id,
            'period_id' => $this->period_id,
            'years_id' => $this->years_id,
            'cate_id' => $this->cate_id,
            'meet_id' => $this->meet_id,
            
        ];
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function years()
    {
        return $this->belongsTo(TypeYears::class, 'years_id');
    }

    public function period()
    {
        return $this->belongsTo(TypePeriod::class, 'period_id');
    }

    public function cate()
    {
        return $this->belongsTo(TypeCate::class, 'cate_id');
    }

    public function meet()
    {
        return $this->belongsTo(TypeMeet::class, 'meet_id');
    }

}
