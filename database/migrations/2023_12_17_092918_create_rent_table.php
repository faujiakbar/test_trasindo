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
        Schema::create('rent', function (Blueprint $table) {
            $table->id();
            $table->integer("id_car")->comment("Get Id from tabel car");
            $table->date("rent_start")->comment("Tanggal mulai meminjam");
            $table->date("rent_end")->comment("Tanggal akhir meminjam");
            $table->integer("id_user")->comment("Peminjam");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent');
    }
};
