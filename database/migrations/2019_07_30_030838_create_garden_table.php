<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('garden', function (Blueprint $table) {
      $table->bigIncrements('garId');
      $table->string('garReasonsocial');
      $table->string('garNamecomercial');
      $table->string('garNit');
      $table->bigInteger('garCity_id')->unsigned();
      $table->foreign('garCity_id')->references('id')->on('citys')->onDelete('cascade');
      $table->bigInteger('garLocation_id')->unsigned();
      $table->foreign('garLocation_id')->references('id')->on('locations')->onDelete('cascade');
      $table->bigInteger('garDistrict_id')->unsigned();
      $table->foreign('garDistrict_id')->references('id')->on('districts')->onDelete('cascade');
      $table->string('garAddress');
      $table->string('garPhone');
      $table->string('garPhoneone');
      $table->string('garPhonetwo');
      $table->string('garPhonethree');
      $table->string('garWhatsapp');
      $table->string('garWebsite');
      $table->string('garMailone');
      $table->string('garMailtwo');
      $table->string('garNamelogo')->default('default.png');
      $table->string('garNamerepresentative');
      $table->string('garCardrepresentative');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('garden');
  }
}
