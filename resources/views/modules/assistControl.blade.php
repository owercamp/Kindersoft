@extends('homeAssistences')

@section('menuAssistances')
<div class="row">
  <div class="col-md-2">
    <ul class="nav bj-flex" style="min-height: 60vh;">
      <li>
        <a href="{{ route('assistences.check-in')}}" class="nav-link">
          <i class="fas fa-book-open"></i>
          <p>{{ ucwords('registro de llegada') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('assistences.check-out') }}" class="nav-link">
          <i class="fas fa-server"></i>
          <p>{{ ucwords('registro de salida') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('assistences.register') }}" class="nav-link">
          <i class="fas fa-list-ul"></i>
          <p>{{ ucwords('registro de asistencia') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('assistences.absence') }}" class="nav-link">
          <i class="fas fa-network-wired"></i>
          <p>{{ ucwords('registro de ausencia') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{route('assistences.graphics') }}" class="nav-link">
          <i class="fas fa-chart-bar"></i>
          <p>{{ ucwords('estadistica de asistencia') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
    </ul>
  </div>
  <div class="col-md-10">
    <div class="row">
      @yield('infoMenuAssistances')
    </div>
  </div>
</div>

@endsection