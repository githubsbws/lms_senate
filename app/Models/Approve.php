<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    use HasFactory;

    protected $table = 'approve'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['number', 'type_detail','the_time','the_date','active','file_name','status','not_approve_detail','type_period_id']; 

    public $timestamps = false;

    const CREATED_AT = 'create_date';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function period()
    {
        return $this->belongsTo(TypePeriod::class, 'type_period_id');
    }

    protected static function booted()
    {
        static::creating(function ($approve) {
            $approve->active = 'y';
        });
        
    }
}
