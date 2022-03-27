@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>LISTA DE REQUISITOS DE MATRICULA</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de requisito -->
      @if(session('SuccessNewDocumentsEnrollment'))
      <div class="alert alert-success">
        {{ session('SuccessNewDocumentsEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryNewDocumentsEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryNewDocumentsEnrollment') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de requisitos -->
      @if(session('PrimaryUpdateDocumentsEnrollment'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateDocumentsEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryUpdateDocumentsEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateDocumentsEnrollment') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de requisitos -->
      @if(session('WarningDeleteDocumentsEnrollment'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteDocumentsEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryDeleteDocumentsEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteDocumentsEnrollment') }}
      </div>
      @endif
    </div>
  </div>
  <table class="table text-center">
    <thead>
      <tr>
        <th><small class="text-muted"><b>POSICION</b></small></th>
        <th><small class="text-muted"><b>DOCUMENTO</b></small></th>
        <th><small class="text-muted"><b>¿OBLIGATORIO?</b></small></th>
        <th><small class="text-muted"><b>ESTADO</b></small></th>
        <th><small class="text-muted"><b>ACCIONES</b></small></th>
      </tr>
    </thead>
    <tbody>
      @foreach($documentsEnrollment as $document)
      <tr>
        @if($document->dePosition == null)
        <td class="text-muted">{{ __('N/A') }}</td>
        @else
        <td class="text-muted">{{ $document->dePosition }}</td>
        @endif
        <td class="text-muted">{{ $document->deConcept }}</td>
        <td class="text-muted">{{ $document->deRequired }}</td>
        <td class="text-muted">{{ $document->deStatus }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle updateDocumentEnrollment-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $document->deId }}</span>
            <span hidden>{{ $document->deConcept }}</span>
            <span hidden>{{ $document->deRequired }}</span>
            <span hidden>{{ $document->deStatus }}</span>
            <span hidden>{{ $document->dePosition }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteDocumentEnrollment-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $document->deId }}</span>
            <span hidden>{{ $document->deConcept }}</span>
            <span hidden>{{ $document->dePosition }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    <tfoot class="row">
      <div class="col-md-12 text-center">
        <button id="addDocumentEnrollment" type="button" class="btn btn-outline-success form-control-sm">AGREGAR REQUISITO</button>
      </div>
    </tfoot>
    </tbody>
  </table>

  <div class="modal fade" id="newDocumentEnrollment-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="text-muted">NUEVO REQUISITO DE MATRICULA:</h4>
        </div>
        <div class="modal-body">
          <form id="formNewDocumentEnrollment" action="{{ route('newDocumentEnrollment') }}" method="POST">
            @csrf
            <div class="form-group">
              <small class="text-muted">Documento/Requisito:</small>
              <input type="text" name="deConceptNew" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Es un requisito obligatorio?</small>
              <span><a href="#" title="Si se indica que NO, queda OPCIONAL al momento de que el cliente presente el documento para la matrícula"><i class="fas fa-question-circle"></i></a></span>
              <select id="deRequiredNew" class="form-control form-control-sm select2" required>
                <option value="">Seleccione...</option>
                <option value="SI" selected>SI</option>
                <option value="NO">NO</option>
              </select>
              <input type="hidden" name="deRequiredNew" class="form-control form-control-sm" readonly required>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Requisito activo/Inactivo?</small>
              <span><a href="#" title="Dependiendo de su estado ACTIVO/INACTIVO se mostrará o no como requisito al momento de realizar una matricula. En estado INACTIVO estará guardado en la base de datos pero es como si no existiera. En estado INACTIVO es una opción que se brinda para que no tenga la necesidad de eliminarlo de la lista"><i class="fas fa-question-circle"></i></a></span>
              <select name="deStatusNew" class="form-control form-control-sm select2" required>
                <option value="">Seleccione...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Posición del requisito?</small>
              <span><a href="#" title="Si el estado del nuevo requisito es ACTIVO en el campo, anterior es obligatorio indicar la posicion"><i class="fas fa-question-circle"></i></a></span>
              <select name="dePositionNew" class="form-control form-control-sm select2" required>
                <option value="">Seleccione...</option>
                @foreach($documentsEnrollment as $document)
                <option value="{{ $document->dePosition }}">{{ $document->dePosition . ' - Posicion de: ' . $document->deConcept }}</option>
                @endforeach
                <option value="{{ ($documentsCount + 1) }}" style="color: blue;" selected>{{ ($documentsCount + 1) . ' - SIGUIENTE POSICION' }}</option>
              </select>
              <center>
                <span hidden class="badgeNew text-center p-2" style="font-size: 10px; color: #000; transition: all .3s;">A partir de <b class="infoConcept">concepto</b> se aumentarán las posiciones <br> y se guardará el nuevo registro con posición <b class="infoPosition">número</b></span>
                <span class="badgeNext text-center p-2" style="font-size: 10px; color: #000; transition: all .3s;">A guardará el requisito con la siguiente posición <b class="infoPositionNext">{{ ($documentsCount + 1) }}</b></b></span>
              </center>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-outline-success form-control-sm">AÑADIR A LA LISTA</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteDocumentEnrollment-modal">
    <div class="modal-dialog">
      <form action="{{ route('deleteDocumentEnrollment') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="text-muted">SE ELIMINARÁ EL REQUISITO:</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="deIdDelete" class="form-control form-control-sm" required readonly>
            </div>
            <div class="form-group">
              <small class="text-muted">CONCEPTO:</small>
              <input type="text" name="deConceptDelete" class="form-control form-control-sm" required readonly>
            </div>
            <div class="form-group">
              <small class="text-muted">POSICION:</small>
              <input type="text" name="dePositionDelete" class="form-control form-control-sm" required readonly>
            </div>
          </div>
          <div class="modal-footer text-center">
            <button type="submit" class="btn btn-outline-primary mx-3 form-control-sm">CONTINUAR</button>
            <button type="button" class="btn btn-outline-tertiary  mx-3 form-control-sm" data-dismiss="modal">CANCELAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="updateDocumentEnrollment-modal">
    <div class="modal-dialog">
      <form id="formUpdateDocumentEnrollment" action="{{ route('updateDocumentEnrollment') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="text-muted">EDICION DE REQUISITO:</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="deIdEdit" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <small class="text-muted">Documento/Requisito:</small>
              <input type="text" name="deConceptEdit" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Es un requisito obligatorio?</small>
              <span><a href="#" title="Indique si el requisito que se añadirá es opcional o obligatorio para el cliente/persona que realizará la matricula"><i class="fas fa-question-circle"></i></a></span>
              <select id="deRequiredEdit" class="form-control form-control-sm select2" required>
                <option value="" selected>Seleccione...</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
              </select>
              <input type="hidden" name="deRequiredEdit" class="form-control form-control-sm" readonly required>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Requisito activo/Inactivo?</small>
              <span><a href="#" title="Dependiendo de su estado ACTIVO/INACTIVO se mostrará o no como requisito al momento de realizar una matricula. En estado INACTIVO estará guardado en la base de datos pero es como si no existiera. En estado INACTIVO es una opción que se brinda para que no tenga la necesidad de eliminarlo de la lista"><i class="fas fa-question-circle"></i></a></span>
              <select name="deStatusEdit" class="form-control form-control-sm select2" required>
                <option value="" selected>Seleccione...</option>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
            <div class="form-group">
              <small class="text-muted">¿Posición del requisito?</small>
              <span><a href="#" title="Si el estado del nuevo requisito es ACTIVO en el campo anterior es obligatorio indicar la posicion"><i class="fas fa-question-circle"></i></a></span>
              <select name="dePositionEdit" class="form-control form-control-sm select2" required>
                <option value="">Seleccione...</option>
                @foreach($documentsEnrollment as $document)
                <option value="{{ $document->dePosition }}">{{ $document->dePosition . ' - Posicion de: ' . $document->deConcept }}</option>
                @endforeach
              </select>
              <center>
                <span hidden class="badgeNew_edit text-center p-2" style="font-size: 10px; color: #000; transition: all .3s;">A partir de <b class="infoConcept_edit">concepto</b> se aumentarán las posiciones <br> y se guardará el nuevo registro con posición <b class="infoPosition_edit">número</b></span>
                <span hidden class="badgeNext_edit text-center p-2" style="font-size: 10px; color: #000; transition: all .3s;">A guardará el requisito con la siguiente posición <b class="infoPositionNext_edit">{{ ($documentsCount + 1) }}</b></b></span>
              </center>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary float-left form-control-sm">GUARDAR CAMBIOS</button>
            <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CANCELAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
  $(function() {


  });

  $('#deRequiredNew').on('change', function(e) {
    var selected = e.target.value;
    $('input[name=deRequiredNew]').val('');
    $('input[name=deRequiredNew]').val(selected);
  });

  $('select[name=deStatusNew]').on('change', function(e) {
    var selected = e.target.value;
    if (selected == 'INACTIVO' || selected == '') {
      $("select#deRequiredNew").val('NO');
      $('select#deRequiredNew').attr('disabled', true);
      $('select[name=dePositionNew]').val('');
      $('select[name=dePositionNew]').attr('required', false);
      $('select[name=dePositionNew]').attr('disabled', true);
      $('.badgeNew').attr('hidden', true);
      $('.infoConcept').text('');
      $('.infoPosition').text('');
    } else if (selected == 'ACTIVO') {
      $("select#deRequiredNew").val('SI');
      $('select#deRequiredNew').attr('disabled', false);
      $('select[name=dePositionNew] option:last').attr('selected', true);
      $('select[name=dePositionNew]').attr('required', true);
      $('select[name=dePositionNew]').attr('disabled', false);
    }
    $('input[name=deRequiredNew]').val($('#deRequiredNew option:selected').text());
  });

  $('select[name=dePositionNew]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $.get("{{ route('getNumberSelected') }}", {
        number: selected
      }, function(number) {
        var count = Object.keys(number).length;
        if (count > 0) {
          $('.badgeNew').attr('hidden', false);
          $('.infoConcept').text(number['deConcept']);
          $('.infoPosition').text(number['dePosition']);
          $('.badgeNext').attr('hidden', true);
          $('.infoPositionNext').text('');
        } else {
          $('.badgeNew').attr('hidden', true);
          $('.infoConcept').text('');
          $('.infoPosition').text('');
          $('.badgeNext').attr('hidden', false);
          $('.infoPositionNext').text(selected);
        }
      });
    } else {
      $('.badgeNew').attr('hidden', true);
      $('.infoConcept').text('');
      $('.infoPosition').text('');
      $('.badgeNext').attr('hidden', true);
      $('.infoPositionNext').text('');
    }
  });

  $('#deRequiredEdit').on('change', function(e) {
    var selected = e.target.value;
    $('input[name=deRequiredEdit]').val('');
    $('input[name=deRequiredEdit]').val(selected);
  });

  $('select[name=deStatusEdit]').on('change', function(e) {
    var selected = e.target.value;
    if (selected == 'INACTIVO') {
      $("select#deRequiredEdit").val('NO');
      $('#deRequiredEdit').attr('disabled', true);
      $('select[name=dePositionEdit]').val('');
      $('select[name=dePositionEdit]').attr('required', false);
      $('select[name=dePositionEdit]').attr('disabled', true);
      $('.badgeNew_edit').attr('hidden', true);
      $('.infoConcept_edit').text('');
      $('.infoPosition_edit').text('');
    } else if (selected == 'ACTIVO') {
      $("select#deRequiredEdit").val('SI');
      $('#deRequiredEdit').attr('disabled', false);
    }
    $('input[name=deRequiredEdit]').val($('#deRequiredEdit option:selected').text());
  });


  $('#addDocumentEnrollment').on('click', function() {
    $('input[name=deConceptNew]').val('');
    $('input[name=deRequiredNew]').val('');
    $('input[name=deRequiredNew]').val($('#deRequiredNew option:selected').text());
    $('#newDocumentEnrollment-modal').modal();
  });



  $('.deleteDocumentEnrollment-link').on('click', function() {
    var id = $(this).find('span:nth-child(2)').text();
    var conceptToDelete = $(this).find('span:nth-child(3)').text();
    var positionToDelete = $(this).find('span:nth-child(4)').text();
    $('input[name=deIdDelete]').val('');
    $('input[name=deIdDelete]').val(id);
    $('input[name=deConceptDelete]').val('');
    $('input[name=deConceptDelete]').val(conceptToDelete);
    $('input[name=dePositionDelete]').val('');
    if (positionToDelete == '') {
      $('input[name=dePositionDelete]').val('N/A');
    } else {
      $('input[name=dePositionDelete]').val(positionToDelete);
    }
    $('#deleteDocumentEnrollment-modal').modal();
  });



  $('.updateDocumentEnrollment-link').on('click', function() {
    $('#formUpdateDocumentEnrollment')[0].reset();
    var id = $(this).find('span:nth-child(2)').text();
    var conceptToEdit = $(this).find('span:nth-child(3)').text();
    var requiredToEdit = $(this).find('span:nth-child(4)').text();
    var statusToEdit = $(this).find('span:nth-child(5)').text();
    var positionToEdit = $(this).find('span:nth-child(6)').text();
    $('input[name=deIdEdit]').val(id);
    $('input[name=deConceptEdit]').val(conceptToEdit);
    if (requiredToEdit == 'SI') {
      $("#deRequiredEdit option[value=NO]").attr('selected', false);
      $("#deRequiredEdit option[value=SI]").attr('selected', true);
      $("#deRequiredEdit").attr('disabled', false);
    } else if (requiredToEdit == 'NO') {
      $("#deRequiredEdit option[value=SI]").attr('selected', false);
      $("#deRequiredEdit option[value=NO]").attr('selected', true);
    }
    if (statusToEdit == 'ACTIVO') {
      $("select[name=deStatusEdit] option[value=INACTIVO]").attr('selected', false);
      $("select[name=deStatusEdit] option[value=ACTIVO]").attr('selected', true);
    } else if (statusToEdit == 'INACTIVO') {
      $("select[name=deStatusEdit] option[value=ACTIVO]").attr('selected', false);
      $("select[name=deStatusEdit] option[value=INACTIVO]").attr('selected', true);
      $("#deRequiredEdit").attr('disabled', true);
    }
    $("select[name=dePositionEdit]").val(positionToEdit);
    $('input[name=deRequiredEdit]').val($('#deRequiredEdit option:selected').text());
    $('#updateDocumentEnrollment-modal').modal();
  });
</script>
@endsection