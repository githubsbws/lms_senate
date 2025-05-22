<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $table = 'permissions_group'; 

   protected $fillable = ['key', 'label_th', 'group_name', 'sort_order'];

}
