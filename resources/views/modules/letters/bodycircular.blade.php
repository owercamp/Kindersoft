@extends('modules.circulars')

@section('logisticModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h3>CREACION DE CUERPOS</h3>
    </div>
    <div class="col-md-4">
      <button type="button" title="NUEVO REGISTRO" class="btn btn-outline-success form-control-sm newBody-link">NUEVO
        REGISTRO</button>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de cuerpos -->
      @if (session('SuccessSaveBody'))
      <div class="alert alert-success">
        {{ session('SuccessSaveBody') }}
      </div>
      @endif
      @if (session('SecondarySaveBody'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveBody') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de cuerpos -->
      @if (session('PrimaryUpdateBody'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateBody') }}
      </div>
      @endif
      @if (session('SecondaryUpdateBody'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateBody') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de cuerpos -->
      @if (session('WarningDeleteBody'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteBody') }}
      </div>
      @endif
      @if (session('SecondaryDeleteBody'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteBody') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table-hover table text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach ($bodys as $body)
      <tr>
        <td>{{ $row++ }}</td>
        <td>{{ $body->bcName }}</td>
        <td>{{ $body->bcDescription }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editBody-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $body->bcId }}</span>
            <span hidden>{{ $body->bcName }}</span>
            <span hidden>{{ $body->bcDescription }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle deleteBody-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $body->bcId }}</span>
            <span hidden>{{ $body->bcName }}</span>
            <span hidden>{{ $body->bcDescription }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newBody-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVO CUERPO:</h4>
      </div>
      <div class="modal-body">
        <form id="formNewBody" action="{{ route('body.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">NOMBRE DE CUERPO:</small>
                <input type="text" name="bcName" maxlength="50" class="form-control form-control-sm" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="bcDescription" cols="30" rows="2" maxlength="1000" class="form-control form-control-sm" required></textarea>
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

<div class="modal fade" id="editBody-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE CUERPO:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('body.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">NOMBRE DE CUERPO:</small>
                <input type="text" name="bcNameEdit" maxlength="50" class="form-control form-control-sm" title="De 50 carácteres máximo" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="bcDescriptionEdit" cols="30" rows="2" maxlength="200" class="form-control form-control-sm" title="De 200 carácteres máximo" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="bcIdEdit" value="" required>
              <button type="submit" class="btn btn-outline-success form-control-sm my-3">GUARDAR
                CAMBIOS</button>
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-outline-tertiary form-control-sm mx-3 my-3" data-dismiss="modal">CANCELAR</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteBody-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE CUERPO:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">NOMBRE DE CUERPO: </small><br>
            <span class="text-muted"><b class="bcNameDelete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="bcDescriptionDelete"></b></span>
          </div>
        </div>
        <div class="row border-top mt-3 text-center">
          <form action="{{ route('body.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="bcIdDelete" value="" required>
            <button type="submit" class="btn btn-outline-success form-control-sm my-3">ELIMINAR</button>
          </form>
          <div class="col-md-6">
            <button type="button" class="btn btn-outline-tertiary form-control-sm mx-3 my-3" data-dismiss="modal">CANCELAR</button>
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

  $('.newBody-link').on('click', function() {
    $('#newBody-modal').modal();
  });

  $('.editBody-link').on('click', function(e) {
    e.preventDefault();
    var bcId = $(this).find('span:nth-child(2)').text();
    var bcName = $(this).find('span:nth-child(3)').text();
    var bcDescription = $(this).find('span:nth-child(4)').text();
    $('input[name=bcIdEdit]').val(bcId);
    $('input[name=bcNameEdit]').val(bcName);
    $('textarea[name=bcDescriptionEdit]').val(bcDescription);
    $('#editBody-modal').modal();
  });

  $('.deleteBody-link').on('click', function(e) {
    e.preventDefault();
    var bcId = $(this).find('span:nth-child(2)').text();
    var bcName = $(this).find('span:nth-child(3)').text();
    var bcDescription = $(this).find('span:nth-child(4)').text();
    $('input[name=bcIdDelete]').val(bcId);
    $('.bcNameDelete').text(bcName);
    $('.bcDescriptionDelete').text(bcDescription);
    $('#deleteBody-modal').modal();
  });
</script>
@endsection