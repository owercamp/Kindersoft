@extends('homeLogistic')

@section('modulesLogistic')
	<div class="row">

		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('creation') }}" class="nav-link">
						<i class="fas fa-location-arrow"></i>
						<p>{{ __('Creación') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('diary') }}" class="nav-link">
						<i class="fas fa-calendar"></i>
						<p>{{ __('Agendamiento') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('follow') }}" class="nav-link">
						<i class="fas fa-podcast"></i>
						<p>{{ __('Seguimiento') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('grafic') }}" class="nav-link">
						<i class="fas fa-project-diagram"></i>
						<p>{{ __('Estadistica') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('eventsModules')
			</div>
		</div>
	</div>
@endsection