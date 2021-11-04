@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<form action="{{ route('document.new') }}" method="PUT">
					@csrf
					<div class="row">
						<div class="col-md-8">
							<input type="text" class="form-control form-control-sm" name="type" placeholder="Nuevo documento" required>
						</div>
						<div class="col-md-4">
							<button type="submit" class="bj-btn-table-add form-control-sm">CREAR</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de creación de documentos -->
				@if(session('SuccessSaveDocument'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveDocument') }}
				    </div>
				@endif
				@if(session('SecondarySaveDocument'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveDocument') }}
				    </div>
				@endif
				<!-- Mensajes de actualizacion de documentos -->
				@if(session('PrimaryUpdateDocument'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateDocument') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateDocument'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateDocument') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de documentos -->
				@if(session('WarningDeleteDocument'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteDocument') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteDocument'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteDocument') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tabledocuments" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>TIPO DE DOCUMENTO</th>
					<th colspan="2">ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($documents as $document)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $document->type }}</td>
						<td><a href="{{ route('document.edit', $document->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a></td>
						<td><a href="{{ route('document.delete', $document->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('- Se borrará el tipo de documento')"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
@endsection