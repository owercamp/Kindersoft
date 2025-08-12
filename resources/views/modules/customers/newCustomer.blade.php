@extends('modules.customers')

@section('customersComercial')
<div class="row">
  <div class="card col-md-12">
    <div class="row">
      <div class="col-md-6">
        <!-- Mensajes de actualizacion de clientes -->
        @if(session('SuccessSaveCustomer'))
        <div class="alert alert-success">
          {{ session('SuccessSaveCustomer') }}
        </div>
        @endif
        @if(session('SecondarySaveCustomer'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveCustomer') }}
        </div>
        @endif
      </div>
      <div class="col-md-6 align-items-center">
        <a href="{{ route('customers') }}" class="btn btn-outline-tertiary  mt-5 form-control-sm"> VOLVER A LA TABLA GENERAL</a>
      </div>
    </div>
    <form action="{{ route('customer.save') }}" method="POST">
      @csrf
      <div class="card-body col-md-12">
        <small class="text-muted">DATOS DE CLIENTE</small>
        <div class="row border-bottom">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">Nombres:</small>
              <input type="text" name="cusFirstname" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <small class="text-muted">Apellidos:</small>
              <input type="text" name="cusLastname" class="form-control form-control-sm" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <small class="text-muted">Correo electrónico:</small>
                  <input type="email" name="cusMail" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Número de contacto:</small>
                  <input type="number" name="cusPhone" class="form-control form-control-sm" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Forma de contacto:</small>
                  <select name="cusContact" class="form-control form-control-sm select2" required>
                    <option value="">Seleccione una opción...</option>
                    <option value="LLAMADA TELEFÓNICA">LLAMADA TELEFÓNICA</option>
                    <option value="VISITA PUERTA">VISITA PUERTA</option>
                    <option value="PÁGINA WEB">PÁGINA WEB</option>
                    <option value="REDES SOCIALES">REDES SOCIALES</option>
                    <option value="CORREO ELECTRÓNICO">CORREO ELECTRÓNICO</option>
                    <option value="OTRO">OTRO</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin de fila -->
        <small class="text-muted">DATOS DE ASPIRANTE</small>
        <div class="row border-bottom">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <small class="text-muted">Nombres:</small>
                  <input type="text" name="cusChild" class="form-control form-control-sm" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Años:</small>
                  <input type="text" name="cusChildYears" maxlength="1" pattern="[0-9]{1,1}" class="form-control form-control-sm text-center" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Meses:</small>
                  <input type="text" name="cusChildMount" maxlength="2" pattern="[0-9]{1,2}" class="form-control form-control-sm text-center" required>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted">Nota:</small>
              <textarea type="text" id="cusNotes" name="cusNotes" class="form-control form-control-sm" required placeholder="Máximo de 200 caracteres" maxlength="200"></textarea>
              <small class="text-muted">Carácteres restantes: <b id="lenChar"></b></small>
            </div>
          </div>
        </div>
        <div class="row border-bottom border-top">
          <div class="col-md-4 text-center">
            <small class="text-muted">AGENDARLE CITA A CLIENTE:</small>
          </div>
          <div class="col-md-4 text-center">
            <small class="text-muted">
              <input type="radio" name="schedule" value="SI" checked>
              Con agendamiento
            </small>
          </div>
          <div class="col-md-4 text-center">
            <small class="text-muted">
              <input type="radio" name="schedule" value="NO">
              Solo registro
            </small>
          </div>
        </div>
        <div id="schedule" class="row border-bottom">
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">Fecha:</small>
              <input type="text" name="cusDateVisit" class="form-control form-control-sm datepicker" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">Dia:</small>
              <input type="text" name="cusDayVisit" class="form-control form-control-sm" readonly required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">Hora:</small>
              <input type="time" name="cusHourVisit" class="form-control form-control-sm" required>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR CLIENTE</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('#lenChar').html('200 / 200');

    $('input[name=cusDateVisit]').on('change', function() {
      var dateNow = $(this).val();
      var date = new Date(dateNow);
      $('input[name=cusDayVisit]').val('');
      $('input[name=cusDayVisit]').val(getDay(date.getUTCDay()));
    });

    $('textarea#cusNotes').on('keyup', function() {
      var len = $(this).val().length;
      $('#lenChar').html(200 - len + ' / 200');
    });


    $('input[name=schedule]').on('change', function() {
      //alert($(this).val());
      if ($(this).val() === 'NO') {
        $('input[name=cusDateVisit]').attr('required', false);
        $('input[name=cusDayVisit]').attr('required', false);
        $('input[name=cusHourVisit]').attr('required', false);
        $('#schedule').css('display', 'none');
      } else {
        $('input[name=cusDateVisit]').attr('required', true);
        $('input[name=cusDayVisit]').attr('required', true);
        $('input[name=cusHourVisit]').attr('required', true);
        $('#schedule').css('display', 'flex');
      }
    });
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

  $('input[name=cusChildYearsold]').on('change', function(e) {
    // calculateBirthdate(e.target.value);
  });

  function calculateBirthdate(date) {
    if (date != '') {
      var values = date.split("/");
      var day = values[2];
      var mount = values[1];
      var year = values[0];
      var now = new Date();
      var date = new Date(date);
      if (now >= date) {
        var yearNow = now.getYear()
        var mountNow = now.getMonth() + 1;
        var dayNow = now.getDate();
        //Cálculo de años
        var old = (yearNow + 1900) - year;
        if (mountNow < mount) {
          old--;
        }
        if ((mount == mountNow) && (dayNow < day)) {
          old--;
        }
        if (old > 1900) {
          old -= 1900;
        }
        //Cálculo de meses
        var mounts = 0;
        if (mountNow > mount) {
          mounts = mountNow - mount;
        }
        if (mountNow < mount) {
          mounts = 12 - (mount - mountNow);
        }
        if (mountNow == mount && day > dayNow) {
          mounts = 11;
        }
        //Cálculo de dias
        var days = 0;
        if (dayNow > day) {
          days = dayNow - day
        }
        if (dayNow < day) {
          lastDayMount = new Date(yearNow, mountNow, 0);
          days = lastDayMount.getDate() - (day - dayNow);
        }
        $('input[name=cusChildYears]').val(old);
        $('input[name=cusChildMount]').val(mounts);
        //$('#dayold').val(days); //Opcional para mostrar dias también
      } else {
        $('input[name=cusChildYears]').val('');
        $('input[name=cusChildMount]').val('');
      }
    }
  }
</script>
@endsection