@extends('modules.structure')

@section('academicModules')
	<div class="col-md-12">
		<div class="row border-top">
			<div class="col-md-2">
				<h4 class=" text-muted ml-4 mt-3">LISTADOS:</h4>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de modificacion de curso establecido -->
				@if(session('PrimarySaveCourseConsolidated'))
				    <div class="alert alert-primary my-3">
				        {{ session('PrimarySaveCourseConsolidated') }}
				    </div>
				@endif
				@if(session('SecondarySaveCourseConsolidated'))
				    <div class="alert alert-secondary my-3">
				        {{ session('SecondarySaveCourseConsolidated') }}
				    </div>
				@endif
				<!-- Mensajes de exportacion a pdf de listado -->
				@if(session('SuccessExport'))
				    <div class="alert alert-warning my-3">
				        {{ session('SuccessExport') }}
				    </div>
				@endif
				@if(session('SecondaryExport'))
				    <div class="alert alert-secondary my-3">
				        {{ session('SecondaryExport') }}
				    </div>
				@endif
			</div>
			<div class="col-md-4">
				<a href="#" class="bj-btn-table-add my-4 form-control-sm traslateStudent-link" title="TRASLADE ALUMNOS EN LOS GRADOS EXISTENTES">TRASLADO ENTRE GRADOS</a>
				<a href="{{ route('gradeCourse') }}" class="bj-btn-table-delete my-4 form-control-sm">VOLVER</a>
			</div>
		</div>
		<table id="tablelistcourses" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>FILA</th>
					<th>CURSO</th>
					<th>ALUMNOS</th>
					<th>DIRECTOR DE GRUPO</th>
					<th>INICIO</th>
					<th>FINAL</th>
					<th>ESTADO</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $row = 1; $index = 0; @endphp
				@foreach($coursesConsolidated as $group)
					<tr>
						<td>{{ $row++ }}</td>
						<td>{{ $group->nameCourse }}</td>
						<td><h5 class="badge badge-info">{{ $counts[$index++] }}</h5></td>
						<td>{{ $group->nameCollaborator }}</td>
						<td>{{ $group->ccDateInitial }}</td>
						<td>{{ $group->ccDateFinal }}</td>
						<td>{{ $group->ccStatus }}</td>
						<td>
							@if($group->ccStatus == 'ACTIVO')
								<form action="{{ route('gradeCourse.pdf') }}" method="GET" style="display: inline-block;">
									@csrf
									<input type="hidden" name="ccId" value="{{ $group->ccId }}" class="form-control form-control-sm">
									<button type="submit" title="DESCARGAR LISTADO" class="bj-btn-table-delete form-control-sm">
										<i class="fas fa-file-pdf"></i>
									</button>
								</form>
								<form action="{{ route('gradeCourse.edit') }}" method="GET" style="display: inline-block;">
									@csrf
									<input type="hidden" name="ccId" value="{{ $group->ccId }}" class="form-control form-control-sm">
									<button type="submit" title="EDITAR" class="bj-btn-table-edit form-control-sm">
										<i class="fas fa-edit"></i>
									</button>
								</form>
								<button type="submit" title="CAMBIAR ALUMNOS" class="bj-btn-table-add form-control-sm changeStudent-link">
									<i class="fas fa-filter"></i>
									<span hidden>{{ $group->idGrade }}</span>
									<span hidden>{{ $group->nameCourse }}</span>
								</button>
							@else
								<form action="{{ route('gradeCourse.edit') }}" method="GET" style="display: inline-block;">
									@csrf
									<input type="hidden" name="ccId" value="{{ $group->ccId }}" class="form-control form-control-sm">
									<button type="submit" title="EDITAR" class="bj-btn-table-edit form-control-sm">
										<i class="fas fa-edit"></i>
									</button>
								</form>
							@endif
						</td>
					</tr>
				@endforeach
				<!-- TR SON DINAMICOS CON EL SELECT DE CURSOS -->
			</tbody>
		</table>
	</div>

	<!-- MODAL DE CAMBIO DE ALUMNOS ENTRE LOS CURSO DEL GRADO ASIGNADO -->
	<div class="modal fade" id="changeStudent-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="text-muted">CAMBIO DE ALUMNOS ENTRE LOS CURSO DEL GRADO ASIGNADO</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row p-2">
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">GRADO:</small>
								<select name="grade_change" class="form-control form-control-sm">
									<option value="">Seleccione un grado...</option>
									@foreach($grades as $grade)
										<option value="{{ $grade->id }}">{{ $grade->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">CURSO:</small>
								<select name="course_change" class="form-control form-control-sm">
									<option value="">Seleccione un curso...</option>
									<!-- option dinamics -->
								</select>
							</div>
						</div>
					</div>
					<div class="row p-2">
						<div class="col-md-5 border">
							<small class="text-muted">ALUMNOS DEL GRADO (SIN CURSO):</small>
							<ul class="list-group list_all_not" style="cursor: pointer;">
								<!-- dinamics -->
							</ul>
						</div>
						<div class="col-md-2 d-flex flex-column justify-content-center">
							<button type="button" class="bj-btn-table-edit form-control-sm btn-add" title="AGREGAR ALUMNOS SELECCIONADOS">
								<i class="fas fa-chevron-right"></i>
								<i class="fas fa-chevron-right"></i>
								<i class="fas fa-chevron-right"></i>
							</button>
							<button type="button" class="bj-btn-table-delete form-control-sm btn-remove" title="QUITAR ALUMNOS SELECCIONADOS">
								<i class="fas fa-chevron-left"></i>
								<i class="fas fa-chevron-left"></i>
								<i class="fas fa-chevron-left"></i>
							</button>
						</div>
						<div class="col-md-5 border">
							<small class="text-muted">ALUMNOS DEL CURSO: <b class="courseText"></b></small>
							<ul class="list-group list_all_yes" style="cursor: pointer;">
								<!-- dinamics -->
							</ul>
						</div>
					</div>
					<div class="row p-3 text-center">
						<div class="col-md-12">
							<div class="alert m-3 p-3 msg-change" style="display: none;"></div>
							<form action="{{ route('gradeCourse.change') }}" method="GET">
								<button type="submit" class="bj-btn-table-add">GUARDAR CAMBIOS</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL DE CAMBIO DE ALUMNOS ENTRE LOS CURSO DEL GRADO ASIGNADO -->
	<div class="modal fade" id="traslateStudent-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h6>TRASLADO DE ALUMNOS ENTRE LOS DIFERENTES GRADOS</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row p-2">
						<div class="col-md-3">
							<div class="form-group">
								<small class="text-muted">GRADO ORIGEN:</small>
								<select name="grade_translate_origin" class="form-control form-control-sm">
									<option value="">Seleccione ...</option>
									@foreach($grades as $grade)
										<option value="{{ $grade->id }}">{{ $grade->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<small class="text-muted">CURSO ORIGEN:</small>
								<select name="course_translate_origin" class="form-control form-control-sm">
									<option value="">Seleccione ...</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">ALUMNO:</small>
								<select name="student_translate" class="form-control form-control-sm">
									<option value="">Seleccione ...</option>
									<!-- option dinamics -->
								</select>
							</div>
							<div class="form-group">
								<div class="alert alert-translate" style="font-size: 12px; text-align: center; display: none;"></div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<small class="text-muted">GRADO DESTINO:</small>
								<select name="grade_translate_destiny" class="form-control form-control-sm">
									<option value="">Seleccione ...</option>
									@foreach($grades as $grade)
										<option value="{{ $grade->id }}">{{ $grade->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<small class="text-muted">CURSO DESTINO:</small>
								<select name="course_translate_destiny" class="form-control form-control-sm">
									<option value="">Seleccione ...</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button type="button" class="bj-btn-table-add form-control-sm btn-translate">TRASLADAR</button>
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
			
		});

		$('.changeStudent-link').on('click',function(){
			var idGrade = $(this).find('span:nth-child(2)').text();
			var nameCourse = $(this).find('span:nth-child(3)').text();
			$('.courseText').text(nameCourse);
			$('select[name=grade_change]').val(idGrade);
			// OBTENER LOS CURSOS DEL GRADO SELECCIONADO
			$.get("{{ route('legGradeSelected') }}",{ selectedGrade: idGrade },function(objectCourses){
				var count = Object.keys(objectCourses).length;
				if(count > 0){
					var idCourse = 0;
					$('select[name=course_change]').empty();
					$('select[name=course_change]').append("<option value=''>Seleccione un curso...</option>");
					for (var i = 0; i < count; i++) {
						if(objectCourses[i]['name'] == nameCourse){
							$('select[name=course_change]').append("<option value='" + objectCourses[i]['id'] + "' selected>" + objectCourses[i]['name'] + "</option>");
							idCourse = objectCourses[i]['id'];
						}else{
							$('select[name=course_change]').append("<option value='" + objectCourses[i]['id'] + "'>" + objectCourses[i]['name'] + "</option>");
						}
					}
				}
				refreshListgrade(idGrade);
				refreshListcourse(idGrade,idCourse);
			});
			$('#changeStudent-modal').modal();
		});

		// AL CAMBIAR DE CURSO SE ACTUALIZAN LAS LISTAS DE ALUMNOS
		$('select[name=course_change]').on('change',function(e){
			var idCourse = e.target.value;
			var nameCourse = $(this).find('option:selected').text();
			if(nameCourse.indexOf('Seleccione') == -1){
				$('.courseText').text(nameCourse);
			}else{
				$('.courseText').text('Ninguno');
			}
			var idGrade = $('select[name=grade_change]').val();
			if(idCourse != '' && idGrade != ''){
				refreshListcourse(idGrade,idCourse);
			}else{
				$('ul.list_all_yes').empty();
			}
		});

		$('select[name=grade_change]').on('change',function(e){
			var idGrade = e.target.value;
			$('select[name=course_change]').empty();
			$('select[name=course_change]').append("<option value=''>Seleccione un curso...</option>");
			$.get("{{ route('legGradeSelected') }}",{ selectedGrade: idGrade },function(objectCourses){
				var count = Object.keys(objectCourses).length;
				if(count > 0){
					for (var i = 0; i < count; i++) {
						$('select[name=course_change]').append("<option value='" + objectCourses[i]['id'] + "'>" + objectCourses[i]['name'] + "</option>");
					}
					$('ul.list_all_not').empty();
					$('ul.list_all_yes').empty();
					$('.courseText').text('Ninguno');
					refreshListgrade(idGrade);
				}
			});
		});

		function refreshListgrade(idGrade){
			$.get("{{ route('getStudentGrade') }}",{ selectedGrade: idGrade },function(objectStudent){
				var count = Object.keys(objectStudent).length;
				$('ul.list_all_not').empty();
				if(count > 0){
					for (var i = 0; i < count; i++) {
						$('ul.list_all_not').append("<li id='" + objectStudent[i]['idStudent'] + "' class='list-group-item text-left' style='font-size: 12px;'><input type='checkbox' class='item-list mr-2' value='" + objectStudent[i]['idStudent'] + "' hidden>" +
								objectStudent[i]['nameStudent'] + "</li>"
						);
					}
				}
			});
		}

		function refreshListcourse(idGrade,idCourse){
			$.get("{{ route('getStudentCourse') }}",{ selectedGrade: idGrade, selectedCourse: idCourse },function(objectStudent){
				var count = Object.keys(objectStudent).length;
				$('ul.list_all_yes').empty();
				if(count > 0){
					for (var i = 0; i < count; i++) {
						$('ul.list_all_yes').append("<li id='" + objectStudent[i]['idStudent'] + "' class='list-group-item text-left' style='font-size: 12px;'><input type='checkbox' class='item-list mr-2' value='" + objectStudent[i]['idStudent'] + "' hidden>" +
								objectStudent[i]['nameStudent'] + "</li>"
						);
					}
				}
			});
		}

		$('ul.list_all_not').on('click','li',function(){
			var input = $(this).find('.item-list');
			var checked = input.is(":checked");
			if(checked){
				input.prop('checked', false);
				$(this).css('background','transparent');
				$(this).css('color','#000');
			}else{
				input.prop('checked', true);
				$(this).css('background','#0A15FC');
				$(this).css('color','#fff');
			}
		});

		$('ul.list_all_yes').on('click','li',function(){
			var input = $(this).find('.item-list');
			var checked = input.is(":checked");
			if(checked){
				input.prop('checked', false);
				$(this).css('background','transparent');
				$(this).css('color','#000');
			}else{
				input.prop('checked', true);
				$(this).css('background','#F8B209');
				$(this).css('color','#fff');
			}
		});

		$('.btn-add').on('click',function(){
			//RECORRER LISTA DEL GRADO SELECCIONADO
			var idCourse = $('select[name=course_change]').val();
			var idGrade = $('select[name=grade_change]').val();
			var ids = '';
			$('ul.list_all_not li').each(function(){
				var check = $(this).find('input.item-list').is(':checked');
				if(check){
					ids += $(this).attr('id') + '=';
				}
			});
			if(idCourse != '' && idGrade != ''){
				// REALIZAR CAMBIOS EN BASE DE DATOS
				var idsCompleted = ids.slice(0,-1);
				if(idsCompleted.length > 0){
					$.ajax({
						url: "{{ route('saveChangeStudents') }}",
						type: 'POST',
						data: { selectedGrade: idGrade, selectedCourse: idCourse, idsSelected: idsCompleted },
						beforeSend: function(){
							$('ul.list_all_not li').each(function(){
								var check = $(this).find('input.item-list').is(':checked');
								if(check){
									var clone = $(this).clone();
									clone.css('background','transparent');
									clone.css('color','#000');
									clone.find('input.item-list').prop('checked',false);
									$(this).remove();
									$('ul.list_all_yes').append(clone);
								}
							});
							$('.btn-add').html("<div class='spinner-border' style='width: 10px; height: 10px;' align='center' role='status'><span class='sr-only' align='center'>Procesando...</span></div>");
						},
						complete: function(objectResponse){
							console.log(objectResponse.responseText.indexOf('seleccionado/s'));
							$('.msg-change').css('display','block');
							$('.msg-change').removeClass('alert-warning');
							$('.msg-change').addClass('alert-primary');
							$('.msg-change').html(objectResponse.responseText);
							$('.btn-add').html("<i class='fas fa-chevron-right'></i><i class='fas fa-chevron-right'></i><i class='fas fa-chevron-right'></i>");
						}
					});
				}
			}
		});

		$('.btn-remove').on('click',function(){
			//RECORRER LISTA DEL GRADO SELECCIONADO
			var idCourse = $('select[name=course_change]').val();
			var idGrade = $('select[name=grade_change]').val();
			var ids = '';
			$('ul.list_all_yes li').each(function(){
				var check = $(this).find('input.item-list').is(':checked');
				if(check){
					ids += $(this).attr('id') + '=';
				}
			});
			if(idCourse != '' && idGrade != ''){
				// REALIZAR CAMBIOS EN BASE DE DATOS
				var idsCompleted = ids.slice(0,-1);
				if(idsCompleted.length > 0){
					$.ajax({
						url: "{{ route('saveChangeRemove') }}",
						type: 'POST',
						data: { selectedGrade: idGrade, selectedCourse: idCourse, idsSelected: idsCompleted },
						beforeSend: function(){
							$('ul.list_all_yes li').each(function(){
								var check = $(this).find('input.item-list').is(':checked');
								if(check){
									var clone = $(this).clone();
									clone.css('background','transparent');
									clone.css('color','#000');
									clone.find('input.item-list').prop('checked',false);
									$(this).remove();
									$('ul.list_all_not').append(clone);
								}
							});
							$('.btn-remove').html("<div class='spinner-border' style='width: 10px; height: 10px;' align='center' role='status'><span class='sr-only' align='center'>Procesando...</span></div>");
						},
						complete: function(objectResponse){
							console.log(objectResponse.responseText.indexOf('seleccionado/s'));
							$('.msg-change').css('display','block');
							$('.msg-change').removeClass('alert-primary');
							$('.msg-change').addClass('alert-warning');
							$('.msg-change').html(objectResponse.responseText);
							$('.btn-remove').html("<i class='fas fa-chevron-left'></i><i class='fas fa-chevron-left'></i><i class='fas fa-chevron-left'></i>");
						}
					});
				}
			}
		});

		$('.traslateStudent-link').on('click',function(e){
			e.preventDefault();
			$('#traslateStudent-modal').modal();
		});

		$('select[name=grade_translate_origin]').on('change',function(e){
			let selectedGrade = e.target.value;
			$('select[name=course_translate_origin]').empty();
			$('select[name=course_translate_origin]').append("<option value=''>Seleccione ...</option>");
			if(selectedGrade != ''){
				$.get("{{ route('legGradeSelected') }}",{ selectedGrade: selectedGrade },function(objectCourses){
					var count = Object.keys(objectCourses).length;
					// console.log(count);
					// console.log(objectCourses[0]);
					if(count > 0){
						for (var i = 0; i < count; i++) {
							$('select[name=course_translate_origin]').append('<option value=' + objectCourses[i]['id'] + '>' + objectCourses[i]['name'] + '</option>');
						}
					}
				});
			}
		});

		$('select[name=course_translate_origin]').on('change',function(e){
			var selectedCourse = e.target.value;
			var selectedGrade = $('select[name=grade_translate_origin]').val();
			$('select[name=student_translate]').empty();
			$('select[name=student_translate]').append("<option value=''>Seleccione ...</option>");
			if(selectedCourse != '' && selectedGrade != ''){
				$.get(
					"{{ route('legCourseSelectedForList') }}",
					{ selectedCourse: selectedCourse, selectedGrade: selectedGrade },
					function(objectListCourse){
						var count = Object.keys(objectListCourse).length;
						if(count > 0){
							for (var i = 0; i < count; i++) {
								$('select[name=student_translate]').append(
									"<option value='" + objectListCourse[i]['id'] + "'>" + objectListCourse[i]['firstname'] + " " + objectListCourse[i]['threename'] + " " + objectListCourse[i]['fourname'] + "</option>"
								);
							}
						}
					}
				);
			}
		});

		$('select[name=grade_translate_destiny]').on('change',function(e){
			let selectedGrade = e.target.value;
			$('select[name=course_translate_destiny]').empty();
			$('select[name=course_translate_destiny]').append("<option value=''>Seleccione ...</option>");
			if(selectedGrade != ''){
				$.get("{{ route('legGradeSelected') }}",{ selectedGrade: selectedGrade },function(objectCourses){
					var count = Object.keys(objectCourses).length;
					// console.log(count);
					// console.log(objectCourses[0]);
					if(count > 0){
						for (var i = 0; i < count; i++) {
							$('select[name=course_translate_destiny]').append('<option value=' + objectCourses[i]['id'] + '>' + objectCourses[i]['name'] + '</option>');
						}
					}
				});
			}
		});

		$('.btn-translate').on('click',function(){
			let originGrade = $('select[name=grade_translate_origin]').val();
			let originGradeName = $('select[name=grade_translate_origin] option:selected').text();
			let originCourse = $('select[name=course_translate_origin]').val();
			let originCourseName = $('select[name=course_translate_origin] option:selected').text();
			let student = $('select[name=student_translate]').val();
			let studentName = $('select[name=student_translate] option:Selected').text();
			let destinyGrade = $('select[name=grade_translate_destiny]').val();
			let destinyGradeName = $('select[name=grade_translate_destiny] option:selected').text();
			let destinyCourse = $('select[name=course_translate_destiny]').val();
			let destinyCourseName = $('select[name=course_translate_destiny] option:selected').text();
			if(originGrade != '' && originCourse != '' && student != '' && destinyGrade != '' && destinyCourse != ''){
				$.ajax({
					url: "{{ route('translateStudent') }}",
					type: 'POST',
					async: false,
					data:{
						originGrade: originGrade,
						originCourse: originCourse,
						student: student,
						destinyGrade: destinyGrade,
						destinyCourse: destinyCourse
					},
					success: function(responseTranslate){
						console.log('responseTranslate',responseTranslate);
						$('.alert-translate').fadeIn();
						if(responseTranslate > 0){
							$('.alert-translate').addClass('alert-success');
							$('.alert-translate').append("<b>Se ha trasladado al alumno (" + studentName + ") de (" + originGradeName + "-" + originCourseName + ") a (" + destinyGradeName + "-" + destinyCourseName + ")</b>");
							$('select[name=grade_translate_origin]').val('');
							$('select[name=course_translate_origin]').empty();
							$('select[name=course_translate_origin]').append("<option value=''>Seleccione ...</option>");
							$('select[name=student_translate]').empty();
							$('select[name=student_translate]').append("<option value=''>Seleccione ...</option>");
							$('select[name=grade_translate_destiny]').val('');
							$('select[name=course_translate_destiny]').empty();
							$('select[name=course_translate_destiny]').append("<option value=''>Seleccione ...</option>");
							setTimeout(() => {
								$('.alert-translate').fadeOut();
								$('.alert-translate').empty();
								$('.alert-translate').removeClass('alert-success');
							},10000);
						}else{
							$('.alert-translate').addClass('alert-danger');
							$('.alert-translate').append("<b>No se ha completado el traslado, intentelo de nuevo o comuniquese con el administrador!</b>");
							setTimeout(() => {
								$('.alert-translate').fadeOut();
								$('.alert-translate').empty();
								$('.alert-translate').removeClass('alert-danger');
							},5000);
						}
					},
					error: function(error){
						console.log('error',error);
					}
				});
			}else{
				$('.alert-translate').fadeIn();
				$('.alert-translate').addClass('alert-warning');
				$('.alert-translate').append("<b>Complete los datos de traslado!</b>");
				setTimeout(() => {
					$('.alert-translate').fadeOut();
					$('.alert-translate').empty();
					$('.alert-translate').removeClass('alert-warning');
				},5000);
			}
		});
	</script>
@endsection