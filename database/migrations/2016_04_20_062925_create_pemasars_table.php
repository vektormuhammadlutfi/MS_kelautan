<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemasarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_pemasar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('kode_kegiatan',50);
            $table->string('nomor_direktori')->nullable();
            $table->string('unit_pemasar',50);
            $table->string('pemilik_pemasar',50);
            $table->string('alamat_pemasar',50);
            $table->string('erte',50);
            $table->string('tlp',50);
            $table->string('pos',50);
            $table->enum('tipe', ['Pengumpul','Pedagang','Pengecer']);
            $table->date('tahun_mulai');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pemasar');
    }
}
