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
      position: relative;
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

    td {
      height: 12px !important;
      overflow: hidden;
    }

    .pos-student {
      margin-top: -23%;
      padding-bottom: 10%;
      font-size: 1.5rem !important;
    }

    .mb-n {
      margin-bottom: 0%;
    }

    @media (max-width: 412px) {
      .text-lobster {
        font-size: 60%;
      }

      .mb-n {
        margin-bottom: -15%;
      }

      .pos-student {
        font-size: 1em !important;
      }
    }

    @media (max-width: 810px) {
      .text-lobster {
        font-size: 40%;
      }

      .mb-n {
        margin-bottom: -19%;
      }
    }

    @media (max-width: 1440px) {
      .text-lobster {
        font-size: 28%;
      }

      .mb-n {
        margin-bottom: -20%;
      }
    }

    @media (max-width: 3840px) {
      .text-lobster {
        font-size: 43%;
      }

      .mb-n {
        margin-bottom: -15%;
      }
    }
  </style>
</head>

<body class="full-screen-image">
  <main class="container" style="border: 1px solid #ccc; border-top: none; border-bottom: none;">
    <div class="w-100 mb-n">
      <svg viewBox="0 40 100 50" style="z-index: -1000;">
        <path id="curve" d="M 0 80 Q 95 15 180 87" />
        <text class="text-lobster">
          <textPath xlink:href="#curve" startOffset="55">
            {{ config('app.name') }}
          </textPath>
        </text>
      </svg>
    </div>
    <div class="container text-center text-capitalize text-lobster pos-student" style="position: relative;" id="student">
      Alumno(a)
    </div>
    <form action="" method="post" style="z-index: 1000 !important;">
      <div class="container d-flex">
        <div class="w-50 d-flex justify-content-between">
          <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Inicio</span>
            </div>
            <input type="date" id="date-initials" class="form-control" placeholder="Fecha Inicial" aria-label="Fecha Inicial" aria-describedby="date-initials">
          </div>
          <div class="input-group input-group-sm mb-3">
            <input type="date" id="date-finals" class="form-control" placeholder="Fecha Final" aria-label="Fecha Final" aria-describedby="date-finals">
            <div class="input-group-append">
              <span class="input-group-text">Final</span>
            </div>
          </div>
        </div>
        <div class="w-50 d-flex justify-content-center">
          <div class="input-group input-group-sm mb-3 w-75">
            <div class="input-group-prepend">
              <span class="input-group-text">NUIP</span>
            </div>
            <input type="text" id="Nuip" class="form-control" aria-label="NUIP" aria-describedby="Nuip">
          </div>
          <div class="mx-2">
            <button type="button" class="btn btn-primary btn-sm" id="consultar" role="button">Consultar</button>
          </div>
        </div>
      </div>
    </form>
    <div>
      <table class="table" id="tbl_daily">
        <caption>Agenda Escolar</caption>
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


  <div class="modal fade" id="formView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @include('modules.schedules.partials.modal');
  </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script>
  const informations = () => {
    let initial = $('#date-initials').val();
    let final = $('#date-finals').val();
    let nuip = $('#Nuip').val();

    $.ajax({
      "_token": "{{ csrf_token() }}",
      "url": "{{ route('apiDailyStudent') }}",
      "method": "POST",
      "dataType": "JSON",
      "data": {
        initial: initial,
        final: final,
        nuip: nuip
      },
      success(response) {
        $("#student").text(`Alumno(a): ${response[0].firstname} ${response[0].threename} ${response[0].fourname} - ${response[0].course}`);
        let datos = [];
        tbl_daily.clear().draw();
        response.forEach(element => {
          datos.push({
            0: element.id_fulldate,
            1: element.id_cont,
            2: `<div class="btn-group mr-2" role="group" aria-label="First group">
                  <button type="button" class="btn btn-primary rounded" id="view" data-id='${element.id_pivot}'>Ver</button>
                  @hasanyrole('ADMINISTRADOR SISTEMA')
                    <button type="button" class="btn btn-secondary rounded" id="del" data-id='${element.id_pivot}'>Eliminar</button>
                  @endhasanyrole
                </div>`
          });
        });

        tbl_daily.rows.add(datos).draw();
      },
      complete() {
        Swal.fire({
          icon: 'success',
          html: `Proceso Exitoso`,
          footer: `<p class="text-secondary">gracias por esperar</p>`,
          showConfirmButton: false,
          focusConfirm: true,
          confirmButtonText: `Aceptar`,
          confirmButtonColor: '#333cff',
          timer: 1500
        })
      },
      error(err) {
        console.log(err.responseText);
      }
    })
  }


  var tbl_daily = $('#tbl_daily').DataTable();
  $(document).ready(function() {
    let date = new Date()
    let day = `${(date.getDate())}`.padStart(2, '0');
    let month = `${(date.getMonth()+1)}`.padStart(2, '0');
    let year = date.getFullYear();
    let today = `${year}-${month}-${day}`;
    $('input[type="date"]').val(today);
    tbl_daily.DataTable({
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

  $("#consultar").click(() => {
    let nuip = $('#Nuip').val();
    Swal.fire({
      title: '<strong>Consultado Información</strong>',
      icon: 'info',
      html: `<p>Consultando la informacion del alumno(a) de <b class="text-danger">NUIP:</b> ${nuip}</p>`,
      showCloseButton: false,
      showCancelButton: false,
      focusConfirm: false,
      confirmButtonColor: '#333cff'
    });
    informations();
  })

  $(document).on('click', '#view', (e) => {
    let id = e.target.attributes['data-id'].value;
    $.ajax({
      "_token": "{{ csrf_token() }}",
      url: "{{ route('apiViewInfo') }}",
      dataType: "JSON",
      type: "POST",
      data: {
        id: id
      },
      beforeSend() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'info',
          title: 'Consultando...'
        })
      },
      success(response) {
        let hi = response[0].note[0].id_hi;
        let cont = response[0].note[0].id_cont;
        let note = response[0].note[0].note;
        let listAdm = JSON.parse(response[0].note[0].id_NamesFiles);
        let listDoc = JSON.parse(response[0].note[0].id_NamesSin);

        $('#hi').text(hi);
        $('#cont').text(cont);
        $('#note').text(note);
        $("#list").empty();
        listAdm.forEach(e => {
          $("#list").append(`<li>${e}</li>`);
        })
        listDoc.forEach(item => {
          $("#list").append(`<li>${item}</li>`);
        })
      },
      complete() {
        $("#formView").modal();
      }
    })
  })

  $(document).on('click', '#del', (e) => {
    let id = e.target.attributes['data-id'].value;
    let nuip = $('#Nuip').val();

    Swal.fire({
      html: 'Desea eliminar este registro?',
      showCancelButton: true,
      confirmButtonText: 'Eliminar',
      denyButtonText: `Cancelar`,
      confirmButtonColor: '#333cff'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          "_token": "{{ csrf_token() }}",
          url: "{{ route('apiDelinfo') }}",
          type: "POST",
          dataType: "JSON",
          data: {
            id: id
          },
          beforeSend() {
            Swal.fire({
              title: '<strong>Eliminando Registro</strong>',
              icon: 'info',
              html: `<p>Eliminando Registro para el alumno(a) de <b class="text-danger">NUIP:</b> ${nuip}</p>`,
              showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonColor: '#333cff'
            });
          },
          success(response) {
            if (parseInt(response) == 1) {
              informations();
            }
          }
        })
      }
    })
  })
</script>

</html>