@extends('modules.assistControl')

@section('infoMenuAssistances')
<div class="w-100">
  <h5>{{strtoupper('registro de asistencia')}}</h5>
  @include('layouts.partial.alerts')
  <div class="container">
    <div>
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
    })
  });

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