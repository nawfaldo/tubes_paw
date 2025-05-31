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
        Schema::table('pendaftaran_lomba', function (Blueprint $table) {
            $table->string('jurusan')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('no_telp')->nullable();
            for ($i = 1; $i <= 5; $i++) {
                $table->string("anggota{$i}_nama")->nullable();
                $table->string("anggota{$i}_nim")->nullable();
                $table->string("anggota{$i}_jurusan")->nullable();
                $table->string("anggota{$i}_fakultas")->nullable();
                $table->string("anggota{$i}_no_telp")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_lomba', function (Blueprint $table) {
            $table->dropColumn('jurusan');
            $table->dropColumn('fakultas');
            $table->dropColumn('no_telp');
            for ($i = 1; $i <= 5; $i++) {
                $table->dropColumn(["anggota{$i}_nama", "anggota{$i}_nim", "anggota{$i}_jurusan", "anggota{$i}_fakultas", "anggota{$i}_no_telp"]);
            }
        });
    }
};
