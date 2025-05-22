<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRule extends Model
{
    use HasFactory;

    protected $table = 'type_rule'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_type_rule','active']; 


    protected static function booted()
    {
        static::creating(function ($rule) {
            $rule->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $rule->update_by = auth()->id() ?? '1';
            $rule->active = 'y';
        });
    }

    
}
