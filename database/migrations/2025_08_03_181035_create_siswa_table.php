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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis',15);
            $table->string('nisn',15);
            $table->string('nik',25);
            $table->string('nama',128);
            $table->string('tempat_lahir',128);
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('hobi',128)->nullable();
            $table->string('cita_cita',128)->nullable();
            $table->enum('status_anak',['Kandung','Angkat']);
            $table->integer('jumlah_sdr');
            $table->integer('anak_ke');
            $table->text('alamat')->nullable();
            $table->string('nik_ayah',25)->nullable();
            $table->string('nama_ayah',128)->nullable();
            $table->string('pend_ayah',50)->nullable();
            $table->string('pkr_ayah',50)->nullable();
            $table->string('nik_ibu',25)->nullable();
            $table->string('nama_ibu',128)->nullable();
            $table->string('pend_ibu',50)->nullable();
            $table->string('pkr_ibu',50)->nullable();
            $table->text('alamat_ortu')->nullable();
            $table->date('tgl_masuk');
            $table->date('tgl_keluar')->nullable();
            $table->enum('status',['Active','Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
