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
        Schema::create('mengajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->constrained('tahun_akademik')
                ->onDelete('set null');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('restrict');
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('restrict');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('restrict');
            $table->integer('kkm');
            $table->timestamps();

            $table->unique([
                'tahun_akademik_id',
                'guru_id',
                'mapel_id',
                'kelas_id'
            ],'uniq_mengajar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mengajar');
    }
};
