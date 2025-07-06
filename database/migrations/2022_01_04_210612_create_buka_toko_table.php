<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukaTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buka_toko', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('cabang_id');
            $table->date('tgl');
            $table->time('buka');
            $table->time('tutup');
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
        Schema::dropIfExists('buka_toko');
    }
}
