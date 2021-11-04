@extends('modules.database')

@section('databases')
	<div class="col-md-12">
		<div class="row text-center border-bottom mb-4">
			<div class="col-md-4">
				<h6 class="text-muted">REGISTRAR NUEVO USUARIO</h6>
			</div>
			<div class="col-md-4">
				@if(count($errors) > 0)
					<div class="alert alert-secondary">
					@foreach($errors->all() as $error)
						<p>{{ $error }}</p>
					@endforeach
					</div>
				@endif
				@if(session('SuccessSaveUser'))
				    <div class="alert alert-success">
				        {{ session('SuccessSaveUser') }}
				    </div>
				@endif
				@if(session('SecondarySaveUser'))
				    <div class="alert alert-secondary">
				        {{ session('SecondarySaveUser') }}
				    </div>
				@endif
			</div>
			<div class="col-md-4">
				<a href="{{ route('users') }}" class="bj-btn-table-delete mb-4 form-control-sm">VOLVER</a>
			</div>
		</div>
		<form action="{{ route('user.add') }}" method="PUT">
			@csrf
			<div class="form-group">
			    <label>COLABORADOR:</label>
			    <select class="form-control form-control-sm" name="collaborator" required>
			    	<option value="">SELECCIONE EL COLABORADOR...</option>
			    	@foreach($collaborators as $collaborator)
			    		<option value="{{ $collaborator->id }}">{{ $collaborator->numberdocument . ' - ' . $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</option>
			    	@endforeach
			    </select>
			    <small class="form-text text-muted">Colaborador registrado a quien se le asignará el usuario</small>
			</div>
			<div class="form-group">
			   	<label>IDENTIFICACION:</label>
			    <input type="number" class="form-control form-control-sm" name="id" required>
			    <small class="form-text text-muted">Ingresar solo numeros</small>
			</div>
			<div class="form-group">
			    <label>NOMBRES:</label>
			    <input type="text" class="form-control form-control-sm" name="firstname" required>
			    <small class="form-text text-muted">Ingresar dato mayor o igual a 3 caracteres</small>
			</div>
			<div class="form-group">
			    <label >APELLIDOS:</label>
			    <input type="text" class="form-control form-control-sm" name="lastname" required>
			    <small class="form-text text-muted">Ingresar dato mayor o igual a 3 caracteres</small>
			</div>
			<div class="form-group">
			    <label>CONTRASEÑA:</label>
			    <input type="password" class="form-control form-control-sm" name="password" value="kindersoft2019" readonly>
			    <small class="form-text text-muted">Queda por defecto: kindersoft2019, puede ser cambiada unicamente por el usuario</small>
			</div>
			<div class="form-group">
			    <label>ROL DE PERMISOS:</label>
			    <select class="form-control form-control-sm" name="role" required>
			    	<option value="">SELECCIONE EL TIPO DE ACCESO...</option>
			    	<option value="Indefinido">Indefinido</option>
			    	@foreach($roles as $role)
			    		<option value="{{ $role->name }}">{{ $role->name }}</option>
			    	@endforeach
			    </select>
			    <small class="form-text text-muted">Tipo de acceso que le brindará al usuario</small>
			</div>
			<button type="submit" class="bj-btn-table-add form-control-sm">CREAR USUARIO</button>
		</form>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){
		});

		$('select[name=collaborator]').on('change',function(e){
			var value = e.target.value;
			if(value != ''){
				var text = $(this).find('option:selected').text();
				var separated = text.split(' ');
				if(separated.length > 5){
					$('input[name=id]').val(separated[0]);
					$('input[name=firstname]').val(separated[2] + ' ' + separated[3]);
					$('input[name=lastname]').val(separated[4]  + ' ' + separated[5]);
				}else{
					$('input[name=id]').val(separated[0]);
					$('input[name=firstname]').val(separated[2]);
					$('input[name=lastname]').val(separated[3]  + ' ' + separated[4]);
				}
			}else{
				$('input[name=id]').val('');
				$('input[name=firstname]').val('');
				$('input[name=lastname]').val('');
			}
		});
	</script>
@endsection