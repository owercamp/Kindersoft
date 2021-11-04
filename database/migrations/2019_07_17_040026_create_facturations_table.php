<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('facturations', function (Blueprint $table) {
      $table->bigIncrements('facId');
      $table->string('facCode')->unique();
      $table->string('facRegime');
      $table->string('facEconomicActivity');
      $table->string('facDian');
      $table->date('facDateInitial');
      $table->date('facDateFinal');
      $table->text('facAutorized');
      $table->float('facValue');
      $table->bigInteger('facLegalization_id')->unsigned();
      $table->foreign('facLegalization_id')->references('legId')->on('legalizations')->onDelete('cascade');
      $table->bigInteger('facAutorization_id')->unsigned();
      $table->foreign('facAutorization_id')->references('auId')->on('autorizations')->onDelete('cascade');
      $table->enum('facStatus', ['EN REVISION', 'APROBADA', 'DENEGADA', 'PAGADO'])->default('EN REVISION');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('facturations');
  }
}
