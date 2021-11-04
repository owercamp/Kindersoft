@extends('modules.increase')

@section('logisticModules')
	<div class="col-md-12 p-3">
		<div class="row border-bottom mb-3">
			<div class="col-md-4">
				<h5>VALORACIONES PERIODICAS</h5>
			</div>
			<div class="col-md-4">
				<button type="button" title="NUEVO REGISTRO" class="bj-btn-table-add form-control-sm newRating-link">NUEVA VALORACION</button>
			</div>
			<div class="col-md-4">
				<!-- Mensajes de creación de valoraciones periodicas -->
				@if(session('SuccessSaveRating'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveRating') }}
				    </div>
				@endif
				@if(session('SecondarySaveRating'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveRating') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de valoraciones periodicas -->
				@if(session('PrimaryUpdateRating'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateRating') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateRating'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateRating') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de valoraciones periodicas -->
				@if(session('WarningDeleteRating'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteRating') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteRating'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteRating') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tableDatatable" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>ALUMNO</th>
					<th>PERIODO</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $row = 1; @endphp
				@foreach($ratings as $rating)
					<tr>
						<td>{{ $row++ }}</td>
						<td>{{ $rating->nameStudent }}</td>
						<td>{{ $rating->namePeriod }}</td>
						<td>
							<form action="{{ route('ratingPeriod.pdf') }}" style="display: inline-block;">
								<input type="hidden" name="rpIdPdf" value="{{ $rating->rpId }}" class="form-control form-control-sm">
								<button type="submit" title="DESCARGAR PDF" class="bj-btn-table-delete">
									<i class="fas fa-file-pdf"></i>					
								</button>
							</form>
							<a href="#" title="EDITAR" class="bj-btn-table-edit editRating-link">
								<i class="fas fa-edit"></i>
								<span hidden>{{ $rating->rpId }}</span>
								<span hidden>{{ $rating->rpStudent_id }}</span>
								<span hidden>{{ $rating->rpAcademicperiod_id }}</span>
							</a>
							<a href="#" title="ELIMINAR" class="bj-btn-table-delete deleteRating-link">
								<i class="fas fa-trash-alt"></i>
								<span hidden>{{ $rating->rpId }}</span>
								<span hidden>{{ $rating->rpStudent_id }}</span>
								<span hidden>{{ $rating->rpAcademicperiod_id }}</span>						
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="newRating-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="text-muted">NUEVA VALORACION PERIODICA:</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="{{ route('ratingPeriod.new') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">ALUMNO:</small>
									<select name="rpStudent_id" class="form-control form-control-sm" required>
										<option value="">Seleccion un alumno...</option>
										@foreach($students as $student)
											@if ($student->status == 'ACTIVO')
												<option value="{{ $student->idStudent }}">{{ $student->nameStudent }}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">PERIODO:</small>
									<select name="rpAcademicperiod_id" class="form-control form-control-sm" required>
										<option value="">Seleccion un periodo...</option>
										<!-- Dinamics periods -->
									</select>
									<span class="infoIfexistsperiods" style="display: none; padding: 2px; font-size: 12px; font-weight: bold; color: red; transition: all .2s;"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center d-flex justify-content-center">
								<div class="spinner-border" align="center" role="status">
								  <span class="sr-only" align="center">Procesando...</span>
								</div>
							</div>
						</div>
						<div class="row text-center newRatingDetails" style="display: none;">
							<div class="col-md-12 p-4">
								<div class="row ">
									<div class="col-md-6">
										<span class="rantingStudent-info"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingCourse-info"></span>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-md-6">
										<span class="rantingNumberdocument-info"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingPeriod-info"></span>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 1</h6>
										<div class="form-group">
											<small class="text-muted">Peso</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-weight"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (K)" step="00.01" name="rpWeight_one" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Talla</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-text-height"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (m.cm)" step="00.01" name="rpHeight_one" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Observacion</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-outdent"></i>
												    </span>
												</div>
												<textarea type="text" name="rpObservation_one" maxlength="500" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 2</h6>
										<div class="form-group">
											<small class="text-muted">Peso</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-weight"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (K)" step="00.01" name="rpWeight_two" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Talla</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-text-height"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (m.cm)" step="00.01" name="rpHeight_two" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Observacion</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-outdent"></i>
												    </span>
												</div>
												<textarea type="text" name="rpObservation_two" maxlength="500" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<div class="form-group">
											<small class="text-muted">Tamizaje auditivo:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealtear" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Tamizaje visual:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealteye" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Valoración salud oral:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealthoral" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-10">
										<div class="form-group">
											<small class="text-muted">Observaciones generales de salud:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-notes-medical"></i>
												    </span>
												</div>
												<select name="rpObservationhealth_id" class="form-control form-control-sm">
													<option value="">Seleccione observacion de salud...</option>
													@foreach($observationsHealth as $observation)
														<option value="{{ $observation->ohId }}">{{ $observation->ohObservation }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group form-inline pt-4">
												<a href="#" id="plusObservationhealt" class="bj-btn-table-edit form-control-sm" title="AGREGAR OBSERVACION DE SALUD"><i class="fas fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<ul class="navObservationshealth">
											<!-- li dinamics -->
										</ul>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-12">
										<div class="form-group">
											<small class="text-muted"><i class="fas fa-heartbeat"></i> Esquemas de vacunación</small>
											<table class="table text-center" width="100%" style="font-size: 12px;">
												<tbody class="tbody-vaccinations">
													@php $item = 1; @endphp
													@foreach($vaccinations as $vaccination)
														<tr class="{{ $vaccination->vaId }}">
															<td>
																{{ $item++ }} - {{ $vaccination->vaName }}
															</td>
															<td>
																<div class="row">
														      		<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="option_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="SI">
																			SI
																		</small>
																	</div>
																	<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="option_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="NO">
																			NO
																		</small>
																	</div>
																	<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="option_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="N/A" checked>
																			N/A
																		</small>
																	</div>
														      	</div>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-10">
										<div class="form-group">
											<small class="text-muted">Profesionales de la salud:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-medkit"></i>
												    </span>
												</div>
												<select name="rpProfessionalhealth_id" class="form-control form-control-sm">
													<option value="">Seleccione profesional de la salud...</option>
													@foreach($professionalHealths as $professional)
														<option value="{{ $professional->phId }}">{{ $professional->phName }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group form-inline pt-4">
												<a href="#" id="plusProfessionalhealt" class="bj-btn-table-edit form-control-sm" title="AGREGAR PROFESIONAL DE LA SALUD"><i class="fas fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<ul class="navProfessionalhealth">
											<!-- li dinamics -->
										</ul>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="detailsVaccinations" class="form-control form-control-sm" required>
										<input type="hidden" name="detailsProfessionalhealthsSelected" class="form-control form-control-sm" required>
										<input type="hidden" name="detailsObservationhealthsSelected" class="form-control form-control-sm" required>
										<button type="submit" class="bj-btn-table-add form-control-sm btn-saveRating">GUARDAR VALORACION</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editRating-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="text-muted">MODIFICACION DE VALORACION:</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="{{ route('ratingPeriod.update') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="row text-center">
							<div class="col-md-12 p-4">
								<div class="row ">
									<div class="col-md-6">
										<span class="rantingStudent-infoEdit"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingCourse-infoEdit"></span>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-md-6">
										<span class="rantingNumberdocument-infoEdit"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingPeriod-infoEdit"></span>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 1</h6>
										<div class="form-group">
											<small class="text-muted">Peso</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-weight"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (K)" step="00.01" name="rpWeight_oneEdit" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Talla</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-text-height"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 50.14 (m.cm)" step="00.01" name="rpHeight_oneEdit" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Observacion</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-outdent"></i>
												    </span>
												</div>
												<textarea type="text" name="rpObservation_oneEdit" maxlength="500" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 2</h6>
										<div class="form-group">
											<small class="text-muted">Peso</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-weight"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 25.14 (K)" step="00.01" name="rpWeight_twoEdit" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Talla</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-text-height"></i>
												    </span>
												</div>
												<input type="number" placeholder="Ej. 50.14 (m.cm)" step="00.01" name="rpHeight_twoEdit" class="form-control form-control-sm text-center" required>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Observacion</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-outdent"></i>
												    </span>
												</div>
												<textarea type="text" name="rpObservation_twoEdit" maxlength="500" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<div class="form-group">
											<small class="text-muted">Tamizaje auditivo:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealtearEdit" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Tamizaje visual:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealteyeEdit" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
										<div class="form-group">
											<small class="text-muted">Valoración salud oral:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-pencil-alt"></i>
												    </span>
												</div>
												<textarea type="text" name="rpHealthoralEdit" maxlength="500" placeholder="Observación de 500 carácteres máximo" class="form-control form-control-sm text-left" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-10">
										<div class="form-group">
											<small class="text-muted">Observaciones generales de salud:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-notes-medical"></i>
												    </span>
												</div>
												<select name="rpObservationhealth_idEdit" class="form-control form-control-sm">
													<option value="">Seleccione observacion de salud...</option>
													@foreach($observationsHealth as $observation)
														<option value="{{ $observation->ohId }}">{{ $observation->ohObservation }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group form-inline pt-4">
												<a href="#" id="plusObservationhealtEdit" class="bj-btn-table-edit form-control-sm" title="AGREGAR OBSERVACION DE SALUD"><i class="fas fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<ul class="navObservationshealthEdit">
											<!-- li dinamics -->
										</ul>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-12">
										<div class="form-group">
											<small class="text-muted"><i class="fas fa-heartbeat"></i> Esquemas de vacunación</small>
											<table class="table text-center" width="100%" style="font-size: 12px;">
												<tbody class="tbody-vaccinationsEdit">
													@php $item = 1; @endphp
													@foreach($vaccinations as $vaccination)
														<tr class="{{ $vaccination->vaId }}">
															<td>
																{{ $item++ }} - {{ $vaccination->vaName }}
															</td>
															<td>
																<div class="row">
														      		<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="optionEdit_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="SI">
																			SI
																		</small>
																	</div>
																	<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="optionEdit_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="NO">
																			NO
																		</small>
																	</div>
																	<div class="col-md-4 text-center">
																		<small class="text-muted">
																			<input type="radio" name="optionEdit_{{ $vaccination->vaId }}" class="{{ $vaccination->vaId }}" value="N/A">
																			N/A
																		</small>
																	</div>
														      	</div>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<hr>
								<div class="row text-left">
									<div class="col-md-10">
										<div class="form-group">
											<small class="text-muted">Profesionales de la salud:</small>
											<div class="input-group">
												<div class="input-group-prepend">
												    <span class="input-group-text">
												    	<i class="fas fa-medkit"></i>
												    </span>
												</div>
												<select name="rpProfessionalhealth_idEdit" class="form-control form-control-sm">
													<option value="">Seleccione profesional de la salud...</option>
													@foreach($professionalHealths as $professional)
														<option value="{{ $professional->phId }}">{{ $professional->phName }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group form-inline pt-4">
												<a href="#" id="plusProfessionalhealtEdit" class="bj-btn-table-edit form-control-sm" title="AGREGAR PROFESIONAL DE LA SALUD"><i class="fas fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="row text-left">
									<div class="col-md-12">
										<ul class="navProfessionalhealthEdit">
											<!-- li dinamics -->
										</ul>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="detailsVaccinationsEdit" class="form-control form-control-sm" required>
										<input type="hidden" name="detailsProfessionalhealthsSelectedEdit" class="form-control form-control-sm" required>
										<input type="hidden" name="detailsObservationhealthsSelectedEdit" class="form-control form-control-sm" required>
										<input type="hidden" name="rpStudent_idEdit" class="form-control form-control-sm" required>
										<input type="hidden" name="rpAcademicperiod_idEdit" class="form-control form-control-sm" required>
										<input type="hidden" name="rpIdEdit" class="form-control form-control-sm" required>
										<button type="submit" class="bj-btn-table-edit form-control-sm btn-editRating">ACTUALIZAR VALORACION</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="deleteRating-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="text-muted">ELIMINACION DE VALORACION:</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" style="font-size: 12px;">
						<div class="row">
							<div class="col-md-12 p-4">
								<div class="row ">
									<div class="col-md-6">
										<span class="rantingStudent-infoDelete"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingCourse-infoDelete"></span>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-md-6">
										<span class="rantingNumberdocument-infoDelete"></span>
									</div>
									<div class="col-md-6">
										<span class="rantingPeriod-infoDelete"></span>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 1</h6>

										<small class="text-muted">Peso:</small><br>
										<span class="rpWeight_oneDelete"></span><br>
										<small class="text-muted">Talla:</small><br>
										<span class="rpHeight_oneDelete"></span><br>
										<small class="text-muted">Observación:</small><br>
										<span class="rpObservation_oneDelete"></span>
									</div>
									<div class="col-md-6">
										<h6>TOMA ANTROPOMETRICA 2</h6>

										<small class="text-muted">Peso:</small><br>
										<span class="rpWeight_twoDelete"></span><br>
										<small class="text-muted">Talla:</small><br>
										<span class="rpHeight_twoDelete"></span><br>
										<small class="text-muted">Observación:</small><br>
										<span class="rpObservation_twoDelete"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>TAMIZAJE AUDITIVO:</h6>
										<span class="rpHealtearDelete"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>TAMIZAJE VISUAL:</h6>
										<span class="rpHealteyeDelete"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>VALORACION SALUD ORAL:</h6>
										<span class="rpHealthoralDelete"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>OBSERVACIONES GENERALES DE SALUD:</h6>
										<ul class="navObservationshealthDelete"></ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>ESQUEMAS DE VACUNACION:</h6>
										<ul class="navVaccinationsDelete"></ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h6>PROFESIONALES DE LA SALUD:</h6>
										<ul class="navProfessionalhealthDelete"></ul>
									</div>
								</div>
								<hr>
								<form class="row text-center" action="{{ route('ratingPeriod.delete') }}" method="POST">
									@csrf
									<div class="col-md-12">
										<input type="hidden" name="rpStudent_idDelete" class="form-control form-control-sm" required>
										<input type="hidden" name="rpAcademicperiod_idDelete" class="form-control form-control-sm" required>
										<input type="hidden" name="rpIdDelete" class="form-control form-control-sm" required>
										<button type="submit" class="bj-btn-table-delete form-control-sm btn-editRating">ELIMINAR VALORACION</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- FIN -->

			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){
			$('.spinner-border').css('display','none');
		});

		/*================================================================================================================
			EVENTOS DE LAS OBSERVACION DE SALUD PARA AGREGAR O BORRAR MAS DE UNA EN MODAL DE NUEVA VALORACION
		================================================================================================================*/

		$('.newRating-link').on('click',function(e){
			e.preventDefault();
			$('#newRating-modal').modal();
		});

		$('select[name=rpStudent_id]').on('change',function(e){
			var studentSelected = e.target.value;
			if(studentSelected != ''){
				var infoStudent = [];
				$.get("{{ route('getPeriodsRating') }}",{studentSelected: studentSelected},function(objectPeriods){
					var count = Object.keys(objectPeriods).length;
					$('select[name=rpAcademicperiod_id]').empty();
					$('select[name=rpAcademicperiod_id]').append("<option value=''>Seleccione un periodo...</option>");
					$('.spinner-border').css('display','block');
					$('.newRatingDetails').css('display','none');
					$('.rantingPeriod-info').text('');
					if(count > 0){
						for (var i = 0; i < count; i++) {
							if(objectPeriods[i][0] == 'INFORMACION BASICA'){
								$('.rantingStudent-info').text(objectPeriods[i][1]);
								$('.rantingNumberdocument-info').text(objectPeriods[i][3] + ' EDAD: ' + getYearsold(converterYearsoldFromBirtdate(objectPeriods[i][2])));
								$('.rantingCourse-info').text(objectPeriods[i][4]);
							}else{
								$('select[name=rpAcademicperiod_id]').append('<option value=' + objectPeriods[i][0] + '>' + objectPeriods[i][1] + '</option>');
							}
						}
						$('.newRatingDetails').css('display','block');
						$('.spinner-border').css('display','none');
					}else{
						$('.infoIfexistsperiods').css('display','block');
						$('.infoIfexistsperiods').text('No hay periodos registrados para el alumno');
						$('.spinner-border').css('display','none');
						setTimeout(function(){
							$('.infoIfexistsperiods').css('display','none');
							$('.infoIfexistsperiods').text('');
						},3000);
					}
				});
			}else{
				resetAll();
			}
		});

		$('select[name=rpAcademicperiod_id]').on('change',function(e){
			var periodSelected = e.target.value;
			var periodText = $('select[name=rpAcademicperiod_id] option:selected').text();
			var studentSelected = $('select[name=rpStudent_id] option:selected').val();
			if(periodSelected != '' && studentSelected != ''){
				$('.rantingPeriod-info').text(periodText);
			}else{
				$('.rantingPeriod-info').text('');
			}
		});

		$('#plusObservationhealt').on('click',function(e){
			e.preventDefault();
			var text = $('select[name=rpObservationhealth_id] option:selected').text();
			var value = $('select[name=rpObservationhealth_id]').val();
			if(value != ''){
				$('.navObservationshealth').append(
						"<li class='" + value + "' style='font-size: 12px;'>" + text + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
					);
			}
		});

		$('#plusProfessionalhealt').on('click',function(e){
			e.preventDefault();
			var text = $('select[name=rpProfessionalhealth_id] option:selected').text();
			var value = $('select[name=rpProfessionalhealth_id]').val();
			if(value != ''){
				$('.navProfessionalhealth').append(
						"<li class='" + value + "' style='font-size: 12px;'>" + text + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
					);
			}
		});

		$('.navObservationshealth').on('click','.plusListEdit',function(e){
			e.preventDefault();
			$(this).parent('li').remove();
		});

		$('.navProfessionalhealth').on('click','.plusListEdit',function(e){
			e.preventDefault();
			$(this).parent('li').remove();
		});

		$('.btn-saveRating').on('click',function(e){
			// e.preventDefault();
			var observationsHealth = '';
			$('.navObservationshealth li').each(function(){
				observationsHealth += $(this).attr('class') + ':';
			});
			$('input[name=detailsObservationhealthsSelected]').val(observationsHealth);
			var professionalsHealth = '';
			$('.navProfessionalhealth li').each(function(){
				professionalsHealth += $(this).attr('class') + ':';
			});
			$('input[name=detailsProfessionalhealthsSelected]').val(professionalsHealth);
			var vaccinations = '';
			$('.tbody-vaccinations tr').each(function(){
				var vaId = $(this).attr('class');
				var check = $(this).find($('input[name=option_' + vaId + ']:checked')).val();
				var vacc = $(this).find('td:first').text();
				vaccinations += vaId + '=' + check + ':';
			});
			$('input[name=detailsVaccinations]').val(vaccinations);
			$(this).submit();
		});

		/*================================================================================================================
			EVENTOS DE MODAL DE EDICION DE VALORACIONES
		================================================================================================================*/

		$('.editRating-link').on('click',function(e){
			e.preventDefault();
			var rpId = $(this).find('span:nth-child(2)').text();
			var rpStudent_id = $(this).find('span:nth-child(3)').text();
			var rpAcademicperiod_id = $(this).find('span:nth-child(4)').text();
			if(rpId != ''){
				$('.navObservationshealthEdit').empty();
				$('.navProfessionalhealthEdit').empty();
				$('input[name=rpIdEdit]').val(rpId);
				$('input[name=rpStudent_idEdit]').val(rpStudent_id);
				$('input[name=rpAcademicperiod_idEdit]').val(rpAcademicperiod_id);
				$.get("{{ route('getRating') }}",{ rpId: rpId },function(objectRating){
					if(objectRating != null){
						$('.rantingStudent-infoEdit').text(objectRating['nameStudent']);
						$('.rantingNumberdocument-infoEdit').text(objectRating['numberdocument'] + ' EDAD: ' + getYearsold(converterYearsoldFromBirtdate(objectRating['birthdate'])));
						$('.rantingCourse-infoEdit').text(objectRating['nameCourse']);
						$('.rantingPeriod-infoEdit').text(objectRating['apNameperiod']);
						$('input[name=rpWeight_oneEdit]').val(objectRating['rpWeight_one']);
						$('input[name=rpHeight_oneEdit]').val(objectRating['rpHeight_one']);
						$('textarea[name=rpObservation_oneEdit]').val(objectRating['rpObservation_one']);
						$('input[name=rpWeight_twoEdit]').val(objectRating['rpWeight_two']);
						$('input[name=rpHeight_twoEdit]').val(objectRating['rpHeight_two']);
						$('textarea[name=rpObservation_twoEdit]').val(objectRating['rpObservation_two']);
						$('textarea[name=rpHealtearEdit]').val(objectRating['rpHealtear']);
						$('textarea[name=rpHealteyeEdit]').val(objectRating['rpHealteye']);
						$('textarea[name=rpHealthoralEdit]').val(objectRating['rpHealthoral']);
						// COMPLETAR LA LISTA DE LAS OBSERVACIONES ACTUALES EN LA VALORACION
						if(objectRating['rpObservationshealth'].length >= 3){
							var separatedObservations = objectRating['rpObservationshealth'].split(':');
							for (var i = 0; i < separatedObservations.length; i++) {
								$.get("{{ route('getObservationhealth') }}",{ ohId: separatedObservations[i] },function(objectObservationhealth){
									if(objectObservationhealth != null){
										$('.navObservationshealthEdit').append(
												"<li class='" + objectObservationhealth['ohId'] + "' style='font-size: 12px;'>" + objectObservationhealth['ohObservation'] + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
											);
									}

								});
							}
						}else if(objectRating['rpObservationshealth'].length == 1){
							$.get("{{ route('getObservationhealth') }}",{ ohId: objectRating['rpObservationshealth'] },function(objectObservationhealth){
								if(objectObservationhealth != null){
									$('.navObservationshealthEdit').append(
											"<li class='" + objectObservationhealth['ohId'] + "' style='font-size: 12px;'>" + objectObservationhealth['ohObservation'] + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
										);
								}

							});
						}
						// COMPLETAR LAS FILAS DEL ESQUEMA DE VACUNACIONES CON SU ESTADO PARA LA VALORACION
						var separatedVaccination = objectRating['rpVaccinations'].split(':');
						for (var i = 0; i < separatedVaccination.length; i++) {
							var vaccination = separatedVaccination[i].split('=');
							$('.tbody-vaccinationsEdit tr').each(function(){
								var idRow = $(this).attr('class');
								if(idRow == vaccination[0]){
									$('input[name=optionEdit_' + idRow + ']').each(function(){
										if($(this).val() == vaccination[1]){
											$(this).attr("checked",true);
										}
									});
								}
							});
						}
						// COMPLETAR LA LISTA DE LOS PROFESIONALES DE LA SALUD ACTUALES EN LA VALORACION
						if(objectRating['rpProfessionaslhealth'].length >= 3){
							var separatedProfessionals = objectRating['rpProfessionaslhealth'].split(':');
							for (var i = 0; i < separatedProfessionals.length; i++) {
								$.get("{{ route('getProfessionalhealth') }}",{ phId: separatedProfessionals[i] },function(objectProfessionalhealth){
									if(objectProfessionalhealth != null){
										$('.navProfessionalhealthEdit').append(
												"<li class='" + objectProfessionalhealth['phId'] + "' style='font-size: 12px;'>" + objectProfessionalhealth['phName'] + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
											);
									}

								});
							}
						}else if(objectRating['rpProfessionaslhealth'].length == 1){
							$.get("{{ route('getProfessionalhealth') }}",{ phId: objectRating['rpProfessionaslhealth'] },function(objectProfessionalhealth){
								var count = Object.keys(objectProfessionalhealth).length;
								console.log(count);
								if(count > 0){
									$('.navProfessionalhealthEdit').append(
											"<li class='" + objectProfessionalhealth['phId'] + "' style='font-size: 12px;'>" + objectProfessionalhealth['phName'] + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
										);
								}

							});
						}

					}else{

					}
				});
			}
			$('#editRating-modal').modal();
		});

		$('#plusObservationhealtEdit').on('click',function(e){
			e.preventDefault();
			var text = $('select[name=rpObservationhealth_idEdit] option:selected').text();
			var value = $('select[name=rpObservationhealth_idEdit]').val();
			if(value != ''){
				$('.navObservationshealthEdit').append(
						"<li class='" + value + "' style='font-size: 12px;'>" + text + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
					);
			}
		});

		$('#plusProfessionalhealtEdit').on('click',function(e){
			e.preventDefault();
			var text = $('select[name=rpProfessionalhealth_idEdit] option:selected').text();
			var value = $('select[name=rpProfessionalhealth_idEdit]').val();
			if(value != ''){
				$('.navProfessionalhealthEdit').append(
						"<li class='" + value + "' style='font-size: 12px;'>" + text + "<a href='#' title='QUITAR' class='plusListEdit ml-3' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a></li>"
					);
			}
		});

		$('.navObservationshealthEdit').on('click','.plusListEdit',function(e){
			e.preventDefault();
			$(this).parent('li').remove();
		});

		$('.navProfessionalhealthEdit').on('click','.plusListEdit',function(e){
			e.preventDefault();
			$(this).parent('li').remove();
		});

		$('.btn-editRating').on('click',function(e){
			// e.preventDefault();
			var observationsHealth = '';
			$('.navObservationshealthEdit li').each(function(){
				observationsHealth += $(this).attr('class') + ':';
			});
			$('input[name=detailsObservationhealthsSelectedEdit]').val(observationsHealth);
			var professionalsHealth = '';
			$('.navProfessionalhealthEdit li').each(function(){
				professionalsHealth += $(this).attr('class') + ':';
			});
			$('input[name=detailsProfessionalhealthsSelectedEdit]').val(professionalsHealth);
			var vaccinations = '';
			$('.tbody-vaccinationsEdit tr').each(function(){
				var vaId = $(this).attr('class');
				var check = $(this).find($('input[name=optionEdit_' + vaId + ']:checked')).val();
				var vacc = $(this).find('td:first').text();
				vaccinations += vaId + '=' + check + ':';
			});
			$('input[name=detailsVaccinationsEdit]').val(vaccinations);
			$(this).submit();
		});

		/*================================================================================================================
			EVENTOS DE MODAL DE EDICION DE VALORACIONES
		================================================================================================================*/

		$('.deleteRating-link').on('click',function(e){
			e.preventDefault();
			var rpId = $(this).find('span:nth-child(2)').text();
			var rpStudent_id = $(this).find('span:nth-child(3)').text();
			var rpAcademicperiod_id = $(this).find('span:nth-child(4)').text();
			if(rpId != ''){
				$('.navObservationshealthDelete').empty();
				$('.navProfessionalhealthDelete').empty();
				$('.navVaccinationsDelete').empty();
				$('input[name=rpIdDelete]').val(rpId);
				$('input[name=rpStudent_idDelete]').val(rpStudent_id);
				$('input[name=rpAcademicperiod_idDelete]').val(rpAcademicperiod_id);
				$.get("{{ route('getRating') }}",{ rpId: rpId },function(objectRating){
					if(objectRating != null){
						$('.rantingStudent-infoDelete').text(objectRating['nameStudent']);
						$('.rantingNumberdocument-infoDelete').text(objectRating['numberdocument'] + ' EDAD: ' + getYearsold(converterYearsoldFromBirtdate(objectRating['birthdate'])));
						$('.rantingCourse-infoDelete').text(objectRating['nameCourse']);
						$('.rantingPeriod-infoDelete').text(objectRating['apNameperiod']);
						$('.rpWeight_oneDelete').text(objectRating['rpWeight_one']);
						$('.rpHeight_oneDelete').text(objectRating['rpHeight_one']);
						$('.rpObservation_oneDelete').text(objectRating['rpObservation_one']);
						$('.rpWeight_twoDelete').text(objectRating['rpWeight_two']);
						$('.rpHeight_twoDelete').text(objectRating['rpHeight_two']);
						$('.rpObservation_twoDelete').text(objectRating['rpObservation_two']);
						$('.rpHealtearDelete').text(objectRating['rpHealtear']);
						$('.rpHealteyeDelete').text(objectRating['rpHealteye']);
						$('.rpHealthoralDelete').text(objectRating['rpHealthoral']);
						// COMPLETAR LA LISTA DE LAS OBSERVACIONES ACTUALES EN LA VALORACION
						if(objectRating['rpObservationshealth'].length >= 3){
							var separatedObservations = objectRating['rpObservationshealth'].split(':');
							for (var i = 0; i < separatedObservations.length; i++) {
								$.get("{{ route('getObservationhealth') }}",{ ohId: separatedObservations[i] },function(objectObservationhealth){
									if(objectObservationhealth != null){
										$('.navObservationshealthDelete').append(
												"<li class='" + objectObservationhealth['ohId'] + "' style='font-size: 12px;'>" + objectObservationhealth['ohObservation'] + "</li>"
											);
									}

								});
							}
						}else if(objectRating['rpObservationshealth'].length == 1){
							$.get("{{ route('getObservationhealth') }}",{ ohId: objectRating['rpObservationshealth'] },function(objectObservationhealth){
								if(objectObservationhealth != null){
									$('.navObservationshealthDelete').append(
											"<li class='" + objectObservationhealth['ohId'] + "' style='font-size: 12px;'>" + objectObservationhealth['ohObservation'] + "</li>"
										);
								}

							});
						}
						// COMPLETAR LAS FILAS DEL ESQUEMA DE VACUNACIONES CON SU ESTADO PARA LA VALORACION
						var separatedVaccination = objectRating['rpVaccinations'].split(':');
						for (var i = 0; i < separatedVaccination.length; i++) {
							var vaccination = separatedVaccination[i].split('=');
							$.get("{{ route('getVaccinations') }}",{ vaId: vaccination[0], vaStatus: vaccination[1] },function(objectVaccination){
								if(objectVaccination != null){
									$('.navVaccinationsDelete').append(
											"<li style='font-size: 12px;'>" + objectVaccination[0] + " - " + objectVaccination[1] + "</li>"
										);
								}

							});
						}
						// COMPLETAR LA LISTA DE LOS PROFESIONALES DE LA SALUD ACTUALES EN LA VALORACION
						if(objectRating['rpProfessionaslhealth'].length >= 3){
							var separatedProfessionals = objectRating['rpProfessionaslhealth'].split(':');
							for (var i = 0; i < separatedProfessionals.length; i++) {
								$.get("{{ route('getProfessionalhealth') }}",{ phId: separatedProfessionals[i] },function(objectProfessionalhealth){
									if(objectProfessionalhealth != null){
										$('.navProfessionalhealthDelete').append(
												"<li class='" + objectProfessionalhealth['phId'] + "' style='font-size: 12px;'>" + objectProfessionalhealth['phName'] + "</li>"
											);
									}

								});
							}
						}else if(objectRating['rpProfessionaslhealth'].length == 1){
							$.get("{{ route('getProfessionalhealth') }}",{ phId: objectRating['rpProfessionaslhealth'] },function(objectProfessionalhealth){
								var count = Object.keys(objectProfessionalhealth).length;
								if(count > 0){
									$('.navProfessionalhealthDelete').append(
											"<li class='" + objectProfessionalhealth['phId'] + "' style='font-size: 12px;'>" + objectProfessionalhealth['phName'] + "</li>"
										);
								}

							});
						}

					}else{

					}
				});
			}
			$('#deleteRating-modal').modal();
		});

		/*================================================================================================================
			FUNCIONES JAVASCRIPT
		================================================================================================================*/

		function resetAll(){
			$('select[name=rpAcademicperiod_id]').empty();
			$('select[name=rpAcademicperiod_id]').append("<option value=''>Seleccione un periodo...</option>");
			$('.spinner-border').css('display','none');
		}

		function converterYearsoldFromBirtdate(date){
			var values = date.split("-");
		    var day = values[2];
		    var mount = values[1];
		    var year = values[0];
		    var now = new Date();
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
		    if(mountNow>mount && day > dayNow){ mounts=(mountNow-mount)-1; }
		    else if (mountNow > mount){ mounts=mountNow-mount; }
		    else if(mountNow<mount && day < dayNow){ mounts=12-(mount-mountNow); }
		    else if(mountNow<mount){ mounts=12-(mount-mountNow+1); }
		    if(mountNow==mount && day>dayNow){ mounts=11; }
			//Cálculo de dias
		    var days=0;
		    if(dayNow>day){ days=dayNow-day }
		    if(dayNow<day){ 
		    	lastDayMount = new Date(yearNow, mountNow - 1, 0);
		        days=lastDayMount.getDate()-(day-dayNow);
		    }
		    var processed = parseInt(old) + '-' + parseInt(mounts);
		    return processed;
			// days ==> Opcional para mostrar dias también
		}

		function getYearsold(yearsold){
			var len = yearsold.length;
			if(len < 5 & len > 0){
				var separated = yearsold.split('-');
				return separated[0] + ' años ' + separated[1] + ' meses';
			}else{
				return yearsold;
			}
		}
	</script>
@endsection