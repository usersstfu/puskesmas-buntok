<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRuanganAsalToNomorantrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->string('ruangan_asal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->dropColumn('ruangan_asal');
        });
    }
}
