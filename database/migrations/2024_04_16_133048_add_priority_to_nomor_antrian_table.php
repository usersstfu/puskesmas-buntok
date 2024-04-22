<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToNomorAntrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomorantrian', function (Blueprint $table) {
            $table->enum('prioritas', ['umum', 'usia'])->default('umum')->after('status');
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
            $table->dropColumn('prioritas');
        });
    }
}
