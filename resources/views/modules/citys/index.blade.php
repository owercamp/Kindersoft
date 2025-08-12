@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('city.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <input type="text" class="form-control form-control-sm" name="name" placeholder="Nombre de ciudad" required>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-outline-success mb-4 form-control-sm">CREAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de ciudades -->
      @if(session('SuccessSaveCity'))
      <div class="alert alert-success">
        {{ session('SuccessSaveCity') }}
      </div>
      @endif
      @if(session('SecondarySaveCity'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveCity') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de ciudades -->
      @if(session('PrimaryUpdateCity'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateCity') }}
      </div>
      @endif
      @if(session('SecondaryUpdateCity'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateCity') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de ciudades -->
      @if(session('WarningDeleteCity'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteCity') }}
      </div>
      @endif
      @if(session('SecondaryDeleteCity'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteCity') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablecitys" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>CIUDADES</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($citys as $city)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $city->name }}</td>
        <td><a href="{{ route('city.edit', $city->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle edit-city"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('city.delete', $city->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('Si borra esta ciudad, se eliminarán las localidades y barrios relacionados. ¿Desea borrar la ciudad con sus localidades y barrios?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection