@extends('modules.analysis')

@section('financialModules')
	<div class="col-md-12">
		<div class="row mt-5">
			<div class="col-md-4">
				<h4>PRESUPUESTO ANUAL</h4>
				@php
					$yearnow = date('Y');
					$mountnow = date('m');
					$yearbeforeThree = date('Y') - 3;
					$yearbeforeTwo = date('Y') - 2;
					$yearbeforeOne = date('Y') - 1;
					$yearfutureOne = date('Y') + 1;
					$yearfutureTwo = date('Y') + 2;
					$yearfutureThree = date('Y') + 3;
					$yearfutureFour = date('Y') + 4;
				@endphp
			</div>
			<div class="col-md-4">
				<!-- Mensajes de creación de presupuesto anual -->
				@if(session('SuccessCreateBudget'))
				    <div class="alert alert-success">
				        {{ session('SuccessCreateBudget') }}
				    </div>
				@endif
				@if(session('SecondaryCreateBudget'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryCreateBudget') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de presupuesto anual -->
				@if(session('PrimaryUpdateBudget'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateBudget') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateBudget'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateBudget') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de presupuesto anual -->
				@if(session('WarningDeleteBudget'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteBudget') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteBudget'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteBudget') }}
				    </div>
				@endif
			</div>
			<div class="col-md-4">
				<button type="button" class="bj-btn-table-add form-control-sm newBudget-link">NUEVO PRESUPUESTO</button>
			</div>
		</div>
		<table id="tableDatatable" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>ITEM</th>
					<th>AÑO</th>
					<th>ESTRUCTURA</th>
					<th>DESCRIPCION</th>
					<th>VALOR TOTAL</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $row = 1; @endphp
				@foreach($annuals as $annual)
					<tr>
						<td>{{ $row }}</td>
						<td>{{ $annual->aYear }}</td>
						<td>{{ $annual->csDescription }}</td>
						<td>{{ $annual->cdDescription }}</td>
						<td>{{ $annual->aValue }}</td>
						<td>
							<button type="button" class="bj-btn-table-edit form-control-sm editBudget-link" title="EDITAR">
								<i class="fas fa-edit"></i>
								<span hidden>{{ $annual->aId }}</span> <!-- Id del presupuesto -->
								<span hidden>{{ $annual->aDate }}</span> <!-- Fecha -->
								<span hidden>{{ $annual->csId }}</span> <!-- Id de estructura -->
								<span hidden>{{ $annual->csDescription }}</span> <!-- Estructura de costo -->
								<span hidden>{{ $annual->cdId }}</span> <!-- Id de descripcion -->
								<span hidden>{{ $annual->cdDescription }}</span> <!-- Descripcion de costo -->
								<span hidden>{{ $annual->aValue }}</span> <!-- Valor total -->
								<span hidden>{{ $annual->aDetailsMount }}</span> <!-- Detalles de valores mensuales -->
								<span hidden>{{ $annual->aYear }}</span> <!-- Año del presupuesto -->
							</button>
							<button type="button" class="bj-btn-table-delete form-control-sm deleteBudget-link" title="ELIMINAR">
								<i class="fas fa-trash-alt"></i>
								<span hidden>{{ $annual->aId }}</span> <!-- Id del presupuesto -->
								<span hidden>{{ $annual->aDate }}</span> <!-- Fecha -->
								<span hidden>{{ $annual->csId }}</span> <!-- Id de estructura -->
								<span hidden>{{ $annual->csDescription }}</span> <!-- Estructura de costo -->
								<span hidden>{{ $annual->cdId }}</span> <!-- Id de descripcion -->
								<span hidden>{{ $annual->cdDescription }}</span> <!-- Descripcion de costo -->
								<span hidden>{{ $annual->aValue }}</span> <!-- Valor total -->
								<span hidden>{{ $annual->aDetailsMount }}</span> <!-- Detalles de valores mensuales -->
								<span hidden>{{ $annual->aYear }}</span> <!-- Año del presupuesto -->
							</button>
						</td>
					</tr>
					@php $row++; @endphp
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="newBudget-modal">
		<div class="modal-dialog modal-lg"> <!-- modal-lg -->
			<div class="modal-content">
				<div class="modal-header">
					<h5>NUEVO PRESUPUESTO ANUAL</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-3">
					<form action="{{ route('budget.save') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<div class="form-group">
									<small class="text-muted">AÑO:</small>
									<select name="aYear_new" class="form-control form-control-sm" required>
										<option value="">Seleccione un año...</option>
										<option value="{{ $yearbeforeThree }}">{{ $yearbeforeThree }}</option>
										<option value="{{ $yearbeforeTwo }}">{{ $yearbeforeTwo }}</option>
										<option value="{{ $yearbeforeOne }}">{{ $yearbeforeOne }}</option>
										<option value="{{ $yearnow }}" selected>{{ $yearnow }}</option>
										<option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
										<option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
										<option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
										<option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
									</select>
								</div>
							</div>
							<div class="col-md-4"></div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">ESTRUCTURA DE COSTO:</small>
									<select name="aCoststructure_new" class="form-control form-control-sm" required>
										<option value="">Seleccione una estructura de costo...</option>
										@foreach($structures as $structure)
											<option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">DESCRIPCION DE COSTO:</small>
									<select name="aCostdescription_new" class="form-control form-control-sm" required>
										<option value="">Seleccione una descripción de costo...</option>
										<!-- rows dinamics -->
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<table class="table_New" width="100%">
									<thead>
										<tr>
											<th>MES</th>
											<th>PRESUPUESTO</th>
										</tr>
									</thead>
									<tbody>
										<tr><td>ENERO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="january_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>FEBRERO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="february_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>MARZO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="march_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>ABRIL</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="april_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>MAYO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="may_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>JUNIO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="june_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>JULIO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="july_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>AGOSTO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="august_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>SEPTIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="september_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>OCTUBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="october_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>NOVIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="november_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>DICIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="december_new" class="form-control form-control-sm valueMount_new" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2" class="text-center">
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="text" name="aValue_new" class="form-control form-control-sm text-center" value="0" required readonly>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="form-group text-center">
									<button type="submit" class="bj-btn-table-add form-control-sm btn-saveAnnual">GUARDAR PRESUPUESTO</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editBudget-modal">
		<div class="modal-dialog modal-lg"> <!-- modal-lg -->
			<div class="modal-content">
				<div class="modal-header">
					<h5>MODIFICACIONES EN PRESUPUESTO ANUAL</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-3">
					<form action="{{ route('budget.update') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<div class="form-group">
									<small class="text-muted">AÑO:</small>
									<select name="aYear_edit" class="form-control form-control-sm" required>
										<option value="">Seleccione un año...</option>
										<option value="{{ $yearbeforeThree }}">{{ $yearbeforeThree }}</option>
										<option value="{{ $yearbeforeTwo }}">{{ $yearbeforeTwo }}</option>
										<option value="{{ $yearbeforeOne }}">{{ $yearbeforeOne }}</option>
										<option value="{{ $yearnow }}">{{ $yearnow }}</option>
										<option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
										<option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
										<option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
										<option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
									</select>
								</div>
							</div>
							<div class="col-md-4"></div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">ESTRUCTURA DE COSTO:</small>
									<select name="aCoststructure_edit" class="form-control form-control-sm" required>
										<option value="">Seleccione una estructura de costo...</option>
										@foreach($structures as $structure)
											<option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<small class="text-muted">DESCRIPCION DE COSTO:</small>
									<select name="aCostdescription_edit" class="form-control form-control-sm" required>
										<option value="">Seleccione una descripción de costo...</option>
										<!-- rows dinamics -->
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<table class="table_Edit" width="100%">
									<thead>
										<tr>
											<th>MES</th>
											<th>PRESUPUESTO</th>
										</tr>
									</thead>
									<tbody>
										<tr><td>ENERO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="january_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>FEBRERO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="february_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>MARZO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="march_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>ABRIL</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="april_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>MAYO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="may_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>JUNIO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="june_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>JULIO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="july_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>AGOSTO</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="august_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>SEPTIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="september_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>OCTUBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="october_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>NOVIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="november_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr><td>DICIEMBRE</td>
											<td>
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="number" name="december_edit" class="form-control form-control-sm valueMount_edit" title="Ingrese el valor del presupuesto sin puntos ni comas" required>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2" class="text-center">
												<div class="input-group">
													<div class="input-group-prepend">
													    <span class="input-group-text">
													    	<i class="fas fa-dollar-sign"></i>
													    </span>
													</div>
													<input type="text" name="aValue_edit" class="form-control form-control-sm text-center" value="0" required readonly>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<div class="form-group text-right">
									<input type="hidden" name="aId_edit" class="form-control form-control-sm" readonly required>
									<button type="submit" class="bj-btn-table-add form-control-sm btn-updateAnnual">GUARDAR CAMBIOS DE PRESUPUESTO</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="deleteBudget-modal">
		<div class="modal-dialog modal-lg"> <!-- modal-lg -->
			<div class="modal-content">
				<div class="modal-header">
					<h5>ELIMINACION DE PRESUPUESTO ANUAL</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-3">
						<div class="row p-3 border">
							<div class="col-md-6 border-right">
								<small class="text-muted">AÑO DE PRESUPUESTO:</small>
								<h6 class="aYear_details"></h6>
								<hr>
								<small class="text-muted">ESTRUCTURA DE COSTO:</small>
								<h6 class="aCoststructure_details"></h6>
								<hr>
								<small class="text-muted">DESCRIPCION DE COSTO:</small>
								<h6 class="aCostdescription_details"></h6>
								<hr>
								<small class="text-muted">TOTAL:</small>
								<h6 class="aValue_details"></h6>
							</div>
							<div class="col-md-6 border-left d-flex align-items-center">
								<ul style="font-size: 12px;">
									<li class="january_details"></li>
									<li class="february_details"></li>
									<li class="march_details"></li>
									<li class="april_details"></li>
									<li class="may_details"></li>
									<li class="june_details"></li>
									<li class="july_details"></li>
									<li class="august_details"></li>
									<li class="september_details"></li>
									<li class="october_details"></li>
									<li class="november_details"></li>
									<li class="december_details"></li>
								</ul>
							</div>
						</div>
						<div class="row border-top p-3">
							<div class="col-md-12 text-center">
								<form action="{{ route('budget.delete') }}" method="POST">
									@csrf
									<input type="hidden" name="aId_delete" class="form-control form-control-sm" readonly required>
									<button type="submit" class="bj-btn-table-add form-control-sm btn-updateAnnual">ELIMINAR PRESUPUESTO</button>
								</form>
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

		/*=========================================================
			EVENTOS PARA REGISTRAR PRESUPUESTOS
		=========================================================*/
		$('.newBudget-link').on('click',function(){
			$('#newBudget-modal').modal();
		});

		$('select[name=aCoststructure_new]').on('change',function(e){
			var selected = e.target.value;
			if(selected != ''){
				$.get("{{ route('getCostdescriptions') }}",{ idCoststructure: selected },function(objectCostdescriptions){
					var count = Object.keys(objectCostdescriptions).length;
					$('select[name=aCostdescription_new]').empty();
					$('select[name=aCostdescription_new]').append("<option value=''>Seleccione una descripción  de costo...</option>");
					if(count > 0){
						for (var i = 0; i < count; i++) {
							$('select[name=aCostdescription_new]').append(
								"<option value='" + objectCostdescriptions[i]['cdId'] + "'>" +
									objectCostdescriptions[i]['cdDescription'] +
								"</option>"
							);
						}
					}
				});
			}else{
				$('select[name=aCostdescription_new]').empty();
				$('select[name=aCostdescription_new]').append("<option value=''>Seleccione una descripción  de costo...</option>");
			}
		});

		$('.valueMount_new').on('keyup',function(){
			var total = 0;
			$('.table_New .valueMount_new').each(function(){
				if(parseInt($(this).val()) > 0){
					total += parseInt($(this).val());
				}
			});
			$('input[name=aValue_new]').val(total);
		});

		$('.btn-saveAnnual').on('click',function(){
			// e.preventDefault();
			var total = parseInt($('input[name=aValue_new]').val());
			if(total > 0){
				$(this).submit();
			}
		});

		/*=========================================================
			EVENTOS PARA MODIFICAR PRESUPUESTOS
		=========================================================*/

		$('.editBudget-link').on('click',function(){
			var aId = $(this).find('span:nth-child(2)').text();
			var aDate = $(this).find('span:nth-child(3)').text();
			var idStructure = $(this).find('span:nth-child(4)').text();
			var costStructure = $(this).find('span:nth-child(5)').text();
			var idDescription = $(this).find('span:nth-child(6)').text();
			var costDescription = $(this).find('span:nth-child(7)').text();
			var aValue = $(this).find('span:nth-child(8)').text();
			var aDetails = $(this).find('span:nth-child(9)').text();
			var aYear = $(this).find('span:nth-child(10)').text();
			
			// ID DEl PRESUPUESTO SELECCIONADO
			$('input[name=aId_edit]').val(aId);

			// AÑO DEL PRESUPUESTO
			$('select[name=aYear_edit]').val(aYear);

			// SELECCIONAR LA ESTRUCTURA CORRESPONDIENTE
			$('select[name=aCoststructure_edit]').val(idStructure);

			// COMPLETAR LA DESCRIPCION DE COSTO Y SELECCIONARSE EL CORRESPONDIENTE
			$.get("{{ route('getCostdescriptions') }}",{ idCoststructure: idStructure },function(objectCostdescriptions){
				var count = Object.keys(objectCostdescriptions).length;
				$('select[name=aCostdescription_edit]').empty();
				$('select[name=aCostdescription_edit]').append("<option value=''>Seleccione una descripción  de costo...</option>");
				if(count > 0){
					for (var i = 0; i < count; i++) {
						if(objectCostdescriptions[i]['cdId'] == idDescription){
							$('select[name=aCostdescription_edit]').append(
								"<option value='" + objectCostdescriptions[i]['cdId'] + "' selected>" +
									objectCostdescriptions[i]['cdDescription'] +
								"</option>"
							);
						}else{
							$('select[name=aCostdescription_edit]').append(
								"<option value='" + objectCostdescriptions[i]['cdId'] + "'>" +
									objectCostdescriptions[i]['cdDescription'] +
								"</option>"
							);
						}
					}
				}
			});

			// DETALLES DE VALORES POR MES
			var separatedDetails = aDetails.split('-');
			for (var i = 0; i < separatedDetails.length; i++) {
				var separatedValues = separatedDetails[i].split(':');
				if(i == 0){ $('input[name=january_edit]').val(separatedValues[1]);}
				else if(i == 1){ $('input[name=february_edit]').val(separatedValues[1]);}
				else if(i == 2){ $('input[name=march_edit]').val(separatedValues[1]);}
				else if(i == 3){ $('input[name=april_edit]').val(separatedValues[1]);}
				else if(i == 4){ $('input[name=may_edit]').val(separatedValues[1]);}
				else if(i == 5){ $('input[name=june_edit]').val(separatedValues[1]);}
				else if(i == 6){ $('input[name=july_edit]').val(separatedValues[1]);}
				else if(i == 7){ $('input[name=august_edit]').val(separatedValues[1]);}
				else if(i == 8){ $('input[name=september_edit]').val(separatedValues[1]);}
				else if(i == 9){ $('input[name=october_edit]').val(separatedValues[1]);}
				else if(i == 10){ $('input[name=november_edit]').val(separatedValues[1]);}
				else if(i == 11){ $('input[name=december_edit]').val(separatedValues[1]);}
			}

			$('input[name=aValue_edit]').val(aValue);

			$('#editBudget-modal').modal();
		});

		$('select[name=aCoststructure_edit]').on('change',function(e){
			var selected = e.target.value;
			if(selected != ''){
				$.get("{{ route('getCostdescriptions') }}",{ idCoststructure: selected },function(objectCostdescriptions){
					var count = Object.keys(objectCostdescriptions).length;
					$('select[name=aCostdescription_edit]').empty();
					$('select[name=aCostdescription_edit]').append("<option value=''>Seleccione una descripción  de costo...</option>");
					if(count > 0){
						for (var i = 0; i < count; i++) {
							$('select[name=aCostdescription_edit]').append(
								"<option value='" + objectCostdescriptions[i]['cdId'] + "'>" +
									objectCostdescriptions[i]['cdDescription'] +
								"</option>"
							);
						}
					}
				});
			}else{
				$('select[name=aCostdescription_edit]').empty();
				$('select[name=aCostdescription_edit]').append("<option value=''>Seleccione una descripción  de costo...</option>");
			}
		});

		$('.valueMount_edit').on('keyup',function(){
			var total = 0;
			$('.table_Edit .valueMount_edit').each(function(){
				if(parseInt($(this).val()) > 0){
					total += parseInt($(this).val());
				}
			});
			$('input[name=aValue_edit]').val(total);
		});

		$('.btn-updateAnnual').on('click',function(){
			// e.preventDefault();
			var total = parseInt($('input[name=aValue_edit]').val());
			if(total > 0){
				$(this).submit();
			}
		});

		/*=========================================================
			EVENTOS PARA ELIMINAR PRESUPUESTOS
		=========================================================*/

		$('.deleteBudget-link').on('click',function(){
			var aId = $(this).find('span:nth-child(2)').text();
			var aDate = $(this).find('span:nth-child(3)').text();
			var idStructure = $(this).find('span:nth-child(4)').text();
			var costStructure = $(this).find('span:nth-child(5)').text();
			var idDescription = $(this).find('span:nth-child(6)').text();
			var costDescription = $(this).find('span:nth-child(7)').text();
			var aValue = $(this).find('span:nth-child(8)').text();
			var aDetails = $(this).find('span:nth-child(9)').text();
			var aYear = $(this).find('span:nth-child(10)').text();
			
			// ID DEl PRESUPUESTO SELECCIONADO
			$('input[name=aId_delete]').val(aId);

			// AÑO DEL PRESUPUESTO
			$('.aYear_details').text(aYear);

			// SELECCIONAR LA ESTRUCTURA CORRESPONDIENTE
			$('.aCoststructure_details').text(costStructure);
			$('.aCostdescription_details').text(costDescription);

			// DETALLES DE VALORES POR MES
			var separatedDetails = aDetails.split('-');
			for (var i = 0; i < separatedDetails.length; i++) {
				var separatedValues = separatedDetails[i].split(':');
				if(i == 0){ $('.january_details').text('ENERO: ' + separatedValues[1]);}
				else if(i == 1){ $('.february_details').text('FEBRERO: ' + separatedValues[1]);}
				else if(i == 2){ $('.march_details').text('MARZO: ' + separatedValues[1]);}
				else if(i == 3){ $('.april_details').text('ABRIL: ' + separatedValues[1]);}
				else if(i == 4){ $('.may_details').text('MAYO: ' + separatedValues[1]);}
				else if(i == 5){ $('.june_details').text('JUNIO: ' + separatedValues[1]);}
				else if(i == 6){ $('.july_details').text('JULIO: ' + separatedValues[1]);}
				else if(i == 7){ $('.august_details').text('AGOSTO: ' + separatedValues[1]);}
				else if(i == 8){ $('.september_details').text('SEPTIEMBRE: ' + separatedValues[1]);}
				else if(i == 9){ $('.october_details').text('OCTUBRE: ' + separatedValues[1]);}
				else if(i == 10){ $('.november_details').text('NOVIEMBRE: ' + separatedValues[1]);}
				else if(i == 11){ $('.december_details').text('DICIEMBRE: ' + separatedValues[1]);}
			}

			// VALOR TOTAL
			$('.aValue_details').text(aValue);

			$('#deleteBudget-modal').modal();
		});
	</script>
@endsection