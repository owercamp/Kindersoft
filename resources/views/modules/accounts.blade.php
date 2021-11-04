@extends('financial')

@section('modulesFinancial')
	<div class="col-md-2">
		<ul class="nav bj-flex" style="min-height: 60vh; margin-top: 30px;">
			<li>
				<a href="#" id="1" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('ENERO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="2" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('FEBRERO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="3" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('MARZO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="4" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('ABRIL') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="5" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('MAYO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="6" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('JUNIO') }}</p>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-8">
		<div class="row">
			@yield('financialModules')
		</div>
	</div>
	<div class="col-md-2">
		<ul class="nav bj-flex" style="min-height: 60vh; margin-top: 30px;">
			<li>
				<a href="#" id="7" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('JULIO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="8" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('AGOSTO') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="9" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('SEPTIEMBRE') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="10" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('OCTUBRE') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="11" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('NOVIEMBRE') }}</p>
				</a>
			</li>
			<div class="dropdown-divider bj-divider"></div>
			<li>
				<a href="#" id="12" class="nav-link accountMount">
					<i class="fas fa-calendar-week"></i>
					<p>{{ __('DICIEMBRE') }}</p>
				</a>
			</li>
		</ul>
	</div>
@endsection