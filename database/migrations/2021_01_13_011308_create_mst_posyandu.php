<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPosyandu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('posyandu_kode',6)->nullable();
            $table->string('posyandu_nama')->nullable();
            $table->unique('posyandu_kode','IdxUPosyandu');
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
        Schema::dropIfExists('mst_posyandu');
    }
}
