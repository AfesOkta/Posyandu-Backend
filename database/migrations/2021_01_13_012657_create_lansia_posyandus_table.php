<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLansiaPosyandusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lansia_posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posyandu_id',false);
            $table->string('lansia_kode',6)->nullable();
            $table->string('lansia_nik')->nullable();
            $table->string('lansia_kk')->nullable();
            $table->string('lansia_alamat')->nullable();
            $table->string('lansia_telp')->nullable();
            $table->unsignedBigInteger('user_id', false);
            $table->index(['posyandu_id','lansia_kode'],'idxkader');
            $table->foreign('posyandu_id')->references('id')->on('mst_posyandu');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('lansia_posyandus');
    }
}
