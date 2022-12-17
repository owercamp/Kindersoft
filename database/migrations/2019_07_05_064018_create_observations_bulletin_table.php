<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservationsBulletinTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('observations_bulletin', function (Blueprint $table) {
      $table->bigIncrements('obuId');
      $table->bigInteger('obuBulletin_id')->unsigned();
      $table->foreign('obuBulletin_id')->references('buId')->on('bulletins')->onDelete('cascade');
      $table->bigInteger('obuObservation_id')->unsigned();
      $table->foreign('obuObservation_id')->references('obsId')->on('observations')->onDelete('cascade');
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
    Schema::dropIfExists('observations_bulletin');
  }
}
