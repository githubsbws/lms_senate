<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePeriod extends Model
{
    use HasFactory;

    protected $table = 'type_period'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_period', 'active']; 

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($period) {
            $period->create_date = now();
            $period->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $period->active = 'y';
        });
    }
}
