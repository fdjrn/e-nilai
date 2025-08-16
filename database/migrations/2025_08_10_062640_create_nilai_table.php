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
            $table->integer('nslm_1')->default(0);
            $table->integer('nslm_2')->default(0);
            $table->integer('nslm_3')->default(0);
            $table->integer('nslm_4')->default(0);
            $table->integer('nslm_5')->default(0);
            $table->integer('nslm_6')->default(0);
            $table->integer('nslm_7')->default(0);
            $table->decimal('rata_nslm',5,2)->default(0);
            $table->integer('nsas')->default(0);
            $table->decimal('nr',5,2)->default(0);
            $table->timestamps();

            $table->unique([
                'tahun_akademik_id',
                'semester',
                'kelas_id',
                'mapel_id',
                'siswa_id'
            ], 'nilai_unique');
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
