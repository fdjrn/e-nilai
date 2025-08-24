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
        Schema::create('rombel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('restrict');
            $table->foreignId('wali_kelas_id')->constrained('wali_kelas')->onDelete('restrict');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('restrict');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('restrict');
            $table->timestamps();

            $table->unique([
                'tahun_akademik_id',
                'wali_kelas_id',
                'siswa_id',
                'kelas_id'
            ],'rombel_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel');
    }
};
