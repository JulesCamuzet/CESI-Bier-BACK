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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->float('total_cost');
            $table->string('payment_key');
            $table->boolean('is_paid');
            $table->string('status');
            $table->string('adress');
            $table->string('zip_code');
            $table->string('city');
            $table->string('country');
            $table->integer('user_id');
            $table->dateTime('created_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
