@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <h5>MODIFICACION DE PERIODO: {{ $period->name }}</h5>
  <form action="{{ route('period.save', $period->id) }}" method="PUT">
    @csrf
    <div class="form-group">
      <label for="id">IDENTIFICADOR:</label>
      <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $period->id }}" disabled="disabled" required="required">
      <small class="form-text text-muted">Identificador en base de datos</small>
    </div>
    <div class="form-group">
      <select class="form-control form-control-sm select2" name="grade_id" id="grade_id" required="required">
        <option value="">SELECCIONE UNA GRADO...</option>
        @php $namegrade = '' @endphp
        @foreach($grades as $grade)
        @if($grade->id == $period->grade_id)
        @php $namegrade = $period->name @endphp
        <option value="{{ $grade->id }}" selected="selected">{{ $grade->name }}</option>
        @else
        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
        @endif
        @endforeach
      </select>
      <small class="form-text text-muted">Actualmente el periodo es del grado <b>{{ $namegrade }}</b></small>
    </div>
    <div class="form-group">
      <label for="name">NOMBRE:</label>
      <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $period->name }}" required="required">
    </div>
    <div class="form-group">
      <label for="initialDate">FECHA INICIAL:</label>
      <input type="text" class="form-control form-control-sm datepicker" id="initialDate" name="initialDate" value="{{ $period->initialDate }}" required="required">
    </div>
    <div class="form-group">
      <label for="finalDate">FECHA FINAL:</label>
      <input type="text" class="form-control form-control-sm datepicker" id="finalDate" name="finalDate" value="{{ $period->finalDate }}" required="required">
    </div>
    <button type="submit" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIO</button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
  </form>
</div>
@endsection

@section('scripts')

<!-- Scripts de datatables -->
<script>
  $('.datepicker').datepicker({
    format: "yyyy/mm/dd",
    language: "es",
    autoclose: true
  });
</script>

@endsection