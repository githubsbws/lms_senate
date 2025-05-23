<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class DeleteElasticsearchIndex extends Command
{
    protected $signature = 'elasticsearch:delete-index {index?}';
    protected $description = 'Delete a specific Elasticsearch index or all indices starting with "textfile_"';

    public function handle(Client $client)
    {
        $index = $this->argument('index');

        if ($index) {
            // ลบ index ที่ระบุ พร้อมลบ alias ถ้ามี
            if ($client->indices()->exists(['index' => $index])) {
                // ลบ alias ที่ชี้ index นี้ก่อน (ถ้ามี)
                
                $aliases = $client->indices()->getAlias(['index' => $index]);
                if (!empty($aliases)) {
                    $actions = [];
                    foreach ($aliases[$index]['aliases'] as $aliasName => $aliasData) {
                        $actions[] = ['remove' => ['index' => $index, 'alias' => $aliasName]];
                    }
                    if (!empty($actions)) {
                        $client->indices()->updateAliases(['body' => ['actions' => $actions]]);
                        $this->info("Removed alias(es) from index '{$index}'");
                    }
                }

                // ลบ index
                $client->indices()->delete(['index' => $index]);
                $this->info("Index '{$index}' deleted.");
            } else {
                $this->error("Index '{$index}' does not exist.");
            }
        } else {
            // ลบทุก index ที่ขึ้นต้นด้วย textfile_
            $indices = json_decode($client->cat()->indices(['format' => 'json'])->getBody()->getContents(), true);
            $deleted = 0;
            
            foreach ($indices as $idx) {
                $indexName = trim($idx['index']);
                if (str_starts_with($indexName, 'textfile_')) {
                    // ลบ alias ที่ชี้ index นี้ก่อน (ถ้ามี)
                    try {
                        $aliases = $client->indices()->getAlias(['index' => $indexName]);
                        if (!empty($aliases)) {
                            $actions = [];
                            foreach ($aliases[$indexName]['aliases'] as $aliasName => $aliasData) {
                                $actions[] = ['remove' => ['index' => $indexName, 'alias' => $aliasName]];
                            }
                            if (!empty($actions)) {
                                $client->indices()->updateAliases(['body' => ['actions' => $actions]]);
                                $this->info("Removed alias(es) from index '{$indexName}'");
                            }
                        }
                    } catch (\Exception $e) {
                        // ไม่มี alias ก็ข้ามได้
                    }

                    // ลบ index
                    $client->indices()->delete(['index' => $indexName]);
                    $this->info("Deleted index: {$indexName}");
                    $deleted++;
                }
            }
            if ($deleted === 0) {
                $this->info("No 'textfile_' indices found to delete.");
            }
        }
    }
}
