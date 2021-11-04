@extends('modules.humans')

@section('humans')
<div class="col-md-12 card">
	<div class="card-header">
		<div class="row text-center">
			<div class="col-md-6">
				<h6 class="text-muted">FICHA DE ALUMNO/A:</h6>
			</div>
			<div class="col-md-6">
				<a href="{{ url()->previous() }}" class="bj-btn-table-delete form-control-sm">VOLVER A LA TABLA GENERAL</a>
			</div>
		</div>
	</div>
	<div class="card-body col-md-12">
		<div class="row">
			<div class="col-md-6 text-center">
				<img src="{{ asset('storage/admisiones/fotosaspirantes/'.$MyPhoto) }}" class="img-thumbnail" style="width: 3cm; height: 4cm;"><br>
				<small class="text-muted"><b>{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</b></small><br>
				@foreach($documents as $document)
				@if($document->id == $student->typedocument_id)
				<small class="text-muted"><b>{{ $document->type }}</b></small><br>
				@endif
				@endforeach
				<small class="text-muted"><b>N° {{ $student->numberdocument }}</b></small><br>
				@foreach($bloodtypes as $bloodtype)
				@if($bloodtype->id == $student->bloodtype_id)
				<small class="text-muted"><b>{{ $bloodtype->group . ' ' . $bloodtype->type }}</b></small><br>
				@endif
				@endforeach
				<small class="text-muted"><b>{{ $student->gender }}</b></small><br>
				<small class="text-muted"><b class="formatBirthdate">{{ $student->birthdate }}</b></small><br>
				<small class="text-muted"><b class="formatYears">{{ $student->yearsold }}</b></small><br>
			</div>
			<div class="col-md-6 border-left text-left">
				@foreach($citys as $city)
				@if($city->id == $student->cityhome_id)
				<small class="text-muted">CIUDAD: </small><br>
				<small class="text-muted"><b>{{ $city->name }}</b></small><br>
				@endif
				@endforeach
				@foreach($locations as $location)
				@if($location->id == $student->locationhome_id)
				<small class="text-muted">LOCALIDAD: </small><br>
				<small class="text-muted"><b>{{ $location->name }}</b></small><br>
				@endif
				@endforeach
				@foreach($districts as $district)
				@if($district->id == $student->dictricthome_id)
				<small class="text-muted">BARRIO: </small><br>
				<small class="text-muted"><b>{{ $district->name }}</b></small><br>
				@endif
				@endforeach
				<small class="text-muted">DIRECCION: </small><br>
				<small class="text-muted"><b>{{ $student->address }}</b></small><br>
				@foreach($healths as $health)
				@if($health->id == $student->health_id)
				<small class="text-muted">AFILIACION A SALUD: </small><br>
				<small class="text-muted"><b>{{ $health->entity . '-' . $health->type }}</b></small><br>
				@endif
				@endforeach
				<small class="text-muted">SALUD ADICIONAL: </small><br>
				<small class="text-muted"><b>{{ $student->additionalHealt }}</b></small><br>
				<small class="text-muted">DESCRIPCION DE SALUD ADICIONAL: </small><br>
				<small class="text-muted"><b>{{ $student->additionalHealtDescription }}</b></small><br>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script>
	$(function() {
		var birthdate = $('.formatBirthdate').text(); //SE CAPTURA EN VARIABLE FORMATO DE FECHA.
		$('.formatBirthdate').text(returnDate(birthdate)); //SE LLAMA A LA FUNCION QUE CAMBIA EL FORMATO DE FECHA
		var yearsold = $('.formatYears').text(); //CAPTURA EL FORMATO DE EDAD, EJEMPLO: 2-5
		var dates = yearsold.split('-'); // SEPARA LOS NUMERO POR EL CARACTER (-), CONVIRTIENDO EN ARRAY LOS DATOS
		$('.formatYears').text(dates[0]); //PONER FORMATO NUEVO EN EL TEXTO DE DETALES
	});

	//FUNCTION QUE CAMBIA FORMATO DE FECHA
	function returnDate(date) {
		var datesbirth = date.split('-');
		switch (datesbirth[1]) {
			case '01':
				return datesbirth[2] + ' de ENERO del ' + datesbirth[0];
				break;
			case '02':
				return datesbirth[2] + ' de FEBRERO del ' + datesbirth[0];
				break;
			case '03':
				return datesbirth[2] + ' de MARZO del ' + datesbirth[0];
				break;
			case '04':
				return datesbirth[2] + ' de ABRIL del ' + datesbirth[0];
				break;
			case '05':
				return datesbirth[2] + ' de MAYO del ' + datesbirth[0];
				break;
			case '06':
				return datesbirth[2] + ' de JUNIO del ' + datesbirth[0];
				break;
			case '07':
				return datesbirth[2] + ' de JULIO del ' + datesbirth[0];
				break;
			case '08':
				return datesbirth[2] + ' de AGOSTO del ' + datesbirth[0];
				break;
			case '09':
				return datesbirth[2] + ' de SEPTIEMBRE del ' + datesbirth[0];
				break;
			case '10':
				return datesbirth[2] + ' de OCTUBRE del ' + datesbirth[0];
				break;
			case '11':
				return datesbirth[2] + ' de NOVIEMBRE del ' + datesbirth[0];
				break;
			case '12':
				return datesbirth[2] + ' de DICIEMBRE del ' + datesbirth[0];
				break;
		}
	}
</script>
@endsection