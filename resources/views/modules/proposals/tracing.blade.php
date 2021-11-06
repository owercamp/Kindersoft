@extends('modules.proposal')

@section('proposalComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>TABLA GENERAL DE SEGUIMIENTOS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de cotizaciones -->
      @if(session('PrimaryUpdateTracing'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateTracing') }}
      </div>
      @endif
      @if(session('SecondaryUpdateTracing'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateTracing') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de cotizaciones -->
      @if(session('WarningDeleteTracing'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteTracing') }}
      </div>
      @endif
      @if(session('SecondaryDeleteTracing'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteTracing') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tabletracings" class="table table-responsive table-hover text-center">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>FECHA</th>
        <th>NOMBRE</th>
        <th>CORREO ELECTRONICO</th>
        <th>NUMERO DE CONTACTO</th>
        <th>ESTADO</th>
        <th>DETALLES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tracings as $tracing)
      <tr>
        <td>{{ $tracing->id }}</td>
        <td>{{ $tracing->proDateQuotation }}</td>
        <td>{{ $tracing->cusFirstname }} {{ $tracing->cusLastname }}</td>
        <td>{{ $tracing->cusMail }}</td>
        <td>{{ $tracing->cusPhone }}</td>
        @if($tracing->proResult == null)
        <td class="status">{{ __('SIN RESPUESTA') }}</td>
        @endif
        <td>
          <!--<a href="#" title="EDITAR" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>-->
          <!-- data-toggle="modal" data-target="#seeDetailsTracing" -->
          <button type="button" title="DETALLES" class="btn btn-outline-success rounded-circle seeModalWithInfo">
            <i class="fas fa-eye"></i>
            <span hidden>{{ $tracing->id }}</span>
          </button>
          <button type="button" title="BITACORA" class="btn btn-outline-primary rounded-circle seeModalBinnacle">
            <i class="fas fa-file-alt"></i>
            <span hidden>{{ $tracing->id }}</span>
            <span hidden>{{ $tracing->cusFirstname . ' ' . $tracing->cusLastname }}</span>
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal de detalles y exportacion a PDF -->
<div class="modal fade" id="seeDetailsTracing">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row">
          <div class="col-md-12 d-flex">
            <form id="formForApproved" action="{{ route('aprovedToProposal') }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" name="CodeFromBtnApproved" readonly required>
                <button type="submit" id="btnForApprove" class="btn btn-outline-success mx-3"><i class="fas fa-check-circle"></i> APROBADO</button>
              </div>
            </form>
            <form id="formForDenied" action="{{ route('deniedToProposal') }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" name="CodeFromBtnDenied" readonly required>
                <button type="submit" id="btnForNotApprove" class="btn btn-outline-primary mx-3"><i class="fas fa-times-circle"></i> DENEGADO</button>
              </div>
            </form>
            <form id="formForDownload" action="{{ route('tracingsPdf') }}" method="GET">
              @csrf
              <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" name="CodeFromBtnDownload" readonly required>
                <button type="submit" class="btn btn-outline-tertiary  mx-3"><i class="fas fa-file-pdf"></i> DESCARGAR PDF</button>
              </div>
            </form>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div id="divToPdf" class="row modal-body">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3 text-center">
              <img style="width: 100px; height: auto;" class="infoImgCompany" src="{{ asset('storage/garden/logo.png') }}" alt="{{ config('app.lastname', 'JARDIN') }}"><br>
              <small class="text-muted"><b><span class="infoReasonCompany">RAZON SOCIAL</span></b></small><br>
              <small class="text-muted"><b><span class="infoNameCompany">NOMBRE COMERCIAL</span></b></small><br>
              <small class="text-muted"><b>NIT. </b><span class="infoNitCompany">000.000.0000-0</span></small><br>
              <small class="text-muted"><b></b><span class="infoWebCompany">www.jardin.com</span></small>
            </div>
            <div class="col-md-5 text-left">
              <small class="text-muted"><span class="infoCityCompany">Bogotá D.C, Colombia - Codigo Postal</span></small><br>
              <small class="text-muted"><b>Direccion: </b><span class="infoAddressCompany">Direccion de la organización</span></small><br>
              <small class="text-muted"><b>Tels: </b><span class="infoTelsCompany"> 000-000-00-00</span></small><br>
              <small class="text-muted"><b>Cels: </b><span class="infoPhoneCompany"> 000-000-00-00</span></small><br>
              <small class="text-muted"><b>Whatsapp: </b><span class="infoWhatsappCompany"> 000 000 00 00</span></small><br>

              <small class="text-muted"><b><span class="infoMailsCompany">Correos</span></b></small><br>
              <small class="text-muted"><b><span class="infoRepresentativeCompany">Representante</span></b></small>
            </div>
            <div class="col-md-4 text-left">
              <small class="text-muted"><b>COTIZACION</b></small><br>
              <small class="text-muted"><b>Código: </b><span class="infoQuotationCode"> 000</span></small><br>
              <small class="text-muted"><b>Fecha: </b><span class="infoQuotationDate"> AAAA-mm-dd</span></small><br>
              <div class="row text-left">
                <div class="col-md-12">
                  <small class="text-muted"><b>Estado de cotización: </b></small>
                  <input type="text" class="form-control text-center" name="infoQuotationStatus" value="" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="row py-3 px-3 border-top">
            <small class="text-muted">INFORMACION DE COTIZACION:</small>
          </div>
          <div class="row card-body border-top pt-3">
            <div class="col-md-4 text-left border-right">
              <div class="form-group">
                <small class="text-muted">Nombres de cliente:</small><br>
                <span class="infoCustomerName">ClienteNombres</span><br>
                <small class="text-muted">Número de contacto:</small><br>
                <span class="infoCustomerPhone">NumeroCelular</span><br>
                <small class="text-muted">Correo eletrónico:</small><br>
                <span class="infoCustomerMail">CorreoElectronico</span><br>
                <small class="text-muted">Nombres de estudiante:</small><br>
                <span class="infoStudentName">EstudianteNombres</span><br>
                <small class="text-muted">EDAD:</small><br>
                <span class="infoStudentYears">Edad</span><br>
                <small class="text-muted">Notas/Observaciones:</small><br>
                <span class="infoCustomerNotes">NotasDeAgendamiento</span><br>
                <small class="text-muted">Agenda: </small><br>
                <span class="infoQuotationScheduling"> SinAgenda</span><br>
                <hr>
                <small class="text-muted">Concepto de Grado:</small><br>
                <span class="infoQuotationGrade">ConceptoGrado</span><br>
                <hr>
                <small class="text-muted"><b>Total a pagar: </b></small>
                <input type="text" class="form-control text-center" name="infoQuotationTotal" value="$0" readonly>
              </div>
            </div>
            <div class="col-md-8 text-right">
              <table class="table" width="100%">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th colspan="4">CONCEPTO</th>
                    <th>VALOR</th>
                  </tr>
                </thead>
                <tbody class="table-services-modal">
                  <!-- CAMPOS DINAMICOS -->
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de detalles y exportacion a PDF -->
<div class="modal fade" id="seeDetailsBinnacle">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row">
          <div class="col-md-12 text-center">
            <h4>BITACORA DE SEGUIMIENTO:</h4>
            <h6 class="nameCustomer"></h6>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="row modal-body">
        <div class="col-md-12">
          <form action="{{ route('binnacle.save') }}" method="POST">
            @csrf
            <div class="form-group">
              <input type="hidden" name="binProposal_id" class="form-control form-control-sm" readonly required>
              <small class="text-muted">FECHA:</small>
              <input type="text" name="binDate" class="form-control form-control-sm datepicker" required>
            </div>
            <div class="form-group">
              <small class="text-muted">DESCRIPCIÓN:</small>
              <textarea type="text" name="binObservation" class="form-control form-control-sm" required></textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-outline-success">GUARDAR REGISTRO</button>
            </div>
          </form>
          <div class="row mt-3 p-3 border-top">
            <table class="table tblBinnacle" width="100%">
              <thead>
                <tr>
                  <th>FECHA:</th>
                  <th>OBSERVACIÓN:</th>
                </tr>
              </thead>
              <tbody>
                <!-- Dinamics -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script>
  $(function() {
    var countRow = $('#tabletracings tbody').find('tr').length;
    for (var i = 1; i <= countRow; i++) {
      var statusRow = $('#tabletracings').find("tbody tr:nth-child(" + i + ")").find('.status').text();
      if (statusRow == 'APROBADO') {
        $('#tabletracings').find("tbody tr:nth-child(" + i + ") .status").css('background', 'rgba(164,176,104,0.4)');
      } else if (statusRow == 'SIN RESPUESTA') {
        $('#tabletracings').find("tbody tr:nth-child(" + i + ") .status").css('background', 'rgba(253,135,1,0.4)');
      }
    }
  });

  $('.seeModalWithInfo').on('click', function() {
    var proposalId = $(this).find('span').text();
    $.get("{{ route('importAllProposal') }}", {
      proposalSelected: proposalId
    }, function(objectProposal) {

      //GUARDAR CODIGO DE PROPUESTA PARA REALIZAR DESCARGA PDF
      $('input[name=CodeFromBtnDownload]').val('');
      $('input[name=CodeFromBtnDownload]').val(proposalId);

      //GUARDAR CODIGO DE PROPUESTA PARA CAMBIAR A ESTADO APROBADO
      $('input[name=CodeFromBtnApproved]').val('');
      $('input[name=CodeFromBtnApproved]').val(proposalId);
      $('input[name=CodeFromBtnDenied]').val('');
      $('input[name=CodeFromBtnDenied]').val(proposalId);

      //COTIZACION
      $('.infoQuotationCode').text('');
      $('.infoQuotationCode').text(proposalId);

      //LIMPIAR CAMPOS DE INFORMACION BASICA
      $('.infoQuotationDate').text('');
      $('input[name=infoQuotationStatus]').val('');
      $('input[name=infoQuotationTotal]').val('');
      $('.infoCustomerName').text('');
      $('.infoCustomerPhone').text('');
      $('.infoCustomerMail').text('');
      $('.infoStudentName').text('');
      $('.infoStudentYears').text('');
      $('.infoCustomerNotes').text('');
      $('.infoQuotationScheduling').text('');
      $('.infoQuotationGrade').text('');
      //LIMPIAR CAMPOS DE PRODUCTOS/SERVICIOS COTIZADOS
      $('.infoQuotationAdmissionConcept').text('');
      $('.infoQuotationAdmissionValue').text('');
      $('.infoQuotationJourneyConcept').text('');
      $('.infoQuotationJourneyDays').text('');
      $('.infoQuotationJourneyEntry').text('');
      $('.infoQuotationJourneyExit').text('');
      $('.infoQuotationJourneyValue').text('');
      $('.infoQuotationFeedingConcept').text('');
      $('.infoQuotationFeedingValue').text('');
      $('.infoQuotationUniformConcept').text('');
      $('.infoQuotationUniformValue').text('');
      $('.infoQuotationSupplieConcept').text('');
      $('.infoQuotationSupplieValue').text('');
      $('.infoQuotationTransportConcept').text('');
      $('.infoQuotationTransportValue').text('');
      $('.infoQuotationExtratimeConcept').text('');
      $('.infoQuotationExtratimeValue').text('');
      $('.infoQuotationExtracurricularConcept').text('');
      $('.infoQuotationExtracurriculartValue').text('');

      var count = Object.keys(objectProposal).length //total de registros

      // VACIAR LA TABLA MODAL
      $('.table-services-modal').empty();

      //RECORRER ARREGLO RECIBIDO CON LA INFORMACION UNIFICADA DEL CLIENTE Y LA COTIZACION REALIZADA
      for (var i = 0; i < count; i++) {
        //SI ES EL PRIMER ELEMENTO TIENE LA INFORMACION DEL CLIENTE Y LA INFORMACION BASICA DE LA COTIZACION
        if (i == 0) {
          //FECHA DE PROPUESTA
          $('.infoQuotationDate').text(objectProposal[i][0]);
          //SI ES ESTADO ABIERTO O CERRADO SE MUESTRA O NO BOTON PARA APROBAR
          if (objectProposal[i][1] == 'ABIERTO') {
            $('#formForApproved').css('display', 'block');
            $('input[name=infoQuotationStatus]').val('EN ESPERA DE RESPUESTA');
          } else if (objectProposal[i][1] == 'CERRADO') {
            $('#formForApproved').css('display', 'none');
            $('input[name=infoQuotationStatus]').val(objectProposal[i][2]);
          }
          $('input[name=infoQuotationTotal]').val(objectProposal[i][3]);
          //DATOS DE CLIENTE
          $('.infoCustomerName').text(objectProposal[i][4]);
          $('.infoCustomerPhone').text(objectProposal[i][5]);
          $('.infoCustomerMail').text(objectProposal[i][6]);
          $('.infoStudentName').text(objectProposal[i][7]);
          $('.infoStudentYears').text(objectProposal[i][8]);
          $('.infoCustomerNotes').text(objectProposal[i][9]);

          if (objectProposal[i][10] == null || objectProposal[i][10] == '') {
            $('.infoQuotationScheduling').text('SIN AGENDA');
          } else {
            $('.infoQuotationScheduling').text('');
          }
          $('.infoQuotationGrade').text(objectProposal[i][11]);
        } else if (i > 0) {
          if (objectProposal[i][0] != 'JORNADA') {
            if (objectProposal[i][0] == 'EXTRACURRICULAR') {
              $('.table-services-modal').append(
                "<tr>" +
                "<th>" + objectProposal[i][0] + "</th>" +
                "<td colspan='4'>" + objectProposal[i][1] + " " + objectProposal[i][2] + "</td>" +
                "<td>" + objectProposal[i][3] + "</td>" +
                "</tr>"
              );
            } else {
              $('.table-services-modal').append(
                "<tr>" +
                "<th>" + objectProposal[i][0] + "</th>" +
                "<td colspan='4'>" + objectProposal[i][1] + "</td>" +
                "<td>" + objectProposal[i][2] + "</td>" +
                "</tr>"
              );
            }
          } else {
            $('.table-services-modal').append(
              "<tr>" +
              "<th>" + objectProposal[i][0] + "</th>" +
              "<td colspan='4'>" +
              "<b>" + objectProposal[i][1] + "<br>" +
              "<b>Dias: </b>" + objectProposal[i][2] + "<br>" +
              "<b>Entrada: </b>" + objectProposal[i][3] + "<br>" +
              "<b>Salida: </b>" + objectProposal[i][4] + "<br>" +
              "<b>Valor: </b>" + objectProposal[i][5] + "<br>" +
              "</td>" +
              "<td>" + objectProposal[i][2] + "</td>" +
              "</tr>"
            );
          }
        }
      } //END FOR

      //RECORRER FILAS DE LA TABLA MODAL PARA DESAPARECER LAS QUE NO TENGAN DATOS
      // $('.table-services-modal tr').each(function(){
      // 	var validateText = $(this).find('span:first').text();
      // 	if(validateText == ''){
      // 		$(this).css('visibility','hidden');
      // 	}else{
      // 		$(this).css('visibility','visible');
      // 	}
      // });

      //ORGANIZACION
      //$('.infoImgCompany').attr(''); //IMG
      //$('.infoReasonCompany').text('');
      //$('.infoNameCompany').text('');
      //$('.infoNitCompany').text('');
      //$('.infoWebCompany').text('');
      //$('.infoCityCompany').text('');
      //$('.infoAddressCompany').text('');
      //$('.infoTelsCompany').text('');
      //$('.infoPhoneCompany').text('');
      //$('.infoWhatsappCompany').text('');
      //$('.infoMailsCompany').text('');
      //$('.infoNameRepresentativeCompany').text('');
      //$('.infoDocumentRepresentativeCompany').text('');

      $.get("{{ route('getGarden') }}", function(objectGarden) {
        if (objectGarden != null && objectGarden != '') {
          $('.infoReasonCompany').text('');
          $('.infoReasonCompany').text(objectGarden['garReasonsocial']);
          $('.infoNameCompany').text('');
          $('.infoNameCompany').text(objectGarden['garNamecomercial']);
          $('.infoNitCompany').text('');
          $('.infoNitCompany').text(objectGarden['garNit']);
          $('.infoWebCompany').text('');
          $('.infoWebCompany').text(objectGarden['garWebsite']);
          $('.infoCityCompany').text('');
          $('.infoCityCompany').text(objectGarden['garNameCity'] + ' - ' + objectGarden['garNameLocation'] + ' -  ' + objectGarden['garNameDistrict']);
          $('.infoAddressCompany').text('');
          $('.infoAddressCompany').text(objectGarden['garAddress']);
          $('.infoTelsCompany').text('');
          $('.infoTelsCompany').text(objectGarden['garPhoneone'] + ' - ' + objectGarden['garPhonetwo'] + ' -  ' + objectGarden['garPhonethree']);
          $('.infoPhoneCompany').text('');
          $('.infoPhoneCompany').text(objectGarden['garPhone']);
          $('.infoWhatsappCompany').text('');
          $('.infoWhatsappCompany').text(objectGarden['garWhatsapp']);
          $('.infoMailsCompany').text('');
          $('.infoMailsCompany').text(objectGarden['garMailone'] + ' - ' + objectGarden['garMailtwo']);
          $('.infoRepresentativeCompany').text('');
          $('.infoRepresentativeCompany').text(objectGarden['garNamerepresentative'] + ' C.C ' + objectGarden['garCardrepresentative']);
        }
      });

      $('#seeDetailsTracing').modal();
    });
  });

  $('.seeModalBinnacle').on('click', function() {
    var proposalId = $(this).find('span:nth-child(2)').text();
    var nameCustomer = $(this).find('span:nth-child(3)').text();
    $('.nameCustomer').text('');
    $('.nameCustomer').text(nameCustomer);
    $('input[name=binProposal_id]').val('');
    $('input[name=binProposal_id]').val(proposalId);
    $.get("{{ route('getHistoryBinnacle') }}", {
      proposalId: proposalId
    }, function(objectHistory) {
      var count = Object.keys(objectHistory).length //total de registro de bitacora
      if (count > 0) {
        $('.tblBinnacle tbody').empty();
        for (var i = 0; i < count; i++) {
          $('.tblBinnacle tbody').append("<tr><td>" + objectHistory[i]['binDate'] + "</td><td>" + objectHistory[i]['binObservation'] + "</td></tr>");
        }
      } else {
        $('.tblBinnacle tbody').empty();
      }
    });
    $('#seeDetailsBinnacle').modal();
  });
</script>
@endsection