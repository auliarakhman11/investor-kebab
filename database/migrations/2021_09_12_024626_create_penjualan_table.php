<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('no_invoice',20);
            $table->unsignedInteger('costumer_id');
            $table->unsignedInteger('produk_id');
            $table->unsignedSmallInteger('qty');
            $table->unsignedFloat('harga');
            $table->unsignedFloat('diskon');
            $table->unsignedFloat('total');
            $table->unsignedTinyInteger('void');
            $table->unsignedSmallInteger('admin');
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
        Schema::dropIfExists('penjualan');
    }
}
