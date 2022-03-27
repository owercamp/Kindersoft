@extends('modules.structure')

@section('academicModules')
<div class="col-md-12">
  <div class="row border-top">
    <div class="col-md-6">
      <h4 class=" text-muted ml-4 mt-3">MODIFICACION DE CURSO ESTABLECIDO:</h4>
    </div>
    <div class="col-md-6">
      <a href="{{ route('listgradeCourse') }}" class="btn btn-outline-tertiary  my-4 form-control-sm">VOLVER</a>
    </div>
  </div>
  <div class="row mt-3 border-top">
    <div class="col-md-12">
      <form action="{{ route('gradeCourse.update') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">GRADO:</small>
              <input type="hidden" name="ccGradeEdit" value="{{ $courseConsolidated->ccGrade_id }}" required>
              <input type="text" class="form-control form-control-sm" value="{{ $courseConsolidated->nameGrade }}" readonly>
            </div>
            <div class="form-group">
              <small class="text-muted">CURSO:</small>
              <input type="hidden" name="ccCourseEdit" value="{{ $courseConsolidated->ccCourse_id }}" required>
              <input type="text" class="form-control form-control-sm" value="{{ $courseConsolidated->nameCourse }}" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">FECHA INICIAL:</small>
              <input type="text" name="ccDateInitialEdit" class="form-control form-control-sm datepicker" value="{{ $courseConsolidated->ccDateInitial }}" required>
            </div>
            <div class="form-group">
              <small class="text-muted">FECHA FINAL:</small>
              <input type="text" name="ccDateFinalEdit" class="form-control form-control-sm datepicker" value="{{ $courseConsolidated->ccDateFinal }}" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">DIRECTOR/A DE GRUPO:</small>
              <select name="ccCollaboratorEdit" class="form-control form-control-sm select2" required>
                <option value="">Seleccione un colaborador...</option>
                @foreach($collaborators as $collaborator)
                @if($courseConsolidated->ccCollaborator_id == $collaborator->id)
                <option selected value="{{ $collaborator->id }}">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</option>
                @else
                <option value="{{ $collaborator->id }}">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="from-froup">
              <small class="text-muted">ESTADO</small>
              <select name="ccStatusEdit" class="form-control form-control-sm select2">
                <option value="">Seleccione un estado...</option>
                @if($courseConsolidated->ccStatus == 'ACTIVO')
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
                @endif
                @if($courseConsolidated->ccStatus == 'INACTIVO')
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO" selected>INACTIVO</option>
                @endif
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input type="hidden" name="ccIdEdit" value="{{ $courseConsolidated->ccId }}" readonly required>
            <button type="submit" class="btn btn-outline-success form-control-sm mt-4">GUARDAR CAMBIOS</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });
</script>
@endsection