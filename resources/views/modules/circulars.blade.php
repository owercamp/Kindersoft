@extends('homeLogistic')

@section('modulesLogistic')
<div class="row">

	<div class="col-md-2">
		<ul class="nav bj-flex" style="min-height: 60vh;">
			<li>
				<a href="{{ route('bodycircular') }}" class="nav-link">
					<i class="fas fa-envelope-open-text"></i>
					<p>{{ __('Creación de cuerpos') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularacademic') }}" class="nav-link">
					<i class="fas fa-credit-card"></i>
					<p>{{ __('Circular académica') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularadministrative') }}" class="nav-link">
					<i class="fas fa-money-check"></i>
					<p>{{ __('Circular administrativa') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularmemo') }}" class="nav-link">
					<i class="fas fa-receipt"></i>
					<p>{{ __('Memorando interno') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularacademic.list') }}" class="nav-link">
					<i class="fas fa-folder-plus"></i>
					<p>{{ __('Archivo circular académica') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularadministrative.list') }}" class="nav-link">
					<i class="fas fa-folder-open"></i>
					<p>{{ __('Archivo circular administrativa') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('circularmemo.list') }}" class="nav-link">
					<i class="fas fa-file-archive"></i>
					<p>{{ __('Archivo comunicado interno') }}</p>
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