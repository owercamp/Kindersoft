@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>CERTIFICACIONES</h3>
    </div>
    <div class="col-md-6">
      <!-- Reservado para mensajes -->
    </div>
  </div>
  <div class="row mb-3 border-bottom">
    <div class="col-md-12 text-center">
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">SELECCIONE UN ALUMNO MATRICULADO PARA CERTIFICAR</small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <select name="cerStudent" class="form-control form-control-sm" required>
              <option value="">Seleccione un estudiante...</option>
              @foreach($students as $student)
              <option value="{{ $student->studentId }}">{{ $student->nameStudent }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row sectionCertificates">
    <div class="col-md-12 text-center">
      <div class="row">
        <div class="col-md-12 text-center">
          <div class="spinner-border" align="center" role="status">
            <span class="sr-only" align="center">Procesando...</span>
          </div>
        </div>
      </div>
      <div class="row infoCertificates" style="display: none; min-height: 792px;">
        <div class="col-md-12">
          <div class="row text-center">
            <div class="col-md-12">
              <form id="formForDownload" action="{{ route('certificatesPdf') }}" method="GET">
                @csrf
                <div class="form-group">
                  <input type="hidden" class="form-control form-control-sm" name="codeCertificatedPdf" value="" readonly required>
                  <button type="submit" class="btn btn-outline-tertiary  mx-3 my-3 form-control-sm"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row border-left border-top border-right border-bottom text-center mx-3 px-4 py-4">
            <div class="col-md-12">
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
              <b class="nameGardenCertificated">NOMBRE DE JARDIN</b><br>
              <b class="nitGardenCertificated">NIT</b><br>
              <br>
              <br>
              <br>
              <br>
              <br>
              <h4>CERTIFICA QUE</h4>
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
              @php

              function getStringDate($date){
              $separatedDate = explode('-',$date);
              switch($separatedDate[1]){
              case '01': return $separatedDate[2] . ' dias del mes de enero de ' . $separatedDate[0]; break;
              case '02': return $separatedDate[2] . ' dias del mes de febrero de ' . $separatedDate[0]; break;
              case '03': return $separatedDate[2] . ' dias del mes de marzo de ' . $separatedDate[0]; break;
              case '04': return $separatedDate[2] . ' dias del mes de abril de ' . $separatedDate[0]; break;
              case '05': return $separatedDate[2] . ' dias del mes de mayo de ' . $separatedDate[0]; break;
              case '06': return $separatedDate[2] . ' dias del mes de junio de ' . $separatedDate[0]; break;
              case '07': return $separatedDate[2] . ' dias del mes de julio de ' . $separatedDate[0]; break;
              case '08': return $separatedDate[2] . ' dias del mes de agosto de ' . $separatedDate[0]; break;
              case '09': return $separatedDate[2] . ' dias del mes de septiembre de ' . $separatedDate[0]; break;
              case '10': return $separatedDate[2] . ' dias del mes de octubre de ' . $separatedDate[0]; break;
              case '11': return $separatedDate[2] . ' dias del mes de noviembre de ' . $separatedDate[0]; break;
              case '12': return $separatedDate[2] . ' dias del mes de diciembre de ' . $separatedDate[0]; break;
              }
              }

              @endphp
              <p class="text-justify">
                <b class="nameStudentCertificate">NOMBRE ESTUDIANTE</b> identificado/a con el documento Nº <b class="numberStudentCertificate">NUMERO</b> con fecha de nacimiento el día <b class="birthdateStudentCertificate">FECHA</b> y con una edad actual de <b class="yearsoldStudentCertificate"></b> se encuentra matriculado/a en el programa de compromiso de atención a la primera infancia con el respectivo acudiente <b class="attendantStudentCertificate">ACUDIENTE</b> identificado con documento No. <b class="numberattendantStudentCertificate"></b> mediante contrato de cooperación educativa No. <b class="legalizationIdStudentCertificate"></b> con vigencia de <b class="dateInitialCertificate"></b> a <b class="dateFinalCertificate"></b>.
              </p>
              <br>
              <br>
              <br>
              @php $datenow = date('Y-m-d'); @endphp
              Se expide en la ciudad de Bogotá D.C, a los <b>{{ getStringDate($datenow) }}</b>
              <br>
              <br>
              <br>
              <p class="text-left">
                @if($garden->garFirm != null)
                <img class="img-firm" src="{{ asset('storage/garden/firm/'.$garden->garFirm) }}" style="width: 120px; height: auto;">
                @endif
                <br>
                <b class="nameRectorCertificated">NOMBRE</b><br>
                DIRECTORA<br><br>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>
@endsection


@section('scripts')
<script>
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

  $(function() {
    $('.sectionCertificates').css('display', 'none');
    $('.spinner-border').css('display', 'none');
  });

  $('select[name=cerStudent]').on('change', function(e) {
    $('.sectionCertificates').css('display', 'flex');
    $('.spinner-border').css('display', 'flex');
    $('.infoCertificates').css('display', 'none');
    var selectedStudent = e.target.value;
    if (selectedStudent !== '' && selectedStudent !== null) {
      $('input[name=codeCertificatedPdf]').val('');
      $('input[name=codeCertificatedPdf]').val(selectedStudent);

      $.ajax({
        url: "{{ route('getDatesCertificate') }}",
        data: {
          selectedStudent: selectedStudent
        },
        beforeSend: function() {
          $('.spinner-border').css('display', 'flex');
        },
        success: function(datesObject) {
          var nameStudent = datesObject['firstname'] + ' ' + datesObject['threename'] + ' ' + datesObject['fourname'];
          $('.nameStudentCertificate').text('');
          $('.nameStudentCertificate').text(nameStudent);
          $('.numberStudentCertificate').text('');
          $('.numberStudentCertificate').text(datesObject['numberdocument']);
          $('.birthdateStudentCertificate').text('');
          $('.birthdateStudentCertificate').text(getFormatDate(datesObject['birthdate']));
          $('.yearsoldStudentCertificate').text('');
          $('.yearsoldStudentCertificate').text(datesObject['yearsold']);
          $('.attendantStudentCertificate').text('');
          $('.attendantStudentCertificate').text(datesObject['nameAttendant']);
          $('.numberattendantStudentCertificate').text('');
          $('.numberattendantStudentCertificate').text(datesObject['numberAttendant']);
          $('.legalizationIdStudentCertificate').text('');
          $('.legalizationIdStudentCertificate').text(datesObject['legId']);

          $('.dateInitialCertificate').text('');
          $('.dateInitialCertificate').text(getFormatDate(datesObject['legDateInitial']));
          $('.dateFinalCertificate').text('');
          $('.dateFinalCertificate').text(getFormatDate(datesObject['legDateFinal']));
          $('.nameCourseCertificate').text('');

          $('.spinner-border').css('display', 'none');
          $('.infoCertificates').css('display', 'flex');

          $.get("{{ route('getGarden') }}", function(gardenObject) {
            if (gardenObject != null && gardenObject != '') {
              /*
              	gardenObject['garNamecomercial']
              	gardenObject['garNamerepresentative']
              */
              $('.nameGardenCertificated').text('');
              $('.nameGardenCertificated').text(gardenObject['garNamecomercial']);
              $('.nitGardenCertificated').text('');
              $('.nitGardenCertificated').text(gardenObject['garNit']);
              $('.nameRectorCertificated').text('');
              $('.nameRectorCertificated').text(gardenObject['garNamerepresentative']);
            }
          });
        }
      });
      /*$.ajax(
      	url: "{{ route('getDatesCertificate') }}",
      	data: { selectedStudent: selectedStudent },
      	beforeSend: function(){
      		$('spinner-border').css('display','flex');
      	},
      	success: function(datesObject){
      	if(datesObject !== null && datesObject !== ''){
      		var nameStudent = datesObject['firstname'] + ' ' + datesObject['secondname'] + ' ' + datesObject['threename'] + ' ' + datesObject['fourname'];
      		$('.nameStudentCertificate').text('');
      		$('.nameStudentCertificate').text(nameStudent);
      		$('.dateInitialCertificate').text('');
      		$('.dateInitialCertificate').text(datesObject['legDateInitial']);
      		$('.dateFinalCertificate').text('');
      		$('.dateFinalCertificate').text(datesObject['legDateFinal']);
      		$('.nameCourseCertificate').text('');
      		$('.nameCourseCertificate').text(datesObject['nameCourse']);
      		$('.nameGradeCertificate').text('');
      		$('.nameGradeCertificate').text(datesObject['nameGrade']);
      		$('.sectionCertificates').css('display','flex');
      		$('.infoCertificates').css('display','flex');
      	}else{
      		$('.sectionCertificates').css('display','none');
      		$('.sectionCertificates').html('');
      	}
      });*/
    } else {
      $('.sectionCertificates').css('display', 'none');
      $('.sectionCertificates').html('');
    }
  });

  function getFormatDate(date) {
    var separatedDate = date.split('-');
    switch (separatedDate[1]) {
      case '01':
        return separatedDate[2] + ' de Enero de ' + separatedDate[0];
        break;
      case '02':
        return separatedDate[2] + ' de Febrero de ' + separatedDate[0];
        break;
      case '03':
        return separatedDate[2] + ' de Marzo de ' + separatedDate[0];
        break;
      case '04':
        return separatedDate[2] + ' de Abril de ' + separatedDate[0];
        break;
      case '05':
        return separatedDate[2] + ' de Mayo de ' + separatedDate[0];
        break;
      case '06':
        return separatedDate[2] + ' de Junio de ' + separatedDate[0];
        break;
      case '07':
        return separatedDate[2] + ' de Julio de ' + separatedDate[0];
        break;
      case '08':
        return separatedDate[2] + ' de Agosto de ' + separatedDate[0];
        break;
      case '09':
        return separatedDate[2] + ' de Septiembre de ' + separatedDate[0];
        break;
      case '10':
        return separatedDate[2] + ' de Octubre de ' + separatedDate[0];
        break;
      case '11':
        return separatedDate[2] + ' de Noviembre de ' + separatedDate[0];
        break;
      case '12':
        return separatedDate[2] + ' de Diciembre de ' + separatedDate[0];
        break;
    }
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
</script>
@endsection