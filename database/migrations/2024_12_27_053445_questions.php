<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id')->nullable(false)->change(); // ห้าม NULL
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->text('question_text'); // ข้อความคำถาม
            $table->enum('question_type', ['single', 'multiple', 'textarea']); // ประเภทคำถาม
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
