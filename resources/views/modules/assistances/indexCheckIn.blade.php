@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('registro de llegada')}}</h5>
  @include('layouts.partial.alerts')
  <div class="container p-3">
    <form action="{{route('check-in.save')}}" method="post" class="shadow border rounded-sm p-3">
      @csrf
      <div class="col-md-12 row">
        <div class="col-md-4">
          <div class="form-group">
            <small>{{ucwords('fecha:')}}</small>
            <div>{{ucfirst($day." ".$date)}}</div>
            <input type="hidden" name="date" value="{{ucfirst($day.' '.$date)}}" aria-hidden=true>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <small>{{ucwords('hora:')}}</small>
            <div class="d-flex row justify-content-center">
              <input id="hours" class="form-control form-control-sm w-25 mr-2 text-center Hours" name="hour" require>
              :
              <input id="mins" class="form-control form-control-sm w-25 ml-2 text-center Hours" name="min" require>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <small>{{ucwords('grado')}}</small>
            <select name="Grades" class="form-control form-control-sm select2" require>
              <option value="">{{ucfirst('seleccione...')}}</option>
              @foreach($grades as $grade)
              <option value="{{$grade->id}}">{{$grade->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <small>{{ucwords('curso')}}</small>
            <select name="course" class="form-control form-control-sm select2" require>
              <option value="">{{ucfirst('seleccione...')}}</option>
              <!-- dinamic -->
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="w-100 text-center">
        <p class="text-primary">{{strtoupper('datos de ingreso')}}</p>
      </div>
      <div class="col-md-12 row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <small>{{ucfirst('alumno')}}</small>
                <select type="text" name="student" class="form-control form-control-sm select2" require>
                  <option value="">{{ucfirst('seleccione...')}}</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <small>{{ucfirst('temperatura')}}</small>
                <input type="text" name="temp" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="w-100 d-flex">
            <button type="submit" class="btn btn-outline-success m-auto">{{ucfirst('guardar')}}</button>
          </div>
          <div>
            <span class="form-group pt-3">
              <span class="text-muted"><b>{{ucfirst('nota:')}}</b></span><br>
              <span class="text-info">Para registrar una <b>ausencia</b> se debe dejar la <b><i>hora en blanco</i></b></span>
            </span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small>{{ucfirst('observaciones')}}</small>
            <textarea name="obs" cols="30" rows="10" class="form-control-sm form-control"></textarea>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
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
        let students = [];
        $("select[name=student]").empty();
        $("select[name=student]").append("<option value=''>Seleccione...</option>");
        response.forEach(student => {
          students.push(student);
        });
        $.get("{{route('getAsistences')}}", function(objectAssistances) {

          for (const iterator of students) {
            objectAssistances.forEach(element => {
              if (element.pre_student === iterator.id) {
                let position = students.indexOf(iterator);
                students.splice(position, 1);
              }
            });
          }
          students.forEach(Absence => {
            $('select[name=student]').append("<option value='" + Absence.id + "'>" + Absence.firstname + " " + Absence.threename + " " + Absence.fourname + "</option>");
          });
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
</script>
@endsection