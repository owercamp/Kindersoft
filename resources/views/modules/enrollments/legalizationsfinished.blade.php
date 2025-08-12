@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>ARCHIVO DE CONTRATOS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes -->
      @if(session('SuccessFinished'))
      <div class="alert alert-success">
        {{ session('SuccessFinished') }}
      </div>
      @endif
      @if(session('SecondaryFinished'))
      <div class="alert alert-secondary">
        {{ session('SecondaryFinished') }}
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
          <form action="{{ route('legalizationsfinishedPdf') }}" method="GET" style="display: inline-block;">
            @csrf
            <input type="hidden" name="CodeContractForPDF" value="{{ $arrayLegalizations[$row][0] }}" class="form-control form-control-sm" required>
            <button type="submit" title="DESCARGAR PDF" class="btn btn-outline-danger rounded-circle form-control-sm">
              <i class="fas fa-file-pdf"></i>
            </button>
          </form>
        </td>
        </tr>
        @endfor
    </tbody>
  </table>
</div>

@endsection


@section('scripts')
<script>
  $(function() {
    $('.spinner-border').css('display', 'none');
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