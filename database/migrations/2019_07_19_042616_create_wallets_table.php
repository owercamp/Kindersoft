<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wallets', function (Blueprint $table) {
      $table->bigIncrements('waId');
      $table->float('waMoney')->default(0);
      $table->enum('waStatus', ['SIN SALDO', 'A FAVOR', 'EN DEUDA'])->default('SIN SALDO');
      $table->bigInteger('waStudent_id')->unsigned();
      $table->foreign('waStudent_id')->references('id')->on('students')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wallets');
  }
}
