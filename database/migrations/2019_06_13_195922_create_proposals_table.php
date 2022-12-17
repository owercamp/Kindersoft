<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
  public function up()
  {
    Schema::create('proposals', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->date('proDateQuotation');
      $table->bigInteger('proScheduling_id')->unsigned()->nullable();
      $table->foreign('proScheduling_id')->references('id')->on('schedulings')->onDelete('cascade');
      $table->bigInteger('proCustomer_id')->unsigned()->nullable();
      $table->foreign('proCustomer_id')->references('id')->on('customers')->onDelete('cascade');
      $table->bigInteger('proGrade_id')->unsigned();
      $table->foreign('proGrade_id')->references('id')->on('grades')->onDelete('cascade');
      $table->bigInteger('proAdmission_id')->unsigned();
      $table->foreign('proAdmission_id')->references('id')->on('admissions')->onDelete('cascade');
      $table->bigInteger('proJourney_id')->unsigned();
      $table->foreign('proJourney_id')->references('id')->on('journeys')->onDelete('cascade');
      $table->bigInteger('proFeeding_id')->unsigned();
      $table->foreign('proFeeding_id')->references('id')->on('feedings')->onDelete('cascade');
      $table->bigInteger('proUniform_id')->unsigned();
      $table->foreign('proUniform_id')->references('id')->on('uniforms')->onDelete('cascade');
      $table->bigInteger('proSupplie_id')->unsigned();
      $table->foreign('proSupplie_id')->references('id')->on('supplies')->onDelete('cascade');
      $table->bigInteger('proTransport_id')->unsigned();
      $table->foreign('proTransport_id')->references('id')->on('transports')->onDelete('cascade');
      $table->bigInteger('proExtratime_id')->unsigned();
      $table->foreign('proExtratime_id')->references('id')->on('extratimes')->onDelete('cascade');
      $table->bigInteger('proExtracurricular_id')->unsigned();
      $table->foreign('proExtracurricular_id')->references('id')->on('extracurriculars')->onDelete('cascade');
      $table->float('proValueQuotation');
      $table->enum('proStatus', ['ABIERTO', 'CERRADO'])->default('ABIERTO');
      $table->enum('proResult', ['ACEPTADO', 'DENEGADO'])->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('proposals');
  }
}
