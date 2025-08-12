@extends('homeLogistic')

@section('modulesLogistic')
	<div class="row">
		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('professionalHealth') }}" class="nav-link">
						<i class="fas fa-user"></i>
						<p>{{ __('Profesional de la salud') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('observationsHealth') }}" class="nav-link">
						<i class="fas fa-notes-medical"></i>
						<p>{{ __('Observaciones de salud') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('vaccination') }}" class="nav-link">
						<i class="fas fa-utensils"></i>
						<p>{{ __('Esquemas de vacunación') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('ratinPeriod') }}" class="nav-link">
						<i class="fas fa-child"></i>
						<p>{{ __('Valoraciones periodicas') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('increase.statistic') }}" class="nav-link">
						<i class="fas fa-project-diagram"></i>
						<p>{{ __('Estadistica') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('logisticModules')
			</div>
		</div>
	</div>
@endsection