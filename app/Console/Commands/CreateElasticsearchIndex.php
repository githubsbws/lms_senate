<?php
// app/Console/Commands/CreateThaiElasticsearchIndex.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Elastic\Elasticsearch\Client;

class CreateElasticsearchIndex extends Command
{
    protected $signature = 'elasticsearch:create-thai-index';
    protected $description = 'Create Elasticsearch index with Thai analyzer and alias';
    

    public function handle(Client $client)
    {
        // สร้างชื่อ index ใหม่ตาม timestamp
        $timestamp = now()->format('Ymd_His');
        $indexName = "textfile_{$timestamp}";
        $aliasName = 'textfile';
        $synonymFile = "/etc/elasticsearch/synonym/synonym.txt";

        // สร้าง index ใหม่
        $client->indices()->create([
            'index' => $indexName,
            'body' => [
                'settings' => [
                    'analysis' => [
                        'tokenizer' => [
                            'thai' => [
                                'type' => 'thai'
                            ]
                        ],
                        'filter' => [
                            'synonym_filter' => [
                                'type' => 'synonym_graph',
                                'synonyms_path' => $synonymFile // ใช้ไฟล์ synonym.txt ที่เก็บไว้ในโฟลเดอร์ `config` หรือ `storage`
                            ]
                        ],
                        'analyzer' => [
                            'thai_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'thai',
                                'filter' => ['lowercase', 'stop', 'synonym_filter'] // เพิ่ม synonym filter
                            ]
                        ]
                    ],
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    'properties' => [
                        'text' => [
                            'type' => 'text',
                            'analyzer' => 'thai_analyzer',
                            'term_vector' => 'yes', // new uupdate
                            'fields' => [
                                'keyword' => ['type' => 'keyword'],
                                'standard' => ['type' => 'text', 'analyzer' => 'standard']
                            ]
                        ],
                        'file_id' => ['type' => 'keyword'],
                        'page' => ['type' => 'keyword'],
                        'file' => ['type' => 'keyword'],
                        'name_file' => ['type' => 'keyword'],
                        'period' => ['type' => 'keyword'],
                        'cate_id' => ['type' => 'keyword'],
                        'cate' => ['type' => 'keyword'],
                        'meet_id' => ['type' => 'keyword'],
                        'meet' => ['type' => 'keyword'],
                        'year' => ['type' => 'keyword'],
                        'date_meet' => ['type' => 'keyword'],
                        'active' => ['type' => 'keyword']
                    ]
                ]
            ]
        ]);

        $this->info("Created new index: {$indexName}");

        // ตั้ง alias ให้ชี้ไปยัง index ใหม่
        $client->indices()->updateAliases([
            'body' => [
                'actions' => [
                    [
                        'add' => [
                            'index' => $indexName,
                            'alias' => $aliasName,
                        ]
                    ]
                ]
            ]
        ]);

        $this->info("Alias '{$aliasName}' now points to '{$indexName}'");
    }
}