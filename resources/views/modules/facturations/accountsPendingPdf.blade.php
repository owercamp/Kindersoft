<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Para bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <style>
    @page {
      margin: 50px 50px;
    }

    .titles {
      text-align: left;
      font-size: 12px;
      font-weight: bold;
      color: #ccc;
      font-style: italic;
      line-height: 0;
    }

    .dates {
      font-size: 9px;
      color: #000;
      font-style: normal;
      font-weight: bold;
    }

    .dates-green {
      color: #a4b068;
      text-align: left;
    }

    .dates-small {
      font-size: 12px;
      color: #000;
    }

    .title-items {
      font-size: 10px;
      font-weight: bold;
      color: #ff5500;
      padding-right: 2px;
      text-align: center;
      background-color: #ccc;
      border: 1px solid #ccc;
    }

    .title-blue {
      color: #54ADFF;
    }
  </style>
</head>

<body>
  @php
  function returnType($value){
  switch($value){
  case 'Cedula de ciudadania' || 'Cédula de ciudadania':
  return 'C.C:';
  break;
  case 'NUIP' || 'nuip':
  return 'NUIP:';
  break;
  default: return $value; break;
  }
  }
  function returnDate($date){
  $mount = $date[5] . $date[6];
  $day = $date[8] . $date[9];
  $year = $date[0] . $date[1] . $date[2] . $date[3];
  switch($mount){
  case '01': return 'Enero ' . $day . ' de ' . $year; break;
  case '02': return 'Febrero ' . $day . ' de ' . $year; break;
  case '03': return 'Marzo ' . $day . ' de ' . $year; break;
  case '04': return 'Abril ' . $day . ' de ' . $year; break;
  case '05': return 'Mayo ' . $day . ' de ' . $year; break;
  case '06': return 'Junio ' . $day . ' de ' . $year; break;
  case '07': return 'Julio ' . $day . ' de ' . $year; break;
  case '08': return 'Agosto ' . $day . ' de ' . $year; break;
  case '09': return 'Septiembre ' . $day . ' de ' . $year; break;
  case '10': return 'Octubre ' . $day . ' de ' . $year; break;
  case '11': return 'Noviembre ' . $day . ' de ' . $year; break;
  case '12': return 'Diciembre ' . $day . ' de ' . $year; break;
  }
  }
  function returnRegime($value){
  switch($value){
  case 'COMUN': return 'IVA regimen común'; break;
  case 'SIMPLIFICADO': return 'IVA regimen simplificado'; break;
  case 'ESPECIAL': return 'IVA regimen especial'; break;
  }
  }
  function returnAutoretainer($value){
  switch($value){
  case 'SI': return 'somos autoretenedores'; break;
  case 'NO': return 'no somos autoretenedores'; break;
  }
  }
  function returnTaxpayer($value){
  switch($value){
  case 'SI': return 'somos grandes contribuyentes'; break;
  case 'NO': return 'no somos grandes contribuyentes'; break;
  }
  }
  function returnAccount($value){
  switch($value){
  case 'AHORRO': return 'Cuenta de ahorro'; break;
  case 'CORRIENTE': return 'Cuenta corriente'; break;
  case 'RECAUDO': return 'Cuenta de recaudo'; break;
  case 'FIDUCIA': return 'Cuenta fiducia'; break;
  }
  }
  function returnValueIva($value,$iva){
  return ($value * $iva) / 100;
  }
  @endphp
  <!-- <div class="container-fluid"> -->
  <table width="100%">
    <tr>
      <td style="text-align: center; width: 80px;">
        <h1 style="font-weight: bold; color: #ccc;">CARTERA PENDIENTE</h1>
      </td>
      <td style="text-align: center;">
        <img src="{{ asset('storage/garden/code.png') }}" style="width: 100px; height: auto;">
      </td>
      <td style="padding-right: 10px;">
        <p class="titles" style="line-height: 20px; text-align: right;">
          <small class="text-muted titles"><span>{{ $garden->garNamecomercial }}</span></small><br>
          <small class="text-muted titles">NIT <span>{{ $garden->garNit }}</span></small><br>
          <small class="text-muted titles"><span>{{ $garden->garAddress }}</span></small><br>
          <small class="text-muted titles"><span>{{ $garden->nameCity }}</span> - <span>{{ $garden->nameLocation }}</span></small><br>
          <small class="text-muted titles"><span>{{ $garden->garMailone }}</span> / <span>+57 {{ $garden->garPhone }}</span></small>
        </p>
      </td>
    </tr>
    <tr>
      <td style="text-align: right; border: 1px solid #ccc; padding-right: 10px;">
        <p class="titles" style="line-height: 15px; text-align: right;">
          <small class="text-muted titles" style="margin-top: 5px;">Cliente:</small><br>
          <small class="text-muted titles">Alumno:</small><br>
          <small class="text-muted titles">Grado:</small><br>
          <small class="text-muted titles">Domicilio:</small>
        </p>
      </td>
      <td colspan="2" style="text-align: left; border: 1px solid #ccc; padding-left: 10px;">
        <p class="titles" style="line-height: 15px; text-align: left;">
          <small class="dates dates-green" style="margin-top: 5px;">{{ $legalization->nameAttendant }}</small><br>
          <small class="dates dates-green">{{ $legalization->nameStudent }} </small><br>
          <small class="dates dates-green">{{ $legalization->nameGrade }}</small><br>
          <small class="dates dates-green">{{ $legalization->address }}</small>
        </p>
      </td>
    </tr>
  </table>
  <hr>
  <p style="font-size: 12px; font-weight: bold;">Se relaciona a continuación la cartera pendiente de pago:</p>
  <hr>
  <table width="100%" class="table-striped text-center" style="text-align: center; font-size: 12px;" cellpadding="2">
    <thead>
      <tr>
        <th>FECHA</th>
        <th>CONCEPTO</th>
        <th>VALOR SIN IVA</th>
      </tr>
    </thead>
    <tbody>
      @php $countAll = 0; @endphp
      @for($i = 0; $i < count($concepts); $i++) <tr>
        <td>{{ returnDate($concepts[$i][1]) }}</td>
        <td>{{ $concepts[$i][2] }}</td>
        <td>$ {{ $concepts[$i][3] }}</td>
        </tr>
        @php $countAll += $concepts[$i][3]; @endphp
        @endfor
        <tr>
          <td colspan="2" style="text-align: right; margin-left: 10px;">
            TOTAL:
          </td>
          <td>
            $<b>{{ $countAll }}
          </td>
        </tr>
    </tbody>
  </table>
  <!-- </div> -->
</body>

</html>