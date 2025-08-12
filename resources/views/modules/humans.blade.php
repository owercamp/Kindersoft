@extends('home')

@section('modules')
	<div class="row">
		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('collaborators') }}" class="nav-link">
						<i class="fas fa-users-cog"></i>
						<p>{{ __('Colaboradores') }}</p>
					</a>
				</li>
				<!-- @ can('ADMIN-COM') --> <!-- ¿Tiene rol ADMIN-SYSTEM? -->
				<li>
					<a href="{{ route('attendants') }}" class="nav-link">
						<i class="fas fa-users"></i>
						<p>{{ __('Acudientes') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('students') }}" class="nav-link">
						<i class="fas fa-user-graduate"></i>
						<p>{{ __('Alumnos') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('providers') }}" class="nav-link">
						<i class="fas fa-boxes"></i>
						<p>{{ __('Proveedores') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('authorized') }}" class="nav-link">
						<i class="fas fa-boxes"></i>
						<p>{{ __('Autorizados') }}</p>
					</a>
				</li>
				<!-- @ endcan -->
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('humans')
			</div>
		</div>
	</div>
@endsection
