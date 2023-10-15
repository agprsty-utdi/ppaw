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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_jabatan_id');
            $table->string('nama');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->char('janis_kel');
            $table->char('agama');
            $table->string('telepon');
            $table->string('file_foto');
            $table->string('email')->unique();
            $table->timestamps();

            $table->foreign('mst_jabatan_id')->references('id')->on('mst_jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
