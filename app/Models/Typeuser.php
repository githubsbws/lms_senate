<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeuser extends Model
{
    use HasFactory;

    protected $table = 'type_user';

    protected $primaryKey = 'id';

    protected $fillable = ['name','active'];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($type) {
            $type->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $type->active = 'y';
        });
    }
}
