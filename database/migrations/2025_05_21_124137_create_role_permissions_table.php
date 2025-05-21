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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id('permission_id');
            //when the user_roles record is deleted, all role_permissions rows with that same role_id automatically deleted
            $table->foreignId('role_id')->constrained('user_roles', 'role_id')->onDelete('cascade');
            $table->enum('description', ['create', 'retrieve', 'update', 'delete']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
