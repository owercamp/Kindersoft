@extends('modules.accountants')



@section('financialModules')
  <div class="col-md-12">

    <div class="col-md-12">

      <div class="row border-bottom mb-3">

        <div class="col-md-6">

          <h3>COMPROBANTES DE INGRESO</h3>

          <!-- <a class="btn btn-outline-success form-control-sm newVoucherEntry-link" href="#" title="AGREGAR">NUEVO COMPROBANTE</a> -->

        </div>

        <div class="col-md-6">

          <!-- Mensajes de creación de comprobantes de ingreso -->

          @if (session('SuccessSaveEntry'))
            <div class="alert alert-success">

              {{ session('SuccessSaveEntry') }}

            </div>
          @endif

          @if (session('SecondarySaveEntry'))
            <div class="alert alert-secondary">

              {{ session('SecondarySaveEntry') }}

            </div>
          @endif

          <!-- Mensajes de actualizacion de comprobantes de ingreso -->

          @if (session('PrimaryUpdateEntry'))
            <div class="alert alert-primary">

              {{ session('PrimaryUpdateEntry') }}

            </div>
          @endif

          @if (session('SecondaryUpdateEntry'))
            <div class="alert alert-secondary">

              {{ session('SecondaryUpdateEntry') }}

            </div>
          @endif

          <!-- Mensajes de eliminación de comprobantes de ingreso -->

          @if (session('WarningDeleteEntry'))
            <div class="alert alert-warning">

              {{ session('WarningDeleteEntry') }}

            </div>
          @endif

          @if (session('SecondaryDeleteEntry'))
            <div class="alert alert-secondary">

              {{ session('SecondaryDeleteEntry') }}

            </div>
          @endif

        </div>

      </div>

      <div class="row">

        <div class="col-md-12">

          <form action="{{ route('entryVouchers.excel') }}" method="GET">

            @csrf

            <div class="row">

              <div class="col-md-4">

                <div class="form-group">

                  <small class="text-muted">FECHA INICIAL:</small>

                  <input class="form-control form-control-sm datepicker" name="venDateInitial" required type="text">

                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">

                  <small class="text-muted">FECHA FINAL:</small>

                  <input class="form-control form-control-sm datepicker" name="venDateFinal" required type="text"
                    value="{{ $day }}">

                </div>

              </div>

              <div class="col-md-4">

                <button class="btn btn-outline-success form-control-sm mt-4" type="submit">GENERAR EXCEL</button>

              </div>

            </div>



          </form>

        </div>

      </div>

      <table class="table-hover table text-center" id="tableDatatable" width="100%">

        <thead>

          <tr>

            <th>COMPROBANTE</th>

            <th>FECHA DE INGRESO</th>

            <th>ALUMNO</th>

            <th>FACTURA</th>

            <th>VALOR PAGADO</th>

            <th>DETALLES</th>

          </tr>

        </thead>

        <tbody>

          @foreach ($voucherentrys as $entry)
            <tr>

              <td>{{ $entry->venCode }}</td>

              <td>{{ $entry->venDate }}</td>

              <td>{{ $entry->venStudent }}</td>

              <td>{{ $entry->facCode }}</td>

              <td>{{ $entry->venPaid }}</td>

              <td>

                <a class="btn btn-outline-success rounded-circle detailsVoucherentry-link" href="#"
                  title="VER DETALLES">

                  <i class="fas fa-eye"></i>

                  <span hidden>{{ $entry->venId }}</span>

                  <span hidden>{{ $entry->facId }}</span>

                  <span hidden>{{ $entry->idStudent }}</span>

                </a>

                <form action="{{ route('entryVouchers.pdf') }}" method="GET" style="display: inline;">

                  @csrf

                  <input class="form-control form-control-sm" name="venId" type="hidden" value="{{ $entry->venId }}">

                  <button class="btn btn-outline-tertiary rounded-circle" title="PDF DE COMPROBANTE" type="submit">

                    <i class="fas fa-file-pdf"></i>

                    <span hidden>{{ $entry->venId }}</span>

                    <span hidden>{{ $entry->idStudent }}</span>

                  </button>

                </form>

                <form action="{{ route('entryVouchersFacturation.pdf') }}" method="GET" style="display: inline;">

                  @csrf

                  <input class="form-control form-control-sm" name="facId" type="hidden" value="{{ $entry->facId }}">

                  <button class="btn btn-outline-primary rounded-circle" title="PDF DE FACTURA" type="submit">

                    <i class="fas fa-file-pdf"></i>

                    <span hidden>{{ $entry->facId }}</span>

                  </button>

                </form>

                <!-- <a class="btn btn-outline-tertiary detailsVoucherentry-link" href="{{ route('entryVouchers.pdf', $entry->venId) }}" title="DESCARGAR">

                <i class="fas fa-file-pdf"></i>

                <span hidden>{{ $entry->venId }}</span>

                <span hidden>{{ $entry->facId }}</span>

               </a> -->

              </td>

            </tr>
          @endforeach

        </tbody>

      </table>

    </div>

  </div>



  <div class="modal fade" id="detailsVoucherEntry-modal">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header">

          <div class="row">

            <div class="col-md-12 d-flex">

              <h4 class="text-muted">DETALLES DE COMPROBANTE DE INGRESO</h4>

            </div>

          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>

        </div>

        <div class="row modal-body">

          <div class="col-md-4">

            <small class="text-muted">ALUMNO:</small>

            <h6 class="nameStudent"></h6>

            <h6 class="documentStudent"></h6>

            <h6 class="yearsStudent"></h6>

            <h6 class="courseStudent"></h6>

            <hr>

            <small class="text-muted">ACUDIENTE/S:</small>

            <hr>

            <h6 class="nameFather"></h6>

            <h6 class="documentFather"></h6>

            <h6 class="phoneFather"></h6>

            <h6 class="mailFather"></h6>

            <hr>

            <h6 class="nameMother"></h6>

            <h6 class="documentMother"></h6>

            <h6 class="phoneMother"></h6>

            <h6 class="mailMother"></h6>

            <hr>

            <small class="text-muted">CONTRATO:</small>

            <hr>

            <h6 class="dateInitial"></h6>

            <h6 class="dateFinal"></h6>

          </div>

          <div class="col-md-5">

            <table class="table-concepts table" width="100%">

              <thead>

                <tr>

                  <th>CONCEPTO</th>

                  <th>VALOR</th>

                  <th>IVA</th>

                </tr>

              </thead>

              <tbody>

                <!-- Dinamico -->

              </tbody>

            </table>

          </div>

          <div class="col-md-3">

            <small class="text-muted">COMPROBANTE:</small><br>

            <div class="input-group">

              <div class="input-group-prepend">

                <span class="input-group-text">

                  <i class="fas fa-key"></i>

                </span>

              </div>

              <input class="form-control form-control-sm text-center" disabled name="codeVoucher"
                style="font-weight: bold;" title="CÓDIGO DE COMPROBANTE" type="text">

            </div>

            <small class="text-muted">FECHA DE EMISION:</small><br>

            <h6 class="dateVoucher"></h6>

            <small class="text-muted">DESCRIPCION:</small><br>

            <h6 class="descriptionVoucher"></h6>

            <hr>

            <small class="text-muted">FACTURA:</small><br>

            <div class="input-group">

              <div class="input-group-prepend">

                <span class="input-group-text">

                  <i class="fas fa-key"></i>

                </span>

              </div>

              <input class="form-control form-control-sm text-center" disabled name="codeFacture"
                style="font-weight: bold;" title="CÓDIGO DE FACTURA" type="text">

            </div>

            <small class="text-muted">VALOR PAGADO (+ IVA):</small>

            <h6 class="valuePaid"></h6>

            <small class="text-muted">PORCENTAJE DE IVA:</small>

            <h6 class="porcentageIva"></h6>

            <small class="text-muted">FECHA DE EMISION:</small>

            <h6 class="dateInitialFacture"></h6>

            <small class="text-muted">FECHA DE VENCIMIENTO:</small>

            <h6 class="dateFinalFacture"></h6>

            <small class="text-muted">VALOR SIN IVA:</small>

            <h6 class="valueFacture"></h6>

          </div>

        </div>

      </div>

    </div>

  </div>



  <div class="modal fade" id="excelVoucherEntry-modal">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header">

          <div class="row">

            <div class="col-md-12 d-flex">

              <h4 class="text-muted">EXPORTAR COMPROBANTES A EXCEL</h4>

            </div>

          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>

        </div>

        <div class="row modal-body">

          <form action="">

            <div class="row">

              <div class="col-md-12">

                @php $datenow = Date('Y-m-d'); @endphp

                <div class="form-group">

                  <small>FECHA:</small>

                  <input class="form-control form-control-sm datepicker" required type="text"
                    value='{{ $day }}'>

                </div>

              </div>

            </div>

            <div class="row">

              <div class="col-md-12 text-center">

                <button class="btn btn-outline-success" type="submit">GENERAR EXCEL</button>

              </div>

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>
@endsection



