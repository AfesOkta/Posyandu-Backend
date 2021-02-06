<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiPosyandu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lansia_id',false)->nullable();
            $table->unsignedBigInteger('posyandu_id',false)->nullable();
            $table->timestamp('masuk')->nullable();
            $table->timestamp('pulang')->nullable();
            $table->index(['id','lansia_id','posyandu_id'],'idxAbsensi');
            $table->foreign('posyandu_id')->references('id')->on('mst_posyandu');
            $table->foreign('lansia_id')->references('id')->on('lansia_posyandu');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_posyandu');
    }
}
