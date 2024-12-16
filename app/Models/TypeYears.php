<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeYears extends Model
{
    use HasFactory;

    protected $table = 'type_years'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_years', 'active']; 


    protected static function booted()
    {
        static::creating(function ($years) {
            $years->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $years->update_by = auth()->id() ?? '1'; 
            $years->active = 'y';
        });
    }

    public function period()
    {
        return $this->belongsTo(TypePeriod::class, 'period_id');
    }
}
