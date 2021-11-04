@extends('home')

@section('modules')
	<div class="row">

		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('admissions') }}" class="nav-link">
						<i class="fas fa-door-open"></i>
						<p>{{ __('Admisiones') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('journeys') }}" class="nav-link">
						<i class="fas fa-clock"></i>
						<p>{{ __('Jornadas') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('feedings') }}" class="nav-link">
						<i class="fas fa-utensils"></i>
						<p>{{ __('Alimentación') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('uniforms') }}" class="nav-link">
						<i class="fas fa-tshirt"></i>
						<p>{{ __('Uniformes') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('supplies') }}" class="nav-link">
						<i class="fas fa-drafting-compass"></i>
						<p>{{ __('Material escolar') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('extratimes') }}" class="nav-link">
						<i class="fas fa-user-clock"></i>
						<p>{{ __('Tiempo adicional') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('extracurriculars') }}" class="nav-link">
						<i class="fas fa-chalkboard-teacher"></i>
						<p>{{ __('Extracurriculares') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('transports') }}" class="nav-link">
						<i class="fas fa-bus-alt"></i>
						<p>{{ __('Transporte') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			@yield('services')
		</div>
	</div>


@endsection