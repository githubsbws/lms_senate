<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_cate', function (Blueprint $table) {
            $table->id(); // สร้าง primary key
            $table->string('name_type_cate'); // เพิ่มคอลัมน์ string
            $table->integer('period_id'); // เพิ่มคอลัมน์ integer
            $table->integer('years_id'); // เพิ่มคอลัมน์ integer
            $table->integer('create_by'); // เพิ่มคอลัมน์ integer
            $table->integer('update_by'); // เพิ่มคอลัมน์ integer
            $table->string('active'); // เพิ่มคอลัมน์ string
            $table->timestamps(); // เพิ่ม created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_cate');
    }
};
