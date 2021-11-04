@extends('homeComercial')

@section('modulesComercial')
	<div class="row">

		<div class="col-md-2">
			<ul class="nav bj-flex" style="min-height: 60vh;">
				<li>
					<a href="{{ route('documentsEnrollment') }}" class="nav-link">
						<i class="fas fa-clipboard-list"></i>
						<p>{{ __('Creación de documentos') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('consolidatedEnrollment') }}" class="nav-link">
						<i class="fas fa-file-alt"></i>
						<p>{{ __('Orden de matrícula') }}</p>
					</a>
				</li>
				<li>
					<a href="{{ route('legalizationEnrollment') }}" class="nav-link">
						<i class="fas fa-folder-open"></i>
						<p>{{ __('Legalización de matrícula') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('contracts') }}" class="nav-link">
						<i class="fas fa-file-contract"></i>
						<p>{{ __('Generación de contrato') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('certificates') }}" class="nav-link">
						<i class="fas fa-file-invoice"></i>
						<p>{{ __('Generación de certificaciones') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div>
				<li>
					<a href="{{ route('legalizationsfinished') }}" class="nav-link">
						<i class="fas fa-box-open"></i>
						<p>{{ __('Archivo de contratos') }}</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			<div class="row">
				@yield('enrollmentsComercial')
			</div>
		</div>
	</div>


@endsection