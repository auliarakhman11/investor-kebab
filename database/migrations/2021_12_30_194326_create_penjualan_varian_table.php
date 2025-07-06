<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanVarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_varian', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('penjualan_id');
            $table->string('no_invoice',100);
            $table->unsignedSmallInteger('varian_id');
            $table->unsignedSmallInteger('qty');
            $table->double('harga');
            $table->date('tgl');
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
        Schema::dropIfExists('penjualan_varian');
    }
}
