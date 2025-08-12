@extends('modules.analysis')

@section('financialModules')
<div class="col-md-12">
  <div class="row mt-5">
    <div class="col-md-6">
      <h4>DESCRIPCION DE COSTOS</h4>
      <!-- Mensajes de creación de descripciones -->
      @if(session('SuccessCreateDescription'))
      <div class="alert alert-success">
        {{ session('SuccessCreateDescription') }}
      </div>
      @endif
      @if(session('SecondaryCreateDescription'))
      <div class="alert alert-secondary">
        {{ session('SecondaryCreateDescription') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de descripciones -->
      @if(session('PrimaryUpdateDescription'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateDescription') }}
      </div>
      @endif
      @if(session('SecondaryUpdateDescription'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateDescription') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de descripciones -->
      @if(session('WarningDeleteDescription'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteDescription') }}
      </div>
      @endif
      @if(session('SecondaryDeleteDescription'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteDescription') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="#" class="btn btn-outline-success form-control-sm newCostdescription-link">NUEVA DESCRIPCION</a>
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>ITEM</th>
        <th>DESCRIPCION</th>
        <th>ESTRUCTURA</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @for($i = 0; $i < count($dates); $i++) <tr>
        <td>{{ $row }}</td>
        <td>{{ $dates[$i][1] }}</td>
        <td>{{ $dates[$i][3] }}</td>
        <td>
          <a href="#" class="btn btn-outline-primary rounded-circle editCostdescription-link" title="EDITAR">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $dates[$i][0] }}</span> <!-- Id de costDescription -->
            <span hidden>{{ $dates[$i][1] }}</span> <!-- Descripcion de costDescription -->
            <span hidden>{{ $dates[$i][2] }}</span> <!-- Id de costStructure -->
            <span hidden>{{ $dates[$i][3] }}</span> <!-- Descripcion de costStructure -->
          </a>
          <a href="#" class="btn btn-outline-tertiary rounded-circle  deleteCostdescription-link" title="ELIMINAR">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $dates[$i][0] }}</span> <!-- Id de costDescription -->
            <span hidden>{{ $dates[$i][1] }}</span> <!-- Descripcion de costDescription -->
            <span hidden>{{ $dates[$i][2] }}</span> <!-- Id de costStructure -->
            <span hidden>{{ $dates[$i][3] }}</span> <!-- Descripcion de costStructure -->
          </a>
        </td>
        </tr>
        @php $row++; @endphp
        @endfor
    </tbody>
  </table>
</div>

<div class="modal fade" id="newCostdescription-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>NUEVO REGISTRO DE DESCRIPCION DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4">
        <form action="{{ route('analysis.newCostdescription') }}" method="POST">
          @csrf
          <div class="form-group">
            <small class="text-muted">DESCRIPCION DE COSTO:</small>
            <textarea name="costDescription_new" cols="10" rows="2" class="form-control form-control-sm" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100" required></textarea>
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <select name="costStructure_id_new" class="form-control form-control-sm select2" required>
              <option value="">Seleccione una estructura de costo...</option>
              @foreach($structures as $structure)
              <option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success m-4">CREAR DESCRIPCIÓN</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editCostdescription-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>EDICION DE DESCRIPCION DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4">
        <form action="{{ route('analysis.editCostdescription') }}" method="POST">
          @csrf
          <div class="form-group">
            <small class="text-muted">DESCRIPCION DE COSTO:</small>
            <textarea name="costDescription_edit" cols="10" rows="2" class="form-control form-control-sm" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100" required></textarea>
            <input type="hidden" name="costDescription_id_edit" class="form-control form-control-sm" required>
            <input type="hidden" name="costStructure_id_edit" class="form-control form-control-sm" required>
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <select name="costStructure_edit" class="form-control form-control-sm select2" required>
              <option value="">Seleccione una estructura de costo...</option>
              @foreach($structures as $structure)
              <option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-outline-success m-4">GUARDAR CAMBIOS</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteCostdescription-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h5>ELIMINACION DE DESCRIPCION DE COSTO</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body p-4 text-center">
        <p>Se eliminará el siguiente registro:</p>
        <form action="{{ route('analysis.deleteCostdescription') }}" method="POST">
          @csrf
          <div class="form-group">
            <textarea name="costDescription_delete" cols="10" rows="2" class="form-control form-control-sm text-center" title="DESCRIPCION DE 100 CARACTERES MAXIMO" placeholder="DESCRIPCION DE 100 CARACTERES MAXIMO" maxlength="100" disabled></textarea>
            <small class="text-muted">¿Desea continuar?</small>
            <input type="hidden" name="costDescription_id_delete" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-tertiary  m-4">SI, ELIMINAR</button>
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

  $('.newCostdescription-link').on('click', function(e) {
    e.preventDefault();
    $('#newCostdescription-modal').modal();
  });

  $('.editCostdescription-link').on('click', function(e) {
    e.preventDefault();
    var cdId = $(this).find('span:nth-child(2)').text();
    var cdDescription = $(this).find('span:nth-child(3)').text();
    var csId = $(this).find('span:nth-child(4)').text();
    var csDescription = $(this).find('span:nth-child(5)').text();
    $('input[name=costDescription_id_edit]').val(cdId);
    $('textarea[name=costDescription_edit]').val(cdDescription);
    $('input[name=costStructure_id_edit]').val(csId);
    $('select[name=costStructure_edit]').val(csId);
    $('#editCostdescription-modal').modal();
  });

  $('select[name=costStructure_edit]').on('change', function(e) {
    var csId = e.target.value;
    $('input[name=costStructure_id_edit]').val(csId);
  });

  $('.deleteCostdescription-link').on('click', function(e) {
    e.preventDefault();
    var cdId = $(this).find('span:nth-child(2)').text();
    var cdDescription = $(this).find('span:nth-child(3)').text();
    var csId = $(this).find('span:nth-child(4)').text();
    var csDescription = $(this).find('span:nth-child(5)').text();
    $('input[name=costDescription_id_delete]').val(cdId);
    $('textarea[name=costDescription_delete]').val(cdDescription);
    $('#deleteCostdescription-modal').modal();
  });
</script>
@endsection