@extends('modules.accountants')

@section('financialModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>MODULO DE FACTURACION</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de facturaciones -->
      @if(session('SuccessSaveFacturation'))
      <div class="alert alert-success">
        {{ session('SuccessSaveFacturation') }}
      </div>
      @endif
      @if(session('SecondarySaveFacturation'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveFacturation') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de facturaciones -->
      @if(session('PrimaryUpdateFacturation'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateFacturation') }}
      </div>
      @endif
      @if(session('SecondaryUpdateFacturation'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateFacturation') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de facturaciones -->
      @if(session('WarningDeleteFacturation'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteFacturation') }}
      </div>
      @endif
      @if(session('SecondaryDeleteFacturation'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteFacturation') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  @if(isset($all) && $all != null)
  <div class="row p-3">
    <div class="col-md-4 p-2 border-right">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-key"></i>
          </span>
        </div>
        <input type="text" class="form-control form-control-sm text-center" value="{{ $all['codeFacture'] }}" name="codeFacture" style="font-weight: bold;" disabled required>
        <input type="hidden" name="legalization" class="form-control form-control-sm" value="{{ $all['legalization'] }}" disabled>
      </div>
      <hr>
      <small class="text-muted">FECHA DE EMISION:</small><br>
      <h6 class="dateInitialFacture-view">{{ $all['dateFacture'] }}</h6>
      <span hidden class="dateInitialFacture-hidden">{{ $all['dateFacture'] }}</span><br>
      <small class="text-muted">FECHA DE VENCIMIENTO:</small><br>
      <div class="form-group">
        <select name="dateFinalFacture" class="form-control form-control-sm select2">
          <option value="" selected>INMEDIATA</option>
          <option value="1">UN (1) DIA</option>
          <option value="2">DOS (2) DIAS</option>
          <option value="3">TRES (3) DIAS</option>
          <option value="4">CUATRO (4) DIAS</option>
          <option value="5">CINCO (5) DIAS</option>
          <option value="6">SEIS (6) DIAS</option>
          <option value="7">SIETE (7) DIAS</option>
          <option value="8">OCHO (8) DIAS</option>
          <option value="9">NUEVE (9) DIAS</option>
          <option value="30">TREINTA (30) DIAS</option>
        </select>
      </div>
      <hr>
      <small class="text-muted">ALUMNO:</small><br>
      <h6>{{ $all['nameStudent'] }}</h6>
      <h6>{{ $all['typeStudent'] . ': ' . $all['numberStudent'] }}</h6>
      <hr>

      <small class="text-muted">ACUDIENTE 1:</small><br>
      @if(isset($all['nameFather']) && isset($all['typeFather']) && isset($all['numberFather']))
      <h6>{{ $all['nameFather'] }}</h6>
      <h6>{{ $all['typeFather'] . ': ' . $all['numberFather'] }}</h6>
      @else
      <h6>{{ __('SIN REGISTRO') }}</h6>
      @endif
      <hr>
      <small class="text-muted">ACUDIENTE 2:</small><br>
      @if(isset($all['nameMother']) && isset($all['typeMother']) && isset($all['numberMother']))
      <h6>{{ $all['nameMother'] }}</h6>
      <h6>{{ $all['typeMother'] . ': ' . $all['numberMother'] }}</h6>
      @else
      <h6>{{ __('SIN REGISTRO') }}</h6>
      @endif
      <span hidden class="concepts">{{ $all['concepts'] }}</span>
    </div>
    <div class="col-md-8 p-2 border-left">
      <div class="row">
        <div class="col-md-12 text-center">
          <h6>CONCEPTOS A FACTURAR</h6>
        </div>
      </div>
      <table class="table text-center" width="100%">
        <thead>
          <tr>
            <th>ITEM</th>
            <th>FECHA DE COMPROMISO</th>
            <th>CONCEPTO</th>
            <th>VALOR</th>
          </tr>
        </thead>
        <tbody>
          @php $row = 1; @endphp
          @for($i = 1; $i <= $all['totalConcept'];$i++) <tr>
            <td>{{ $row }}</td>
            <td>{{ $all['conDate' . $i] }}</td>
            <td>{{ $all['conConcept' . $i] }}</td>
            <td>{{ number_format($all['conValue' . $i],0,',','.') }}</td>
            </tr>
            @php $row++ @endphp
            @endfor
        </tbody>
      </table>
    </div>
  </div>
  <div class="row p-2 border-top border-right border-bottom border-left text-center">
    <div class="col-md-3">
      <small class="text-muted">SUBTOTAL:</small><br>
      <span hidden aria-hidden="true" class="form-control form-control-sm badge badge-success subtotalFacture" style="color: #fff; font-weight: bold; font-size: 20px;">{{ $all['totalFacture'] }}</span>
      <span class="form-control form-control-sm badge badge-success" style="color: #fff; font-weight: bold; font-size: 20px;">{{ number_format($all['totalFacture'],0,',','.') }}</span>
      <!-- <div class="form-group">
						<small class="text-muted">TOTAL:</small>
						<div class="input-group">
							<div class="input-group-prepend">
							    <span class="input-group-text">
							    	<i class="fas fa-dollar-sign"></i>
							    </span>
							</div>
							<input type="number" name="facSubtotalFacture" class="form-control form-control-sm text-center" value="{{ $all['totalFacture'] }}" disabled>
						</div>
					</div> -->
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <small class="text-muted">VALOR DESCUENTO:</small>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-dollar-sign"></i>
            </span>
          </div>
          <input type="text" maxlength="8" name="facValuediscount" pattern="[0-9]{1,8}" title="Máximo 8 carácteres numéricos" class="form-control form-control-sm text-center" value="0">
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <small class="text-muted">% DEL IVA PARA CADA ITEM:</small>
        <div class="input-group">
          <input type="text" maxlength="2" name="facPorcentageIva" pattern="[0-9]{1,2}" title="Máximo 2 carácteres numéricos" class="form-control form-control-sm text-center" value="0">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-percentage"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <small class="text-muted">TOTAL:</small>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fas fa-dollar-sign"></i>
            </span>
          </div>
          <input type="text" name="facValueIva" class="form-control form-control-sm text-center" value="{{ $all['totalFacture'] }}" disabled>
        </div>
      </div>
    </div>
  </div>
  <div class="row  p-2 border-top border-right border-bottom border-left text-center">
    <div class="col-md-12">
      <button type="button" class="btn btn-outline-success btn-getModal mt-3">GENERAR FACTURA</button>
    </div>
  </div>

  <!-- MODAL DE DETALLES -->
  <div class="modal fade" id="modal-confirm">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <div class="modal-header">
          <h5 class="text-muted modal-title">CONFIRMACION: </h5>
        </div>
        <div class="modal-body p-2">
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted">SE GUARDARÁ EL REGISTRO DE FACTURA Y SE GENERARÁ UN ARCHIVO PDF EL CUAL PUEDE DESCARGAR DESDE GESTION DE CARTERA, ¿DESEA CONTINUAR?</h6>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-md-12">
              <button type="button" class="btn btn-outline-success btn-saveFacture">CONTINUAR</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="row text-center p-4">
    <div class="col-md-12">
      <h6 class="text-muted">PARA ACCEDER A ESTE MODULO DEBE SELECCIONAR UN ESTADO DE CUENTA EN EL MODULO <b>FINANCIERO</b>, DANDO CLIC EN EL BOTON DE <b>FACTURAR</b></h6>
    </div>
  </div>
  @endif
</div>
@endsection

@section('scripts')
<script>
  var idAutorization = 0;
  $(function() {
    $('.dateInitialFacture-view').text(converterDate($('.dateInitialFacture-hidden').text()));
    $('.message').css('display', 'none');
    // $('.spinner-border').css('display','none');
  });

  $('.btn-getModal').on('click', function() {
    $('#modal-confirm').modal();
  });
  $('.btn-saveFacture').on('click', function() {
    var legalization = $('input[name=legalization]').val();
    var code = $('input[name=codeFacture]').val();
    var dateInitial = $('span.dateInitialFacture-hidden').text();
    var countDays = $('select[name=dateFinalFacture]').val();
    var concepts = $('span.concepts').text();
    var subtotal = $('span.subtotalFacture').text();
    var valueDiscount = $('input[name=facValuediscount').val();
    var porcentage = $('input[name=facPorcentageIva').val();
    var totalWithIva = $('input[name=facValueIva').val();
    if (porcentage != '' && totalWithIva != '') {
      $.ajax({
        url: "{{ route('facturation.new') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          facLegalization_id: legalization,
          facCode: code,
          facDateInitial: dateInitial,
          facDateFinal: countDays,
          facConcepts: concepts,
          facSubtotal: totalWithIva,
          facValuediscount: valueDiscount,
          facPorcentageIva: porcentage,
          facValueIva: totalWithIva
        },
        beforeSend: function() {
          $('.btn-saveFacture').html("<div class='spinner-border' align='center' role='status'>" +
            "<span class='sr-only' align='center'>Procesando...</span></div>");
        },
        success: function(response) {
          var find = response.success;
          if (find >= "") {
            $('.btn-saveFacture').html("CONTINUAR");
            $('.btn-getModal').attr('disabled', true);
            $('.btn-getModal').html("<i class='fas fa-ban'></i> GENERAR FACTURA <i class='fas fa-ban'></i>");
            $('.message').html("<p style='font-size: 12px;'>" + response.success + "</p>");
            $('.message').addClass('alert-success');
            $('.message').removeClass('alert-warning');
            $('.message').css('display', 'block');
            $('#modal-confirm').modal('hide');
            $('html, body').animate({
              scrollTop: 0
            }, 'slow');
          } else {
            $('.btn-saveFacture').html("CONTINUAR");
            $('.btn-getModal').attr('disabled', false);
            $('.btn-getModal').html("GENERAR FACTURA");
            $('.message').html("<p style='font-size: 12px;'>" + response.success + "</p>");
            $('.message').addClass('alert-warning');
            $('.message').removeClass('alert-success');
            $('.message').css('display', 'block');
            $('#modal-confirm').modal('hide');
            $('html, body').animate({
              scrollTop: 0
            }, 'slow');
          }
        }
      });
    } else {
      $('.message').html("<p style='font-size: 12px;'>% DEL IVA o VALOR TOTAL CON IVA no pueden estar vacios</p>");
      $('.message').addClass('alert-warning');
      $('.message').removeClass('alert-success');
      $('.message').css('display', 'block');
      $('#modal-confirm').modal('hide');
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');

      setTimeout(function() {
        $('.message').removeClass('alert-warning');
        $('.message').removeClass('alert-success');
        $('.message').css('display', 'none');
        $('.message').html("");
      }, 5000);
    }
  });

  $("#modal-confirm").on('hidden.bs.modal', function() {
    // code...
  });

  $('input[name=facPorcentageIva]').on('keyup', function(e) {
    var iva = e.target.value;
    if (iva == '') {
      iva = 0;
    }
    var totalWithoutIva = parseInt($('.subtotalFacture').text());
    var discount = parseInt($('input[name=facValuediscount]').val());
    if (iva > 0) {
      if (discount > 0) {
        var totalWithDiscount = totalWithoutIva - discount;
        var totalIva = ((iva * totalWithDiscount) / 100);
        var total = totalWithDiscount + totalIva;
        if (total < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(total);
        }
      } else {
        var totalIva = ((iva * totalWithoutIva) / 100);
        var total = totalWithoutIva + totalIva;
        if (total < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(total);
        }
      }
    } else {
      if (discount > 0) {
        var total = totalWithoutIva - discount;
        if (total < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(total);
        }
      } else {
        $('input[name=facValueIva]').val(totalWithoutIva);
      }
    }
    // CAMBIO DESPUES DE MANTENIMIENTO #2 (AGREGAR CAMPO DE DESCUENTO)
    // var total = 0;
    // $('.table tbody tr').each(function(){
    // 	var value = $(this).find('td:last').text();
    // 	var resultIva = ((iva * value)/100) + parseInt(value);
    // 	total += resultIva
    // });
    // $('input[name=facValueIva]').val(total);
  });

  $('input[name=facValuediscount]').on('keyup', function(e) {
    var discount = e.target.value;
    if (discount == '') {
      discount = 0;
    }
    if (discount > 0) {
      var totalWithoutIva = $('.subtotalFacture').text();
      var totalWithDiscount = totalWithoutIva - discount;
      var iva = parseInt($('input[name=facPorcentageIva]').val());
      if (iva > 0) {
        var porcentageIva = ((iva * totalWithDiscount) / 100);
        var total = totalWithDiscount + porcentageIva;
        if (total < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(total);
        }
      } else {
        if (totalWithDiscount < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(totalWithDiscount);
        }
      }
    } else {
      var totalWithoutIva = $('.subtotalFacture').text();
      var iva = parseInt($('input[name=facPorcentageIva]').val());
      if (iva > 0) {
        var porcentageIva = ((iva * totalWithoutIva) / 100);
        var total = totalWithoutIva + porcentageIva;
        if (total < 0) {
          $('input[name=facValueIva]').val(0);
        } else {
          $('input[name=facValueIva]').val(total);
        }
      } else {
        $('input[name=facValueIva]').val(totalWithoutIva);
      }
    }
  });

  // $('select[name=facStudent]').on('change',function(e){
  // 	e.preventDefault();
  // 	resetAll();
  // 	var studentSelected = e.target.value;
  // 	if(studentSelected != ''){
  // 		$('.items-facturation').css('display','none');
  // 		$('.textarea[name=addDescription]').val('');
  // 		$('.spinner-border').css('display','flex');
  // 		$.get("{{ route('getDatesFacturation') }}",{studentSelected: studentSelected},function(objectDates){
  // 			if(objectDates != null && objectDates != ''){
  // 				$('.nameAttendant').text('');
  // 				$('.nameAttendant').text(objectDates['nameAttendant']);
  // 				$('.idAttendant').text('');
  // 				$('.idAttendant').text(objectDates['idAttendant']);
  // 				$('.nameGrade').text('');
  // 				$('.nameGrade').text(objectDates['nameGrade']);
  // 				$('.idGrade').text('');
  // 				$('.idGrade').text(objectDates['idGrade']);
  // 				$('.nameCourse').text('');
  // 				$('.nameCourse').text(objectDates['nameCourse']);
  // 				$('.idCourse').text('');
  // 				$('.idCourse').text(objectDates['idCourse']);
  // 				$('.numberLegalization').text('');
  // 				$('.numberLegalization').text(objectDates['legId']);

  // 				var idAttendant = objectDates['idAttendant'];
  // 				var idCourse = objectDates['idCourse'];
  // 				$('.items-facturation').css('display','none');
  // 				$('.spinner-border').css('display','none');
  // 				$.get(
  // 					"{{ route('getDatesAutorization') }}",
  // 					{
  // 						idStudent: studentSelected,
  // 						idAttendant: idAttendant,
  // 						idCourse: idCourse,
  // 					},
  // 					function(objectAutorization){
  // 					if(objectAutorization != null && objectAutorization != ''){
  // 						var count = Object.keys(objectAutorization).length;
  // 						$('select[name=facDatesAutorizations]').empty();
  // 						$('select[name=facDatesAutorizations]').append("<option value=''>Seleccione una fecha...</option>");
  // 						for (var i = 0; i < count; i++) {
  // 							var date = converterDate(objectAutorization[i]['auDate']);
  // 							$('select[name=facDatesAutorizations]').append('<option value=' + objectAutorization[i]['auId'] + '>' + date + '</option>');
  // 						}
  // 					}
  // 				});
  // 			}
  // 		});
  // 	}else{
  // 		resetAll();
  // 	}
  // });

  // $('select[name=facDatesAutorizations]').on('change',function(e){
  // 	e.preventDefault();
  // 	var selectedAutorized = e.target.value;
  // 	if(selectedAutorized != ''){
  // 		$.ajax({
  // 			url: "{{ route('getAutorized') }}",
  // 			data: { idAutorized: selectedAutorized },
  // 			beforeSend: function(){
  // 				resetItem();
  // 			},
  // 			success: function(objectAutorized){
  // 				if(objectAutorized != ''){
  // 					var count = Object.keys(objectAutorized).length;
  // 					//console.log(objectAutorized);
  // 					var total = 0;
  // 					var subtotal = 0;
  // 					for (var i = 0; i < count; i++) {
  // 						if(i == (count-1)){
  // 							$('textarea[name=addDescription]').val('');
  // 							$('textarea[name=addDescription]').val(objectAutorized[i][2]);
  // 							idAutorization = parseInt(objectAutorized[i][0]);
  // 							//objectAutorized[i][0] ==> ID DE AUTORIZACION
  // 							//objectAutorized[i][1] ==> FECHA DE AUTORIZACION
  // 							//objectAutorized[i][2] ==> DESCRIPCION DE AUTORIZACION
  // 							//objectAutorized[i][3] ==> AUTORIZACIONES GENERALES
  // 						}else{
  // 							switch(objectAutorized[i][0]){
  // 								case 'JORNADA':
  // 									// $('.row-journey').css('display','table-inline');
  // 									$('.nameJourney').text('');
  // 									$('.nameJourney').text('JORNADA');
  // 									$('.idJourney-fac').text('');
  // 									$('.idJourney-fac').text(objectAutorized[i][1]);
  // 									$('.jouJourney-fac').text('');
  // 									$('.jouJourney-fac').text(objectAutorized[i][2]);
  // 									$('.jouDays-fac').text('');
  // 									$('.jouDays-fac').text(objectAutorized[i][3]);
  // 									$('.jouHourEntry-fac').text('');
  // 									$('.jouHourEntry-fac').text(objectAutorized[i][4]);
  // 									$('.jouHourExit-fac').text('');
  // 									$('.jouHourExit-fac').text(objectAutorized[i][5]);
  // 									$('.jouValue-fac').text('');
  // 									$('.jouValue-fac').text(objectAutorized[i][6]);
  // 									subtotal += parseInt(objectAutorized[i][6]);
  // 									var price = (parseInt(objectAutorized[i][6]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][6])  + price);
  // 								break;
  // 								case 'ALIMENTACION':
  // 									// $('.row-feeding').css('display','table-inline');
  // 									$('.nameFeeding').text('');
  // 									$('.nameFeeding').text('ALIMENTACION');
  // 									$('.idFeeding-fac').text('');
  // 									$('.idFeeding-fac').text(objectAutorized[i][1]);
  // 									$('.feeConcept-fac').text('');
  // 									$('.feeConcept-fac').text(objectAutorized[i][2]);
  // 									$('.feeValue-fac').text('');
  // 									$('.feeValue-fac').text(objectAutorized[i][3]);
  // 									subtotal += parseInt(objectAutorized[i][3]);
  // 									var price = (parseInt(objectAutorized[i][3]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][3])  + price);
  // 								break;
  // 								case 'UNIFORME':
  // 									// $('.row-uniform').css('display','table-inline');
  // 									$('.nameUniform').text('');
  // 									$('.nameUniform').text('UNIFORME');
  // 									$('.idUniform-fac').text('');
  // 									$('.idUniform-fac').text(objectAutorized[i][1]);
  // 									$('.uniConcept-fac').text('');
  // 									$('.uniConcept-fac').text(objectAutorized[i][2]);
  // 									$('.uniValue-fac').text('');
  // 									$('.uniValue-fac').text(objectAutorized[i][3]);
  // 									subtotal += parseInt(objectAutorized[i][3]);
  // 									var price = (parseInt(objectAutorized[i][3]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][3])  + price);
  // 								break;
  // 								case 'MATERIAL':
  // 									// $('.row-supplie').css('display','table-inline');
  // 									$('.nameSupplie').text('');
  // 									$('.nameSupplie').text('MATERIAL ESCOLAR');
  // 									$('.idSupplie-fac').text('');
  // 									$('.idSupplie-fac').text(objectAutorized[i][1]);
  // 									$('.supConcept-fac').text('');
  // 									$('.supConcept-fac').text(objectAutorized[i][2]);
  // 									$('.supValue-fac').text('');
  // 									$('.supValue-fac').text(objectAutorized[i][3]);
  // 									subtotal += parseInt(objectAutorized[i][3]);
  // 									var price = (parseInt(objectAutorized[i][3]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][3])  + price);
  // 								break;
  // 								case 'TIEMPO EXTRA':
  // 									// $('.row-extratime').css('display','table-inline');
  // 									$('.nameExtratime').text('');
  // 									$('.nameExtratime').text('TIEMPO EXTRA');
  // 									$('.idExtratime-fac').text('');
  // 									$('.idExtratime-fac').text(objectAutorized[i][1]);
  // 									$('.extTConcept-fac').text('');
  // 									$('.extTConcept-fac').text(objectAutorized[i][2]);
  // 									$('.extTValue-fac').text('');
  // 									$('.extTValue-fac').text(objectAutorized[i][3]);
  // 									subtotal += parseInt(objectAutorized[i][3]);
  // 									var price = (parseInt(objectAutorized[i][3]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][3])  + price);
  // 								break;
  // 								case 'EXTRACURRICULAR':
  // 									// $('.row-extracurricular').css('display','table-inline');
  // 									$('.nameExtracurricular').text('');
  // 									$('.nameExtracurricular').text('EXTRACURRICULAR');
  // 									$('.idExtracurricular-fac').text('');
  // 									$('.idExtracurricular-fac').text(objectAutorized[i][1]);
  // 									$('.extConcept-fac').text('');
  // 									$('.extConcept-fac').text(objectAutorized[i][2]);
  // 									$('.extIntensity-fac').text('');
  // 									$('.extIntensity-fac').text(objectAutorized[i][3]);
  // 									$('.extValue-fac').text('');
  // 									$('.extValue-fac').text(objectAutorized[i][4]);
  // 									subtotal += parseInt(objectAutorized[i][4]);
  // 									var price = (parseInt(objectAutorized[i][4]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][4])  + price);
  // 								break;
  // 								case 'TRANSPORTE':
  // 									// $('.row-transport').css('display','table-inline');
  // 									$('.nameTransport').text('');
  // 									$('.nameTransport').text('TRANSPORTE');
  // 									$('.idTransport-fac').text('');
  // 									$('.idTransport-fac').text(objectAutorized[i][1]);
  // 									$('.traConcept-fac').text('');
  // 									$('.traConcept-fac').text(objectAutorized[i][2]);
  // 									$('.traValue-fac').text('');
  // 									$('.traValue-fac').text(objectAutorized[i][3]);
  // 									subtotal += parseInt(objectAutorized[i][3]);
  // 									var price = (parseInt(objectAutorized[i][3]) * 19)/100;
  // 									total += (parseInt(objectAutorized[i][3])  + price);
  // 								break;
  // 							}//switch
  // 						}//if count
  // 					}//for
  // 				}//id objectAutorized
  // 				$('.subtotalFacturation').text('');
  // 				$('.subtotalFacturation').text(subtotal);
  // 				$('.totalFacturation').text('');
  // 				$('.totalFacturation').text(total);
  // 			},//success
  // 			complete: function(){
  // 				$('tbody tr').each(function(){
  // 					var myself = $(this);
  // 					var title = $(this).find('td:first').text();
  // 					if(title == ''){
  // 						myself.css('display','none');
  // 						myself.hide();
  // 					}else{
  // 						myself.show();
  // 						myself.css('display','table-inline');
  // 					}
  // 				});
  // 				$('.items-facturation').css('display','flex');
  // 				$('.spinner-border').css('display','none');
  // 				//var validate = false;
  // 				//while(validate == false){
  // 					var code = randomCode();
  // 					$.get("{{ route('validateCodeFacturation') }}",{code: code},function(response){
  // 						if(!response){
  // 							$('input[name=facNumber]').val('');
  // 							$('input[name=facNumber]').val(randomCode());
  // 						}else{
  // 							$('input[name=facNumber]').val('');
  // 							$('input[name=facNumber]').val(response);
  // 						}
  // 					});
  // 					var numberLegalization = $('.numberLegalization').text();
  // 					$.get("{{ route('getInformationPaid') }}",{numberLegalization: numberLegalization},function(objectPaid){
  // 						if(Object.keys(objectPaid).length > 0){
  // 							$('.infoBank').css('visibility','hidden');
  // 							$('input[name=payId]').val('');
  // 							$('input[name=payId]').val(objectPaid['payId']);
  // 							$('input[name=payTítular]').val('');
  // 							$('input[name=payTítular]').val(objectPaid['payTitular']);
  // 							$('input[name=payDocumentTitular]').val('');
  // 							$('input[name=payDocumentTitular]').val(objectPaid['payDocumentTitular']);
  // 							$('input[name=payBank]').val('');
  // 							$('input[name=payBank]').val(objectPaid['payBank']);
  // 							$('input[name=payTypeAccount]').val('');
  // 							$('input[name=payTypeAccount]').val(objectPaid['payType']);
  // 							if(objectPaid['payType'] == 'RECAUDO'){
  // 								$('input[name=payAgreement]').attr('disabled',false);
  // 							}
  // 							$('input[name=payAgreement]').val('');
  // 							$('input[name=payAgreement]').val(objectPaid['payAgreement']);
  // 							$('input[name=payNumberAccount]').val('');
  // 							$('input[name=payNumberAccount]').val(objectPaid['payAccount']);
  // 						}else{
  // 							$('.infoBank').css('visibility','visible');
  // 							$('input[name=payId]').val('');
  // 							$('input[name=payId]').val('N/A');
  // 							$('input[name=payTítular]').val('');
  // 							$('input[name=payDocumentTitular]').val('');
  // 							$('input[name=payBank]').val('');
  // 							$('input[name=payTypeAccount]').val('');
  // 							$('input[name=payAgreement]').val('');
  // 							$('input[name=payNumberAccount]').val('');
  // 						}
  // 					});
  // 				//}						
  // 			}
  // 		});
  // 	}else{

  // 	}
  // });

  // //VALIDAR CAMBIOS EN INPUT DEL TIPO DE CUENTA
  // $('input[name=payTypeAccount]').on('keyup',function(e){
  // 	var value = e.target.value;
  // 	if(value == 'RECAUDO'){
  // 		$('input[name=payAgreement]').attr('disabled',false);
  // 	}else{
  // 		$('input[name=payAgreement]').attr('disabled',true);
  // 	}
  // });

  // $('.btnSaveFacturation').on('click',function(e){
  // 	e.preventDefault();
  // 	var facCode = $('input[name=facNumber]').val();
  // 	if(facCode == false){
  // 		facCode = randomCode();
  // 	}
  // 	var facRegime = $('textarea[name=facRegime]').val();
  // 	var facEconomicActivity = $('input[name=facEconomicActivity]').val();
  // 	var facDian = $('textarea[name=facDian]').val();
  // 	var facDateInitial = $('input[name=facDateInitial]').val();
  // 	var facDateFinal = $('input[name=facDateFinal]').val();

  // 	var infoPayId = $('input[name=payId]').val();
  // 	var infoPayTitular = $('input[name=payTítular]').val();
  // 	var infoPayDocumentTitular = $('input[name=payDocumentTitular]').val();
  // 	var infoPayBank = $('input[name=payBank]').val();
  // 	var infoPayTypeAccount = $('input[name=payTypeAccount]').val();
  // 	var infoPayAgreement = $('input[name=payAgreement]').val();
  // 	var infoPayNumberAccount = $('input[name=payNumberAccount]').val();
  // 	//ITEMS
  // 	var items = '';
  // 	$('tbody tr').each(function(){
  // 		if($(this).is(':visible')){
  // 			if($(this).find('td:nth-child(1)').text() == 'JORNADA'){
  // 				items +=  $(this).find('td:nth-child(1)').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.jouJourney-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.jouDays-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.jouHourEntry-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.jouHourExit-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(3)').find('h5').text() + ',';
  // 			}else if($(this).find('td:nth-child(1)').text() == 'EXTRACURRICULAR'){
  // 				items +=  $(this).find('td:nth-child(1)').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.extConcept-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span.extIntensity-fac').text() + '/';
  // 				items +=  $(this).find('td:nth-child(3)').find('h5').text() + ',';
  // 			}else{
  // 				items +=  $(this).find('td:nth-child(1)').text() + '/';
  // 				items +=  $(this).find('td:nth-child(2)').find('span:nth-child(2)').text() + '/';
  // 				items +=  $(this).find('td:nth-child(3)').find('h5').text() + ',';
  // 			}
  // 		}
  // 	});

  // 	//console.log(items); //TODO LO AUTORIZADO DENTRO DE UNA CADENA DE TEXTO

  // 	var idAutorized = idAutorization;
  // 	var idLegalization = $('.numberLegalization').text();
  // 	var facTotal = $('.totalFacturation').text();
  // 	if(
  // 		facCode != '' &&
  // 		facRegime != '' &&
  // 		facEconomicActivity != '' &&
  // 		facDian != '' &&

  // 		infoPayTitular != '' &&
  // 		infoPayDocumentTitular != '' &&
  // 		infoPayBank != '' &&
  // 		infoPayTypeAccount != '' &&
  // 		infoPayNumberAccount != '' &&

  // 		facDateInitial != '' &&
  // 		facDateFinal != '' &&
  // 		items != '' &&
  // 		idAutorized != '' &&
  // 		idLegalization != '' &&
  // 		facTotal != ''
  // 	){
  // 		$.ajax({
  // 			url: "{{ route('facturation.new') }}",
  // 			type: 'GET',
  // 			data: {
  // 				"_token": "{{ csrf_token() }}",
  // 				facCode: facCode,
  // 				facRegime: facRegime,
  // 				facEconomicActivity: facEconomicActivity,
  // 				facDian: facDian,
  // 				infoPayId: infoPayId,
  // 				infoPayTitular: infoPayTitular,
  // 				infoPayDocumentTitular: infoPayDocumentTitular,
  // 				infoPayBank: infoPayBank,
  // 				infoPayTypeAccount: infoPayTypeAccount,
  // 				infoPayAgreement: infoPayAgreement,
  // 				infoPayNumberAccount: infoPayNumberAccount,
  // 				facDateInitial: facDateInitial,
  // 				facDateFinal: facDateFinal,
  // 				facAutorized: items,
  // 				facValue: facTotal,
  // 				facLegalization_id: idLegalization,
  // 				facAutorization_id: idAutorization
  // 			},
  // 			success: function(response){
  // 				$('.message').css('display','block');
  // 				$('.message').addClass('alert-success');
  // 				$('.message').removeClass('alert-warning');
  // 				$('.message').html(response);
  // 				setTimeout(function(){
  // 					$('.message').css('display','none');
  // 					$('.message').removeClass('alert-success');
  // 					$('.message').removeClass('alert-warning');
  // 					$('.message').html('');
  // 				}, 20000);
  // 			},
  // 			complete: function(){
  // 				resetAll();
  // 				$('select[name=facStudent]').val('');
  // 			}
  // 		});
  // 	}
  // });

  function converterDate(value) {
    var separated = value.split('-');

    switch (separated[1]) {
      case '01':
        separated[1] = 'ENERO';
        break;
      case '02':
        separated[1] = 'FEBRERO';
        break;
      case '03':
        separated[1] = 'MARZO';
        break;
      case '04':
        separated[1] = 'ABRIL';
        break;
      case '05':
        separated[1] = 'MAYO';
        break;
      case '06':
        separated[1] = 'JUNIO';
        break;
      case '07':
        separated[1] = 'JULIO';
        break;
      case '08':
        separated[1] = 'AGOSTO';
        break;
      case '09':
        separated[1] = 'SEPTIEMBRE';
        break;
      case '10':
        separated[1] = 'OCTUBRE';
        break;
      case '11':
        separated[1] = 'NOVIEMBRE';
        break;
      case '12':
        separated[1] = 'DICIEMBRE';
        break;
    }
    return separated[2] + ' DE ' + separated[1] + ' DEL ' + separated[0];
  }

  // function resetItem(){
  // 	//ITEMS
  // 	$('.row-journey').css('display','table-inline');
  // 	$('.nameJourney').text('');
  // 	$('.idJourney-fac').text('');
  // 	$('.jouJourney-fac').text('');
  // 	$('.jouDays-fac').text('');
  // 	$('.jouHourEntry-fac').text('');
  // 	$('.jouHourExit-fac').text('');
  // 	$('.jouValue-fac').text('');
  // 	//
  // 	$('.row-feeding').css('display','table-inline');
  // 	$('.nameFeeding').text('');
  // 	$('.idFeeding-fac').text('');
  // 	$('.feeConcept-fac').text('');
  // 	$('.feeValue-fac').text('');
  // 	//
  // 	$('.row-uniform').css('display','table-inline');
  // 	$('.nameUniform').text('');
  // 	$('.idUniform-fac').text('');
  // 	$('.uniConcept-fac').text('');
  // 	$('.uniValue-fac').text('');
  // 	//
  // 	$('.row-supplie').css('display','table-inline');
  // 	$('.nameSupplie').text('');
  // 	$('.idSupplie-fac').text('');
  // 	$('.supConcept-fac').text('');
  // 	$('.supValue-fac').text('');
  // 	//
  // 	$('.row-extratime').css('display','table-inline');
  // 	$('.nameExtratime').text('');
  // 	$('.idExtratime-fac').text('');
  // 	$('.extTConcept-fac').text('');
  // 	$('.extTValue-fac').text('');
  // 	//
  // 	$('.row-extracurricular').css('display','table-inline');
  // 	$('.nameExtracurricular').text('');
  // 	$('.idExtracurricular-fac').text('');
  // 	$('.extConcept-fac').text('');
  // 	$('.extIntensity-fac').text('');
  // 	$('.extValue-fac').text('');
  // 	//
  // 	$('.row-transport').css('display','table-inline');
  // 	$('.nameTransport').text('');
  // 	$('.idTransport-fac').text('');
  // 	$('.traConcept-fac').text('');
  // 	$('.traValue-fac').text('');
  // 	//
  // 	idAutorization = 0;
  // 	$('.items-facturation').css('display','none');
  // 	$('.spinner-border').css('display','flex');
  // 	$('.totalFacturation').text('');
  // }

  // function resetAll(){
  // 	$('.nameAttendant').text('');
  // 	$('.idAttendant').text('');
  // 	$('.nameGrade').text('');
  // 	$('.idGrade').text('');
  // 	$('.nameCourse').text('');
  // 	$('.idCourse').text('');
  // 	$('.numberLegalization').text('');

  // 	//AUTORIZATION
  // 	$('select[name=facDatesAutorizations]').empty();
  // 	$('select[name=facDatesAutorizations]').append("<option value=''>Seleccione una fecha...</option>");
  // 	$('textarea[name=addDescription]').val('');
  // 	//ITEMS
  // 	$('.row-journey').css('display','table-inline');
  // 	$('.idJourney-fac').text('');
  // 	$('.jouJourney-fac').text('');
  // 	$('.jouDays-fac').text('');
  // 	$('.jouHourEntry-fac').text('');
  // 	$('.jouHourExit-fac').text('');
  // 	$('.jouValue-fac').text('');
  // 	//
  // 	$('.row-feeding').css('display','table-inline');
  // 	$('.idFeeding-fac').text('');
  // 	$('.feeConcept-fac').text('');
  // 	$('.feeValue-fac').text('');
  // 	//
  // 	$('.row-uniform').css('display','table-inline');
  // 	$('.idUniform-fac').text('');
  // 	$('.uniConcept-fac').text('');
  // 	$('.uniValue-fac').text('');
  // 	//
  // 	$('.row-supplie').css('display','table-inline');
  // 	$('.idSupplie-fac').text('');
  // 	$('.supConcept-fac').text('');
  // 	$('.supValue-fac').text('');
  // 	//
  // 	$('.row-extratime').css('display','table-inline');
  // 	$('.idExtratime-fac').text('');
  // 	$('.extTConcept-fac').text('');
  // 	$('.extTValue-fac').text('');
  // 	//
  // 	$('.row-extracurricular').css('display','table-inline');
  // 	$('.idExtracurricular-fac').text('');
  // 	$('.extConcept-fac').text('');
  // 	$('.extIntensity-fac').text('');
  // 	$('.extValue-fac').text('');
  // 	//
  // 	$('.row-transport').css('display','table-inline');
  // 	$('.idTransport-fac').text('');
  // 	$('.traConcept-fac').text('');
  // 	$('.traValue-fac').text('');
  // 	//
  // 	idAutorization = 0;
  // 	$('.items-facturation').css('display','none');
  // 	$('.spinner-border').css('display','none');
  // 	$('.totalFacturation').text('');
  // }

  // function randomCode(){
  // 	var chain = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  // 	var result = chain.substr(Math.floor(Math.random() * 26),1) + chain.substr(Math.floor(Math.random() * 26),1) + Math.floor(Math.random() * 9) + Math.floor(Math.random() * 9) + Math.floor(Math.random() * 9) + Math.floor(Math.random() * 9);
  // 	return result;
  // }
</script>
@endsection