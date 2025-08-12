@extends('modules.reports')

@section('logisticModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>CONFIGURACION DE INFORMES</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de configuracion de informes -->
      @if(session('SuccessSaveSeting'))
      <div class="alert alert-success">
        {{ session('SuccessSaveSeting') }}
      </div>
      @endif
      @if(session('SecondarySaveSeting'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveSeting') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table id="tableDatatable" class="table" width="100%">
        <thead>
          <tr>
            <td>ALUMNO</td>
            <td>GENERO</td>
            <td>TIPO DE SANGRE</td>
            <td>FECHA DE NACIMIENTO</td>
            <td>GRADO</td>
            <td>ACUDIENTE</td>
            <td>FECHA DE LEGALIZACION</td>
          </tr>
        </thead>
        <tbody>
          @foreach($legalizations as $legalization)
          <tr>
            <td>{{ $legalization->nameStudent }}</td>
            <td>{{ $legalization->genderStudent }}</td>
            <td>{{ $legalization->nameBloodtype }}</td>
            <td>{{ $legalization->birthdate }}</td> <!-- $legalization->nameDistrict -->
            <td>{{ $legalization->nameGrade }}</td>
            <td>{{ $legalization->nameAttendantone }}</td>
            <td>{{ $legalization->legDateCreate }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form action="{{ route('legalizationExcel') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-outline-success form-control-sm btn-excel">EXPORTAR A EXCEL</button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('select[name=srTables] option').each(function() {
      var name = $(this).text();
      if (
        name == 'chronologicals' ||
        name == 'binnacle' ||
        name == 'consolidatedenrollments' ||
        name == 'consolide_achievements' ||
        name == 'coursesconsolidated' ||
        name == 'documentsEnrollment' ||
        name == 'facturaciongeneral' ||
        name == 'hoursweek' ||
        name == 'legalizations' ||
        name == 'listcourses' ||
        name == 'migrations' ||
        name == 'model_has_permissions' ||
        name == 'model_has_roles' ||
        name == 'numbersInitial' ||
        name == 'paids' ||
        name == 'permissions' ||
        name == 'proposals' ||
        name == 'role_has_permissions' ||
        name == 'roles' ||
        name == 'schedulings' ||
        name == 'trackingachievements' ||
        name == 'users' ||
        name == 'wallets' ||
        name == 'weeklytrackings'
      ) {
        $(this).remove();
      } else {
        $(this).text(traslateNameTable(name));
      }
    });
  });

  function traslateNameTable(nameTable) {
    switch (nameTable) {
      case 'academicperiods':
        return 'PERIODOS ACADEMICOS';
        break;
      case 'achievements':
        return 'LOGROS';
        break;
      case 'activityclass':
        return 'CLASES Y ACTIVIDADES';
        break;
      case 'activityspaces':
        return 'ESPACIOS DE ACTIVIDADES';
        break;
      case 'admissions':
        return 'ADMISIONES';
        break;
      case 'assistances':
        return 'ASISTENCIAS';
        break;
      case 'attendants':
        return 'ACUDIENTES';
        break;
      case 'authorized':
        return 'AUTORIZADOS';
        break;
      case 'autorizations':
        return 'AUTORIZACIONES';
        break;
      case 'binnacle':
        return 'BITACORAS';
        break;
      case 'bloodtypes':
        return 'TIPO DE SANGRE';
        break;
      case 'bulletins':
        return 'BOLETINES';
        break;
      case 'chronologicals':
        return 'CRONOLOGIA';
        break;
      case 'citys':
        return 'CIUDADES';
        break;
      case 'collaborators':
        return 'COLABORADORES';
        break;
      case 'concepts':
        return 'CONCEPTOS';
        break;
      case 'consolidatedenrollments':
        return 'MATRICULAS CONSOLIDADAS';
        break;
      case 'consolide_achievements':
        return 'LOGROS CONSOLIDADOS';
        break;
      case 'costDescription':
        return 'DESCRIPCIONES DE COSTOS';
        break;
      case 'costStructure':
        return 'ESTRUCTURAS DE COSTOS';
        break;
      case 'courses':
        return 'CURSOS';
        break;
      case 'coursesconsolidated':
        return 'CURSOS CONSOLIDADOS';
        break;
      case 'customers':
        return 'CLIENTES';
        break;
      case 'districts':
        return 'BARRIOS';
        break;
      case 'documents':
        return 'TIPOS DE DOCUMENTOS';
        break;
      case 'documentsEnrollment':
        return 'DOCUMENTOS DE MATRICULA';
        break;
      case 'eventCreations':
        return 'TIPOS DE EVENTOS';
        break;
      case 'eventDiary':
        return 'EVENTOS';
        break;
      case 'extracurriculars':
        return 'EXTRACURRICULARES';
        break;
      case 'extratimes':
        return 'TIEMPO EXTRA';
        break;
      case 'facturaciongeneral':
        return 'INFORMACION GENERAL DE FACTURACION';
        break;
      case 'facturations':
        return 'FACTURACIONES';
        break;
      case 'feedingcontrols':
        return 'CONTROL DE ALIMENTACION';
        break;
      case 'feedings':
        return 'ALIMENTACION AUTORIZADA';
        break;
      case 'garden':
        return 'INFORMACION DEL JARDIN';
        break;
      case 'grades':
        return 'GRADOS';
        break;
      case 'healthcontrols':
        return 'CONTROL DE ENFERMERIA';
        break;
      case 'healths':
        return 'ENTIDADES DE SALUD';
        break;
      case 'hoursweek':
        return 'HORARIO SEMANAL';
        break;
      case 'intelligences':
        return 'INTELIGENCIAS';
        break;
      case 'journeys':
        return 'JORNADAS';
        break;
      case 'legalizations':
        return 'LEGALIZACIONES';
        break;
      case 'listcourses':
        return 'LISTADO DE CURSOS';
        break;
      case 'locations':
        return 'LOCALIDADES';
        break;
      case 'migrations':
        return '';
        break;
      case 'model_has_permissions':
        return '';
        break;
      case 'model_has_roles':
        return '';
        break;
      case 'numbersInitial':
        return '';
        break;
      case 'observations':
        return 'OBSERVACIONES';
        break;
      case 'observations_bulletin':
        return 'OBSERVACIONES DE BOLETINES';
        break;
      case 'paids':
        return '';
        break;
      case 'periods':
        return 'PERIODOS';
        break;
      case 'permissions':
        return '';
        break;
      case 'professions':
        return 'PROFESIONES';
        break;
      case 'proposals':
        return '';
        break;
      case 'providers':
        return 'PROVEEDORES';
        break;
      case 'role_has_permissions':
        return '';
        break;
      case 'roles':
        return '';
        break;
      case 'schedulings':
        return '';
        break;
      case 'sphincters':
        return 'ESFINTERES';
        break;
      case 'students':
        return 'ALUMNOS';
        break;
      case 'supplies':
        return 'MATERIALES ESCOLARES';
        break;
      case 'trackingachievements':
        return '';
        break;
      case 'transports':
        return 'TRANSPORTES';
        break;
      case 'uniforms':
        return 'UNIFORMES';
        break;
      case 'users':
        return '';
        break;
      case 'voucheregress':
        return 'COMPROBANTES DE EGRESO';
        break;
      case 'voucherentrys':
        return 'COMPROBANTES DE INGRESO';
        break;
      case 'wallets':
        return 'SALDO EN CARTERA';
        break;
      case 'weeklytrackings':
        return 'SEGUIMIENTO SEMANAL';
        break;
      case 'annual':
        return 'PRESUPUESTO ANUAL';
        break;
    }
  }

  $('select[name=srTables]').on('change', function(e) {
    var table = e.target.value;
  });

  $('.btn-addItem').on('click', function() {
    var tableDB = $('select[name=srTables]').val();
    var tableES = $('select[name=srTables] option:selected').text();
    console.log(tableDB);
    console.log(tableES);

  });
</script>
@endsection