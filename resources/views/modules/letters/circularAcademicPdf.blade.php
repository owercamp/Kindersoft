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

    span {
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <header id="header">
      <img src="{{ asset('storage/garden/headerPdf.gif') }}" style="margin-top: 0.4cm;">
    </header>
    <br>
    <br>
    <div id="content-circular" style="width: 100%;">
      <br>
      <p style="text-align: center;"><b>CIRCULAR ACADEMICA</b></p>
      <br><br>
      <p><b>CIRCULAR N° </b><br>{{ $code }}</p>
      <p><b>FECHA: </b><br>{{ $date }}</p>
      <p><b>SEÑOR/ES:<br></b>
        {{ $to }}
      </p>
      <br><br>
      <p style="text-align: justify;">{{ $message }}</p>
      <br><br>
      <b>CORDIAL SALUDO,</b><br>
      @if (isset($from->firm))
      @if($from->firm != null)
      <small class="text-muted">FIRMA:</small><br>
      <img src="{{ asset('storage/firms/'.$from->firm) }}" style="width: 140px; height: auto;"><br>
      @else
      <h6 style="font-size: 12px;">SIN FIRMA</h6>
      @endif
      {{ $from->firstname . ' ' . $from->threename . ' ' . $from->fourname }} <br>
      {{ $from->position }}
      @endif
    </div>
    <footer id="footer" style="text-align: center;">
      <div class=" border border-top border-primary w-100 bg-primary"></div>
      <p style="padding-top: 0.7cm; size: 50rem;">Contacto: <em class="text-primary">info@dreamhome.com.co</em></p>
      <!-- <img src="{{ asset('storage/garden/footerPdf.png') }}"> -->
    </footer>
  </div>
</body>

</html>