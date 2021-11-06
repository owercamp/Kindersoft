@extends('modules.increase')

@section('logisticModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>ESQUEMAS DE VACUNACION</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO ESQUEMA" class="btn btn-outline-success form-control-sm newVaccination-link">NUEVO ESQUEMA</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de esquemas de vacunación -->
      @if(session('SuccessSaveVaccination'))
      <div class="alert alert-success">
        {{ session('SuccessSaveVaccination') }}
      </div>
      @endif
      @if(session('SecondarySaveVaccination'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveVaccination') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de esquemas de vacunación -->
      @if(session('PrimaryUpdateVaccination'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateVaccination') }}
      </div>
      @endif
      @if(session('SecondaryUpdateVaccination'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateVaccination') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de esquemas de vacunación -->
      @if(session('WarningDeleteVaccination'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteVaccination') }}
      </div>
      @endif
      @if(session('SecondaryDeleteVaccination'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteVaccination') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>ESQUEMA DE VACUNACION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($vaccinations as $vaccination)
      <tr>
        <td>{{ $vaccination->vaId }}</td>
        <td>{{ $vaccination->vaName }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editVaccination-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $vaccination->vaId }}</span>
            <span hidden>{{ $vaccination->vaName }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteVaccination-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $vaccination->vaId }}</span>
            <span hidden>{{ $vaccination->vaName }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newVaccination-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="text-muted">NUEVO ESQUEMA:</h6>
      </div>
      <div class="modal-body">
        <form action="{{ route('vaccination.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">ESQUEMA DE VACUNACION:</small>
                <input type="text" name="vaName" maxlength="50" class="form-control form-control-sm" required>
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

<div class="modal fade" id="editVaccination-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="text-muted">MODIFICACION DE ESQUEMA:</h6>
      </div>
      <div class="modal-body">
        <form action="{{ route('vaccination.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">ESQUEMA DE VACUNACION:</small>
                <input type="text" name="vaNameEdit" maxlength="50" class="form-control form-control-sm" title="De 50 carácteres máximo" required>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="vaIdEdit" value="" required>
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

<div class="modal fade" id="deleteVaccination-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="text-muted">ELIMINACION DE ESQUEMA:</h6>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">CODIGO: </small><br>
            <span class="text-muted"><b class="vaIdDelete"></b></span><br>
            <small class="text-muted">ESQUEMA DE VACUNACION: </small><br>
            <span class="text-muted"><b class="vaNameDelete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('vaccination.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="vaIdDelete" value="" required>
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

  $('.newVaccination-link').on('click', function() {
    $('#newVaccination-modal').modal();
  });

  $('.editVaccination-link').on('click', function(e) {
    e.preventDefault();
    var vaId = $(this).find('span:nth-child(2)').text();
    var vaName = $(this).find('span:nth-child(3)').text();
    $('input[name=vaIdEdit]').val(vaId);
    $('input[name=vaNameEdit]').val(vaName);
    $('#editVaccination-modal').modal();
  });

  $('.deleteVaccination-link').on('click', function(e) {
    e.preventDefault();
    var vaId = $(this).find('span:nth-child(2)').text();
    var vaName = $(this).find('span:nth-child(3)').text();
    $('.vaIdDelete').text(vaId);
    $('.vaNameDelete').text(vaName);
    $('input[name=vaIdDelete]').val(vaId);
    $('#deleteVaccination-modal').modal();
  });
</script>
@endsection