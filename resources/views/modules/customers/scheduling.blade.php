@extends('modules.customers')

@section('customersComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de clientes -->
      @if(session('PrimaryUpdateCustomer'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateCustomer') }}
      </div>
      @endif
      @if(session('SecondaryUpdateCustomer'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateCustomer') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de clientes -->
      @if(session('WarningDeleteCustomer'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteCustomer') }}
      </div>
      @endif
      @if(session('SecondaryDeleteCustomer'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteCustomer') }}
      </div>
      @endif
      @if(session('SuccessSaveScheduling'))
      <div class="alert alert-success">
        {{ session('SuccessSaveScheduling') }}
      </div>
      @endif
      @if(session('SecondarySaveScheduling'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveScheduling') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="{{ route('customer.new') }}" class="btn btn-outline-success mx-5 my-2 form-control-sm">REGISTRAR CLIENTE</a>
    </div>
  </div>
  <table id="tablecustomers" class="table table-responsive" width="100%">
    <thead>
      <tr>
        <th>NOMBRES</th>
        <th>TELEFONO</th>
        <th>CORREO</th>
        <th>ASPIRANTE</th>
        <th>EDAD</th>
        <th>OBSERVACION</th>
        <th style="min-width: 200px;">ACCIONES</th>
      </tr>
    </thead>
    <tbody>

      @for($i = 0; $i < count($customerInactive);$i++) <tr>
        <td>{{ $customerInactive[$i][1] }}</td>
        <td>{{ $customerInactive[$i][2] }}</td>
        <td>{{ $customerInactive[$i][3] }}</td>
        <td>{{ $customerInactive[$i][5] }}</td>
        <td>{{ $customerInactive[$i][6] }}</td>
        <td>{{ $customerInactive[$i][7] }}</td>
        <td>
          <a href="#" title="AGENDAR CITA" class="btn btn-outline-success rounded-circle scheduling-link">
            <i class="fas fa-calendar-plus"></i>
            <span hidden>{{ $customerInactive[$i][1] }}</span>
            <span hidden>{{ $customerInactive[$i][2] }}</span>
            <span hidden>{{ $customerInactive[$i][3] }}</span>
            <span hidden>{{ $customerInactive[$i][5] }}</span>
            <span hidden>{{ $customerInactive[$i][6] }}</span>
            <span hidden>{{ $customerInactive[$i][0] }}</span>
          </a>
          <a href="{{ route('customer.edit', $customerInactive[$i][0]) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <a href="{{ route('customer.delete', $customerInactive[$i][0]) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('- Se eliminará el cliente, tenga en cuenta que se eliminarán los agendamientos PENDIENTES que tenga el cliente, ¿Desea eliminar el cliente?')"><i class="fas fa-trash-alt"></i></a>
        </td>
        </tr>
        @endfor
    </tbody>
  </table>
</div>

<!-- Modal de re-agendamiento -->
<div class="modal fade" id="scheduling-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row p-3 m-3">
          <div class="col-md-12">
            <h5 class="text-muted">INFORMACION DE CLIENTE:</h5>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="row modal-body">
        <div class="col-md-6">
          <div class="row p-3 border-bottom">
            <div class="col-md-6 text-right">
              <b style="font-size: 12px;" class="text-muted">CLIENTE:</b><br>
              <b style="font-size: 12px;" class="text-muted">TELEFONO:</b><br>
              <b style="font-size: 12px;" class="text-muted">CORREO:</b><br>
              <b style="font-size: 12px;" class="text-muted">ASPIRANTE:</b><br>
              <b style="font-size: 12px;" class="text-muted">EDAD DE ASPIRANTE:</b><br>

            </div>
            <div class="col-md-6 text-left">
              <b style="font-size: 12px;" class="text-muted name-scheduling"></b><br>
              <b style="font-size: 12px;" class="text-muted phone-scheduling"></b><br>
              <b style="font-size: 12px;" class="text-muted mail-scheduling"></b><br>
              <b style="font-size: 12px;" class="text-muted child-scheduling"></b><br>
              <b style="font-size: 12px;" class="text-muted yearschild-scheduling"></b><br>
            </div>
          </div>
          <form action="{{ route('scheduling.only') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-md-12 text-left">
                <h6 class="text-muted">NUEVA VISITA:</h6>
              </div>
            </div>
            <div class="row p-2 border-top">
              <input type="hidden" name="schCustomer_id" class="form-control form-control-sm" required>
              <div class="col-md-4">
                <div class="form-group">
                  <small>FECHA:</small>
                  <input type="text" name="schDateVisit" class="form-control form-control-sm datepicker" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <small>DIA:</small>
                  <input type="text" name="schDayVisit" class="form-control form-control-sm" readonly required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <small>HORA:</small>
                  <input type="time" name="schHourVisit" class="form-control form-control-sm" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-outline-success">AGENDAR</button>
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

@endsection

@section('scripts')
<script>
  $(function() {

  });

  $('.scheduling-link').on('click', function(e) {
    e.preventDefault();

    var name = $(this).find('span:nth-child(2)').text();
    var phone = $(this).find('span:nth-child(3)').text();
    var mail = $(this).find('span:nth-child(4)').text();
    var child = $(this).find('span:nth-child(5)').text();
    var yearschild = $(this).find('span:nth-child(6)').text();
    var cusId = $(this).find('span:nth-child(7)').text();
    $('.name-scheduling').text('');
    $('.name-scheduling').text(name);
    $('.phone-scheduling').text('');
    $('.phone-scheduling').text(phone);
    $('.mail-scheduling').text('');
    $('.mail-scheduling').text(mail);
    $('.child-scheduling').text('');
    $('.child-scheduling').text(child);
    $('.yearschild-scheduling').text('');
    $('.yearschild-scheduling').text(yearschild);
    $('input[name=schCustomer_id]').val('');
    $('input[name=schCustomer_id]').val(cusId);

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
    $('#scheduling-modal').modal();
  });

  $('input[name=schDateVisit]').on('change', function() {
    var dateNow = $(this).val();
    var date = new Date(dateNow);
    $('input[name=schDayVisit]').val('');
    $('input[name=schDayVisit]').val(getDay(date.getUTCDay()));

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