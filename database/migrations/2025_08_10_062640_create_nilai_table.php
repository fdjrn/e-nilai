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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('restrict');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('restrict');
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('restrict');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('restrict');
            $table->integer('nilai_tp1');
            $table->integer('nilai_tp2');
            $table->integer('nilai_tp3');
            $table->integer('nilai_tp4');
            $table->integer('nilai_tp5');
            $table->integer('nilai_tp6');
            $table->integer('nilai_tp7');
            $table->integer('rata_tp');
            $table->integer('nilai_uh1');
            $table->integer('nilai_uh2');
            $table->integer('nilai_uh3');
            $table->integer('nilai_uh4');
            $table->integer('nilai_uh5');
            $table->integer('nilai_uh6');
            $table->integer('nilai_uh7');
            $table->integer('rata_uh');
            $table->integer('nilai_pts');
            $table->integer('nilai_uas');
            $table->integer('nilai_akhir');
            $table->string('nilai_huruf');
            $table->string('deskripsi');
            $table->timestamps();

            $table->unique([
                'tahun_akademik_id',
                'semester',
                'kelas_id',
                'mapel_id',
                'siswa_id'
            ], 'rombel_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
