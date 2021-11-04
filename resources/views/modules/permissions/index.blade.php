@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row justify-content-center">
			<form class="form-inline" action="{{ route('role.new') }}" method="PUT">
			  <div class="form-group mx-sm-4 mb-2">
			    <input type="text" class="form-control mx-sm-4" id="name" name="name" placeholder="NUEVO PERMISO" required="required">
			  </div>
			  <button type="submit" class="bj-btn-table-add">CREAR</button>
			</form>
		</div>
		<table id="tableroles" class="table table-striped table-bordered text-center" style="width:100%;">
			<thead>
				<tr>
					<th>#</th>
					<th>ROLES</th>
					<th>PERMISOS</th>
					<th colspan="2">ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1 @endphp
				@foreach($roles as $role)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $role->name }}</td>
						<td>{{ $role->name }}</td>
						<td><a href="{{ route('role.edit', $role->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a></td>
						<td><a href="{{ route('role.delete', $role->id) }}" title="ELIMINAR" class="bj-btn-table-delete"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
@endsection