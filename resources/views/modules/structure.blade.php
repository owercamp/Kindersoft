@extends('homeAcademic')

@section('modulesAcademic')
	<div class="row">

		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('gradeCourse') }}" class="nav-link">
						<i class="fas fa-brain"></i>
						<p>{{ __('Grados y cursos') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('activitySpace') }}" class="nav-link">
						<i class="fas fa-th-large"></i>
						<p>{{ __('Espacios de actividades') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('activityClass') }}" class="nav-link">
						<i class="fas fa-radiation-alt"></i>
						<p>{{ __('Clases y actividades') }}</p>
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