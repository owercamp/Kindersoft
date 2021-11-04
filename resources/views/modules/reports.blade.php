@extends('homeLogistic')

@section('modulesLogistic')
	<div class="row">
		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('enrollments.list') }}" class="nav-link">
						<i class="fas fa-book-open"></i>
						<p>{{ __('Listado de matriculados') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('setting.reports') }}" class="nav-link">
						<i class="fas fa-server"></i>
						<p>{{ __('Configuración de informes') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('setting.reports.attendant') }}" class="nav-link">
						<i class="fas fa-list-ul"></i>
						<p>{{ __('Informes de acudientes') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('statistic.assitances') }}" class="nav-link">
						<i class="fas fa-network-wired"></i>
						<p>{{ __('Estadísticas de asistencia') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('statistic.increase') }}" class="nav-link">
						<i class="fas fa-laugh"></i>
						<p>{{ __('Estadísticas de crecimiento y desarrollo') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('license.collaborator') }}" class="nav-link">
						<i class="fas fa-id-card"></i>
						<p>{{ __('Carnetización colaboradores') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('license.student') }}" class="nav-link">
						<i class="fas fa-id-card-alt"></i>
						<p>{{ __('Carnetización alumnos') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('logisticModules')
			</div>
		</div>
	</div>
@endsection

