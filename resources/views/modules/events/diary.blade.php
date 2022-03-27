@extends('modules.events')

@section('eventsModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>AGENDAMIENTO DE EVENTOS</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO AGENDAMIENTO" class="btn btn-outline-success form-control-sm newEventDiary-link">NUEVO AGENDAMIENTO</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de agendamiento de eventos -->
      @if(session('SuccessSaveEventdiary'))
      <div class="alert alert-success">
        {{ session('SuccessSaveEventdiary') }}
      </div>
      @endif
      @if(session('SecondarySaveEventdiary'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveEventdiary') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de agendamiento de eventos -->
      @if(session('PrimaryUpdateEventdiary'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateEventdiary') }}
      </div>
      @endif
      @if(session('SecondaryUpdateEventdiary'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateEventdiary') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de agendamiento de eventos -->
      @if(session('WarningDeleteEventdiary'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteEventdiary') }}
      </div>
      @endif
      @if(session('SecondaryDeleteEventdiary'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteEventdiary') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>TIPO DE EVENTO</th>
        <th>HORAS</th>
        <th>RESPONSABLE</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach($events as $event)
      <tr>
        <td>{{ $row++ }}</td>
        <td>{{ $event->edDate }}</td>
        <td>{{ $event->nameCreation }}</td>
        <td>{{ $event->edStart . ' - ' . $event->edEnd }}</td>
        <td>{{ $event->nameCollaborator }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editEventDiary-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $event->edId }}</span>
            <span hidden>{{ $event->edDate }}</span>
            <span hidden>{{ $event->edStart }}</span>
            <span hidden>{{ $event->edEnd }}</span>
            <span hidden>{{ $event->edCollaborator_id }}</span>
            <span hidden>{{ $event->nameCollaborator }}</span>
            <span hidden>{{ $event->edCreation_id }}</span>
            <span hidden>{{ $event->nameCreation }}</span>
            <span hidden>{{ $event->edStudents }}</span>
            <span hidden>{{ $event->edDescription }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteEventDiary-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $event->edId }}</span>
            <span hidden>{{ $event->edDate }}</span>
            <span hidden>{{ $event->edStart }}</span>
            <span hidden>{{ $event->edEnd }}</span>
            <span hidden>{{ $event->edCollaborator_id }}</span>
            <span hidden>{{ $event->nameCollaborator }}</span>
            <span hidden>{{ $event->edCreation_id }}</span>
            <span hidden>{{ $event->nameCreation }}</span>
            <span hidden>{{ $event->edStudents }}</span>
            <span hidden>{{ $event->edDescription }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newEventDiary-modal">
  <div class="modal-dialog lg-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVO AGENDAMIENTO DE EVENTO:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('diary.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">FECHA DE EVENTO:</small>
                <input type="text" name="edDate" class="form-control form-control-sm datepicker" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">HORA (Desde):</small>
                    <input type="time" name="edStart" class="form-control form-control-sm" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">HORA (Hasta):</small>
                    <input type="time" name="edEnd" class="form-control form-control-sm" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">RESPONSABLE:</small>
                <select name="edCollaborator_id" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un colaborador...</option>
                  @foreach($collaborators as $collaborator)
                  <option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">TIPO DE EVENTO:</small>
                <select name="edCreation_id" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un tipo de evento...</option>
                  @foreach($creations as $creation)
                  <option value="{{ $creation->crId }}">{{ $creation->crName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">ALUMNO (Opcional):</small><br>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group ml-3">
                    <small class="text-muted">
                      <input type="radio" name="activeStudent" value="NO" checked>
                      NO
                    </small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">
                      <input type="radio" name="activeStudent" value="SI">
                      SI
                    </small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group selectStudent" style="display: none;">
                <small class="text-muted">SELECCIONE ALUMNO:</small>
                <select name="edStudents" class="form-control form-control-sm select2">
                  <option value="">Seleccione un alumno...</option>
                  @foreach($students as $student)
                  <option value="{{ $student->id }}">{{ $student->nameStudent }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="edDescription" cols="30" rows="5" maxlength="1000" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">GUARDAR AGENDAMIENTO</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editEventDiary-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE AGENDAMIENTO DE EVENTO:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('diary.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">FECHA DE EVENTO:</small>
                <input type="text" name="edDate_edit" class="form-control form-control-sm datepicker" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">HORA (Desde):</small>
                    <input type="time" name="edStart_edit" class="form-control form-control-sm" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">HORA (Hasta):</small>
                    <input type="time" name="edEnd_edit" class="form-control form-control-sm" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">RESPONSABLE:</small>
                <select name="edCollaborator_id_edit" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un colaborador...</option>
                  @foreach($collaborators as $collaborator)
                  <option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">TIPO DE EVENTO:</small>
                <select name="edCreation_id_edit" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione un tipo de evento...</option>
                  @foreach($creations as $creation)
                  <option value="{{ $creation->crId }}">{{ $creation->crName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">ALUMNO (Opcional):</small><br>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group ml-3">
                    <small class="text-muted">
                      <input type="radio" name="activeStudentEdit" class="NO" value="NO" checked>
                      NO
                    </small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <small class="text-muted">
                      <input type="radio" name="activeStudentEdit" class="SI" value="SI">
                      SI
                    </small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group selectStudent_edit" style="display: none;">
                <small class="text-muted">SELECCIONE ALUMNO:</small>
                <select name="edStudents_edit" class="form-control form-control-sm select2">
                  <option value="">Seleccione un alumno...</option>
                  @foreach($students as $student)
                  <option value="{{ $student->id }}">{{ $student->nameStudent }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="edDescription_edit" cols="30" rows="5" maxlength="1000" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <input type="hidden" class="form-control form-control-sm" name="edId_edit" value="" required>
            <button type="submit" class="btn btn-outline-success form-control-sm">GUARDAR AGENDAMIENTO</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteEventDiary-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE AGENDAMIENTO DE EVENTO:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">FECHA DE EVENTO: </small><br>
            <span class="text-muted"><b class="deDate_Delete"></b></span><br>
            <small class="text-muted">DESDE - HASTA: (Horas) </small><br>
            <span class="text-muted"><b class="deStart_Delete"></b></span> - <span class="text-muted"><b class="deEnd_Delete"></b></span><br>
            <small class="text-muted">RESPONSABLE: </small><br>
            <span class="text-muted"><b class="deCollaborator_Delete"></b></span><br>
            <small class="text-muted">TIPO DE EVENTO: </small><br>
            <span class="text-muted"><b class="deCreation_Delete"></b></span><br>
            <small class="text-muted">ALUMNO: </small><br>
            <span class="text-muted"><b class="deStudent_Delete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="deDescription_Delete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('diary.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="deId_Delete" value="" readonly required>
            <button type="submit" class="btn btn-outline-success form-control-sm my-3">ELIMINAR</button>
          </form>
          <div class="col-md-6">
            <button type="button" class="btn btn-outline-tertiary  mx-3 form-control-sm my-3" data-dismiss="modal">CANCELAR</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });

  //CHEQUEO DE AGENDA PARA HABILITAR O NO EL SELECT DE ALUMNOS (NUEVO)
  $('input[name=activeStudent]').on('click', function() {
    var check = $(this).val();
    if (check == 'SI') {
      $('.selectStudent').css('display', 'block');
      $('select[name=edStudents]').val('');
      $('select[name=edStudents]').attr('required', true);
    } else if (check == 'NO') {
      $('.selectStudent').css('display', 'none');
      $('select[name=edStudents]').val('');
      $('select[name=edStudents]').attr('required', false);
    }
  });
  //CHEQUEO DE AGENDA PARA NO HABILITAR EL SELECT DE ALUMNOS (MODIFICACION)
  $('input[name=activeStudentEdit]').on('click', function() {
    var clas = $(this).attr('class');
    // var check = ;
    if (clas == 'SI') {
      $('.selectStudent_edit').css('display', 'block');
      $('select[name=edStudents_edit]').val('');
      $('select[name=edStudents_edit]').attr('required', true);
    } else if (clas == 'NO') {
      $('.selectStudent_edit').css('display', 'none');
      $('select[name=edStudents_edit]').val('');
      $('select[name=edStudents_edit]').attr('required', false);
    }
  });

  $('.newEventDiary-link').on('click', function() {
    $('#newEventDiary-modal').modal();
  });

  $('.editEventDiary-link').on('click', function(e) {
    e.preventDefault();
    var edId = $(this).find('span:nth-child(2)').text();
    var edDate = $(this).find('span:nth-child(3)').text();
    var edStart = $(this).find('span:nth-child(4)').text();
    var edEnd = $(this).find('span:nth-child(5)').text();
    var edCollaborator_id = $(this).find('span:nth-child(6)').text();
    var nameCollaborator = $(this).find('span:nth-child(7)').text();
    var edCreation_id = $(this).find('span:nth-child(8)').text();
    var nameCreation = $(this).find('span:nth-child(9)').text();
    var edStudent = $(this).find('span:nth-child(10)').text();
    var edDescription = $(this).find('span:nth-child(11)').text();
    $('input[name=edId_edit]').val(edId);
    $('input[name=edDate_edit]').val(edDate);
    $('input[name=edStart_edit]').val(edStart);
    $('input[name=edEnd_edit]').val(edEnd);
    $('select[name=edCollaborator_id_edit]').val(edCollaborator_id);
    $('select[name=edCreation_id_edit]').val(edCreation_id);
    if (edStudent != '') {
      var idStudent = edStudent.split(':');
      $('input[name=activeStudentEdit]:first').attr('checked', false);
      $('input[name=activeStudentEdit]:last').attr('checked', true);
      $('.selectStudent_edit').css('display', 'block');
      $('select[name=edStudents_edit]').val(parseInt(idStudent[1]));
      $('select[name=edStudents_edit]').attr('required', true);
      console.log('ID ALUMNO: ' + idStudent[1]);
    } else {
      $('input[name=activeStudentEdit]:last').attr('checked', false);
      $('input[name=activeStudentEdit]:first').attr('checked', true);
      $('select[name=edStudents_edit]').val('');
      $('select[name=edStudents_edit]').attr('required', false);
      $('.selectStudent_edit').css('display', 'none');
    }
    $('textarea[name=edDescription_edit]').val(edDescription);

    $('#editEventDiary-modal').modal();
  });

  $('.deleteEventDiary-link').on('click', function(e) {
    e.preventDefault();
    var edId = $(this).find('span:nth-child(2)').text();
    var edDate = $(this).find('span:nth-child(3)').text();
    var edStart = $(this).find('span:nth-child(4)').text();
    var edEnd = $(this).find('span:nth-child(5)').text();
    var edCollaborator_id = $(this).find('span:nth-child(6)').text();
    var nameCollaborator = $(this).find('span:nth-child(7)').text();
    var edCreation_id = $(this).find('span:nth-child(8)').text();
    var nameCreation = $(this).find('span:nth-child(9)').text();
    var edStudent = $(this).find('span:nth-child(10)').text();
    var edDescription = $(this).find('span:nth-child(11)').text();
    $('input[name=deId_Delete]').val(edId);
    $('.deDate_Delete').text(edDate);
    $('.deStart_Delete').text(edStart);
    $('.deEnd_Delete').text(edEnd);
    $('.deCollaborator_Delete').text(nameCollaborator);
    $('.deCreation_Delete').text(nameCreation);
    if (edStudent != null) {
      $.get("{{ route('getStudentDiary') }}", {
        id: edStudent
      }, function(objectStudent) {
        if (objectStudent['nameStudent'] != null && objectStudent['nameStudent'] != '') {
          $('.deStudent_Delete').text(objectStudent['nameStudent']);
        } else {
          $('.deStudent_Delete').text('NO APLICA');
        }
      });
    } else {
      $('.deStudent_Delete').text('NO APLICA');
    }
    $('.deDescription_Delete').text(edDescription);

    $('#deleteEventDiary-modal').modal();
  });
</script>
@endsection