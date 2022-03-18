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
      padding: 5px;
      /* color: #1807F9; */
      color: black;
      font-weight: bold;
    }

    .tbl-presents-pdf td {
      padding: 5px;
    }
  </style>
</head>

<body style="font-size: 12px; text-align: center;">
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
  case '01': return $day . ' DE ENERO DEL ' . $year; break;
  case '02': return $day . ' DE FEBRERO DEL ' . $year; break;
  case '03': return $day . ' DE MARZO DEL ' . $year; break;
  case '04': return $day . ' DE ABRIL DEL ' . $year; break;
  case '05': return $day . ' DE MAYO DEL ' . $year; break;
  case '06': return $day . ' DE JUNIO DEL ' . $year; break;
  case '07': return $day . ' DE JULIO DEL ' . $year; break;
  case '08': return $day . ' DE AGOSTO DEL ' . $year; break;
  case '09': return $day . ' DE SEPTIEMBRE DEL ' . $year; break;
  case '10': return $day . ' DE OCTUBRE DEL ' . $year; break;
  case '11': return $day . ' DE NOVIEMBRE DEL ' . $year; break;
  case '12': return $day . ' DE DICIEMBRE DEL ' . $year; break;
  }
  }
  @endphp
  <h4>{{ $garden->garReasonsocial }}</h4>
  <h5>INFORME DE NOVEDADES DIARIAS</h5>
  <h6>{{ returnDate($date) }}</h6>
  <br>
  <hr>
  <br>
  <div style="width: 100%; border: 1px solid #ccc; padding: 20px; text-align: left;">
    <p class="titles">INFORME DE ASISTENCIAS:</p>
    <table class="tbl-presents-pdf" border="1" width="100%" style="text-align: center;">
      <thead>
        <tr>
          <th>ALUMNO</th>
          <th>GRADO</th>
          <th>LLEGADA</th>
          <th>SALIDA</th>
        </tr>
      </thead>
      <tbody>
        @php $travel = 0; @endphp
        @for($i = 0; $i < count($consolidated); $i++) 
          @if($consolidated[$i][0]=='ASISTENCIA' ) 
            @if($consolidated[$i][2] <=0) <tr>
              <td colspan="4">
                NO HAY REGISTROS DE ASISTENCIAS {{ $consolidated[$i][2] }}<br>
              </td>
              </tr>
            @else
              <tr>
                <td>{{$consolidated[$i][3]}}</td>
                <td>{{$consolidated[$i][1]}}</td>
                <td>{{$consolidated[$i][4]}}</td>
                <td>{{$consolidated[$i][5]}}</td>
              </tr>
              @php $travel++ @endphp
            @endif
          @endif
        @endfor
      </tbody>
    </table>
  </div>
  <div style="width: 100%; border: 1px solid #ccc; padding: 20px; text-align: left;">
    <p class="titles">INFORME DE INASISTENCIAS:</p>
    <ol>
      @php $travel = 0; @endphp
      @for($i = 0; $i < count($consolidated); $i++) @if($consolidated[$i][0]=='INASISTENCIA' ) @if($consolidated[$i][2]=='SIN REGISTROS' ) <h6 style="font-weight: bold; display: block; width: 100%; height: 30px; background-color: #D4D210;">NO HAY REGISTROS DE INASISTENCIAS</h6>
        @else
        <li>{{ $consolidated[$i][2] }} <b>Curso: </b>{{ $consolidated[$i][1] }}</li>
        @php $travel++ @endphp
        @endif
        @endif
        @endfor
    </ol>
  </div>
  <div style="width: 100%; border: 1px solid #ccc; padding: 20px; text-align: center;">
    <p class="titles">INFORME DE NOVEDADES:</p>
    @for($i = $travel; $i < count($consolidated); $i++) @if($consolidated[$i][0]=='DETALLES' ) @if($consolidated[$i][2] !='SIN REGISTROS' ) <table width="100%" class="text-center" style="border-collapse: collapse;">
      <thead>
        <tr>
          <th colspan="2" style="background: #ccc;">{{ $consolidated[$i][1] }}</th>
        </tr>
      </thead>
      <tbody>
        @for($n = 0; $n < count($consolidated[$i][2]); $n++) <tr>
          <td style="border: 1px solid #ddf; width: 50%;">{{ $consolidated[$i][2][$n][0] }}</td>
          <td style="border: 1px solid #ddf; width: 50%;">{{ $consolidated[$i][2][$n][1] }}</td>
          </tr>
          @endfor
      </tbody>
      </table>
      @endif
      @endif
      @endfor
      <hr>
      <p class="titles">INFORME DE EVENTOS CERRADOS:</p>
      <table width="100%" class="text-center" style="border-collapse: collapse;">
        <thead>
          <tr>
            <th>TIPO DE EVENTO</th>
            <th>EVENTO</th>
            <th>OBSERVACION</th>
          </tr>
        </thead>
        <tbody>
          @php $rowEvents = 0; @endphp
          @for($n = 0; $n < count($consolidated); $n++) @if($consolidated[$n][0]=='EVENTOS' ) <tr style="padding: 20px; font-size: 10px; text-align: center;">
            <td style="border: 1px solid #ddf; width: 50%;">{{ $consolidated[$n][1] }}</td>
            <td style="border: 1px solid #ddf; width: 50%;">{{ $consolidated[$n][2] }}</td>
            <td style="border: 1px solid #ddf; width: 50%;">{{ $consolidated[$n][3] }}</td>
            </tr>
            @php $rowEvents += 1; @endphp
            @endif
            @endfor
            @if($rowEvents <= 0) <tr style="padding: 20px; font-size: 10px; text-align: center;">
              <td colspan="3">NO HAY EVENTOS CERRADOS EN LA FECHA</td>
              </tr>
              @endif
              }
        </tbody>
      </table>
  </div>
</body>

</html>