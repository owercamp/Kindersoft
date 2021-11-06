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
      margin: 180px 50px;
    }

    header {
      width: 100%;
      position: fixed;
      top: -130px;
      left: 0;
      right: 0;
      text-align: left;
      padding: 5px;
    }

    .info {
      padding: 5px;
    }

    table {
      width: 100%;
      text-align: center;
    }

    table tr:first-child {
      background-color: #ccc;
    }

    table tr {
      padding: 2px;
    }
  </style>
</head>

<body>
  <hr>
  <header>
    <div style="width: 50%; float: left;">
      @if($collaborator->gender == 'FEMENINO')
      <small class="text-muted">DIRECTORA DE GRUPO</small><br>
      <span class="info">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</span><br>
      @else
      <small class="text-muted">DIRECTOR DE GRUPO</small><br>
      <span class="info">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</span><br>
      @endif
      <small class="text-muted">CANTIDAD DE ALUMNOS:</small><br>
      <span class="info">{{ count($students) }}</span>
    </div>
    <div style="width: 50%; float: right;">
      <small class="text-muted">GRADO:</small><br>
      <span class="info">{{ $grade->name }}</span><br>
      <small class="text-muted">CURSO:</small><br>
      <span class="info">{{ $course->name }}</span><br>
    </div>
  </header>
  <hr>
  <table class="table-striped text-center" width="100%" style="font-size: 10px;">
    <thead>
      <tr>
        <th>#</th>
        <th>IDENTIFICACION</th>
        <th>NOMBRES</th>
        <th>APELLIDOS</th>
        <th>EDAD ACTUAL</th>
        <th>FECHA DE NACIMIENTO</th>
      </tr>
    </thead>
    <tbody>
      @php
      $row = 1;
      function getStringDate($date){
      $separatedDate = explode('-',$date);
      switch($separatedDate[1]){
      case '01': return $separatedDate[2] . '-ENERO-' . $separatedDate[0]; break;
      case '02': return $separatedDate[2] . '-FEBRERO-' . $separatedDate[0]; break;
      case '03': return $separatedDate[2] . '-MARZO-' . $separatedDate[0]; break;
      case '04': return $separatedDate[2] . '-ABRIL-' . $separatedDate[0]; break;
      case '05': return $separatedDate[2] . '-MAYO-' . $separatedDate[0]; break;
      case '06': return $separatedDate[2] . '-JUNIO-' . $separatedDate[0]; break;
      case '07': return $separatedDate[2] . '-JULIO-' . $separatedDate[0]; break;
      case '08': return $separatedDate[2] . '-AGOSTO-' . $separatedDate[0]; break;
      case '09': return $separatedDate[2] . '-SEPTIEMBRE-' . $separatedDate[0]; break;
      case '10': return $separatedDate[2] . '-OCTUBRE-' . $separatedDate[0]; break;
      case '11': return $separatedDate[2] . '-NOVIEMBRE-' . $separatedDate[0]; break;
      case '12': return $separatedDate[2] . '-DICIEMBRE-' . $separatedDate[0]; break;
      }
      }

      function converterYearsoldFromBirtdate($date){
      $values = explode('-',$date);
      $day = $values[2];
      $mount = $values[1];
      $year = $values[0];
      $yearNow = Date('Y');
      $mountNow = Date('m');
      $dayNow = Date('d');
      //Cálculo de años
      $old = ($yearNow + 1900) - $year;
      if ( $mountNow < $mount ){ $old--; } if ($mount==$mountNow && $dayNow <$day){ $old--; } if ($old> 1900){ $old -= 1900; }
        //Cálculo de meses
        $mounts=0;
        if($mountNow>$mount && $day > $dayNow){ $mounts=($mountNow-$mount)-1; }
        else if ($mountNow > $mount){ $mounts=$mountNow-$mount; }
        else if($mountNow<$mount && $day < $dayNow){ $mounts=12-($mount-$mountNow); } else if($mountNow<$mount){ $mounts=12-($mount-$mountNow+1); } if($mountNow==$mount && $day>$dayNow){ $mounts=11; }
          $processed = $old . '-' . $mounts;
          return $processed;
          }

          function getYearsold($yearsold){
          $len = strlen($yearsold);
          if($len < 5 & $len> 0){
            $separated = explode('-',$yearsold);
            $mounts = ($separated[1]>1 ? $separated[1] . ' meses' : $separated[1] . ' mes');
            return $separated[0] . ' años ' . $mounts;
            }else{
            return $yearsold;
            }
            }
            @endphp
            @for($i = 0;$i < count($students);$i++) <tr>
              <td>{{ $row++ }}<span hidden>{{ $students[$i][0] }}</span></td>
              <td>{{ $students[$i][2] }}</td>
              <td>{{ $students[$i][3] }}</td>
              <td>{{ $students[$i][4] }}</td>
              <td>{{ getYearsold(converterYearsoldFromBirtdate($students[$i][6])) }}</td>
              <td>{{ getStringDate($students[$i][6]) }}</td>
              </tr>
              @endfor
    </tbody>
  </table>
</body>

</html>