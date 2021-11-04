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
      margin: 100px 25px;
    }

    header {
      position: fixed;
      top: -60px;
      left: 0px;
      right: 0px;
      height: 9rem;

      /** Extra personal styles **/
      background-color: #03a9f4;
      color: white;
      text-align: center;
      line-height: 35px;
    }

    footer {
      position: fixed;
      bottom: -60px;
      left: 0px;
      right: 0px;
      height: 50px;
    }

    section {
      position: relative;
      margin-top: 60px;
    }

    .bg-primary-50 {
      background: rgba(0, 123, 255, 0.72);
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <header id="header">
      @if(config('app.name') == "Dream Home By Creatyvia")
      <img src="{{ asset('storage/garden/headerPdf.gif') }}" style="margin-top: -0.5cm;">
      @elseif(config('app.name') == "Colchildren Kindergarten")
      <img src="{{ asset('storage/garden/headerPdf.png') }}" style="margin-top: -0.11cm;">
      @endif
    </header>
    <hr>
    <footer id="footer" style="text-align: center;">
      @if(config('app.name') == "Dream Home By Creatyvia")
      <div class=" border border-top border-primary w-100 bg-primary"></div>
      <p style="padding-top: 0.7cm; size: 50rem;">Contacto: <em class="text-primary">info@dreamhome.com.co</em></p>
      @elseif(config('app.name') == "Colchildren Kindergarten")
      <img src="{{ asset('storage/garden/footerPdf.png') }}">
      @endif
    </footer>
    <section>
      <div class="position-absolute text-center">
        <p class="text-primary mt-3">{{strtoupper('facturaciones canceladas')}}</p>
        <p>{{$initial." al ".$final}}</p>
      </div>
    </section>
    <main style="font-size: 15px; padding-top: 160px!important;">
      <table class="table table-striped text-center">
        <thead class="bg-primary-50 text-white">
          <tr>
            <th>{{ucwords('factura n°')}}</th>
            <th>{{ucwords('nombre alumno')}}</th>
            <th>{{ucwords('argumento legalización')}}</th>
            <th>{{ucwords('valor')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $item)
          <tr>
            <td class="align-middle">{{$item->facCode}}</td>
            <td class="align-middle">{{$item->firstname." ".$item->threename." ".$item->fourname}}</td>
            <td class="align-middle">{{$item->legArgument}}</td>
            <td class="align-middle">{{number_format($item->facValue,0,',','.')}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th class="text-right text-primary">{{ucfirst('total')}}</th>
            <th>{{number_format($priceTotal,0,',','.')}}</th>
          </tr>
        </tfoot>
      </table>
    </main>
  </div>
</body>

</html>