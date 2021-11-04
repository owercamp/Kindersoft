@extends('modules.proposal')

@section('proposalComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>COTIZACIONES CERRADAS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de archivo -->
      <!-- @if(session('PrimaryUpdateFiles'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateFiles') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateFiles'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateFiles') }}
				    </div>
				@endif -->
    </div>
  </div>
  <table id="tabletracings" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>FECHA DE COTIZACION</th>
        <th>NOMBRE</th>
        <th>CORREO ELECTRONICO</th>
        <th>NUMERO DE CONTACTO</th>
        <th>ESTADO</th>
        <th>DETALLES</th>
      </tr>
    </thead>
    <tbody>
      @for($i = 0; $i < count($tracings); $i++) <tr>
        <td>{{ $tracings[$i][0] }}</td>
        <td>{{ $tracings[$i][1] }}</td>
        <td>{{ $tracings[$i][3] }}</td>
        <td>{{ $tracings[$i][4] }}</td>
        <td>{{ $tracings[$i][5] }}</td>
        @if($tracings[$i][2] == 'ACEPTADO')
        <td>
          <p class="badge rounded-pill bg-success text-white mb-0 p-2" style="font-size: 0.80rem;">{{ __('APROBADA') }}</p>
        </td>
        @elseif($tracings[$i][2] == 'DENEGADO')
        <td>
          <p class="badge rounded-pill bg-danger text-white mb-0 p-2" style="font-size: 0.80rem;">{{ __('DENEGADA') }}</p>
        </td>
        @elseif($tracings[$i][2] == 'ELIMINADO')
        <td>
          <p class="badge rounded-pill bg-secondary text-white mb-0 p-2" style="font-size: 0.80rem;">{{ __('CLIENTE ELIMINADO') }}</p>
        </td>
        @endif
        <td>
          @if($tracings[$i][3] != 'eliminado')
          <button type="button" title="DETALLES" class="bj-btn-table-add seeModalWithInfo">
            <i class="fas fa-eye"></i>
            <span hidden>{{ $tracings[$i][0] }}</span>
          </button>
          @endif
        </td>
        </tr>
        @endfor
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
            <form id="formForDownload" action="{{ route('tracingsPdf') }}" method="GET">
              @csrf
              <div class="form-group">
                <input type="hidden" class="form-control form-control-sm" name="CodeFromBtnDownload" readonly required>
                <button type="submit" class="bj-btn-table-delete mx-3"><i class="fas fa-file-pdf"></i> DESCARGAR PDF</button>
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
              <table class="table table-responsive">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th colspan="4">CONCEPTO</th>
                    <th>VALOR</th>
                  </tr>
                </thead>
                <tbody class="table-services-modal">
                  <tr>
                    <th><small class="text-center">ADMISION:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationAdmissionConcept">ConceptoAdmision</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationAdmissionValue">ValorAdmision</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">JORNADA:</small></th>
                    <td colspan="4">
                      <small class="text-muted"><span class="infoQuotationJourneyConcept">ConceptoJornada</span></small><br>
                      <small class="text-muted"><b>Detalles de jornada:</b></small><br>
                      <small class="text-muted">Dias: </small><span class="infoQuotationJourneyDays">DiasJornada</span><br>
                      <small class="text-muted">Entrada: </small><span class="infoQuotationJourneyEntry">EntradaJornada</span><br>
                      <small class="text-muted">Salida: </small><span class="infoQuotationJourneyExit">SalidaJornada</span><br>
                    </td>
                    <td>
                      <small class="text-muted"><span class="infoQuotationJourneyValue">ValorJornada</span></small>
                    </td>
                  </tr>
                  <tr>
                    <th><small class="text-center">ALIMENTACION:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationFeedingConcept">ConceptoAlimentacion</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationFeedingValue">ValorAlimentacion</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">UNIFORME:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationUniformConcept">ConceptoUniforme</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationUniformValue">ValorUniforme</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">MATERIAL ESCOLAR:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationSupplieConcept">ConceptoMaterial</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationSupplieValue">ValorMaterial</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">TRANSPORTE:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationTransportConcept">ConceptoTransporte</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationTransportValue">ValorTransporte</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">TIEMPO EXTRA:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationExtratimeConcept">ConceptoTiempoextra</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationExtratimeValue">ValorTiempoextra</span></small></td>
                  </tr>
                  <tr>
                    <th><small class="text-center">EXTRACURRICULAR:</small></th>
                    <td colspan="4"><small class="text-muted"><span class="infoQuotationExtracurricularConcept">ConceptoExtracurricular</span></small></td>
                    <td><small class="text-muted"><span class="infoQuotationExtracurriculartValue">ValorExtracurricular</span></small></td>
                  </tr>
                </tbody>
              </table>
            </div>
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

  });

  $('.seeModalWithInfo').on('click', function() {
    var proposalId = $(this).find('span').text();

    $.get("{{ route('importAllProposal') }}", {
      proposalSelected: proposalId
    }, function(objectProposal) {

      //GUARDAR CODIGO DE PROPUESTA PARA REALIZAR DESCARGA PDF
      $('input[name=CodeFromBtnDownload]').val('');
      $('input[name=CodeFromBtnDownload]').val(proposalId);

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
          $('input[name=infoQuotationTotal]').val(new Intl.NumberFormat().format(objectProposal[i][3]));
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
          //ADMISION
          if (objectProposal[i][0] == 'ADMISION') {
            $('.infoQuotationAdmissionConcept').text(objectProposal[i][1]);
            $('.infoQuotationAdmissionValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //JORNADA
          if (objectProposal[i][0] == 'JORNADA') {
            $('.infoQuotationJourneyConcept').text(objectProposal[i][1]);
            $('.infoQuotationJourneyDays').text(objectProposal[i][2]);
            $('.infoQuotationJourneyEntry').text(objectProposal[i][3]);
            $('.infoQuotationJourneyExit').text(objectProposal[i][4]);
            $('.infoQuotationJourneyValue').text(new Intl.NumberFormat().format(objectProposal[i][5]));
          }
          //ALIMENTACION
          if (objectProposal[i][0] == 'ALIMENTACION') {
            $('.infoQuotationFeedingConcept').text(objectProposal[i][1]);
            $('.infoQuotationFeedingValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //UNIFORME
          if (objectProposal[i][0] == 'UNIFORME') {
            $('.infoQuotationUniformConcept').text(objectProposal[i][1]);
            $('.infoQuotationUniformValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //MATERIAL ESCOLAR
          if (objectProposal[i][0] == 'MATERIAL ESCOLAR') {
            $('.infoQuotationSupplieConcept').text(objectProposal[i][1]);
            $('.infoQuotationSupplieValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //TRANSPORTE
          if (objectProposal[i][0] == 'TRANSPORTE') {
            $('.infoQuotationTransportConcept').text(objectProposal[i][1]);
            $('.infoQuotationTransportValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //TIEMPO EXTRA
          if (objectProposal[i][0] == 'TIEMPO EXTRA') {
            $('.infoQuotationExtratimeConcept').text(objectProposal[i][1]);
            $('.infoQuotationExtratimeValue').text(new Intl.NumberFormat().format(objectProposal[i][2]));
          }
          //EXTRACURRICULAR
          if (objectProposal[i][0] == 'EXTRACURRICULAR') {
            $('.infoQuotationExtracurricularConcept').text(objectProposal[i][1] + ' ' + objectProposal[i][2]);
            $('.infoQuotationExtracurriculartValue').text(new Intl.NumberFormat().format(objectProposal[i][3]));
          }
        }
      } //END FOR

      //RECORRER FILAS DE LA TABLA MODAL PARA DESAPARECER LAS QUE NO TENGAN DATOS
      $('.table-services-modal tr').each(function() {
        var validateText = $(this).find('span:first').text();
        if (validateText == '') {
          $(this).css('visibility', 'hidden');
        } else {
          $(this).css('visibility', 'visible');
        }
      });

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
</script>
@endsection
