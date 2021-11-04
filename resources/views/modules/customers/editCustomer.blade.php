@extends('modules.customers')

@section('customersComercial')
	<div class="row">
		<div class="card col-md-12">
			<form action="{{ route('customer.update',$customer->id) }}" method="POST">
				@csrf
				<div class="card-body col-md-12">
					<small class="text-muted">DATOS DE CLIENTE: <b>{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</b></small>
					@if($scheduling < 1)
						<small class="text-muted">CON: <span class="badge badge-warning">{{ $scheduling }}</span> AGENDAMIENTOS EN SU HISTORIAL</small>
					@else
						<small class="text-muted">CON: <span class="badge badge-success">{{ $scheduling }}</span> AGENDAMIENTO/S EN SU HISTORIAL</small>
					@endif
					<div class="row border-bottom">
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">Nombres:</small>
								<input type="text" name="cusFirstname" class="form-control form-control-sm" required value="{{ $customer->cusFirstname }}">
								<small class="text-muted">Actualmente es <b>{{ $customer->cusFirstname }}</b></small><br>
								<small class="text-muted">Apellidos:</small>
								<input type="text" name="cusLastname" class="form-control form-control-sm" required value="{{ $customer->cusLastname }}">
								<small class="text-muted">Actualmente es <b>{{ $customer->cusLastname }}</b></small><br>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<small class="text-muted">Correo electrónico:</small>
									<input type="email" name="cusMail" class="form-control form-control-sm" value="{{ $customer->cusMail }}">
									<small class="text-muted">Actualmente es <b>{{ $customer->cusMail }}</b></small><br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<small class="text-muted">Número de contacto:</small>
										<input type="number" name="cusPhone" class="form-control form-control-sm" required value="{{ $customer->cusPhone }}">
										<small class="text-muted">Actualmente es <b>{{ $customer->cusPhone }}</b></small><br>
									</div>
									
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<small class="text-muted">Forma de contacto:</small>
										<input type="hidden" name="contactHidden" class="form-control form-control-sm" value="{{ $customer->cusContact }}">
										<select name="cusContact" class="form-control form-control-sm" required>
											<option value="">Seleccione una opción...</option>
											<option value="LLAMADA TELEFÓNICA">LLAMADA TELEFÓNICA</option>
											<option value="VISITA PUERTA">VISITA PUERTA</option>
											<option value="PÁGINA WEB">PÁGINA WEB</option>
											<option value="REDES SOCIALES">REDES SOCIALES</option>
											<option value="CORREO ELECTRÓNICO">CORREO ELECTRÓNICO</option>
											<option value="OTRO">OTRO</option>
										</select>
									</div>
								</div>
							</div>
							
							<!-- <div class="form-group">
								<small class="text-muted">Forma de contacto:</small>
								<select name="cusContact" class="form-control form-control-sm" required>
									<option value="">Seleccione una opción...</option>
									<option value="LLAMADA TELEFÓNICA">LLAMADA TELEFÓNICA</option>
									<option value="VISITA PUERTA">VISITA PUERTA</option>
									<option value="PÁGINA WEB">PÁGINA WEB</option>
									<option value="REDES SOCIALES">REDES SOCIALES</option>
									<option value="CORREO ELECTRÓNICO">CORREO ELECTRÓNICO</option>
									<option value="OTRO">OTRO</option>
								</select>
							</div> -->
						</div>
					</div><!-- Fin de fila -->
					<small class="text-muted">DATOS DE ASPIRANTE</small>
					<div class="row border-bottom">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<small class="text-muted">Nombres:</small>
										<input type="text" name="cusChild" class="form-control form-control-sm" required value="{{ $customer->cusChild }}">
										<small class="text-muted">Actualmente es <b>{{ $customer->cusChild }}</b></small><br>
									</div>
								</div>
							</div>
							<div class="row">
								<span hidden class="yearsoldChild-hidden">{{ $customer->cusChildYearsold }}</span>
								<div class="col-md-6">
									<div class="form-group">
										<small class="text-muted">Años:</small>
										<input type="text" name="cusChildYears" maxlength="1" pattern="[0-9]{1,1}" class="form-control form-control-sm text-center" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<small class="text-muted">Meses:</small>
										<input type="text" name="cusChildMount" maxlength="2" pattern="[0-9]{1,1}" class="form-control form-control-sm text-center" required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">Nota:</small>
								<textarea type="text" id="cusNotes" name="cusNotes" class="form-control form-control-sm" required placeholder="Máximo de 200 caracteres" maxlength="200">{{ $customer->cusNotes }}</textarea>
								<small class="text-muted">Carácteres restantes: <b id="lenChar"></b></small><br>
								<small class="text-muted">Actualmente es <b>{{ $customer->cusNotes }}</b></small><br>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-md-12 text-center">
							<button type="submit" class="bj-btn-table-edit form-control-sm">GUARDAR CAMBIOS</button>
							<a href="{{ route('customers') }}" class="bj-btn-table-delete form-control-sm">VOLVER</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection


@section('scripts')

	<script>
		$(function(){
			var lennow = $('textarea#cusNotes').val().length;
			var restLen = 200 - lennow;
			$('#lenChar').html(restLen + ' / 200');
			$('textarea#cusNotes').on('keyup',function(){
				var len = $(this).val().length;
				$('#lenChar').html(200 - len + ' / 200');
			});
			var valueContact = $('input[name=contactHidden]').val();
			$('select[name=cusContact] option').each(function(){
				var value = $(this).val();
				if(value == valueContact){
					$(this).attr('selected',true);
				}
			});
			var years = $('span.yearsoldChild-hidden').text();
			if(years.length > 10){
				$('input[name=cusChildYears]').val(years.substring(5,6));
				$('input[name=cusChildMount]').val(years.substring(16,17));
			}else{
				$('input[name=cusChildYears]').val(years);
				$('input[name=cusChildMount]').val(0);
			}
		});

		$('input[name=cusChildYearsold]').on('change', function(e){
			// calculateBirthdate(e.target.value);
		});

		function calculateBirthdate(date){
		    if(date != ''){
				var values=date.split("/");
		        var day = values[2];
		        var mount = values[1];
		        var year = values[0];
		        var now = new Date();
		        var date = new Date(date);
		        if(now >= date){
		        	var yearNow = now.getYear()
			        var mountNow = now.getMonth()+1;
			        var dayNow = now.getDate();
			        //Cálculo de años
			        var old = (yearNow + 1900) - year;
			        if ( mountNow < mount ){ old--; }
			        if ((mount == mountNow) && (dayNow < day)){ old--; }
			        if (old > 1900){ old -= 1900; }
			        //Cálculo de meses
			        var mounts=0;
			        if(mountNow>mount){ mounts=mountNow-mount; }
			        if(mountNow<mount){ mounts=12-(mount-mountNow); }
			        if(mountNow==mount && day>dayNow){ mounts=11; }
					//Cálculo de dias
			        var days=0;
			        if(dayNow>day){ days=dayNow-day }
			        if(dayNow<day){ 
			        	lastDayMount = new Date(yearNow, mountNow, 0);
			            days=lastDayMount.getDate()-(day-dayNow);
			        }
			        $('input[name=cusChildYears]').val(old);
					$('input[name=cusChildMount]').val(mounts);
					//$('#dayold').val(days); //Opcional para mostrar dias también
		        }else{
		        	$('input[name=cusChildYears]').val('');
					$('input[name=cusChildMount]').val('');
		        }
		    }
		}
	</script>

@endsection

