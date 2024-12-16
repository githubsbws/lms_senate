<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['password','firstname','lastname','id_card','dob','email','employee_type','lastvisit','position','agency','type_user_id','active']; 

    public $timestamps = false;

}
