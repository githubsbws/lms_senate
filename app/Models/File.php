<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'file'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['name_file', 'active']; 

    public $timestamps = false;

}
