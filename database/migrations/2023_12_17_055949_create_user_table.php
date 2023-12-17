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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama',255)->comment('full nama pengguna');
            $table->string('no_hp',50)->comment('no hp pengguna');
            $table->string('no_sim',50)->comment('no sim pengguna');
            $table->string('alamat',512)->comment('no sim pengguna');
            $table->string('hash_pwd',512)->comment('hash password pengguna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
