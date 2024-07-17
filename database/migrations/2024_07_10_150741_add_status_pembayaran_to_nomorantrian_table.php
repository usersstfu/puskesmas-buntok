<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPembayaranToNomorantrianTable extends Migration
{
    public function up()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('belum lunas');
        });
    }

    public function down()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
}

