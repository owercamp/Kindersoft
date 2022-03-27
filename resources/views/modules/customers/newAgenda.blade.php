@extends('modules.customers')

@section('customersComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de clientes -->
      @if(session('SuccessSaveCustomerAgenda'))
      <div class="alert alert-primary">
        {{ session('SuccessSaveCustomerAgenda') }}
      </div>
      @endif
      @if(session('SecondarySaveCustomerAgenda'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveCustomerAgenda') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de clientes -->
      @if(session('PrimaryUpdateCustomerAgenda'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateCustomerAgenda') }}
      </div>
      @endif
      @if(session('SecondaryUpdateCustomerAgenda'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateCustomerAgenda') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de clientes -->
      @if(session('WarningDeleteCustomerAgenda'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteCustomerAgenda') }}
      </div>
      @endif
      @if(session('SecondaryDeleteCustomerAgenda'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteCustomerAgenda') }}
      </div>
      @endif
      <!-- Mensajes de envios de correos -->
      @if(session('SuccessMailCustomer'))
      <div class="alert alert-success">
        {{ session('SuccessMailCustomer') }}
      </div>
      @endif
      @if(session('SecondaryMailCustomer'))
      <div class="alert alert-secondary">
        {{ session('SecondaryMailCustomer') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="{{ route('customer.new') }}" class="btn btn-outline-success mx-5 my-2 form-control-sm">REGISTRAR CLIENTE</a>
    </div>
  </div>
  <table id="tablecustomers" class="table table-responsive text-center" width="100%">
    <thead>
      <tr>
        <th>NOMBRES</th>
        <th>TELEFONO</th>
        <th>CORREO</th>
        <th>ASPIRANTE</th>
        <th>EDAD</th>
        <th>OBSERVACION</th>
        <th style="min-width: 200px;">DETALLES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($customers as $customer)
      <tr>
        <td>{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</td>
        <td>{{ $customer->cusPhone }}</td>
        <td>{{ $customer->cusMail }}</td>
        <td>{{ $customer->cusChild }}</td>
        <td>{{ $customer->cusChildYearsold }}</td>
        <td>{{ $customer->cusNotes }}</td>
        <td class="column-actions">
          <span class="dateVisit" hidden>{{ $customer->schDateVisit }}</span>
          <span class="hourVisit" hidden>{{ $customer->schHourVisit }}</span>
          <a href="#" title="DETALLES/ACCION DE CITACION" class="btn btn-outline-success rounded-circle rescheduling-link">
            <i class="fas fa-clock"></i>
            <span hidden>{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</span>
            <span hidden>{{ $customer->cusPhone }}</span>
            <span hidden>{{ $customer->cusMail }}</span>
            <span hidden>{{ $customer->cusChild }}</span>
            <span hidden>{{ $customer->cusChildYearsold }}</span>
            <span hidden>{{ $customer->cusId }}</span>
          </a>
          <!-- <a href="{{ route('customer.edit', $customer->cusId) }}" title="EDITAR" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
							<a href="{{ route('customer.delete', $customer->cusId) }}" title="ELIMINAR" class="btn btn-outline-tertiary " onclick="return confirm('- Se eliminará el cliente, tenga en cuenta que se eliminarán los agendamientos PENDIENTES que tenga el cliente, ¿Desea eliminar el cliente?')"><i class="fas fa-trash-alt"></i></a> -->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal de re-agendamiento -->
<div class="modal fade" id="rescheduling-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row p-3 m-3">
          <div class="col-md-4">
            <h5 class="text-muted">INFORMACIÓN DE CLIENTE:</h5>
          </div>
          <div class="col-md-4">
            <form id="form-sendMail" action="{{ route('customer.remember') }}" style="margin-left: 20px; visibility: hidden;">
              <input type="hidden" name="customer_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="mail_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="day_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="date_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="hour_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="student_forMail" class="form-control form-control-sm" readonly required>
              <input type="hidden" name="idScheduling_forMail" class="form-control form-control-sm" readonly required>
              <button type="submit" class="btn btn-outline-primary form-control-sm">ENVIAR CORREO <i class="fas fa-envelope-open-text"></i></button>
            </form>
          </div>
          <div class="col-md-4 p-2 text-center" style="background: #0086f9; border-radius: 20px; color: #fff; font-weight: bold; font-size: 20px;">
            <h5>CORREOS ENVIADOS: <b class="cusMails_count"></b></h5>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="row modal-body">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="row p-3 border-bottom">
                <div class="col-md-6 text-right">
                  <b style="font-size: 12px;" class="text-muted">CLIENTE:</b><br>
                  <b style="font-size: 12px;" class="text-muted">TELEFONO:</b><br>
                  <b style="font-size: 12px;" class="text-muted">CORREO:</b><br>
                  <b style="font-size: 12px;" class="text-muted">ASPIRANTE:</b><br>
                  <b style="font-size: 12px;" class="text-muted">EDAD DE ASPIRANTE:</b><br>
                  <b class="mt-2">DATOS DE VISITA</b><br>
                  <b style="font-size: 12px;" class="text-muted">FECHA:</b><br>
                  <b style="font-size: 12px;" class="text-muted">DIA:</b><br>
                  <b style="font-size: 12px;" class="text-muted">HORA:</b>

                </div>
                <div class="col-md-6 text-left">
                  <b style="font-size: 12px;" class="text-muted name-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted phone-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted mail-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted child-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted yearschild-rescheduling"></b><br>
                  <b></b><br>
                  <b style="font-size: 12px;" class="text-muted date-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted day-rescheduling"></b><br>
                  <b style="font-size: 12px;" class="text-muted hour-rescheduling"></b>
                </div>
              </div>
              <div class="row p-3 border-top border-bottom" style="background: #ccc;">
                <div class="col-md-12">
                  <h6><b class="text-muted">CAMBIAR ESTADO DE VISITA</b></h6>
                </div>
              </div>
              <form action="{{ route('scheduling.change') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row p-2 border-top">
                  <input type="hidden" name="schId" class="form-control form-control-sm" required>
                  <div class="col-md-12">
                    <div class="form-group">
                      <small>NUEVO ESTADO:</small>
                      <select name="schResultVisit_change" class="form-control form-control-sm select2" required>
                        <option value="">Seleccione una opción...</option>
                        <option value="ASISTIDO">ASISTIDO</option>
                        <option value="INASISTIDO">INASISTIDO</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small>OBSERVACIONES:</small>
                      <textarea type="text" name="schObservation_change" class="form-control form-control-sm" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-outline-primary m-2">CAMBIAR</button>
                  </div>
                </div>
              </form>
              <div class="row p-3 border-top border-bottom" style="background: #ccc;">
                <div class="col-md-12">
                  <h6><b class="text-muted">REPROGRAMAR VISITA</b></h6>
                </div>
              </div>
              <form action="{{ route('scheduling.reprogramming') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row p-2 border-top">
                  <input type="hidden" name="schId" class="form-control form-control-sm" required>
                  <div class="col-md-4">
                    <div class="form-group">
                      <small>FECHA:</small>
                      <input type="text" name="schDateVisit_new" class="form-control form-control-sm datepicker" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <small>HORA:</small>
                      <input type="text" name="schDayVisit_new" class="form-control form-control-sm" readonly required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <small>HORA:</small>
                      <input type="time" name="schHourVisit_new" class="form-control form-control-sm" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-outline-success">REPROGRAMAR</button>
                    <button type="button" class="btn btn-outline-tertiary " data-dismiss="modal">CANCELAR</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-6 border-left">
              <h6 class="text-center text-muted">HISTORIAL DE VISITAS:</h6><br>
              <table class="table table-responsive text-center table-history" width="100%" style="height: 100%;">
                <thead>
                  <tr>
                    <th style="min-width: 150px;">FECHA</th>
                    <th>ESTADO</th>
                    <th style="min-width: 150px;">OBSERVACION</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Campos dinámicos -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const getTime = dateLimit => {
    let now = new Date(),
      time = (new Date(dateLimit) - now + 1000) / 1000,
      seconds = ('0' + Math.floor(time % 60)).slice(-2),
      minutes = ('0' + Math.floor(time / 60 % 60)).slice(-2),
      hours = ('0' + Math.floor(time / 3600 % 24)).slice(-2),
      days = Math.floor(time / (3600 * 24));

    return {
      seconds,
      minutes,
      hours,
      days,
      time
    }
  };

  const countdown = (dateLimit, element) => {
    const item = document.getElementById(element);
    const timerUpdate = setInterval(() => {
      let currenTime = getTime(dateLimit);
      item.innerHTML = `${currenTime.hours}h:${currenTime.minutes}m:${currenTime.seconds}s`;
      if (currenTime.time <= 1) {
        clearInterval(timerUpdate);
        item.innerHTML = '<br>EN CURSO';
      }
    }, 1000);
  };

  $(function() {
    var index = 1;
    $('.column-actions').each(function() {
      var dateVisit = $(this).find('span.dateVisit').text();
      var hourVisit = $(this).find('span.hourVisit').text();
      var bol = dateVisit.indexOf('/');
      if (bol < 0) {
        var dateSeparated = dateVisit.split('-');
        var visit = new Date(dateSeparated[0], (dateSeparated[1] - 1), dateSeparated[2]);
        var today = new Date();
        visit.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);
        var element = $(this).parent('tr').find('td:first');
        if (visit.getTime() == today.getTime()) {
          element.append("<br><i title='VISITA PARA HOY' class='fas fa-exclamation-triangle m-1' style='color: red; font-size: 20px;'></i><b id='timedown" + index + "' class='text-muted'></b>");
          var separatedHour = hourVisit.split(':');
          visit.setHours(separatedHour[0], separatedHour[1], separatedHour[2]);
          countdown(visit, 'timedown' + index);
          index++
        }
      } else {
        var dateSeparated = dateVisit.split('/');
        var visit = new Date(dateSeparated[0], (dateSeparated[1] - 1), dateSeparated[2]);
        console.log(visit);
      }
    });
  });

  $('.rescheduling-link').on('click', function(e) {
    e.preventDefault();
    var name = $(this).find('span:nth-child(2)').text();
    var phone = $(this).find('span:nth-child(3)').text();
    var mail = $(this).find('span:nth-child(4)').text();
    var child = $(this).find('span:nth-child(5)').text();
    var yearschild = $(this).find('span:nth-child(6)').text();
    var cusId = $(this).find('span:nth-child(7)').text();

    $.get("{{ route('getSchedulingForChange') }}", {
      cusId: cusId
    }, function(objectScheduling) {
      if (objectScheduling['schDateVisit'] !== null || objectScheduling['schDateVisit'] !== '') {
        var before = new Date(objectScheduling['schDateVisit']);
        var mountBefore = ((before.getMonth() + 1) < 10 ? '0' : '') + (before.getMonth() + 1);
        var dayBefore = ((before.getDate() + 1) < 10 ? '0' : '') + (before.getDate());
        var datebeforeCompleted = before.getFullYear() + "-" + mountBefore + "-" + dayBefore;

        var datenow = new Date();
        var mountnow = ((datenow.getMonth() + 1) < 10 ? '0' : '') + (datenow.getMonth() + 1);
        var daynow = ((datenow.getDate() + 1) < 10 ? '0' : '') + (datenow.getDate());
        var datenowCompleted = datenow.getFullYear() + "-" + mountnow + "-" + daynow;

        //SE MUESTRA O OCULTA FORMULARIO/BOTON DE CORREO DEPENDIENDO DE LA FECHA ACTUAL
        // if(datebeforeCompleted == datenowCompleted){
        if (datenow < before) {
          $('#form-sendMail').css('visibility', 'visible');
          //SE LLENA FORMULARIO PARA ENVIAR CORREO
          $('input[name=customer_forMail]').val(name);
          $('input[name=mail_forMail]').val(mail);
          $('input[name=day_forMail]').val(objectScheduling['schDayVisit']);
          $('input[name=date_forMail]').val(getDateComplete(objectScheduling['schDateVisit']));
          $('input[name=hour_forMail]').val(objectScheduling['schHourVisit']);
          $('input[name=student_forMail]').val(child);
          $('input[name=idScheduling_forMail]').val(objectScheduling['id']);
        } else {
          $('#form-sendMail').css('visibility', 'hidden');
        }

        $('.cusMails_count').text(objectScheduling['schMails']);

        //SE COMPLETAN CAMPOS INFORMATIVOS
        $('.date-rescheduling').text('');
        $('.date-rescheduling').text(objectScheduling['schDateVisit']);
        $('.day-rescheduling').text('');
        $('.day-rescheduling').text(objectScheduling['schDayVisit']);
        $('.hour-rescheduling').text('');
        $('.hour-rescheduling').text(objectScheduling['schHourVisit']);
        $('input[name=schId]').val('');
        $('input[name=schId]').val(objectScheduling['id']);
      } else {
        $('.date-rescheduling').text('');
        $('.day-rescheduling').text('');
        $('.hour-rescheduling').text('');
        $('input[name=schId]').val('');
      }
    });

    $('.name-rescheduling').text('');
    $('.name-rescheduling').text(name);
    $('.phone-rescheduling').text('');
    $('.phone-rescheduling').text(phone);
    $('.mail-rescheduling').text('');
    $('.mail-rescheduling').text(mail);
    $('.child-rescheduling').text('');
    $('.child-rescheduling').text(child);
    $('.yearschild-rescheduling').text('');
    $('.yearschild-rescheduling').text(yearschild);

    $.get("{{ route('getHistoryVisits') }}", {
      cusId: cusId
    }, function(objectHistory) {
      if (objectHistory != null && objectHistory != '') {
        var count = Object.keys(objectHistory).length; //total de registros en historial
        $('.table-history tbody').empty();
        for (var i = 0; i < count; i++) {
          $('.table-history tbody').append("<tr><td>" + getDateComplete(objectHistory[i]['schDateVisit']) + " A LAS " + getHourFormat(objectHistory[i]['schHourVisit']) + "</td><td>" + objectHistory[i]['schResultVisit'] + "</td><td>" + objectHistory[i]['schObservation'] + "</td></tr>");
        }
      }
    });

    $('#rescheduling-modal').modal();
  });

  $('input[name=schDateVisit_new]').on('change', function() {
    var dateNow = $(this).val();
    var date = new Date(dateNow);
    $('input[name=schDayVisit_new]').val('');
    $('input[name=schDayVisit_new]').val(getDay(date.getUTCDay()));

  });

  function getDay(value) {
    switch (value) {
      case 0:
        return 'DOMINGO';
        break;
      case 1:
        return 'LUNES';
        break;
      case 2:
        return 'MARTES';
        break;
      case 3:
        return 'MIERCOLES';
        break;
      case 4:
        return 'JUEVES';
        break;
      case 5:
        return 'VIERNES';
        break;
      case 6:
        return 'SÁBADO';
        break;
    }
  }

  function getDateComplete(value) {
    var pos = value.indexOf('-');
    var separated;
    if (pos < 0) {
      var separated = value.split('/');
    } else {
      var separated = value.split('-');
    }
    switch (separated[1]) {
      case '01':
        return separated[2] + ' de ENERO del ' + separated[0];
        break;
      case '02':
        return separated[2] + ' de FEBRERO del ' + separated[0];
        break;
      case '03':
        return separated[2] + ' de MARZO del ' + separated[0];
        break;
      case '04':
        return separated[2] + ' de ABRIL del ' + separated[0];
        break;
      case '05':
        return separated[2] + ' de MAYO del ' + separated[0];
        break;
      case '06':
        return separated[2] + ' de JUNIO del ' + separated[0];
        break;
      case '07':
        return separated[2] + ' de JULIO del ' + separated[0];
        break;
      case '08':
        return separated[2] + ' de AGOSTO del ' + separated[0];
        break;
      case '09':
        return separated[2] + ' de SEPTIEMBRE del ' + separated[0];
        break;
      case '10':
        return separated[2] + ' de OCTUBRE del ' + separated[0];
        break;
      case '11':
        return separated[2] + ' de NOVIEMBRE del ' + separated[0];
        break;
      case '12':
        return separated[2] + ' de DICIEMBRE del ' + separated[0];
        break;
    }
  }

  function getHourFormat(hour) {
    var separated = hour.split(':');

    if (separated[0] > 12) {
      return getDayFormat(separated[0]) + ':' + separated[1] + ' PM';
    } else {
      return separated[0] + ':' + separated[1] + ' AM';
    }
  }

  function getDayFormat(day) {
    switch (day) {
      case '13':
        return '01';
        break;
      case '14':
        return '02';
        break;
      case '15':
        return '03';
        break;
      case '16':
        return '04';
        break;
      case '17':
        return '05';
        break;
      case '18':
        return '06';
        break;
      case '19':
        return '07';
        break;
      case '20':
        return '08';
        break;
      case '21':
        return '09';
        break;
      case '22':
        return '10';
        break;
      case '23':
        return '11';
        break;
      case '24':
        return '12';
        break;
    }
  }
</script>
@endsection