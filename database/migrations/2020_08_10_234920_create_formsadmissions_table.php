<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsadmissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('formsadmissions', function (Blueprint $table) {
      $table->bigIncrements('fmId');
      $table->string('nombres');
      $table->string('apellidos');
      $table->enum('genero', ['MASCULINO', 'FEMENINO']);
      $table->date('fechanacimiento');
      $table->enum('tipodocumento', ['REGISTRO CIVIL', 'PASAPORTE']);
      $table->string('numerodocumento');
      $table->string('nacionalidad');
      $table->string('mesesgestacion');
      $table->string('tiposangre');
      $table->enum('tipoparto', ['Natural', 'Cesárea']);
      $table->string('enfermedades');
      $table->string('tratamientos');
      $table->string('alergias');
      $table->enum('asistenciaterapias', ['Si', 'No']);
      $table->string('cual');
      $table->string('health');
      $table->string('programa');
      $table->string('numerohermanos');
      $table->string('lugarqueocupa');
      $table->string('conquienvive');
      $table->text('otroscuidados');
      $table->string('nombreacudiente1');
      $table->string('documentoacudiente1');
      $table->string('direccionacudiente1');
      $table->string('barrioacudiente1');
      $table->string('localidadacudiente1');
      $table->string('celularacudiente1');
      $table->string('whatsappacudiente1');
      $table->string('correoacudiente1');
      $table->enum('formacionacudiente1', ['Profesional', 'Tecnólogo', 'Técnico', 'Otros']);
      $table->string('tituloacudiente1');
      $table->enum('tipoocupacionacudiente1', ['Dependiente Laboral', 'Independiente Laboral']);
      $table->string('empresaacudiente1');
      $table->string('direccionempresaacudiente1');
      $table->string('ciudadempresaacudiente1');
      $table->string('barrioempresaacudiente1');
      $table->string('localidadempresaacudiente1');
      $table->string('cargoempresaacudiente1');
      $table->date('fechaingresoempresaacudiente1');
      $table->string('nombreacudiente2');
      $table->string('documentoacudiente2');
      $table->string('direccionacudiente2');
      $table->string('barrioacudiente2');
      $table->string('localidadacudiente2');
      $table->string('celularacudiente2');
      $table->string('whatsappacudiente2');
      $table->string('correoacudiente2');
      $table->enum('formacionacudiente2', ['Profesional', 'Tecnólogo', 'Técnico', 'Otros']);
      $table->string('tituloacudiente2');
      $table->enum('tipoocupacionacudiente2', ['Dependiente Laboral', 'Independiente Laboral']);
      $table->string('empresaacudiente2');
      $table->string('direccionempresaacudiente2');
      $table->string('ciudadempresaacudiente2');
      $table->string('barrioempresaacudiente2');
      $table->string('localidadempresaacudiente2');
      $table->string('cargoempresaacudiente2');
      $table->date('fechaingresoempresaacudiente2');
      $table->string('nombreemergencia');
      $table->string('documentoemergencia');
      $table->string('direccionemergencia');
      $table->string('barrioemergencia');
      $table->string('localidademergencia');
      $table->string('celularemergencia');
      $table->string('whatsappemergencia');
      $table->string('parentescoemergencia');
      $table->string('correoemergencia');
      $table->string('nombreautorizado1');
      $table->string('documentoautorizado1');
      $table->string('parentescoautorizado1');
      $table->string('nombreautorizado2');
      $table->string('documentoautorizado2');
      $table->string('parentescoautorizado2');
      $table->date('fechaingreso');
      $table->string('firmaacudiente1')->nullable();
      $table->string('firmaacudiente2')->nullable();
      $table->enum('status', ['PENDIENTE', 'APROBADA']);
      $table->integer('migracion')->default(0);
      // Actualizacion 10 de Septiembre del 2020
      // INFORMACION Y EXPECTATIVAS
      $table->text('expectatives_likechild');
      $table->text('expectatives_activityschild');
      $table->text('expectatives_toychild');
      $table->text('expectatives_aspectchild');
      $table->text('expectatives_dreamforchild');
      $table->text('expectatives_learnchild');
      // INFORMACION CULTURAL
      $table->text('cultural_eventfamily');
      $table->text('cultural_supportculturefamily');
      $table->text('cultural_gardenlearnculture');
      $table->text('cultural_shareculturefamily');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('formsadmissions');
  }
}
