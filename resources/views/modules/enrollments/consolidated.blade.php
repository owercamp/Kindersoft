@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <h3>TABLA GENERAL DE MATRICULAS</h3>
      </div>
      <div class="row text-center">
        <a href="{{ route('consolidatedEnrollment.new') }}" class="btn btn-outline-success form-control-sm">CREAR NUEVA MATRICULA</a>
      </div>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de consolidado de matriculas -->
      @if(session('PrimaryUpdateConsolidatedEnrollment'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateConsolidatedEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryUpdateConsolidatedEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateConsolidatedEnrollment') }}
      </div>
      @endif
      <div class="alert alert-primary message-enrollUpdate"></div>
    </div>
  </div>
  <table id="tableConsolidatedEnrollments" class="table text-center mt-3 border-top">
    <thead>
      <tr>
        <td>DOCUMENTO</td>
        <td>NOMBRES</td>
        <td>EDAD</td>
        <td>ESTADO DE MATRICULA</td>
        <td>ACCIONES</td>
      </tr>
    </thead>
    <tbody>
      @foreach($consolidatedenrollmentsAll as $itemEnrollment)
      <tr>
        <td><span class="text-muted">{{ $itemEnrollment->numberdocument }}</span></td>
        <td><span class="text-muted">{{ $itemEnrollment->firstname . ' ' . $itemEnrollment->threename . ' ' . $itemEnrollment->fourname }}</span></td>
        <td><span class="text-muted">{{ $itemEnrollment->yearsold }}</span></td>
        <td><span class="text-muted">{{ $itemEnrollment->conenStatus }}</span></td>
        <td>
          @if($itemEnrollment->conenStatus == 'PENDIENTE' || $itemEnrollment->conenStatus == 'PENDIENTE DE DOCUMENTOS')
          <form action="{{ route('getDocumentsPending') }}">
            <a href="#" class="btn btn-outline-primary rounded-circle updateConsolidatedEnrollment-link" title="CONTINUAR PROCESO">
              <i class="fas fa-clipboard-list"></i>
              <span hidden>{{ $itemEnrollment->conenId }}</span>
              <span hidden>{{ $itemEnrollment->conenStudent_id }}</span>
              <span hidden>{{ $itemEnrollment->conenStatus }}</span>
              <span hidden>{{ $itemEnrollment->conenRequirements }}</span>
              <span hidden>{{ $itemEnrollment->typedocument_id }}</span>
              <span hidden>{{ $itemEnrollment->numberdocument }}</span>
              <span hidden>{{ $itemEnrollment->firstname . ' ' . $itemEnrollment->threename . ' ' . $itemEnrollment->fourname }}</span>
              <span hidden>{{ $itemEnrollment->birthdate }}</span>
              <span hidden>{{ $itemEnrollment->yearsold }}</span>
              <span hidden>{{ $itemEnrollment->address }}</span>
              <span hidden>{{ $itemEnrollment->cityhome_id }}</span>
              <span hidden>{{ $itemEnrollment->locationhome_id }}</span>
              <span hidden>{{ $itemEnrollment->dictricthome_id }}</span>
              <span hidden>{{ $itemEnrollment->bloodtype_id }}</span>
              <span hidden>{{ $itemEnrollment->gender }}</span>
              <span hidden>{{ $itemEnrollment->health_id }}</span>
              <span hidden>{{ $itemEnrollment->additionalHealt }}</span>
              <span hidden>{{ $itemEnrollment->additionalHealtDescription }}</span>
            </a>
            <input type="hidden" name="conenId" class="form-control form-control-sm" value="{{ $itemEnrollment->conenId }}" readonly required>
            <input type="hidden" name="dateNow" class="form-control form-control-sm" readonly required>
            <button type="submit" class="btn btn-outline-tertiary rounded-circle " title="DESCARGAR PDF"><i class="fas fa-file-pdf"></i></button>
          </form>
          @elseif($itemEnrollment->conenStatus == 'COMPLETADO')
          <a href="#" class="btn btn-outline-success rounded-circle detailsConsolidatedEnrollment-link" title="VER DETALLES">
            <i class="fas fa-eye"></i>
            <span hidden>{{ $itemEnrollment->conenId }}</span>
            <span hidden>{{ $itemEnrollment->conenStudent_id }}</span>
            <span hidden>{{ $itemEnrollment->conenStatus }}</span>
            <span hidden>{{ $itemEnrollment->conenRequirements }}</span>
            <span hidden>{{ $itemEnrollment->typedocument_id }}</span>
            <span hidden>{{ $itemEnrollment->numberdocument }}</span>
            <span hidden>{{ $itemEnrollment->firstname . ' ' . $itemEnrollment->threename . ' ' . $itemEnrollment->fourname }}</span>
            <span hidden>{{ $itemEnrollment->birthdate }}</span>
            <span hidden>{{ $itemEnrollment->yearsold }}</span>
            <span hidden>{{ $itemEnrollment->address }}</span>
            <span hidden>{{ $itemEnrollment->cityhome_id }}</span>
            <span hidden>{{ $itemEnrollment->locationhome_id }}</span>
            <span hidden>{{ $itemEnrollment->dictricthome_id }}</span>
            <span hidden>{{ $itemEnrollment->bloodtype_id }}</span>
            <span hidden>{{ $itemEnrollment->gender }}</span>
            <span hidden>{{ $itemEnrollment->health_id }}</span>
            <span hidden>{{ $itemEnrollment->additionalHealt }}</span>
            <span hidden>{{ $itemEnrollment->additionalHealtDescription }}</span>
          </a>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- MODAL PARA CONTINUAR PROCESO DE MATRICULAS PENDIENTES -->
<div class="modal fade" id="updateConsolidatedEnrollment-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted float-left">PROCESO ORDEN DE MATRICULA:</h4>
        <div class="alert alert-primary float-right message-enrollUpdate-modal"></div>
      </div>
      <div class="modal-body p-4">
        <div class="row p-2 border-bottom">
          <div class="col-md-6">
            <h5 class="text-muted">INFORMACION DE ALUMNO</h5>
          </div>
          <div class="col-md-6">
            <h5 class="text-muted">LISTADO DE REQUISITOS</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 border-right">
            <small class="text-muted"><b><span class="updateConenNamesStudent">Nombres</span></b></small>
            <br>
            <small class="text-muted">TIPO DE DOCUMENTO: <b><span class="updateConenTypedocumentStudent">Tipo</span></b></small><br>
            <small class="text-muted">N° DOCUMENTO: <b><span class="updateConenNumberdocumentStudent">Numero</span></b></small>
            <br>
            <small class="text-muted">FECHA DE NACIMIENTO: <b><span class="updateConenBirthdateStudent">fecha</span></b></small>
            <br>
            <small class="text-muted">AÑOS: <b><span class="updateConenYearStudent-show">año</span></b></small>
            <br>
            <small class="text-muted">MESES: <b><span class="updateConenMountStudent-show">mes</span></b></small>
            <br>
            <hr>
            <small class="text-muted">DIRECCION: <br><b><span class="updateConenAddressStudent">Direccion</span></b></small><br>
            <small class="text-muted">CIUDAD: <b><span class="updateConenCityStudent">Ciudad</span></b></small><br>
            <small class="text-muted">LOCALIDAD: <b><span class="updateConenLocationStudent">Ciudad</span></b></small><br>
            <small class="text-muted">BARRIO: <b><span class="updateConenDistrictStudent">Ciudad</span></b></small>
            <br>
            <hr>
            <small class="text-muted">GENERO: <b><span class="updateConenGenderStudent">genero</span></b></small><br>
            <small class="text-muted">TIPO DE SANGRE: <b><span class="updateConenBlootypeStudent">sangre</span></b></small><br>
            <small class="text-muted">CENTRO DE SALUD: <b><span class="updateConenHealthStudent">centro</span></b></small><br>
            <small class="text-muted">SALUD ADICIONAL: <b><span class="updateConenHealthAdditionalStudent">adicional</span></b></small>
            <br>
            <small class="text-muted">DESCRIPCION: <b><span class="updateConenHealthAdditionalDescripcionStudent">descripcion adicional</span></b></small>
            <br>
            <hr><br>
            <span class="form-control form-control-sm badge badge-warning float-right conenStatusUpdate" style="color: #fff; font-weight: bold;">PENDIENTE</span>
            <br><br>
            <form id="formForceFinalConsolidated" action="{{ route('saveConsolidatedWithoutDocuments') }}" method="POST">
              @csrf
              <input type="hidden" name="idConsolidated_hidden" class="form-control form-control-sm" required>
              <button type="submit" class="btn btn-outline-primary btn-enrollWithoutDocuments">MATRICULAR SIN DOCUMENTOS</button>
            </form>
          </div>
          <div class="col-md-7 mt-2">
            <div id="checkItems" class="row">
              <div class="col-md-12">
                <form id="formForUpdateConsolideEnroll" action="{{ route('consolidatedEnrollment.update') }}" method="POST">
                  @csrf
                  <input type="hidden" class="form-control form-control-sm" name="conenid" value="" readonly required>
                  <input type="hidden" class="form-control form-control-sm" name="conenStudent_id" value="" readonly required>
                  @foreach($documentsActives as $document)
                  <div class="row border-bottom">
                    <div class="col-md-12">
                      <div class="input-group form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text form-control-sm">
                              @if($document->deRequired == 'SI')
                              <input type="checkbox" name="itemCheck" class="form-control-sm itemCheck-enroll" value="{{ $document->deConcept }}-ENTREGADO"><span class="badge badge-success bad-info">ENTREGADO</span>
                              @else
                              <input type="checkbox" name="itemCheck-optional" class="form-control-sm itemCheck-enroll" value="{{ $document->deConcept }}-ENTREGADO"><span class="badge badge-success bad-info">ENTREGADO</span>
                              @endif
                            </span>
                          </div>
                          <span class="input-group-text form-control form-control-sm"><b>{{ $document->deConcept }}</b></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <div class="row text-center mb-3">
                    <div class="col-md-12">
                      <div class="form-group progress checkprogress">
                        <small class="text-muted"><b>PROGRESO</b></small>
                        <input type="progress" class="progress-bar progress-bar-striped bg-warning ml-2" readonly>
                      </div>
                    </div>
                  </div>
                  <button id="btnFormUpdateConsolidatedEnrollment" type="submit" class="btn btn-outline-success mx-3 form-control-sm">GUARDAR PROCESO</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-outline-tertiary  form-control-sm" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA VER DETALLES DE MATRICULAS COMPLETA -->
<div class="modal fade" id="detailsConsolidatedEnrollment-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="text-muted float-left">ORDEN DE MATRICULA:</h4>
        <div class="alert alert-primary float-right message-enrollUpdate-modal"></div>
      </div>
      <div class="modal-body p-4">
        <div class="row p-2 border-bottom">
          <div class="col-md-6">
            <h5 class="text-muted">INFORMACION DE ALUMNO</h5>
          </div>
          <div class="col-md-6">
            <h5 class="text-muted">LISTADO DE REQUISITOS</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 border-right">
            <small class="text-muted"><b><span class="detailsConenNamesStudent">Nombres</span></b></small>
            <br>
            <small class="text-muted">TIPO DE DOCUMENTO: <b><span class="detailsConenTypedocumentStudent">Tipo</span></b></small><br>
            <small class="text-muted">N° DOCUMENTO: <b><span class="detailsConenNumberdocumentStudent">Numero</span></b></small>
            <br>
            <small class="text-muted">FECHA DE NACIMIENTO: <b><span class="updateConenBirthdateStudent">fecha</span></b></small>
            <br>
            <small class="text-muted">AÑOS: <b><span class="detailsConenYearStudent-show">año</span></b></small>
            <br>
            <small class="text-muted">MESES: <b><span class="detailsConenMountStudent-show">mes</span></b></small>
            <br>
            <hr>
            <small class="text-muted">DIRECCION: <br><b><span class="detailsConenAddressStudent">Direccion</span></b></small><br>
            <small class="text-muted">CIUDAD: <b><span class="detailsConenCityStudent">Ciudad</span></b></small><br>
            <small class="text-muted">LOCALIDAD: <b><span class="detailsConenLocationStudent">Localidad</span></b></small><br>
            <small class="text-muted">BARRIO: <b><span class="detailsConenDistrictStudent">Barrio</span></b></small>
            <br>
            <hr>
            <small class="text-muted">GENERO: <b><span class="detailsConenGenderStudent">genero</span></b></small><br>
            <small class="text-muted">TIPO DE SANGRE: <b><span class="detailsConenBlootypeStudent">sangre</span></b></small><br>
            <small class="text-muted">CENTRO DE SALUD: <b><span class="detailsConenHealthStudent">centro</span></b></small><br>
            <small class="text-muted">SALUD ADICIONAL: <b><span class="detailsConenHealthAdditionalStudent">adicional</span></b></small>
            <br>
            <small class="text-muted">DESCRIPCION: <b><span class="detailsConenHealthAdditionalDescripcionStudent">descripcion adicional</span></b></small>
            <br>
            <hr><br>
            <span class="form-control form-control-sm badge badge-success float-right" style="color: #fff; font-weight: bold;">COMPLETADO</span>
          </div>
          <div class="col-md-7 mt-2">
            <div id="checkItems" class="row">
              <div class="col-md-12">
                @foreach($documentsActives as $document)
                <div class="row border-bottom">
                  <div class="col-md-12">
                    <div class="input-group form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text form-control-sm">
                            <input type="checkbox" checked class="form-control-sm" value="{{ $document->deConcept }}-ENTREGADO" disabled><span class="badge badge-success">ENTREGADO</span>
                          </span>
                        </div>
                        <span class="input-group-text form-control form-control-sm"><b>{{ $document->deConcept }}</b></span>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer text-center">
        <button type="button" class="btn btn-outline-tertiary  form-control-sm" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  $(function() {
    $('.bad-info').css('display', 'none');
    $('.message-enrollUpdate').css('display', 'none');
    $('.message-enrollUpdate-modal').css('display', 'none');
    var datenow = new Date();
    var dateCompleted = datenow.getDate() + " de " + getFormatMount((datenow.getMonth() + 1)) + " de " + datenow.getFullYear();
    $('input[name=dateNow]').val(dateCompleted);
    refreshProgress();
  });

  $('#checkItems').on('click', 'input[name=itemCheck]', function() {
    refreshProgress();
  });

  function getFormatMount(mount) {
    switch (mount) {
      case 1:
        return 'Enero';
        break;
      case 2:
        return 'Febrero';
        break;
      case 3:
        return 'Marzo';
        break;
      case 4:
        return 'Abril';
        break;
      case 5:
        return 'Mayo';
        break;
      case 6:
        return 'Junio';
        break;
      case 7:
        return 'Julio';
        break;
      case 8:
        return 'Agosto';
        break;
      case 9:
        return 'Septiembre';
        break;
      case 10:
        return 'OCtubre';
        break;
      case 11:
        return 'Noviembre';
        break;
      case 12:
        return 'Diciembre';
        break;
    }
  }

  function refreshProgress() {
    $('input[type=progress]').attr('max', 100 + '%');
    var itemsCount = $('input[name=itemCheck]').length;
    var nowValue = 0;
    $('input[name=itemCheck]:checked').each(function() {
      nowValue++;
    });
    var newValue = (nowValue * 100) / itemsCount;
    $('input[type=progress]').attr('style', 'width:' + newValue + '%;');
    if (newValue < 100) {
      $('input[type=progress]').removeClass('bg-success');
      $('input[type=progress]').addClass('bg-warning');
      $('.conenStatusUpdate').removeClass('badge-success');
      $('.conenStatusUpdate').addClass('badge-warning');
      $('.conenStatusUpdate').text('');
      $('.conenStatusUpdate').text('PENDIENTE');
      $('#btnFormUpdateConsolidatedEnrollment').text('');
      $('#btnFormUpdateConsolidatedEnrollment').text('GUARDAR PROCESO');
    } else {
      $('input[type=progress]').removeClass('bg-warning');
      $('input[type=progress]').addClass('bg-success');
      $('.conenStatusUpdate').removeClass('badge-warning');
      $('.conenStatusUpdate').addClass('badge-success');
      $('.conenStatusUpdate').text('');
      $('.conenStatusUpdate').text('COMPLETADO');
      $('#btnFormUpdateConsolidatedEnrollment').text('');
      $('#btnFormUpdateConsolidatedEnrollment').text('FINALIZAR MATRICULA');
    }
  }

  $('.updateConsolidatedEnrollment-link').on('click', function() {

    //DATOS GENERALES DE MATRICULA
    var conenId = $(this).find('span:nth-child(2)').text();
    var conenStudent_id = $(this).find('span:nth-child(3)').text();
    var conenStatus = $(this).find('span:nth-child(4)').text();
    var conenRequirements = $(this).find('span:nth-child(5)').text();

    if ($('.conenStatusUpdate').text() === 'PENDIENTE') {
      $('input[name=idConsolidated_hidden]').val('');
      $('input[name=idConsolidated_hidden]').val(conenId);
      $('#formForceFinalConsolidated').css('display', 'block');
    } else {
      $('#formForceFinalConsolidated').css('display', 'none');
    }

    if (conenStatus == 'PENDIENTE DE DOCUMENTOS') {
      $('.btn-enrollWithoutDocuments').css('display', 'none');
    } else {
      $('.btn-enrollWithoutDocuments').css('display', 'flex');
    }

    //CAPTURAR VALORES OCULTOS EN SPANs

    //TRAER EL TIPO DE DOCUMENTO DE ACUERDO A SU ID
    $('.updateConenTypedocumentStudent').text('');
    $.get("{{ route('getTypeDocument') }}", {
      id: $(this).find('span:nth-child(6)').text()
    }, function(objectTypedocument) {
      if (objectTypedocument['type'] !== null || objectTypedocument['type'] !== '') {
        $('.updateConenTypedocumentStudent').text(objectTypedocument['type']);
      } else {
        $('.updateConenTypedocumentStudent').text('NO DEFINIDO');
      }
    });

    //TRAER LA CIUDAD DE ACUERDO A SU ID
    $('.updateConenCityStudent').text('');
    $.get("{{ route('getCity') }}", {
      id: $(this).find('span:nth-child(12)').text()
    }, function(objectCity) {
      if (objectCity['name'] !== null || objectCity['name'] !== '') {
        $('.updateConenCityStudent').text(objectCity['name']);
      } else {
        $('.updateConenCityStudent').text('NO DEFINIDO');
      }
    });

    //TRAER LA LOCALIDAD DE ACUERDO A SU ID
    $('.updateConenLocationStudent').text('');
    $.get("{{ route('getLocation') }}", {
      id: $(this).find('span:nth-child(13)').text()
    }, function(objectLocation) {
      if (objectLocation['name'] !== null || objectLocation['name'] !== '') {
        $('.updateConenLocationStudent').text(objectLocation['name']);
      } else {
        $('.updateConenLocationStudent').text('NO DEFINIDO');
      }
    });


    //TRAER EL BARRIO DE ACUERDO A SU ID
    $('.updateConenDistrictStudent').text('');
    $.get("{{ route('getDistrict') }}", {
      id: $(this).find('span:nth-child(14)').text()
    }, function(objectDistrict) {
      if (objectDistrict['name'] !== null || objectDistrict['name'] !== '') {
        $('.updateConenDistrictStudent').text(objectDistrict['name']);
      } else {
        $('.updateConenDistrictStudent').text('NO DEFINIDO');
      }
    });


    //TRAER EL TIPO DE SANGRE DE ACUERDO A SU ID
    $('.updateConenBlootypeStudent').text('');
    $.get("{{ route('getTypeBlood') }}", {
      id: $(this).find('span:nth-child(15)').text()
    }, function(objectTypeblood) {
      if (objectTypeblood['bloodtypeStudent'] !== null || objectTypeblood['bloodtypeStudent'] !== '') {
        $('.updateConenBlootypeStudent').text(objectTypeblood['bloodtypeStudent']);
      } else {
        $('.updateConenBlootypeStudent').text('NO DEFINIDO');
      }
    });

    //TRAER EL CENTRO DE SALUD DE ACUERDO A SU ID
    $('.updateConenHealthStudent').text('');
    $.get("{{ route('getHealth') }}", {
      id: $(this).find('span:nth-child(17)').text()
    }, function(objectHealth) {
      if (objectHealth['healthStudent'] !== null || objectHealth['healthStudent'] !== '') {
        $('.updateConenHealthStudent').text(objectHealth['healthStudent']);
      } else {
        $('.updateConenHealthStudent').text('NO DEFINIDO');
      }
    });

    var estNumberdocument = $(this).find('span:nth-child(7)').text();
    var estNames = $(this).find('span:nth-child(8)').text();
    var estBirtdate = $(this).find('span:nth-child(9)').text();
    var estYearsold = $(this).find('span:nth-child(10)').text();
    var estAddress = $(this).find('span:nth-child(11)').text();
    var estTypeblood = $(this).find('span:nth-child(15)').text();
    var estGender = $(this).find('span:nth-child(16)').text();
    var estAdditionalHealth = $(this).find('span:nth-child(18)').text();
    var estAdditionalHealthDescription = $(this).find('span:nth-child(19)').text();

    //ESTUDIANTE
    $('input[name=conenid]').val('');
    $('input[name=conenid]').val(conenId);
    $('input[name=conenStudent_id]').val('');
    $('input[name=conenStudent_id]').val(conenStudent_id);

    $('.updateConenNamesStudent').text('');
    $('.updateConenNamesStudent').text(estNames);
    $('.updateConenNumberdocumentStudent').text('');
    $('.updateConenNumberdocumentStudent').text(estNumberdocument);
    $('.updateConenBirthdateStudent').text('');
    $('.updateConenBirthdateStudent').text(estBirtdate);
    var separateYearsold = estYearsold.split('-'); //EPARAR EDAD EN ARRAY
    $('.updateConenYearStudent-show').text('');
    $('.updateConenYearStudent-show').text(separateYearsold[0]); //AÑOS
    $('.updateConenMountStudent-show').text('');
    $('.updateConenMountStudent-show').text(separateYearsold[1]); //MESES
    $('.updateConenAddressStudent').text('');
    $('.updateConenAddressStudent').text(estAddress);
    $('.updateConenGenderStudent').text('');
    $('.updateConenGenderStudent').text(estGender);
    $('.updateConenHealthAdditionalStudent').text('');
    $('.updateConenHealthAdditionalStudent').text(estAdditionalHealth);
    $('.updateConenHealthAdditionalDescripcionStudent').text('');
    $('.updateConenHealthAdditionalDescripcionStudent').text(estAdditionalHealthDescription);


    //var indexChart = conenRequirements.lastIndexOf(',');//BUSCAR ULTIMA COMA
    //var indexChart = conenRequirements.length - 1 ;//ULTIMO CARACTER
    //var conenCheckitems = conenRequirements.substring(0,indexChart);//QUITAR ULTIMA COMA (,) DE LOS REQUISITOS DE MATRICULA
    var separateRequerements = conenRequirements.split(',');
    $('input.itemCheck-enroll').each(function() {
      $(this).attr('checked', false);
      $(this).attr('disabled', false);
      $(this).siblings('.bad-info').css('display', 'none');
    });
    for (i = 0; i < separateRequerements.length; i++) {
      $('input.itemCheck-enroll').each(function() {
        if (separateRequerements[i] == $(this).val()) {
          $(this).attr('checked', true);
          $(this).attr('disabled', true);
          $(this).siblings('.bad-info').css('display', 'block');
        }
      });
    }
    refreshProgress();
    $('#updateConsolidatedEnrollment-modal').modal();
  });

  $("#updateConsolidatedEnrollment-modal").on('hidden.bs.modal', function() {
    $('#formForUpdateConsolideEnroll')[0].reset();
  });

  $("#detailsConsolidatedEnrollment-modal").on('hidden.bs.modal', function() {
    //$('#formForUpdateConsolideEnroll')[0].reset();
  });

  $('#btnFormUpdateConsolidatedEnrollment').on('click', function(e) {
    e.preventDefault();

    var arrayItems = new Array();
    var textButton = $(this).text();
    var textSpan = $('.conenStatusUpdate').text();
    var idConsolidated = $('input[name=conenid]').val();
    var idStudent = $('input[name=conenStudent_id]').val();

    if (idStudent > 0 && idStudent !== '' && idConsolidated > 0 && idConsolidated !== '') {
      var finalStatus;
      if (textButton == 'GUARDAR PROCESO' && textSpan == 'PENDIENTE') {
        finalStatus = 'PENDIENTE';
      } else if (textButton == 'FINALIZAR MATRICULA' && textSpan == 'COMPLETADO') {
        finalStatus = 'COMPLETADO';
      }
      arrayItems.push(idConsolidated);
      arrayItems.push(idStudent);
      arrayItems.push(finalStatus);

      $('input.itemCheck-enroll:checked').each(function() {
        arrayItems.push($(this).val());
      });
      var jsonItems = JSON.stringify(arrayItems);
      $.post("{{ route('updateConsolidatedEnrollment') }}", {
        jsonItems
      }, function(objectResponse) {
        if (objectResponse !== null) {

          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.message-enrollUpdate').css('display', 'flex');
          $('.message-enrollUpdate').removeClass('alert-warning');
          $('.message-enrollUpdate').addClass('alert-primary');
          var timeSeconds = 10;
          setInterval(function() {
            $('.message-enrollUpdate').html('');
            $('.message-enrollUpdate').html(objectResponse + ', PARA VER LOS CAMBIOS RECARGA LA PAGINA O ESPERA ' + timeSeconds + ' SEGUNDOS PARA QUE SE CARGUEN LAS MODIFICACIONES');
            timeSeconds--;
          }, 1000);

          $('input[type=progress]').attr('style', 'width:0%;');
          $('#updateConsolidatedEnrollment-modal').modal('hide');
          //$('#formForUpdateConsolideEnroll')[0].reset();
          setTimeout(function() {
            location.reload();
          }, 10000);

        } else {
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          $('.message-enrollUpdate-modal').css('display', 'flex');
          $('.message-enrollUpdate-modal').removeClass('alert-primary');
          $('.message-enrollUpdate-modal').addClass('alert-warning');
          $('.message-enrollUpdate-modal').html('<b>NO FUE POSIBLE PROCESAR LA INFORMACION</b>');
          setTimeout(function() {
            $('.message-enrollUpdate-modal').html('');
            $('.message-enrollUpdate-modal').removeClass('alert-warning');
            $('.message-enrollUpdate-modal').css('display', 'none');
          }, 10000);
        }
      });
    } else {
      $("html, body").animate({
        scrollTop: 0
      }, "slow");
      $('.message-enrollUpdate-modal').css('display', 'flex');
      $('.message-enrollUpdate-modal').removeClass('alert-primary');
      $('.message-enrollUpdate-modal').addClass('alert-warning');
      $('.message-enrollUpdate-modal').html('<b>NINGUN ALUMNO SELECCIONADO</b>');
      setTimeout(function() {
        $('.message-enrollUpdate-modal').html('');
        $('.message-enrollUpdate-modal').removeClass('alert-warning');
        $('.message-enrollUpdate-modal').css('display', 'none');
      }, 10000);
    }

  });

  $('.detailsConsolidatedEnrollment-link').on('click', function() {

    //DATOS GENERALES DE MATRICULA
    var conenId = $(this).find('span:nth-child(2)').text();
    var conenStudent_id = $(this).find('span:nth-child(3)').text();
    var conenStatus = $(this).find('span:nth-child(4)').text();
    var conenRequirements = $(this).find('span:nth-child(5)').text();

    //CAPTURAR VALORES OCULTOS EN SPANs

    //TRAER EL TIPO DE DOCUMENTO DE ACUERDO A SU ID
    $('.detailsConenTypedocumentStudent').text('');
    $.get("{{ route('getTypeDocument') }}", {
      id: $(this).find('span:nth-child(6)').text()
    }, function(objectTypedocument) {
      if (objectTypedocument['type'] !== null || objectTypedocument['type'] !== '') {
        $('.detailsConenTypedocumentStudent').text(objectTypedocument['type']);
      } else {
        $('.detailsConenTypedocumentStudent').text('NO DEFINIDO');
      }
    });

    //TRAER LA CIUDAD DE ACUERDO A SU ID
    $('.detailsConenCityStudent').text('');
    $.get("{{ route('getCity') }}", {
      id: $(this).find('span:nth-child(12)').text()
    }, function(objectCity) {
      if (objectCity['name'] !== null || objectCity['name'] !== '') {
        $('.detailsConenCityStudent').text(objectCity['name']);
      } else {
        $('.detailsConenCityStudent').text('NO DEFINIDO');
      }
    });

    //TRAER LA LOCALIDAD DE ACUERDO A SU ID
    $('.detailsConenLocationStudent').text('');
    $.get("{{ route('getLocation') }}", {
      id: $(this).find('span:nth-child(13)').text()
    }, function(objectLocation) {
      if (objectLocation['name'] !== null || objectLocation['name'] !== '') {
        $('.detailsConenLocationStudent').text(objectLocation['name']);
      } else {
        $('.detailsConenLocationStudent').text('NO DEFINIDO');
      }
    });

    //TRAER EL BARRIO DE ACUERDO A SU ID
    $('.detailsConenDistrictStudent').text('');
    $.get("{{ route('getDistrict') }}", {
      id: $(this).find('span:nth-child(14)').text()
    }, function(objectDistrict) {
      if (objectDistrict['name'] !== null || objectDistrict['name'] !== '') {
        $('.detailsConenDistrictStudent').text(objectDistrict['name']);
      } else {
        $('.detailsConenDistrictStudent').text('NO DEFINIDO');
      }
    });

    //TRAER EL TIPO DE SANGRE DE ACUERDO A SU ID
    $('.detailsConenBlootypeStudent').text('');
    $.get("{{ route('getTypeBlood') }}", {
      id: $(this).find('span:nth-child(15)').text()
    }, function(objectTypeblood) {
      if (objectTypeblood['bloodtypeStudent'] !== null || objectTypeblood['bloodtypeStudent'] !== '') {
        $('.detailsConenBlootypeStudent').text(objectTypeblood['bloodtypeStudent']);
      } else {
        $('.detailsConenBlootypeStudent').text('NO DEFINIDO');
      }
    });

    //TRAER EL CENTRO DE SALUD DE ACUERDO A SU ID
    $('.detailsConenHealthStudent').text('');
    $.get("{{ route('getHealth') }}", {
      id: $(this).find('span:nth-child(17)').text()
    }, function(objectHealth) {
      if (objectHealth['healthStudent'] !== null || objectHealth['healthStudent'] !== '') {
        $('.detailsConenHealthStudent').text(objectHealth['healthStudent']);
      } else {
        $('.detailsConenHealthStudent').text('NO DEFINIDO');
      }
    });

    var estNumberdocument = $(this).find('span:nth-child(7)').text();
    var estNames = $(this).find('span:nth-child(8)').text();
    var estBirtdate = $(this).find('span:nth-child(9)').text();
    var estYearsold = $(this).find('span:nth-child(10)').text();
    var estAddress = $(this).find('span:nth-child(11)').text();
    var estTypeblood = $(this).find('span:nth-child(15)').text();
    var estGender = $(this).find('span:nth-child(16)').text();
    var estAdditionalHealth = $(this).find('span:nth-child(18)').text();
    var estAdditionalHealthDescription = $(this).find('span:nth-child(19)').text();

    //ESTUDIANTE

    $('.detailsConenNamesStudent').text('');
    $('.detailsConenNamesStudent').text(estNames);
    $('.detailsConenNumberdocumentStudent').text('');
    $('.detailsConenNumberdocumentStudent').text(estNumberdocument);
    $('.detailsConenBirthdateStudent').text('');
    $('.detailsConenBirthdateStudent').text(estBirtdate);
    var separateYearsold = estYearsold.split('-'); //EPARAR EDAD EN ARRAY
    $('.detailsConenYearStudent-show').text('');
    $('.detailsConenYearStudent-show').text(separateYearsold[0]); //AÑOS
    $('.detailsConenMountStudent-show').text('');
    $('.detailsConenMountStudent-show').text(separateYearsold[1]); //MESES
    $('.detailsConenAddressStudent').text('');
    $('.detailsConenAddressStudent').text(estAddress);
    $('.detailsConenGenderStudent').text('');
    $('.detailsConenGenderStudent').text(estGender);
    $('.detailsConenHealthAdditionalStudent').text('');
    $('.detailsConenHealthAdditionalStudent').text(estAdditionalHealth);
    $('.detailsConenHealthAdditionalDescripcionStudent').text('');
    $('.detailsConenHealthAdditionalDescripcionStudent').text(estAdditionalHealthDescription);

    $('#detailsConsolidatedEnrollment-modal').modal();
  });
</script>
@endsection