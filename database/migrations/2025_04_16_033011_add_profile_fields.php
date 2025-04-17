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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable(); //a path or filename (text), not an actual image
            $table->string('phone_no')->nullable(); //may contain symbols or start with 0, and not used for math
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nickname', 'avatar', 'phone_no', 'city']);
        });
    }
};  // returning an instance of an anonymous class -the entire expression is a full statement