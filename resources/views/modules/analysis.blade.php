@extends('financial')

@section('modulesFinancial')
	<div class="col-md-2">
		<ul class="nav bj-flex" style="min-height: 60vh; margin-top: 30px;">
			<li>
				<a href="{{ route('analysis.structure') }}" class="nav-link">
					<i class="fas fa-credit-card"></i>
					<p>{{ __('Estructura de costos') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('analysis.description') }}" class="nav-link">
					<i class="fas fa-money-check"></i>
					<p>{{ __('Descripción de costos') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('analysis.budget') }}" class="nav-link">
					<i class="fas fa-receipt"></i>
					<p>{{ __('Presupuesto anual') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('analysis.follow') }}" class="nav-link">
					<i class="fas fa-money-check"></i>
					<p>{{ __('Seguimiento mensual') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('analysis.report') }}" class="nav-link">
					<i class="fas fa-receipt"></i>
					<p>{{ __('Informe de cierre') }}</p>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-10">
		<div class="row">
			@yield('financialModules')
		</div>
	</div>
@endsection