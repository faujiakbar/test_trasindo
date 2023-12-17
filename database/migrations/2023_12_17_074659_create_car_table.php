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
        Schema::create('car', function (Blueprint $table) {
            $table->id();
            $table->string('merek', 150)->comment("Merek Mobil");
            $table->string('model', 100)->comment("Model Mobil");
            $table->string('plat_no', 10)->comment("Plat No. Mobil");
            $table->integer('harga_sewa')->default(0)->comment("Harga sewa per hari");
            $table->tinyInteger('status')->default(0)->comment("0: tersedia, 1: sedang disewa");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car');
    }
};
