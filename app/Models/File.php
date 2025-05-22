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

    public function period()
    {
        return $this->hasOne(TypePeriod::class, 'id', 'period_id');
    }

    public function cate()
    {
        return $this->hasOne(TypeCate::class, 'id', 'cate_id');
    }

    public function meet()
    {
        return $this->hasOne(TypeMeet::class, 'id', 'meet_id');
    }

    public function con()
    {
        return $this->hasOne(TypeCon::class, 'id', 'con_id');
    }

    public function rule()
    {
        return $this->hasOne(TypeRule::class, 'id', 'rule_id');
    }

    public function doc()
    {
        return $this->hasOne(TypeDoc::class, 'id', 'doc_id');
    }
    public function textfile()
    {
        return $this->hasOne(TextFile::class, 'file_id', 'id');
    }
}
