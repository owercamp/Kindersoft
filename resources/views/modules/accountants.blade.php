@extends('financial')

@section('modulesFinancial')
	<div class="col-md-2">
		<ul class="nav bj-flex" style="min-height: 60vh;">
			<li>
				<a href="{{ route('facturation.all') }}" class="nav-link">
					<i class="fas fa-credit-card"></i>
					<p>{{ __('Facturación Electronica') }}</p>
				</a>
			</li>
			<!-- <div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('facturations') }}" class="nav-link">
					<i class="fas fa-money-check-alt"></i>
					<p>{{ __('Proceso de facturacion') }}</p>
				</a>
			</li> -->
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" class="nav-link">
					<i class="fas fa-money-check-alt"></i>
					<p>{{ __('Gestión de cartera') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('entryVouchers') }}" class="nav-link">
					<i class="fas fa-file-contract"></i>
					<p>{{ __('Comprobantes de ingreso') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('egressVouchers') }}" class="nav-link">
					<i class="fas fa-file-alt"></i>
					<p>{{ __('Comprobantes de egreso') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('canceled') }}" class="nav-link">
					<i class="fas fa-file-alt"></i>
					<p>{{ __('Facturas anuladas') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('balances') }}" class="nav-link">
					<i class="fas fa-hand-holding-usd"></i>
					<p>{{ __('Conciliación de saldos') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="{{ route('statistics.financial') }}" class="nav-link">
					<i class="fas fa-chart-line"></i>
					<p>{{ __('Estadística de ventas') }}</p>
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