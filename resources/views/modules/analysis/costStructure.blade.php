@extends('modules.analysis')

@section('financialModules')
<div class="col-md-12">
  <div class="row mt-5">
    <div class="col-md-6">
      <h4>ESTRUCTURA DE COSTOS</h4>
      <!-- Mensajes de creación de estructuras -->
      @if(session('SuccessCreateStructure'))
      <div class="alert alert-success">
        {{ session('SuccessCreateStructure') }}
      </div>
      @endif
      @if(session('SecondaryCreateStructure'))
      <div class="alert alert-secondary">
        {{ session('SecondaryCreateStructure') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de estructuras -->
      @if(session('PrimaryUpdateStructure'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateStructure') }}
      </div>
      @endif
      @if(session('SecondaryUpdateStructure'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateStructure') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de estructuras -->
      @if(session('WarningDeleteStructure'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteStructure') }}
      </div>
      @endif
      @if(session('SecondaryDeleteStructure'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteStructure') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="#" class="btn btn-outline-success form-control-sm newCoststructure-link">NUEVA ESTRUCTURA</a>
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>ITEM</th>
        <th>DESCRIPCION</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach($structure as $cost)
      <tr>
        <td>{{ $row }}</td>
        <td>{{ $cost->csDescription }}</td>
        <td>
          <a href="#" class="btn btn-outline-primary rounded-circle editCoststructure-link" title="EDITAR">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $cost->csId }}</span>
            <span hidden>{{ $cost->csDescription }}</span>
          </a>
          <a href="#" class="btn btn-outline-tertiary rounded-circle  deleteCoststructure-link" title="ELIMINAR">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $cost->csId }}</span>
            <span hidden>{{ $cost->csDescription }}</span>
          </a>
        </td>
      </tr>
      @php $row++; @endphp
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newCoststructure-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>NUEVO REGISTRO DE ESTRUCTURA DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4 text-center">
        <form action="{{ route('analysis.newCoststructure') }}" method="POST">
          @csrf
          <div class="form-group">
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <textarea name="costStructure_new" cols="10" rows="2" class="form-control form-control-sm" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100"></textarea>
            <button type="submit" class="btn btn-outline-success m-4">CREAR DESCRIPCIÓN</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editCoststructure-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>EDICION DE ESTRUCTURA DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4 text-center">
        <form action="{{ route('analysis.editCoststructure') }}" method="POST">
          @csrf
          <div class="form-group">
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <textarea name="costStructure_edit" cols="10" rows="2" class="form-control form-control-sm" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100" required></textarea>
            <input type="hidden" name="costStructure_id_edit" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-success m-4">GUARDAR CAMBIOS</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteCoststructure-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>ELIMINACION DE ESTRUCTURA DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4">
        <p>Se eliminará el siguiente registro:</p>
        <form action="{{ route('analysis.deleteCoststructure') }}" method="POST">
          @csrf
          <div class="form-group">
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <textarea name="costStructure_delete" cols="10" rows="2" class="form-control form-control-sm text-center" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100" disabled></textarea>
            <small class="text-muted">Tenga en cuenta que las ESTRUCTURAS DE COSTO estan relacionadas con las DESCRIPCIONES DE COSTO, si elimina este registro, tambien se eliminarán las descripcion de costo relacionadas, ¿Desea continuar?</small>
            <input type="hidden" name="costStructure_id_delete" class="form-control form-control-sm" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success m-4">SI, ELIMINAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });

  $('.newCoststructure-link').on('click', function(e) {
    e.preventDefault();
    $('#newCoststructure-modal').modal();
  });

  $('.editCoststructure-link').on('click', function(e) {
    e.preventDefault();
    var id = $(this).find('span:nth-child(2)').text();
    var description = $(this).find('span:nth-child(3)').text();
    $('input[name=costStructure_id_edit]').val(id);
    $('textarea[name=costStructure_edit]').val(description);
    $('#editCoststructure-modal').modal();
  });

  $('.deleteCoststructure-link').on('click', function(e) {
    e.preventDefault();
    var id = $(this).find('span:nth-child(2)').text();
    var description = $(this).find('span:nth-child(3)').text();
    $('input[name=costStructure_id_delete]').val(id);
    $('textarea[name=costStructure_delete]').val(description);
    $('#deleteCoststructure-modal').modal();
  });
</script>
@endsection