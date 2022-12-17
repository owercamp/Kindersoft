@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>CONTRATOS DE MATRICULAS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes -->
      @if(session('SuccessContract'))
      <div class="alert alert-success">
        {{ session('SuccessContract') }}
      </div>
      @endif
      @if(session('SecondaryContract'))
      <div class="alert alert-secondary">
        {{ session('SecondaryContract') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablecontracts" class="table text-center">
    <thead>
      <tr>
        <th><small class="text-muted"><b>#</b></small></th>
        <th><small class="text-muted"><b>ALUMNO</b></small></th>
        <th><small class="text-muted"><b>MADRE / PADRE</b></small></th>
        <th><small class="text-muted"><b>GRADO</b></small></th>
        <th><small class="text-muted"><b>ACCIONES</b></small></th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @for($row = 0;$row < count($arrayLegalizations);$row++) <tr>
        <td>{{ $arrayLegalizations[$row][0] }}</td>
        <td>{{ $arrayLegalizations[$row][1] }}</td>
        <td>{{ $arrayLegalizations[$row][2] }}</td>
        <td>{{ $arrayLegalizations[$row][3] }}</td>
        <td>
          <a href="#" title="VER CONTRATO" class="btn btn-outline-success rounded-circle form-control-sm detailsLegalization-link">
            <i class="fas fa-eye"></i>
            <span hidden>{{ $arrayLegalizations[$row][0] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][1] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][2] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][3] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][4] }}</span>
          </a>
          <a href="#" title="TERMINACION DE CONTRATO" class="btn btn-outline-secondary rounded-circle form-control-sm finishLegalization-link">
            <i class="fas fa-times"></i>
            <span hidden>{{ $arrayLegalizations[$row][0] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][1] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][2] }}</span>
            <span hidden>{{ $arrayLegalizations[$row][3] }}</span>
          </a>
        </td>
        </tr>
        @endfor
    </tbody>
  </table>
</div>

