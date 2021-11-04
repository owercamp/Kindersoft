@extends('modules.events')

@section('eventsModules')
	<div class="col-md-12 p-3">
		<div class="row">
			<div class="col-md-6">
				@php $yearNow = date('Y') @endphp
				<div class="btn-group mx-3" role='group'>
					<a 	href="#" class="btn btn-primary btn-less"><i class="fas fa-angle-left"></i></a>
					<button class="px-3" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"> AÑO: </button>
					<button class="btn btn-default year" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">{{ $yearNow }}</button>
					<a 	href="#" class="btn btn-default btn-plus" disabled><i class="fas fa-angle-right"></i></a>
				</div>
			</div>
			<div class="col-md-6">
    			<!-- <div class="form-group">
    				<input type="hidden" class="form-control form-control-sm" name="year" value="{{ $yearNow }}" readonly required>
    				<input type="hidden" name="view_file" class="form-control form-control-sm" readonly required>
					<button type="button" class="bj-btn-table-delete mx-3 my-3 form-control-sm btn-drawPdf"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
    			</div> -->
			</div>
		</div>
		<div class="row border-top mt-10">
			<canvas id="statisticEvents" width="300" height="150"></canvas>
			<!-- <div class="col-md-12">
				@for($e = 0; $e < count($eventsAll); $e++)
					<table class="table table-hover text-center mt-4 border-top" width="100%" style="font-size: 10px;">
						<thead>
							<tr>
								<th>TIPO DE EVENTO: <b>{{ $eventsAll[$e][1][0] }}</b></th>
								<th>CANTIDAD</th>
							</tr>
						</thead>
						<tbody>
							@for($c = 1; $c <= 12; $c++)
							<tr>
								@if($c == '1') <td>ENERO</td> @endif
								@if($c == '2') <td>FEBRERO</td> @endif
								@if($c == '3') <td>MARZO</td> @endif
								@if($c == '4') <td>ABRIL</td> @endif
								@if($c == '5') <td>MAYO</td> @endif
								@if($c == '6') <td>JUNIO</td> @endif
								@if($c == '7') <td>JULIO</td> @endif
								@if($c == '8') <td>AGOSTO</td> @endif
								@if($c == '9') <td>SEPTIEMBRE</td> @endif
								@if($c == '10') <td>OCTUBRE</td> @endif
								@if($c == '11') <td>NOVIEMBRE</td> @endif
								@if($c == '12') <td>DICIEMBRE</td> @endif
								<td>{{ $eventsAll[$e][$c][1] }}</td>
							</tr>
							@endfor
						</tbody>
					</table>
				@endfor
			</div> -->
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var datesInitials = new Array({!! json_encode($eventsAll) !!});
		var img = new Image();
		var canvas = document.getElementById('statisticEvents');
		var ctx = document.getElementById('statisticEvents').getContext('2d');
		var statistic = new Chart(ctx, {
		    type: 'line',
		    data: {
		        labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'],
		        datasets: [{
		            label: 'TIPO DE EVENTO',
		            data: [
		            		{!! 0 !!}
		            	],
		            backgroundColor: [
		                '#a4b068'
		            ],
		            borderColor: [
		                '#a4b068'
		            ],
		            fill: false,
		            borderWidth: 1
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
			setGrafic();
		});

		function setGrafic(){
			statistic.data.datasets.length = 0;
			for (var i = 0; i < datesInitials[0].length; i++) {
				var rowDates = [];
				var colorDates = [];
				for (var m = 1; m <= 12; m++) {
					rowDates.push(datesInitials[0][i][m][1]);
					colorDates.push(getColor(i));
				}
				statistic.data.datasets.push({
					label: datesInitials[0][i][1][0],
		            data: rowDates,
		            backgroundColor: getColor(i),
		            borderColor: getColor(i),
		            fill: false,
		            borderWidth: 2
				});
			}
			statistic.update();
			convertCanvasToImage();
		}

		function getColor(number){
			var colors = ['#0086f9','#fd8701','#a4b068','#3e95cd','#8e5ea2','#3cba9f','#e8c3b9','#FF2413','#E846E0','#9959FF','#466EE8','#4DE8FF','#E8772A','#FF3B2E','#E8DC2A','#6CFF0D','#EBCA95','#E8BF2A','#FF992E','#7D601D','#695A42','#8A5219','#8A7807','#8A5143','#8A6389','#8AB972','#638A7C','#FF59A4','#4DFFA4','#1FFFF5'];
			return colors[number];
		}

		// $('.btn-drawPdf').on('click',function(e){
		// 	e.preventDefault();
		// 	convertCanvasToImage();
		// 	var pdf = new jsPDF();
		// 	pdf.setFontSize(15);
		// 	pdf.text('REPORTE DE EVENTOS DURANTE EL AÑO ' + $('button.year').text(), 30,25);
		// 	pdf.addImage(img,'png',20,40,170,90);
		// 	pdf.save("EVENTOS_" + $('button.year').text() + "_GENERADO EL " + Date() + ".pdf");
		// });

		function convertCanvasToImage() {
			img.src = canvas.toDataURL("image/png");
		}

		$('.btn-less').on('click',function(e){
			e.preventDefault();
			var year = parseInt($('.year').text()) - 1;
			var yearnow = new Date().getFullYear();
			if(year <= parseInt(yearnow)){
				if(year == parseInt(yearnow)){
					$('.btn-plus').attr('disabled',true);
					$('.btn-plus').removeClass('btn-primary');
					$('.btn-plus').addClass('btn-default');
				}
				$.ajax({
					type: 'GET',
					url: "{{ route('grafic.refresh') }}",
					data: {year: year},
					dataType: 'json',
					async: false
				}).done(function(response){
					datesInitials = response;
					setGrafic();
				});
				$('.year').text(year);
				$('input[name=year]').val(year);
				if(year == parseInt(yearnow)){
					$('.btn-plus').attr('disabled',true);
					$('.btn-plus').removeClass('btn-primary');
					$('.btn-plus').addClass('btn-default');
				}else{
					$('.btn-plus').attr('disabled',false);
					$('.btn-plus').removeClass('btn-default');
					$('.btn-plus').addClass('btn-primary');
				}
			}else{
				$('.btn-plus').attr('disabled',true);
				$('.btn-plus').removeClass('btn-primary');
				$('.btn-plus').addClass('btn-default');
			}
		});

		$('.btn-plus').on('click',function(e){
			e.preventDefault();
			var year = parseInt($('.year').text()) + 1;
			var yearnow = new Date().getFullYear();
			if(year <= parseInt(yearnow)){
				if(year == parseInt(yearnow)){
					$('.btn-plus').attr('disabled',true);
					$('.btn-plus').removeClass('btn-primary');
					$('.btn-plus').addClass('btn-default');
				}
				$.ajax({
					type: 'GET',
					url: "{{ route('grafic.refresh') }}",
					data: {year: year},
					dataType: 'json',
					async: false
				}).done(function(response){
					datesInitials[0] = response;
					setGrafic();
				});
				$('.year').text(year);
				$('input[name=year]').val(year);
				if(year == parseInt(yearnow)){
					$('.btn-plus').attr('disabled',true);
					$('.btn-plus').removeClass('btn-primary');
					$('.btn-plus').addClass('btn-default');
				}else{
					$('.btn-plus').attr('disabled',false);
					$('.btn-plus').removeClass('btn-default');
					$('.btn-plus').addClass('btn-primary');
				}
			}else{
				$('.btn-plus').attr('disabled',true);
				$('.btn-plus').removeClass('btn-primary');
				$('.btn-plus').addClass('btn-default');
			}
		});
	</script>
@endsection