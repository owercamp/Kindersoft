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
      left: 0;
      top: -180px;
      right: 0;
      height: 150px;
      text-align: center;
      overflow-y: hidden;
      border-bottom: 1px solid #fd8701;
    }

    header>section {
      position: absolute;
      top: 0;
      z-index: 4;
    }

    header .page:before {
      content: counter(page, upper-roman);
    }

    footer {
      width: 100%;
      position: fixed;
      left: 0px;
      bottom: -180px;
      right: 0px;
      height: 150px;
      text-align: center;
      overflow-y: hidden;
      border-top: 1px solid #fd8701;
    }

    footer>section {
      position: absolute;
      top: 0;
      z-index: 4;
    }

    footer .page:after {
      content: counter(page, upper-roman);
    }

    header .forms {
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 3;
    }

    header .figure {
      width: 300px;
      height: 110px;
      position: absolute;
    }

    header .figure-green {
      background: #a4b068;
      border-radius: 0px 0px 100px 0px;
      left: -50px;
      top: 0;
      z-index: 2;
    }

    header .figure-orange {
      background: #fd8701;
      border-radius: 0px 0px 100px 0px;
      left: 100;
      top: -20px;
      z-index: 1;
    }

    header .figure-blue {
      background: #0086f9;
      border-radius: 0px 0px 100px 0px;
      left: 300px;
      top: -50px;
      z-index: 0;
    }

    footer .forms {
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 3;
    }

    footer .figure {
      width: 300px;
      height: 110px;
      position: absolute;
    }

    footer .figure-green {
      background: #a4b068;
      border-radius: 100px 0px 0px 0px;
      right: -50px;
      bottom: 0;
      z-index: 2;
    }

    footer .figure-orange {
      background: #fd8701;
      border-radius: 100px 0px 0px 0px;
      right: 100;
      bottom: -20px;
      z-index: 1;
    }

    footer .figure-blue {
      background: #0086f9;
      border-radius: 100px 0px 0px 0px;
      right: 300px;
      bottom: -50px;
      z-index: 0;
    }

    header .figure-green-lateral {
      width: 60px;
      height: 1100px;
      background: #a4b068;
      top: 0;
      left: -70px;
    }

    .img-back {
      width: 250px;
      height: auto;
      align-self: center;
      margin-left: auto;
      margin-right: auto;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      -webkit-transform: translate(-50%, -50%);
      z-index: 1;
      opacity: 0.3;
    }

    #content-circular {
      margin-top: auto;
      margin-bottom: auto;
      position: absolute;
      top: 0;
      bottom: 0;
      padding: 30px;
    }

    #content-circular>p {
      display: block;
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <header>
      <div class="forms">
        <div class="figure figure-green"></div>
        <div class="figure figure-orange"></div>
        <div class="figure figure-blue"></div>
        <div class="figure figure-green-lateral"></div>
      </div>
      <section style="width: 100%;">
        @if(isset($garden))
        <div class="text-left" style="width: 50%; float: left; margin-top: 120px;">
          <small class="text-muted"><b><span>REPRESENTANTE: {{ $garden->garNamerepresentative }}</span></b></small><br>
          <small class="text-muted"><b><span>C.C {{ $garden->garCardrepresentative }}</span></b></small>
        </div>
        <div class="text-right" style="width: 50%; float: left; padding-top: 10px">
          @if(file_exists('storage/garden/logo.png'))
          <img src="{{ asset('storage/garden/logo.png') }}" style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany">
          @else
          @if(file_exists('storage/garden/logo.jpg'))
          <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany">
          @else
          <img src="{{ asset('storage/garden/default.png') }}" style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany">
          @endif
          @endif
          <br>
          <small class="text-muted"><b><span>{{ $garden->garNamecomercial }} </span></b></small><br>
          <small class="text-muted"><b>NIT. </b><span>{{ $garden->garNit }}</span></small>
        </div>
        @endif
      </section>
    </header>

    <div id="content-circular" style="width: 100%;">
      @if(asset('storage/garden/logo.png'))
      <img class="img-back" src="{{ asset('storage/garden/logo.png') }}">
      @else
      @if(asset('storage/garden/logo.jpg'))
      <img class="img-back" src="{{ asset('storage/garden/logo.jpg') }}">
      @else
      <img class="img-back" src="{{ asset('storage/garden/default.png') }}">
      @endif
      @endif
      <p style="text-align: center;"><b>MEMORANDO INTERNO</b></p>
      <p><b>MEMORANDO N° </b>{{ $code }}</p>
      <p><b>FECHA: </b>{{ $date }}</p>
      <p><b>SEÑOR/ES: </b>
        {{ $to }}
      </p>
      <br>
      <p style="text-align: justify;">{{ $message }}</p>
      <br>
      <p><b>CORDIAL SALUDO,</b><br>
        {{ $from }}
      </p>
    </div>

    <footer>
      <div class="forms">
        <div class="figure figure-green"></div>
        <div class="figure figure-orange"></div>
        <div class="figure figure-blue"></div>
      </div>
      <section style="width: 100%;">
        <div class="text-left" style="width: 100%; float: left; margin: 10px;">
          @if(isset($garden))
          <small class="text-muted" style="margin-left: 30px; margin-top: 60px;">
            <img style="width: 20px; height: 20px;" src="{{ asset('img/ciudadinfo.png') }}">
            <span style="font-size: 10px; padding-bottom: 10px;"> {{ $garden->garAddress . ' ' . $garden->garNameCity . ' - ' . $garden->garNameLocation . ' - ' . $garden->garNameDistrict }} </span>
            <img style="width: 20px; height: 20px;" src="{{ asset('img/telefonoinfo.png') }}">
            <span style="font-size: 10px; padding-bottom: 10px;"> {{ $garden->garPhoneone . ' - ' . $garden->garPhonetwo . ' - ' . $garden->garPhonethree }} </span>
            <img style="width: 20px; height: 20px;" src="{{ asset('img/celularinfo.png') }}">
            <span style="font-size: 10px; padding-bottom: 10px;"> {{ $garden->garPhone }} </span>
            <img style="width: 20px; height: 20px;" src="{{ asset('img/whatsappinfo.png') }}">
            <span style="font-size: 10px; padding-bottom: 10px;"> {{ $garden->garWhatsapp }} </span>
          </small>
          <br>
          <small class="text-muted" style="margin-left: 30px; margin-top: 60px;">
            <img style="width: 20px; height: 20px;" src="{{ asset('img/correoinfo.png') }}">
            <span style="font-size: 15px; padding-bottom: 10px;"> {{ $garden->garMailone }} <br> {{ $garden->garMailtwo }} </span>
          </small>
          <br>
          <small style="color: #fff;"><b><span style="font-size: 15px; padding-bottom: 10px; position: absolute; right: 2px; bottom: 5px;">{{ $garden->garWebsite }}</span></b></small><br>
          <small style="color: #fff;"><b><span style="font-size: 15px; padding-bottom: 10px; position: absolute; right: 2px; bottom: 20px;">{{ $garden->garReasonsocial }}</span></b></small><br>
          @endif
        </div>
      </section>
    </footer>
  </div>
</body>
<!-- <body style="width: 100%;">
        <img src="{{ asset('img/first_bulletin.png') }}">
        <p style="text-align: center;"><b>MEMORANDO INTERNO</b></p>
        <p><b>MEMORANDO N° </b>{{ $code }}</p>
        <p><b>FECHA: </b>{{ $date }}</p>
        <p><b>SEÑOR/ES: </b>
            {{ $to }}
        </p>
        <p style="text-align: justify;">{{ $message }}</p>
        <p><b>CORDIAL SALUDO,</b><br>
            {{ $from }}
        </p>
    </body> -->

</html>