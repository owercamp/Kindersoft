@extends('modules.increase')

@section('logisticModules')
	<div class="col-md-12">
		<div class="row border-bottom mb-3">
			<div class="col-md-12">
				<h5>ESTADISTICA</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<select name="rpStudent_id" class="form-control form-control-sm">
					<option value="">Seleccione un alumno...</option>
					@foreach($students as $student)
						@if ($student->status == 'ACTIVO')
							<option value="{{ $student->idStudent }}">{{ $student->nameStudent }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="col-md-6">
				<button type="button" class="bj-btn-table-add form-control-sm btn-seeStatistic">CONSULTAR</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center d-flex justify-content-center">
				<div class="spinner-border mt-4" align="center" role="status">
				  <span class="sr-only" align="center">Procesando...</span>
				</div>
			</div>
		</div>
		<div class="row sectionGrafic" style="display: none;">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<canvas id="statisticRating" width="300" height="150"></canvas>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<table class="table mt-3" border="1" width="100%" style="text-align: justify; font-size: 12px;">
							<tr>
								<th colspan="4" class="text-center">
									<b class="nameStudent-table">NINGUN ALUMNO SELECCIONADO</b>
								</th>
							</tr>
							<tr>
								<th></th>
								<th>PRIMER PERIODO</th>
								<th>SEGUNDO PERIODO</th>
								<th>TERCER PERIODO</th>
							</tr>
							<tr>
								<th>TOMA ANTROPOMETRICA 1</th>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted oneWeightFirst">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted oneHeightFirst">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted oneObservationFirst">Texto</small>
									</div>
								</td>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted oneWeightSecond">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted oneHeightSecond">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted oneObservationSecond">Texto</small>
									</div>
								</td>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted oneWeightThree">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted oneHeightThree">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted oneObservationThree">Texto</small>
									</div>
								</td>
							</tr>
							<tr>
								<th>TOMA ANTROPOMETRICA 2</th>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted twoWeightFirst">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted twoHeightFirst">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted twoObservationFirst">Texto</small>
									</div>
								</td>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted twoWeightSecond">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted twoHeightSecond">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted twoObservationSecond">Texto</small>
									</div>
								</td>
								<td>
									<div>
										<b>Peso: </b>
										<small class="text-muted twoWeightThree">0.00 (Kg)</small>
									</div>
									<div>
										<b>Talla:</b>
										<small class="text-muted twoHeightThree">0.00 (m.cm)</small>
									</div>
									<div>
										<b>Observacion:</b>
										<small class="text-muted twoObservationThree">Texto</small>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var img = new Image();
		var canvas = document.getElementById('statisticRating');
		var ctx = document.getElementById('statisticRating').getContext('2d');
		var statistic = new Chart(ctx, {
		    type: 'line',
		    data: {
		        labels: ['PRIMER PERIODO','SEGUNDO PERIODO','TERCER PERIODO'],
		        datasets: [
		        	{
			            label: 'PESO 1',
			            data: [
			            		0,
			            		0,
			            		0
			            	],
			            backgroundColor: [
			                '#ff5500',
			                '#ff5500',
			                '#ff5500'
			            ],
			            borderColor: [
			                '#ff5500',
			                '#ff5500',
			                '#ff5500'
			            ],
			            fill: false,
			            borderWidth: 2
			        },
			        {
			            label: 'PESO 2',
			            data: [
			            		0,
			            		0,
			            		0
			            	],
			            backgroundColor: [
			                '#fd8701',
			                '#fd8701',
			                '#fd8701'
			            ],
			            borderColor: [
			                '#fd8701',
			                '#fd8701',
			                '#fd8701'
			            ],
			            fill: false,
			            borderWidth: 2
			        },
			        {
			            label: 'TALLA 1',
			            data: [
			            		0,
			            		0,
			            		0
			            	],
			            backgroundColor: [
			                '#85c4f9',
			                '#85c4f9',
			                '#85c4f9'
			            ],
			            borderColor: [
			                '#85c4f9',
			                '#85c4f9',
			                '#85c4f9'
			            ],
			            fill: false,
			            borderWidth: 2
			        },
			        {
			            label: 'TALLA 2',
			            data: [
			            		0,
			            		0,
			            		0
			            	],
			            backgroundColor: [
			                '#0086f9',
			                '#0086f9',
			                '#0086f9'
			            ],
			            borderColor: [
			                '#0086f9',
			                '#0086f9',
			                '#0086f9'
			            ],
			            fill: false,
			            borderWidth: 2
			        }
		        ]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true
		                }
		            }]
		        }
		    }
		});

		$(function(){
			$('.spinner-border').css('display','none');
			$('.sectionGrafic').css('display','block');
		});

		$('.btn-seeStatistic').on('click',function(){
			var idStudent = $('select[name=rpStudent_id] option:selected').val();
			var nameStudent = $('select[name=rpStudent_id] option:selected').text();
			$('.nameStudent-table').text('');
			if(idStudent != ''){
				$.ajax({
					type: 'GET',
					url: "{{ route('rating.grafic') }}",
					data: {rpStudent_id: idStudent},
					dataType: 'json',
					async: false
				}).done(function(response){
					$('.nameStudent-table').text(nameStudent);
					for (var i = 0; i <= 5; i++) {
						if(i >= 0 && i <= 3){
							statistic.data.datasets[i].data = response[i];	
							if(i == 0){
								$('.oneWeightFirst').text(response[i][0] + ' (Kg)');
								$('.oneWeightSecond').text(response[i][1] + ' (Kg)');
								$('.oneWeightThree').text(response[i][2] + ' (Kg)');
							}else if(i == 1){
								$('.twoWeightFirst').text(response[i][0] + ' (Kg)');
								$('.twoWeightSecond').text(response[i][1] + ' (Kg)');
								$('.twoWeightThree').text(response[i][2] + ' (Kg)');
							}else if(i == 2){
								$('.oneHeightFirst').text(response[i][0] + ' (m.cm)');
								$('.oneHeightSecond').text(response[i][1] + ' (m.cm)');
								$('.oneHeightThree').text(response[i][2] + ' (m.cm)');
							}else if(i == 3){
								$('.twoHeightFirst').text(response[i][0] + ' (m.cm)');
								$('.twoHeightSecond').text(response[i][1] + ' (m.cm)');
								$('.twoHeightThree').text(response[i][2] + ' (m.cm)');
							}
						}
						if(i == 4){
							$('.oneObservationFirst').text(response[i][0]);
							$('.oneObservationSecond').text(response[i][1]);
							$('.oneObservationThree').text(response[i][2]);
						}else if(i == 5){
							$('.twoObservationFirst').text(response[i][0]);
							$('.twoObservationSecond').text(response[i][1]);
							$('.twoObservationThree').text(response[i][2]);
						}
					}
					statistic.update();
					convertCanvasToImage();
				});
			}else{
				$('.nameStudent-table').text('NINGUN ALUMNO SELECCIONADO');
				$('.oneWeightFirst').text('0.00 (Kg)');
				$('.oneWeightSecond').text('0.00 (Kg)');
				$('.oneWeightThree').text('0.00 (Kg)');
				$('.twoWeightFirst').text('0.00 (Kg)');
				$('.twoWeightSecond').text('0.00 (Kg)');
				$('.twoWeightThree').text('0.00 (Kg)');
				$('.oneHeightFirst').text('00.00 (m.cm)');
				$('.oneHeightSecond').text('00.00 (m.cm)');
				$('.oneHeightThree').text('00.00 (m.cm)');
			}
		});

		function convertCanvasToImage() {
			img.src = canvas.toDataURL("image/png");
		}
	</script>
@endsection