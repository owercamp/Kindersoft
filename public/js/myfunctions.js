$(document).ready(function () {

  /*if ($('#validateAuthColor').val() == 'Autenticado'){
    $('body').css('background','#fff');
    $('header').css('background','#fff');
  }
  if(($('#validateAuthColor').val() == 'Ausente')){
    $('body').css('background','#ccc');
    $('header').css('background','#ccc');
  }*/

  //Cargando datatables en tablas
  loadDatatables();

  //Cargando inputs con calendario
  $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    autoclose: true
  });

  $('input[name=temp]').mask("00.0");
  $('input[name=tExit]').mask("00.0");

  $('.bj-header-submenu').click(function () {
    $(this).find('ul').slideToggle();
  });
  $('.bj-header-submenu ul').click(function (e) {
    e.stopPropagation();
  });

  var direccionActual = $('.directionUri').html();
  $('.directionUri').html(seeDirection(direccionActual));

  $('input[name=firstname]').bind("keypress", event => sinComa(event));
  $('input[name=lastname]').bind("keypress", event => sinComa(event));
  $('input[name=nationality]').bind("keypress", event => sinComa(event));
  $('input[name=nameattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=addressattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=tituloattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=bussinessattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=addressbussinessattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=positionattendant1]').bind("keypress", event => sinComa(event));
  $('input[name=nameattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=addressattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=tituloattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=bussinessattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=addressbussinessattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=positionattendant2]').bind("keypress", event => sinComa(event));
  $('input[name=nameemergency]').bind("keypress", event => sinComa(event));
  $('input[name=addressemergency]').bind("keypress", event => sinComa(event));
  $('input[name=relationemergency]').bind("keypress", event => sinComa(event));
  $('input[name=nameautorized1]').bind("keypress", event => sinComa(event));
  $('input[name=relationautorized1]').bind("keypress", event => sinComa(event));
  $('input[name=nameautorized2]').bind("keypress", event => sinComa(event));
  $('input[name=relationautorized2]').bind("keypress", event => sinComa(event));
});

const sinComa = event => {
  let regex = new RegExp("^[a-zA-Z0-9 #-]+$");
  let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
}

