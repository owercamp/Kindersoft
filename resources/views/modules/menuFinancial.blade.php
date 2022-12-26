@extends('financial')

@section('modulesFinancial')
<div class="col-md-2">
  <ul class="nav bj-flex" style="min-height: 60vh;">
    <li>
      <a href="{{ route('companyInfo') }}" class="nav-link">
        <i class="fas fa-credit-card"></i>
        <p>{{ __('Información General') }}</p>
      </a>
    </li>
    <div class="dropdown-divider bj-divider"></div>
    <li>
      <a href="{{ route('general') }}" class="nav-link">
        <i class="fas fa-money-check-alt"></i>
        <p>{{ __('Información Tributaria') }}</p>
      </a>
    </li>
    <div class="dropdown-divider bj-divider"></div>
    <li>
      <a href="{{ route('companylogo') }}" class="nav-link">
        <i class="fas fa-file-contract"></i>
        <p>{{ __('Imagenes Corporativas') }}</p>
      </a>
    </li>
    <div class="dropdown-divider bj-divider"></div>
    <li>
      <a href="{{ route('egressVouchers') }}" class="nav-link">
        <i class="fas fa-file-alt"></i>
        <p>{{ __('Documentos Corporativos') }}</p>
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