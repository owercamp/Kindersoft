@extends('modules.customers')

@section('customersComercial')
<div class="col-md-12">
  <h4>PROGRAMACION DE CLIENTES</h4>
  <div class="row">
    <div class="col-md-12">
      <!-- Mensajes de creacion de agendas -->
      @if(session('SuccessSaveProgramming'))
      <div class="alert alert-success">
        {{ session('SuccessSaveProgramming') }}
      </div>
      @endif
      @if(session('SecondarySaveProgramming'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveProgramming') }}
      </div>
      @endif
      <!-- Mensajes de asistencia de cita -->
      @if(session('SuccessConfirmScheduling'))
      <div class="alert alert-success">
        {{ session('SuccessConfirmScheduling') }}
      </div>
      @endif
      @if(session('SecondaryConfirmScheduling'))
      <div class="alert alert-secondary">
        {{ session('SecondaryConfirmScheduling') }}
      </div>
      @endif
      <!-- Mensajes de inasistencia de cita -->
      @if(session('WarningCancelScheduling'))
      <div class="alert alert-warning">
        {{ session('WarningCancelScheduling') }}
      </div>
      @endif
      @if(session('SecondaryCancelScheduling'))
      <div class="alert alert-secondary">
        {{ session('SecondaryCancelScheduling') }}
      </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 pt-4 border-bottom">
      <div class="row border-bottom mb-3">
        <div class="col-md-12 alert alert-success messages"></div>
      </div>
      <!--<button type="text" id="btn-agenda">Agendar</button>-->
      <div id='calendarfull'></div>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal fade" id="addEvent">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">AGENDAMIENTO: <small class="text-muted" id="customerName"></small></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form action="{{ route('scheduling.save') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-6 text-center">
                    <small class="text-muted">
                      <input type="radio" name="optionOld" value="NO" checked>
                      Cliente nuevo
                    </small>
                  </div>
                  <div class="col-md-6 text-center">
                    <small class="text-muted">
                      <input type="radio" name="optionOld" value="SI">
                      Cliente existente
                    </small>
                  </div>
                </div>
                <div class="card-body col-md-12">
                  <small class="text-muted">DATOS DE CLIENTE</small>
                  <div class="row border-top">
                    <div class="col-md-12 old">
                      <div class="form-group">
                        <small class="text-muted">Nombre y apellido:</small>
                        <select id="schCustomer_id" name="schCustomer_id" class="form-control form-control-sm select2">
                          <option value="" selected>Seleccione un cliente...</option>
                          @foreach($customers as $customer)
                          <option value="{{ $customer->id }}">{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 new">
                      <div class="form-group">
                        <small class="text-muted">Nombres:</small>
                        <input type="text" name="cusFirstname" class="form-control form-control-sm" required>
                      </div>
                    </div>
                    <div class="col-md-6 new">
                      <div class="form-group">
                        <small class="text-muted">Apellidos:</small>
                        <input type="text" name="cusLastname" class="form-control form-control-sm" required>
                      </div>
                    </div>
                  </div><!-- Fin de fila -->
                  <div class="row border-bottom">
                    <div class="col-md-6">
                      <div class="form-group">
                        <small class="text-muted">Número de contacto:</small>
                        <input type="number" name="cusPhone" class="form-control form-control-sm" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <small class="text-muted">Correo electrónico:</small>
                        <input type="email" name="cusMail" class="form-control form-control-sm" required>
                      </div>
                    </div>
                  </div>
                  <small class="text-muted">DATOS DE ASPIRANTE</small>
                  <div class="row border-bottom">
                    <div class="col-md-6">
                      <div class="form-group">
                        <small class="text-muted">Nombres:</small>
                        <input type="text" name="cusChild" class="form-control form-control-sm" required>
                        <small class="text-muted">Edad:</small>
                        <input type="number" name="cusChildYearsold" class="form-control form-control-sm" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <small class="text-muted">Nota:</small>
                        <textarea type="text" id="cusNotes" name="cusNotes" class="form-control form-control-sm" required placeholder="Máximo de 200 caracteres"></textarea>
                      </div>
                    </div>
                  </div>
                  <small class="text-muted">DATOS DE AGENDA</small>
                  <div class="row border-bottom">
                    <div class="col-md-4">
                      <div class="form-group">
                        <small class="text-muted">Fecha:</small>
                        <input type="text" name="schDateVisit" class="form-control form-control-sm" readonly required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <small class="text-muted">Dia:</small>
                        <input type="text" name="schDayVisit" class="form-control form-control-sm" readonly required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <small class="text-muted">Hora:</small>
                        <input type="time" name="schHourVisit" class="form-control form-control-sm" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <button type="submit" class="btn btn-outline-success form-control-sm">AGENDAR CITA</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="seeEvent">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">ESTADO DE CITA: <span class="badge badge-default see-schResult"></span></h4>
          <input type="hidden" class="see-schId">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="card-body col-md-12">
                <small class="text-muted">DATOS DE CLIENTE:</small>
                <div class="row border-top">
                  <div class="form-group">
                    <small class="text-muted">Nombres:</small>
                    <small class="see-cusNames"></small>
                    <br>
                    <small class="text-muted">Contacto:</small>
                    <small class="see-cusPhone"></small>
                    <br>
                    <small class="text-muted">Correo electrónico:</small>
                    <small class="see-cusMail"></small>
                  </div>
                </div>
                <small class="text-muted">DATOS DE ASPIRANTE:</small>
                <div class="row border-top">
                  <div class="form-group">
                    <small class="text-muted">Nombres:</small>
                    <small class="see-cusChild"></small>
                    <br>
                    <small class="text-muted">Notas/Observaciones: </small>
                    <small class="see-cusNotes"></small>
                  </div>
                </div>
                <small class="text-muted">DATOS DE AGENDA:</small>
                <div class="row border-top">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">Cita programada: </small>
                      <small class="see-schDayVisit"></small>
                      <small class="see-schDateVisit"></small>
                      <small class="see-schHourVisit"></small>
                    </div>
                  </div>
                </div>
                <div class="row card-footer text-center bj-active">
                  <div class="col-md-6">
                    <button type="button" id="confirmScheduling" class="btn btn-outline-primary mt-2 form-control-sm">ASISTIDA</button>
                  </div>
                  <div class="col-md-6">
                    <button type="button" id="cancelScheduling" class="btn btn-outline-tertiary  mt-2 form-control-sm">INASISTIDA</button>
                  </div>
                </div>
                <div class="row card-footer text-center bj-inactive">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-outline-tertiary  mt-2 form-control-sm" data-dismiss="modal">CERRAR</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="newHourModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="text-muted">REPROGRAMAR CITA:</h5>
          <div class="form-group">
            <small class="text-muted">HORA ACTUAL / CLIENTE: <br><b><span class="customer-rescheduling"></span></b></small><br>
            <small class="text-muted">NUEVA FECHA: <b><span class="date-rescheduling"></span></b></small><br>
            <small class="text-muted">NUEVO DIA: <b><span class="day-rescheduling"></span></b></small>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <small class="text-muted">ESCRIBA LA HORA A REPROGRAMAR:</small>
            <input type="time" class="form-control form-control-sm" name="new-schHourVisit">
          </div>
          <div class="form-group">
            <button id="confirmNewHour" type="button" class="btn btn-outline-success float-left form-control-sm">ACEPTAR</button>
            <button type="button" class="btn btn-outline-tertiary  float-right form-control-sm" data-dismiss="modal">CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection


@section('scripts')
<script>
  $(function() {
    $('.messages').css('display', 'none');
    $('.bj-inactive').css('display', 'none');
    dateNow();

    $('#calendarfull').css('font-size', '10px !important');

    $('.old').css('display', 'none');

    $('input[name=optionOld]').on('change', function() {

      $("#schCustomer_id option[value='']").attr("selected", true);

      if ($(this).val() === 'SI') {
        $('.old').css('display', 'block');
        $('.new').css('display', 'none');

        $("#schCustomer_id option[value='']").attr("selected", true);
        $('select[name=schCustomer_id]').attr('required', true);
        $('input[name=cusFirstname]').attr('required', false);
        $('input[name=cusLastname]').attr('required', false);
        $('input[name=cusPhone]').attr('readonly', true);
        $('input[name=cusMail]').attr('readonly', true);
        $('input[name=cusChild]').attr('readonly', true);
        $('input[name=cusChildYearsold]').attr('readonly', true);
        $('#cusNotes').attr('readonly', true);
      } else if ($(this).val() === 'NO') {
        $('.old').css('display', 'none');
        $('.new').css('display', 'block');

        $("#schCustomer_id option[value='']").attr("selected", true);
        $('select[name=schCustomer_id]').attr('required', false);

        $('input[name=cusFirstname]').val('');
        $('input[name=cusFirstname]').attr('required', true);

        $('input[name=cusLastname]').val('');
        $('input[name=cusLastname]').attr('required', true);

        $('input[name=cusPhone]').val('');
        $('input[name=cusPhone]').attr('readonly', false);

        $('input[name=cusMail]').val('');
        $('input[name=cusMail]').attr('readonly', false);

        $('input[name=cusChild]').val('');
        $('input[name=cusChild]').attr('readonly', false);

        $('input[name=cusChildYearsold]').val('');
        $('input[name=cusChildYearsold]').attr('readonly', false);

        $('#cusNotes').val('');
        $('#cusNotes').attr('readonly', false);
      }
    });

    $("#schCustomer_id").on("change", function(e) {
      var customer_id = e.target.value;
      $.get("{{ route('subcustomer') }}", {
        customer_id: customer_id
      }, function(customerObject) {
        $('input[name=cusPhone]').val(customerObject['cusPhone']);
        $('input[name=cusMail]').val(customerObject['cusMail']);
        $('input[name=cusChild]').val(customerObject['cusChild']);
        $('input[name=cusChildYearsold]').val(customerObject['cusChildYearsold']);
        $('#cusNotes').val(customerObject['cusNotes']);
      });
    });



  });

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendarfull');
    //var btnAgenda = document.getElementById('btn-agenda');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid'],
      editable: true,
      selectable: true,
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth'
      },
      events: {
        url: "{{ route('scheduling.get') }}"
      },
      eventClick: function(info) {
        //console.log(info.event.id);
        $.get("{{ route('allscheduling') }}", {
          scheduling: info.event.id
        }, function(schedulingObject) {

          $('.see-schId').val('');
          $('.see-schId').val(schedulingObject['schId']);
          $('.see-schResult').html('');
          $('.see-schResult').html(schedulingObject['schResultVisit']);
          $('.see-cusNames').html('');
          $('.see-cusNames').html('<b>' + schedulingObject['cusFirstname'] + ' ' + schedulingObject['cusLastname'] + '</b>');
          $('.see-cusPhone').html('');
          $('.see-cusPhone').html('<b>' + schedulingObject['cusPhone'] + '</b>');
          $('.see-cusMail').html('');
          $('.see-cusMail').html('<b>' + schedulingObject['cusMail'] + '</b>');
          $('.see-cusChild').html('');
          $('.see-cusChild').html('<b>' + schedulingObject['cusChild'] + '</b> con <b>' + schedulingObject['cusChildYearsold'] + '</b> años de edad');
          $('.see-cusNotes').html('');
          $('.see-cusNotes').html('<b>' + schedulingObject['cusNotes'] + '</b>');
          $('.see-schDateVisit').html('');
          $('.see-schDateVisit').html('<b>' + schedulingObject['schDateVisit'] + '</b>');
          $('.see-schDayVisit').html('');
          $('.see-schDayVisit').html('<b>' + schedulingObject['schDayVisit'] + '</b>');
          $('.see-schHourVisit').html('');
          $('.see-schHourVisit').html('<b>' + schedulingObject['schHourVisit'] + '</b>');
          var dateComplete = dateCompleteNow();
          if (schedulingObject['schStatusVisit'] == 'INACTIVO' || dateComplete < schedulingObject['schDateVisit']) {
            $('.bj-active').css('display', 'none');
            $('.bj-inactive').css('display', 'flex');
          } else if (schedulingObject['schStatusVisit'] == 'ACTIVO' && dateComplete >= schedulingObject['schDateVisit']) {
            $('.bj-active').css('display', 'flex');
            $('.bj-inactive').css('display', 'none');
          }

        });
        setTimeout(function() {
          $('#seeEvent').modal();
        }, 500);

        $('#confirmScheduling').on('click', function(e) {
          e.preventDefault();
          $.get("{{ route('confirmScheduling') }}", {
            schId: $('.see-schId').val()
          }, function(response) {
            $("#seeEvent").modal('hide');
            //info.refetchEvents();
          });
        });

        $('#cancelScheduling').on('click', function(e) {
          e.preventDefault();
          $.get("{{ route('cancelScheduling') }}", {
            schId: $('.see-schId').val()
          }, function(response) {
            $("#seeEvent").modal('hide');
            //info.refetchEvents();
          });
        });
      },
      eventDrop: function(info) {
        var dateDroped = dateCompleteNow(info.event.start.toISOString());
        var dateNewRescheduling = new Date(dateDroped);
        var dateComplete = dateCompleteNow();
        if (dateComplete <= dateDroped) {
          $('#newHourModal').modal();
          $('.customer-rescheduling').text('');
          $('.customer-rescheduling').text(info.event.title);
          $('.date-rescheduling').text('');
          $('.date-rescheduling').text(dateDroped);
          $('.day-rescheduling').text('');
          $('.day-rescheduling').text(getDay(dateNewRescheduling.getUTCDay()));

          $('#confirmNewHour').on('click', function() {
            if ($('input[name=new-schHourVisit]').val() !== '') {
              $.get("{{ route('reschedule') }}", {
                schId: info.event.id,
                newDate: dateDroped,
                newHour: $('input[name=new-schHourVisit]').val()
              }, function(response) {
                $('.messages').css('display', 'flex');
                $('.messages').html('');
                if (response.indexOf('NO ES POSIBLE REPROGRAMAR') >= 0) {
                  info.revert();
                }
                $('#newHourModal').modal('hide');
                $('.customer-rescheduling').text('');
                $('.date-rescheduling').text('');
                $('.day-rescheduling').text('');
                $('input[name=new-schHourVisit]').val('');
                $('.messages').append('<b>' + response + '</b>');
                setTimeout(function() {
                  $('.messages').html('');
                  $('.messages').css('display', 'none');
                }, 20000);
              });
            } else {
              info.revert();
            }
          });
        } else {
          info.revert();
        }

      },
      dateClick: function(info) {
        $('input[name=schDateVisit]').val(info.dateStr);
        dateNow();
        var dateComplete = dateCompleteNow();
        if (dateComplete <= info.dateStr) {
          $('#addEvent').modal();
        }
      },
      select: function(info) {
        //$('#addEvent').modal();
      }
    });
    calendar.setOption('locale', 'es');
    calendar.render();

    //new Draggable(btnAgenda);
  });

  function dateCompleteNow(date = '') {
    if (date == '') {
      var now = new Date();
      var month = now.getMonth() + 1;
      var day = now.getDate();

      var dateComplete = now.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;

    } else {
      var now = new Date(date);
      var month = now.getMonth() + 1;
      var day = now.getDate();

      var dateComplete = now.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    }
    return dateComplete;
  }

  function dateNow() {
    var dateNow = $('input[name=schDateVisit]').val();
    var date = new Date(dateNow);
    $('input[name=schDayVisit]').val('');
    $('input[name=schDayVisit]').val(getDay(date.getUTCDay()));
  }

  function getDay(value) {
    switch (value) {
      case 0:
        return 'Domingo';
        break;
      case 1:
        return 'Lunes';
        break;
      case 2:
        return 'Martes';
        break;
      case 3:
        return 'Miercoles';
        break;
      case 4:
        return 'Jueves';
        break;
      case 5:
        return 'Viernes';
        break;
      case 6:
        return 'Sabado';
        break;
    }
  }
</script>
@endsection