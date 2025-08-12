@extends('modules.structure')

@section('academicModules')
<div class="col-md-12">
  <div class="row border-bottom mb-3">
    <div class="col-md-6">
      <h3>REGISTROS DE CLASES Y ACTIVIDADES</h3>
      <a href="#" title="AGREGAR" class="btn btn-outline-success form-control-sm newActivityClass-link">AGREGAR CLASE/ACTIVIDAD</a>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de clases/actividades -->
      @if(session('SuccessSaveActivityClass'))
      <div class="alert alert-success">
        {{ session('SuccessSaveActivityClass') }}
      </div>
      @endif
      @if(session('SecondarySaveActivityClass'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveActivityClass') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de clases/actividades -->
      @if(session('PrimaryUpdateActivityClass'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateActivityClass') }}
      </div>
      @endif
      @if(session('SecondaryUpdateActivityClass'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateActivityClass') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de clases/actividades -->
      @if(session('WarningDeleteActivityClass'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteActivityClass') }}
      </div>
      @endif
      @if(session('SecondaryDeleteActivityClass'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteActivityClass') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableactivityclass" class="table table-hover text-center">
    <thead>
      <tr>
        <th>FILA</th>
        <th>NUMERO</th>
        <th>CLASE/ACTIVIDAD</th>
        <th>DESCRIPCION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach($activityClass as $activityclass)
      <tr>
        <td>{{ $row++ }}</td>
        <td>{{ $activityclass->acNumber }}</td>
        <td>{{ $activityclass->acClass }}</td>
        <td>{{ $activityclass->acDescription }}</td>
        <td>
          <a href="#" title="EDITAR" class="btn btn-outline-primary rounded-circle editActivityClass-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $activityclass->acId }}</span>
            <span hidden>{{ $activityclass->acNumber }}</span>
            <span hidden>{{ $activityclass->acClass }}</span>
            <span hidden>{{ $activityclass->acDescription }}</span>
          </a>
          <a href="#" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  deleteActivityClass-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $activityclass->acId }}</span>
            <span hidden>{{ $activityclass->acNumber }}</span>
            <span hidden>{{ $activityclass->acClass }}</span>
            <span hidden>{{ $activityclass->acDescription }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newActivityClass-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">NUEVA CLASE/ACTIVIDAD:</h4>
      </div>
      <div class="modal-body">
        <form id="formNewActivitySpace" action="{{ route('activityClass.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <small class="text-muted">NUMERO:</small>
                <input type="number" name="acNumber" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <small class="text-muted">CLASE/ACTIVIDAD:</small>
                <input type="text" name="acClass" class="form-control form-control-sm" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="acDescription" cols="30" rows="10" maxlength="600" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editActivityClass-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE CLASE/ACTIVIDAD:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('activityClass.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <small class="text-muted">NUMERO:</small>
                <input type="number" name="acNumberEdit" class="form-control form-control-sm" value="" required>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <small class="text-muted">ESPACIO:</small>
                <input type="text" name="acClassEdit" class="form-control form-control-sm" value="" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="acDescriptionEdit" cols="30" rows="10" maxlength="600" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="acIdEdit" value="" required>
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

<div class="modal fade" id="deleteActivityClass-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE CLASE/ACTIVIDAD:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">NUMERO: </small>
            <span class="text-muted"><b class="acNumberDelete"></b></span><br>
            <small class="text-muted">ESPACIO: </small>
            <span class="text-muted"><b class="acClassDelete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="acDescriptionDelete"></b></span><br>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('activityClass.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="acIdDelete" value="" required>
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

  $('.newActivityClass-link').on('click', function() {
    $('#newActivityClass-modal').modal();
  });

  $('.deleteActivityClass-link').on('click', function() {
    $('input[name=acIdDelete]').val('');
    $('input[name=acIdDelete]').val($(this).find('span:nth-child(2)').text());
    $('.acNumberDelete').text($(this).find('span:nth-child(3)').text());
    $('.acClassDelete').text($(this).find('span:nth-child(4)').text());
    $('.acDescriptionDelete').text($(this).find('span:nth-child(5)').text());
    $('#deleteActivityClass-modal').modal();
  });

  $('.editActivityClass-link').on('click', function() {
    $('input[name=acIdEdit]').val('');
    $('input[name=acIdEdit]').val($(this).find('span:nth-child(2)').text());
    $('input[name=acNumberEdit]').val('');
    $('input[name=acNumberEdit]').val($(this).find('span:nth-child(3)').text());
    $('input[name=acClassEdit]').val('');
    $('input[name=acClassEdit]').val($(this).find('span:nth-child(4)').text());
    $('textarea[name=acDescriptionEdit]').val('');
    $('textarea[name=acDescriptionEdit]').val($(this).find('span:nth-child(5)').text());
    $('#editActivityClass-modal').modal();
  });
</script>
@endsection