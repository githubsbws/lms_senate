<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMeet extends Model
{
    use HasFactory;

    protected $table = 'type_meet'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_meet', 'active'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($cate) {
            $cate->create_date = now(); // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $cate->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $cate->active = 'y';
        });
    }

    
}
