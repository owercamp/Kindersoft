<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherentrysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('voucherentrys', function (Blueprint $table) {
      $table->bigIncrements('venId');
      $table->bigInteger('venFacturation_id')->unsigned();
      $table->foreign('venFacturation_id')->references('facId')->on('facturations')->onDelete('cascade');
      $table->date('venDate');
      $table->float('venPaid');
      $table->text('venDescription')->nullable();
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
    Schema::dropIfExists('voucherentrys');
  }
}