@section('scripts')
  <script>
    $(function() {



    });





    $('.detailsVoucherentry-link').on('click', function(e) {

      e.preventDefault();

      var voucher = $(this).find('span:nth-child(2)').text();

      var facturation = $(this).find('span:nth-child(3)').text();

      var student = $(this).find('span:nth-child(4)').text();

      // CONSULTA DE DETALLES DE COMPROBANTE

      $.get("{{ route('getDetailsVoucherEntry') }}", {

        venId: voucher,

        facId: facturation,

        student: student

      }, function(objectsEntry) {
        console.log(objectsEntry);

        var count = Object.keys(objectsEntry).length;

        if (count > 0) {

          $('.table-concepts tbody').empty();

          for (var i = 0; i < count; i++) {

            if (objectsEntry[i][0] == 'INFORMACION') {

              //ALUMNO

              $('.nameStudent').text('');

              $('.nameStudent').text(objectsEntry[i][1]);

              $('.documentStudent').text('');

              $('.documentStudent').text(objectsEntry[i][2]);

              $('.yearsStudent').text('');

              $('.yearsStudent').text(objectsEntry[i][3]);

              $('.courseStudent').text('');

              $('.courseStudent').text(objectsEntry[i][4]);

              //PADRE

              $('.nameFather').text('');

              $('.nameFather').text(objectsEntry[i][5]);

              $('.documentFather').text('');

              $('.documentFather').text(objectsEntry[i][6]);

              $('.phoneFather').text('');

              $('.phoneFather').text(objectsEntry[i][7]);

              $('.mailFather').text('');

              $('.mailFather').text(objectsEntry[i][8]);

              //MADRE

              $('.nameMother').text('');

              $('.nameMother').text(objectsEntry[i][9]);

              $('.documentMother').text('');

              $('.documentMother').text(objectsEntry[i][10]);

              $('.phoneMother').text('');

              $('.phoneMother').text(objectsEntry[i][11]);

              $('.mailMother').text('');

              $('.mailMother').text(objectsEntry[i][12]);

              //CONTRATO

              $('.dateInitial').text('');

              $('.dateInitial').text(objectsEntry[i][13]);

              $('.dateFinal').text('');

              $('.dateFinal').text(objectsEntry[i][14]);

              //COMPROBANTE

              $('input[name=codeVoucher]').val('');

              $('input[name=codeVoucher]').val(objectsEntry[i][15]);

              $('.dateVoucher').text('');

              $('.dateVoucher').text(objectsEntry[i][16]);

              $('.descriptionVoucher').text('');

              $('.descriptionVoucher').text(objectsEntry[i][17]);

              //FACTURA

              $('input[name=codeFacture]').val('');

              $('input[name=codeFacture]').val(objectsEntry[i][18]);

              $('.valuePaid').text('');

              $('.valuePaid').text(objectsEntry[i][25]);

              $('.porcentageIva').text('');

              $('.porcentageIva').text(objectsEntry[i][19]);

              $('.dateInitialFacture').text('');

              $('.dateInitialFacture').text(objectsEntry[i][20]);

              $('.dateFinalFacture').text('');

              $('.dateFinalFacture').text(objectsEntry[i][21]);

              $('.valueFacture').text('');

              $('.valueFacture').text(objectsEntry[i][25]);

            } else {

              $('.table-concepts tbody').append('<tr><td>' + objectsEntry[i][1] + '</td><td>' + objectsEntry[i][
                2
              ] + '</td><td>' + objectsEntry[i][3] + '</td></tr>');

            }

          }

        } else {

          //ALUMNO

          $('.nameStudent').text('');

          $('.documentStudent').text('');

          $('.yearsStudent').text('');

          $('.courseStudent').text('');

          //PADRE

          $('.nameFather').text('');

          $('.documentFather').text('');

          $('.phoneFather').text('');

          $('.mailFather').text('');

          //MADRE

          $('.nameMother').text('');

          $('.documentMother').text('');

          $('.phoneMother').text('');

          $('.mailMother').text('');

          //CONTRATO

          $('.dateInitial').text('');

          $('.dateFinal').text('');

          //COMPROBANTE

          $('input[name=codeVoucher]').val('');

          $('.dateVoucher').text('');

          $('.descriptionVoucher').text('');

          //FACTURA

          $('input[name=codeFacture]').val('');

          $('.valuePaid').text('');

          $('.porcentageIva').text('');

          $('.dateInitialFacture').text('');

          $('.dateFinalFacture').text('');

          $('.valueFacture').text('');

          //TABLA

          $('.table-concepts tbody').empty();

        }

      });

      $('#detailsVoucherEntry-modal').modal();

    });



    // $('.newVoucherEntry-link').on('click',function(e){

    // 	e.preventDefault();

    // 	$('#newVoucherEntry-modal').modal();

    // });, 



    // $('select[name=venLegalization]').on('change',function(e){

    // 	var selected = e.target.value;

    // 	$('.sectionFacture').css('display','none');

    // 	$('.facValue').text('');

    // 	$('.facDateInitial').text('');

    // 	$('.facDateFinal').text('');

    // 	$('.walletMoney').text('$ -');

    // 	$('.walletStatus').text('');

    // 	$('.useWallet').css('visibility','hidden');

    // 	$('input[name=venPay]').val('');

    // 	$('input[name=venPaid]').val('');

    // 	$('input[name=venPaid]').attr('readonly',true);

    // 	if(selected != ''){

    // 		$.get("{{ route('getFactures') }}",{selected: selected},function(objectFactures){

    // 			var count = Object.keys(objectFactures).length //total de cursos del grado seleccionado

    // 			var student = '';

    // 			if(count > 0){

    // 				var countFacture = 0;

    // 				$('select[name=venFacture]').empty();

    // 				$('select[name=venFacture]').append("<option value=''>Seleccione una factura...</option>");

    // 				for (var i = 0; i < count; i++) {

    // 					student = objectFactures[i]['idStudent'];

    // 					$('select[name=venFacture]').append('<option value=' + objectFactures[i]['facId'] + '>CODIGO ' + objectFactures[i]['facCode'] + ', FECHA ' + objectFactures[i]['facDateInitial'] + '</option>');

    // 					countFacture++;

    // 				}

    // 				//AVISO DE CANTIDAD DE FACTURAS APROBADAS

    // 				if(countFacture == 1){

    // 					$('.message').text('');

    // 					$('.message').css('color','#a4b068');

    // 					$('.message').text('Alumn@ con ' + countFacture + ' factura APROBADA, Seleccionela');

    // 					$('.message-modal').css('display','block');

    // 				}else if(countFacture > 1){

    // 					$('.message').text('');

    // 					$('.message').css('color','#a4b068');

    // 					$('.message').text('Alumn@ con ' + countFacture + ' facturas APROBADAS, Seleccione una');

    // 					$('.message-modal').css('display','block');

    // 				}

    // 				setTimeout(function(){

    // 					$('.message').text('');

    // 					$('.message-modal').css('display','none');

    // 				},5000);

    // 				$.get("{{ route('getWallet') }}",{student: student},function(objectWallet){

    // 						if(objectWallet['waMoney'] > 0){

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#a4b068');

    // 							$('.walletMoney').text('TOTAL ==> $' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#a4b068');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}else if(objectWallet['waMoney'] == 0){

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#0086f9');

    // 							$('.walletMoney').text('TOTAL ==> $' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#0086f9');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}else{

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#fd8701');

    // 							$('.walletMoney').text('TOTAL ==> $ ' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#fd8701');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}

    // 					});

    // 			}else{

    // 				//AVISO DE NINGUNA FACTURA APROBADA

    // 				$('.useWallet').css('visibility','hidden');

    // 				$('select[name=venFacture]').empty();

    // 				$('select[name=venFacture]').append("<option value=''>Seleccione una factura...</option>");

    // 				$('.message').text('');

    // 				$('.message').css('color','#fd8701');

    // 				$('.message').text('No hay ninguna factura APROBADA para el estudiante seleccionado');

    // 				$('.message-modal').css('display','block');

    // 				setTimeout(function(){

    // 					$('.message').text('');

    // 					$('.message-modal').css('display','none');

    // 				},5000);

    // 			}

    // 			if(student == null || student == '' || student == 'undefined'){

    // 				var selectedLegalization = $('select[name=venLegalization] option:selected').val();

    // 				$.get("{{ route('getStudentSelected') }}",{ selectedLegalization:selectedLegalization }, function(response){

    // 					student = response['idStudent'];

    // 					$.get("{{ route('getWallet') }}",{student: student},function(objectWallet){

    // 						if(objectWallet['waMoney'] > 0){

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#a4b068');

    // 							$('.walletMoney').text('TOTAL ==> $' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#a4b068');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}else if(objectWallet['waMoney'] == 0){

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#0086f9');

    // 							$('.walletMoney').text('TOTAL ==> $' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#0086f9');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}else{

    // 							$('.walletMoney').text('');

    // 							$('.walletMoney').css('color','#fd8701');

    // 							$('.walletMoney').text('TOTAL ==> $ ' + objectWallet['waMoney']);

    // 							$('.walletStatus').text('');

    // 							$('.walletStatus').css('color','#fd8701');

    // 							$('.walletStatus').text(objectWallet['waStatus']);

    // 							$('.walletMoneyHide').text('');

    // 							$('.walletMoneyHide').text(objectWallet['waMoney']);

    // 							$('.useWallet').css('visibility','hidden');

    // 						}

    // 					});

    // 				});

    // 			}

    // 		});

    // 	}else{

    // 		$('select[name=venFacture]').empty();

    // 		$('select[name=venFacture]').append("<option value=''>Seleccione una factura...</option>");

    // 		$('.useWallet').css('visibility','hidden');

    // 	}

    // });



    // $('select[name=venFacture]').on('change',function(e){

    // 	var selected = e.target.value;

    // 	if(selected != ''){

    // 		$.get("{{ route('getDatesFacture') }}",{selected: selected},function(objectFacture){

    // 			var valuetotal = 0;

    // 			var count = Object.keys(objectFacture).length

    // 			if(count > 0){

    // 				if(count > 1){

    // 					for (var i = 0; i < count; i++) {

    // 						if(i == 0){

    // 							$('.facValue').text('');

    // 							$('.facValue').text('$' + objectFacture[i][6]);

    // 							$('.facDateInitial').text('');

    // 							$('.facDateInitial').text(objectFacture[i][3]);

    // 							$('.facDateFinal').text('');

    // 							$('.facDateFinal').text(objectFacture[i][4]);

    // 							$('.facStatusDate').text('');

    // 							$('.facPaidPrevious').text('');

    // 							$('input[name=venPay]').val('');

    // 							$('input[name=venPay]').val(objectFacture[i][6]);

    // 							valuetotal = objectFacture[i][6];

    // 							$('input[name=venPaid]').attr('readonly',false);

    // 							//var separatedDate = objectFacture[0]['facDateFinal'].split('-');

    // 							//var date = new Date(separatedDate[0],separatedDate[1],separatedDate[2]);

    // 							var date = new Date(objectFacture[i][4]);

    // 							var now = new Date();

    // 							var today = now.getFullYear() + '-' + (now.getMonth() +1) + '-' + now.getDate();

    // 							if(now < date){

    // 								$('.facStatusDate').text('Esta factura esta VIGENTE');

    // 								$('.facStatusDate').css('color','#a4b068');

    // 							}else{

    // 								$('.facStatusDate').text('Esta factura esta VENCIDA');

    // 								$('.facStatusDate').css('color','#fd8701');

    // 							}

    // 							$('.sectionFacture').css('display','block');

    // 						}else{

    // 							$('.facPaidPrevious').text('');

    // 							if(objectFacture[i][0] == 1){

    // 								$('.facPaidPrevious').text(

    // 									'Esta factura ya tiene ' + objectFacture[i][0] + ' pago anterior, con un valor total de $ ' + objectFacture[i][1]

    // 								);

    // 								var valuenow = $('input[name=venPay]').val();

    // 								var less = parseInt(valuenow) - parseInt(objectFacture[i][1]);

    // 								$('input[name=venPay]').val('');

    // 								$('input[name=venPay]').val(less);

    // 							}else if(objectFacture[i][0] > 1){

    // 								$('.facPaidPrevious').text(

    // 									'Esta factura ya tiene ' + objectFacture[i][0] + ' pagos anteriores, con un valor total de $ ' + objectFacture[i][1]

    // 								);

    // 								var valuenow = $('input[name=venPay]').val();

    // 								var less = parseInt(valuenow) - parseInt(objectFacture[i][1]);

    // 								$('input[name=venPay]').val('');

    // 								$('input[name=venPay]').val(less);

    // 							}

    // 						}

    // 					}

    // 				}else if(count == 1){

    // 					$('.facValue').text('');

    // 					$('.facValue').text('$' + objectFacture[0][6]);

    // 					$('.facDateInitial').text('');

    // 					$('.facDateInitial').text(objectFacture[0][3]);

    // 					$('.facDateFinal').text('');

    // 					$('.facDateFinal').text(objectFacture[0][4]);

    // 					$('.facStatusDate').text('');

    // 					$('.facPaidPrevious').text('');

    // 					$('input[name=venPay]').val('');

    // 					$('input[name=venPay]').val(objectFacture[0][6]);

    // 					valuetotal = objectFacture[0][6];

    // 					$('input[name=venPaid]').attr('readonly',false);

    // 					//var separatedDate = objectFacture[0]['facDateFinal'].split('-');

    // 					//var date = new Date(separatedDate[0],separatedDate[1],separatedDate[2]);

    // 					var date = new Date(objectFacture[0][4]);

    // 					var now = new Date();

    // 					var today = now.getFullYear() + '-' + (now.getMonth() +1) + '-' + now.getDate();

    // 					if(now < date){

    // 						$('.facStatusDate').text('Esta factura esta VIGENTE');

    // 						$('.facStatusDate').css('color','#a4b068');

    // 					}else{

    // 						$('.facStatusDate').text('Esta factura esta VENCIDA');

    // 						$('.facStatusDate').css('color','#fd8701');

    // 					}

    // 					$('.sectionFacture').css('display','block');

    // 				}

    // 			}

    // 			var statusWallet = $('.walletStatus').text();

    // 			if(statusWallet == 'A FAVOR'){

    // 				$('.useWallet').css('visibility','visible');

    // 			}

    // 		});

    // 	}else{

    // 		$('.useWallet').css('visibility','hidden');

    // 		$('.facValue').text('');

    // 		$('.facDateInitial').text('');

    // 		$('.facDateFinal').text('');

    // 		$('.facStatusDate').text('');

    // 		$('.facPaidPrevious').text('');

    // 		$('input[name=venPay]').val('');

    // 		$('input[name=venPaid]').attr('readonly',true);

    // 		$('.facStatusDate').text('');

    // 		$('.sectionFacture').css('display','none');

    // 	}

    // });

    // //DETECTAR CIERRE DE MODAL

    // $("#newVoucherEntry-modal").on('hidden.bs.modal', function () {

    // 	//VACIAR MODAL

    // 	$('.sectionFacture').css('display','none');

    // 	$('.facValue').text('');

    // 	$('.facDateInitial').text('');

    // 	$('.facDateFinal').text('');

    // 	$('.walletMoney').text('$ -');

    // 	$('.walletMoneyHide').text('');

    // 	$('.walletStatus').text('');

    // 	$('input[name=venPay]').val('');

    // 	$('input[name=venPaid]').val('');

    // 	$('input[name=venPaid]').attr('readonly',true);

    // 	$('select[name=venFacture]').empty();

    // 	$('select[name=venFacture]').append("<option value=''>Seleccione una factura...</option>");

    //   	});

    // //CAMBIAR VALOR DE PAGO

    // $('input[name=venPaid]').on('keyup',function(){

    // 	var paid = parseInt($(this).val());

    // 	changeResults(paid);

    // });

    // //BOTON USAR ==> PARA USAR EL SALDO DE LA CARTERA DEL ALUMNO

    // $('.useWallet').on('click',function(e){

    // 	e.preventDefault();

    // 	$('input[name=walletused]').val('true');

    // 	var wallet = parseInt($('.walletMoneyHide').text());

    // 	var facture = parseInt($('input[name=venPay]').val());

    // 	console.log(wallet + ' ' + facture);

    // 	$('.walletMoneyHide').text('');

    // 	$('input[name=venPay]').val('');

    // 	//$('input[name=venPaid]').val('');

    // 	$('input[name=waMoneyFuture]').val('');

    // 	$('input[name=waStatusFuture]').val('');

    // 	$('.facValueStatus').text('');



    // 	if(wallet > facture){

    // 		var newWallet = wallet - facture;

    // 		var newFacture = 0;

    // 		$('.walletMoneyHide').text(newWallet);

    // 		$('input[name=waMoneyFuture]').val(newWallet);

    // 		$('input[name=waStatusFuture]').val(checkStatus(newWallet));

    // 		$('input[name=venPay]').val(newFacture);

    // 		$('input[name=venPaid]').val(newFacture);

    // 		$('input[name=venPaid]').attr('readonly',true);

    // 		$('.facValueStatus').text('Factura quedará en estado PAGADO');

    // 		$('.btnSaveVoucherEntry').attr('disabled',false);

    // 		//changeResults(newFacture);

    // 	}else if(wallet < facture){

    // 		var newWallet = 0;

    // 		var newFacture = facture - wallet;

    // 		$('.walletMoneyHide').text(newWallet);

    // 		$('input[name=venPay]').val(newFacture);

    // 		//$('input[name=venPaid]').val(newFacture);

    // 		$('input[name=venPaid]').attr('readonly',false);

    // 		$('.facValueStatus').text('Factura seguirá en estado APROBADA con $ ' + newFacture + ' pendiente de pago');

    // 		//changeResults(newFacture);

    // 	}else if(wallet == facture){

    // 		var newWallet = 0;

    // 		var newFacture = 0;

    // 		$('.walletMoneyHide').text(newWallet);

    // 		$('input[name=venPay]').val(newFacture);

    // 		$('input[name=venPaid]').val(newFacture);

    // 		$('input[name=venPaid]').attr('readonly',true);

    // 		$('.facValueStatus').text('Factura quedará en estado PAGADO');

    // 		//changeResults(newFacture);

    // 	}

    // 	$(this).text('');

    // 	$(this).text('USADO');

    // 	$(this).attr('disabled',true);

    // });



    // function checkStatus(value){

    // 	if(value < 0){

    // 		return 'EN DEUDA';

    // 	}else if(value == 0){

    // 		return 'SIN SALDO';

    // 	}else if(value > 0){

    // 		return 'A FAVOR';

    // 	}

    // }

    // //REALIZAR CAMBIOS DE ACUERDO AL VALOR INGRESADO A PAGAR

    // function changeResults(paid){

    // 	if(!isNaN(paid) && paid >= 0){

    // 		$('.btnSaveVoucherEntry').attr('disabled',false);

    // 		var valueFacture = parseFloat($('input[name=venPay]').val());

    // 		var newValueFacture = valueFacture - paid;



    // 		var walletMoneyNow = parseFloat($('.walletMoneyHide').text());

    // 		var walletStatusNow = checkStatus(parseInt(walletMoneyNow));

    // 		//var walletStatusNow = $('.walletStatus').text();

    // 		$('.facValueStatus').text('');

    // 		if(newValueFacture == 0){

    // 			$('.facValueStatus').text('Factura quedará en estado PAGADO');

    // 			$('input[name=waMoneyFuture]').val('');

    // 			$('input[name=waMoneyFuture]').val(walletMoneyNow);

    // 			$('input[name=waStatusFuture]').val('');

    // 			$('input[name=waStatusFuture]').val(walletStatusNow);

    // 		}else if(newValueFacture > 0){

    // 			$('.facValueStatus').text('Factura seguirá en estado APROBADA con $ ' + newValueFacture + ' pendiente de pago');

    // 			$('input[name=waMoneyFuture]').val('');

    // 			$('input[name=waMoneyFuture]').val(walletMoneyNow);

    // 			$('input[name=waStatusFuture]').val('');

    // 			$('input[name=waStatusFuture]').val(walletStatusNow);

    // 		}else if(newValueFacture < 0){

    // 			$('.facValueStatus').text('Factura quedará en estado PAGADO');

    // 			var rest = newValueFacture * (-1);

    // 			var walletMoneyFuture = walletMoneyNow + rest;

    // 			var walletStatusFuture = '';

    // 			if(walletMoneyFuture < 0){

    // 				walletStatusFuture = 'EN DEUDA';

    // 			}else if(walletMoneyFuture == 0){

    // 				walletStatusFuture = 'SIN SALDO';

    // 			}else if(walletMoneyFuture > 0){

    // 				walletStatusFuture = 'A FAVOR';

    // 			}

    // 			$('input[name=waMoneyFuture]').val('');

    // 			$('input[name=waMoneyFuture]').val(walletMoneyFuture);

    // 			$('input[name=waStatusFuture]').val('');

    // 			$('input[name=waStatusFuture]').val(walletStatusFuture);

    // 		}

    // 	}else{

    // 		$('.btnSaveVoucherEntry').attr('disabled',true);

    // 	}

    // }
  </script>
@endsection
