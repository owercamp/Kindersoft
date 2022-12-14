@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('registro de ausencia')}}</h5>
  @include('layouts.partial.alerts')
  <div class="container">
    <div class="w-100 d-flex justify-content-lg-center">
      <form action="{{route('pdf.Absences')}}" method="post">
        @csrf
        <button class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> {{strtoupper('pdf')}}</button>
      </form>
    </div>
    <div class="container">
      <div class="container position-fixed d-flex justify-content-center" style="padding-top: 10em;">
        <i class="fas fa-spinner fa-pulse text-primary" style="width: 3em; height: 3em;" id="Spinner"></i>
      </div>
      <div class="col-md-12 row my-3">
        <div class="col-md-2 border-right border-secondary">
          <div class="form-group">
            <small class="text-muted">{{ucfirst('fecha')}}</small>
            <input type="date" name="searchDate" class="form-control form-control-sm">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <small class="text-muted">{{ucfirst('grado')}}</small>
            <select name="Grades" class="form-control form-control-sm select2">
              <option value="">{{ucfirst('seleccione...')}}</option>
              @foreach($grades as $grade)
              <option value="{{$grade->id}}">{{$grade->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <small class="text-muted">{{ucfirst('curso')}}</small>
            <select name="course" class="form-control form-control-sm select2">
              <option value="">{{ucfirst('seleccione...')}}</option>
              <!-- dinamic -->
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small>{{ucfirst('alumno')}}</small>
            <select type="text" name="student" class="form-control form-control-sm select2" require>
              <option value="">{{ucfirst('seleccione...')}}</option>
            </select>
          </div>
        </div>
      </div>
      <table class="table text-center table-striped w-100" id="AssistTable">
        <thead>
          <tr>
            <th>{{ucfirst('fecha')}}</th>
            <th>{{ucfirst('alumno')}}</th>
            <th>{{ucfirst('curso')}}</th>
            <th>{{ucwords('estado')}}</th>
            <th>{{ucfirst('acciones')}}</th>
          </tr>
        </thead>
        <tbody id="MyData" class="hidden">
          <!-- dinamic -->
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $('select[name=student]').change(() => {
    const student = $('select[name=student]').val();
    $.ajax({
      "_method": "{{csrf_token()}}",
      url: "{{route('getDataStudent')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        student: student
      },
      beforeSend() {
        $("#MyData").fadeOut(1);
        $("#Spinner").fadeIn(1);
      },
      success(response) {
        $('#MyData').empty();
        response.forEach(element => {
          let envio;
          if (element.pre_status == "PRESENTE") {
            envio = `<td class="text-danger">NO APLICA</td>
          <td></td>`;
          } else {
            envio = `<td class="text-danger">${element.pre_status_mail}</td>
          <td><button class="btn btn-outline-dark"><i class="fas fa-mail-bulk"></i><span hidden>${element.pre_id}</span></button></td>`;
          }
          $('#MyData').append(`<tr>
          <td>${element.pre_date}</td>
          <td>${element.firstname} ${element.threename} ${element.fourname}</td>
          <td>${element.name}</td>
          ${envio}
          </tr>`)
        });
      },
      complete() {
        $("#Spinner").fadeOut(2500);
        $("#MyData").fadeIn(2500);
      }
    })
  });

  $('input[name=searchDate]').change(() => {
    const dt = $('input[name=searchDate]').val();
    $.ajax({
      "_token": "{{csrf_token()}}",
      url: "{{route('getAbsenceDate')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        dt: dt
      },
      beforeSend() {
        $("#MyData").fadeOut(1);
        $("#Spinner").fadeIn(1);
      },
      success(response) {
        $('#MyData').empty();
        response.forEach(element => {
          let envio;
          if (element.pre_status == "PRESENTE") {
            envio = "NO APLICA";
          } else {
            envio = element.pre_status_mail;
          }
          $('#MyData').append(`<tr>
          <td>${element.pre_date}</td>
          <td>${element.firstname} ${element.threename} ${element.fourname}</td>
          <td>${element.name}</td>
          <td class="text-danger">${envio}</td>
          <td><button class="btn btn-outline-dark"><i class="fas fa-mail-bulk"></i><span hidden>${element.pre_id}</span></button></td>
          </tr>`)
        });
      },
      complete() {
        $("#Spinner").fadeOut(2500);
        $("#MyData").fadeIn(2500);
      }
    })
  });

  $('select[name=course]').change(() => {
    const course = $('select[name=course]').val();
    $.ajax({
      "_token": "{{csrf_token()}}",
      url: "{{route('getStudent')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        course: course
      },
      beforeSend() {
        Swal.fire({
          icon: 'info',
          title: `<h5>Consultando Alumnos</h5>`,
          showConfirmButton: false
        })
      },
      success(response) {
        $("select[name=student]").empty();
        $("select[name=student]").append("<option value=''>Seleccione...</option>");
        response.forEach(student => {
          $('select[name=student]').append("<option value='" + student.id + "'>" + student.firstname + " " + student.threename + " " + student.fourname + "</option>");
        });
      },
      complete() {
        Swal.fire({
          icon: 'success',
          title: `<h5>Consulta Completa</h5>`,
          timer: 1000,
          showConfirmButton: false
        })
      }
    });
  });

  $('select[name=Grades]').change(() => {
    const grade = $('select[name=Grades]').val();
    $.ajax({
      "_token": "{{csrf_token()}}",
      url: "{{route('getGrade')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        grade: grade
      },
      beforeSend() {
        Swal.fire({
          icon: 'info',
          title: `<h5>Consultando cursos del grado: <i class="text-primary text-uppercase">kinder ${grade}</i></h5>`,
          html: `<b>espere por favor...</b>`,
          showConfirmButton: false
        })
      },
      success(response) {
        $("select[name=course]").empty();
        $("select[name=course]").append("<option value=''>Seleccione...</option>");
        response.forEach(course => {
          $("select[name=course]").append("<option value='" + course.id + "'>" + course.name + "</option>");
        });
      },
      complete() {
        Swal.fire({
          icon: 'success',
          title: `<h5>Consulta Completa</h5>`,
          timer: 1000,
          showConfirmButton: false
        })
      }
    });
  });

  const nowData = () => {
    $.ajax({
      "_token": "csrf_token()",
      type: "POST",
      url: "{{ route('getAbsence')}}",
      dataType: "JSON",
      beforeSend() {
        Swal.fire({
          icon: "info",
          title: `<h3 class="text-info">Consultando Registros</h3>`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      beforeSend() {
        $("#MyData").fadeOut(1);
        $("#Spinner").fadeIn(1);
      },
      success(response) {
        $('#MyData').empty();
        response.forEach(element => {
          let envio;
          if (element.pre_status == "PRESENTE") {
            envio = "NO APLICA";
          } else {
            envio = element.pre_status_mail;
          }
          $('#MyData').append(` <tr>
          <td>${element.pre_date}</td>
          <td>${element.firstname} ${element.threename} ${element.fourname}</td>
          <td>${element.name}</td>
          <td class="text-danger">${envio}</td>
          <td><button class="btn btn-outline-dark" onclick="mail(${element.pre_id})"><i class="fas fa-mail-bulk"></i></button></td>
          </tr>`)
        });
      },
      complete() {
        $("#Spinner").fadeOut(2500);
        $("#MyData").fadeIn(2500);
      }
    })
  }
  nowData();

  const mail = (mail) => {
    const inf = mail;
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('MailSend')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        data: inf
      },
      beforeSend() {
        Swal.fire({
          title: `<h4 class="text-monospace text-primary">Enviando Correo</h4>`,
          showConfirmButton: false,
        })
      },
      success(response) {
        if (response.length > 0) {
          Swal.fire({
            icon: "success",
            title: `<h4 class="text-monospace text-success">Correo Enviado</h4>`,
            timer: 1500,
            showConfirmButton: false
          })
        }
      }
    })
  }
</script>
@endsection