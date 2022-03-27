@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('estadistica de asistencia')}}</h5>
  <div class="container">
    <div class="col-md-12 row my-3">
      <div class="col-md-3">
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
      <div class="col-md-3">
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
  </div>
  <hr>
  <div class="container">
    <canvas id="statisticPresences" width="300" height="150"></canvas>
  </div>
</div>
@endsection

@section('scripts')
<script>
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

  $('select[name=student]').change(() => {
    const Student = $('select[name=student]').val();
    $.ajax({
      "_token": "{{csrf_token()}}",
      url: "{{route('getAssistAnual')}}",
      type: "POST",
      dataType: "JSON",
      data: {
        student: Student
      },
      success(response) {
        let Months = [
          'Enero',
          'Febrero',
          'Marzo',
          'Abril',
          'Mayo',
          'Junio',
          'Julio',
          'Agosto',
          'Septiembre',
          'Octubre',
          'Noviembre',
          'Diciembre'
        ];
        let Assitences = [],
          Absences = [];
        let countAssit = 0,
          countAbsence = 0;
        for (const iterator of Months) {
          countAssit = 0, countAbsence = 0;
          response.forEach(element => {
            const separateDate = element.pre_date.split(" ");
            if (iterator.toLocaleLowerCase() === separateDate[3] && element.pre_status == "PRESENTE") {
              countAssit += 1;
            } else if (iterator.toLocaleLowerCase() === separateDate[3] && element.pre_status == "AUSENTE") {
              countAbsence += 1;
            }
          });
          Assitences.push(countAssit);
          Absences.push(countAbsence);
        }
        const graphics = () => {
          const ctx = document.getElementById('statisticPresences');
          const myChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
              datasets: [{
                label: 'Asistencia',
                data: Assitences,
                backgroundColor: [
                  'rgba(63, 191, 84, 0.2)',
                ],
                borderColor: [
                  'rgba(63, 191, 84, 1)',
                ],
                borderWidth: 1
              }, {
                label: 'Ausencia',
                data: Absences,
                backgroundColor: [
                  'rgba(253, 1, 1, 0.2)',
                ],
                borderColor: [
                  'rgba(253, 1, 1, 1)',
                ],
                borderWidth: 1
              }]
            },
            options: {
              elements: {
                point: {
                  radius: 5,
                  backgroundColor: 'rgba(255, 255, 255, 1)',
                  borderColor: '#000'
                }
              },
              title: {
                display: true,
                text: 'Graficá de Asistencia',
                fontSize: 20,
                fontColor: 'rgb(0, 123, 255)'
              },
              scales: {
                y: {
                  beginAtZero: true
                }
              },
              tooltips: {
                mode: 'index',
                axis: 'y',
                backgroundColor: 'rgba(0, 123, 255, .8)',
                titleFontSize: 15,
                position: 'nearest',
                bodyFontSize: 13
              }
            }
          });
        }
        graphics();
      }
    })
  })
</script>
@endsection