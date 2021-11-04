@extends('modules.programming')

@section('academicModules')
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<h5>PLANEACION CRONOLOGICA</h5>
			</div>
			<div class="col-md-4">
				<button type="button" class="bj-btn-table-delete form-control-sm filterPlanning-link">ARCHIVOS DE CRONOGRAMA</button>
			</div>
			<div class="col-md-4">
				<!-- Mensajes de creacion de planeacion cronológica -->
				@if(session('SuccessSavePlanning'))
				    <div class="alert alert-success">
				        {{ session('SuccessSavePlanning') }}
				    </div>
				@endif
				@if(session('SecondarySavePlanning'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySavePlanning') }}
				    </div>
				@endif
				<!-- Mensajes de modificacion de planeacion cronológica -->
				@if(session('PrimaryUpdatePlanning'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdatePlanning') }}
				    </div>
				@endif
				@if(session('SecondaryUpdatePlanning'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdatePlanning') }}
				    </div>
				@endif
				<!-- Mensajes de eliminacion de planeacion cronológica -->
				@if(session('WarningDeletePlanning'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeletePlanning') }}
				    </div>
				@endif
				@if(session('SecondaryDeletePlanning'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeletePlanning') }}
				    </div>
				@endif
				<!-- Mensajes de filtros en PDF de planeacion cronológica -->
				@if(session('SuccessFilterPlanning'))
				    <div class="alert alert-success">
				        {{ session('SuccessFilterPlanning') }}
				    </div>
				@endif
				@if(session('SecondaryFilterPlanning'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryFilterPlanning') }}
				    </div>
				@endif
				<!-- <div class="alert alert-info messages"></div> -->
			</div>
		</div>
		<form action="{{ route('planning.new') }}" method="POST">
			@csrf
			<div class="row border-top py-2">
				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">CURSO:</small>
						<select name="chCourse" class="form-control form-control-sm" required>
							<option value="">Seleccione un curso...</option>
							@foreach($courses as $course)
								<option value="{{ $course->id }}">{{ $course->name }}</option>
							@endforeach
						</select>
						<input type="hidden" name="chNameCourse" class="form-control form-control-sm" value="" required>
					</div>
					<div class="form-group">
						<small class="text-muted">PERIODO:</small>
						<select name="chPeriod" class="form-control form-control-sm" required>
							<option value="">Seleccione un periodo...</option>
							<!-- Select dinámico -->
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">DIRECTOR/A DE GRUPO:</small>
						<input type="hidden" name="chCollaborator-hidden" class="form-control form-control-sm" value="" disabled required>
						<input type="text" name="chCollaborator" class="form-control form-control-sm" value="" disabled required>
					</div>
					<div class="form-group">
						<small class="text-muted">GRADO:</small>
						<input type="text" name="chGrade" class="form-control form-control-sm" value="" disabled required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">FECHA INICIAL:</small>
						<input type="text" name="chDateInitial" class="form-control form-control-sm datepicker" disabled required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<small class="text-muted">FECHA FINAL:</small>
						<input type="text" name="chDateFinal" class="form-control form-control-sm datepicker" disabled required>
					</div>
				</div>
			</div>
			<div class="row border-top py-3 configWeeks" style="display: none;">
				<div class="col-md-12">
					<div class="row text-center">
						<div class="col-md-12">
							<h6>CRONOGRAMA SEMANAL PARA <b class="nameCourseChronological"></b></h6>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-md-12 d-flex justify-content-center">
							<nav aria-label="Page navigation" width="100%">
							  	<ul class="pagination">
							    	<li class="page-item"><a class="page-link changeWeekPrev" href="#"><i class="fas fa-chevron-left"></i></a></li>
							    	<li class="page-item px-3 text-center border-top border-bottom">
							    		<h6>Semana <b class="numberWeek">#</b><br></h6>
							    		<h5>
							    			<b class="dateInitialWeek">fecha inicial</b> A <b class="dateFinalWeek">fecha final</b>
							    		</h5>
							    		<input type="hidden" name="positionRange" class="form-control form-control-sm" value="" disabled>
							    		<input type="hidden" name="chRangeWeek" class="form-control form-control-sm" value="" required>
							    		<input type="hidden" name="chNumberWeek" class="form-control form-control-sm" value="" required>
							    	</li>
							    	<li class="page-item"><a class="page-link changeWeekNext" href="#"><i class="fas fa-chevron-right"></i></a></li>
							  	</ul>
							</nav>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<small class="text-muted">COLABORADOR DOCENTE: </small>
								<select name="chCollaborator_id" class="form-control form-control-sm" required>
									<option value="">Seleccione un docente...</option>
									@foreach($collaborators as $collaborator)
										<option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">ASIGNATURA: </small>
								<select name="chIntelligence_id" class="form-control form-control-sm" required>
									<option value="">Seleccione una inteligencia...</option>
									@foreach($intelligences as $intelligence)
										<option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
									@endforeach
								</select>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<small class="text-muted">DESCRIPCION DE INTELIGENCIA: </small>
								<input type="text" name="chIntelligenceDescription" class="form-control form-control-sm" disabled>
							</div>
							<!-- sección se deja oculta ya que no se usa luego de actualizaciones requeridas -->
							<div class="form-group" style="display: none;">
								<!-- <small class="text-muted">DESCRIPCION DE ACTIVIDADES DE LA SEMANA: </small>
								<textarea name="chDescription" class="form-control form-control-sm" cols="10" rows="5" maxlength="1000" placeholder="De máximo 1000 carácteres" required></textarea> -->
							</div>
						</div>
					</div>
					<div class="row sectionBases" style="display: none;">
						<div class="col-md-12">
							<div class="row p-2">
								<div class="col-md-6">
									<h6 class="text-muted">BASES DE ACTIVIDADES</h6>
								</div>
								<div class="col-md-6">
									<button type="button" class="bj-btn-table-edit form-control-sm btn-add" title="AGREGAR BASE DE ACTIVIDAD">
										<i class="fas fa-plus-square"></i>
									</button>
									<button type="button" class="bj-btn-table-delete form-control-sm btn-del" title="QUITAR BASE DE ACTIVIDAD">
										<i class="fas fa-minus-square"></i>
									</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 allItemsBase d-flex flex-column">
									<div class="form-group itemBase">
										<select name="chBases_id" class="form-control form-control-sm chBase" required>
											<option value="">Seleccione una base de actividad...</option>
											<!-- Dinamics option with selected the intelligence -->
										</select>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row sectionFinal" style="display: none;">
				<div class="col-md-12 text-center">
					<input type="hidden" name="chBases" class="form-control form-control-sm" required>
					<button type="submit" class="bj-btn-table-add form-control-sm btn-register">REGISTRAR CRONOGRAMA</button>
				</div>
			</div>
		</form>
	</div>

	<!-- MODAL PARA VER DETALLES Y FILTRAR DESCARGAR PDF -->
	<div class="modal fade" id="filterPlanning-Modal">
	  	<div class="modal-dialog">
		    <div class="modal-content px-4 py-4">
		    	<form action="{{ route('planning.pdf') }}" method="GET">
		    		@csrf
			    	<div class="modal-header row">
			    		<div class="col-md-12">
			    			<h6 class="text-muted mb-4">DESCARGA DE CRONOGRAMA: </h6>
			    			<hr>
							<div class="row py-3 border-top border-bottom">
					      		<div class="col-md-4 text-center">
									<small class="text-muted">
										<input type="radio" name="optionFilter" value="INTELLIGENCE" checked>
										Por inteligencia
									</small>
								</div>
								<div class="col-md-4 text-center">
									<small class="text-muted">
										<input type="radio" name="optionFilter" value="COURSE">
										Por curso
									</small>
								</div>
								<div class="col-md-4 text-center">
									<small class="text-muted">
										<input type="radio" name="optionFilter" value="COLLABORATOR">
										Por docente
									</small>
								</div>
						   	</div>
		    				<div class="row my-3">
		    					<div class="col-md-12">
		    						<div class="form-group dinamicIntelligence">
		    							<small class="text-muted">INTELIGENCIA:</small>
										<select name="chFilterIntelligence" class="form-control form-control-sm" required>
											<option value="">Seleccione una inteligencia...</option>
											@foreach($intelligences as $intelligence)
												<option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
											@endforeach
										</select>
										<!-- <small class="text-muted">FECHA INICIAL:</small>
										<input type="text" name="chFilterIntelligenceDateInitial" class="form-control form-control-sm datepicker" required autocomplete="off">
										<small class="text-muted">FECHA FINAL:</small>
										<input type="text" name="chFilterIntelligenceDateFinal" class="form-control form-control-sm datepicker" required autocomplete="off"> -->
		    						</div>
		    						<div class="form-group dinamicCourse" style="display: none;">
		    							<small class="text-muted">CURSO:</small>
										<select name="chFilterCourse" class="form-control form-control-sm" disabled>
											<option value="">Seleccione un curso...</option>
											@foreach($courses as $course)
												<option value="{{ $course->id }}">{{ $course->name }}</option>
											@endforeach
										</select>
										<!-- <small class="text-muted">FECHA INICIAL:</small>
										<input type="text" name="chFilterCourseDateInitial" class="form-control form-control-sm datepicker" autocomplete="off">
										<small class="text-muted">FECHA FINAL:</small>
										<input type="text" name="chFilterCourseDateFinal" class="form-control form-control-sm datepicker" autocomplete="off"> -->
		    						</div>
		    						<div class="form-group dinamicCollaborator" style="display: none;">
		    							<small class="text-muted">DOCENTE:</small>
										<select name="chFilterCollaborator" class="form-control form-control-sm" disabled>
											<option value="">Seleccione un docente...</option>
											@foreach($collaborators as $collaborator)
												<option value="{{ $collaborator->id }}">{{ $collaborator->nameCollaborator }}</option>
											@endforeach
										</select>
										<!-- <small class="text-muted">FECHA INICIAL:</small>
										<input type="text" name="chFilterCollaboratorDateInitial" class="form-control form-control-sm datepicker" autocomplete="off">
										<small class="text-muted">FECHA FINAL:</small>
										<input type="text" name="chFilterCollaboratorDateFinal" class="form-control form-control-sm datepicker" autocomplete="off"> -->
		    						</div>
		    					</div>
		    				</div>
			    		</div>
			    	</div>
			    	<div class="modal-body">
			    		<button type="submit" class="bj-btn-table-delete mx-3 form-control-sm"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
			    		<button type="button" class="bj-btn-table-delete float-right form-control-sm" data-dismiss="modal">CERRAR</button>
			    	</div>
			    </form>
		    </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		var arrayRanges = [];
		$(function(){
		});

		$('input[name=optionFilter]').on('click',function(e){
			var value = e.target.value;
			if(value == 'INTELLIGENCE'){

				$('.dinamicIntelligence').css('display','block');
				$('select[name=chFilterIntelligence]').attr('disabled',false);
				$('select[name=chFilterIntelligence]').attr('required',true);
				$('input[name=chFilterIntelligenceDateInitial]').attr('disabled',false);
				$('input[name=chFilterIntelligenceDateInitial]').attr('required',true);
				$('input[name=chFilterIntelligenceDateFinal]').attr('disabled',false);
				$('input[name=chFilterIntelligenceDateFinal]').attr('required',true);

				$('.dinamicCourse').css('display','none');
				$('select[name=chFilterCourse]').attr('disabled',true);
				$('select[name=chFilterCourse]').attr('required',false);
				$('input[name=chFilterCourseDateInitial]').attr('disabled',true);
				$('input[name=chFilterCourseDateInitial]').attr('required',false);
				$('input[name=chFilterCourseDateFinal]').attr('disabled',true);
				$('input[name=chFilterCourseDateFinal]').attr('required',false);

				$('.dinamicCollaborator').css('display','none');
				$('select[name=chFilterCollaborator]').attr('disabled',true);
				$('select[name=chFilterCollaborator]').attr('required',false);
				$('input[name=chFilterCollaboratorDateInitial]').attr('disabled',true);
				$('input[name=chFilterCollaboratorDateInitial]').attr('required',false);
				$('input[name=chFilterCollaboratorDateFinal]').attr('disabled',true);
				$('input[name=chFilterCollaboratorDateFinal]').attr('required',false);

			}else if(value == 'COURSE'){

				$('.dinamicIntelligence').css('display','none');
				$('select[name=chFilterIntelligence]').attr('disabled',true);
				$('select[name=chFilterIntelligence]').attr('required',false);
				$('input[name=chFilterIntelligenceDateInitial]').attr('disabled',true);
				$('input[name=chFilterIntelligenceDateInitial]').attr('required',false);
				$('input[name=chFilterIntelligenceDateFinal]').attr('disabled',true);
				$('input[name=chFilterIntelligenceDateFinal]').attr('required',false);

				$('.dinamicCourse').css('display','block');
				$('select[name=chFilterCourse]').attr('disabled',false);
				$('select[name=chFilterCourse]').attr('required',true);
				$('input[name=chFilterCourseDateInitial]').attr('disabled',false);
				$('input[name=chFilterCourseDateInitial]').attr('required',true);
				$('input[name=chFilterCourseDateFinal]').attr('disabled',false);
				$('input[name=chFilterCourseDateFinal]').attr('required',true);

				$('.dinamicCollaborator').css('display','none');
				$('select[name=chFilterCollaborator]').attr('disabled',true);
				$('select[name=chFilterCollaborator]').attr('required',false);
				$('input[name=chFilterCollaboratorDateInitial]').attr('disabled',true);
				$('input[name=chFilterCollaboratorDateInitial]').attr('required',false);
				$('input[name=chFilterCollaboratorDateFinal]').attr('disabled',true);
				$('input[name=chFilterCollaboratorDateFinal]').attr('required',false);

			}else if(value == 'COLLABORATOR'){

				$('.dinamicIntelligence').css('display','none');
				$('select[name=chFilterIntelligence]').attr('disabled',true);
				$('select[name=chFilterIntelligence]').attr('required',false);
				$('input[name=chFilterIntelligenceDateInitial]').attr('disabled',true);
				$('input[name=chFilterIntelligenceDateInitial]').attr('required',false);
				$('input[name=chFilterIntelligenceDateFinal]').attr('disabled',true);
				$('input[name=chFilterIntelligenceDateFinal]').attr('required',false);

				$('.dinamicCourse').css('display','none');
				$('select[name=chFilterCourse]').attr('disabled',true);
				$('select[name=chFilterCourse]').attr('required',false);
				$('input[name=chFilterCourseDateInitial]').attr('disabled',true);
				$('input[name=chFilterCourseDateInitial]').attr('required',false);
				$('input[name=chFilterCourseDateFinal]').attr('disabled',true);
				$('input[name=chFilterCourseDateFinal]').attr('required',false);

				$('.dinamicCollaborator').css('display','block');
				$('select[name=chFilterCollaborator]').attr('disabled',false);
				$('select[name=chFilterCollaborator]').attr('required',true);
				$('input[name=chFilterCollaboratorDateInitial]').attr('disabled',false);
				$('input[name=chFilterCollaboratorDateInitial]').attr('required',true);
				$('input[name=chFilterCollaboratorDateFinal]').attr('disabled',false);
				$('input[name=chFilterCollaboratorDateFinal]').attr('required',true);

			}
		});

		$('.filterPlanning-link').on('click',function(){
			$('#filterPlanning-Modal').modal();
		});

		$('select[name=chIntelligence_id]').on('change',function(e){
			if(e.target.value != ''){
				$.get("{{ route('getDescriptionIntelligence') }}",{ intelligenceSelected: e.target.value },function(objectDescription){
					if(objectDescription != null && objectDescription != ''){
						$('input[name=chIntelligenceDescription]').val('');
						$('input[name=chIntelligenceDescription]').val(objectDescription['description']);
					}
					$.get("{{ route('getBasesFromIntelligence') }}",{ intelligenceSelected: e.target.value },function(objectBases){
						var count = Object.keys(objectBases).length;
						var countItems = 1;
						$('.allItemsBase .itemBase').each(function(){
							if(countItems == 1){
								$(this).find('select').empty();
								$(this).find('select').append("<option value=''>Seleccione una base de actividad...</option>");
							}else{
								$(this).remove();
							}
							countItems++;
						});
						if(count > 0){
							for(var i = 0; i < count; i++){
								$('select[name=chBases_id]').append(
									"<option value='" + objectBases[i]['baId'] + "'>" +
										objectBases[i]['baDescription'] +
									"</option>"
								);
							}
							$('.sectionFinal').css('display','flex');
						}else{
							$('.sectionFinal').css('display','none');
						}
						$('.allItemsBase').css('display','flex');
					});
					$('.sectionBases').css('display','flex');
				});
			}else{
				$('input[name=chIntelligenceDescription]').val('');
				$('.sectionBases').css('display','none');
			}
		});

		$('.btn-add').on('click',function(){
			var item = $('.itemBase:first').clone();
			item.find('select').val('');
			$('.allItemsBase').append(item);
		});

		$('.btn-del').on('click',function(){
			var countItems =$('.allItemsBase .itemBase').length;
			if(countItems > 1){
				var item = $('.allItemsBase .itemBase:last').remove();
			}
		});

		$('.btn-register').on('click',function(){
			var itemBases = '';
			$('.chBase').each(function(){
				var baId = $(this).val();
				if(baId != ''){
					itemBases += baId + ':';
				}
			});
			if(itemBases != ''){
				$('input[name=chBases]').val(itemBases);
			}
			$(this).submit();
		});

		$('select[name=chCourse]').on('change',function(e){
			var courseSelected = e.target.value;
			if(courseSelected != ''){
				$('input[name=chNameCourse]').val('');
				$('input[name=chNameCourse]').val($('select[name=chCourse] option:selected').text());
				$.get("{{ route('getInfoCourseConsolidated') }}",{courseSelected: courseSelected},function(objectInfo){
					if(objectInfo != null && objectInfo != ''){
						$('input[name=chGrade]').val('');
						$('input[name=chGrade]').val(objectInfo['nameGrade']);
						$('input[name=chCollaborator-hidden]').val('');
						$('input[name=chCollaborator-hidden]').val(objectInfo['idCollaborator']);
						$('input[name=chCollaborator]').val('');
						$('input[name=chCollaborator]').val(objectInfo['nameCollaborator']);

						$.get("{{ route('getAcademicPeriodsCourse') }}",{courseSelected: courseSelected},function(objectPeriods){
							if(objectPeriods != null && objectPeriods != ''){
								var count = Object.keys(objectPeriods).length //total de periodos existentes del curso
								$('select[name=chPeriod]').empty();
								$('select[name=chPeriod]').append("<option value=''>Seleccione un periodo...</option>");
								for (var i = 0; i < count; i++) {
									$('select[name=chPeriod]').append('<option value=' + objectPeriods[i]['apId'] + '>' + objectPeriods[i]['apNameperiod'] + '</option>');
								}
								$('.nameCourseChronological').text('');
								$('.nameCourseChronological').text($('select[name=chCourse] option:selected').text());
							}
						});
					}
				});
			}else{
				$('input[name=chGrade]').val('');
				$('input[name=chCollaborator-hidden]').val('');
				$('input[name=chCollaborator]').val('');
				$('select[name=chPeriod]').empty();
				$('select[name=chPeriod]').append("<option value=''>Seleccione un periodo...</option>");
				$('.nameCourseChronological').text('');
			}
		});

		$('select[name=chPeriod]').on('change',function(e){
			var periodSelected = e.target.value;
			if(periodSelected != ''){
				$.get("{{ route('getRangePeriod') }}",{periodSelected: periodSelected},function(objectDates){
					if(objectDates != null && objectDates != ''){
						$('input[name=chDateInitial]').val('');
						$('input[name=chDateInitial]').val(objectDates['apDateInitial']);
						$('input[name=chDateFinal]').val('');
						$('input[name=chDateFinal]').val(objectDates['apDateFinal']);
						$('.configWeeks').css('display','block');

						var initial = $('input[name=chDateInitial]').val();
						var final = $('input[name=chDateFinal]').val()

						arrayRanges = getWeek(initial,final);
						if(arrayRanges != null && arrayRanges != ''){
							pushRanges();
							$('.changeWeekPrev').attr('disabled',true);
							$('.changeWeekNext').attr('disabled',false);
						}
					}
				});
			}else{
				$('.configWeeks').css('display','none');
			}
		});

		$('.changeWeekPrev').on('click',function(e){
			e.preventDefault();
			var indexRange = $('input[name=positionRange]').val();
			if(indexRange > 0){
				indexRange--;
				pushRanges(indexRange);
				if(indexRange == 0){
					$(this).attr('disabled',true);
					$('.changeWeekNext').attr('disabled',false);
				}else if(indexRange > 0){
					$(this).attr('disabled',false);
					$('.changeWeekNext').attr('disabled',false);
				}
			}
		});

		$('.changeWeekNext').on('click',function(e){
			e.preventDefault();
			var indexRange = $('input[name=positionRange]').val();
			if(indexRange < (arrayRanges.length - 1)){
				indexRange++;
				pushRanges(indexRange);
				if(indexRange == arrayRanges.length){
					$(this).attr('disabled',true);
					$('.changeWeekPrev').attr('disabled',false);
				}else if(indexRange < arrayRanges.length){
					$(this).attr('disabled',false);
					$('.changeWeekPrev').attr('disabled',false);
				}
			}
		});

		function pushRanges(value = 0){
			$('.numberWeek').text('');
			$('.numberWeek').text(arrayRanges[value][0]);
			$('input[name=chNumberWeek]').val('');
			$('input[name=chNumberWeek]').val(arrayRanges[value][0]);
			$('.dateInitialWeek').text('');
			$('.dateInitialWeek').text(arrayRanges[value][1]);
			$('.dateFinalWeek').text('');
			$('.dateFinalWeek').text(arrayRanges[value][2]);
			$('input[name=positionRange]').val('');
			$('input[name=positionRange]').val(value);
			$('input[name=chRangeWeek]').val('');
			$('input[name=chRangeWeek]').val(arrayRanges[value][1] + '/' + arrayRanges[value][2]);
		}

		function getWeek(dateInitial,dateFinal){
			
			var initial = new Date(dateInitial.replace(/-/g, '\/'));
			var final = new Date(dateFinal.replace(/-/g, '\/'));
			
			/*var dayInitial = initial.getDay();
			var monthInitial = initial.getMonth();
			var numberDayMonthInitial = initial.getDate();

			var dayFinal = final.getDay();
			var monthFinal = final.getMonth();
			var numberDayMonthFinal = final.getDate();

			var initialComplete = getDayString(dayInitial) + ', ' + numberDayMonthInitial + ' de ' + getMonthString(monthInitial) + ' de ' + initial.getFullYear();

			var finalComplete = getDayString(dayFinal) + ', ' + numberDayMonthFinal + ' de ' + getMonthString(monthFinal) + ' de ' + final.getFullYear();
			$('.dateInitialWeek').text('');
			$('.dateInitialWeek').text(initialComplete);
			$('.dateFinalWeek').text('');
			$('.dateFinalWeek').text(finalComplete);*/

			var dates = [];
			var weekNumber = 1;
			while(initial.getTime() <= final.getTime()){
				var nowWeek = weekNumber;
				var nowInitial = initial.getFullYear() + '-' + 
				    					((initial.getMonth()+1)<10 ? '0' : '') + (initial.getMonth()+1) + '-' +
										(initial.getDate()<10 ? '0' : '') + initial.getDate();
				initial.setTime( initial.getTime() + (86400000*7) );
				var nowFinal = initial.getFullYear() + '-' + 
				    					((initial.getMonth()+1)<10 ? '0' : '') + (initial.getMonth()+1) + '-' +
										((initial.getDate()-1)<10 ? '0' : '') + (initial.getDate()-1);
				dates.push( [ nowWeek,nowInitial,nowFinal ] );
				weekNumber++;
			}
			return dates;
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

		/*document.addEventListener('DOMContentLoaded', function() {
	        var calendarEl = document.getElementById('fullCalendarChronological');
	        //var btnAgenda = document.getElementById('btn-agenda');

	        var calendar = new FullCalendar.Calendar(calendarEl, {
	          	plugins: [ 'interaction', 'dayGrid','timeGrid' ],
	          	//defaultView: 'agendaWeek',
	          	businessHours: {
				    start: '07:00', // hora final
				    end: '18:00', // hora inicial
				    dow: [ 1, 2, 3, 4, 5 ] // dias de semana, 0=Domingo
				},
	          	editable: true,
	          	selectable: true,
	          	header: { 
	          		left: 'prev,next today',
		          	center: 'title'
		          	//right: 'dayGrid'
		        },
				events:{
					//url:
				},
				eventClick: function(info){
					//console.log(info);
				},
				eventDrop: function(info){
					//console.log(info);
				},
				dateClick: function(info) {
					info.dateStr = $('input[name=chDateInitial]').val();
					console.log(info);
				},
				select: function(info) {
					//console.log(info);			
			    },
			    dateRender: function(date, cell){
			    	//console.log(date + ' ' + cell);
			    }
	        });
	        calendar.setOption('locale','es');
	        calendar.render();
	    });*/
	</script>
@endsection