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
      left: 0px;
      top: -150px;
      right: 0px;
      height: 150px;
      text-align: center;
      overflow-y: hidden;
    }

    /*footer {
                width: 100%;
                position: fixed;
                left: 0px;
                bottom: -180px;
                right: 0px;
                height: 150px;
                text-align: center;
                overflow-y: hidden;
            }

            footer .page:after {
                content: counter(page, upper-roman);
            }*/
    table td {
      border: 1px solid #ccc;
      text-align: center;
      vertical-align: middle;
      font-weight: bold;
    }

    .table-first td {
      border: none;
    }
  </style>
</head>

<body>
  <!-- 
            $datehead           // ARRAY
            $collaborator       // CADENA
            $allfacturations    // ARRAY
            $countfacturations  // ENTERO
            $totalFactures      // ENTERO
         -->
  <header>
    <table width="100%" class="table-first">
      <tr>
        <td class="text-right"><small class="text-muted text-right"><b>CURSO </b></small></td>
        <td class="text-left">
          <small class="text-muted text-left">{{ $datehead->nameCourse }}</small>
        </td>
        <td colspan="2" class="text-right">
          @php $year = date('Y'); @endphp
          <h6 class="text-muted text-right"><b>REPORTE DE CARTERA INDIVIDUAL</b></h6>
        </td>
      </tr>
      <tr>
        <td class="text-right"><small class="text-muted text-right"><b>GRADO </b></small></td>
        <td class="text-left">
          <small class="text-muted text-left">{{ $datehead->nameGrade }}</small>
        </td>
        <td colspan="2" class="text-right">
          @php $datenow = date('Y-m-d'); @endphp
          <h6 class="text-muted text-right"><b>{{ $datenow }}</b></h6>
        </td>
      </tr>
      <tr>
        <td class="text-right"><small class="text-muted text-right"><b>DIRECTOR DE GRUPO </b></small></td>
        <td class="text-left">
          <small class="text-muted text-left">{{ $collaborator->nameCollaborator }}</small>
        </td>
        <td colspan="2" rowspan="3">
          <!-- Imagen -->
        </td>
      </tr>
      <tr>
        <td class="text-right"><small class="text-muted text-right"><b>NOMBRE DE ALUMN@ </b></small></td>
        <td class="text-left">
          <small class="text-muted text-left">{{ $datehead->nameStudent }}</small>
        </td>
      </tr>
      <tr>
        <td class="text-right"><small class="text-muted text-right"><b>NOMBRE DE ACUDIENTE </b></small></td>
        <td class="text-left">
          <small class="text-muted text-left">{{ $datehead->nameAttendant }}</small>
        </td>
      </tr>
    </table>
  </header>

  <hr>

  <table width="100%">
    <tr>
      <td colspan="3" style="border-top: none; border-left: none;"></td>
      <td colspan="4" rowspan="2" class="text-center">
        <h6 class="text-muted text-center"><b>$ {{ $datehead->waMoney }}</b></h6> <!-- Valor de saldo -->
        <h6 class="text-muted text-center"><b>{{ $datehead->waStatus }}</b></h6> <!-- Estado de saldo -->
      </td>
      <td colspan="3" style="border-top: none; border-right: none;"></td>
    </tr>
    <tr>
      <td colspan="3" style="border-top: none; border-left: none;"></td>
      <td colspan="3" style="border-top: none; border-right: none;"></td>
    </tr>
    <tr>
      <td colspan="5">
        <small class="text-muted text-right"><b>CANTIDAD DE FACTURAS</b></small>
      </td>
      <td colspan="5">
        <small class="text-muted text-right"><b>$ TOTAL DE FACTURAS</b></small>
      </td>
    </tr>
    <tr>
      <td colspan="5">
        <small class="text-muted text-right"><b>{{ $countfacturations }}</b></small>
      </td>
      <td colspan="5">
        <small class="text-muted text-right"><b>$ {{ $totalFactures }}</b></small>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <small class="text-muted text-right"><b>CODIGO</b></small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right"><b>VALOR</b></small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right"><b>FECHA DE EMISION</b></small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right"><b>ESTADO</b></small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right"><b>ORIGEN</b></small>
      </td>
    </tr>
    @php $count = 0; @endphp
    @for( $f = 0 ; $f < count($allfacturations) ; $f++ ) <tr>
      <td colspan="2">
        <small class="text-muted text-right">
          {{ $allfacturations[$f][0] }}
        </small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right">
          {{ $allfacturations[$f][1] }}
        </small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right">
          {{ $allfacturations[$f][2] }}
        </small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right">
          {{ $allfacturations[$f][3] }}
        </small>
      </td>
      <td colspan="2">
        <small class="text-muted text-right">
          {{ $allfacturations[$f][4] }}
        </small>
      </td>
      </tr>
      @php $count++; @endphp
      @endfor
      @if($count == 0)
      <tr>
        <td colspan="10" class="text-center">
          <small class="text-muted text-center"><b>SIN FACTURAS</b></small>
        </td>
      </tr>
      @endif
  </table>
</body>

</html>