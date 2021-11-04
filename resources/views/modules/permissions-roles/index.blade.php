@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row justify-content-center">
			<div class="row">
				<form class="form-inline" action="{{ route('role.new') }}" method="PUT">
				  <div class="form-group mx-sm-2 mb-2">
				    <input type="text" class="form-control mx-sm-2" id="role" name="role" placeholder="NUEVO ROL" required="required">
				  </div>
				  <button type="submit" class="bj-btn-table-add">CREAR ROL</button>
				</form>
			</div>
		</div>
		<table id="tablepermissions" class="table table-striped table-bordered text-center" style="width:100%;">
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
				@foreach($rolesPermission as $rolePermission)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $rolePermission->name }}</td>
						<td><span class="badge">{{ $rolePermission->permissions_count }}</span></td>
						<td><a href="{{ route('role.edit', $rolePermission->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a></td>
						<td><a href="{{ route('role.delete', $rolePermission->id) }}" title="ELIMINAR" class="bj-btn-table-delete"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>
@endsection

@section('scripts')
	<!-- Scripts de datatables -->
	<script>
		$(document).ready(function(){
			$('#tablepermissions').DataTable();
		});
	</script>

@endsection