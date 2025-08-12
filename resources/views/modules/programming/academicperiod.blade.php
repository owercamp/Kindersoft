@extends('modules.programming')

@section('academicModules')
<div class="col-md-12">
  <div class="row mb-3 border-bottom py-3">
    <div class="col-md-6">
      <h3>PERIODOS ACADEMICOS</h3>
      <a href="{{ route('academicperiod.new') }}" class="btn btn-outline-tertiary  form-control-sm">REGISTRAR PERIODOS</a>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de periodo academico -->
      @if(session('SuccessSaveAcademicperiod'))
      <div class="alert alert-success">
        {{ session('SuccessSaveAcademicperiod') }}
      </div>
      @endif
      @if(session('SecondarySaveAcademicperiod'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAcademicperiod') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de periodo academico -->
      @if(session('PrimaryUpdateAcademicperiod'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAcademicperiod') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAcademicperiod'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAcademicperiod') }}
      </div>
      @endif
      <!-- Mensajes de eliminacion de periodo academico -->
      @if(session('WarningDeleteAcademicperiod'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAcademicperiod') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAcademicperiod'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAcademicperiod') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>CURSO</th>
        <th>CANTIDAD</th>
        <th>INICIO</th>
        <th>FIN</th>
        <th>ESTADO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($academicperiods as $academicperiod)
      <tr>
        <td>{{ $academicperiod->nameCourse }}</td>
        <td>{{ $academicperiod->apNameperiod }}</td>
        <td>{{ $academicperiod->apDateInitial }}</td>
        <td>{{ $academicperiod->apDateFinal }}</td>
        <td>{{ $academicperiod->apStatus }}</td>
        <td>
          <a href="#" class="btn btn-outline-primary rounded-circle editAcademicperiod-link" title="EDITAR">
            <i class="fas fa-edit"></i>
            <span hidden>{{ $academicperiod->apId }}</span>
            <span hidden>{{ $academicperiod->apCourse_id }}</span>
            <span hidden>{{ $academicperiod->nameCourse }}</span>
            <span hidden>{{ $academicperiod->apNameperiod }}</span>
            <span hidden>{{ $academicperiod->apDateInitial }}</span>
            <span hidden>{{ $academicperiod->apDateFinal }}</span>
            <span hidden>{{ $academicperiod->apStatus }}</span>
          </a>
          <a href="#" class="btn btn-outline-tertiary rounded-circle  deleteAcademicperiod-link" title="ELIMINAR">
            <i class="fas fa-trash-alt"></i>
            <span hidden>{{ $academicperiod->apId }}</span>
            <span hidden>{{ $academicperiod->apCourse_id }}</span>
            <span hidden>{{ $academicperiod->nameCourse }}</span>
            <span hidden>{{ $academicperiod->apNameperiod }}</span>
            <span hidden>{{ $academicperiod->apDateInitial }}</span>
            <span hidden>{{ $academicperiod->apDateFinal }}</span>
            <span hidden>{{ $academicperiod->apStatus }}</span>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- MODAL PARA EDITAR PERIODOS DEFINIDOS PARA EL CURSO -->
<div class="modal fade" id="editAcademicperiod-Modal">
  <div class="modal-dialog">
    <div class="modal-content px-4 py-4">
      <div class="modal-header row">
        <div class="col-md-12">
          <h6 class="text-muted mb-4"><span hidden class="dateSelected-modal"></span> MODIFICACION DE PERIODO ACADEMICO:</h6>
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">CURSO: </small>
              <span class="text-muted"><b class="editNameCourse">Nombre curso</b></span><br>
              <small class="text-muted">PERIODO: </small>
              <span class="text-muted"><b class="editNameperiod">nombre periodo</b></span><br>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <form action="{{ route('academicperiod.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">Fecha de inicio:</small>
                <input type="text" name="apDateInitialEdit" class="form-control form-control-sm datepicker" value="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <small class="text-muted">Fecha de terminación:</small>
                <input type="text" name="apDateFinalEdit" class="form-control form-control-sm datepicker" value="" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <small class="text-muted">ESTADO:</small>
            <select name="apStatusEdit" class="form-control form-control-sm select2" required>
              <option value="">Seleccione un estado...</option>
              <option value="ACTIVO">ACTIVO</option>
              <option value="INACTIVO">INACTIVO</option>
            </select>
          </div>
          <div class="form-group">
            <input type="hidden" name="apIdEdit" class="form-control form-control-sm" value="" required>
            <input type="hidden" name="apCourse_idEdit" class="form-control form-control-sm" value="" required>
            <input type="hidden" name="apNameperiodEdit" class="form-control form-control-sm" value="" required>
            <button type="submit" class="btn btn-outline-primary float-left form-control-sm">GUARDAR CAMBIOS</button>
            <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA ELIMINAR PERIODOS DEFINIDOS PARA EL CURSO -->
<div class="modal fade" id="deleteAcademicperiod-Modal">
  <div class="modal-dialog">
    <div class="modal-content px-4 py-4">
      <div class="modal-header row">
        <div class="col-md-12">
          <h6 class="text-muted mb-4"><span hidden class="dateSelected-modal"></span> ELIMINACION DE PERIODO ACADEMICO:</h6>
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">CURSO: </small>
              <span class="text-muted"><b class="deleteNameCourse">Nombre curso</b></span><br>
              <small class="text-muted">PERIODO: </small>
              <span class="text-muted"><b class="deleteNameperiod">nombre periodo</b></span><br>
              <small class="text-muted">FECHA DE INICIO: </small>
              <span class="text-muted"><b class="deleteDateInitial">Fecha inicial</b></span><br>
              <small class="text-muted">FECHA DE TERMINACION: </small>
              <span class="text-muted"><b class="deleteDateFinal">Fecha inicial</b></span><br>
              <small class="text-muted">ESTADO: </small>
              <span class="text-muted"><b class="deleteStatus">Estado</b></span><br>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <form action="{{ route('academicperiod.delete') }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="hidden" name="apIdDelete" class="form-control form-control-sm" value="" required>
            <input type="hidden" name="nameCourseDelete" class="form-control form-control-sm" value="" required>
            <button type="submit" class="btn btn-outline-primary float-left form-control-sm">ELIMINAR</button>
            <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
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

  $('.editAcademicperiod-link').on('click', function() {
    var id = $(this).find('span:nth-child(2)').text();
    var idCourse = $(this).find('span:nth-child(3)').text();
    var nameCourse = $(this).find('span:nth-child(4)').text();
    var period = $(this).find('span:nth-child(5)').text();
    var dateInitial = $(this).find('span:nth-child(6)').text();
    var dateFinal = $(this).find('span:nth-child(7)').text();
    var status = $(this).find('span:nth-child(8)').text();

    $('.editNameCourse').text('');
    $('.editNameCourse').text(nameCourse);
    $('.editNameperiod').text('');
    $('.editNameperiod').text(period);

    $('input[name=apDateInitialEdit]').val('');
    $('input[name=apDateInitialEdit]').val(dateInitial);

    $('input[name=apDateFinalEdit]').val('');
    $('input[name=apDateFinalEdit]').val(dateFinal);

    $('select[name=apStatusEdit]').val('');
    if (status == 'ACTIVO') {
      $('select[name=apStatusEdit]').val('ACTIVO');
    } else if (status == 'INACTIVO') {
      $('select[name=apStatusEdit]').val('INACTIVO');
    }

    $('input[name=apIdEdit]').val('');
    $('input[name=apIdEdit]').val(id);
    $('input[name=apCourse_idEdit]').val('');
    $('input[name=apCourse_idEdit]').val(idCourse);
    $('input[name=apNameperiodEdit]').val('');
    $('input[name=apNameperiodEdit]').val(period);

    $('#editAcademicperiod-Modal').modal();
  });

  $('.deleteAcademicperiod-link').on('click', function() {
    var id = $(this).find('span:nth-child(2)').text();
    var nameCourse = $(this).find('span:nth-child(4)').text();
    var period = $(this).find('span:nth-child(5)').text();
    var dateInitial = $(this).find('span:nth-child(6)').text();
    var dateFinal = $(this).find('span:nth-child(7)').text();
    var status = $(this).find('span:nth-child(8)').text();

    $('.deleteNameCourse').text('');
    $('.deleteNameCourse').text(nameCourse);
    $('.deleteNameperiod').text('');
    $('.deleteNameperiod').text(period);
    $('.deleteDateInitial').text('');
    $('.deleteDateInitial').text(dateInitial);
    $('.deleteDateFinal').text('');
    $('.deleteDateFinal').text(dateFinal);
    $('.deleteStatus').text('');
    $('.deleteStatus').text(status);

    $('input[name=nameCourseDelete]').val('');
    $('input[name=nameCourseDelete]').val(nameCourse);

    $('input[name=apIdDelete]').val('');
    $('input[name=apIdDelete]').val(id);

    $('#deleteAcademicperiod-Modal').modal();
  });
</script>
@endsection