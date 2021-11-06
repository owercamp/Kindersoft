<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('img/shortlogo.gif') }}" />

  <title>{{ config('app.name', 'Colchildren') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Fullcalendar -->
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/core/main.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/daygrid/main.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/timegrid/main.min.css')}}">

  <!-- ChartJs -->
  <link rel="stylesheet" href="{{asset('plugins/chartJS/Chart.min.css')}}">
</head>

<body>
  <div id="app" class="bj-body">

    <!-- # HEADER # -->
    <header class="row">
      <div class="col-md-3 d-flex justify-content-center">
        <div class="bj-logo">
          <div>
            <a href="{{ url('/home') }}">
              <img src="{{ asset('img/shortlogo.gif') }}" class="img-kindersoft" alt="{{ config('app.lastname', 'KINDERSOFT') }}">
            </a><br>
            <small class="javapri">{{ __('V 19.07.01') }}</small><br>
            <small class="javapri">{{ __('Copyright©Javapri') }}</small>
          </div>
          <div>
            <small class="kinsmall">{{ __('KINDER') }}</small><small class="sofsmall">{{ __('SOFT') }}</small><small class="tm">&trade;</small><br>
            <b><small class="eslogan">{{ __('Control en linea') }}</small></b>
          </div>
        </div>
        <div class="text-center ml-4 pt-2">
          @if(file_exists('storage/garden/logo.png'))
          <img src="{{ asset('storage/garden/logo.png') }}" style="width: 80px; height: auto;">
          @else
          @if(file_exists('storage/garden/logo.jpg'))
          <img class="text-center" src="{{ asset('storage/garden/logo.jpg') }}" style="width: 80px; height: auto;">
          @else
          <img class="text-center" src="{{ asset('storage/garden/default.png') }}" style="width: 80px; height: auto;">
          @endif
          @endif
        </div>
      </div>
      @auth
      <input type="hidden" id="validateAuthColor" name="validateAuthColor" value="Autenticado">
      <div class="col-md-6 bj-nav">
        <ul class="bj-header-menu">
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN|COMERCIAL|LOGISTICO|ACADEMICO')
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
          <li><a href="#">ADMISIONES <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('registerAdmission') }}">REGISTRO FORMULARIO</a></li>
              <li><a href="{{ route('aprovedAdmission') }}">APROBACION FORMULARIO</a></li>
              <li><a href="{{ route('filesAdmission') }}">MIGRACION FORMULARIO</a></li>
              <li><a href="{{ route('admissionFiles') }}">ARCHIVO FORMULARIOS</a></li>
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
          <li><a href="#">ADMINISTRATIVA <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('citys') }}">CONFIGURACION BASE DE DATOS</a></li>
              <li><a href="{{ route('intelligences') }}">CONFIGURACION PROGRAMA ACADEMICO</a></li>
              <li><a href="{{ route('collaborators') }}">CONFIGURACION RECURSOS HUMANOS</a></li>
              <li><a href="{{ route('admissions') }}">CONFIGURACION PRODUCTOS Y SERVICIOS</a></li>
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN|COMERCIAL')
          <li><a href="#">COMERCIAL <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('customers') }}">CLIENTE POTENCIAL</a></li>
              <li><a href="{{ route('customer_proposal') }}">PROPUESTA COMERCIAL</a></li>
              <li><a href="{{ route('documentsEnrollment') }}">MATRICULAS Y ADMISIONES</a></li>
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN|ACADEMICO')
          <li><a href="#">ACADEMICA <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('gradeCourse') }}">ESTRUCTURA ESCOLAR</a></li>
              <li><a href="{{ route('hoursweek') }}">PROGRAMACION ESCOLAR</a></li>
              <li><a href="{{ route('weeklyTracking') }}">EVALUACION ESCOLAR</a></li>
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN|LOGISTICO')
          <li><a href="#">LOGISTICA <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('assistences.check-in') }}">CONTROL DE ASISTENCIA</a></li>
              <li><a href="{{ route('additionals') }}">NOVEDADES DIARIAS</a></li>
              <li><a href="{{ route('creation') }}">PROGRAMACION DE EVENTOS</a></li>
              <li><a href="{{ route('professionalHealth') }}">CRECIMIENTO Y DESARROLLO</a></li>
              <li><a href="{{ route('enrollments.list') }}">INFORMES ESPECIALES</a></li>
              <li><a href="{{ route('bodycircular') }}">CIRCULARES INFORMATIVAS</a></li>
              <li><a href="{{ route('greetingTemplate') }}">AGENDA ESCOLAR</a></li>
            </ul>
          </li>
          @endhasanyrole
          @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN|FINANCIERO')
          <li><a href="#">FINANCIERA <i class="fas fa-level-down-alt"></i></a>
            <ul class="bj-header-submenu">
              <li><a href="{{ route('accounts') }}">ESTADO DE CUENTA</a></li>
              <li><a href="{{ route('general') }}">DOCUMENTOS CONTABLES</a></li>
              <li><a href="{{ route('analysis.structure') }}">ANALISIS DE PRESUPUESTO</a></li>
            </ul>
          </li>
          @endhasanyrole
          @endhasanyrole
        </ul>
      </div>
      <div class="col-md-3">
        <div class="row profile">
          <img src="{{ asset('img/bg_profile.png') }}" class="bg-profile" alt="{{ config('app.lastname', 'PROFILE') }}">
          <div class="bj-profile">
            <i class="fas fa-user bj-user"></i>
            <a href="{{ route('profile') }}" class="bj-link-user">
              {{ Auth::user()->lastname }}, {{ Auth::user()->firstname }}<br>
              @if(isset(Auth::user()->getRoleNames()[0]))
              {{ Auth::user()->getRoleNames()[0] }}
              @else
              {{ __('ROL INDEFINIDO') }}
              @endif
            </a>
            <a href="{{ route('logout') }}" title="Salir" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-in-alt bj-icon-logout"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </div>
      </div>
      @else
      <input type="hidden" id="validateAuthColor" name="validateAuthColor" value="Ausente">
      @endauth
    </header>
    <!-- # HEADER # -->


    <main class="row">
      @yield('content')
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fullcalendar-->
  <script src="{{asset('plugins/fullcalendar/moment/main.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/core/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/daygrid/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/timegrid/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/interaction/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/core/locales/es.js')}}"></script>


  <!-- ChartJS para graficos de las estadisticas -->
  <script src="{{asset('plugins/chartJS/Chart.min.js')}}"></script>

  <!-- Plugin de jsPDF para reportes -->
  <script src="{{ asset('js/jsPDF.js') }}"></script>
  <script src="{{asset('plugins/jsPDF-1.3.2/dist/jspdf.min.js')}}"></script>
  <!-- Plugin de html2canvas para reportes -->
  <script src="{{asset('plugins/html2canvas/html2canvas.min.js')}}"></script>
  @yield('scripts')
</body>

</html>