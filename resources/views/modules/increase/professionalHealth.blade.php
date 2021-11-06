@extends('modules.increase')

@section('logisticModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>PROFESIONALES DE LA SALUD</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO REGISTRO" class="btn btn-outline-success form-control-sm newProfessional-link">NUEVO REGISTRO</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de profesionales de la salud -->
      @if(session('SuccessSaveProfessionalhealth'))
      <div class="alert alert-success">
        {{ session('SuccessSaveProfessionalhealth') }}
      </div>
      @endif
      @if(session('SecondarySaveProfessionalhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveProfessionalhealth') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de profesionales de la salud -->
      @if(session('PrimaryUpdateProfessionalhealth'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateProfessionalhealth') }}
      </div>
      @endif
      @if(session('SecondaryUpdateProfessionalhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateProfessionalhealth') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de profesionales de la salud -->
      @if(session('WarningDeleteProfessionalhealth'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteProfessionalhealth') }}
      </div>
      @endif
      @if(session('SecondaryDeleteProfessionalhealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteProfessionalhealth') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>PROFESIONAL</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($professionalsHealth as $professional)
      <tr>
        <td>{{ $professional->phId }}</td>
        <td>{{ $professional->phName }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editProfessionalhealth-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $professional->phId }}</span>
            <span hidden>{{ $professional->phName }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteProfessionalhealth-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $professional->phId }}</span>
            <span hidden>{{ $professional->phName }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newProfessional-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVO PROFESIONAL DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('professionalHealth.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">PROFESIONAL:</small>
                <input type="text" name="phName" maxlength="50" class="form-control form-control-sm" required>
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

<div class="modal fade" id="editProfessionalhealth-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE PROFESIONAL DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('professionalHealth.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">PROFESIONAL:</small>
                <input type="text" name="phNameEdit" maxlength="50" class="form-control form-control-sm" title="De 50 carácteres máximo" required>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="phIdEdit" value="" required>
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

<div class="modal fade" id="deleteProfessionalhealth-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE PROFESIONAL DE LA SALUD:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">CODIGO: </small><br>
            <span class="text-muted"><b class="phIdDelete"></b></span><br>
            <small class="text-muted">PROFESIONAL: </small><br>
            <span class="text-muted"><b class="phNameDelete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('professionalHealth.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="phIdDelete" value="" required>
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

  $('.newProfessional-link').on('click', function() {
    $('#newProfessional-modal').modal();
  });

  $('.editProfessionalhealth-link').on('click', function(e) {
    e.preventDefault();
    var phId = $(this).find('span:nth-child(2)').text();
    var phName = $(this).find('span:nth-child(3)').text();
    $('input[name=phIdEdit]').val(phId);
    $('input[name=phNameEdit]').val(phName);
    $('#editProfessionalhealth-modal').modal();
  });

  $('.deleteProfessionalhealth-link').on('click', function(e) {
    e.preventDefault();
    var phId = $(this).find('span:nth-child(2)').text();
    var phName = $(this).find('span:nth-child(3)').text();
    $('.phIdDelete').text(phId);
    $('.phNameDelete').text(phName);
    $('input[name=phIdDelete]').val(phId);
    $('#deleteProfessionalhealth-modal').modal();
  });
</script>
@endsection