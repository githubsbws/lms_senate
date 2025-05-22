<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDoc extends Model
{
    use HasFactory;

    protected $table = 'type_doc'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_doc','active']; 


    protected static function booted()
    {
        static::creating(function ($doc) {
            $doc->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $doc->update_by = auth()->id() ?? '1';
            $doc->active = 'y';
            $doc->status = 'y';
        });
    }

}
