@extends('modules.structure')

@section('academicModules')
	<div class="col-md-12">
		<div class="row border-bottom mb-3">
			<div class="col-md-6">
				<h3>REGISTROS DE ESPACIOS DE ACTIVIDADES</h3>
				<a href="#" title="AGREGAR" class="bj-btn-table-add form-control-sm newActivitySpace-link">AGREGAR ESPACIO</a>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de espacios -->
				@if(session('SuccessSaveActivitySpace'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveActivitySpace') }}
				    </div>
				@endif
				@if(session('SecondarySaveActivitySpace'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveActivitySpace') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de espacios -->
				@if(session('PrimaryUpdateActivitySpace'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateActivitySpace') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateActivitySpace'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateActivitySpace') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de espacios -->
				@if(session('WarningDeleteActivitySpace'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteActivitySpace') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteActivitySpace'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteActivitySpace') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tableactivityspace" class="table table-hover text-center">
			<thead>
				<tr>
					<th>FILA</th>
					<th>NUMERO DE ESPACIO</th>
					<th>ESPACIO</th>
					<th>DESCRIPCION</th>
				</tr>
			</thead>
			<tbody>
				@php $row = 1; @endphp
				@foreach($activityspaces as $activityspace)
				<tr>
					<td>{{ $row++ }}</td>
					<td>{{ $activityspace->asNumber }}</td>
					<td>{{ $activityspace->asSpace }}</td>
					<td>{{ $activityspace->asDescription }}</td>
					<td>
						<a href="#" title="EDITAR" class="bj-btn-table-edit editActivitySpace-link">
							<i class="fas fa-edit"></i>
							<span hidden>{{ $activityspace->asId }}</span>
							<span hidden>{{ $activityspace->asNumber }}</span>
							<span hidden>{{ $activityspace->asSpace }}</span>
							<span hidden>{{ $activityspace->asDescription }}</span>
						</a>
						<a href="#" title="ELIMINAR" class="bj-btn-table-delete deleteActivitySpace-link">
							<i class="fas fa-trash-alt"></i>
							<span hidden>{{ $activityspace->asId }}</span>
							<span hidden>{{ $activityspace->asNumber }}</span>
							<span hidden>{{ $activityspace->asSpace }}</span>
							<span hidden>{{ $activityspace->asDescription }}</span>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="newActivitySpace-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="text-muted">NUEVO ESPACIO:</h4>
				</div>
				<div class="modal-body">
					<form id="formNewActivitySpace" action="{{ route('activitySpace.save') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<small class="text-muted">NUMERO:</small>
									<input type="number" name="asNumber" class="form-control form-control-sm" required>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<small class="text-muted">ESPACIO:</small>
									<input type="text" name="asSpace" class="form-control form-control-sm" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<small class="text-muted">DESCRIPCION:</small>
									<textarea name="asDescription" cols="30" rows="10" maxlength="600" class="form-control form-control-sm" required></textarea>
								</div>
							</div>
						</div>
						<div class="form-group text-center">
							<button type="submit" class="bj-btn-table-add form-control-sm">REGISTRAR</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editActivitySpace-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="text-muted">MODIFICACION DE ESPACIO:</h4>
				</div>
				<div class="modal-body">
					<form id="formNewActivitySpace" action="{{ route('activitySpace.update') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<small class="text-muted">NUMERO:</small>
									<input type="number" name="asNumberEdit" class="form-control form-control-sm" value="" required>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<small class="text-muted">ESPACIO:</small>
									<input type="text" name="asSpaceEdit" class="form-control form-control-sm" value="" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<small class="text-muted">DESCRIPCION:</small>
									<textarea name="asDescriptionEdit" cols="30" rows="10" maxlength="600" class="form-control form-control-sm" required></textarea>
								</div>
							</div>
						</div>
						<div class="row border-top mt-3 text-center">
							<div class="col-md-6">
								<input type="hidden" class="form-control form-control-sm" name="asIdEdit" value="" required>
								<button type="submit" class="bj-btn-table-add form-control-sm my-3">GUARDAR CAMBIOS</button>
							</div>
							<div class="col-md-6">
								<button type="button" class="bj-btn-table-delete mx-3 form-control-sm my-3" data-dismiss="modal">CANCELAR</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="deleteActivitySpace-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="text-muted">ELIMINACION DE ESPACIO:</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<small class="text-muted">NUMERO: </small>
							<span class="text-muted"><b class="asNumberDelete"></b></span><br>
							<small class="text-muted">ESPACIO: </small>
							<span class="text-muted"><b class="asSpaceDelete"></b></span><br>
							<small class="text-muted">DESCRIPCION: </small><br>
							<span class="text-muted"><b class="asDescriptionDelete"></b></span><br>
						</div>
					</div>
					<div class="row mt-3 border-top text-center">
						<form id="formDeleteActivitySpace" action="{{ route('activitySpace.delete') }}" method="POST" class="col-md-6">
							@csrf
							<input type="hidden" class="form-control form-control-sm" name="asIdDelete" value="" required>
							<button type="submit" class="bj-btn-table-add form-control-sm my-3">ELIMINAR</button>
						</form>
						<div class="col-md-6">
							<button type="button" class="bj-btn-table-delete mx-3 form-control-sm my-3" data-dismiss="modal">CANCELAR</button>
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

		$('.newActivitySpace-link').on('click',function(){
			$('#newActivitySpace-modal').modal();
		});

		$('.deleteActivitySpace-link').on('click',function(){
			$('input[name=asIdDelete]').val('');
			$('input[name=asIdDelete]').val($(this).find('span:nth-child(2)').text());
			$('.asNumberDelete').text($(this).find('span:nth-child(3)').text());
			$('.asSpaceDelete').text($(this).find('span:nth-child(4)').text());
			$('.asDescriptionDelete').text($(this).find('span:nth-child(5)').text());
			$('#deleteActivitySpace-modal').modal();
		});

		$('.editActivitySpace-link').on('click',function(){
			$('input[name=asIdEdit]').val('');
			$('input[name=asIdEdit]').val($(this).find('span:nth-child(2)').text());
			$('input[name=asNumberEdit]').val('');
			$('input[name=asNumberEdit]').val($(this).find('span:nth-child(3)').text());
			$('input[name=asSpaceEdit]').val('');
			$('input[name=asSpaceEdit]').val($(this).find('span:nth-child(4)').text());
			$('textarea[name=asDescriptionEdit]').val('');
			$('textarea[name=asDescriptionEdit]').val($(this).find('span:nth-child(5)').text());
			$('#editActivitySpace-modal').modal();
		});
		
	</script>
@endsection