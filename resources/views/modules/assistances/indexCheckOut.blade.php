@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('registro de salida')}}</h5>
  @include('layouts.partial.alerts')
  <div class="container">
    <table id="tableDatatable" class="table text-center table-striped w-100">
      <thead>
        <tr>
          <th>{{ucfirst('fecha')}}</th>
          <th>{{ucfirst('alumno')}}</th>
          <th>{{ucfirst('curso')}}</th>
          <th>{{ucwords('hora llegada')}}</th>
          <th>{{ucfirst('acciones')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($registers as $register)
        @if($register->pre_hexit == null && $register->pre_texit == null && $register->pre_obse == null && $register->pre_status == "PRESENTE")
        <tr>
          <td>{{$register->pre_date}}</td>
          <td>{{$register->firstname." ".$register->threename." ".$register->fourname}}</td>
          <td>{{$register->name}}</td>
          <td>{{$register->pre_harrival}}</td>
          <td>
            <button title="Registrar Salida" class="btn btn-outline-primary exit">
              <i class="fas fa-sign-in-alt"></i>
              <span hidden>{{$register->pre_id}}</span>
            </button>
          </td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="ExitRegister">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5>{{ucwords('registrar salida')}}</h5>
        <button class="btn btn-sm btn-outline-secondary" data-dismiss="modal">&xwedge;</button>
      </div>
      <div class="modal-body">
        <p class="text-center">{{ucfirst('datos de llegada')}}</p>
        <div class="col-md-12 row">
          <div class="col-md-8">
            <div class="form-group">
              <small class="text-muted">{{ucfirst('alumno')}}</small>
              <p class="text-black" id="student"></p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <small class="text-muted">{{ucfirst('curso')}}</small>
              <p class="text-black" id="course"></p>
            </div>
          </div>
        </div>
        <div class="col-md-12 row">
          <div class="col md-4">
            <div class="form-group">
              <small class="text-muted">{{ucwords('hora llegada')}}</small>
              <p class="text-black" id="harrival"></p>
            </div>
            <div class="form-group">
              <small class="text-muted">{{ucwords('temp al llegar')}}</small>
              <p class="text-black" id="tarrival"></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <small class="text-muted">{{ucwords('observaciones')}}</small>
              <p id="obser" class="text-black"></p>
            </div>
          </div>
        </div>
        <hr>
        <p class="text-center">{{ucfirst('datos de salida')}}</p>
        <form action="{{route('check-out.save')}}" method="post">
          @csrf
          <input type="hidden" name="pre_id">
          <div class="col-md-12 row">
            <div class="col-md-4">
              <div class="form-group">
                <small>{{ucwords('hora:')}}</small>
                <div class="d-flex row justify-content-center mt-2">
                  <input id="hours" class="form-control form-control-sm w-25 mr-2 text-center Hours" name="hour" require>
                  :
                  <input id="mins" class="form-control form-control-sm w-25 ml-2 text-center Hours" name="min" require>
                </div>
              </div>
              <div class="form-group">
                <small class="text-muted">{{ucwords('temp al salir')}}</small>
                <input type="text" name="tExit" class="form-control form-control-sm">
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <small class="text-muted">{{ucwords('observaciones')}}</small>
                <textarea name="obse" cols="30" rows="6" class="form-control-sm form-control"></textarea>
              </div>
            </div>
          </div>
          <hr>
          <div class="d-flex justify-content-center">
            <button class="btn btn-info">{{ucwords('registrar salida')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $('.exit').click(function() {
    const id = $(this).find('span:nth-child(2)').text();
    $.ajax({
      "_token": "{{csrf_token()}}",
      url: "{{route('getInfoArrival')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        data: id
      },
      beforeSend() {
        Swal.fire({
          icon: "info",
          title: `<h4>Consultando Datos</h4>`,
          timer: 1500,
          showConfirmButton: false,
        })
      },
      success(response) {
        $('#student').text(`${response[0]['firstname']} ${response[0]['threename']} ${response[0]['fourname']}`);
        $('#course').text(`${response[0]['name']}`);
        $('#harrival').text(`${response[0]['pre_harrival']}`);
        $('#tarrival').text(`${response[0]['pre_tarrival']}`);
        $('#obser').text(`${response[0]['pre_obsa']}`);
        $('input[name=pre_id]').val(`${response[0]['pre_id']}`);
      },
      complete() {
        $('#ExitRegister').modal();
      }
    })
  });

  const hora = setInterval(() => {
    const now = new Date(),
      hours = now.toLocaleTimeString(),
      separateHours = hours.split(":"),
      hour = ("00" + separateHours[0]).slice(-2),
      min = ("00" + separateHours[1]).slice(-2);
    $('#hours').val(`${hour}`);
    $('#mins').val(`${min}`);
  }, 1000);

  $('#hours').focusin(() => {
    clearInterval(hora);
  });
  $('#mins').focusin(() => {
    clearInterval(hora);
  });
</script>
@endsection