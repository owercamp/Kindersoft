<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoDailiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_dailies', function (Blueprint $table) {
      $table->bigIncrements('id_id');
      $table->string('id_fulldate', 70);
      $table->text('id_hi');
      $table->text('id_cont');
      $table->text('id_NamesFiles');
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
    Schema::dropIfExists('info_dailies');
  }
}
