<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlasanPrioritasToNomorantrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->text('alasan_prioritas')->nullable();
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
            $table->dropColumn('alasan_prioritas');
        });
    }
}
