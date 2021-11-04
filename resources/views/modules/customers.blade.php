@extends('homeComercial')

@section('modulesComercial')
	<div class="col-md-12 bj-container-nav">
		<div class="row">
			<div class="col-md-2">
				<ul class="nav bj-flex">
					<li>
						<a href="{{ route('customers') }}" class="nav-link">
							<i class="fas fa-calendar-day"></i>
							<p>{{ __('Registro') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('newAgenda') }}" class="nav-link">
							<i class="fas fa-calendar-day"></i>
							<p>{{ __('Agendamiento') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('programming') }}" class="nav-link">
							<i class="fas fa-calendar-alt"></i>
							<p>{{ __('Programación') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('statisticSchedulings') }}" class="nav-link">
							<i class="fas fa-project-diagram"></i>
							<p>{{ __('Estadística') }}</p>
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-10">
					@yield('customersComercial')
			</div>
		</div>
	</div>
@endsection