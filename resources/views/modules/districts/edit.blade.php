@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<h5>MODIFICACION DE BARRIO: {{ $district->name }}</h5>
		<form action="{{ route('district.save', $district->id) }}" method="PUT">
			@csrf
		  <div class="form-group">
		    <label>IDENTIFICADOR:</label>
		    <input type="text" class="form-control form-control-sm" id="id" name="id" value="{{ $district->id }}" disabled="disabled" required="required">
		    <small class="form-text text-muted">Identificador en base de datos</small>
		  </div>
		  <div class="form-group">
		  	<select required class="form-control form-control-sm" name="city_id" id="cityD">
		    		<option value="">Seleccione ciudad...</option>
		    			@php $namecity = '' @endphp
			    	@foreach($citys as $city)
			    		@if($city->id == $city_from_district[0]->id)
			    			@php $namecity = $city->name @endphp
			    			<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
			    		@else
			    			<option value="{{ $city->id }}">{{ $city->name }}</option>
			    		@endif
		    		@endforeach
		    </select>
		    <small class="form-text text-muted">La ciudad actual corresponde a <b>{{ $namecity }}</b></small>
		  </div>
		  <div class="form-group">
		  	<input type="hidden" id="locationD_hidden" value="{{ $district->location_id }}">
		  	<select required class="form-control form-control-sm" name="location_id" id="locationD">
		  		<!-- options dinamics -->
		  		<option value="">Seleccione localidad...</option>
		    </select>
		    <small class="form-text text-muted">La localidad actual corresponde a <b>{{ $location->name }}</b></small>
		  </div>
		  <div class="form-group">
		    <label for="name">NOMBRE:</label>
		    <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $district->name }}" required="required">
		    <small class="form-text text-muted">La barrio actualmente se llama <b>{{ $district->name }}</b></small>
		  </div>
		  <button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIOS</button>
		  	<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
		</form>
	</div>
@endsection


@section('scripts')
<script>
	$(document).ready(function(){

		var valueCity = $('#city option:selected').val();

		$.get('sublocation', valueCity, function(locationObject){
			console.log(locationObject);
		  $('#locationD').empty();
		  $('#locationD').append("<option value=''>SELECCIONE UNA LOCALIDAD...</option>");
			var count = Object.keys(locationObject).length //total de localidades devueltas
			for (var i = 0; i < count; i++) {
				$('#locationD').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
			}
		});

		var city_id = $("select[name=city_id]").val();
		if(city_id > 0){
			fullSelect(city_id);
		}

		$("#cityD").on("change", function(e){
			var cityhome_id = e.target.value;
			$.get("{{ route('edit.sublocation') }}", {cityhome_id: cityhome_id}, function(locationObject){
				var count = Object.keys(locationObject).length //total de localidades devueltas
				$('#locationD').empty();
				$('#locationD').append("<option value=''>Seleccione localidad...</option>");
				for (var i = 0; i < count; i++) {
					$('#locationD').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			});
		});
	});

	function fullSelect(value){
		$.get("{{ route('edit.sublocation') }}", {cityhome_id: value}, function(locationObject){
			var count = Object.keys(locationObject).length //total de localidades devueltas
			$('#locationD').empty();
			$('#locationD').append("<option value=''>Seleccione localidad...</option>");
			var locationD_hidden = $('#locationD_hidden').val();
			for (var i = 0; i < count; i++) {
				if(locationD_hidden != ''){
					if(locationD_hidden == locationObject[i]['id']){
						$('#locationD').append("<option value=" + locationObject[i]['id'] + " selected>" + locationObject[i]['name'] + "</option>");
					}else{
						$('#locationD').append("<option value=" + locationObject[i]['id'] + ">" + locationObject[i]['name'] + "</option>");
					}
				}else{
					$('#locationD').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			}
		});
	}
</script>
@endsection