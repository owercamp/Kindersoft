<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ucwords('ausencias')}}</title>
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
  </style>
</head>

<body>
  <header id="header">
    @if(config('app.name') == "Dream Home By Creatyvia")
    <img src="{{ asset('storage/garden/headerPdf.gif') }}" style="margin-top: -0.5cm;">
    @elseif(config('app.name') == "Colchildren Kindergarten")
    <img src="{{ asset('storage/garden/headerPdf.png') }}" style="margin-top: -0.11cm;">
    @else
    <img src="{{ asset('storage/garden/headerPdf.gif') }}" style="margin-top: -0.5cm;">
    @endif
  </header>
  <hr>
  <footer id="footer" style="text-align: center;">
    @if(config('app.name') == "Dream Home By Creatyvia")
    <div class=" border border-top border-primary w-100 bg-primary"></div>
    <p style="padding-top: 0.7cm; size: 50rem;">Contacto: <em class="text-primary">info@dreamhome.com.co</em></p>
    @elseif(config('app.name') == "Colchildren Kindergarten")
    <img src="{{ asset('storage/garden/footerPdf.png') }}">
    @else
    <div class=" border border-top border-primary w-100 bg-primary"></div>
    <p style="padding-top: 0.7cm; size: 50rem;">Contacto: <em class="text-primary">info@dreamhome.com.co</em></p>
    @endif
  </footer>
  <section>
    <div class="position-absolute text-center">
      <p class="text-primary mt-3">{{strtoupper('ausencias del dia '.$dateNow)}}</p>
    </div>
  </section>
  <main style="font-size: 15px; padding-top: 160px!important;">
    <div class="mx-3">
      <table class="table text-center table-striped w-100">
        <thead>
          <tr>
            <th>{{ucfirst('fecha')}}</th>
            <th>{{ucfirst('alumno')}}</th>
            <th>{{ucfirst('curso')}}</th>
            <th>{{ucwords('estado')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($registers as $item)
          <tr>
            <td>{{$item->pre_date}}</td>
            <td>{{$item->firstname}} {{$item->threename}} {{$item->fourname}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->pre_status_mail}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>