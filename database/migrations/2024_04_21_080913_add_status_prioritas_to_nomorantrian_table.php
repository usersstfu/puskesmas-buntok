<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPrioritasToNomorantrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->integer('status_prioritas')->nullable()->default(null);
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
            $table->dropColumn('status_prioritas');
        });
    }
}
