@extends('modules.programming')

@section('academicModules')
<div class="col-md-12 p-3">
  <div class="row border-bottom mb-3">
    <div class="col-md-4">
      <h5>BASE DE ACTIVIDADES</h5>
    </div>
    <div class="col-md-4">
      <button type="button" title="Registrar una base" class="btn btn-outline-success form-control-sm newBase-link">REGISTRAR BASE</button>
    </div>
    <div class="col-md-4">
      @if(session('SuccessBases'))
      <div class="alert alert-success">
        {{ session('SuccessBases') }}
      </div>
      @endif
      @if(session('PrimaryBases'))
      <div class="alert alert-primary">
        {{ session('PrimaryBases') }}
      </div>
      @endif
      @if(session('WarningBases'))
      <div class="alert alert-warning">
        {{ session('WarningBases') }}
      </div>
      @endif
      @if(session('SecondaryBases'))
      <div class="alert alert-secondary">
        {{ session('SecondaryBases') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>DESCRIPCION</th>
        <th>INTELIGENCIA</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row = 1; @endphp
      @foreach($bases as $base)
      <tr>
        <td>{{ $row++ }}</td>
        @if(strlen($base->baDescription) > 50)
        <td>{{ substr($base->baDescription,0,21) . ' ... ' }}</td>
        @else
        <td>{{ $base->baDescription }}</td>
        @endif
        <td>{{ $base->nameIntelligence }}</td>
        <td>
          <a href="#" title="Editar base de actividad" class="btn btn-outline-primary rounded-circle form-control-sm editBase-link">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $base->baId }}</span>
            <span hidden>{{ $base->baDescription }}</span>
            <span hidden>{{ $base->baIntelligence_id }}</span>
          </a>
          <a href="#" title="Eliminar base de actividad" class="btn btn-outline-tertiary rounded-circle  form-control-sm deleteBase-link">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $base->baId }}</span>
            <span hidden>{{ $base->baDescription }}</span>
            <span hidden>{{ $base->nameIntelligence }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="newBase-modal">
  <div class="modal-dialog" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4>NUEVA BASE DE ACTIVIDADES:</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('baseactivitys.save') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">INTELIGENCIA:</small>
                <select name="baIntelligence_id" class="form-control form-control-sm" required>
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
                <textarea name="baDescription" class="form-control form-control-sm" maxlength="500" cols="30" rows="5" required></textarea>
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

<div class="modal fade" id="editBase-modal">
  <div class="modal-dialog" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5>EDITAR BASE DE ACTIVIDAD:</h5>
      </div>
      <div class="modal-body">
        <form action="{{ route('baseactivitys.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <small class="text-muted">INTELIGENCIA:</small>
                <select name="baIntelligence_id_Edit" class="form-control form-control-sm" required>
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
                <textarea name="baDescription_Edit" class="form-control form-control-sm" maxlength="500" cols="30" rows="5" required></textarea>
              </div>
            </div>
          </div>
          <div class="row border-top mt-3 text-center">
            <div class="col-md-6">
              <input type="hidden" class="form-control form-control-sm" name="baId_Edit" value="" required>
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

<div class="modal fade" id="deleteBase-modal">
  <div class="modal-dialog" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5>ELIMINACION DE BASE DE ACTIVIDAD:</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <small class="text-muted">INTELIGENCIA: </small><br>
            <span class="text-muted"><b class="baIntelligence_Delete"></b></span><br>
            <small class="text-muted">DESCRIPCION: </small><br>
            <span class="text-muted"><b class="baDescription_Delete"></b></span>
          </div>
        </div>
        <div class="row mt-3 border-top text-center">
          <form action="{{ route('baseactivitys.delete') }}" method="POST" class="col-md-6">
            @csrf
            <input type="hidden" class="form-control form-control-sm" name="baId_Delete" value="" required>
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

  $('.newBase-link').on('click', function() {
    $('#newBase-modal').modal();
  });

  $('.editBase-link').on('click', function(e) {
    e.preventDefault();
    var baId = $(this).find('span:nth-child(2)').text();
    var baDescription = $(this).find('span:nth-child(3)').text();
    var baIntelligence_id = $(this).find('span:nth-child(4)').text();
    $('input[name=baId_Edit]').val(baId);
    $('textarea[name=baDescription_Edit]').val(baDescription);
    $('select[name=baIntelligence_id_Edit]').val(baIntelligence_id);
    $('#editBase-modal').modal();
  });

  $('.deleteBase-link').on('click', function(e) {
    e.preventDefault();
    var baId = $(this).find('span:nth-child(2)').text();
    var baDescription = $(this).find('span:nth-child(3)').text();
    var baIntelligence = $(this).find('span:nth-child(4)').text();
    $('input[name=baId_Delete]').val(baId);
    $('.baIntelligence_Delete').text(baIntelligence);
    $('.baDescription_Delete').text(baDescription);
    $('#deleteBase-modal').modal();
  });
</script>
@endsection