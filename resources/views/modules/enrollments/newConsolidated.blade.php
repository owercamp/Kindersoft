@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <div class="row">
        <h3>NUEVA ORDEN DE MATRICULA</h3>
      </div>
      <diw class="row text-center">
        <a href="{{ route('consolidatedEnrollment') }}" class="btn btn-outline-tertiary  form-control-sm">VER TODAS LAS MATRICULAS</a>
      </diw>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de consolidado de matriculas -->
      @if(session('SuccessNewConsolidatedEnrollment'))
      <div class="alert alert-success">
        {{ session('SuccessNewConsolidatedEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryNewConsolidatedEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryNewConsolidatedEnrollment') }}
      </div>
      @endif
      <div class="alert alert-primary message-enroll"></div>
    </div>
  </div>
  <form id="formConsolidatedEnrollment" action="" method="POST">
    @csrf
    <div class="row border-top mt-4">
      <!-- DATOS PRINCIPALES DE ESTUDIANTE -->
      <div class="col-md-4 border-right border-bottom">
        <div class="form-group">
          <small class="text-muted"><b>ALUMNO</b></small>
          <select id="conenStudent" name="conenStudent" class="form-control form-control-sm select2" required>
            <option value="">SELECCIONE UN ALUMNO...</option>
            @foreach($students as $student)
            @if ($student->status == 'ACTIVO')
            <option value="{{ $student->id }}">{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</option>
            @endif
            @endforeach
          </select>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>TIPO DE DOCUMENTO</b></small>
              <input type="text" name="conenTypeDocumentStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>NUMERO DE DOCUMENTO</b></small>
              <input type="text" name="conenNumberDocumentStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>FECHA DE NACIMIENTO</b></small>
              <input type="text" name="conenBirthdateStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>EDAD AÑO-MESES</b></small>
              <input type="text" name="conenYearsoldStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
      </div>
      <!-- DATOS SOBRE SALUD DE ESTUDIANTE -->
      <div class="col-md-4 border-right border-bottom">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>GENERO</b></small>
              <input type="text" name="conenGenderStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>TIPO DE SANGRE</b></small>
              <input type="text" name="conenBloodtypeStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>CENTRO DE SALUD</b></small>
              <input type="text" name="conenHealtStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>SALUD ADICIONAL</b></small>
              <input type="text" name="conenAdditionalHealtStudent" class="form-control form-control-sm text-center" readonly required>
              <textarea type="text" name="conenAdditionalHealtDescriptionStudent" class="form-control form-control-sm" readonly required>
								</textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- UBICACION DE ESTUDIANTE -->
      <div class="col-md-4 border-bottom">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>CIUDAD</b></small>
              <input type="text" name="conenCityStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>LOCALIDAD</b></small>
              <input type="text" name="conenLocationStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <small class="text-muted"><b>BARRIO</b></small>
              <input type="text" name="conenDistrictStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>DIRECCION</b></small>
              <input type="text" name="conenAddressStudent" class="form-control form-control-sm" readonly required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted"><b>ESTADO DE DOCUMENTACION</b></small>
              <span id="conenStatus" class="form-control form-control-sm badge badge-warning" style="color: #fff; font-weight: bold;">PENDIENTE</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row py-2 border-bottom">
      <h4 class="text-muted ml-5">LISTA DE DOCUMENTACION</h4>
    </div>
    <div class="row text-center mb-3">
      <div class="col-md-8">
        <div class="form-group progress checkprogress">
          <small class="text-muted"><b>PROGRESO</b></small>
          <input type="progress" class="progress-bar progress-bar-striped bg-warning ml-2" readonly value="0%" style="font-weight: bold; font-size: 20px;">
        </div>
      </div>
      <div class="col-md-4" style="text-align: center; background: rgba(0,134,249,1); color: #fff;">
        <h3 class="info_progress"></h3>
      </div>
    </div>
    <div class="row" id="checkItems">
      <div class="col-md-12">
        @foreach($requirements as $requirement)
        <div class="row border-bottom">
          <div class="col-md-12">
            <div class="input-group form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text form-control-sm">
                    @if($requirement->deRequired == 'SI')
                    <small class="text-muted mr-3" style="font-weight: bold;">{{ $requirement->dePosition }}</small>
                    <input type="checkbox" name="itemCheck" class="form-control-sm itemCheck-enroll" value="{{ $requirement->deConcept }}-ENTREGADO">
                    @else
                    <small class="text-muted mr-3" style="font-weight: bold;">{{ $requirement->dePosition }}</small>
                    <input type="checkbox" name="itemCheck-optional" class="form-control-sm itemCheck-enroll" value="{{ $requirement->deConcept }}-ENTREGADO">
                    @endif
                  </span>
                </div>
                <span class="input-group-text form-control form-control-sm"><b>{{ $requirement->deConcept }}</b></span>
                @if($requirement->deRequired == 'SI')
                <span class="input-group-text form-control form-control-sm"><b>{{ __('OBLIGATORIO') }}</b></span>
                @else
                <span class="input-group-text form-control form-control-sm"><b>{{ __('OPCIONAL') }}</b></span>
                @endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="row text-center mb-3">
      <div class="col-md-8">
        <div class="form-group progress checkprogress">
          <small class="text-muted"><b>PROGRESO</b></small>
          <input type="progress" class="progress-bar progress-bar-striped bg-warning ml-2" readonly value="0%" style="font-weight: bold; font-size: 20px;">
        </div>
      </div>
      <div class="col-md-4" style="text-align: center; background: rgba(0,134,249,1); color: #fff;">
        <h3 class="info_progress"></h3>
      </div>
    </div>
    <div class="row text-center">
      <button id="btnFormSaveConsolidatedEnrollment" type="submit" class="btn btn-outline-success form-control-sm">GUARDAR PROCESO</button>
    </div>
  </form>
</div>
@endsection


@section('scripts')
<script>
  $(function() {
    $('.message-enroll').css('display', 'none');
    refreshProgress();
  });

  $('#checkItems').on('click', 'input[name=itemCheck]', function() {
    refreshProgress();
  });

  function refreshProgress() {
    $('input[type=progress]').attr('max', 100 + '%');
    var itemsCount = $('input[name=itemCheck]').length;
    var nowValue = 0;
    $('input[name=itemCheck]:checked').each(function() {
      nowValue++;
    });
    var newValue = (nowValue * 100) / itemsCount;
    $('input[type=progress]').attr('style', 'width:' + newValue + '%;');
    $('input[type=progress]').val('');
    $('input[type=progress]').val(newValue.toFixed(1) + '%');
    $('h3.info_progress').text('');
    $('h3.info_progress').text(newValue.toFixed(1) + '%');
    if (newValue < 100) {
      $('input[type=progress]').removeClass('bg-success');
      $('input[type=progress]').addClass('bg-warning');
      $('#conenStatus').removeClass('badge-success');
      $('#conenStatus').addClass('badge-warning');
      $('#conenStatus').text('PENDIENTE');
      $('#btnFormSaveConsolidatedEnrollment').text('GUARDAR PROCESO');
    } else {
      $('input[type=progress]').removeClass('bg-warning');
      $('input[type=progress]').addClass('bg-success');
      $('#conenStatus').removeClass('badge-warning');
      $('#conenStatus').addClass('badge-success');
      $('#conenStatus').text('COMPLETADO');
      $('#btnFormSaveConsolidatedEnrollment').text('FINALIZAR MATRICULA');
    }
  }

  $('select[name=conenStudent]').on('change', function(e) {
    var selectedStudent = e.target.value;
    if (selectedStudent > 0 && selectedStudent != '') {
      $.get("{{ route('conenStudentSelected') }}", {
        selectedStudent: selectedStudent
      }, function(objectStudent) {
        $('input[name=conenTypeDocumentStudent]').val('');
        $('input[name=conenTypeDocumentStudent]').val(objectStudent['type']);
        $('input[name=conenNumberDocumentStudent]').val('');
        $('input[name=conenNumberDocumentStudent]').val(objectStudent['numberdocument']);
        $('input[name=conenBirthdateStudent]').val('');
        $('input[name=conenBirthdateStudent]').val(objectStudent['birthdate']);
        $('input[name=conenYearsoldStudent]').val('');
        $('input[name=conenYearsoldStudent]').val(objectStudent['yearsold']);
        $('input[name=conenGenderStudent]').val('');
        $('input[name=conenGenderStudent]').val(objectStudent['gender']);
        $('input[name=conenBloodtypeStudent]').val('');
        $('input[name=conenBloodtypeStudent]').val(objectStudent['groupBlood'] + ' ' + objectStudent['typeBlood']);
        $('input[name=conenHealtStudent]').val('');
        $('input[name=conenHealtStudent]').val(objectStudent['entityHealth'] + ' - ' + objectStudent['typeHealth']);
        $('input[name=conenAdditionalHealtStudent]').val('');
        $('input[name=conenAdditionalHealtStudent]').val(objectStudent['additionalHealt']);
        $('textarea[name=conenAdditionalHealtDescriptionStudent]').val('');
        $('textarea[name=conenAdditionalHealtDescriptionStudent]').val(objectStudent['additionalHealtDescription']);
        $('input[name=conenCityStudent]').val('');
        $('input[name=conenCityStudent]').val(objectStudent['nameCity']);
        $('input[name=conenLocationStudent]').val('');
        $('input[name=conenLocationStudent]').val(objectStudent['nameLocation']);
        $('input[name=conenDistrictStudent]').val('');
        $('input[name=conenDistrictStudent]').val(objectStudent['nameDistrict']);
        $('input[name=conenAddressStudent]').val('');
        $('input[name=conenAddressStudent]').val(objectStudent['address']);
      });
    } else {
      $('input[name=conenTypeDocumentStudent]').val('');
      $('input[name=conenNumberDocumentStudent]').val('');
      $('input[name=conenBirthdateStudent]').val('');
      $('input[name=conenYearsoldStudent]').val('');
      $('input[name=conenGenderStudent]').val('');
      $('input[name=conenBloodtypeStudent]').val('');
      $('input[name=conenHealtStudent]').val('');
      $('input[name=conenAdditionalHealtStudent]').val('');
      $('textarea[name=conenAdditionalHealtDescriptionStudent]').val('');
      $('input[name=conenCityStudent]').val('');
      $('input[name=conenLocationStudent]').val('');
      $('input[name=conenDistrictStudent]').val('');
      $('input[name=conenAddressStudent]').val('');
    }
  });

  $('#btnFormSaveConsolidatedEnrollment').on('click', function(e) {
    e.preventDefault();
    var arrayItems = new Array();
    var textButton = $(this).text();
    var textSpan = $('#conenStatus').text();
    var idStudent = $('#conenStudent option:selected').val();


    if (idStudent > 0 && idStudent !== '') {
      var finalStatus;
      if (textButton == 'GUARDAR PROCESO' && textSpan == 'PENDIENTE') {
        finalStatus = 'PENDIENTE';
      } else if (textButton == 'FINALIZAR MATRICULA' && textSpan == 'COMPLETADO') {
        finalStatus = 'COMPLETADO';
      }
      arrayItems.push(idStudent);
      arrayItems.push(finalStatus);

      $('input.itemCheck-enroll:checked').each(function() {
        arrayItems.push($(this).val());
      });
      var jsonItems = JSON.stringify(arrayItems);
      $.post("{{ route('saveConsolidatedEnrollment') }}", {
        jsonItems
      }, function(objectResponse) {
        if (objectResponse !== null) {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.message-enroll').css('display', 'flex');
          $('.message-enroll').removeClass('alert-warning');
          $('.message-enroll').addClass('alert-primary');
          $('.message-enroll').html('<b>' + objectResponse + '</b>');
          $('input[type=progress]').attr('style', 'width:0%;');
          $('#formConsolidatedEnrollment')[0].reset();
        } else {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.message-enroll').css('display', 'flex');
          $('.message-enroll').removeClass('alert-primary');
          $('.message-enroll').addClass('alert-warning');
          $('.message-enroll').html('<b>NO FUE POSIBLE PROCESAR LA INFORMACION</b>');
          setTimeout(function() {
            $('.message-enroll').html('');
            $('.message-enroll').removeClass('alert-warning');
            $('.message-enroll').css('display', 'none');
          }, 10000);
        }
      });

    } else {
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      $('.message-enroll').css('display', 'flex');
      $('.message-enroll').removeClass('alert-primary');
      $('.message-enroll').addClass('alert-warning');
      $('.message-enroll').html('<b>NINGUN ALUMNO SELECCIONADO</b>');
      setTimeout(function() {
        $('.message-enroll').html('');
        $('.message-enroll').removeClass('alert-warning');
        $('.message-enroll').css('display', 'none');
      }, 10000);
    }
  });
</script>
@endsection