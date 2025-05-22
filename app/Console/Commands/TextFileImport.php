<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TextFile;
use Symfony\Component\Console\Helper\ProgressBar;

class TextFileImport extends Command
{
    protected $signature = 'textfile:import';
    protected $description = 'Import TextFile data into Elasticsearch without recreating index.';

    public function handle()
    {
        // ดึงข้อมูลทั้งหมดจาก TextFile model
        $textFiles = TextFile::where('active','y')->get();

        // สร้าง progress bar
        $bar = $this->output->createProgressBar(count($textFiles));
        $bar->start();

        // วนลูปผ่านข้อมูลทุกแถวและส่งไปยัง Elasticsearch
        foreach ($textFiles as $textFile) {
            $textFile->searchable();
            $bar->advance(); // เพิ่มการแสดงความคืบหน้า
        }

        // เสร็จสิ้นการนำเข้า
        $bar->finish();

        $this->info('TextFile documents imported successfully.');
    }
}
