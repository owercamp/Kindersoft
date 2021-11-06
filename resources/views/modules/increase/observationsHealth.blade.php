@extends('modules.increase')

@section('logisticModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>OBSERVACIONES DE LA SALUD</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO REGISTRO" class="btn btn-outline-success form-control-sm newObservation-link">NUEVO REGISTRO</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de observaciones de la salud -->
      @if(session('SuccessSaveObservationhealth'))
      <div class="alert alert-success">
        {{ session('SuccessSaveObservationhealth') }}
      </div>
      @endif
      @if(session('SecondarySaveObservationhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveObservationhealth') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de observaciones de la salud -->
      @if(session('PrimaryUpdateObservationhealth'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateObservationhealth') }}
      </div>
      @endif
      @if(session('SecondaryUpdateObservationhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateObservationhealth') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de observaciones de la salud -->
      @if(session('WarningDeleteObservationhealth'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteObservationhealth') }}
      </div>
      @endif
      @if(session('SecondaryDeleteObservationhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteObservationhealth') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>OBSERVACION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($observationsHealth as $observation)
      <tr>
        <td>{{ $observation->ohId }}</td>
        <td>{{ $observation->ohObservation }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editObservationhealth-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $observation->ohId }}</span>
            <span hidden>{{ $observation->ohObservation }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteObservationhealth-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $observation->ohId }}</span>
            <span hidden>{{ $observation->ohObservation }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newObservation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVA OBSERVACION DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('observationHealth.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">OBSERVACION:</small>
                <textarea type="text" name="ohObservation" maxlength="500" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">GUARDAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editObservationhealth-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE OBSERVACION DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('observationHealth.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">OBSERVACION:</small>
                <textarea type="text" name="ohObservationEdit" maxlength="500" class="form-control form-control-sm" title="De 500 carácteres máximo" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="ohIdEdit" value="" required>
              <button type="submit" class="btn btn-outline-success form-control-sm my-3">GUARDAR CAMBIOS</button>
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-outline-tertiary  mx-3 form-control-sm my-3" data-dismiss="modal">CANCELAR</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteObservationhealth-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE OBSERVACION DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">CODIGO: </small><br>
            <span class="text-muted"><b class="ohIdDelete"></b></span><br>
            <small class="text-muted">OBSERVACION: </small><br>
            <span class="text-muted"><b class="ohObservationDelete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('observationHealth.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="ohIdDelete" value="" required>
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

  $('.newObservation-link').on('click', function() {
    $('#newObservation-modal').modal();
  });

  $('.editObservationhealth-link').on('click', function(e) {
    e.preventDefault();
    var ohId = $(this).find('span:nth-child(2)').text();
    var ohObservation = $(this).find('span:nth-child(3)').text();
    $('input[name=ohIdEdit]').val(ohId);
    $('textarea[name=ohObservationEdit]').val(ohObservation);
    $('#editObservationhealth-modal').modal();
  });

  $('.deleteObservationhealth-link').on('click', function(e) {
    e.preventDefault();
    var ohId = $(this).find('span:nth-child(2)').text();
    var ohObservation = $(this).find('span:nth-child(3)').text();
    $('.ohIdDelete').text(ohId);
    $('.ohObservationDelete').text(ohObservation);
    $('input[name=ohIdDelete]').val(ohId);
    $('#deleteObservationhealth-modal').modal();
  });
</script>
@endsection