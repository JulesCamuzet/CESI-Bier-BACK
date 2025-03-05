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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->float('price');
            $table->integer('stock');
            $table->string('picture')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('bier_id')->nullable();
            $table->dateTime('created_at');
    
            $table->foreign('bier_id')->references('id')->on('biers')->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