function seeDirection($direction = '/home') {
  // const initial = "colchildren";
  // const initial = "dreamhome";
  const initial = "";
  const administrativeHumans = `${initial}/administrative/humans`,
    administrativeServices = `${initial}/administrative/services`,
    comercialCustomers = `${initial}/comercial/customers`,
    comercialProposals = `${initial}/comercial/proposals`,
    comercialEnrollments = `${initial}/comercial/enrollments`,
    academicStructure = `${initial}/academic/structure`,
    academicProgramming = `${initial}/academic/programming`,
    academicEvaluations = `${initial}/academic/evaluation`,
    logisticAssist = `${initial}/logistic/assist-control`,
    logisticNewletters = `${initial}/logistic/newsletters`,
    logisticEvents = `${initial}/logistic/events`,
    logisticIncreases = `${initial}/logistic/increase`,
    logisticCirculars = `${initial}/logistic/circulars`,
    logisticSchoolSchedule = `${initial}/logistic/school-schedule`,
    reportEnrollments = `${initial}/reports/enrollments`,
    reportStatistic = `${initial}/reports/statistic`,
    reportlicenses = `${initial}/reports/license`,
    financialAccounttants = `${initial}/financial/accounttants`,
    financialAnalysis = `${initial}/financial/analysis`;

  switch ($direction) {
    case `/${initial}/home`:
      return 'INICIO';
      break;
    case `/${initial}/profile`:
      return 'MI PERFIL >> GESTION DE ACCESO';
      break;
    case `/${initial}/registerAdmission`:
      return 'ADMISIONES > REGISTRO FORMULARIO';
      break;
    case `/${initial}/aprovedAdmission`:
      return 'ADMISIONES > APROBACION FORMULARIOS';
      break;
    case `/${initial}/Admission`:
      return 'ADMISIONES > MIGRACION FORMULARIOS';
      break;
    case `/${initial}/filesAdmission`:
      return 'ADMISIONES > ARCHIVO FORMULARIOS';
      break;
    case `/${initial}/city`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > CIUDADES';
      break;
    case `/${initial}/city/edit/`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > CIUDADES';
      break;
    case `/${initial}/location`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > LOCALIDADES';
      break;
    case `/${initial}/district`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > BARRIOS';
      break;
    case `/${initial}/document`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > DOCUMENTOS';
      break;
    case `/${initial}/bloodtype`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > GRUPOS SANGUINEOS';
      break;
    case `/${initial}/profession`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > PROFESIONES';
      break;
    case `/${initial}/health`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > CENTROS DE SALUD';
      break;
    case `/${initial}/user`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > USUARIOS';
      break;
    case `/${initial}/permission`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION BASE DE DATOS > PERMISOS';
      break;
    case `/${initial}/administrative/academic`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS';
      break;
    case `/${initial}/academic/period`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > PERIODOS';
      break;
    case `/${initial}/achievementAcademics`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > PROGRAMAS';
      break;
    case `/${initial}/academic/achievement/view`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > PROGRAMAS CONSOLIDADOS';
      break;
    case `/${initial}/intelligence`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > INTELIGENCIAS';
      break;
    case `/${initial}/achievement`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > LOGROS';
      break;
    case `/${initial}/grade`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > GRADOS';
      break;
    case `/${initial}/course`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > CURSOS';
      break;
    case `/${initial}/observations`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PROGRAMAS ACADEMICOS > OBSERVACIONES';
      break;
    case `/${initial}/role`:
      return 'GESTION DE MODIFICACIONES DE ACCESO... ROLES Y PERMISOS';
      break;
    case `/${administrativeHumans}`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS';
      break;
    case `/${administrativeHumans}/collaborator`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > COLABORADORES';
      break;
    case `/${administrativeHumans}/collaborator/new`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > NUEVO COLABORADOR';
      break;

    case `/${administrativeHumans}/attendant`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > ACUDIENTES';
      break;
    case `/${administrativeHumans}/attendant/new`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > NUEVO ACUDIENTE';
      break;

    case `/${administrativeHumans}/student`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > ALUMNO';
      break;
    case `/${administrativeHumans}/student/new`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > NUEVO ALUMNO';
      break;

    case `/${administrativeHumans}/provider`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > PROVEEDORES';
      break;
    case `/${administrativeHumans}/provider/new`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > NUEVO PROVEEDOR';
      break;
    case `/${administrativeHumans}/authorized`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > AUTORIZADOS';
      break;
    case `/${administrativeHumans}/authorized/new`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION RECURSOS HUMANOS > NUEVO AUTORIZADO';
      break;
    case `/${administrativeServices}`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS';
      break;
    case `/${administrativeServices}/admissions`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > ADMISIONES';
      break;
    case `/${administrativeServices}/journeys`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > JORNADAS';
      break;
    case `/${administrativeServices}/feedings`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > ALIMENTACIONES';
      break;
    case `/${administrativeServices}/uniforms`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > UNIFORMES';
      break;
    case `/${administrativeServices}/supplies`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > MATERIALES ESCOLARES';
      break;
    case `/${administrativeServices}/extratimes`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > MATERIALES ESCOLARES';
      break;
    case `/${administrativeServices}/extracurriculars`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > EXTRACURRICULARES';
      break;
    case `/${administrativeServices}/transports`:
      return 'GESTION ADMINISTRATIVA > CONFIGURACION PRODUCTOS Y SERVICIOS > TRANSPORTES';
      break;

    /* GESTION COMERCIAL */

    case `/${comercialCustomers}`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > REGISTRO ==> CLIENTES SIN CITACION';///////
      break;
    case `/${initial}/comercial/agenda`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > AGENDAMIENTO ==> CLIENTES CON CITACION';///////
      break;
    case `/${comercialCustomers}/new`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > AGENDAMIENTO > NUEVO CLIENTE';
      break;
    case `/${comercialCustomers}/programming`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > PROGRAMACION';
      break;
    case `/${comercialCustomers}/statistic`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > ESTADISTICAS';
      break;
    case `/${comercialCustomers}/statistic`:
      return 'GESTION COMERCIAL > CLIENTE POTENCIAL > ESTADISTICAS DE AGENDAMIENTOS';
      break;
    case `/${comercialProposals}/customerproposal`:
      return 'GESTION COMERCIAL > PROPUESTA COMERCIAL > CLIENTES ASISTIDOS';///////
      break;
    case `/${comercialProposals}/quotation`:
      return 'GESTION COMERCIAL > PROPUESTA COMERCIAL > COTIZACIONES';
      break;
    case `/${comercialProposals}/tracing`:
      return 'GESTION COMERCIAL > PROPUESTA COMERCIAL > SEGUIMIENTOS';
      break;
    case `/${comercialProposals}/files`:
      return 'GESTION COMERCIAL > PROPUESTA COMERCIAL > ARCHIVO';////////
      break;
    case `/${comercialProposals}/statistic`:
      return 'GESTION COMERCIAL > PROPUESTA COMERCIAL > ESTADISTICAS DE PROPUESTAS';
      break;
    case `/${comercialEnrollments}/documents`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > LISTA DE REQUISITOS';
      break;
    case `/${comercialEnrollments}/consolidated`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > ORDEN DE MATRICULAS';
      break;
    case `/${comercialEnrollments}/consolidated/new`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > ORDEN DE MATRICULAS > NUEVA MATRICULA';
      break;
    case `/${comercialEnrollments}/legalization`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > LEGALIZACION DE MATRICULAS';
      break;
    case `/${comercialEnrollments}/contract`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > GENERACION DE CONTRATOS';
      break;
    case `/${comercialEnrollments}/certificates`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > GENERACION DE CERTIFICADOS';
      break;
    case `/${comercialEnrollments}/legalizationsfinished`:
      return 'GESTION COMERCIAL > MATRICULAS Y ADMISIONES > ARCHIVO DE CONTRATOS';
      break;

    /* GESTION ACADEMICA */
    case `/${academicStructure}/gradeCourse`:
      return 'GESTION ACADEMICA > ESTRUCTURA ESCOLAR > GRADOS Y CURSOS';
      break;
    case `/${academicStructure}/gradeCourse/list`:
      return 'GESTION ACADEMICA > ESTRUCTURA ESCOLAR > GRADOS Y CURSOS >> LISTADOS';
      break;
    case `/${academicStructure}/gradeCourse/edit`:
      return 'GESTION ACADEMICA > ESTRUCTURA ESCOLAR > GRADOS Y CURSOS >> EDITAR FECHAS DEL CURSO';
      break;
    case `/${academicStructure}/activityspace`:
      return 'GESTION ACADEMICA > ESTRUCTURA ESCOLAR > ESPACIOS DE ACTIVIDADES';
      break;
    case `/${academicStructure}/activityclass`:
      return 'GESTION ACADEMICA > ESTRUCTURA ESCOLAR > CLASES Y ACTIVIDADES';
      break;
    case `/${academicProgramming}/hoursweek`:
      return 'GESTION ACADEMICA > PROGRAMACION ESCOLAR > HORARIO SEMANAL';
      break;
    case `/${academicProgramming}/academicperiod`:
      return 'GESTION ACADEMICA > PROGRAMACION ESCOLAR > PERIODOS ACADEMICOS';
      break;
    case `/${academicProgramming}/academicperiod/new`:
      return 'GESTION ACADEMICA > PROGRAMACION ESCOLAR > PERIODOS ACADEMICOS >> REGISTRO DE PERIODOS';
      break;
    case `/${academicProgramming}/baseactivitys`:
      return 'GESTION ACADEMICA > PROGRAMACION ESCOLAR > BASE DE ACTIVIDADES';
      break;
    case `/${academicProgramming}/planning`:
      return 'GESTION ACADEMICA > PROGRAMACION ESCOLAR > PLANEACION CRONOLOGICA';
      break;

    case `/${academicEvaluations}/weeklyTracking`:
      return 'GESTION ACADEMICA > EVALUACION ESCOLAR > SEGUIMIENTO SEMANAL';
      break;
    case `/${academicEvaluations}/periodClosing`:
      return 'GESTION ACADEMICA > EVALUACION ESCOLAR > CIERRE DE PERIODO ACADEMICO';
      break;
    case `/${academicEvaluations}/newsletters`:
      return 'GESTION ACADEMICA > EVALUACION ESCOLAR > INFORME DE PERIODO';
      break;
    case `/${academicEvaluations}/bulletins`:
      return 'GESTION ACADEMICA > EVALUACION ESCOLAR > BOLETINES ESCOLARES';
      break;


    /* GESTION LOGISTICA */

    case `/${logisticAssist}/check-in`:
      return 'GESTION LOGISTICA > CONTROL DE ASISTENCIA > REGISTRO INGRESO';
      break;
    case `/${logisticAssist}/check-out`:
      return 'GESTION LOGISTICA > CONTROL DE ASISTENCIA > REGISTRO SALIDA';
      break;
    case `/${logisticAssist}/register`:
      return 'GESTION LOGISTICA > CONTROL DE ASISTENCIA > REGISTRO ASISTENCIA';
      break;
    case `/${logisticAssist}/absence`:
      return 'GESTION LOGISTICA > CONTROL DE ASISTENCIA > REGISTRO AUSENCIA';
      break;
    case `/${logisticAssist}/graphics`:
      return 'GESTION LOGISTICA > CONTROL DE ASISTENCIA > GRAFICA ASISTENCIA';
      break;
    case `/${logisticNewletters}/assistances`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > CONTROL DE ASISTENCIAS';
      break;
    case `/${logisticNewletters}/additionals`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > CONTROL DE ADICIONALES';
      break;
    case `/${logisticNewletters}/feedingscontrol`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > CONTROL DE ALIMENTACION';
      break;
    case `/${logisticNewletters}/sphinctersControl`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > CONTROL DE ESFINTERES';
      break;
    case `/${logisticNewletters}/healthsControl`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > CONTROL DE ENFERMERIA';
      break;
    case `/${logisticNewletters}/reportDaily`:
      return 'GESTION LOGISTICA > NOVEDADES DIARIAS > INFORME DIARIO';
      break;

    case `/${logisticEvents}/creation`:
      return 'GESTION LOGISTICA > PROGRAMACION DE EVENTOS > CREACION';
      break;
    case `/${logisticEvents}/diary`:
      return 'GESTION LOGISTICA > PROGRAMACION DE EVENTOS > AGENDAMIENTO';
      break;
    case `/${logisticEvents}/follow`:
      return 'GESTION LOGISTICA > PROGRAMACION DE EVENTOS > SEGUIMIENTO';
      break;
    case `/${logisticEvents}/grafic`:
      return 'GESTION LOGISTICA > PROGRAMACION DE EVENTOS > ESTADISTICA';
      break;

    // CRECIMIENTO Y DESARROLLO
    case `/${logisticIncreases}/professionalsHealth`:
      return 'GESTION LOGISTICA > CRECIMIENTO Y DESARROLLO > PROFESIONALES DE LA SALUD';
      break;
    case `/${logisticIncreases}/observationsHealth`:
      return 'GESTION LOGISTICA > CRECIMIENTO Y DESARROLLO > OBSERVACIONES DE LA SALUD';
      break;
    case `/${logisticIncreases}/vaccination`:
      return 'GESTION LOGISTICA > CRECIMIENTO Y DESARROLLO > ESQUEMAS DE VACUNACION';
      break;
    case `/${logisticIncreases}/rating`:
      return 'GESTION LOGISTICA > CRECIMIENTO Y DESARROLLO > VALORACIONES PERIODICAS';
      break;
    case `/${logisticIncreases}/increaseStatistic`:
      return 'GESTION LOGISTICA > CRECIMIENTO Y DESARROLLO > ESTADISTICA';
      break;

    // CIRCULARES
    case `/${logisticCirculars}/bodycircular`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > CREACION DE CUERPOS';
      break;
    case `/${logisticCirculars}/academic`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > CIRCULAR ACADEMICA';
      break;
    case `/${logisticCirculars}/administrative`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > CIRCULAR ADMINISTRATIVA';
      break;
    case `/${logisticCirculars}/memo`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > MEMORANDO INTERNO';
      break;
    case `/${logisticCirculars}/academic/list`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > ARCHIVO CIRCULAR ACADEMICA';
      break;
    case `/${logisticCirculars}/administrative/list`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > ARCHIVO CIRCULAR ADMINISTRATIVA';
      break;
    case `/${logisticCirculars}/memo/list`:
      return 'GESTION LOGISTICA > CIRCULARES INFORMATIVAS > ARCHIVO COMUNICADO INTERNO';
      break;
    case `/${reportEnrollments}/list`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > LISTADO DE MATRICULADOS';
      break;
    case `/${reportEnrollments}/setting`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > CONFIGURACION DE INFORMES';
      break;
    case `/${reportEnrollments}/setting/attendant`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > INFORME DE ACUDIENTES';
      break;
    case `/${reportStatistic}/assistances`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > ESTADISTICA DE ASISTENCIA';
      break;
    case `/${reportStatistic}/increase`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > ESTADISTICA DE CRECIMIENTO Y DESARROLLO';
      break;
    case `/${reportlicenses}/collaborators`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > CARNETIZACION COLABORADOR';
      break;
    case `/${reportlicenses}/students`:
      return 'GESTION LOGISTICA > INFORMES ESPECIALES > CARNETIZACION ALUMNO';
      break;

    // AGENDA ESCOLAR
    case `/${logisticSchoolSchedule}/greeting`:
      return 'GESTION lOGISTICA > AGENDA ESCOLAR > PLANTILLAS DE SALUDO';
      break
    case `/${logisticSchoolSchedule}/context`:
      return 'GESTION LOGISTICA > AGENDA ESCOLAR > PLANTILLA DE CONTEXTO';
      break
    case `/${logisticSchoolSchedule}/daily`:
      return 'GESTION LOGISTICA > AGENDA ESCOLAR > INFORMACION DIARIA';
      break
    case `/${logisticSchoolSchedule}/file`:
      return 'GESTION LOGISTICA > AGENDA ESCOLAR > ARCHIVO DE AGENDA';
      break

    case `/${financialAccounttants}/accounts`:
      return 'GESTION FINANCIERA > ESTADOS DE CUENTA';
      break;
    case `/${financialAccounttants}/facturations/general`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > INFORMACION GENERAL';
      break;
    case `/${financialAccounttants}/facturations`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > FACTURACION';
      break;
    case `/${financialAccounttants}/facturations/all`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > GESTION DE CARTERA';
      break;
    case `/${financialAccounttants}/entryvouchers`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > COMPROBANTE DE INGRESO';
      break;
    case `/${financialAccounttants}/agressvouchers`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > COMPROBANTE DE EGRESO';
      break;
    case `/${financialAccounttants}/canceled`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > FACTURAS ANULADAS';
      break;
    case `/${financialAccounttants}/balances`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > CONCILIACION DE SALDOS';
      break;
    case `/${financialAccounttants}/statistic/financial`:
      return 'GESTION FINANCIERA > DOCUMENTOS CONTABLES > ESTADISTICA DE VENTAS';
      break;

    // ANALISIS DE PRESUPUESTO
    case `/${financialAnalysis}/coststructure`:
      return 'GESTION FINANCIERA > ANALISIS DE PRESUPUESTO > ESTRUCTURA DE COSTOS';
      break;
    case `/${financialAnalysis}/costdescription`:
      return 'GESTION FINANCIERA > ANALISIS DE PRESUPUESTO > DESCRIPCION DE COSTOS';
      break;
    case `/${financialAnalysis}/budget`:
      return 'GESTION FINANCIERA > ANALISIS DE PRESUPUESTO > PRESUPUESTO ANUAL';
      break;
    case `/${financialAnalysis}/follow`:
      return 'GESTION FINANCIERA > ANALISIS DE PRESUPUESTO > SEGUIMIENTO MENSUAL';
      break;
    case `/${financialAnalysis}/report`:
      return 'GESTION FINANCIERA > ANALISIS DE PRESUPUESTO > INFORME DE CIERRE';
      break;
    default:
      return 'GESTION DE MODIFICACIONES...';
      break;
  }
}


