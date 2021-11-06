@extends('modules.events')

@section('eventsModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>CREACION DE EVENTOS</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO REGISTRO" class="btn btn-outline-success form-control-sm newCreation-link">NUEVO REGISTRO</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de creaciones -->
      @if(session('SuccessSaveCreation'))
      <div class="alert alert-success">
        {{ session('SuccessSaveCreation') }}
      </div>
      @endif
      @if(session('SecondarySaveCreation'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveCreation') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de creaciones -->
      @if(session('PrimaryUpdateCreation'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateCreation') }}
      </div>
      @endif
      @if(session('SecondaryUpdateCreation'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateCreation') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de creaciones -->
      @if(session('WarningDeleteCreation'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteCreation') }}
      </div>
      @endif
      @if(session('SecondaryDeleteCreation'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteCreation') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>EVENTO</th>
        <th>DESCRIPCION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach($creations as $creation)
      <tr>
        <td>{{ $row++ }}</td>
        <td>{{ $creation->crName }}</td>
        <td>{{ $creation->crDescription }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editCreation-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $creation->crId }}</span>
            <span hidden>{{ $creation->crName }}</span>
            <span hidden>{{ $creation->crDescription }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteCreation-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $creation->crId }}</span>
            <span hidden>{{ $creation->crName }}</span>
            <span hidden>{{ $creation->crDescription }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newCreation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVA CREACION:</h4>
      </div>
      <div class="modal-body">
        <form id="formNewCreation" action="{{ route('creation.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">NOMBRE DE EVENTO:</small>
                <input type="text" name="crName" maxlength="50" class="form-control form-control-sm" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="crDescription" cols="30" rows="2" maxlength="200" class="form-control form-control-sm" required></textarea>
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

<div class="modal fade" id="editCreation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE CREACION:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('creation.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">NOMBRE DE EVENTO:</small>
                <input type="text" name="crNameEdit" maxlength="50" class="form-control form-control-sm" title="De 50 carácteres máximo" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="crDescriptionEdit" cols="30" rows="2" maxlength="200" class="form-control form-control-sm" title="De 200 carácteres máximo" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="crIdEdit" value="" required>
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

<div class="modal fade" id="deleteCreation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE CREACION:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">NOMBRE DE EVENTO: </small><br>
            <span class="text-muted"><b class="crNameDelete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="crDescriptionDelete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('creation.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="crIdDelete" value="" required>
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

  $('.newCreation-link').on('click', function() {
    $('#newCreation-modal').modal();
  });

  $('.editCreation-link').on('click', function(e) {
    e.preventDefault();
    var crId = $(this).find('span:nth-child(2)').text();
    var crName = $(this).find('span:nth-child(3)').text();
    var crDescription = $(this).find('span:nth-child(4)').text();
    $('input[name=crIdEdit]').val(crId);
    $('input[name=crNameEdit]').val(crName);
    $('textarea[name=crDescriptionEdit]').val(crDescription);
    $('#editCreation-modal').modal();
  });

  $('.deleteCreation-link').on('click', function(e) {
    e.preventDefault();
    var crId = $(this).find('span:nth-child(2)').text();
    var crName = $(this).find('span:nth-child(3)').text();
    var crDescription = $(this).find('span:nth-child(4)').text();
    $('input[name=crIdDelete]').val(crId);
    $('.crNameDelete').text(crName);
    $('.crDescriptionDelete').text(crDescription);
    $('#deleteCreation-modal').modal();
  });
</script>
@endsection