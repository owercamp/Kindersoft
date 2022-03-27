@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <div class="row mb-3 border-bottom py-3">
    <div class="col-md-4">
      <h5>TABLA DE OBSERVACIONES</h5>
    </div>
    <div class="col-md-4">
      <a href="#" class="btn btn-outline-success form-control-sm newObservation-link">REGISTRAR OBSERVACION</a>
    </div>
    <div class="col-md-4">
      <!-- Mensajes de creación de observaciones -->
      @if(session('SuccessSaveObservations'))
      <div class="alert alert-success">
        {{ session('SuccessSaveObservations') }}
      </div>
      @endif
      @if(session('SecondarySaveObservations'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveObservations') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de observaciones -->
      @if(session('PrimaryUpdateObservations'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateObservations') }}
      </div>
      @endif
      @if(session('SecondaryUpdateObservations'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateObservations') }}
      </div>
      @endif
      <!-- Mensajes de eliminacion de observaciones -->
      @if(session('WarningDeleteObservations'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteObservations') }}
      </div>
      @endif
      @if(session('SecondaryDeleteObservations'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteObservations') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>NUMERO</th>
        <th>OBSERVACION</th>
        <th>INTELIGENCIA</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($observations as $observation)
      <tr>
        <td>{{ $observation->obsNumber }}</td>
        <td>{{ $observation->obsDescription }}</td>
        <td>{{ $observation->type }}</td>
        <td>
          <a href="#" class="btn btn-outline-primary rounded-circle editObservation-link" title="EDITAR">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $observation->obsId }}</span>
            <span hidden>{{ $observation->obsNumber }}</span>
            <span hidden>{{ $observation->obsDescription }}</span>
            <span hidden>{{ $observation->obsIntelligence_id }}</span>
          </a>
          <a href="#" class="btn btn-outline-tertiary rounded-circle  deleteObservation-link" title="ELIMINAR">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $observation->obsId }}</span>
            <span hidden>{{ $observation->obsNumber }}</span>
            <span hidden>{{ $observation->obsDescription }}</span>
            <span hidden>{{ $observation->type }}</span>
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
        <h4 class="text-muted">NUEVA OBSERVACION:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('observation.new') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">NUMERO:</small>
                <input type="number" name="obsNumber" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">INTELIGENCIA:</small>
                <select name="obsIntelligence_id" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione una inteligencia...</option>
                  @foreach($intelligences as $intelligence)
                  <option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="obsDescription" rows="2" maxlength="100" class="form-control form-control-sm" required></textarea>
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

<div class="modal fade" id="editObservation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">MODIFICACION DE OBSERVACION:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('observation.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">NUMERO:</small>
                <input type="number" name="obsNumberEdit" class="form-control form-control-sm" value="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">INTELIGENCIA:</small>
                <select name="obsIntelligence_idEdit" class="form-control form-control-sm select2" required>
                  <option value="">Seleccione una inteligencia...</option>
                  @foreach($intelligences as $intelligence)
                  <option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">DESCRIPCION:</small>
                <textarea name="obsDescriptionEdit" cols="30" rows="10" maxlength="100" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="obsIdEdit" value="" required>
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

<div class="modal fade" id="deleteObservation-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted">ELIMINACION DE OBSERVACION:</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">NUMERO: </small>
            <span class="text-muted"><b class="obsNumberDelete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="obsDescriptionDelete"></b></span><br>
            <small class="text-muted">INTELIGENCIA: </small><br>
            <span class="text-muted"><b class="obsIntelligence_idDelete"></b></span><br>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('observation.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="obsIdDelete" value="" required>
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

  $('.editObservation-link').on('click', function() {
    var id = $(this).find('span:nth-child(2)').text();
    var number = $(this).find('span:nth-child(3)').text();
    var description = $(this).find('span:nth-child(4)').text();
    var idIntelligence = $(this).find('span:nth-child(5)').text();
    $('input[name=obsIdEdit]').val(id);
    $('input[name=obsNumberEdit]').val(number);
    $('textarea[name=obsDescriptionEdit]').val(description);
    $('select[name=obsIntelligence_idEdit]').val(idIntelligence);
    $('#editObservation-modal').modal();
  });

  $('.deleteObservation-link').on('click', function() {
    var id = $(this).find('span:nth-child(2)').text();
    var number = $(this).find('span:nth-child(3)').text();
    var description = $(this).find('span:nth-child(4)').text();
    var intelligence = $(this).find('span:nth-child(5)').text();
    $('input[name=obsIdDelete]').val(id);
    $('.obsNumberDelete').text(number);
    $('.obsDescriptionDelete').text(description);
    $('.obsIntelligence_idDelete').text(intelligence);
    $('#deleteObservation-modal').modal();
  });
</script>
@endsection