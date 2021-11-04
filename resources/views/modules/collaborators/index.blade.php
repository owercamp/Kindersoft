@extends('modules.humans')

@section('humans')
		<div class="col-md-12">
			<div class="row text-center my-2">
				<div class="col-md-6">
					<!-- Mensajes de actualizacion de colaboradores -->
					@if(session('PrimaryUpdateCollaborator'))
					    <div class="alert alert-primary">
					        {{ session('PrimaryUpdateCollaborator') }}
					    </div>
					@endif
					@if(session('SecondaryUpdateCollaborator'))
					    <div class="alert alert-secondary">
					        {{ session('SecondaryUpdateCollaborator') }}
					    </div>
					@endif
					<!-- Mensajes de eliminación de colaboradores -->
					@if(session('WarningDeleteCollaborator'))
					    <div class="alert alert-warning">
					        {{ session('WarningDeleteCollaborator') }}
					    </div>
					@endif
					@if(session('SecondaryDeleteCollaborator'))
					    <div class="alert alert-secondary">
					        {{ session('SecondaryDeleteCollaborator') }}
					    </div>
					@endif
				</div>
				<div class="col-md-6">
					<a href="{{ route('collaborator.new') }}" class="bj-btn-table-add mx-5 my-2 form-control-sm">REGISTRAR COLABORADOR</a>
				</div>
			</div>
			<table id="tablecollaborators" class="table table-hover text-center">
					<thead>
						<tr>
							<th>DOCUMENTO</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>GENERO</th>
							<th>TELEFONO</th>
							<th>ACCIONES</th>
						</tr>
					</thead>
					<tbody>
						@foreach($collaborators as $collaborator)
							<tr>
								<td>{{ $collaborator->numberdocument }}</td>
								<td>{{ $collaborator->threename }} {{ $collaborator->fourname }}</td>
								<td>{{ $collaborator->firstname }}</td>
								<td class="gen">{{ $collaborator->gender }}</td>
								<td>{{ $collaborator->phoneone }}</td>
								<td><a href="{{ route('collaborator.details', $collaborator->id) }}" title="VER DETALLES" class="bj-btn-table-add"><i class="fas fa-eye"></i></a><a href="{{ route('collaborator.edit', $collaborator->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a><a href="{{ route('collaborator.delete', $collaborator->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('* Se eliminará el colaborador')"><i class="fas fa-trash-alt"></i></a></td>	
							</tr>
						@endforeach
					</tbody>
				</table>
		</div>
	
@endsection

@section('scripts')
	<script>
		$(function(){
			//var value = $('.gen')[0].innerHtml;
			//$('.gen')[0].innerHtml = genderReturn(value);
		});

		function genderReturn(value){
			switch(value){
				case 'M':
					return 'MASCULINO';
					break;
				case 'F':
					return 'FEMENINO';
					break;
				case 'I':
					return 'INDEFINIDO';
					break;
			}
		}
	</script>
@endsection