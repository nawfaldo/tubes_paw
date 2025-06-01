<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lomba', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lomba');
            $table->text('deskripsi');
            $table->date('deadline_pendaftaran');
            $table->string('poster')->nullable();
            $table->string('tingkat_lomba');
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lomba');
    }
}; 