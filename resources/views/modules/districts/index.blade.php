@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('district.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">CIUDAD:</small>
              <select class="form-control form-control-sm select2" name="city_id" id="city" required>
                <option value="">Seleccione ciudad...</option>
                @foreach($citys as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <small class="text-muted">LOCALIDAD:</small>
              <select class="form-control form-control-sm select2" name="location_id" id="location" required>
                <!-- options dinamics -->
                <option value="">Seleccione localidad...</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">NUEVO BARRIO:</small>
              <input required type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nuevo Barrio">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-outline-success mt-2 form-control-sm">CREAR</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6 align-items-end">
      <!-- Mensajes de creación de barrios -->
      @if(session('SuccessSaveDistrict'))
      <div class="alert alert-success">
        {{ session('SuccessSaveDistrict') }}
      </div>
      @endif
      @if(session('SecondarySaveDistrict'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveDistrict') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de barrios -->
      @if(session('PrimaryUpdateDistrict'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateDistrict') }}
      </div>
      @endif
      @if(session('SecondaryUpdateDistrict'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateDistrict') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de barrios -->
      @if(session('WarningDeleteDistrict'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteDistrict') }}
      </div>
      @endif
      @if(session('SecondaryDeleteDistrict'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteDistrict') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tabledistricts" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>BARRIOS</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($districts as $district)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $district->name }}</td>
        <td><a href="{{ route('district.edit', $district->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('district.delete', $district->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('¿Desea borrar el barrio?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection

@section('scripts')
<!-- Scripts de ajax -->
<script>
  $(document).ready(function() {
    $("#city").on("change", function(e) {
      var city_id = e.target.value;
      $.get("{{ route('edit.sublocation') }}", {
        cityhome_id: city_id
      }, function(locationObject) {
        var count = Object.keys(locationObject).length //total de localidades devueltas
        $('#location').empty();
        $('#location').append("<option value=''>Seleccione localidad...</option>");
        $('#location').empty();
        $('#location').append("<option value=''>Seleccione barrio...</option>");
        for (var i = 0; i < count; i++) {
          $('#location').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
        }
      });
    });
  });
</script>

@endsection