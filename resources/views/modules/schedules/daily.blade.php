@extends('modules.schedules')

@section('scheduleModules')
<div class="container">
  <div class="col-md-12 w-100">
    INFORMACION DIARIA
  </div>
  <div class="container-fluid border border-primary p-2" style="min-height: 45rem;">
    <form action="{{ route('daily.save') }}" method="POST" enctype="multipart/form-data" name="infoDaily">
      @csrf
      <div class="col-12 row justify-content-around">
        <div>
          <div class="form-group p-2" style="font-size: 1.2rem;">
            <small>Fecha: </small><br>
            <small>{{ $myDate }}</small>
          </div>
        </div>
        <div class="form-group p-2 w-25" style="font-size: 1.2rem;">
          <small>Hora: </small><br>
          <small id="reloj"></small>
        </div>
      </div>
      <hr style="margin-top: -1rem;">
      <div class="w-100 text-center p-2">
        <span class="border-bottom border-primary text-monospace font-weight-bolder text-primary">CURSOS</span>
      </div>
      <div class="w-100 d-flex container flex-wrap">
        @foreach($Courses as $course)
        <div class="w-25 justify-content-center pr-3 pl-3" id="List">
          <input type="checkbox" name="{{ $course->name }}" value="{{ $course->name }}">
          <small style="vertical-align: text-top;">{{ $course->name }}</small>
        </div>
        @endforeach
      </div>
      <hr>
      <div class="w-100 d-flex justify-content-center p-2">
        <button type="button" class="btn btn-outline-secondary" onclick="searchStudents()">Consultar Alumnos</button>
      </div>
      <div class="w-75 container-fluid border-top border-bottom border-secondary p-2">
        <div class="spinner position-absolute" style="left: 0; right: 0; display: none;"></div>
        <div id="ListAlumns" name="ListAlumns" class="d-flex flex-wrap">
          <!-- dinamic -->
        </div>
        <textarea name="emailAttendants" cols="30" rows="10" hidden></textarea>
      </div>
      <hr>
      <div class="w-100 text-center p-2 row">
        <div class="w-50 border-right border-info">
          <span class="border-bottom border-primary text-monospace font-weight-bolder text-primary">SALUDO</span>
          <div class="container pt-2">
            <select name="myHi" class="form-control form-control-sm">
              <option value="">seleccione...</option>
              @foreach($Hellos as $hello)
              <option value="{{ $hello->sch_id }}">{{ $hello->sch_body }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="w-50">
          <span type="button" id="selContext" class="border-bottom border-primary text-monospace font-weight-bolder text-primary pr-1">SELECCIONAR CONTEXTO</span>
          <div class="container pt-2">
            <select id="contextSel" class="form-control form-control-sm">
              <option value="">seleccione...</option>
              @foreach($Context as $context)
              <option value="{{ $context->sch_id }}">{{ $context->sch_body }}</option>
              @endforeach
            </select>
            <textarea id="contextEsc" class="form-control-sm form-control" style="display: none;" placeholder="Contexto"></textarea>
            <textarea hidden name="Context" id="Context" cols="30" rows="10"></textarea>
          </div>
        </div>
      </div>
      <div class="w-100 text-center p-2 row">
        <div class="w-50 border-right border-dark">
          <span class="border-bottom border-primary text-monospace font-weight-bolder text-primary">CIRCULAR ADMINISTRATIVA</span>
          <div class="container pt-2">
            <select name="cirAdministrative" class="form-control form-control-sm">
              <option value="">seleccione...</option>
              @foreach($cirAdministrative as $administrative)
              <option value="{{ $administrative->acf_id }}">{{ $administrative->bcName }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="w-50">
          <span class="border-bottom border-primary text-monospace font-weight-bolder text-primary">CIRCULAR ACADEMICA</span>
          <div class="container pt-2">
            <select name="cirAcademic" class="form-control form-control-sm">
              <option value="">seleccione...</option>
              @foreach($cirAcademic as $academic)
              <option value="{{ $academic->acf_id }}">{{$academic->bcName}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="w-100 text-center p-2 d-flex justify-content-around">
        <span class="border-bottom border-primary text-monospace font-weight-bolder text-primary">CIRCULARES EXTERNAS</span>
        <input type="file" name="archives[]" multiple max="8" maxlength="8" class="w-50" id="archives">
      </div>
      <hr>
    </form>
    <div class="w-100 d-flex justify-content-center">
      <button class="btn btn-outline-dark" id="submit" onclick="send()">ENVIAR - GUARDAR</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let relojs = setInterval(myTimer, 1000);

  function myTimer() {
    var time = new Date();
    var timer = time.toLocaleTimeString();
    $('#reloj').text(timer);
  }

  let assign = [];

  function addAlumns(name) {
    if ($("input[name='" + name + "']").prop('checked')) {
      let documents = name.split("-");
      assign.push(documents[1]);
    } else if ($("input[name='" + name + "']").prop("checked", false)) {
      let documents = name.split("-");
      assign.forEach(element => {
        if (element == documents[1]) {
          let removeAlumns = assign.indexOf(element);
          assign.splice(removeAlumns, 1);
        }
      })
    }
  }

  function send() {
    var $fileUpload = $("input[type='file']");
    if (parseInt($fileUpload.get(0).files.length) > 8) {
      Swal.fire({
        icon: 'error',
        title: "ERROR",
        html: "<p class='text-secondary'>Solo puede cargar un máximo de <em>8</em> archivos<p>",
        showConfirmButton: false,
        timer: 3000
      })
    } else {
      $.ajax({
        url: "{{route('Emailers')}}",
        type: "GET",
        data: {
          data: assign,
        },
        dataType: "json",
        beforeSend() {
          Swal.fire({
            icon: 'info',
            title: 'Consultando correos de los acudientes',
            showConfirmButton: false,
          })
        },
        success(response) {
          let count = "";
          response.forEach(element => {
            if (element != "") {
              count += element[0]['correoacudiente1'] + "," + element[0]['correoacudiente2'] + ",";
            }
          });
          $('textarea[name=emailAttendants]').val(count);
        },
        complete() {
          Swal.fire({
            icon: 'success',
            title: 'Consulta terminada, enviando correos masivos',
            html: "<p class='text-info font-italic'>Por Favor Espere...</p>",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
          })
          $('form[name=infoDaily]').submit();
        }
      })
    }

  }

  $('#contextSel').change(function() {
    if ($(this).val() != "") {
      $("#contextEsc").val("");
      $("#Context").val($(this).val());
    }
  });

  $('#contextEsc').keypress(function() {
    if ($(this).val() != "") {
      $("#contextSel").val("");
      $("#Context").val($(this).val());
    }
  });

  $('#contextEsc').bind('paste', function(event) {
    event.preventDefault()
  });

  $('#selContext').click(function() {
    $(this).text(($(this).text() == 'SELECCIONAR CONTEXTO') ? 'ESCRIBIR CONTEXTO' : 'SELECCIONAR CONTEXTO');
    $('#contextEsc').toggle();
    $('#contextSel').toggle();
  });

  let course = [];

  function searchStudents() {
    $('.spinner').fadeIn(1000);
    $('#ListAlumns').fadeOut(1000);
    $('#ListAlumns').empty();
    $('textarea[name=emailAttendants]').val("");
    $.get("{{ route('getAlumnsList') }}", function(objectAlumns) {
      // console.log(objectAlumns);
      objectAlumns.forEach(element => {
        // console.log(element);
        course.forEach(elementcourse => {
          // console.log(elementcourse);
          if (element.name === elementcourse) {
            let name = element.firstname + " " + element.threename + " " + element.fourname + "-" + element.numberdocument;
            $('#ListAlumns').append("<div class='w-50 pr-3 pl-3'><input type='checkbox' name='" + name + "' onclick='addAlumns(name)'> " + "<small style='vertical-align: text-top;'>" + element.firstname + " " + element.threename + " " + element.fourname + "</small></div>")
            // console.log(element.firstname + " " + element.threename + " " + element.fourname);
            // console.log(element.name);
          }
        });
      });
    })
    $('#ListAlumns').fadeIn(1000);
    $('.spinner').fadeOut(1000);
  }

  // creación de la lista de cursos dinamicamente
  $('#List input').each(function(index, element) {
    $(element).click(function(e) {
      if (e.target.checked == true) {
        let val = $(element).val();
        course.push(val);
      } else if (e.target.checked == false) {
        let vale = $(this).val();
        course.forEach(element => {
          if (element == vale) {
            let pos = course.indexOf(element);
            course.splice(pos, 1);
          }
        });
      }
    })
  });
</script>
@if(session('SuccessMail') == "SuccessMail")
<script>
  Swal.fire({
    icon: 'success',
    title: "Complete",
    html: "<p class='text-secondary'>Gracias por esperar<p>",
    showConfirmButton: false,
    timer: 3000
  })
</script>
@endif
@endsection