function loadDatatables() {

  $('#tableAccount').DataTable({
    language: {
      processing: "Procesamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#AssistTable').DataTable({
    language: {
      processing: "Procesamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      },
    }
  });

  $('#tableDatatable').DataTable({
    language: {
      processing: "Procesamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('.tableDatatable').DataTable({
    language: {
      processing: "Procesamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablecitys').DataTable({
    language: {
      processing: "Procesamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableachievements').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablebloodtypes').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablecourses').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tabledistricts').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tabledocuments').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablegrades').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablehealths').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableintelligences').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablelocations').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableperiods').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tablepermissions').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableprofessions').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableusers').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
  $('#tableconsolideachievements').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablecollaborators').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableattendants').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableproviders').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablestudents').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableadmissions').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });


  $('#tablejourneys').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablefeedings').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableuniforms').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablesupplies').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableextracurriculars').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableextratimes').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tabletransports').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablecustomers').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tabletracings').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableConsolidatedEnrollments').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablecontracts').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tablelistcourses').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableactivityspace').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });

  $('#tableactivityclass').DataTable({
    language: {
      processing: "Tratamiento en curso...",
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
      infoEmpty: "Mostrando dato 0 a 0 de 0 registros",
      emptyTable: "No hay registros disponibles",
      infoFiltered: "Filtrado de _MAX_ elementos totales",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No hay registros para mostrar",
      infoFiltered: "Filtrado de _MAX_ registros",
      paginate: {
        first: "|<",
        previous: "<",
        next: ">",
        last: ">|"
      }
    }
  });
}
