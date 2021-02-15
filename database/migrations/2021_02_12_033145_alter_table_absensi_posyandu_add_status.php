<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAbsensiPosyanduAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('absensi_posyandu', function (Blueprint $table) {
            $table->smallInteger('status',false,false)->nullable()->default(0)->comment('0 => Status absensi hanya masuk; 1 => Status absensi completed masuk dan pulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
