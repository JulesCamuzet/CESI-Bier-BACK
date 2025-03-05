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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title');
            $table->text('content');
            $table->integer('rate');
            $table->integer('user_id');
            $table->integer('bier_id');
            $table->dateTime('created_at');
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bier_id')->references('id')->on('biers')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
