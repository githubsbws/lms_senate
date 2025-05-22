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
            // ลบ index ที่ระบุ
            if ($client->indices()->exists(['index' => $index])) {
                $client->indices()->delete(['index' => $index]);
                $this->info("Index '{$index}' deleted.");
            } else {
                $this->error("Index '{$index}' does not exist.");
            }
        } else {
            // ลบทุก index ที่ขึ้นต้นด้วย textfile_
            $indices = $client->cat()->indices(['format' => 'json']);
            $deleted = 0;

            foreach ($indices as $idx) {
                if (str_starts_with($idx['index'], 'textfile_')) {
                    $client->indices()->delete(['index' => $idx['index']]);
                    $this->info("Deleted index: {$idx['index']}");
                    $deleted++;
                }
            }

            if ($deleted === 0) {
                $this->info("No 'textfile_' indices found to delete.");
            }
        }
    }
}
