@extends('homeComercial')

@section('modulesComercial')
	<div class="col-md-12 bj-container-nav">
		<div class="row">
			<div class="col-md-2">
				<ul class="nav bj-flex">
					<li>
						<a href="{{ route('customer_proposal') }}" class="nav-link">
							<i class="fas fa-users"></i>
							<p>{{ __('Clientes') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('quotation') }}" class="nav-link">
							<i class="fas fa-money-check-alt"></i>
							<p>{{ __('Cotización') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('tracing') }}" class="nav-link">
							<i class="fas fa-podcast"></i>
							<p>{{ __('Seguimiento') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('files') }}" class="nav-link">
							<i class="fas fa-file"></i>
							<p>{{ __('Archivo') }}</p>
						</a>
					</li>
					<li>
						<a href="{{ route('statisticProposal') }}" class="nav-link">
							<i class="fas fa-project-diagram"></i>
							<p>{{ __('Estadística') }}</p>
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-10">
					@yield('proposalComercial')
			</div>
		</div>
	</div>
@endsection