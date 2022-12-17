<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('paids', function (Blueprint $table) {
      $table->bigIncrements('payId');
      $table->string('payTitular');
      $table->string('payDocumentTitular');
      $table->string('payBank');
      $table->string('payType');
      $table->string('payAgreement')->default('');
      $table->string('payAccount');
      $table->bigInteger('payLegalization_id')->unsigned();
      $table->foreign('payLegalization_id')->references('legId')->on('legalizations')->onDelete('cascade');
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
    Schema::dropIfExists('paids');
  }
}
