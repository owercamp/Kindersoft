@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('health.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <input type="text" class="form-control my-2 form-control-sm" name="entity" placeholder="Nueva entidad" required>
          </div>
          <div class="col-md-6">
            <select class="form-control my-2 form-control-sm select2" name="type" required>
              <option value="">Selecciones tipo...</option>
              <option value="EPS">EPS</option>
              <option value="PREPAGADA">PREPAGADA</option>
            </select>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-outline-success my-2 form-control-sm">CREAR</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de centros de salud -->
      @if(session('SuccessSaveHealth'))
      <div class="alert alert-success">
        {{ session('SuccessSaveHealth') }}
      </div>
      @endif
      @if(session('SecondarySaveHealth'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveHealth') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de centros de salud -->
      @if(session('PrimaryUpdateHealth'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateHealth') }}
      </div>
      @endif
      @if(session('SecondaryUpdateHealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateHealth') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de centros de salud -->
      @if(session('WarningDeleteHealth'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteHealth') }}
      </div>
      @endif
      @if(session('SecondaryDeleteHealth'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteHealth') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablehealths" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>CENTRO DE SALUD</th>
        <th>TIPO DE AFILIACION</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($healths as $health)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $health->entity }}</td>
        <td>{{ $health->type }}</td>
        <td><a href="{{ route('health.edit', $health->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('health.delete', $health->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('- Se eliminará el centro de salud')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection