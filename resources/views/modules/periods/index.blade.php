@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4 border-right">
    <div class="col-md-6">
      <form id="formPeriodNew" action="{{ route('period.new') }}" method="PUT">
        @csrf
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <select class="form-control form-control-sm select2" name="grade_id" required>
                <option value="">Seleccione un grado...</option>
                <!-- Options dinamics -->
                @foreach($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <select class="form-control form-control-sm select2" name="name" required>
                <option value="">Seleccione un periodo...</option>
                <option value="PRIMER PERIODO">PRIMER PERIODO</option>
                <option value="SEGUNDO PERIODO">SEGUNDO PERIODO</option>
                <option value="TERCER PERIODO">TERCER PERIODO</option>
                <option value="CUARTO PERIODO">CUARTO PERIODO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="form-text text-muted">DESDE:</small>
              <input type="text" class="form-control form-control-sm datepicker" name="initialDate" required>
            </div>
            <div class="col-md-6">
              <small class="form-text text-muted">HASTA:</small>
              <input type="text" class="form-control form-control-sm datepicker" name="finalDate" required>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-outline-success form-control-sm">CREAR PERIODO</button>
        </div>
      </form>
    </div>
    <div class="col-md-6 align-items-center border-left">
      <!-- Mensajes de creación de periodos -->
      @if(session('SuccessSavePeriod'))
      <div class="alert alert-success">
        {{ session('SuccessSavePeriod') }}
      </div>
      @endif
      @if(session('SecondarySavePeriod'))
      <div class="alert alert-secondary">
        {{ session('SecondarySavePeriod') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de periodos -->
      @if(session('PrimaryUpdatePeriod'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdatePeriod') }}
      </div>
      @endif
      @if(session('SecondaryUpdatePeriod'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdatePeriod') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de periodos -->
      @if(session('WarningDeletePeriod'))
      <div class="alert alert-warning">
        {{ session('WarningDeletePeriod') }}
      </div>
      @endif
      @if(session('SecondaryDeletePeriod'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeletePeriod') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableperiods" class="table table-hover text-center" style="width:100%;">
    <thead>
      <tr>
        <th>GRADO</th>
        <th>PERIODO</th>
        <th>FECHA INICIAL</th>
        <th>FECHA FINAL</th>
        <th colspan="2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($gradesFilter as $dates)
      <tr>
        <td>{{ $dates->nameGrade }}</td>
        <td>{{ $dates->name }}</td>
        <td>{{ $dates->initialDate }}</td>
        <td>{{ $dates->finalDate }}</td>
        <td><a href="{{ route('period.edit', $dates->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('period.delete', $dates->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('¿Desea borrar el periodo?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection