@extends('modules.academic')

@section('academics')
<div class="row">
  <div class="card col-md-12">
    <form id="formAchievementNew" action="{{ route('achievementConsolide.new') }}" method="POST">
      @csrf
      <div class="card-header text-center">
        <h6>FORMULARIO DE REGISTRO DE PROGRAMAS</h6>
      </div>
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <!-- SELECCION DE GRADO -->
            <small class="form-text text-muted">GRADO:</small>
            <select class="form-control form-control-sm" name="grade_id" id="grade_id" required>
              <option value="">Seleccione...</option>
              @foreach($grades as $grade)
              <option value="{{ $grade->id }}">{{ $grade->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <!-- SELECCION DE PERIODO -->
            <small class="form-text text-muted">PERIODO:</small>
            <select class="form-control form-control-sm" name="period_id" id="period_id" required>
              <option value="">Seleccione...</option>
              <!-- Select dinamico de periodos -->
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- FECHAS INICIAL ESTABLECIDA -->
            <small class="form-text text-muted">FECHA INICIO:</small>
            <input class="form-control form-control-sm" type="text" name="initialDate" id="initialDate" required readonly>
          </div>
          <div class="col-md-6">
            <!-- FECHAS FINAL ESTABLECIDA -->
            <small class="form-text text-muted">FECHA FINAL:</small>
            <input class="form-control form-control-sm" type="text" name="finalDate" id="finalDate" required readonly>
          </div>
        </div>
      </div>
      <div class="card-header">
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <!-- SELECCION DE CURSO -->
            <small class="form-text text-muted">CURSO:</small>
            <select class="form-control form-control-sm" name="course_id" id="course_id" required>
              <option value="">Seleccione...</option>
              <!-- Select dinamico de cursos -->
            </select>
          </div>
        </div>
      </div>
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <!-- SELECCION DE INTELIGENCIA -->
            <small class="form-text text-muted">INTELIGENCIA:</small>
            <select class="form-control form-control-sm" name="intelligence_id" id="intelligence_id" required="required">
              <option value="">Seleccione...</option>
              @foreach($intelligences as $intelligence)
              <option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <!-- SELECCION DE LOGRO -->
            <small class="form-text text-muted">LOGROS:</small>
            <select class="form-control form-control-sm" name="achievement_id" id="achievement_id" required="required">
              <option value="">Seleccione...</option>
              <!-- Select dinamico de logros -->
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- DESCRIPCION DE INTELIGENCIA -->
            <small class="form-text text-muted">DESCRIPCION DE INTELIGENCIA:</small>
            <textarea class="form-control form-control-sm" name="description_inteligence" id="description_inteligence" required readonly></textarea>
          </div>
          <div class="col-md-6">
            <!-- DESCRIPCION DE LOGRO -->
            <small class="form-text text-muted">DESCRIPCION DE LOGRO:</small>
            <textarea class="form-control form-control-sm" name="description_achievement" id="description_achievement" required readonly></textarea>
          </div>
        </div>
      </div>
      <div class="card-header">
        <div class="row">
          <div class="col-md-4 justify-content-center">
            <button id="saveConsolidated" type="submit" class="btn btn-outline-success m-4 form-control-sm">PROGRAMAR</button>
          </div>
          <div class="col-md-4">
            <div class="alert messages"></div>
          </div>
          <div class="col-md-4">
            <a href="{{ route('consolidatedAchievements.all') }}" class="btn btn-outline-primary m-4 form-control-sm">TABLA GENERAL</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


@section('scripts')
<script>
  $(document).ready(function() {
    $("#grade_id").on("change", function(e) {
      var grade_id = e.target.value;
      //Llenar select de los periodos
      $.get('subperiods', grade_id, function(periodsObject) {
        var count = Object.keys(periodsObject).length //total de periodos
        $('#period_id').empty();
        $('#period_id').append("<option value=''>Seleccione...</option>");
        $("#initialDate").val('');
        $("#finalDate").val('');
        for (var i = 0; i < count; i++) {
          $('#period_id').append('<option value=' + periodsObject[i]['id'] + '>' + periodsObject[i]['name'] + '</option>');
        }
        //Llenar select de los cursos
        $.get('subcourses', grade_id, function(coursesObject) {
          var count = Object.keys(coursesObject).length //total de cursos
          $('#course_id').empty();
          $('#course_id').append("<option value=''>Seleccione...</option>");
          for (var i = 0; i < count; i++) {
            $('#course_id').append('<option value=' + coursesObject[i]['id'] + '>' + coursesObject[i]['name'] + '</option>');
          }
        });
      });
    });
    $("#period_id").on("change", function(e) {
      var grade_id = $('#grade_id option:selected').val();
      var period_id = e.target.value;
      $.get('subranges', {
        period: period_id,
        grade: grade_id
      }, function(rangesObject) {
        //Lenar input con fechas
        $("#initialDate").val('');
        $("#initialDate").val(rangesObject[0]['initialDate']);
        $("#finalDate").val('');
        $("#finalDate").val(rangesObject[0]['finalDate']);
      });
    });

    //
    $("#intelligence_id").on("change", function(e) {
      var intelligence_id = e.target.value;
      //Llenar select de los logros
      $.get('subachievements', intelligence_id, function(achievementObject) {
        var count = Object.keys(achievementObject).length //total de logros
        $("#description_achievement").val('');
        $('#description_inteligence').val('');
        $('#achievement_id').empty();
        $('#achievement_id').append("<option value=''>Seleccione...</option>");
        if (achievementObject[0]) {
          $('#description_inteligence').val(achievementObject[0]['description']);
          if (count > 0) {
            for (var i = 0; i < count; i++) {
              console.log(achievementObject[i]['achievementId']);
              $('#achievement_id').append('<option value=' + achievementObject[i]['achievementId'] + '>' + achievementObject[i]['name'] + '</option>');
            }
          }
          $('.messages').empty();
          $('.messages').css('display', 'none');
        } else {
          $('.messages').css('display', 'flex');
          $('.messages').addClass('alert-secondary');
          $('.messages').html('No hay logros para la inteligencia seleccionada');
        }
      });
    });

    $("#achievement_id").on("change", function(e) {
      var achievement_id = e.target.value;
      $.get('subdescription', achievement_id, function(descriptionObject) {
        //Lenar descripcion de logro seleccionado
        $("#description_achievement").val('');
        $("#description_achievement").val(descriptionObject[0]['description']);
      });
    });


    //Guardar registro
    $('#saveConsolidated').click(function(e) {
      e.preventDefault();
      $('.messages').css('display', 'none');
      var url = "academic/achievement/new";
      $.ajax({
        type: "POST",
        url: url,
        data: $("#formAchievementNew").serialize(),
        success: function(data) {
          $('.messages').css('display', 'flex');
          $('.messages').removeClass('alert-success');
          $('.messages').addClass('alert-success');
          $('.messages').append('Registro correcto, consulta la tabla general');
          $("#formAchievementNew")[0].reset();
          setTimeout(function() {
            $('.messages').empty();
            $('.messages').css('display', 'none');
          }, 5000);
        },
        error: function(data) {
          $('.messages').css('display', 'flex');
          $('.messages').addClass('alert-secondary')
          $('.messages').empty();
          $('.messages').append('Registro incorrecto, Complete los campos');
          setTimeout(function() {
            $('.messages').empty();
            $('.messages').css('display', 'none');
          }, 5000);
        }
      });
    });


  });
</script>
@endsection