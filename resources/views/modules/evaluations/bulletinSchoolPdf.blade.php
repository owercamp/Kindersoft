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

    * {
      padding: 0;
      text-align: center;
    }

    section {
      width: 100%;
    }

    article {
      display: inline-block;
      text-align: center;
    }

    table td {}

    .titles-table-intelligence {
      background: rgb(255, 242, 204);
      color: #000;
      font-weight: bold;
      border-color: #000;
    }

    .titles-table-results {
      background: rgb(255, 242, 204);
      color: rgb(237, 125, 49);
      font-size: 20px;
      font-weight: bold;
      border-color: #000;
    }

    .numbers {
      color: rgb(250, 125, 0);
      font-weight: bold;
      border-color: #000;
    }
  </style>
</head>

<body>
  @php
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

        function getFormatDate($date){
        $separatedDate = explode('-',$date);
        switch($separatedDate[1]){
        case '01': return 'Enero ' . $separatedDate[2]; break;
        case '02': return 'Febrero ' . $separatedDate[2]; break;
        case '03': return 'Marzo ' . $separatedDate[2]; break;
        case '04': return 'Abril ' . $separatedDate[2]; break;
        case '05': return 'Mayo ' . $separatedDate[2]; break;
        case '06': return 'Junio ' . $separatedDate[2]; break;
        case '07': return 'Julio ' . $separatedDate[2]; break;
        case '08': return 'Agosto ' . $separatedDate[2]; break;
        case '09': return 'Septiembre ' . $separatedDate[2]; break;
        case '10': return 'Octubre ' . $separatedDate[2]; break;
        case '11': return 'Noviembre ' . $separatedDate[2]; break;
        case '12': return 'Diciembre ' . $separatedDate[2]; break;
        }
        }
        @endphp
        <table width="100%" style="text-align: center;">
          <tr>
            <td style="width: 25%;">
              @if(file_exists('storage/garden/logo.png'))
              <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/logo.png') }}">
              @else
              @if(file_exists('storage/garden/logo.jpg'))
              <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/logo.jpg') }}">
              @else
              <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/default.png') }}">
              @endif
              @endif
            </td>
            <td style="width: 75%; font-family: 'Arial Black', 'Arial Bold'; font-size: 20px; font-weight: bold; color: rgb(0,32,96);">
              <h4>BOLETIN ESCOLAR</h4>
              @php
              $letter = substr($course->name,-1);
              $year = substr($period->apDateInitial, 0, 4);
              @endphp
              <h4>{{ $period->apNameperiod }} - CALENDARIO {{ $letter }}</h4>
              <h4>{{ $year }}</h4>
            </td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr>
            <td rowspan="4" style="background: #ccc;" nowrap>
              <p style="transform: rotate(-90deg); color: #fff; font-weight: bold;">ALUMNO</p>
            </td>
            <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">CURSO</td>
            <td nowrap style="font-size: 15px font-weight: bold;">{{ $course->name }}</td>
            <td nowrap rowspan="4" style="align-items: center; border: none;">
              @if(asset('storage/students/' . $student->photo))
              <img style="width: 80px; height: auto;" src="{{ asset('storage/students/'.$student->photo) }}">
              @else
              <img style="width: 80px; height: auto;" src="{{ asset('storage/students/default.png') }}">
              @endif
            </td>
          </tr>
          <tr>
            <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">NOMBRE</td>
            <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;">{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</td>
          </tr>
          <tr>
            <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">EDAD</td>
            <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;"><b class="yearsstudent">{{ getYearsold(converterYearsoldFromBirtdate($student->birthdate)) }}</b></td>
          </tr>
          <tr>
            <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">FECHA</td>
            <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;">{{ getFormatDate($period->apDateInitial) }} a {{ getFormatDate($period->apDateFinal) }}</td>
          </tr>
        </table>
        <hr>
        @for($i = 0; $i < count($observationsPeriod); $i++) <section>
          <table width="100%" border="1" style="font-size: 11px; margin-top: 10px;">
            <thead>
              <tr>
                <th class="titles-table-intelligence" colspan="2" style="width: 80px;">INTELIGENCIA</th>
                <th class="titles-table-intelligence">OBSERVACIONES</th>
              </tr>
            </thead>
            @php $row = 1; $validateOther = false; @endphp
            <tbody>
              @if($observationsPeriod[$i][1] != 'N/A')
              @for($a = 0; $a < count($observationsPeriod[$i][1]); $a++) <tr>
                @if(!$validateOther)
                <td rowspan="{{ count($observationsPeriod[$i][1]) }}" class="titles-table-intelligence" style="overflow: hidden; width: 10px; padding-top: 5px;" nowrap="false">
                  @php $len = strlen($observationsPeriod[$i][0]); @endphp
                  @if($len > 10)
                  @php $separatedSpace = explode(' ',$observationsPeriod[$i][0]); @endphp
                  @if(count($separatedSpace) > 1)
                  <p style="transform: rotate(-90deg);">
                    {{ $separatedSpace[0] }}
                    <br>
                    {{ $separatedSpace[1] }}
                  </p>
                  @else
                  <p style="transform: rotate(-90deg);">
                    {{ $observationsPeriod[$i][0] }}
                  </p>
                  @endif
                  @else
                  <p style="transform: rotate(-90deg);">
                    {{ $observationsPeriod[$i][0] }}
                  </p>
                  @endif
                  @php $validateOther = true; @endphp
                </td>
                @endif
                @if($row%2 == 0)
                <td nowrap style="width: 20px; background: rgb(217,217,217);" class="numbers">{{ $observationsPeriod[$i][1][$a][0] }}</td>
                <td nowrap style="text-align: left; padding-left: 5px; background: rgb(217,217,217);">{{ $observationsPeriod[$i][1][$a][1] }}</td>
                @else
                <td nowrap style="width: 20px;" class="numbers">{{ $observationsPeriod[$i][1][$a][0] }}</td>
                <td nowrap style="text-align: left; padding-left: 5px;">{{ $observationsPeriod[$i][1][$a][1] }}</td>
                @endif
                </tr>
                @endfor
                @else
                <tr>
                  <td colspan="2" class="titles-table-intelligence" style="width: 20px;">
                    {{ $observationsPeriod[$i][0] }}
                  </td>
                  <td style="width: 20px;">
                    No hay observaciones
                  </td>
                </tr>
                @endif
            </tbody>
          </table>
          </section>
          @endfor
          <table width="100%" style="margin-top: 10px;">
            <thead>
              <tr>
                <td nowrap colspan="2" class="titles-table-results" style="border-right: none; text-align: center;">
                  CONGRATULATION
                </td>
                <td nowrap colspan="2" class="titles-table-results" style="border-left: none; text-align: center;">
                  {{ $student->firstname }} !!!
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border-right: none; text-align: center; font-size: 12px; font-weight: bold; padding-top: 5px;">
                  {{ $garden->garNamerepresentative }}
                  <br>
                  <p style="font-weight: normal;">DIRECTORA</p>
                </td>
                <td colspan="2" style="border-left: none; text-align: center; font-size: 12px; font-weight: bold; padding-top: 5px;">
                  {{ $collaborator->nameCollaborator }}
                  <br>
                  <p style="font-weight: normal;">TITULAR DE GRUPO</p>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border-right: none; text-align: center;">
                  @if(asset('storage/garden/logo.png'))
                  <img style="width: 90px; height: auto; margin-left: 10px; margin-top: 10px;" src="{{ asset('storage/garden/logo.png') }}">
                  @else
                  @if(asset('storage/garden/logo.jpg'))
                  <img style="width: 100px; height: auto; margin-left: 10px;" src="{{ asset('storage/garden/logo.jpg') }}">
                  @else
                  <img style="width: 100px; height: auto; margin-left: 10px;" src="{{ asset('storage/garden/default.png') }}">
                  @endif
                  @endif
                </td>
                <td></td>
                <td style="border-left: none; text-align: center; text-align: left;">
                  Recibimos, <br><br>

                  ____________________________
                </td>
              </tr>
            </thead>
          </table>

          <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
          <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

          <script>
          </script>
</body>

</html>