<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatNomorAntrianTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_nomor_antrian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik');
            $table->string('ruangan');
            $table->string('nomor');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('status')->default('sedang_antri');
            $table->longText('waktu_dilayani')->nullable();
            $table->double('waktu_total_sistem', 8, 2)->nullable();
            $table->longText('riwayat_waktu')->nullable();
            $table->longText('waktu')->nullable();
            $table->enum('prioritas', ['umum', 'usia', 'didahulukan'])->default('umum');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('status_prioritas')->nullable();
            $table->string('ruangan_asal')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_nomor_antrian');
    }
}
