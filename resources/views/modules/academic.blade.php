@extends('home')

@section('modules')
	<div class="row">
		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('intelligences') }}" class="nav-link">
						<i class="fas fa-brain"></i>
						<p>{{ __('Inteligencias') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('achievements') }}" class="nav-link">
						<i class="fas fa-medal"></i>
						<p>{{ __('Logros') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('grades') }}" class="nav-link">
						<i class="fas fa-star-of-life"></i>
						<p>{{ __('Grados') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('courses') }}" class="nav-link">
						<i class="fas fa-user-graduate"></i>
						<p>{{ __('Cursos') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('periods') }}" class="nav-link">
						<i class="fas fa-calendar-alt"></i>
						<p>{{ __('Periodos') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('achievementsAcademics') }}" class="nav-link">
						<i class="fas fa-medal"></i>
						<p>{{ __('Programas') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('observations') }}" class="nav-link">
						<i class="fas fa-calendar-week"></i>
						<p>{{ __('Observaciones') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			@yield('academics')
		</div>
	</div>
@endsection