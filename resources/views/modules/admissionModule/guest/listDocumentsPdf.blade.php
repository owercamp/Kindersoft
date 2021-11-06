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

    * {
      font-family: sans-serif;
      text-align: center;
    }

    table td {
      padding: 5px;
      border-bottom: 1px solid #ccc;
    }

    table thead {
      background-color: #ccc;
      color: white;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <header id="header">
      <img src="{{ asset('storage/garden/headerPdf.png') }}">
    </header>
    <hr>
    <div class="row" style="width: 100%;">
      <div class="col-md-12" style="width: 100%;">
        <h6>LISTA DE DOCUMENTOS REQUERIDOS PARA LEGALIZACION DE MATRICULA</h6>
        <hr>
        <table width="100%" style="text-align: center; font-size: 13px;">
          <thead>
            <tr>
              <th>ITEM</th>
              <th>NOMBRE</th>
              <th>ESTADO</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($documents as $document)
            <tr>
              <td>{{ $document->dePosition }}</td>
              <td>{{ $document->deConcept }}</td>
              <td>
                @if($document->deRequired == 'SI')
                {{ __('OBLIGATORIO') }}
                @else
                {{ __('OPCIONAL') }}
                @endif
              </td>
              <td>
                <input type="checkbox">
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <hr>
      </div>
    </div>
    <footer id="footer">
      <img src="{{ asset('storage/garden/footerPdf.png') }}">
    </footer>
  </div>
</body>

</html>