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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20)->unique();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat');
            $table->foreignId('agama_id')->constrained('agamas');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->string('nik_ayah', 20)->nullable();
            $table->string('nama_ayah', 100)->nullable();
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->foreignId('pekerjaan_ayah_id')->constrained('pekerjaans')->nullable();
            $table->string('nik_ibu', 20)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->foreignId('pekerjaan_ibu_id')->constrained('pekerjaans')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
