<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $table = 'submenu'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_submenu','active','link']; 

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($rule) {
            $rule->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $rule->create_date = now();
            $rule->active = 'y';
        });
    }

    
}
