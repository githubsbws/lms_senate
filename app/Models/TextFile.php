<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use \Elastic\Elasticsearch\Client;

class TextFile extends Model
{
    use HasFactory,Searchable; //เพิ่มภายหลังกันerror  

    // use Searchable;
    // use HasFactory; 

    protected $table = 'textfile'; 

    protected $primaryKey = 'id';
    
    protected $fillable = ['text','page_number','file_id', 'active']; 

    public function searchableUsing()
    {
        return new \Matchish\ScoutElasticSearch\Engines\ElasticSearchEngine(app(Client::class));
    }

    public function searchableAs()
    {
        return 'textfile'; // ชื่อ index
    }

    protected static function booted()
    {
        static::creating(function ($cate) {
            $cate->create_by = auth()->id() ?? '1'; // ใช้ User ID ที่ล็อกอิน ถ้าไม่มีก็ใส่ 1
            $cate->update_by = auth()->id() ?? '1'; 
            $cate->active = 'y';
        });
        
    }

    public function toSearchableArray()
    {
        return [
            'text' => $this->text,
            'file_id' => $this->file_id,
            'page' => (string) $this->page_number,
            'file' => $this->file?->type_name,
            'name_file' => $this->file?->name_file,
            'period' => $this->file?->period?->name_type_period,
            'cate_id' => $this->file?->cate_id,
            'cate' => $this->file?->cate?->name_type_cate,
            'meet_id' => $this->file?->meet_id,
            'meet' => $this->file?->meet?->name_type_meet,
            'year' => $this->file?->years,
            'date_meet' =>$this->file?->date_meet,
            'active' => $this->active,
        ];
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
    
    // public function indexConfigurator()
    // {
    //     return new class {
    //         public function settings()
    //         {
    //             return [
    //                 'analysis' => [
    //                     'analyzer' => [
    //                         'thai_analyzer' => [
    //                             'type' => 'custom',
    //                             'tokenizer' => 'thai',
    //                             'filter' => ['lowercase', 'stop']
    //                         ]
    //                     ]
    //                 ]
    //             ];
    //         }
    //     };
    // }

    // // เพิ่มเมธอดนี้เพื่อกำหนด mapping
    // public function mappingProperties()
    // {
    //     return [
    //         'text' => [
    //             'type' => 'text',
    //             'analyzer' => 'thai_analyzer',
    //             'fields' => [
    //                 'keyword' => [
    //                     'type' => 'keyword'
    //                 ],
    //                 'standard' => [
    //                     'type' => 'text',
    //                     'analyzer' => 'standard'
    //                 ]
    //             ]
    //         ],
    //         'file_id' => ['type' => 'keyword'],
    //         'page' => ['type' => 'keyword'],
    //         'file' => ['type' => 'keyword'],
    //         'name_file' => ['type' => 'keyword'],
    //         'period' => ['type' => 'keyword'],
    //         'cate_id' => ['type' => 'keyword'],
    //         'cate' => ['type' => 'keyword'],
    //         'meet_id' => ['type' => 'keyword'],
    //         'meet' => ['type' => 'keyword'],
    //         'year' => ['type' => 'keyword'],
    //         'date_meet' => ['type' => 'keyword'],
    //         'active' => ['type' => 'keyword']
    //     ];
    // }

}
