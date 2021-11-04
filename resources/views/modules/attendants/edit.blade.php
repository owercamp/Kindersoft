@extends('modules.humans')

@section('humans')
<div class="row card">
	<div class="card-header">
		<div class="row text-center">
			<div class="col-md-6">
				<h6 class="text-muted">MODIFICACION DE ACUDIENTE: <b>{{ $attendant->threename }}, {{ $attendant->firstname }}</b></h6>
			</div>
			<div class="col-md-6">
				<a href="{{ route('attendants') }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
			</div>
		</div>
	</div>
	<form id="formAttendantUpdate" action="{{ route('attendant.update', $attendant->id) }}" method="POST">
		@csrf
		<div class="card-body col-md-12">
			<div class="row">
				<div class="col-md-6 border-right">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<small class="text-muted">TIPO DE DOCUMENTO: *</small>
								<select class="form-control form-control-sm" name="typedocument_id_edit" required="required">
									<option value="">Seleccione tipo...</option>
									@foreach($documents as $document)
									@if($document->id == $attendant->typedocument_id)
									@php $namedocument = $document->type @endphp
									<option value="{{ $document->id }}" selected="selected">{{ $document->type }}</option>
									@else
									<option value="{{ $document->id }}">{{ $document->type }}</option>
									@endif
									@endforeach
								</select>
								@if( $document->type === "")
								<small for="typedocument_id_edit" class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small for="typedocument_id_edit" class="text-muted">Actualmente es <b>{{ __('') }}</b></small>
								@endif
							</div>
							<div class="col-md-6">
								<small class="text-muted">NÚMERO DE DOCUMENTO: *</small>
								<input type="number" name="numberdocument_edit" class="form-control form-control-sm" value="{{ $attendant->numberdocument }}" required>
								<small class="text-muted">Actualmente es <b>{{ $attendant->numberdocument }}</b></small>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<small class="text-muted">NOMBRES: *</small>
								<input type="text" name="firstname_edit" class="form-control form-control-sm" value="{{ $attendant->firstname }}" required>
								<small class="text-muted">Actualmente es <b>{{ $attendant->firstname }}</b></small>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<small class="text-muted">APELLIDOS: *</small>
								<input type="text" name="threename_edit" class="form-control form-control-sm" required value="{{ $attendant->threename }}">
								<small class="text-muted">Actualmente es <b>{{ $attendant->threename }}</b></small>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<small class="text-muted">TIPO DE SANGRE: *</small>
								<select class="form-control form-control-sm" name="bloodtype_id_edit" required>
									<option value="">Seleccione grupo...</option>
									@php $namebloodtypes = '' @endphp
									@foreach($bloodtypes as $bloodtype)
									@if($bloodtype->id == $attendant->bloodtype_id)
									@php $namebloodtypes = $bloodtype->group . " " . $bloodtype->type @endphp
									<option value="{{ $bloodtype->id }}" selected>{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
									@else
									<option value="{{ $bloodtype->id }}">{{ $bloodtype->group }} {{ $bloodtype->type }}</option>
									@endif
									@endforeach
								</select>
								@if($namebloodtypes === '')
								<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Actualmente es <b>{{ $namebloodtypes }}</b></small>
								@endif
							</div>
							<div class="col-md-6">
								<small class="text-muted">GENERO: *</small>
								<select class="form-control form-control-sm" id="gender_edit" name="gender_edit" required>
									<option value="">Seleccione genero...</option>
									<option value="MASCULINO">MASCULINO</option>
									<option value="FEMENINO">FEMENINO</option>
									<option value="INDEFINIDO">INDEFINIDO</option>
								</select>
								<input type="hidden" id="genderActual" value="{{ $attendant->gender }}">
								<small id="genderActualView" for="gender_edit" class="text-muted">Actualmente es <b>{{ $attendant->gender }}</b></small>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 border-left">
					<div class="form-group">
						<small class="text-muted">CIUDAD: *</small>
						<select class="form-control form-control-sm" id="cityhome_id_edit" name="cityhome_id_edit" required="required">
							<option value="">Seleccione ciudad...</option>
							@php $namecity = '' @endphp
							@foreach($citys as $city)
							@if($city->id == $attendant->cityhome_id)
							@php $namecity = $city->name @endphp
							<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
							@else
							<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endif
							@endforeach
						</select>
						<!-- @ if($namecity == '')
								<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
							@ else
								<small class="text-muted">Referencia actual <b>{{ $namecity }}</b></small>
							@ endif -->
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<small class="text-muted">LOCALIDAD: *</small>
								<input type="hidden" id="locationhome_id_hidden" value="{{ $attendant->locationhome_id }}">
								<select class="form-control form-control-sm" id="locationhome_id_edit" name="locationhome_id_edit" required>
									<option value="">Seleccione localidad...</option>
									<!-- Options dinamics -->
								</select>
								<!-- @ if($attendant->locationhome_id == '')
										<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
									@ else
										<small class="text-muted">Referencia actual <b>{{ $attendant->locationhome_id }}</b></small>
									@ endif -->
							</div>
							<div class="col-md-6">
								<small class="text-muted">BARRIO: *</small>
								<input type="hidden" id="dictricthome_id_hidden" value="{{ $attendant->dictricthome_id }}">
								<select class="form-control form-control-sm" id="dictricthome_id_edit" name="dictricthome_id_edit" required>
									<option value="">Seleccione barrio...</option>
									<!-- Options dinamics -->
								</select>
								<!-- @ if($attendant->dictricthome_id == '')
										<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
									@ else
										<small class="text-muted">Referencia actual <b>{{ $attendant->dictricthome_id }}</b></small>
									@ endif -->
							</div>
						</div>
					</div>
					<div class="form-group">
						<small class="text-muted">DIRECCIÓN: *</small>
						<input type="text" name="address_edit" class="form-control form-control-sm" required value="{{ $attendant->address }}">
						<small class="text-muted">Actualmente es <b>{{ $attendant->address }}</b></small>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<small class="text-muted">TELEFONO 1: *</small>
								<input type="number" name="phoneone_edit" class="form-control form-control-sm" required value="{{ $attendant->phoneone }}">
								<small class="text-muted">Actualmente es <b>{{ $attendant->phoneone }}</b></small>
							</div>
							<div class="col-md-4">
								<small class="text-muted">TELEFONO 2:</small>
								<input type="number" name="phonetwo_edit" class="form-control form-control-sm" value="{{ $attendant->phonetwo }}">
								@if($attendant->phonetwo == '')
								<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Actualmente es <b>{{ $attendant->phonetwo }}</b></small>
								@endif
							</div>
							<div class="col-md-4">
								<small class="text-muted">WHATSAPP:</small>
								<input type="number" name="whatsapp_edit" class="form-control form-control-sm" value="{{ $attendant->whatsapp }}">
								@if($attendant->whatsapp == '')
								<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Actualmente es <b>{{ $attendant->whatsapp }}</b></small>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row border-top">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<small class="text-muted">CORREO ELECTRÓNICO 1: *</small>
							<input type="email" name="emailone_edit" class="form-control form-control-sm" value="{{ $attendant->emailone }}" required>
							@if($attendant->emailone == '')
							<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
							@else
							<small class="text-muted">Actualmente es <b>{{ $attendant->emailone }}</b></small>
							@endif
						</div>
						<div class="col-md-6">
							<small class="text-muted">CORREO ELECTRÓNICO 2:</small>
							<input type="email" name="emailtwo_edit" class="form-control form-control-sm" value="{{ $attendant->emailtwo }}">
							@if($attendant->emailtwo == '')
							<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
							@else
							<small class="text-muted">Actualmente es <b>{{ $attendant->emailtwo }}</b></small>
							@endif
						</div>
					</div>
				</div>
			</div>

			<div class="row border-top">

				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">PROFESION: *</small>
						<select class="form-control form-control-sm" name="profession_id_edit" required>
							<option value="">Seleccione profesión...</option>
							@php $nameprofession = '' @endphp
							@foreach($professions as $profession)
							@if($profession->id == $attendant->profession_id)
							@php $nameprofession = $profession->title @endphp
							<option value="{{ $profession->id }}" selected>{{ $profession->title }}</option>
							@else
							<option value="{{ $profession->id }}">{{ $profession->title }}</option>
							@endif
							@endforeach
						</select>
						@if($nameprofession === '')
						<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
						@else
						<small class="text-muted">Actualmente es <b>{{ $nameprofession }}</b></small>
						@endif
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<small class="text-muted">CARGO:</small>
								<input type="text" name="position_edit" class="form-control form-control-sm" value="{{ $attendant->position }}">
								@if($attendant->position == '')
								<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Actualmente es <b>{{ $attendant->position }}</b></small>
								@endif
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<small for="antiquity_edit" class="text-muted">FECHA DE INICIO:</small>
								<input type="text" name="antiquity_edit" class="form-control form-control-sm datepicker" value="{{ $attendant->antiquity }}">
								@if($attendant->antiquity == '' || $attendant->antiquity == 0)
								<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Actualmente es <b>{{ $attendant->antiquity }}</b></small>
								@endif
							</div>
							<div class="col-md-6">
								<small class="text-muted">ANTIGUEDAD EN AÑOS:</small>
								<input type="text" name="antiquity_years" class="form-control form-control-sm text-center" value="0" disabled>
							</div>
						</div>
					</div>
					<div class="form-group">
						<small class="text-muted">EMPRESA DONDE LABORA:</small>
						<input type="text" name="company_edit" class="form-control form-control-sm" value="{{ $attendant->company }}">
						@if($attendant->company == '')
						<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
						@else
						<small class="text-muted">Actualmente es <b>{{ $attendant->company }}</b></small>
						@endif
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">CIUDAD DE EMPRESA: *</small>
						<select class="form-control form-control-sm" id="citycompany_id_edit" name="citycompany_id_edit" required>
							<option value="">Seleccione ciudad...</option>
							@php $namecitycompany = '' @endphp
							@foreach($citys as $city)
							@if($city->id == $attendant->citycompany_id)
							@php $namecitycompany = $city->name @endphp
							<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
							@else
							<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endif
							@endforeach
						</select>
						@if($namecitycompany == '')
						<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
						@else
						<small class="text-muted">Referencia actual <b>{{ $namecitycompany }}</b></small>
						@endif
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<small class="text-muted">LOCALIDAD DE EMPRESA:</small>
								<input type="hidden" id="locationcompany_id_hidden" value="{{ $attendant->locationcompany_id }}">
								<select class="form-control form-control-sm" id="locationcompany_id_edit" name="locationcompany_id_edit">
									<option value="">Seleccione localidad...</option>
									<!-- Options dinamics -->
								</select>
								@if($attendant->locationcompany_id == '')
								<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Referencia actual <b>{{ $attendant->locationcompany_id }}</b></small>
								@endif
							</div>
							<div class="col-md-6">
								<small class="text-muted">BARRIO DE EMPRESA:</small>
								<input type="hidden" id="dictrictcompany_id_hidden" value="{{ $attendant->dictrictcompany_id }}">
								<select class="form-control form-control-sm" id="dictrictcompany_id_edit" name="dictrictcompany_id_edit">
									<option value="">Seleccione barrio...</option>
									<!-- Options dinamics -->
								</select>
								@if($attendant->dictrictcompany_id == '')
								<small class="text-muted">Referencia actual <b>{{ __('Dato vacio') }}</b></small>
								@else
								<small class="text-muted">Referencia actual <b>{{ $attendant->dictrictcompany_id }}</b></small>
								@endif
							</div>
						</div>
					</div>

					<div class="form-group">
						<small class="text-muted">DIRECCIÓN DE EMPRESA:</small>
						<input type="text" name="addresscompany_edit" class="form-control form-control-sm" value="{{ $attendant->addresscompany }}">
						@if($attendant->addresscompany == '')
						<small class="text-muted">Actualmente es <b>{{ __('Dato vacio') }}</b></small>
						@else
						<small class="text-muted">Actualmente es <b>{{ $attendant->addresscompany }}</b></small>
						@endif
					</div>
				</div>
			</div>

		</div>

		<div class="card-footer">
			<div class="row">
				<div class="col-md-6 text-center">
					<button type="submit" id="saveAttendant" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIOS</button>
				</div>
				<div class="col-md-6 text-center">
					<div class="messageAttendant alert">
						@if(count($errors) > 0)
						@foreach($errors->all() as $error)
						<p>{{ $error }}</p>
						@endforeach
						@endif
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
@endsection


@section('scripts')
<script>
	$(document).ready(function() {

		var dateAntiquity = $('input[name=antiquity_edit]').val();
		calculateYears(dateAntiquity);
		var valueGenderActual = $('#genderActual').val();
		$("#gender_edit option[value=" + valueGenderActual + "]").attr("selected", true);

		var cityhome_id = $("select[name=cityhome_id_edit]").val();
		var citycompany_id = $("select[name=citycompany_id_edit]").val();
		if (cityhome_id > 0) {
			//Llenar select de las localidades
			fullSelectHome(cityhome_id);
			fullSelectCompany(citycompany_id);
		}


		$("#cityhome_id_edit").on("change", function(e) {
			var cityhome_id = e.target.value;
			$.get("{{ route('edit.sublocation') }}", {
				cityhome_id: cityhome_id
			}, function(locationObject) {
				var count = Object.keys(locationObject).length //total de localidades devueltas
				$('#locationhome_id_edit').empty();
				$('#locationhome_id_edit').append("<option value=''>Seleccione localidad...</option>");
				$('#dictricthome_id_edit').empty();
				$('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('#locationhome_id_edit').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			});
		});
		$("#locationhome_id_edit").on("change", function(e) {
			var locationhome_id = e.target.value;
			$.get("{{ route('edit.subdistrict') }}", {
				locationhome_id: locationhome_id
			}, function(districtObject) {
				var count = Object.keys(districtObject).length //total de barrios devueltos
				$('#dictricthome_id_edit').empty();
				$('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('#dictricthome_id_edit').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
				}
			});
		});

		$("#citycompany_id_edit").on("change", function(e) {
			var citycompany_id = e.target.value;
			$.get("{{ route('edit.sublocation') }}", {
				cityhome_id: citycompany_id
			}, function(locationObject) {
				var count = Object.keys(locationObject).length //total de localidades devueltas
				$('#locationcompany_id_edit').empty();
				$('#locationcompany_id_edit').append("<option value=''>Seleccione localidad...</option>");
				$('#dictrictcompany_id_edit').empty();
				$('#dictrictcompany_id_edit').append("<option value=''>Seleccione barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('#locationcompany_id_edit').append("<option value='" + locationObject[i]['id'] + "'>" + locationObject[i]['name'] + "</option>");
				}
			});
		});
		$("#locationcompany_id_edit").on("change", function(e) {
			var locationcompany_id = e.target.value;
			$.get("{{ route('edit.subdistrict') }}", {
				locationhome_id: locationcompany_id
			}, function(districtObject) {
				var count = Object.keys(districtObject).length //total de barrios devueltos
				$('#dictrictcompany_id_edit').empty();
				$('#dictrictcompany_id_edit').append("<option value=''>Seleccione barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('#dictrictcompany_id_edit').append("<option value='" + districtObject[i]['id'] + "'>" + districtObject[i]['name'] + "</option>");
				}
			});
		});

	});

	function fullSelectHome(value) {
		$.get("{{ route('edit.sublocation') }}", {
			cityhome_id: value
		}, function(locationObject) {
			var count = Object.keys(locationObject).length //total de localidades devueltas
			$('#locationhome_id_edit').empty();
			$('#locationhome_id_edit').append("<option value=''>Seleccione localidad...</option>");
			var locationhome_id_hidden = $('#locationhome_id_hidden').val();
			for (var i = 0; i < count; i++) {
				if (locationhome_id_hidden != '') {
					if (locationhome_id_hidden == locationObject[i]['id']) {
						$('#locationhome_id_edit').append("<option value=" + locationObject[i]['id'] + " selected>" + locationObject[i]['name'] + "</option>");
					} else {
						$('#locationhome_id_edit').append("<option value=" + locationObject[i]['id'] + ">" + locationObject[i]['name'] + "</option>");
					}
				} else {
					$('#locationhome_id_edit').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			}
			var locationhome_id_result = $('select[id=locationhome_id_edit]').val();
			$.get("{{ route('edit.subdistrict') }}", {
				locationhome_id: locationhome_id_result
			}, function(districtObject) {
				var count = Object.keys(districtObject).length //total de barrios devueltos
				$('#dictricthome_id_edit').empty();
				$('#dictricthome_id_edit').append("<option value=''>Seleccione barrio...</option>");
				var dictricthome_id_hidden = $('#dictricthome_id_hidden').val();
				for (var i = 0; i < count; i++) {
					if (dictricthome_id_hidden != '') {
						if (dictricthome_id_hidden == districtObject[i]['id']) {
							$('#dictricthome_id_edit').append("<option value=" + districtObject[i]['id'] + " selected>" + districtObject[i]['name'] + "</option>");
						} else {
							$('#dictricthome_id_edit').append("<option value=" + districtObject[i]['id'] + ">" + districtObject[i]['name'] + "</option>");
						}
					} else {
						$('#dictricthome_id_edit').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
					}
				}
			});
		});
	}

	function fullSelectCompany(value) {
		$.get("{{ route('edit.sublocation') }}", {
			cityhome_id: value
		}, function(locationObject) {
			var count = Object.keys(locationObject).length //total de localidades devueltas
			$('#locationcompany_id_edit').empty();
			$('#locationcompany_id_edit').append("<option value=''>Seleccione localidad...</option>");
			var locationcompany_id_hidden = $('#locationcompany_id_hidden').val();
			for (var i = 0; i < count; i++) {
				if (locationcompany_id_hidden != '') {
					if (locationcompany_id_hidden == locationObject[i]['id']) {
						$('#locationcompany_id_edit').append("<option value=" + locationObject[i]['id'] + " selected>" + locationObject[i]['name'] + "</option>");
					} else {
						$('#locationcompany_id_edit').append("<option value=" + locationObject[i]['id'] + ">" + locationObject[i]['name'] + "</option>");
					}
				} else {
					$('#locationcompany_id_edit').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			}
			var locationcompany_id_result = $('select[id=locationcompany_id_edit]').val();
			$.get("{{ route('edit.subdistrict') }}", {
				locationhome_id: locationcompany_id_result
			}, function(districtObject) {
				var count = Object.keys(districtObject).length //total de barrios devueltos
				$('#dictrictcompany_id_edit').empty();
				$('#dictrictcompany_id_edit').append("<option value=''>Seleccione barrio...</option>");
				var dictrictcompany_id_hidden = $('#dictrictcompany_id_hidden').val();
				for (var i = 0; i < count; i++) {
					if (dictrictcompany_id_hidden != '') {
						if (dictrictcompany_id_hidden == districtObject[i]['id']) {
							$('#dictrictcompany_id_edit').append("<option value=" + districtObject[i]['id'] + " selected>" + districtObject[i]['name'] + "</option>");
						} else {
							$('#dictrictcompany_id_edit').append("<option value=" + districtObject[i]['id'] + ">" + districtObject[i]['name'] + "</option>");
						}
					} else {
						$('#dictrictcompany_id_edit').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
					}
				}
			});
		});
	}

	$('input[name=antiquity_edit]').on('change', function() {
		calculateYears($(this).val());
	});

	function calculateYears(date) {
		if (!date) {
			$('input[name=antiquity_years]').val('No se registra fecha de inicio');
		} else {
			let dayNow = new Date();
			let dateAntiquity = new Date(date);
			let year = dayNow.getFullYear();
			let dateAnti = dateAntiquity.getFullYear();
			let diff = year - dateAnti;
			$('input[name=antiquity_years]').val(("00" + diff).slice(-2) + " años");
		}
	}
</script>
@endsection