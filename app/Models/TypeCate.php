<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCate extends Model
{
    use HasFactory;

    protected $table = 'type_cate'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_cate', 'active'];

    protected static function booted()
    {
        static::creating(function ($cate) {
            $cate->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $cate->update_by = auth()->id() ?? '1'; 
            $cate->active = 'y';
        });
    }

    
}
