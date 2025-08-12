@extends('modules.programming')

@section('academicModules')
<div class="col-md-12">
  <div class="row p-4">
    <div class="col-md-4">
      <h5>HORARIO SEMANAL</h5>
    </div>
    <div class="col-md-4">
      <button type="button" class="btn btn-outline-tertiary  form-control-sm filterHourweek-link">FILTRAR DESCARGAS</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de eliminacion de horario semanal -->
      @if(session('WarningDeleteHoursweek'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteHoursweek') }}
      </div>
      @endif
      @if(session('SecondaryDeleteHoursweek'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteHoursweek') }}
      </div>
      @endif
      <div class="alert alert-info messages"></div>
    </div>
  </div>
  <form action="" method="POST">
    @csrf
    <div class="row border-top py-2">
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">CURSO:</small>
          <select name="hwCourse" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un curso...</option>
            @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">GRADO:</small>
          <input type="text" name="hwGrade" class="form-control form-control-sm" value="" disabled required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">DIRECTOR/A DE GRUPO:</small>
          <input type="hidden" name="hwCollaborator-hidden" class="form-control form-control-sm" value="" disabled required>
          <input type="text" name="hwCollaborator" class="form-control form-control-sm" value="" disabled required>
        </div>
        <div class="form-group">
          <small class="text-muted">ESTADO DEL CURSO:</small>
          <input type="text" name="hwStatus" class="form-control form-control-sm" value="" disabled required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">FECHA INICIAL:</small>
          <input type="text" name="hwDateInitial" class="form-control form-control-sm datepicker" disabled required>
        </div>
        <div class="form-group">
          <small class="text-muted">FECHA FINAL:</small>
          <input type="text" name="hwDateFinal" class="form-control form-control-sm datepicker" disabled required>
        </div>
      </div>
    </div>
    <div class="row border-top py-3">
      <div class="col-md-12">
        <div id="fullcalendarweek"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="form-group">
          <button type="submit" class="btn btn-outline-success form-control-sm mt-4" style="display: none;">ESTABLECER HORARIO</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- MODAL PARA CREAR ACTIVIDADES O CLASES EN UNA HORA ESPECIFICA -->
<div class="modal fade" id="newHourweek-Modal">
  <div class="modal-dialog">
    <div class="modal-content px-4 py-4">
      <div class="modal-header row">
        <div class="col-md-12">
          <h6 class="text-muted mb-4"><span hidden class="dateSelected-modal"></span> TIEMPO PROGRAMADO PARA: <b class="nameCourseSelected-modal"></b></h6>
          <div class="row py-3 border-top border-bottom">
            <div class="col-md-6 text-center">
              <small class="text-muted">
                <input type="radio" name="optionAllDays" value="SI">
                Todos los <span class="hwDay-modal"></span>
              </small>
            </div>
            <div class="col-md-6 text-center">
              <small class="text-muted">
                <input type="radio" name="optionAllDays" value="NO" checked>
                Solo este <span class="hwDay-modal"></span>
              </small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">DESDE:</small>
                <input type="text" class="form-control form-control-sm datepicker" name="hwDateInitial-modal" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">HASTA:</small>
                <input type="text" class="form-control form-control-sm datepicker" name="hwDateFinal-modal" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <h6>DIA SELECCIONADO: <b class="dateSelected-modalInfo"></b></h6>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">HORA INICIAL:</small>
              <input type="time" class="form-control form-control-sm" name="hwHourInitial-modal" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">HORA FINAL:</small>
              <input type="time" class="form-control form-control-sm" name="hwHourFinal-modal">
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">ACTIVIDAD/CLASE:</small>
          <select name="hwActivityClass-modal" class="form-control form-control-sm select2" required>
            <option value="">Seleccione una clase/actividad...</option>
            @foreach($activityclass as $ac)
            <option value="{{ $ac->acId }}">{{ $ac->acNumber . '-' . $ac->acClass }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">ESPACIO:</small>
          <select name="hwActivitySpace-modal" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un espacio...</option>
            @foreach($activityspace as $as)
            <option value="{{ $as->asId }}">{{ $as->asNumber . '-' . $as->asSpace }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">DOCENTE:</small>
          <select name="hwCollaborator-modal" class="form-control form-control-sm select2" required>
            <option value="">Seleccione docente...</option>
            @foreach($collaborators as $collaborator)
            <option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <button id="confirmNewHour" type="button" class="btn btn-outline-success float-left form-control-sm">ACEPTAR</button>
          <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA VER DETALLES DE CADA EVENTO EN EL CALENDARIO -->
<div class="modal fade" id="detailsHourweek-Modal">
  <div class="modal-dialog">
    <div class="modal-content px-4 py-4">
      <div class="modal-header row">
        <div class="col-md-12">
          <h6 class="text-muted mb-4">DETALLES DE HORARIO: </h6>
          <hr>
          <small class="text-muted">CURSO: </small>
          <small class="text-muted"><b class="nameCourse-modalDetails"></b></small><br>
          <small class="text-muted">FECHA: </small>
          <small class="text-muted"><b class="hwDate-modalDetails"></b></small><br>
          <small class="text-muted">DIA: </small>
          <small class="text-muted"><b class="hwDay-modalDetails"></b></small><br>
          <small class="text-muted">HORA INICIAL: </small>
          <small class="text-muted"><b class="hwHourInitial-modalDetails"></b></small><br>
          <small class="text-muted">HORA FINAL: </small>
          <small class="text-muted"><b class="hwHourFinal-modalDetails"></b></small><br>
          <small class="text-muted">ACTIVIDAD/CLASE: </small>
          <small class="text-muted"><b class="hwActivityClass-modalDetails"></b></small><br>
          <small class="text-muted">ESPACIO: </small>
          <small class="text-muted"><b class="hwActivitySpace-modalDetails"></b></small>
        </div>
      </div>
      <div class="modal-body">
        <form action="{{ route('hourweek.delete') }}" method="POST">
          @csrf
          <input type="hidden" name="hwIdDelete" value="" readonly required>
          <button type="submit" class="btn btn-outline-tertiary  float-left form-control-sm">ELIMINAR</button>
        </form>
        <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA FILTRAR DESCARGAR PDF -->
<div class="modal fade" id="filterHourweek-Modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content px-4 py-4">
      <form action="{{ route('hourweek.pdf') }}" method="GET">
        <!-- ROUTE PREV: hourweek.pdf -->
        @csrf
        <div class="modal-header row">
          <div class="col-md-12">
            <h6 class="text-muted mb-4">DESCARGA DE HORARIO SEMANAL: </h6>
            <hr>
            <div class="row py-3 border-top border-bottom" style="background: #dedede;">
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="SPACE" checked>
                  Por espacio
                </small>
              </div>
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="ACTIVITY">
                  Por actividad
                </small>
              </div>
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="COURSE">
                  Por curso
                </small>
              </div>
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="COLLABORATOR">
                  Por docente
                </small>
              </div>
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="HOUR">
                  Por hora
                </small>
              </div>
              <div class="col-md-2 text-center">
                <small class="text-muted">
                  <input type="radio" name="optionFilter" value="DAY">
                  Por dia
                </small>
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-12">
                <div class="form-group dinamicSpace">
                  <small class="text-muted">ESPACIO:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <select name="hwFilterActivitySpace" class="form-control form-control-sm select2" required>
                        <option value="">Seleccione un espacio...</option>
                        @foreach($activityspace as $as)
                        <option value="{{ $as->asId }}">{{ $as->asNumber . '-' . $as->asSpace }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterSpace" style='display: none;'>CONSULTAR</button>
                    </div>
                  </div>
                </div>
                <div class="form-group dinamicActivity" style="display: none;">
                  <small class="text-muted">ACTIVIDAD:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <select name="hwFilterActivityOnly" class="form-control form-control-sm select2" disabled>
                        <option value="">Seleccione una actividad...</option>
                        @foreach($activityclass as $ac)
                        <option value="{{ $ac->acId }}">{{ $ac->acNumber . '-' . $ac->acClass }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterACtivity" style='display: none;'>CONSULTAR</button>
                    </div>
                  </div>
                </div>
                <div class="form-group dinamicCourse" style="display: none;">
                  <small class="text-muted">CURSO:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <select name="hwFilterCourse" class="form-control form-control-sm select2" disabled>
                        <option value="">Seleccione un curso...</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterCourse" style='display: none;'>CONSULTAR</button>
                    </div>
                  </div>
                </div>
                <div class="form-group dinamicCollaborator" style="display: none;">
                  <small class="text-muted">DOCENTE:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <select name="hwFilterCollaborator" class="form-control form-control-sm select2" disabled>
                        <option value="">Seleccione un docente...</option>
                        @foreach($collaborators as $collaborator)
                        <option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterCollaborator" style='display: none;'>CONSULTAR</button>
                    </div>
                  </div>
                </div>
                <div class="form-group dinamicHour" style="display: none;">
                  <small class="text-muted">HORA DE INICIO:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <select name="hwFilterHour" class="form-control form-control-sm select2" disabled>
                        <option value="">Seleccione una hora...</option>
                        <option value="06:00:00">06:00:00</option>
                        <option value="06:30:00">06:30:00</option>
                        <option value="07:00:00">07:00:00</option>
                        <option value="07:30:00">07:30:00</option>
                        <option value="08:00:00">08:00:00</option>
                        <option value="08:30:00">08:30:00</option>
                        <option value="09:00:00">09:00:00</option>
                        <option value="09:30:00">09:30:00</option>
                        <option value="10:00:00">10:00:00</option>
                        <option value="10:30:00">10:30:00</option>
                        <option value="11:00:00">11:00:00</option>
                        <option value="11:30:00">11:30:00</option>
                        <option value="12:00:00">12:00:00</option>
                        <option value="12:30:00">12:30:00</option>
                        <option value="13:00:00">13:00:00</option>
                        <option value="13:30:00">13:30:00</option>
                        <option value="14:00:00">14:00:00</option>
                        <option value="14:30:00">14:30:00</option>
                        <option value="15:00:00">15:00:00</option>
                        <option value="15:30:00">15:30:00</option>
                        <option value="16:00:00">16:00:00</option>
                        <option value="16:30:00">16:30:00</option>
                        <option value="17:00:00">17:00:00</option>
                        <option value="17:30:00">17:30:00</option>
                      </select>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterHour" style="display: none;">CONSULTAR</button>
                    </div>
                  </div>
                </div>
                <div class="form-group dinamicDay" style="display: none;">
                  <small class="text-muted">FECHA:</small>
                  <div class="row">
                    <div class="col-md-8">
                      <input type="text" name="hwFilterDay" class="form-control form-control-sm datepicker" disabled>
                    </div>
                    <div class="col-md-4 text-center">
                      <button type="button" class="btn btn-outline-success form-control-sm btn-filterDay" style="display: none;">CONSULTAR</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Actualizacion -->
            <!-- <div class="row p-4">
								<div class="col-md-12 d-flex justify-content-center">
									<div class="spinner-border" align="center" role="status">
									  <span class="sr-only" align="center">Loading...</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div id="fullcalendarfilter" class="fullcalendarfilter"></div>
									<canvas id="fullcalendarfilter_hidden" width="300px" height="300px" hidden></canvas>
								</div>
							</div> -->
          </div>
        </div>
        <div class="modal-body">
          <!-- CLASE PARA PONER A BOTON Y VER CALENDARIO EN MODAL: btn-downloadCalendar -->
          <button type="submit" class="btn btn-outline-tertiary  mx-3 form-control-sm"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
          <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var canvasCalendar = document.getElementById('fullcalendarfilter_hidden');
  // var ctx = canvasCalendar.getContext('2d');

  $(function() {
    $('.spinner-border').css('display', 'none');
    $('.messages').css('display', 'none');
  });

  $('input[name=optionFilter]').on('click', function(e) {
    var value = e.target.value;
    if (value == 'COURSE') {
      $('.dinamicCourse').css('display', 'block');
      $('select[name=hwFilterCourse]').attr('disabled', false);
      $('select[name=hwFilterCourse]').attr('required', true);
      $('.dinamicSpace').css('display', 'none');
      $('select[name=hwFilterActivitySpace]').attr('disabled', true);
      $('select[name=hwFilterActivitySpace]').attr('required', false);
      $('.dinamicActivity').css('display', 'none');
      $('select[name=hwFilterActivityOnly]').attr('disabled', true);
      $('select[name=hwFilterActivityOnly]').attr('required', false);
      $('.dinamicCollaborator').css('display', 'none');
      $('select[name=hwFilterCollaborator]').attr('disabled', true);
      $('select[name=hwFilterCollaborator]').attr('required', false);
      $('.dinamicHour').css('display', 'none');
      $('select[name=hwFilterHour]').attr('disabled', true);
      $('select[name=hwFilterHour]').attr('required', false);
      $('.dinamicDay').css('display', 'none');
      $('input[name=hwFilterDay]').attr('disabled', true);
      $('input[name=hwFilterDay]').attr('required', false);
    } else if (value == 'SPACE') {
      $('.dinamicCourse').css('display', 'none');
      $('select[name=hwFilterCourse]').attr('disabled', true);
      $('select[name=hwFilterCourse]').attr('required', false);
      $('.dinamicSpace').css('display', 'block');
      $('select[name=hwFilterActivitySpace]').attr('disabled', false);
      $('select[name=hwFilterActivitySpace]').attr('required', true);
      $('.dinamicActivity').css('display', 'none');
      $('select[name=hwFilterActivityOnly]').attr('disabled', true);
      $('select[name=hwFilterActivityOnly]').attr('required', false);
      $('.dinamicCollaborator').css('display', 'none');
      $('select[name=hwFilterCollaborator]').attr('disabled', true);
      $('select[name=hwFilterCollaborator]').attr('required', false);
      $('.dinamicHour').css('display', 'none');
      $('select[name=hwFilterHour]').attr('disabled', true);
      $('select[name=hwFilterHour]').attr('required', false);
      $('.dinamicDay').css('display', 'none');
      $('input[name=hwFilterDay]').attr('disabled', true);
      $('input[name=hwFilterDay]').attr('required', false);
    } else if (value == 'ACTIVITY') {
      $('.dinamicCourse').css('display', 'none');
      $('select[name=hwFilterCourse]').attr('disabled', true);
      $('select[name=hwFilterCourse]').attr('required', false);
      $('.dinamicSpace').css('display', 'none');
      $('select[name=hwFilterActivitySpace]').attr('disabled', true);
      $('select[name=hwFilterActivitySpace]').attr('required', false);
      $('.dinamicActivity').css('display', 'block');
      $('select[name=hwFilterActivityOnly]').attr('disabled', false);
      $('select[name=hwFilterActivityOnly]').attr('required', true);
      $('.dinamicCollaborator').css('display', 'none');
      $('select[name=hwFilterCollaborator]').attr('disabled', true);
      $('select[name=hwFilterCollaborator]').attr('required', false);
      $('.dinamicHour').css('display', 'none');
      $('select[name=hwFilterHour]').attr('disabled', true);
      $('select[name=hwFilterHour]').attr('required', false);
      $('.dinamicDay').css('display', 'none');
      $('input[name=hwFilterDay]').attr('disabled', true);
      $('input[name=hwFilterDay]').attr('required', false);
    } else if (value == 'COLLABORATOR') {
      $('.dinamicCourse').css('display', 'none');
      $('select[name=hwFilterCourse]').attr('disabled', true);
      $('select[name=hwFilterCourse]').attr('required', false);
      $('.dinamicSpace').css('display', 'none');
      $('select[name=hwFilterActivitySpace]').attr('disabled', true);
      $('select[name=hwFilterActivitySpace]').attr('required', false);
      $('.dinamicActivity').css('display', 'none');
      $('select[name=hwFilterActivityOnly]').attr('disabled', true);
      $('select[name=hwFilterActivityOnly]').attr('required', false);
      $('.dinamicCollaborator').css('display', 'block');
      $('select[name=hwFilterCollaborator]').attr('disabled', false);
      $('select[name=hwFilterCollaborator]').attr('required', true);
      $('.dinamicHour').css('display', 'none');
      $('select[name=hwFilterHour]').attr('disabled', true);
      $('select[name=hwFilterHour]').attr('required', false);
      $('.dinamicDay').css('display', 'none');
      $('input[name=hwFilterDay]').attr('disabled', true);
      $('input[name=hwFilterDay]').attr('required', false);
    } else if (value == 'HOUR') {
      $('.dinamicCourse').css('display', 'none');
      $('select[name=hwFilterCourse]').attr('disabled', true);
      $('select[name=hwFilterCourse]').attr('required', false);
      $('.dinamicSpace').css('display', 'none');
      $('select[name=hwFilterActivitySpace]').attr('disabled', true);
      $('select[name=hwFilterActivitySpace]').attr('required', false);
      $('.dinamicActivity').css('display', 'none');
      $('select[name=hwFilterActivityOnly]').attr('disabled', true);
      $('select[name=hwFilterActivityOnly]').attr('required', false);
      $('.dinamicCollaborator').css('display', 'none');
      $('select[name=hwFilterCollaborator]').attr('disabled', true);
      $('select[name=hwFilterCollaborator]').attr('required', false);
      $('.dinamicHour').css('display', 'block');
      $('select[name=hwFilterHour]').attr('disabled', false);
      $('select[name=hwFilterHour]').attr('required', true);
      $('.dinamicDay').css('display', 'none');
      $('input[name=hwFilterDay]').attr('disabled', true);
      $('input[name=hwFilterDay]').attr('required', false);
    } else if (value == 'DAY') {
      $('.dinamicCourse').css('display', 'none');
      $('select[name=hwFilterCourse]').attr('disabled', true);
      $('select[name=hwFilterCourse]').attr('required', false);
      $('.dinamicSpace').css('display', 'none');
      $('select[name=hwFilterActivitySpace]').attr('disabled', true);
      $('select[name=hwFilterActivitySpace]').attr('required', false);
      $('.dinamicActivity').css('display', 'none');
      $('select[name=hwFilterActivityOnly]').attr('disabled', true);
      $('select[name=hwFilterActivityOnly]').attr('required', false);
      $('.dinamicCollaborator').css('display', 'none');
      $('select[name=hwFilterCollaborator]').attr('disabled', true);
      $('select[name=hwFilterCollaborator]').attr('required', false);
      $('.dinamicHour').css('display', 'none');
      $('select[name=hwFilterHour]').attr('disabled', true);
      $('select[name=hwFilterHour]').attr('required', false);
      $('.dinamicDay').css('display', 'block');
      $('input[name=hwFilterDay]').attr('disabled', false);
      $('input[name=hwFilterDay]').attr('required', true);
    }
  });

  $('.filterHourweek-link').on('click', function() {
    $('#filterHourweek-Modal').modal();
  });

  $('#confirmNewHour').on('click', function() {

    var dateInitial = $('input[name=hwDateInitial]').val();
    var dateFinal = $('input[name=hwDateFinal]').val();
    var dateSelected = $('span.dateSelected-modal').text();
    var hourInitialSelected = $('input[name=hwHourInitial-modal]').val();
    var hourFinalSelected = $('input[name=hwHourFinal-modal]').val();
    var daySelected = getNumberDay($('.hwDay-modal:first').text());
    var classSelected = $('select[name=hwActivityClass-modal]').val();
    var spaceSelected = $('select[name=hwActivitySpace-modal]').val();
    // var collaboratorSelected = $('input[name=hwCollaborator-hidden]').val();
    var courseSelected = $('select[name=hwCourse] option:selected').val();
    var allDays = $('input[name=optionAllDays]:checked').val();
    var collaboratorSelected = $('select[name=hwCollaborator-modal] option:selected').val();

    // console.log('FECHA INICIAL: ' + dateInitial);
    // console.log('FECHA FINAL: ' + dateFinal);
    // console.log('FECHA SELECCIONADA: ' + dateSelected);
    // console.log('HORA INICIAL SELECCIONADA: ' + hourInitialSelected);
    // console.log('HORA FINAL SELECCIONADA: ' + hourFinalSelected);
    // console.log('DIA SELECCIONADO CON METODO: ' + daySelected);
    // console.log('DIA SELECCIONADO SIN METODO: ' + $('span.hwDay-modal').text());
    // console.log('CLASE SELECCIONADA: ' + classSelected);
    // console.log('ESPACIO SELECCIONADO: ' + spaceSelected);
    // console.log('COLABORADOR SELECCIONADO: ' + collaboratorSelected);
    // console.log('CURSO SELECCIONADA: ' + courseSelected);

    if (
      dateInitial != '' && dateInitial != null &&
      dateFinal != '' && dateFinal != null &&
      dateSelected != '' && dateSelected != null &&
      hourInitialSelected != '' && hourInitialSelected != null &&
      hourFinalSelected != '' && hourFinalSelected != null &&
      daySelected != '' && daySelected != null &&
      classSelected != '' && classSelected != null &&
      spaceSelected != '' && spaceSelected != null &&
      collaboratorSelected != '' && collaboratorSelected != null &&
      courseSelected != '' && courseSelected != null &&
      allDays != '' && allDays != null
    ) {
      $.get(
        "{{ route('saveHourweek') }}", {
          dateInitial: dateInitial,
          dateFinal: dateFinal,
          date: dateSelected,
          hourInitial: hourInitialSelected,
          hourFinal: hourFinalSelected,
          day: daySelected,
          class: classSelected,
          space: spaceSelected,
          collaborator: collaboratorSelected,
          course: courseSelected,
          allDays: allDays
        },
        function(response) {
          $('.dateSelected-modal').text('');
          $('span.hwDay-modal').text('');
          $('input[name=hwHourInitial-modal]').val('');
          $('input[name=hwHourFinal-modal]').val('');
          $('select[name=hwActivityClass-modal] option:first').attr('selected', true);
          $('select[name=hwActivitySpace-modal] option:first').attr('selected', true);
          $('select[name=hwCollaborator-modal]').val('');
          $('#newHourweek-Modal').modal('hide');
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.messages').empty();
          $('.messages').css('display', 'block');
          $('.messages').append(response);
          //$('#fullcalendarweek').resize();
          //$('#fullcalendarweek').fullCalendar('refetchEvents');
          //$('#fullcalendarweek').fullCalendar('render');
          //$('#fullcalendarweek').css({ position: 'relative', visibility: 'visible' }).fullCalendar('render');
        }
      );
    }
  });

  $('select[name=hwCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    $.get("{{ route('getInfoCourseConsolidated') }}", {
      courseSelected: courseSelected
    }, function(objectInfo) {
      if (objectInfo != null && objectInfo != '') {
        $('input[name=hwGrade]').val('');
        $('input[name=hwGrade]').val(objectInfo['nameGrade']);
        $('input[name=hwCollaborator-hidden]').val('');
        $('input[name=hwCollaborator-hidden]').val(objectInfo['idCollaborator']);
        $('input[name=hwCollaborator]').val('');
        $('input[name=hwCollaborator]').val(objectInfo['nameCollaborator']);
        $('input[name=hwStatus]').val('');
        $('input[name=hwStatus]').val(objectInfo['ccStatus']);
        $('input[name=hwDateInitial]').val('');
        $('input[name=hwDateInitial]').val(objectInfo['ccDateInitial']);
        $('input[name=hwDateFinal]').val('');
        $('input[name=hwDateFinal]').val(objectInfo['ccDateFinal']);
      }
    });
  });

  $('input[name=hwDateInitial]').on('change', function() {
    console.log($(this).val());
    $('input[name=hwDateInitial-modal]').val('');
    $('input[name=hwDateInitial-modal]').val($(this).val());
  });
  $('input[name=hwDateFinal]').on('change', function() {
    var dateFinalSelected = $(this).val().split('/');
    var monthDateFinal = dateFinalSelected[1];
    var dayDateFinal = dateFinalSelected[2];
    $('input[name=hwDateFinal-modal]').val('');
    $('input[name=hwDateFinal-modal]').val($(this).val());
  });

  function ramdonColor(pos) {
    var colors = ['#ff550060', '#62770060', '#0086f960', '#fd870160', '#a4b06860', '#85c4f960'];
    return colors[pos];
  }

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('fullcalendarweek');
    //var btnAgenda = document.getElementById('btn-agenda');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'timeGrid'],
      //timeZone: 'UTC',
      // defaultView: 'timeGridWeek',
      defaultView: 'timeGridWeek',
      allDaySlot: true,
      //eventLimit: 6,
      allDayText: 'all-day',
      slotEventOverlap: false,
      minTime: "07:00",
      maxTime: "17:00",
      slotDuration: '00:15:00',
      // timeGridEventMinHeight: 30,
      nowIndicator: false,
      timeFormat: 'h(:mm)t',

      hour: 'numeric',
      minute: '2-digit',
      meridiem: false,

      eventOrder: '-duration',

      editable: false,
      selectable: false,
      header: {
        left: 'prev,next today',
        center: 'title'
      },
      events: {
        url: "{{ route('getAllHourWeek') }}",
        backgroundColor: ramdonColor(Math.floor(Math.random() * 5))
      },
      eventClick: function(info) {

        $.get("{{ route('getDetailsHourweek') }}", {
          hwId: info.event.id
        }, function(objectInfo) {

          $('input[name=hwIdDelete]').val('');
          $('input[name=hwIdDelete]').val(info.event.id);
          $('.nameCourse-modalDetails').text('');
          $('.nameCourse-modalDetails').text(objectInfo['name']);
          $('.hwDate-modalDetails').text('');
          $('.hwDate-modalDetails').text(objectInfo['hwDate']);
          $('.hwDay-modalDetails').text('');
          $('.hwDay-modalDetails').text(getDayString(parseInt(objectInfo['hwDay'])));
          $('.hwHourInitial-modalDetails').text('');
          $('.hwHourInitial-modalDetails').text(objectInfo['hwHourInitial']);
          $('.hwHourFinal-modalDetails').text('');
          $('.hwHourFinal-modalDetails').text(objectInfo['hwHourFinal']);
          $('.hwActivityClass-modalDetails').text('');
          $('.hwActivityClass-modalDetails').text(objectInfo['acClass']);
          $('.hwActivitySpace-modalDetails').text('');
          $('.hwActivitySpace-modalDetails').text(objectInfo['asSpace']);

          $('#detailsHourweek-Modal').modal();
        });
      },
      eventDrop: function(info) {

      },
      dateClick: function(info) {

        if ($('select[name=hwCourse] option:selected').val() != '' && $('input[name=hwDateInitial]').val() != '' && $('input[name=hwDateFinal]').val() != '') {

          //console.log('FECHA DE PRUEBA: ' + dateCompleteNow($('input[name=hwDateInitial]').val()));

          var dateInitial = dateCompleteNow($('input[name=hwDateInitial]').val().replace(/-/g, '\/'));
          var dateFinal = dateCompleteNow($('input[name=hwDateFinal]').val().replace(/-/g, '\/'));
          var dateSelected = dateCompleteNow(info.dateStr);
          var courseSelectedId = $('select[name=hwCourse] option:selected').val();
          var courseSelectedText = $('select[name=hwCourse] option:selected').text();
          //console.log(dateInitial + ' ' + dateFinal + ' ' + dateSelected + ' ACTUAL: ' + dateCompleteNow());
          //onlyDate(info.dateStr);
          //onlyDate($('input[name=hwDateInitial]').val());

          if (onlyDate(info.dateStr) >= onlyDate($('input[name=hwDateInitial]').val()) && onlyDate(info.dateStr) <= onlyDate($('input[name=hwDateFinal]').val())) {

            $('.dateSelected-modal').text('');
            $('.dateSelected-modal').text(onlyDate(info.dateStr));

            $('.nameCourseSelected-modal').text(courseSelectedText);
            var separatedInitial = dateInitial.split('-');
            var separatedFinal = dateFinal.split('-');
            var separatedSelected = dateSelected.split('-');
            $('.dateSelected-modalInfo').text(separatedSelected[4] + ', ' + onlyDate(info.dateStr));
            $('input[name=hwDateInitial-modal]').val('');
            $('input[name=hwDateInitial-modal]').val(separatedInitial[2] + ' de ' + separatedInitial[1]);
            $('input[name=hwDateFinal-modal]').val('');
            $('input[name=hwDateFinal-modal]').val(separatedFinal[2] + ' de ' + separatedFinal[1]);

            $('span.hwDay-modal').text('');
            $('span.hwDay-modal').text(separatedSelected[4]);
            $('input[name=hwHourInitial-modal]').val('');
            $('input[name=hwHourInitial-modal]').val(separatedSelected[3]);

            $('#newHourweek-Modal').modal();
            $('.messages').empty();
            $('.messages').css('display', 'none');
          } else {
            $("html, body").animate({
              scrollTop: 0
            }, "slow");
            $('.messages').empty();
            $('.messages').css('display', 'block');
            $('.messages').append('Ha seleccionado una fecha fuera del rango de fechas seleccionado');
          }
        } else {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.messages').empty();
          $('.messages').css('display', 'block');
          $('.messages').append('Asegurese primero de establecer un rango de fechas seleccionando un curso');
        }
      },
      select: function(info) {

      }
    });
    calendar.setOption('locale', 'es');
    calendar.render();

    //new Draggable(btnAgenda);
  });

  function dateCompleteNow(date = '') {
    if (date == '') {
      var now = new Date();
      var month = now.getMonth() + 1;
      var dayMonth = now.getDate();
      var hour = now.getHours();
      var minutes = now.getMinutes();
      var monthString = getMonthString((month < 10 ? '0' : '') + month);

      var dateCompleted = now.getFullYear() + '-' +
        getMonthString(now.getUTCMonth()) + '-' +
        (dayMonth < 10 ? '0' : '') + dayMonth + '-' +
        (hour < 10 ? '0' : '') + hour + ':' +
        (minutes < 10 ? '0' : '') + minutes;

    } else {
      //var now = new Date(date.replace(/-/g, '\/'));
      var now = new Date(date);
      //console.log('FORMATO: ' + now.toLocaleString('en-US'));
      var month = now.getMonth() + 1;
      var dayWeek = now.getDay();
      var dayMonth = now.getDate();
      var hour = now.getHours();
      var minutes = now.getMinutes();
      var monthString = getMonthString(now.getUTCMonth());
      //var monthString = getMonthString((month<10 ? '0' : '') + month);
      //console.log('NUMERO DE MES: ' + month + ' NOMBRE DE MES: ' + monthString);

      var dateCompleted = now.getFullYear() + '-' +
        getMonthString(now.getUTCMonth()) + '-' +
        (dayMonth < 10 ? '0' : '') + dayMonth + '-' +
        (hour < 10 ? '0' : '') + hour + ':' +
        (minutes < 10 ? '0' : '') + minutes + '-' +
        getDayString(dayWeek);
    }
    return dateCompleted;
  }

  function onlyDate(date = '') {
    if (date == '') {
      var now = new Date();
      var month = now.getMonth() + 1;
      var dayMonth = now.getDate();

      var dateComplete = now.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + dayMonth;

    } else {
      var now = new Date(date);
      //console.log('FORMATO: ' + now.toLocaleString('en-US'));
      var month = now.getMonth() + 1;
      var day = now.getDate();
      var dateComplete = now.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    }
    return dateComplete;
  }

  function getDayString(value) {
    switch (value) {
      case 0:
        return 'DOMINGO';
        break;
      case 1:
        return 'LUNES';
        break;
      case 2:
        return 'MARTES';
        break;
      case 3:
        return 'MIERCOLES';
        break;
      case 4:
        return 'JUEVES';
        break;
      case 5:
        return 'VIERNES';
        break;
      case 6:
        return 'SABADO';
        break;
    }
  }

  function getNumberDay(value) {
    switch (value) {
      case 'DOMINGO':
        return 0;
        break;
      case 'LUNES':
        return 1;
        break;
      case 'MARTES':
        return 2;
        break;
      case 'MIERCOLES':
        return 3;
        break;
      case 'JUEVES':
        return 4;
        break;
      case 'VIERNES':
        return 5;
        break;
      case 'SABADO':
        return 6;
        break;
    }
  }

  function getMonthString(value) {
    switch (value) {
      case 0:
        return 'ENERO';
        break;
      case 1:
        return 'FEBRERO';
        break;
      case 2:
        return 'MARZO';
        break;
      case 3:
        return 'ABRIL';
        break;
      case 4:
        return 'MAYO';
        break;
      case 5:
        return 'JUNIO';
        break;
      case 6:
        return 'JULIO';
        break;
      case 7:
        return 'AGOSTO';
        break;
      case 8:
        return 'SEPTIEMBRE';
        break;
      case 9:
        return 'OCTUBRE';
        break;
      case 10:
        return 'NOVIEMBRE';
        break;
      case 11:
        return 'DICIEMBRE';
        break;
    }
  }

  $('.btn-filterSpace').on('click', function() {
    var value = $('select[name=hwFilterActivitySpace]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('SPACE', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  $('.btn-filterACtivity').on('click', function() {
    var value = $('select[name=hwFilterActivityOnly]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('ACTIVITY', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  $('.btn-filterCourse').on('click', function() {
    var value = $('select[name=hwFilterCourse]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('COURSE', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  $('.btn-filterCollaborator').on('click', function() {
    var value = $('select[name=hwFilterCollaborator]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('COLLABORATOR', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  $('.btn-filterHour').on('click', function() {
    var value = $('select[name=hwFilterHour]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('HOUR', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  $('.btn-filterDay').on('click', function() {
    var value = $('input[name=hwFilterDay]').val();
    if (value != '') {
      $('.spinner-border').css('display', 'block');
      $('#fullcalendarfilter').empty();
      buildCalendar('DAY', value);
      $('.spinner-border').css('display', 'none');
      $('.btn-downloadCalendar').css('display', 'block');
    } else {
      $('.spinner-border').css('display', 'none');
      $('#fullcalendarfilter').empty();
      $('.btn-downloadCalendar').css('display', 'none');
    }
  });

  function buildCalendar(type, filter) {
    var calendar = document.getElementById('fullcalendarfilter');
    var call = new FullCalendar.Calendar(calendar, {
      plugins: ['interaction', 'timeGrid'],
      defaultView: 'timeGridWeek',
      allDaySlot: true,
      allDayText: 'all-day',
      slotEventOverlap: false,
      minTime: "07:00",
      maxTime: "17:00",
      slotDuration: '00:15:00',
      timeGridEventMinHeight: 30,
      nowIndicator: false,
      timeFormat: 'h(:mm)t',
      hour: 'numeric',
      minute: '2-digit',
      meridiem: false,
      eventOrder: '-duration',
      editable: false,
      selectable: false,
      header: {
        left: 'prev,next today',
        center: 'title'
      },

      events: {
        url: "{{ route('getFilterHourWeek') }}",
        method: 'GET',
        extraParams: {
          type: type,
          filter: filter
        },
        backgroundColor: ramdonColor(Math.floor(Math.random() * 5)),
        textColor: '#fff'
      }
    });
    call.setOption('locale', 'es');
    call.render();
  }

  $('.btn-downloadCalendar').on('click', function(e) {
    // e.preventDefault();

    // html2canvas($('#fullcalendarfilter')).then(canvas => {
    // 	let pdf = new jsPDF();
    // 	pdf.addImage(canvas.toDataURL('image/png'), 'png', 0, 0, 211, 298);
    // 	pdf.save('horario semanal.pdf');
    // });

    // var grafic = converterGrafic();
    // var pdf = new jsPDF();
    // pdf.addImage(grafic,'png',20,40,170,90);
    // pdf.save("CALENDARIO_GENERADO_EL_" + Date() + ".pdf");

    // var options = {
    //     	"background": '#fff',
    //      format: 'PNG',
    //      pagesplit: true
    //		};
    // pdf.addImage(grafic,'png',20,40,170,90);
    // pdf.save("CALENDARIO_GENERADO_EL_" + Date() + ".pdf");
    // pdf.fromHTML('PERIODO: ' + namePeriod,20,150);
  });

  function genPDF() {
    html2canvas(document.querySelector('#fullcalendarfilter'));
  }

  function converterGrafic() {
    var imgGrafic = new Image();
    var cloneCalendar = $('#fullcalendarfilter').html();
    ctx.drawImage(cloneCalendar, 0, 0, 40, 40);
    imgGrafic.src = canvasCalendar.toDataURL("image/png");
    console.log(imgGrafic);
    return imgGrafic;
  }
</script>
@endsection