@extends('homeAcademic')

@section('modulesAcademic')
	<div class="row">

		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('hoursweek') }}" class="nav-link">
						<i class="fas fa-calendar-week"></i>
						<p>{{ __('Horario semanal') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('academicperiod') }}" class="nav-link">
						<i class="fas fa-calendar"></i>
						<p>{{ __('Periodos académicos') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('baseactivitys') }}" class="nav-link">
						<i class="fas fa-calendar"></i>
						<p>{{ __('Base de actividades') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('planning') }}" class="nav-link">
						<i class="fas fa-calendar-check"></i>
						<p>{{ __('Planeación cronológica') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('academicModules')
			</div>
		</div>
	</div>
@endsection