@extends('modules.academic')

@section('academics')
<div class="row">
  <div class="card">
    <div class="card-header">
      <div class="form-group">
        <h2 class="text-muted">Modificación de programa:</h2>
        <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary ">Volver</a>
        <p>{{ $consolidated->gradeName }}</p><br>
        <p>{{ $grades }}</p>
      </div>
    </div>
    <div class="card-body">
      <form class="form">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <!-- SELECCION DE GRADO -->
              <small class="form-text text-muted">Grado:</small>
              <select class="form-control form-control-sm mx-sm-4 mb-2 select2" name="grade_id" id="grade_id" required="required">
                <option value="">Seleccione...</option>
                @php $nameConsolidated = '' @endphp
                @foreach($grades as $grade)
                @if($grade->name == $consolidated)
                @php $nameConsolidated = $grade->name @endphp
                <option value="{{ $grade->id }}" selected="selected">{{ $grade->name }}</option>
                @else
                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endif
                @endforeach
              </select>
              <!-- SELECCION DE PERIODO -->
              <small class="form-text text-muted">Periodo:</small>
              <select class="form-control form-control-sm mx-sm-4 mb-2 select2" name="period_id" id="period_id" required="required">
                <option value="">Seleccione...</option>
                <!-- Select dinamico de periodos -->
              </select>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
    </form>
  </div>
</div>
@endsection