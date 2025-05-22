<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCon extends Model
{
    use HasFactory;

    protected $table = 'type_con'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_con','active']; 

    protected static function booted()
    {
        static::creating(function ($con) {
            $con->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $con->update_by = auth()->id() ?? '1';
            $con->active = 'y';
        });
    }

    
}