<div class="modal fade" id="detailsContract-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h4 class="text-muted">CONTRATO:</h4>
          </div>
          <div class="col-md-6">
            <form id="formForDownload" class="form-inline" action="{{ route('contractPdf') }}" method="GET">
              @csrf
              <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" name="CodeContractForPDF" value="" readonly required>
                <button type="submit" class="btn btn-outline-tertiary  mx-3 form-control-sm"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-body my-5 mx-5 py-5 px-5">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              @php $year = date('Y'); @endphp
              <div class="col-md-12 text-center">
                <h4 class="mb-0"><b class="nameGardenContract">NOMBRE DE JARDIN</b></h4><br>
                @if(file_exists('storage/garden/logo.png'))
                <img src="{{ asset('storage/garden/logo.png') }}" alt=".png" style="width: 150px; height: auto;">
                @elseif(file_exists('storage/garden/logo.jpg'))
                <img src="{{ asset('storage/garden/logo.jpg') }}" alt=".png" style="width: 150px; height: auto;">
                @else
                <img src="{{ asset('storage/garden/default.png') }}" alt=".png" style="width: 150px; height: auto;">
                @endif
              </div>
            </div>
            <div class="row border-top mt-3">
              <blockquote class="blockquote">
                <p class="mb-0 text-center">CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCATIVOS AÑO @php echo $year; @endphp</p>
              </blockquote>
              <p style="text-align: justify; font-size: 12px;">
                <b class="nameGardenContract">...</b> identificado con el NIT <b class="nitGardenContract">...</b>, representada legalmente por <b class="nameRectorContract">...</b>, mayor de edad, domiciliada en la ciudad de Bogotá, identificada con la cédula de ciudadanía No. C.C. No. <b class="numberdocumentRectorContract"></b> de Bogotá, en mi condición de representante legal y Directora de <b class="nameGardenContract">...</b>, beneficiario <b class="nameStudentContract">...</b> edad <b class="yearsolsStudentContract">...</b>, realizamos este contrato de atención a la primera infancia con <b class="nameFatherContract">____________________________________ (Acudiente 1)</b> y <b class="nameMotherContract">______________________________________(Acudiente 2)</b>, domiciliados en la ciudad de Bogotá, personas igualmente mayores de edad, identificadas como aparece al pie de sus firmas en su condición de Padres de Familia o Acudiente, Deudor y Codeudor del Beneficiario, celebramos el presente contrato, el cual se regirá de conformidad con las siguientes cláusulas: <b>CLÁUSULA PRIMERA</b>. DEFINICIÓN DEL CONTRATO: Obedeciendo las normas constitucionales y la Ley, el presente contrato es un compromiso de atención a la primera infancia, en donde se establece de la estimulación en desarrollo y consecuencialmente, unas obligaciones de los cuidadores, beneficiarios, Padres de Familia o Acudiente, Deudor y Codeudor, en procura de una mejor prestación del servicio, de manera que el incumplimiento de las obligaciones aquí adquiridas, haría imposible la consecución del fin propuesto. <b>CLÁUSULA SEGUNDA</b>. OBJETO: El presente contrato busca unir esfuerzos recíprocos entre los aquí comprometidos, para obtener una excelente estimulación en el desarrollo y en valores, correspondiente al programa de la edad en el cual se matrícula. <b>CLÁUSULA TERCERA</b>. OBLIGACIONES ESENCIALES DEL CONTRATO: Por ser éste un Contrato de atención a la primera infancia, son obligaciones esenciales el cumplimiento continuado de los contratantes considerándose interrumpido por las siguientes razones:
                <b>A)</b>
                POR PARTE DE <b class="nameGardenContract">...</b>:
                No impartir la estimulación en el desarrollo y en valores aquí contratada
                <b>B)</b>
                POR PARTE DEL ESTUDIANTE BENEFICIARIO: No asistir a la Institución ni cumplir lo estipulado en el Pacto de Corresponsabilidad. El incumplimiento de éste es imputable al Estudiante, Padres de Familia o Acudientes. <b>C)</b> POR PARTE DE LOS PADRES DE FAMILIA O ACUDIENTE, DEUDOR Y CODEUDOR: <b>A)</b> No conocer el Pacto de Convivencia y El modelo aplicado, en los cuales se comparten los principios de desarrollo en que se fundamentan y se comprometen a cumplirlos en la parte que les corresponde.
                <b>PARÁGRAFO: </b>Para todos los efectos legales, tanto el Pacto de Corresponsabilidad y el modelo aplicado., se consideran incorporados al presente contrato. <b>B) </b>El no pago oportuno del costo del servicio aquí pactado y el suministro inmediato de los implementos determinados por el Jardin al Beneficiario.
                <b>CLÁUSULA CUARTA</b>. DURACIÓN: Este contrato tiene vigencia por el año lectivo 2023 contado a partir de <b class="dateInitialContract">...</b> hasta <b class="dateFinalContract">...</b>, Su ejecución será sucesiva por periodos mensuales y podrá renovarse para el año siguiente, siempre y cuando el Beneficiario, los Padres de Familia o Acudiente, Deudor y Codeudor hayan cumplido estrictamente las condiciones estipuladas en el presente contrato, en el Pacto de Corresponsabilidad y modelo aplicado y estar a paz y salvo por todo concepto con <b class="nameGardenContract">...</b>. En caso que un beneficiario se matricule extemporáneo la duración y el monto a cancelar se ajustará en relación al tiempo faltante para la finalización del año lectivo.
                <b>CLÁUSULA QUINTA</b>.
                COSTOS: El presente contrato por este servicio educativo tendrá un costo anual de (<b class="payValuecontract">$0</b>) que corresponde a <b class="payValuemount">$0</b> por concepto de pensión mensual de estudio del año lectivo, el cual debe ser cancelado en (<b class="payCountquotation">0</b>) cuota/s mensuales dentro de los (<b class="payDatepaids">0</b>) primeros días de cada mes y <b class="payValueEnrollment">$0</b> por concepto de matrícula. El costo anual se ajustará cada año, según lo autorizado por la Ley.
                <b>PARÁGRAFO PRIMERO:</b> Las partes contratantes acuerdan que en caso de incumplimiento en las fechas estipuladas para la matrícula, los Padres de Familia o Acudiente, Deudor y Codeudor deberán cancelar el costo estipulado para la matrícula extemporánea. <b>PARÁGRAFO SEGUNDO:</b> Las partes acuerdan que <b class="nameGardenContract">...</b>, no reembolsará suma alguna de dinero por este concepto por retiro anticipado del estudiante beneficiario. <b>PARÁGRAFO TERCERO:</b> El departamento de Cartera genera el primer (1er) día hábil de cada mes,...
              </p>
              <br>
              <p style="text-align: justify; font-size: 12px;">
                DESCARGUE LA VERSION COMPLETA EN PDF ...
              </p>
              <footer class="blockquote-footer">
                Versión: <cite title="Kindersoft {{config('app.version')}}">Kindersoft {{config('app.version')}}</cite>
              </footer>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de terminacion de contrato -->
