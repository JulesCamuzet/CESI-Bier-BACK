<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNullableFieldsOnUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('profile_picture')->nullable()->change();
            $table->tinyInteger('is_admin')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('profile_picture')->nullable(false)->change();
            $table->tinyInteger('is_admin')->default(null)->change();
        });
    }
}

