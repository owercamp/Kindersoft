@extends('homeAcademic')

@section('modulesAcademic')
	<div class="row">
		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('weeklyTracking') }}" class="nav-link">
						<i class="fas fa-calendar"></i>
						<p>{{ __('Seguimiento semanal') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('periodClosing') }}" class="nav-link">
						<i class="fas fa-calendar-check"></i>
						<p>{{ __('Cierre periodo académico') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('newsletters') }}" class="nav-link">
						<i class="fas fa-file"></i>
						<p>{{ __('Informe de periodo') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('bulletins') }}" class="nav-link">
						<i class="fas fa-newspaper"></i>
						<p>{{ __('Boletines escolares') }}</p>
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