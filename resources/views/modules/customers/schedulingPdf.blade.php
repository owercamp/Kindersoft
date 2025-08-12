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
      margin: 150px 50px;
    }

    #header {
      position: fixed;
      top: -150px;
      height: 100px;
      background-color: transparent;
      text-align: center;
    }

    #footer {
      position: fixed;
      bottom: -100;
      height: 70px;
      background-color: transparent;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <header id="header">
      <img src="{{ asset('storage/garden/headerPdf.png') }}">
    </header>
    <br><br>
    <div class="row">
      <div class="col-md-12 content-schudeling">
        <h3>GRAFICA DE AGENDAMIENTOS - AÑO {{ $year }}</h3>
        <img src="{{ $view }}" alt="GRAFICA DE AGENDAMIENTOS - AÑO {{ $year }}">
      </div>
    </div>
    <div class="row border-top mt-10">
      <div class="col-md-12">
        <table class="text-center border-top m-4 p-3" style="border: 2px solid #ccc; border-collapse: collapse; width: 100%;">
          <thead>
            <tr>
              <th></th>
              <!-- <th>TOTAL</th> -->
              <th style="padding: 3px;">PENDIENTES</th>
              <th style="padding: 3px;">ASISTIDAS</th>
              <th style="padding: 3px;">INASISTIDAS</th>
            </tr>
          </thead>
          <tbody>
            @for($i = 1;$i <= 12;$i++) <tr style="padding: 2px; border-bottom: solid;">
              @if($i == '1') <th>ENERO</th> @endif
              @if($i == '2') <th>FEBRERO</th> @endif
              @if($i == '3') <th>MARZO</th> @endif
              @if($i == '4') <th>ABRIL</th> @endif
              @if($i == '5') <th>MAYO</th> @endif
              @if($i == '6') <th>JUNIO</th> @endif
              @if($i == '7') <th>JULIO</th> @endif
              @if($i == '8') <th>AGOSTO</th> @endif
              @if($i == '9') <th>SEPTIEMBRE</th> @endif
              @if($i == '10') <th>OCTUBRE</th> @endif
              @if($i == '11') <th>NOVIEMBRE</th> @endif
              @if($i == '12') <th>DICIEMBRE</th> @endif
              <!-- <td>{{ $statistic[$i][0] }}</td> -->
              <td>{{ $statistic[$i][0] }}</td>
              <td>{{ $statistic[$i][1] }}</td>
              <td>{{ $statistic[$i][2] }}</td>
              </tr>
              @endfor
          </tbody>
        </table>
      </div>
    </div>
    <footer id="footer">
      <img src="{{ asset('storage/garden/footerPdf.png') }}">
    </footer>
  </div>
</body>

</html>