@extends('modules.reports')

@section('logisticModules')
	<div class="col-md-12">
		<div class="row my-3 border-bottom">
			<div class="col-md-12">
				<h4>INFORME DE ACUDIENTES</h4>
			</div>
		</div>
		<div class="row" style="font-size: 12px;">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="form-group">
							<small class="text-muted">ALUMNO:</small>
							<select name="legId" class="form-control form-control-sm select2">
								<option value="">Seleccione ...</option>
								@for($i = 0; $i < count($dates); $i++)
									<option value="{{ $dates[$i][0] }}"
									data-student="{{ $dates[$i][1] }}"
									data-attendant_One="{{ $dates[$i][2] }}"
									data-phoneone_One="{{ $dates[$i][3] }}"
									data-phonetwo_One="{{ $dates[$i][4] }}"
									data-whatsapp_One="{{ $dates[$i][5] }}"
									data-emailone_One="{{ $dates[$i][6] }}"
									data-emailtwo_One="{{ $dates[$i][7] }}"
									data-attendant_Two="{{ $dates[$i][8] }}"
									data-phoneone_Two="{{ $dates[$i][9] }}"
									data-phonetwo_Two="{{ $dates[$i][10] }}"
									data-whatsapp_Two="{{ $dates[$i][11] }}"
									data-emailone_Two="{{ $dates[$i][12] }}"
									data-emailtwo_Two="{{ $dates[$i][13] }}"
									>{{ $dates[$i][1] }}</option>
								@endfor
							</select>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="row p-4 text-center bj-spinner">
			                        <div class="col-md-12">
			                            <div class="spinner-border" align="center" role="status">
			                                <span class="sr-only" align="center">Procesando...</span>
			                            </div>
			                        </div>
			                    </div>
								<div class="row sectionInformation" style="font-size: 12px; display: none;">
									<div class="col-md-6 text-center">
										<h6>ACUDIENTE 1</h6><br>
										<small class="text-muted">NOMBRE:</small><br>
										<p class="attendant_One_info"></p>
										<small class="text-muted">TELEFONO 1:</small><br>
										<p class="phoneone_One_info"></p>
										<small class="text-muted">TELEFONO 2:</small><br>
										<p class="phonetwo_One_info"></p>
										<small class="text-muted">WHATSAPP:</small><br>
										<p class="whatsapp_One_info"></p>
										<small class="text-muted">CORREO 1:</small><br>
										<p class="emailone_One_info"></p>
										<small class="text-muted">CORREO 2:</small><br>
										<p class="emailtwo_One_info"></p>
									</div>
									<div class="col-md-6 text-center">
										<h6>ACUDIENTE 2</h6><br>
										<small class="text-muted">NOMBRE:</small><br>
										<p class="attendant_Two_info"></p>
										<small class="text-muted">TELEFONO 1:</small><br>
										<p class="phoneone_Two_info"></p>
										<small class="text-muted">TELEFONO 2:</small><br>
										<p class="phonetwo_Two_info"></p>
										<small class="text-muted">WHATSAPP:</small><br>
										<p class="whatsapp_Two_info"></p>
										<small class="text-muted">CORREO 1:</small><br>
										<p class="emailone_Two_info"></p>
										<small class="text-muted">CORREO 2:</small><br>
										<p class="emailtwo_Two_info"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){
			$('.bj-spinner').css('display','none');
		});

		$('select[name=legId]').on('change',function(){
			var selected = $(this).val();
			$('.bj-spinner').css('display','block');
			$('.sectionInformation').css('display','none');
			if(selected != ''){
				var student = $(this).find('option:selected').attr('data-student');
				var attendant_One = ($(this).find('option:selected').attr('data-attendant_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-attendant_One'));
				var phoneone_One = ($(this).find('option:selected').attr('data-phoneone_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-phoneone_One'));
				var phonetwo_One = ($(this).find('option:selected').attr('data-phonetwo_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-phonetwo_One'));
				var whatsapp_One = ($(this).find('option:selected').attr('data-whatsapp_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-whatsapp_One'));
				var emailone_One = ($(this).find('option:selected').attr('data-emailone_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-emailone_One'));
				var emailtwo_One = ($(this).find('option:selected').attr('data-emailtwo_One') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-emailtwo_One'));

				var attendant_Two = ($(this).find('option:selected').attr('data-attendant_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-attendant_Two'));
				var phoneone_Two = ($(this).find('option:selected').attr('data-phoneone_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-phoneone_Two'));
				var phonetwo_Two = ($(this).find('option:selected').attr('data-phonetwo_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-phonetwo_Two'));
				var whatsapp_Two = ($(this).find('option:selected').attr('data-whatsapp_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-whatsapp_Two'));
				var emailone_Two = ($(this).find('option:selected').attr('data-emailone_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-emailone_Two'));
				var emailtwo_Two = ($(this).find('option:selected').attr('data-emailtwo_Two') == '' ? 'Sin registrar' : $(this).find('option:selected').attr('data-emailtwo_Two'));

				$('.attendant_One_info').text(attendant_One);
				$('.phoneone_One_info').text(phoneone_One);
				$('.phonetwo_One_info').text(phonetwo_One);
				$('.whatsapp_One_info').text(whatsapp_One);
				$('.emailone_One_info').text(emailone_One);
				$('.emailtwo_One_info').text(emailtwo_One);
				$('.attendant_Two_info').text(attendant_Two);
				$('.phoneone_Two_info').text(phoneone_Two);
				$('.phonetwo_Two_info').text(phonetwo_Two);
				$('.whatsapp_Two_info').text(whatsapp_Two);
				$('.emailone_Two_info').text(emailone_Two);
				$('.emailtwo_Two_info').text(emailtwo_Two);
				$('.bj-spinner').css('display','none');
				$('.sectionInformation').css('display','flex');
			}else{
				setTimeout(function(){
					$('.bj-spinner').css('display','none');
				},500);
			}
		});
	</script>
@endsection