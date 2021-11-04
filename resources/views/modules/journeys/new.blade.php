@extends('modules.services')

@section('services')
<div class="row card">
	<div class="card-header">
		<div class="row text-center">
			<div class="col-md-6">
				<h6 class="text-muted">REGISTRAR NUEVA JORNADA</h6>
				@if(count($errors) > 0)
					<div class="messageJourney alert alert-secondary">
					@foreach($errors->all() as $error)
						<p>{{ $error }}</p>
					@endforeach
					</div>
				@endif
				@if(session('SuccessSaveJourney'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveJourney') }}
				    </div>
				@endif
				@if(session('SecondarySaveJourney'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveJourney') }}
				    </div>
				@endif
				<div class="alert alertAjax"></div>
			</div>
			<div class="col-md-6">
				<a href="{{ route('journeys') }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
			</div>
		</div>
	</div>
	<form id="formNewJourney" action="{{ route('journey.save') }}" method="POST">
		@csrf
		<div class="card-body col-md-12">
			<div class="row">
				<div class="col-md-4 border-right">
					<div class="form-group">
						<small class="text-muted">NOMBRE/JORNADA:</small>
						<input type="text" name="jouJourney" class="form-control form-control-sm" value="{{ old('jouJourney') }}" required>
					</div>
					<div class="form-group justify-content-center" id="divBtn">
						<small class="text-muted">DIAS:</small>
						<a href="#" id="btn-addSelect" class="bj-btn-table-edit form-control-sm" title="AGREGAR DIA"><i class="fas fa-plus"></i></a>
						<a href="#" id="btn-remSelect" class="bj-btn-table-delete form-control-sm" title="QUITAR DIA"><i class="fas fa-minus"></i></a>
					</div>
					<div id="divSelects" class="form-group justify-content-center">
						<input type="hidden" id="fullDays" name="fullDays" required>
						<select class='form-control form-control-sm my-2 jouDays' name='jouDays[]' required>
							<option value=''>Seleccione dia...</option>
							<option value='LUNES'>LUNES</option>
							<option value='MARTES'>MARTES</option>
							<option value='MIERCOLES'>MIERCOLES</option>
							<option value='JUEVES'>JUEVES</option>
							<option value='VIERNES'>VIERNES</option>
							<option value='SABADO'>SABADO</option>
							<option value='DOMINGO'>DOMINGO</option>
						</select>
					</div>
				</div><!-- fin panel izquierdo -->

				<div class="col-md-4 border-left border-right">
					<div class="form-group">
						<small class="text-muted">HORA DE ENTRADA:</small>
						<input type="time" name="jouHourEntry" class="form-control form-control-sm" value="{{ old('jouHourEntry') }}" min="06:00" max="23:59" step="1" required>
					</div>
					<div class="form-group">
						<small class="text-muted">HORA DE SALIDA:</small>
						<input type="time" name="jouHourExit" class="form-control form-control-sm" value="{{ old('jouHourExit') }}" min="06:00" max="23:59" step="1" required>
					</div>
				</div><!-- Fin panel central -->

				<div class="col-md-4 border-left">
					<div class="form-group">
						<small class="text-muted">VALOR:</small>
						<input type="number" name="jouValue" class="form-control form-control-sm" value="{{ old('jouValue') }}" required>
					</div>
					<div class="form-group">
						<button id="saveJourney" type="submit" class="bj-btn-table-add form-control-sm">GUARDAR JORNADA</button>
					</div>
				</div><!-- Fin panel derecho -->
			</div>
		</div>
	</form>
</div>
@endsection


@section('scripts')
	<script>
		$(document).ready(function(){

			$('.alertAjax').css('display','none');

			$('#btn-addSelect').on('click',function(){
				var select = $('.jouDays:first').clone();
				$('#divSelects').append(select);
			});

			$('#btn-remSelect').on('click',function(){
				var count = $('.jouDays').length;
				if(count > 1){
					$('.jouDays:last').remove();
					setSelects();
				}
			});

			$('#divSelects').on('change','.jouDays',function(){
				setSelects();
			});
		});

		function setSelects(){
			var days = [].map.call($('.jouDays'), function( input ) {
			        return input.value;
			    }).join( ' - ' );
			$('#fullDays').val('');
			$('#fullDays').val(days);
		}
	</script>
@endsection