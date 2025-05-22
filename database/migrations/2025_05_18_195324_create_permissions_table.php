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
        Schema::create('permissions_group', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // เช่น 'admin', 'document_file'
            $table->string('label_th');             // เช่น 'หน้าแรก', 'แก้เอกสาร'
            $table->string('group_name')->nullable(); // เช่น: จัดการเอกสาร
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
