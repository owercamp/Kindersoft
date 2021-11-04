<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucheregressTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('voucheregress', function (Blueprint $table) {
      $table->bigIncrements('vegId');
      $table->bigInteger('vegProvider_id')->unsigned();
      $table->foreign('vegProvider_id')->references('id')->on('providers')->onDelete('cascade');
      $table->text('vegConcept', 500);
      $table->date('vegDate');
      $table->float('vegPay');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('voucheregress');
  }
}
