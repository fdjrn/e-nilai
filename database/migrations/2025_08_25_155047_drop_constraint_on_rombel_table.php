<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rombel', function (Blueprint $table) {
            // 1. Drop semua FK yang terlibat di unique lama
            $table->dropForeign(['tahun_akademik_id']);
            $table->dropForeign(['wali_kelas_id']);
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['siswa_id']);

            // 2. Drop unique lama
            $table->dropUnique('rombel_unique');

            // 3. Tambahkan kembali FK
            $table->foreign('tahun_akademik_id')
                ->references('id')
                ->on('tahun_akademik')
                ->restrictOnDelete();

            $table->foreign('wali_kelas_id')
                ->references('id')
                ->on('wali_kelas')
                ->restrictOnDelete();

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->restrictOnDelete();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->restrictOnDelete();

            // 4. Tambahkan unique baru (tanpa wali_kelas_id)
            $table->unique(
                ['tahun_akademik_id', 'siswa_id'],
                'rombel_unique_siswa'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rombel', function (Blueprint $table) {
            // 1. Drop FK lagi supaya bisa rollback unique
            $table->dropForeign(['tahun_akademik_id']);
            $table->dropForeign(['wali_kelas_id']);
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['siswa_id']);

            // 2. Drop unique baru
            $table->dropUnique('rombel_unique_siswa');

            // 3. Tambahkan kembali FK
            $table->foreign('tahun_akademik_id')
                ->references('id')
                ->on('tahun_akademik')
                ->restrictOnDelete();

            $table->foreign('wali_kelas_id')
                ->references('id')
                ->on('wali_kelas')
                ->restrictOnDelete();

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->restrictOnDelete();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->restrictOnDelete();

            // 4. Tambahkan kembali unique lama
            $table->unique(
                ['tahun_akademik_id', 'wali_kelas_id', 'siswa_id', 'kelas_id'],
                'rombel_unique'
            );
        });
    }
};
