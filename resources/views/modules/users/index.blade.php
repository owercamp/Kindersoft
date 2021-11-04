@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-6">
				<a href="{{ route('user.new') }}" class="bj-btn-table-add form-control-sm">CREAR USUARIO</a>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de actualizacion de usuarios -->
				@if(session('PrimaryUpdateUser'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateUser') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateUser'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateUser') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de usuarios -->
				@if(session('WarningDeleteUser'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteUser') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteUser'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteUser') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tableusers" class="table table-hover text-center" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>IDENTIFICACION</th>
					<th>NOMBRE</th>
					<th>APELLIDOS</th>
					<th>ROL</th>
					<th colspan="2">ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($users as $user)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $user->id }}</td>
						<td>{{ $user->firstname }}</td>
						<td>{{ $user->lastname }}</td>
						@if($user->roles->implode('name',',') !== '')
							<td>{{ $user->roles->implode('name',',') }}</td>
						@else
							<td>{{ __('Indefinido') }}</td>
						@endif
						<td><a href="{{ route('user.edit', $user->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a></td>
						<td><a href="{{ route('user.delete', $user->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('Se eliminará el usuario y ya no tendrá acceso al sistema')"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
@endsection
