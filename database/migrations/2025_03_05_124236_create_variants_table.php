<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->integer('stock');
            $table->string('picture')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');

            $table->unsignedBigInteger('product_id')->nullable();

            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
