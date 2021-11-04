@extends('modules.events')

@section('eventsModules')
	<div class="col-md-12 p-3">
		<div class="row border-bottom mb-3">
			<div class="col-md-6">
				<h3>SEGUIMIENTO DE EVENTOS</h3>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de agendamiento de eventos -->
				@if(session('SuccessSaveFollow'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveFollow') }}
				    </div>
				@endif
				@if(session('SecondarySaveFollow'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveFollow') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de agendamiento de eventos -->
				@if(session('PrimaryUpdateFollow'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateFollow') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateFollow'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateFollow') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de agendamiento de eventos -->
				@if(session('WarningDeleteFollow'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteFollow') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteFollow'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteFollow') }}
				    </div>
				@endif
			</div>
		</div>
		<div class="row border-top py-3">
			<div class="col-md-12">
				<div id="fullcalendarfollow"></div>
			</div>
		</div>
	</div>

	<!-- MODAL PARA VER DETALLES DE CADA EVENTO EN EL CALENDARIO -->
	<div class="modal fade" id="detailsFollow-Modal">
	  	<div class="modal-dialog">
		    <div class="modal-content px-4 py-4">
		    	<div class="modal-header row">
		    		<div class="col-md-12">
		    			<h6 class="text-muted mb-4">DETALLES DE EVENTO: </h6>
		    		</div>
		    	</div>
    			<div class="row border-top border-bottom p-2 options">
					<div class="col-md-4">
						<div class="form-group ml-3">
							<small class="text-muted">
								<input type="radio" name="optionFollow" value="DETALLES" checked>
								DETALLES
							</small>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group ml-3">
							<small class="text-muted">
								<input type="radio" name="optionFollow" value="REPROGRAMAR">
								REPROGRAMAR
							</small>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<small class="text-muted">
							<input type="radio" name="optionFollow" value="CERRAR EVENTO">
								CERRAR EVENTO
							</small>
						</div>
					</div>
				</div>
		    	<div class="modal-body">
		    		<div class="row row_detailsFollow">
		    			<div class="col-md-12">
		    				<small class="text-muted">FECHA DE EVENTO: </small><br>
							<span class="text-muted"><b class="deDate_details"></b></span><br>
							<small class="text-muted">DESDE - HASTA: (Horas) </small><br>
							<span class="text-muted"><b class="deStart_details"></b></span> - <span class="text-muted"><b class="deEnd_details"></b></span><br>
							<small class="text-muted">RESPONSABLE: </small><br>
							<span class="text-muted"><b class="deCollaborator_details"></b></span><br>
							<small class="text-muted">TIPO DE EVENTO: </small><br>
							<span class="text-muted"><b class="deCreation_details"></b></span><br>
							<small class="text-muted">ALUMNO: </small><br>
							<span class="text-muted"><b class="deStudent_details"></b></span><br>
							<small class="text-muted">DESCRIPCION: </small><br>
							<span class="text-muted"><b class="deDescription_details"></b></span>
		    			</div>
		    		</div>
		    		<div class="row row_changeFollow" style="display: none;">
		    			<div class="col-md-12">
		    				<form action="{{ route('follow.change') }}" method="POST">
				    			@csrf
				    			<div class="row">
				    				<div class="col-md-6">
				    					<div class="form-group">
											<small class="text-muted">FECHA DE EVENTO:</small>
											<input type="text" name="deDate_change" class="form-control form-control-sm datepicker" required>
										</div>
				    				</div>
				    				<div class="col-md-3">
				    					<div class="form-group">
											<small class="text-muted">DESDE:</small>
											<input type="time" name="deStart_change" class="form-control form-control-sm" required>
										</div>
				    				</div>
				    				<div class="col-md-3">
				    					<div class="form-group">
											<small class="text-muted">HASTA:</small>
											<input type="time" name="deEnd_change" class="form-control form-control-sm" required>
										</div>
				    				</div>
				    			</div>
								<div class="row">
				    				<div class="col-md-6">
				    					<div class="form-group">
											<small class="text-muted">RESPONSABLE:</small><br>
											<span style='font-size: 13px;' class="edCollaborator_change"></span>
										</div>
				    				</div>
				    				<div class="col-md-6">
				    					<div class="form-group">
											<small class="text-muted">TIPO DE EVENTO:</small><br>
											<span style='font-size: 13px;' class="edCreation_change"></span>
										</div>
				    				</div>
				    			</div>
				    			<div class="row">
				    				<div class="col-md-12">
				    					<div class="form-group">
											<small class="text-muted">ALUMNO:</small><br>
											<span style='font-size: 13px;' class="edStudent_change"></span>
										</div>
				    				</div>
				    			</div>
				    			<div class="row">
				    				<div class="col-md-12">
				    					<div class="form-group">
											<small class="text-muted">DESCRIPCION:</small><br>
											<textarea type="text" name="deDescription_change" class="form-control form-control-sm" readonly required></textarea>
										</div>
				    				</div>
				    			</div>
				    			<input type="hidden" name="deId_change" value="" readonly required>
				    			<button type="submit" class="bj-btn-table-edit float-left form-control-sm">GUARDAR CAMBIOS</button>
				    		</form>	
		    			</div>
		    		</div>
		    		<div class="row row_stopFollow" style="display: none;">
		    			<div class="col-md-12">
		    				<small class="text-muted">FECHA DE EVENTO: </small><br>
							<span class="text-muted"><b class="deDate_details"></b></span> de <span class="text-muted"><b class="deStart_details"></b></span> a <span class="text-muted"><b class="deEnd_details"></b></span><br>
							<small class="text-muted">RESPONSABLE - TIPO DE EVENTO: </small><br>
							<span class="text-muted"><b class="deCollaborator_details"></b></span> -  <span class="text-muted"><b class="deCreation_details"></b></span><br>
							<small class="text-muted">ALUMNO: </small><br>
							<span class="text-muted"><b class="deStudent_details"></b></span><br>
							<small class="text-muted">DESCRIPCION: </small><br>
							<span class="text-muted"><b class="deDescription_details"></b></span><br>
		    				<form action="{{ route('follow.stop') }}" method="POST">
				    			@csrf
				    			<div class="form-group">
				    				<small class="text-muted">DESCRIPCION DE CIERRE: </small>
				    				<textarea name="deDescripcionOut_stop" class="form-control form-control-sm" maxlength="1000" placeholder="Observación de cierre de máximo de 1000 carácteres" cols="30" rows="10" required></textarea>
				    			</div>
				    			<input type="hidden" name="deId_stop" value="" readonly required>
				    			<button type="submit" class="bj-btn-table-add float-left form-control-sm">CERRAR EVENTO</button>
				    		</form>	
		    			</div>
		    		</div>
		    		<button type="button" class="bj-btn-table-delete float-right form-control-sm" data-dismiss="modal">CERRAR</button>
		    	</div>
		    </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){
		});

		$('input[name=optionFollow]').on('click',function(){
			var selected = $(this).val();
			if(selected == 'DETALLES'){
				$('.row_detailsFollow').css('display','block');
				$('.row_changeFollow').css('display','none');
				$('.row_stopFollow').css('display','none');
			}else if(selected == 'REPROGRAMAR'){
				$('.row_detailsFollow').css('display','none');
				$('.row_changeFollow').css('display','block');
				$('.row_stopFollow').css('display','none');
			}else if(selected == 'CERRAR EVENTO'){
				$('.row_detailsFollow').css('display','none');
				$('.row_changeFollow').css('display','none');
				$('.row_stopFollow').css('display','block');
			}
		});

		document.addEventListener('DOMContentLoaded', function() {
	        var calendarEl = document.getElementById('fullcalendarfollow');
	        //var btnAgenda = document.getElementById('btn-agenda');

	        var calendar = new FullCalendar.Calendar(calendarEl, {
	          	plugins: [ 'interaction','dayGrid' ],
	          	//timeZone: 'UTC',
    			defaultView: 'dayGridMonth', // timeGridWeek
    			allDaySlot: true,
    			//eventLimit: 6,
    			allDayText: 'all-day',
    			slotEventOverlap: true,
				minTime: "07:00",
   				maxTime: "17:00",
   				slotDuration: '00:15:00',
   				timeGridEventMinHeight: 30,
   				//nowIndicator: true,
				timeFormat: 'h(:mm)t',

				hour: 'numeric',
				minute: '2-digit',
				meridiem: false,

				eventOrder: '-duration',

	          	editable: true,
	          	selectable: true,
	          	header: { 
	          		left: 'prev,next week',
		          	center: 'title'
		        },
				events:{
					url: "{{ route('getAllFollow') }}"
				},
				eventClick: function(info){					
					$.get("{{ route('getDetailsFollow') }}",{edId: info.event.id},function(objectInfo){
						$('input[name=deId_change]').val(objectInfo[0][0]);
						$('input[name=deId_stop]').val(objectInfo[0][0]);
						//DETALLES
						$('.deDate_details').text(objectInfo[0][1]);
						$('.deStart_details').text(objectInfo[0][2]);
						$('.deEnd_details').text(objectInfo[0][3]);
						$('.deCollaborator_details').text(objectInfo[0][5]);
						$('.deCreation_details').text(objectInfo[0][7]);
						$('.deStudent_details').text(objectInfo[0][8]);
						$('.deDescription_details').text(objectInfo[0][9]);

						//REPROGRAMAR
						$('input[name=deDate_change').val(objectInfo[0][1]);
						$('input[name=deStart_change').val(objectInfo[0][2]);
						$('input[name=deEnd_change').val(objectInfo[0][3]);
						$('.edCollaborator_change').text(objectInfo[0][5]);
						$('.edCreation_change').text(objectInfo[0][7]);
						$('.edStudent_change').text(objectInfo[0][8]);
						$('textarea[name=deDescription_change]').val(objectInfo[0][9]);
						if(objectInfo[0][10] == 1){
							$('.options').css('display','none');
						}else{
							$('.options').css('display','flex');
						}

						$('#detailsFollow-Modal').modal();
					});
				},
				eventDrop: function(info){
					
				},
				dateClick: function(info) {

					// if($('select[name=hwCourse] option:selected').val() != '' && $('input[name=hwDateInitial]').val() != '' && $('input[name=hwDateFinal]').val() != ''){

					// 	//console.log('FECHA DE PRUEBA: ' + dateCompleteNow($('input[name=hwDateInitial]').val()));

					// 	var dateInitial = dateCompleteNow($('input[name=hwDateInitial]').val().replace(/-/g, '\/'));
					// 	var dateFinal = dateCompleteNow($('input[name=hwDateFinal]').val().replace(/-/g, '\/'));
					// 	var dateSelected = dateCompleteNow(info.dateStr);
					// 	var courseSelectedId = $('select[name=hwCourse] option:selected').val();
					// 	var courseSelectedText = $('select[name=hwCourse] option:selected').text();
					// 	//console.log(dateInitial + ' ' + dateFinal + ' ' + dateSelected + ' ACTUAL: ' + dateCompleteNow());
					// 	//onlyDate(info.dateStr);
					// 	//onlyDate($('input[name=hwDateInitial]').val());

					// 	if(onlyDate(info.dateStr) >= onlyDate($('input[name=hwDateInitial]').val()) && onlyDate(info.dateStr) <= onlyDate($('input[name=hwDateFinal]').val())){

					// 		$('.dateSelected-modal').text('');
					// 		$('.dateSelected-modal').text(onlyDate(info.dateStr));

					// 		$('.nameCourseSelected-modal').text(courseSelectedText);
					// 		var separatedInitial = dateInitial.split('-');
					// 		var separatedFinal = dateFinal.split('-');
					// 		var separatedSelected = dateSelected.split('-');

					// 		$('input[name=hwDateInitial-modal]').val('');
					// 		$('input[name=hwDateInitial-modal]').val(separatedInitial[2] + ' de ' + separatedInitial[1]);
					// 		$('input[name=hwDateFinal-modal]').val('');
					// 		$('input[name=hwDateFinal-modal]').val(separatedFinal[2] + ' de ' + separatedFinal[1]);
							
					// 		$('span.hwDay-modal').text('');
					// 		$('span.hwDay-modal').text(separatedSelected[4]);
					// 		$('input[name=hwHourInitial-modal]').val('');
					// 		$('input[name=hwHourInitial-modal]').val(separatedSelected[3]);

					// 		$('#newHourweek-Modal').modal();
					// 		$('.messages').empty();
					// 		$('.messages').css('display','none');
					// 	}else{
					// 		$("html, body").animate({ scrollTop: 0 }, "slow");
					// 		$('.messages').empty();
					// 		$('.messages').css('display','block');
					// 		$('.messages').append('Ha seleccionado una fecha fuera del rango de fechas seleccionado');
					// 	}
					// }else{
					// 	$("html, body").animate({ scrollTop: 0 }, "slow");
					// 	$('.messages').empty();
					// 	$('.messages').css('display','block');
					// 	$('.messages').append('Asegurese primero de establecer un rango de fechas seleccionando un curso');
					// }
				},
				select: function(info) {
										
			    }
	        });
	        calendar.setOption('locale','es');
	        calendar.render();

	        //new Draggable(btnAgenda);
	    });

	    function dateCompleteNow(date = ''){
	    	if(date == ''){
	    		var now = new Date();
		        var month = now.getMonth()+1;
				var dayMonth = now.getDate();
				var hour = now.getHours();
				var minutes = now.getMinutes();
				var monthString = getMonthString((month<10 ? '0' : '') + month);

				var dateCompleted = now.getFullYear() + '-' +
				    getMonthString(now.getUTCMonth()) + '-' +
				(dayMonth<10 ? '0' : '') + dayMonth + '-' +
				(hour<10 ? '0' : '') + hour + ':' +
				(minutes<10 ? '0' : '') + minutes;

	    	}else{
	    		//var now = new Date(date.replace(/-/g, '\/'));
	    		var now = new Date(date);
	    		//console.log('FORMATO: ' + now.toLocaleString('en-US'));
		        var month = now.getMonth()+1;
		        var dayWeek = now.getDay();
				var dayMonth = now.getDate();
				var hour = now.getHours();
				var minutes = now.getMinutes();
				var monthString = getMonthString(now.getUTCMonth());
				//var monthString = getMonthString((month<10 ? '0' : '') + month);
				//console.log('NUMERO DE MES: ' + month + ' NOMBRE DE MES: ' + monthString);

				var dateCompleted = now.getFullYear() + '-' +
				    getMonthString(now.getUTCMonth()) + '-' +
				(dayMonth<10 ? '0' : '') + dayMonth + '-' +
				(hour<10 ? '0' : '') + hour + ':' +
				(minutes<10 ? '0' : '') + minutes + '-' +
				getDayString(dayWeek);
	    	}
			return dateCompleted;
	    }
	    
	    function onlyDate(date = ''){
	    	if(date == ''){
	    		var now = new Date();
		        var month = now.getMonth()+1;
				var dayMonth = now.getDate();

				var dateComplete = now.getFullYear() + '-' +
				    (month<10 ? '0' : '') + month + '-' +
				(day<10 ? '0' : '') + dayMonth;

	    	}else{
	    		var now = new Date(date);
	    		//console.log('FORMATO: ' + now.toLocaleString('en-US'));
		        var month = now.getMonth()+1;
				var day = now.getDate();
				var dateComplete = now.getFullYear() + '-' +
				    (month<10 ? '0' : '') + month + '-' +
				(day<10 ? '0' : '') + day;
	    	}
			return dateComplete;
	    }

	    function getDayString(value){
			switch(value){
				case 0:
					return 'DOMINGO';
					break;
				case 1:
					return 'LUNES';
					break;
				case 2:
					return 'MARTES';
					break;
				case 3:
					return 'MIERCOLES';
					break;
				case 4:
					return 'JUEVES';
					break;
				case 5:
					return 'VIERNES';
					break;
				case 6:
					return 'SABADO';
					break;
			}
		}

		function getNumberDay(value){
			switch(value){
				case 'DOMINGO':
					return 0;
					break;
				case 'LUNES':
					return 1;
					break;
				case 'MARTES':
					return 2;
					break;
				case 'MIERCOLES':
					return 3;
					break;
				case 'JUEVES':
					return 4;
					break;
				case 'VIERNES':
					return 5;
					break;
				case 'SABADO':
					return 6;
					break;
			}
		}

		function getMonthString(value){
			switch(value){
				case 0:
					return 'ENERO';
					break;
				case 1:
					return 'FEBRERO';
					break;
				case 2:
					return 'MARZO';
					break;
				case 3:
					return 'ABRIL';
					break;
				case 4:
					return 'MAYO';
					break;
				case 5:
					return 'JUNIO';
					break;
				case 6:
					return 'JULIO';
					break;
				case 7:
					return 'AGOSTO';
					break;
				case 8:
					return 'SEPTIEMBRE';
					break;
				case 9:
					return 'OCTUBRE';
					break;
				case 10:
					return 'NOVIEMBRE';
					break;
				case 11:
					return 'DICIEMBRE';
					break;
			}
		}
	</script>
@endsection