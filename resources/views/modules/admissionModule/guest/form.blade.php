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

  <!-- Styles -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  <!-- Fullcalendar -->
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/core/main.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/daygrid/main.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/packages/timegrid/main.min.css')}}">
  <!-- ChartJs -->
  <link rel="stylesheet" href="{{asset('plugins/chartJS/Chart.min.css')}}">
</head>

<body>
  <main class="container" style="border: 1px solid #ccc; border-top: none; border-bottom: none;">
    @if(session('SuccessAdmission'))
    <hr>
    <div class="alert alert-success text-center" style="font-size: 13px;">
      {{ session('SuccessAdmission') }}
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12 d-flex flex-column justify-content-center align-items-center">
        <button type="button" class="btn btn-outline-info text-center btn-block btn-again">VOLVER AL FORMULARIO</button>
        <br>
        @if(file_exists('storage/garden/logo.png'))
        <img src="{{ asset('storage/garden/logo.png') }}" class="text-center" style="width: 200px; height: auto;">
        @else
        <img src="{{ asset('storage/garden/logo.jpg') }}" class="text-center" style="width: 200px; height: auto;">
        @endif
      </div>
    </div>
    @elseif(session('SecondaryAdmission'))
    <hr>
    <div class="alert alert-secondary text-center" style="font-size: 13px;">
      {{ session('SecondaryAdmission') }}
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12 d-flex flex-column justify-content-center align-items-center">
        <button type="button" class="btn btn-outline-info text-center btn-block btn-again">VOLVER A INTENTARLO</button>
        <hr>
        @if(file_exists('storage/garden/logo.png'))
        <img src="{{ asset('storage/garden/logo.png') }}" style="width: 200px; height: auto;">
        @else
        <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 200px; height: auto;">
        @endif

      </div>
    </div>
    <hr>
    @else
    <div class="row border-bottom m-3">
      <div class="col-md-3 p-3">
        <form action="{{ route('list.documents.pdf') }}" method="GET" style="display: inline-block;">
          @csrf
          <input type="hidden" name="eventList" value="list" class="form-control form-control-sm" required>
          <button type="submit" title="DESCARGAR PDF" class="btn btn-outline-danger form-control-sm">
            <i class="fas fa-file-pdf"></i> LISTADO DE DOCUMENTOS
          </button>
        </form>
      </div>
      <div class="col-md-9"></div>
    </div>
    <form action="{{ route('saveAdmission') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row p-2">
        <div class="col-md-4 d-flex justify-content-center">
          @if(file_exists('storage/garden/logo.png'))
          <img src="{{ asset('storage/garden/logo.png') }}" style="width: 200px; height: auto;">
          @else
          <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 200px; height: auto;">
          @endif
        </div>
        <div class="col-md-6 d-flex flex-column align-items-center">
          <h4 style="color: #1200FF; text-shadow: 1px 1px 1px #000000;">FORMULARIO DE MATRICULA</h4>
          <h5 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">ADMISION</h5>
          @if(config('app.name') == "Dream Home By Creatyvia")
          <h6 style="color: #1200FF;">Agosto {{ date('Y') - 1 }} / Junio {{ date('Y') }}</h6>
          <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO B</h6>
          @elseif(config('app.name') == "Colchildren Kindergarten")
          <h6 style="color: #1200FF;">Año lectivo {{ date('Y') +1}}</h6>
          <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO A</h6>
          @else
          <h6 style="color: #1200FF;">febrero {{ date('Y') }} / Noviembre {{ date('Y') }}</h6>
          <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">MI CALENDARIO</h6>
          @endif
        </div>
        <div class="col-md-2 text-center d-flex flex-column justify-content-center align-items-center">
          <div class="row sectionPhoto">
            <div class="col-md-12 text-center border d-flex flex-column justify-content-center align-items-center" style="width: 3cm; height: 4cm; overflow: hidden;">
              <small class="text-muted text-center titlePhoto">Seleccione fotografía</small>
              <img hidden src="" id="previewPhoto" style="width: 3cm; height: 4cm">
            </div>
          </div>
          <div class="row text-center">
            <input type="file" id="photoSelected" name="photo" lang="es" placeholder="Unicamente con extensión jpeg" accept="image/jpeg" required>
          </div>
        </div>
      </div>
      <hr>
      @include('modules.admissionModule.partial.formPartial')
    </form>
    @endif
  </main>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fullcalendar-->
  <script src="{{asset('plugins/fullcalendar/moment/main.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/core/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/daygrid/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/timegrid/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/interaction/main.min.js')}}"></script>
  <script src="{{asset('plugins/fullcalendar/packages/core/locales/es.js')}}"></script>

  <!-- ChartJS para graficos de las estadisticas -->
  <script src="{{asset('plugins/chartJS/Chart.min.js')}}"></script>

  <!-- Plugin de jsPDF para reportes -->
  <script src="{{asset('plugins/jsPDF-1.3.2/dist/jspdf.min.js')}}"></script>
  <!-- Plugin de html2canvas para reportes -->
  <script src="{{asset('plugins/html2canvas/html2canvas.min.js')}}"></script>
  <script>
    $(function() {
      $('.alert-message').css('display', 'none');
    });

    $('.btn-again').on('click', function(e) {
      e.preventDefault();
      location.reload();
    });

    $('.sectionPhoto').on('click', function() {
      $('#photoSelected').click();
    });

    $('#photoSelected').on('change', function(e) {
      if (e.target.files[0]) {
        let file = URL.createObjectURL(e.target.files[0]);
        $('#previewPhoto').attr('src', file);
        $('#previewPhoto').attr('hidden', false);
        $('.titlePhoto').attr('hidden', true);
      }
    });

    $('select[name=localidadattendant1]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=barrioattendant1]').empty();
      $('select[name=barrioattendant1]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getDistrictFromAdmission') }}", {
          location_id: selected
        }, function(objectsDistricts) {
          var count = Object.keys(objectsDistricts).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=barrioattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=citybussinessattendant1]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=localidadempresaattendant1]').empty();
      $('select[name=localidadempresaattendant1]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getLocationFromAdmission') }}", {
          city_id: selected
        }, function(objectsLocations) {
          var count = Object.keys(objectsLocations).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=localidadempresaattendant1]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=localidadempresaattendant1]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=barrioempresaattendant1]').empty();
      $('select[name=barrioempresaattendant1]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getDistrictFromAdmission') }}", {
          location_id: selected
        }, function(objectsDistricts) {
          var count = Object.keys(objectsDistricts).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=barrioempresaattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=localidadattendant2]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=barrioattendant2]').empty();
      $('select[name=barrioattendant2]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getDistrictFromAdmission') }}", {
          location_id: selected
        }, function(objectsDistricts) {
          var count = Object.keys(objectsDistricts).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=barrioattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=citybussinessattendant2]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=localidadempresaattendant2]').empty();
      $('select[name=localidadempresaattendant2]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getLocationFromAdmission') }}", {
          city_id: selected
        }, function(objectsLocations) {
          var count = Object.keys(objectsLocations).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=localidadempresaattendant2]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=localidadempresaattendant2]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=barrioempresaattendant2]').empty();
      $('select[name=barrioempresaattendant2]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getDistrictFromAdmission') }}", {
          location_id: selected
        }, function(objectsDistricts) {
          var count = Object.keys(objectsDistricts).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=barrioempresaattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('select[name=localidademergency]').on('change', function(e) {
      var selected = e.target.value;
      $('select[name=barrioemergency]').empty();
      $('select[name=barrioemergency]').append("<option value=''>Seleccione ...</option>");
      if (selected != '') {
        $.get("{{ route('getDistrictFromAdmission') }}", {
          location_id: selected
        }, function(objectsDistricts) {
          var count = Object.keys(objectsDistricts).length;
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              $('select[name=barrioemergency]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
            }
          }
        });
      }
    });

    $('.btn-sendform').on('click', function(e) {
      let año = parseInt($('input[name=year]').val());
      let mes = parseInt($('input[name=month]').val());
      let dia = parseInt($('input[name=day]').val());
      let añoingreso = parseInt($('input[name=yearentry]').val());
      let mesingreso = parseInt($('input[name=monthentry]').val());
      let diaingreso = parseInt($('input[name=dayentry]').val());
      if (existe(año, mes, dia)) {
        if (existe(añoingreso, mesingreso, diaingreso)) {
          $(this).submit();
        } else {
          e.preventDefault();
          $('.alert-message').css('display', 'flex');
          $('.alert-message').append('La (fecha de ingreso) no existe');
          setTimeout(function() {
            $('.alert-message').css('display', 'none');
            $('.alert-message').empty();
          }, 5000);
        }
      } else {
        e.preventDefault();
        $('.alert-message').css('display', 'flex');
        $('.alert-message').append('La (fecha de nacimiento del niño/niña) no existe');
        setTimeout(function() {
          $('.alert-message').css('display', 'none');
          $('.alert-message').empty();
        }, 5000);
      }
    });

    function existe(año, mes, dia) {
      let fecha = new Date(año, mes, '0');
      return mes > 0 && mes < 13 && año > 0 && año < 32768 && dia > 0 && dia <= (new Date(año, mes, 0)).getDate();
    }
  </script>
  <!-- inicio del codigo antiguo -->
  <!-- <script>
		$(function() {
			$('.alert-message').css('display', 'none');
		});

		$('.btn-again').on('click', function(e) {
			e.preventDefault();
			location.reload();
		});

		$('.sectionPhoto').on('click', function() {
			$('#photoSelected').click();
		});
		$('#photoSelected').on('change', function(e) {
			if (e.target.files[0]) {
				let file = URL.createObjectURL(e.target.files[0]);
				$('#previewPhoto').attr('src', file);
				$('#previewPhoto').attr('hidden', false);
				$('.titlePhoto').attr('hidden', true);
			}
		});

		$('select[name=localidadattendant1]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=barrioattendant1]').empty();
			$('select[name=barrioattendant1]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getDistrictFromAdmission') }}", {
					location_id: selected
				}, function(objectsDistricts) {
					var count = Object.keys(objectsDistricts).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=barrioattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=citybussinessattendant1]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=localidadempresaattendant1]').empty();
			$('select[name=localidadempresaattendant1]').append("<option value=''>Seleccione ...</option>");
			$('select[name=barrioempresaattendant1]').empty();
			$('select[name=barrioempresaattendant1]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getLocationFromAdmission') }}", {
					city_id: selected
				}, function(objectsLocations) {
					var count = Object.keys(objectsLocations).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=localidadempresaattendant1]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=localidadempresaattendant1]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=barrioempresaattendant1]').empty();
			$('select[name=barrioempresaattendant1]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getDistrictFromAdmission') }}", {
					location_id: selected
				}, function(objectsDistricts) {
					var count = Object.keys(objectsDistricts).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=barrioempresaattendant1]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=localidadattendant2]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=barrioattendant2]').empty();
			$('select[name=barrioattendant2]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getDistrictFromAdmission') }}", {
					location_id: selected
				}, function(objectsDistricts) {
					var count = Object.keys(objectsDistricts).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=barrioattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=citybussinessattendant2]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=localidadempresaattendant2]').empty();
			$('select[name=localidadempresaattendant2]').append("<option value=''>Seleccione ...</option>");
			$('select[name=barrioempresaattendant2]').empty();
			$('select[name=barrioempresaattendant2]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getLocationFromAdmission') }}", {
					city_id: selected
				}, function(objectsLocations) {
					var count = Object.keys(objectsLocations).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=localidadempresaattendant2]').append("<option value=" + objectsLocations[i]['id'] + ">" + objectsLocations[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=localidadempresaattendant2]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=barrioempresaattendant2]').empty();
			$('select[name=barrioempresaattendant2]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getDistrictFromAdmission') }}", {
					location_id: selected
				}, function(objectsDistricts) {
					var count = Object.keys(objectsDistricts).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=barrioempresaattendant2]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('select[name=localidademergency]').on('change', function(e) {
			var selected = e.target.value;
			$('select[name=barrioemergency]').empty();
			$('select[name=barrioemergency]').append("<option value=''>Seleccione ...</option>");
			if (selected != '') {
				$.get("{{ route('getDistrictFromAdmission') }}", {
					location_id: selected
				}, function(objectsDistricts) {
					var count = Object.keys(objectsDistricts).length;
					if (count > 0) {
						for (var i = 0; i < count; i++) {
							$('select[name=barrioemergency]').append("<option value=" + objectsDistricts[i]['id'] + ">" + objectsDistricts[i]['name'] + "</option>");
						}
					}
				});
			}
		});

		$('.btn-sendform').on('click', function(e) {
			let año = parseInt($('input[name=year]').val());
			let mes = parseInt($('input[name=month]').val());
			let dia = parseInt($('input[name=day]').val());
			let añoingreso = parseInt($('input[name=yearentry]').val());
			let mesingreso = parseInt($('input[name=monthentry]').val());
			let diaingreso = parseInt($('input[name=dayentry]').val());
			if (existe(año, mes, dia)) {
				if (existe(añoingreso, mesingreso, diaingreso)) {
					$(this).submit();
				} else {
					e.preventDefault();
					$('.alert-message').css('display', 'flex');
					$('.alert-message').append('La (fecha de ingreso) no existe');
					setTimeout(function() {
						$('.alert-message').css('display', 'none');
						$('.alert-message').empty();
					}, 5000);
				}
			} else {
				e.preventDefault();
				$('.alert-message').css('display', 'flex');
				$('.alert-message').append('La (fecha de nacimiento del niño/niña) no existe');
				setTimeout(function() {
					$('.alert-message').css('display', 'none');
					$('.alert-message').empty();
				}, 5000);
			}

		});

		function existe(año, mes, dia) {
			let fecha = new Date(año, mes, '0');
			return mes > 0 && mes < 13 && año > 0 && año < 32768 && dia > 0 && dia <= (new Date(año, mes, 0)).getDate();
		}
	</script> -->
  <!-- fin del codigo antiguo -->
</body>

</html>