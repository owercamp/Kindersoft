@extends('modules.dailynews')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>CONTROL DE ADICIONALES </h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de adicionales -->
      @if(session('SuccessSaveAdditional'))
      <div class="alert alert-success">
        {{ session('SuccessSaveAdditional') }}
      </div>
      @endif
      @if(session('SecondarySaveAdditional'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAdditional') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de adicionales -->
      @if(session('PrimaryUpdateAdditional'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAdditional') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAdditional'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAdditional') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de adicionales -->
      @if(session('WarningDeleteAdditional'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAdditional') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAdditional'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAdditional') }}
      </div>
      @endif
    </div>
  </div>
  <form action="{{ route('additional.new') }}" method="POST">
    @csrf
    <div class="row border-bottom">
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">CURSO:</small>
          <select name="addCourse" class="form-control form-control-sm " required>
            <option value="">Seleccione un curso...</option>
            @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">ALUMNO:</small>
          <select name="addStudent" class="form-control form-control-sm " required>
            <option value="">Seleccione un alumno...</option>
            <!-- Option dinamico de seleccion del curso -->
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">ACUDIENTE:</small>
          <input type="hidden" name="addIdAttendant" class="form-control form-control-sm" readonly required>
          <input type="text" name="addAttendant" class="form-control form-control-sm" disabled>
        </div>
        <div class="form-group">
          <small class="text-muted">FECHA:</small>
          <input type="text" name="addDate" class="form-control form-control-sm datepicker" readonly required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">OBSERVACION DE AUTORIZACION:</small>
          <textarea name="addDescription" cols="5" rows="3" maxlength="500" class="form-control form-control-sm" placeholder="Máximo de 500 carácteres" required></textarea>
        </div>
      </div>
    </div>
    <div class="row border-top mt-3">
      <div class="col-md-12">
        <!-- ADMISIONES -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">ADMISIONES: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeAdmission" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeAdmission" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-admissions" title="AÑADIR ADMISIÓN">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-admissions" title="QUITAR ADMISIÓN">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-admissions">
                <div class="col-md-6">
                  <select name="addAdmission" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione una admisión...</option>
                    @foreach($admissions as $admission)
                    <option value="{{ $admission->id }}">{{ $admission->admConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addAdmissionvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- JORNADAS -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">JORNADA: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeJourney" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeJourney" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-journeys" title="AÑADIR JORNADA">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-journeys" title="QUITAR JORNADA">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-journeys">
                <div class="col-md-6">
                  <select name="addJourney" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione una jornada...</option>
                    @foreach($journeys as $journey)
                    <option value="{{ $journey->id }}">{{ $journey->jouJourney }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addJourneyvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ALIMENTACION -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">ALIMENTACION: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeFeeding" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeFeeding" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-feedings" title="AÑADIR ALIMENTACION">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-feedings" title="QUITAR ALIMENTACION">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-feedings">
                <div class="col-md-6">
                  <select name="addFeeding" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione una alimentación...</option>
                    @foreach($feedings as $feeding)
                    <option value="{{ $feeding->id }}">{{ $feeding->feeConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addFeedingvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- UNIFORMES -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">UNIFORMES: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeUniform" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeUniform" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-uniforms" title="AÑADIR UNIFORME">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-uniforms" title="QUITAR UNIFORME">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-uniforms">
                <div class="col-md-6">
                  <select name="addUniform" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione un uniforme...</option>
                    @foreach($uniforms as $uniform)
                    <option value="{{ $uniform->id }}">{{ $uniform->uniConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addUniformvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- MATERIAL ESCOLAR -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">MATERIAL ESCOLAR: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeSupplie" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeSupplie" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-supplies" title="AÑADIR MATERIAL ESCOLAR">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-supplies" title="QUITAR MATERIAL ESCOLAR">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-supplies">
                <div class="col-md-6">
                  <select name="addSupplie" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione un uniforme...</option>
                    @foreach($supplies as $supplie)
                    <option value="{{ $supplie->id }}">{{ $supplie->supConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addSupplievalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- TIEMPO ADICIONAL -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">TIEMPO ADICIONAL: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeExtratime" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeExtratime" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-extratime" title="AÑADIR TIEMPO ADICIONAL">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-extratime" title="QUITAR TIEMPO ADICIONAL">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-extratime">
                <div class="col-md-6">
                  <select name="addExtratime" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione un tiempo...</option>
                    @foreach($extratimes as $extratime)
                    <option value="{{ $extratime->id }}">{{ $extratime->extTConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addExtratimevalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- EXTRACURRICULARES -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">EXTRACURRICULARES: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeExtracurricular" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeExtracurricular" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-extracurriculars" title="AÑADIR EXTRACURRICULAR">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-extracurriculars" title="QUITAR EXTRACURRICULAR">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-extracurriculars">
                <div class="col-md-6">
                  <select name="addExtracurricular" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione un extracurricular...</option>
                    @foreach($extracurriculars as $extracurricular)
                    <option value="{{ $extracurricular->id }}">{{ $extracurricular->extConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addExtracurricularvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- TRANSPORTE -->
        <div class="form-group py-2" style="background: #ccc;">
          <h6 class="text-muted pl-4">TRANSPORTE: </h6>
          <div class="row border-top border-bottom p-3" style="background: #fff;">
            <div class="col-md-12 section-all">
              <div class="row section-how">
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeTransport" value="SI">
                    SI
                  </small>
                </div>
                <div class="col-md-4 text-left">
                  <small class="text-muted">
                    <input type="radio" name="activeTransport" value="NO" checked>
                    NO
                  </small>
                </div>
                <div class="col-md-4 text-left section-btn-items">
                  <button type="button" class="btn btn-outline-primary form-control-sm btn-items-plus-transports" title="AÑADIR TRANSPORTE">
                    <i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-outline-tertiary  form-control-sm btn-items-minus-transports" title="QUITAR TRANSPORTE">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="row p-2 fields-items-transports">
                <div class="col-md-6">
                  <select name="addTransport" class="form-control form-control-sm " disabled>
                    <option value="">Seleccione un transporte...</option>
                    @foreach($transports as $transport)
                    <option value="{{ $transport->id }}">{{ $transport->traConcept }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="addTransportvalue" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-12">
        <input type="hidden" name="all_items" class="form-control form-control-sm" readonly required>
        <button type="submit" class="btn btn-outline-success form-control-sm btnSaveAutorized">REGISTRAR AUTORIZACION</button>
      </div>
    </div>
  </form>
  @endsection

  @section('scripts')
  <script>
    $(function() {
      var datenow = new Date();
      var mount = ((datenow.getMonth() + 1) < 10 ? '0' : '') + (datenow.getMonth() + 1);
      var day = (datenow.getDate() < 10 ? '0' : '') + datenow.getDate();
      var dateCompleted = datenow.getFullYear() + '-' + mount + '-' + day;
      $('input[name=addDate]').val(dateCompleted);
      $('.section-btn-items').css('display', 'none');
    });

    // EVENTO PARA VALIDAR CAMPOS Y GUARDAR AUTORIZACIONES EN BASE DE DATOS
    $('.btnSaveAutorized').on('click', function(e) {
      var validate = 0; //SI TODOS ESTAN EN (NO)
      var items = '';
      if ($('input[name=activeAdmission]:checked').val() == 'SI') {
        $('.fields-items-admissions').each(function() {
          var select = $(this).find('select[name=addAdmission]');
          var value = $(this).find('select[name=addAdmission]').val();
          if (select && value != '') {
            items += 'ADMISION:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeJourney]:checked').val() == 'SI') {
        $('.fields-items-journeys').each(function() {
          var select = $(this).find('select[name=addJourney]');
          var value = $(this).find('select[name=addJourney]').val();
          if (select && value != '') {
            items += 'JORNADA:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeFeeding]:checked').val() == 'SI') {
        $('.fields-items-feedings').each(function() {
          var select = $(this).find('select[name=addFeeding]');
          var value = $(this).find('select[name=addFeeding]').val();
          if (select && value != '') {
            items += 'ALIMENTACION:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeUniform]:checked').val() == 'SI') {
        $('.fields-items-uniforms').each(function() {
          var select = $(this).find('select[name=addUniform]');
          var value = $(this).find('select[name=addUniform]').val();
          if (select && value != '') {
            items += 'UNIFORME:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeSupplie]:checked').val() == 'SI') {
        $('.fields-items-supplies').each(function() {
          var select = $(this).find('select[name=addSupplie]');
          var value = $(this).find('select[name=addSupplie]').val();
          if (select && value != '') {
            items += 'MATERIAL:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeExtratime]:checked').val() == 'SI') {
        $('.fields-items-extratime').each(function() {
          var select = $(this).find('select[name=addExtratime]');
          var value = $(this).find('select[name=addExtratime]').val();
          if (select && value != '') {
            items += 'TIEMPO EXTRA:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeExtracurricular]:checked').val() == 'SI') {
        $('.fields-items-extracurriculars').each(function() {
          var select = $(this).find('select[name=addExtracurricular]');
          var value = $(this).find('select[name=addExtracurricular]').val();
          if (select && value != '') {
            items += 'EXTRACURRICULAR:' + value + '=';
            validate++;
          }
        });
      }
      if ($('input[name=activeTransport]:checked').val() == 'SI') {
        $('.fields-items-transports').each(function() {
          var select = $(this).find('select[name=addTransport]');
          var value = $(this).find('select[name=addTransport]').val();
          if (select && value != '') {
            items += 'TRANSPORTE:' + value + '=';
            validate++;
          }
        });
      }
      $('input[name=all_items]').val(items);
      if (validate > 0 && items != '') {
        $('.btnSaveAutorized').submit();
      } else {
        e.preventDefault();
        $('.btnSaveAutorized').attr('disabled', true);
      }
    });

    //SELECCION DEL CURSO PARA MOSTRAR LOS ESTUDIANTES DE DICHO CURSO
    $('select[name=addCourse]').on('change', function(e) {
      var courseSelected = e.target.value;
      if (courseSelected != '') {
        $.get("{{ route('getStudentFromCourse') }}", {
          courseSelected: courseSelected
        }, function(objectStudents) {
          var count = Object.keys(objectStudents).length;
          $('select[name=addStudent]').empty();
          $('select[name=addStudent]').append("<option value=''>Seleccione un alumno...</option>");
          for (var i = 0; i < count; i++) {
            $('select[name=addStudent]').append('<option value=' + objectStudents[i]['id'] + '>' + objectStudents[i]['nameStudent'] + '</option>');
          }
        });
      }
    });

    //SELECCION DE ESTUDIANTE PARA TRAER AL ACUDIENTE
    $('select[name=addStudent]').on('change', function(e) {
      var studentSelected = e.target.value;
      if (studentSelected != '') {
        $.get("{{ route('getAttendantAdditional') }}", {
          studentSelected: studentSelected
        }, function(objectAttendant) {
          if (objectAttendant != null && objectAttendant != '') {
            $('input[name=addAttendant]').val('');
            $('input[name=addAttendant]').val(objectAttendant['nameAttendant']);
            $('input[name=addIdAttendant]').val('');
            $('input[name=addIdAttendant]').val(objectAttendant['idAttendant']);
          }
        });
      } else {
        $('input[name=addAttendant]').val('');
      }
    });

    /*===========================================================================================================
    									/start\ ADMISIONES - ADMISSIONS /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (JORNADAS)
    $('.section-all').on('click', '.btn-items-plus-admissions', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-admissions:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });
    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (JORNADAS)
    $('.btn-items-minus-admissions').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-admissions');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-admissions:last').remove();
      }
    });

    //CHEQUEO DE JORNADA PARA HABILITAR O NO EL SELECT
    $('input[name=activeAdmission]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addAdmission]').val('');
        $('input[name=addAdmissionvalue]').val('');
        $('select[name=addAdmission]').attr('disabled', false);
        $('select[name=addAdmission]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addAdmission]').val('');
        $('input[name=addAdmissionvalue]').val('');
        $('select[name=addAdmission]').attr('disabled', true);
        $('select[name=addAdmission]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-admissions').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-admissions:last').remove();
        }
      }
    });
    //SELECCION DE ADMISION
    $('.section-all').on('change', '.fields-items-admissions', function() {
      var father = $(this);
      var admissionSelected = $(this).find('select[name=addAdmission]').val();
      if (admissionSelected != '') {
        $.get("{{ route('selectedAdmissionQuotation') }}", {
          selectedConcept: admissionSelected
        }, function(objectAdmission) {
          father.find('input[name=addAdmissionvalue]').val(' ==> $' + objectAdmission['admValue']);
          //$('input[name=addAdmissionvalue]').val(objectAdmission['admConcept'] + ' ==> $' + objectAdmission['admValue']);
        });
      } else {
        father.find('input[name=addAdmissionvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ ADMISIONES - ADMISSIONS /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ JORNADAS - JOURNEYS /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (JORNADAS)
    $('.section-all').on('click', '.btn-items-plus-journeys', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-journeys:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });
    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (JORNADAS)
    $('.btn-items-minus-journeys').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-journeys');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-journeys:last').remove();
      }
    });

    //CHEQUEO DE JORNADA PARA HABILITAR O NO EL SELECT
    $('input[name=activeJourney]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addJourney]').val('');
        $('input[name=addJourneyvalue]').val('');
        $('select[name=addJourney]').attr('disabled', false);
        $('select[name=addJourney]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addJourney]').val('');
        $('input[name=addJourneyvalue]').val('');
        $('select[name=addJourney]').attr('disabled', true);
        $('select[name=addJourney]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-journeys').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-journeys:last').remove();
        }
      }
    });
    //SELECCION DE JORNADA
    $('.section-all').on('change', '.fields-items-journeys', function() {
      var father = $(this);
      var journeySelected = $(this).find('select[name=addJourney]').val();
      if (journeySelected != '') {
        $.get("{{ route('selectedJourneyQuotation') }}", {
          selectedConcept: journeySelected
        }, function(objectJourney) {
          father.find('input[name=addJourneyvalue]').val(' ==> $' + objectJourney['jouValue']);
          //$('input[name=addJourneyvalue]').val(objectJourney['jouDays'] + ' ==> $' + objectJourney['jouValue']);
        });
      } else {
        father.find('input[name=addJourneyvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ JORNADAS - JOURNEYS /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ ALIMENTACION - FEEDINGS /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (ALIMENTACION)
    $('.section-all').on('click', '.btn-items-plus-feedings', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-feedings:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (ALIMENTACION)
    $('.btn-items-minus-feedings').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-feedings');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-feedings:last').remove();
      }
    });

    //CHEQUEO DE ALIMENTACION PARA HABILITAR O NO EL SELECT
    $('input[name=activeFeeding]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addFeeding]').val('');
        $('input[name=addFeedingvalue]').val('');
        $('select[name=addFeeding]').attr('disabled', false);
        $('select[name=addFeeding]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addFeeding]').val('');
        $('input[name=addFeedingvalue]').val('');
        $('select[name=addFeeding]').attr('disabled', true);
        $('select[name=addFeeding]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-feedings').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-feedings:last').remove();
        }
      }
    });
    //SELECCION DE LA ALIMENTACION
    $('.section-all').on('change', '.fields-items-feedings', function() {
      var father = $(this);
      var feedingSelected = $(this).find('select[name=addFeeding]').val();
      if (feedingSelected != '') {
        $.get("{{ route('selectedFeedingQuotation') }}", {
          selectedConcept: feedingSelected
        }, function(objectFeeding) {
          father.find('input[name=addFeedingvalue]').val('==> $' + objectFeeding['feeValue']);
        });
      } else {
        father.find('input[name=addFeedingvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ ALIMENTACION - FEEDINGS /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ UNIFORME - UNIFORMS /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (UNIFORME)
    $('.section-all').on('click', '.btn-items-plus-uniforms', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-uniforms:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (UNIFORME)
    $('.btn-items-minus-uniforms').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-uniforms');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-uniforms:last').remove();
      }
    });

    //CHEQUEO DE LOS UNIFORMES PARA HABILITAR O NO EL SELECT
    $('input[name=activeUniform]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addUniform]').val('');
        $('input[name=addUniformvalue]').val('');
        $('select[name=addUniform]').attr('disabled', false);
        $('select[name=addUniform]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addUniform]').val('');
        $('input[name=addUniformvalue]').val('');
        $('select[name=addUniform]').attr('disabled', true);
        $('select[name=addUniform]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-uniforms').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-uniforms:last').remove();
        }
      }
    });
    //SELECCION DE LOS UNIFORMES
    $('.section-all').on('change', '.fields-items-uniforms', function() {
      var father = $(this);
      var uniformSelected = $(this).find('select[name=addUniform]').val();
      if (uniformSelected != '') {
        $.get("{{ route('selectedUniformQuotation') }}", {
          selectedConcept: uniformSelected
        }, function(objectUniform) {
          father.find('input[name=addUniformvalue]').val('==> $' + objectUniform['uniValue']);
        });
      } else {
        father.find('input[name=addUniformvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ UNIFORME - UNIFORMS /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ MATERIAL ESCOLAR - SUPPLIES /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (MATERIAL ESCOLAR)
    $('.section-all').on('click', '.btn-items-plus-supplies', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-supplies:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (MATERIAL ESCOLAR)
    $('.btn-items-minus-supplies').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-supplies');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-supplies:last').remove();
      }
    });

    //CHEQUEO DE LOS MATERIALES ESCOLARES PARA ABILITAR O NO EL SELECT
    $('input[name=activeSupplie]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addSupplie]').val('');
        $('input[name=addSupplievalue]').val('');
        $('select[name=addSupplie]').attr('disabled', false);
        $('select[name=addSupplie]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addSupplie]').val('');
        $('input[name=addSupplievalue]').val('');
        $('select[name=addSupplie]').attr('disabled', true);
        $('select[name=addSupplie]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-supplies').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-supplies:last').remove();
        }
      }
    });
    //SELECCION DE LOS MATERIAL ESCOLAR
    $('.section-all').on('change', '.fields-items-supplies', function() {
      var father = $(this);
      var supplieSelected = $(this).find('select[name=addSupplie]').val();
      if (supplieSelected != '') {
        $.get("{{ route('selectedSupplieQuotation') }}", {
          selectedConcept: supplieSelected
        }, function(objectSupplie) {
          father.find('input[name=addSupplievalue]').val('==> $' + objectSupplie['supValue']);
        });
      } else {
        father.find('input[name=addSupplievalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ MATERIAL ESCOLAR - SUPPLIES /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ TIEMPO EXTRA - EXTRATIME /start\
    ===========================================================================================================*/

    // EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (TIEMPO EXTRA)
    $('.section-all').on('click', '.btn-items-plus-extratime', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-extratime:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    // EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (TIEMPO EXTRA)
    $('.btn-items-minus-extratime').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-extratime');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-extratime:last').remove();
      }
    });

    // CHEQUEO DE LOS TIEMPOS EXTRA PARA HABILITAR O NO EL SELECT
    $('input[name=activeExtratime]').on('click', function() {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addExtratime]').val('');
        $('input[name=addExtratimevalue]').val('');
        $('select[name=addExtratime]').attr('disabled', false);
        $('select[name=addExtratime]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addExtratime]').val('');
        $('input[name=addExtratimevalue]').val('');
        $('select[name=addExtratime]').attr('disabled', true);
        $('select[name=addExtratime]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-extratime').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-extratime:last').remove();
        }
      }
    });
    // SELECCION DE LOS TIEMPOS EXTRA
    $('.section-all').on('change', '.fields-items-extratime', function() {
      var father = $(this);
      var extratimeSelected = $(this).find('select[name=addExtratime]').val();
      if (extratimeSelected != '') {
        $.get("{{ route('selectedExtratimeQuotation') }}", {
          selectedConcept: extratimeSelected
        }, function(objectExtratime) {
          father.find('input[name=addExtratimevalue]').val('');
          father.find('input[name=addExtratimevalue]').val('==> $' + objectExtratime['extTValue']);
        });
      } else {
        father.find('input[name=addExtratimevalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ TIEMPO EXTRA - EXTRATIME /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ EXTRACURRICULAR - EXTRACURRICULAR /start\
    ===========================================================================================================*/

    //EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (EXTRACURRICULAR)
    $('.section-all').on('click', '.btn-items-plus-extracurriculars', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-extracurriculars:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    //EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (EXTRACURRICULAR)
    $('.btn-items-minus-extracurriculars').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-extracurriculars');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-extracurriculars:last').remove();
      }
    });

    //CHEQUEO DE LOS EXTRACURRICULARES PARA HABILITAR O NO EL SELECT
    $('input[name=activeExtracurricular]').on('click', function() {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addExtracurricular]').val('');
        $('input[name=addExtracurricularvalue]').val('');
        $('select[name=addExtracurricular]').attr('disabled', false);
        $('select[name=addExtracurricular]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addExtracurricular]').val('');
        $('input[name=addExtracurricularvalue]').val('');
        $('select[name=addExtracurricular]').attr('disabled', true);
        $('select[name=addExtracurricular]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-extracurriculars').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-extracurriculars:last').remove();
        }
      }
    });
    //SELECCION DE LOS EXTRACURRICULARES
    $('.section-all').on('change', '.fields-items-extracurriculars', function() {
      var father = $(this);
      var extracurricularSelected = $(this).find('select[name=addExtracurricular]').val();
      if (extracurricularSelected != '') {
        $.get("{{ route('selectedExtracurricularQuotation') }}", {
          selectedConcept: extracurricularSelected
        }, function(objectExtracurricular) {
          father.find('input[name=addExtracurricularvalue]').val('');
          father.find('input[name=addExtracurricularvalue]').val('==> $' + objectExtracurricular['extValue']);
        });
      } else {
        father.find('input[name=addExtracurricularvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ EXTRACURRICULAR - EXTRACURRICULAR /end\
    ===========================================================================================================*/

    /*===========================================================================================================
    									/start\ TRANSPORTE - TRANSPORT /start\
    ===========================================================================================================*/

    // EVENTO PARA CLONAR Y AGREGAR CAMPO AL FINAL DE ACUERDO AL BOTON PLUS (EXTRACURRICULAR)
    $('.section-all').on('click', '.btn-items-plus-transports', function() {
      var fields = $(this).parents('div.section-all').find('.fields-items-transports:last').clone();
      fields.find('select').val('');
      fields.find('input').val('');
      $(this).parents('div.section-all').append(fields);
    });

    // EVENTO PARA ELIMINAR ULTIMO CAMPOS DE ACUERDO AL BOTON MINUS (EXTRACURRICULAR)
    $('.btn-items-minus-transports').on('click', function() {
      var sections = $(this).parents('div.section-all').find('.fields-items-transports');
      var count = sections.length;
      if (count > 1) {
        $(this).parents('div.section-all').find('.fields-items-transports:last').remove();
      }
    });

    // CHEQUEO DE TRANSPORTE PARA HABILITAR O NO EL SELECT
    $('input[name=activeTransport]').on('click', function(e) {
      var check = $(this).val();
      var father = $(this).parents('.section-all');
      if (check == 'SI') {
        $('.btnSaveAutorized').attr('disabled', false);
        $('select[name=addTransport]').val('');
        $('input[name=addTransportvalue]').val('');
        $('select[name=addTransport]').attr('disabled', false);
        $('select[name=addTransport]').attr('required', true);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'block');
      } else if (check == 'NO') {
        $('select[name=addTransport]').val('');
        $('input[name=addTransportvalue]').val('');
        $('select[name=addTransport]').attr('disabled', true);
        $('select[name=addTransport]').attr('required', false);
        $(this).parents('.section-how').find('.section-btn-items').css('display', 'none');
        var count_fields = father.find('.fields-items-transports').length;
        for (var i = 1; i < count_fields; i++) {
          father.find('.fields-items-transports:last').remove();
        }
      }
    });
    // SELECCION DE TRANSPORTE
    $('.section-all').on('change', '.fields-items-transports', function() {
      var father = $(this);
      var transportSelected = $(this).find('select[name=addTransport]').val();
      if (transportSelected != '') {
        $.get("{{ route('selectedTransportQuotation') }}", {
          selectedConcept: transportSelected
        }, function(objectTransport) {
          father.find('input[name=addTransportvalue]').val('');
          father.find('input[name=addTransportvalue]').val('==> $' + objectTransport['traValue']);
        });
      } else {
        father.find('input[name=addTransportvalue]').val('');
      }
    });

    /*===========================================================================================================
    									/end\ TRANSPORTE - TRANSPORT /end\
    ===========================================================================================================*/

    function validateField() {

    }

    function resetAll() {
      $('input[name=addAttendant]').val('');

    }
  </script>
  @endsection