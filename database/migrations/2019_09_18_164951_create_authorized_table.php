<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizedTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('authorized', function (Blueprint $table) {
      $table->bigIncrements('autId');
      $table->string('autFirstname');
      $table->string('autLastname');
      $table->bigInteger('autDocument_id')->unsigned();
      $table->foreign('autDocument_id')->references('id')->on('documents')->onDelete('cascade');
      $table->string('autNumberdocument');
      $table->string('autPhoneone');
      $table->string('autPhonetwo')->nullable();
      $table->string('autRelationship')->nullable();
      $table->string('autObservations')->nullable();
      $table->string('autPhoto')->default('authorizeddefault.png');
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
    Schema::dropIfExists('authorized');
  }
}
