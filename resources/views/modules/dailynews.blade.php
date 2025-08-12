@extends('homeLogistic')

@section('modulesLogistic')
<div class="row">
  <div class="col-md-2">
    <ul class="nav bj-flex" style="min-height: 60vh;">
      <!-- <li>
					<a href="{{ route('assistances') }}" class="nav-link">
						<i class="fas fa-tasks"></i>
						<p>{{ __('Control de asistencia') }}</p>
					</a>
				</li>
				<div class="dropdown-divider bj-divider"></div> -->
      <li>
        <a href="{{ route('additionals') }}" class="nav-link">
          <i class="fas fa-clipboard-check"></i>
          <p>{{ __('Control de adicionales') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('feedings.control') }}" class="nav-link">
          <i class="fas fa-utensils"></i>
          <p>{{ __('Control de alimentación') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('sphincters') }}" class="nav-link">
          <i class="fas fa-child"></i>
          <p>{{ __('Control de esfínteres') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('health.control') }}" class="nav-link">
          <i class="fas fa-notes-medical"></i>
          <p>{{ __('Control de enfermería') }}</p>
        </a>
      </li>
      <div class="dropdown-divider bj-divider"></div>
      <li>
        <a href="{{ route('reportDaily') }}" class="nav-link">
          <i class="fas fa-journal-whills"></i>
          <p>{{ __('Informe diario') }}</p>
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