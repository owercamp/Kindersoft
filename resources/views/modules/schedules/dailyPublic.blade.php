<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('img/shortlogo.gif') }}" />

  <title>{{ config('app.name', 'Colchildren') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
  <style>
    .full-screen-image {
      background-image: url('img/fondo.svg');
      background-size: auto;
      background-color: #2927f512;
      background-position-x: center;
      background-position-y: top;
      height: 100%;
      background-repeat: no-repeat;
    }

    svg {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    path {
      fill: none;
    }

    .text-lobster {
      font-family: 'Itim', cursive;
      fill: #000;
      text-anchor: middle;
    }
  </style>
</head>

<body class="full-screen-image">
  <main class="container" style="border: 1px solid #ccc; border-top: none; border-bottom: none;">
    <div style="width: 1140px; height: 300px;">
      <svg viewBox="0 0 100 150" style="width: 100%; height: 100%;">
        <path id="curve" d="M 13 80 Q 95 15 180 87" />
        <text x="-10" y="-34" font-size="7" class="text-lobster">
          <textPath xlink:href="#curve" startOffset="55px">
            {{ config('app.name') }}
          </textPath>
        </text>
      </svg>
    </div>
    <div class="container p-5 text-center text-capitalize text-lobster" style="margin-top: -7%; position: absolute; font-size: x-large;">
      estudiante
    </div>
    <div class="container">
      <div class="w-50">

      </div>
      <div class="w-50">
        <div class="input-group input-group-sm mb-3 w-75">
          <div class="input-group-prepend">
            <span class="input-group-text" id="Nuip">NUIP</span>
          </div>
          <input type="text" class="form-control" aria-label="NUIP" aria-describedby="Nuip">
        </div>
      </div>
    </div>
    <div>
      <table class="table" id="tbl_daily">
        <caption>Agenda Escolar de </caption>
        <thead>
          <tr>
            <th scope="col">{{ ucfirst('fecha') }}</th>
            <th scope="col">{{ ucwords('mensaje') }}</th>
            <th scope="col">{{ ucwords('ver') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </main>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#tbl_daily').DataTable({
      serverSide: true,
      order: [
        [0, 'asc']
      ],
      ajax: {
        url: "{{ route('daily-serverside') }}",
        dataType: "JSON",
        type: "GET",
        data: {
          "_token": "{{ csrf_token() }}"
        }
      },
      columns: [{
          data: 'date'
        },
        {
          data: 'cont'
        },
        {
          data: 'action',
          render: function(data, type, full, meta) {
            return `<div class='btn-group'> ver </div>`;
          },
          orderable: false
        }
      ],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      responsive: true,
      pagingType: 'full_numbers',
    })
  })
</script>

</html>