<div class="modal fade" id="finishLegalization-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-12">
            <h6 class="text-muted">TERMINACION DE CONTRATO:</h6>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="row modal-body">
        <div class="col-md-12">
          <form action="{{ route('contracts.finish') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">INFORMACION DE CONTRATO:</small>
              </div>
            </div>
            <div class="row border mb-3" style="font-size: 12px;">
              <div class="col-md-6">
                <span class="text-muted">CODIGO:</span><br>
                <span class="text-muted">ALUMNO:</span><br>
                <span class="text-muted">GRADO:</span><br>
                <span class="text-muted">ACUDIENTES:</span><br>
              </div>
              <div class="col-md-6">
                <b class="codeLegalization-modalFinish"></b><br>
                <b class="nameStudent-modalFinish"></b><br>
                <b class="gradeStudent-modalFinish"></b><br>
                <b class="parentsStudent-modalFinish"></b>
              </div>
            </div>
            <div class="form-group">
              <small class="text-muted">ARGUMENTO DE TERMINACION:</small>
              <textarea name="argumentFinish" maxlength="500" cols="1" rows="2" class="form-control form-control-sm" required></textarea>
            </div>
            <div class="form-group text-center" style="font-size: 12px;">
              <input type="hidden" name="legId_finish" class="form-control form-control-sm text-center" readonly required>
              <button type="submit" class='btn btn-outline-secondary form-control-sm'>TERMINAR CONTRATO</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
  $(function() {
    $('.spinner-border').css('display', 'none');
  });

  $('.detailsLegalization-link').on('click', function() {
    var legId = $(this).find('span:nth-child(2)').text();
    $('input[name=CodeContractForPDF]').val('');
    $('input[name=CodeContractForPDF]').val(legId);

    $('.nameStudentContract').text($(this).find('span:nth-child(3)').text());

    // var separatedYearMount = $(this).find('span:nth-child(6)').text().split('-');
    // $('.yearsolsStudentContract').text(separatedYearMount[0] + ' años con ' + separatedYearMount[1] + ' meses');
    var birthdate = $(this).find('span:nth-child(6)').text();
    $('.yearsolsStudentContract').text(getYearsold(converterYearsoldFromBirtdate(birthdate)));

    var indexCharacter = $(this).find('span:nth-child(4)').text().indexOf('/');

    if (indexCharacter >= 0) {
      var parents = $(this).find('span:nth-child(4)').text().split('/');
      $('.nameMotherContract').text('');
      $('.nameMotherContract').text(parents[0]);
      $('.nameFatherContract').text('');
      $('.nameFatherContract').text(parents[1]);
    } else {
      var whatParent = $(this).find('span:nth-child(4)').text().indexOf('(Acudiente 2)');
      if (whatParent >= 0) {
        $('.nameFatherContract').text('');
        $('.nameFatherContract').text('_____________________________________(Acudiente 1)');
        $('.nameMotherContract').text('');
        $('.nameMotherContract').text($(this).find('span:nth-child(4)').text());
      } else {
        $('.nameFatherContract').text('');
        $('.nameFatherContract').text($(this).find('span:nth-child(4)').text());
        $('.nameMotherContract').text('');
        $('.nameMotherContract').text('_____________________________________(Acudiente 2)');
      }
    }

    $('.nameGradeContract').text($(this).find('span:nth-child(5)').text());

    $.get("{{ route('getGarden') }}", function(gardenObject) {
      if (gardenObject != null && gardenObject != '') {
        /*
        	gardenObject['garReasonsocial']
        	gardenObject['garNamecomercial']
        	gardenObject['garNit']
        	gardenObject['garNameCity']
        	gardenObject['garNameLocation']
        	gardenObject['garNameDistrict']
        	gardenObject['garAddress']
        	gardenObject['garPhone']
        	gardenObject['garPhoneone']
        	gardenObject['garPhonetwo']
        	gardenObject['garPhonethree']
        	gardenObject['garWhatsapp']
        	gardenObject['garWebsite']
        	gardenObject['garMailone']
        	gardenObject['garMailtwo']
        	gardenObject['garNamelogo']
        	gardenObject['garNamerepresentative']
        	gardenObject['garCardrepresentative']
        */
        $('.nameGardenContract').text('');
        $('.nameGardenContract').text(gardenObject['garReasonsocial'] + ' - ' + gardenObject['garNamecomercial']);
        $('.nitGardenContract').text('');
        $('.nitGardenContract').text(gardenObject['garNit']);
        $('.addressGardenContract').text('');
        $('.addressGardenContract').text(gardenObject['garAddress']);
        $('.nameRectorContract').text('');
        $('.nameRectorContract').text(gardenObject['garNamerepresentative']);
        $('.numberdocumentRectorContract').text('');
        $('.numberdocumentRectorContract').text(gardenObject['garCardrepresentative']);
      }
    });

    $.get("{{ route('getPaid') }}", {
      legId: legId
    }, function(paidObject) {
      if (paidObject != null && paidObject != '') {
        /*
        	paidObject['payValuecontract']
        	paidObject['payCountquotation']
        	paidObject['payValuemount']
        	paidObject['payDatepaids']
        	paidObject['payValueConsolidated']
        	paidObject['payLegalization_id']
        */
        $('.payValuecontract').text('');
        $('.payValuecontract').text(paidObject['payValueContract']);
        $('.payCountquotation').text('');
        $('.payCountquotation').text(paidObject['payDuesQuotationContract']);
        $('.payValuemount').text('');
        $('.payValuemount').text(paidObject['payValuemountContract']);
        $('.payDatepaids').text('');
        $('.payDatepaids').text(returnDay(paidObject['payDatepaidsContract'])); // return day
        $('.payValueEnrollment').text('');
        $('.payValueEnrollment').text(paidObject['payValueEnrollment']);
      }
    });

    /*
    b.nameGardenContract
    b.nitGardenContract
    b.addressGardenContract
    b.emailGardenContract
    b.phoneGardenCOntract
    b.phoneextGardenCOntract
    b.cityGardenContract
    b.districtGardenContract
    b.webGardenContract

    b.nameRectorContract
    b.typedocumentRectorContract
    b.numberdocumentRectorContract
    b.cityNumberdocumentRectorContract

    b.nameAttendantContract
    b.nameStudentContract
    b.nameGradeContract
    */
    $('#detailsContract-modal').modal();
  });

  $('.finishLegalization-link').on('click', function(e) {
    e.preventDefault();
    var legId = $(this).find('span:nth-child(2)').text();
    var nameStudent = $(this).find('span:nth-child(3)').text();
    var attendants = $(this).find('span:nth-child(4)').text();
    var grade = $(this).find('span:nth-child(5)').text();
    $('input[name=legId_finish]').val(legId);
    $('.codeLegalization-modalFinish').text(legId);
    $('.nameStudent-modalFinish').text(nameStudent);
    $('.parentsStudent-modalFinish').text(attendants);
    $('.gradeStudent-modalFinish').text(grade);
    $('#finishLegalization-modal').modal();
  });

  function converterYearsoldFromBirtdate(date) {
    var values = date.split("-");
    var day = values[2];
    var mount = values[1];
    var year = values[0];
    var now = new Date();
    var yearNow = now.getYear()
    var mountNow = now.getMonth() + 1;
    var dayNow = now.getDate();
    //Cálculo de años
    var old = (yearNow + 1900) - year;
    if (mountNow < mount) {
      old--;
    }
    if ((mount == mountNow) && (dayNow < day)) {
      old--;
    }
    if (old > 1900) {
      old -= 1900;
    }
    //Cálculo de meses
    var mounts = 0;
    if (mountNow > mount && day > dayNow) {
      mounts = (mountNow - mount) - 1;
    } else if (mountNow > mount) {
      mounts = mountNow - mount;
    } else if (mountNow < mount && day < dayNow) {
      mounts = 12 - (mount - mountNow);
    } else if (mountNow < mount) {
      mounts = 12 - (mount - mountNow + 1);
    }
    if (mountNow == mount && day > dayNow) {
      mounts = 11;
    }
    //Cálculo de dias
    var days = 0;
    if (dayNow > day) {
      days = dayNow - day
    }
    if (dayNow < day) {
      lastDayMount = new Date(yearNow, mountNow - 1, 0);
      days = lastDayMount.getDate() - (day - dayNow);
    }
    var processed = parseInt(old) + '-' + parseInt(mounts);
    return processed;
    // days ==> Opcional para mostrar dias también
  }

  function getYearsold(yearsold) {
    var len = yearsold.length;
    if (len < 5 & len > 0) {
      var separated = yearsold.split('-');
      return separated[0] + ' años ' + separated[1] + ' meses';
    } else {
      return yearsold;
    }
  }

  function returnDay(date) {
    var day = date.substr(8, 2);
    return day;
  }
</script>
@endsection