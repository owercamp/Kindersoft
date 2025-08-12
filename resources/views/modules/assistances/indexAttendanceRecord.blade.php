@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('registro de asistencia')}}</h5>
  @include('layouts.partial.alerts')

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registro de Asistencia</h4>
          <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>

        <div class="modal-body">

          <div class="modal-split">
            Para realizar una consulta seleccione la caja de busqueda:<br>
            <img src="{{ asset('videos/Welcome.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Welcome">
            <br>
          </div>

          <div class="modal-split">
            Puede realizar la consultas por Fecha, nombre del alumno, curso y hora.<br>
            <strong class="text-danger">Fecha:</strong> dia de la semana<br>
            <img src="{{ asset('videos/writeDay.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Day">
          </div>

          <div class="modal-split">
          Puede realizar la consultas por Fecha, nombre del alumno, curso y hora.<br>
            <strong class="text-danger">Fecha:</strong> dia del mes<br>
            <img src="{{ asset('videos/writeNumber.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Day">
          </div>

          <div class="modal-split">
          Puede realizar la consultas por Fecha, nombre del alumno, curso y hora.<br>
            <strong class="text-danger">Fecha:</strong> mes<br>
            <img src="{{ asset('videos/writeMonth.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Day">
          </div>

          <div class="modal-split">
          Puede realizar la consultas por Fecha, nombre del alumno, curso y hora.<br>
            <strong class="text-danger">Fecha:</strong> año<br>
            <img src="{{ asset('videos/writeYear.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Day">
          </div>

          <div class="modal-split">
          Puede realizar la consultas por Fecha, nombre del alumno, curso y hora.<br>
            <strong class="text-danger">Alumno:</strong><br>
            <img src="{{ asset('videos/writeStudent.gif') }}" width="450" height="200" style="margin-top: 0.5rem;" alt="Day">
          </div>

          <div class="modal-split">
            <strong>
              Gracias
            </strong>
          </div>

        </div>

        <div class="modal-footer">
          <!--Nothing Goes Here but is needed! -->
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">PDF ASISTENCIA</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form action="{{route('pdf.Assistences')}}" method="post">
            @csrf
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
                    <option value=""></option>
                    @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <small class="text-muted">{{ucfirst('curso')}}</small>
                  <select name="course" class="form-control form-control-sm select2">
                    <option value=""></option>
                    <!-- dinamic -->
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small>{{ucfirst('alumno')}}</small>
                  <select type="text" name="student" class="form-control form-control-sm select2">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="w-100 d-flex justify-content-center mb-3">
              <button class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> {{strtoupper('pdf')}}</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="button w-100 d-flex justify-content-center mb-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        GENERAR PDF
      </button>
    </div>

    <div class="table-responsive">
      <table class="table text-center table-striped w-100" id="AssisTable">
        <thead>
          <tr>
            <th>{{ucfirst('fecha')}}</th>
            <th>{{ucfirst('alumno')}}</th>
            <th>{{ucfirst('curso')}}</th>
            <th>{{ucwords('hora llegada')}}</th>
            <th>{{ucfirst('hora salida')}}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {

    $('#AssisTable').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [
        [0, 'asc']
      ],
      "ajax": {
        "url": "{{ route('getAsistences') }}",
        "dataType": "JSON",
        "type": "GET",
        "data": {
          "_token": "{{ csrf_token() }}"
        }
      },
      "columns": [{
          "data": 'date'
        },
        {
          "data": 'student'
        },
        {
          "data": 'course'
        },
        {
          "data": 'harrival'
        },
        {
          "data": 'hexit'
        }
      ],
      "responsive": true,
      // pagingType: "full_numbers",
      "language": {
        "processing": "Procesamiento en curso...",
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ registros",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros. ",
        "infoEmpty": "Mostrando dato 0 a 0 de 0 registros",
        "emptyTable": "No hay registros disponibles",
        "infoFiltered": "Filtrado de _MAX_ elementos totales",
        "infoPostFix": "",
        "loadingRecords": "Cargando...",
        "zeroRecords": "No hay registros para mostrar",
        "infoFiltered": "Filtrado de _MAX_ registros",
        "paginate": {
          "first": "|<",
          "previous": "<",
          "next": ">",
          "last": ">|"
        }
      }
    });

    setTimeout(prep_modal, 2000);
  });

  function prep_modal() {
    $("#myModal").modal({backdrop: 'static', keyboard: false});
    $("#myModal").each(function() {

      var element = this;
      var pages = $(this).find('.modal-split');

      if (pages.length != 0) {
        pages.hide();
        pages.eq(0).show();

        var b_button = document.createElement("button");
        b_button.setAttribute("type", "button");
        b_button.setAttribute("class", "btn btn-primary");
        b_button.setAttribute("style", "display: none;");
        b_button.innerHTML = "Anterior";

        var n_button = document.createElement("button");
        n_button.setAttribute("type", "button");
        n_button.setAttribute("class", "btn btn-primary");
        n_button.innerHTML = "Siguiente";

        $(this).find('.modal-footer').append(b_button).append(n_button);


        var page_track = 0;

        $(n_button).click(function() {

          this.blur();

          if (page_track == 0) {
            $(b_button).show();
          }

          if (page_track == pages.length - 3) {
            $(n_button).text("Cerrar");
          }

          if (page_track == pages.length - 2) {
            $(n_button).text("Cerrar").attr("data-dismiss","modal");
          }

          if (page_track == pages.length - 1) {
            $(element).find("form").hide();
          }

          if (page_track < pages.length - 1) {
            page_track++;

            pages.hide();
            pages.eq(page_track).show();
          }


        });

        $(b_button).click(function() {

          if (page_track == 1) {
            $(b_button).hide();
          }

          if (page_track == pages.length - 1) {
            $(n_button).text("Siguiente");
          }

          if (page_track > 0) {
            page_track--;

            pages.hide();
            pages.eq(page_track).show();
          }


        });

      }

    });
  }

  $('input[name=searchDate]').change(() => {
    $('input[name=datepdf]').val($('input[name=searchDate]').val());
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
</script>
@endsection