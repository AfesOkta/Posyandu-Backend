<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaderPosyandusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kader_posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posyandu_id',false);
            $table->string('kader_kode',6)->nullable();
            $table->string('kader_nik')->nullable();
            $table->string('kader_kk')->nullable();
            $table->string('kader_alamat')->nullable();
            $table->string('kader_telp')->nullable();
            $table->unsignedBigInteger('user_id', false);
            $table->index(['posyandu_id','kader_kode'],'idxkader');
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
        Schema::dropIfExists('kader_posyandu');
    }
}
