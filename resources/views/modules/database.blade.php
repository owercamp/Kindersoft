@extends('home')

@section('modules')
	<div class="col-md-12 bj-container-nav">
		<div class="row">
			<div class="col-md-2">
				<ul class="nav bj-flex">
					<li>
						<a href="{{ route('citys') }}" class="nav-link">
							<i class="fas fa-city"></i>
							<p>{{ __('Ciudades') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('locations') }}" class="nav-link">
							<i class="fas fa-building"></i>
							<p>{{ __('Localidades') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('districts') }}" class="nav-link">
							<i class="fas fa-building"></i>
							<p>{{ __('Barrios') }}</p>
						</a>
					</li>
					<div class="dropdown-divider bj-divider"></div>
					<li>
						<a href="{{ route('documents') }}" class="nav-link">
							<i class="fas fa-id-card"></i>
							<p>{{ __('Documentos') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('bloodtypes') }}" class="nav-link">
							<i class="fas fa-tint"></i>
							<p>{{ __('Grupos sanguineos') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('professions') }}" class="nav-link">
							<i class="fas fa-business-time"></i>
							<p>{{ __('Profesiones') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('healths') }}" class="nav-link">
							<i class="fas fa-hospital"></i>
							<p>{{ __('Centros de salud') }}</p>
						</a>
					</li>
					<div class="dropdown-divider bj-divider"></div>
					@hasanyrole('ADMINISTRADOR|ADMINISTRADOR SISTEMA')
					<li>
						<a href="{{ route('users') }}" class="nav-link">
							<i class="fas fa-user-lock"></i>
							<p>{{ __('Usuarios') }}</p>
						</a>
					</li>
					@endhasanyrole
					<!--<li>
						<a href="{{ route('roles') }}" class="nav-link">
							<i class="fas fa-dungeon"></i>
							<p>{{ __('Roles y Permisos') }}</p>
						</a>
					</li>-->
				</ul>
			</div>
			<div class="col-md-10">
					@yield('databases')
			</div>
		</div>
	</div>
@endsection