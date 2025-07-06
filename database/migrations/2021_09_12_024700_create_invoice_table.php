<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('no_invoice',20);
            $table->unsignedInteger('costumer_id');
            $table->unsignedFloat('total');
            $table->unsignedFloat('diskon');
            $table->string('no_tlp',20);
            $table->string('no_tlp_tujuan',20);
            $table->text('alamat');
            $table->string('status',20)->default('Belum diproses');
            $table->unsignedTinyInteger('void');
            $table->unsignedSmallInteger('admin');
            $table->date('tgl');
            $table->string('nm_penerima',50);
            $table->unsignedSmallInteger('cabang_id');
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
        Schema::dropIfExists('invoice');
    }
}
