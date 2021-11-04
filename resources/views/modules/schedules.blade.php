@extends('homeShedule')

@section('modulesSchedule')
<div class="row">
  <div class="col-md-2">
    <ul class="nav bj-flex" style="min-height: 60vh;">
      <li>
        <a href="{{ route('greetingTemplate') }}" class="nav-link">
          <i class="fas fa-book-open"></i>
          <p>{{ __('Plantilla de saludo') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('contextTemplate') }}" class="nav-link">
          <i class="fas fa-server"></i>
          <p>{{ __('Plantilla de contexto') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('dailyInformation') }}" class="nav-link">
          <i class="fas fa-list-ul"></i>
          <p>{{ __('Información diaria') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('scheduleFile') }}" class="nav-link">
          <i class="fas fa-network-wired"></i>
          <p>{{ __('Archivo de agenda') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
    </ul>
  </div>
  <div class="col-md-10">
    <div class="row">
      @yield('scheduleModules')
    </div>
  </div>
</div>
@endsection