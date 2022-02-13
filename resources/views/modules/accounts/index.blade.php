@extends('modules.accounts')

@section('financialModules')
<div class="col-md-12">
  <div class="row border p-2">
    <div class="col-md-6">
      <div class="form-group">
        <h6 class="text-muted">TOTAL MENSUAL DE VENTAS:</h6>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
          </div>
          <input type="text" pattern="[0-9.]" class="form-control form-control-sm text-center" name="infoPlusmount" style="font-weight: bold;" readonly>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <form action="{{ route('accounts.tramited') }}" method="GET">
        <div class="form-group">
          <small class="text-muted">FACTURACION TRAMITADA:</small><br>
          <input type="hidden" name="xlsYear" class="form-control form-control-sm" readonly required>
          <input type="hidden" name="xlsMount" class="form-control form-control-sm" readonly required>
          <button type="submit" class="btn btn-outline-success form-control-sm btn-facturesTramited">GENERAR EXCEL</button>
          <span hidden class="info-excel" style="color: red; font-size: 10px; font-weight: bold;"></span>
        </div>
      </form>
    </div>
  </div>
  <div class="row m-3 text-center">
    <div class="col-md-6">
      @php
      $yearnow = date('Y');
      $mountnow = date('m');
      $yearbeforeThree = date('Y') - 3;
      $yearbeforeTwo = date('Y') - 2;
      $yearbeforeOne = date('Y') - 1;
      $yearfutureOne = date('Y') + 1;
      $yearfutureTwo = date('Y') + 2;
      $yearfutureThree = date('Y') + 3;
      $yearfutureFour = date('Y') + 4;
      @endphp
      <div class="form-inline border p-1 m-0" style="background: #ccc;">
        <small class="text-muted" style="color: #000;">AÑO DE CONSULTA:</small>
        <select name="yearSelected" class="form-control form-control-sm ml-3">
          <option value="">Seleccione un año...</option>
          <option value="{{ $yearbeforeThree }}">{{ $yearbeforeThree }}</option>
          <option value="{{ $yearbeforeTwo }}">{{ $yearbeforeTwo }}</option>
          <option value="{{ $yearbeforeOne }}">{{ $yearbeforeOne }}</option>
          <option value="{{ $yearnow }}" selected>{{ $yearnow }}</option>
          <option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
          <option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
          <option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
          <option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
        </select>
      </div>
      <input type="hidden" name="mountSelected" value="{{ $mountnow }}" class="form-control form-control-sm" disabled>
    </div>
    <div class="col-md-6">
      <h4>ESTADOS DE CUENTA</h4>
    </div>
  </div>
  <div class="row text-center bj-spinner">
    <div class="col-md-12">
      <div class="spinner-border" align="center" role="status">
        <span class="sr-only" align="center">Procesando...</span>
      </div>
    </div>
  </div>
  <div class="row sectionTable" style="display: none;">
    <div class="col-md-12">
      <h6 class="table-title text-center"></h6>
      <table id="tableAccount" class="table text-center" width="100%">
        <thead>
          <tr>
            <th>ALUMNO</th>
            <th>GRADO</th>
            <th>ACUDIENTE/S</th>
            <th>DETALLES</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dinamics -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL DE DETALLES -->
<div class="modal fade" id="modal-details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="text-muted modal-title">DETALLES DE MATRICULA Y CONTRATO: </h5>
      </div>
      <div class="modal-body p-2">
        <div class="row">
          <div class="col-md-4 border-right">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="text" class="form-control form-control-sm text-center" name="idLegalization-modal" style="font-weight: bold;" disabled required>
              </div>
            </div>
            <div class="form-group" style="font-size: 12px;">
              <hr>
              <small style="font-size: 14px;" class="text-muted">ALUMNO:</small>
              <hr>
              <p class="nameStudent-modal"></p>
              <p class="nameGrade-modal"></p>
              <hr>
              <small style="font-size: 14px;" class="text-muted">ACUDIENTE/S:</small>
              <hr>
              <p class="nameFatherAttendant-modal"></p>
              <p class="nameMotherAttendant-modal"></p>
              <p class="mailAttendant-modal"></p>
              <p class="phoneAttendant-modal"></p>
              <hr>
              <small style="font-size: 14px;" class="text-muted">LEGALIZACION DE CONTRATO:</small>
              <hr>
              <small class="text-muted">Fecha de matricula:</small>
              <p class="legDateCreate-modal"></p>
              <small class="text-muted">Duracion:</small>
              <p class="legDateInitial-modal"></p> - <p class="legDateFinal-modal"></p>
            </div>
          </div>
          <div class="col-md-8 border-left text-center">
            <h6 class="border text-center p-4">ESTADO DE CUENTAS - FACTURACION</h6>
            <!-- <p class="rangeInitial" style="font-size: 14px;"></p> - <p class="rangeFinal" style="font-size: 14px;"></p> -->
            <table class="table table-hover text-center table-modal" width="100%" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>CONCEPTO</th>
                  <th>FECHA DE COMPROMISO</th>
                  <th>VALOR</th>
                  <th>PAGADO</th>
                </tr>
              </thead>
              <tbody>
                <!-- Dinamics -->
              </tbody>
            </table>
            <a href="#" class="btn btn-outline-success link-saveAccountsStatus" style="display: none;"><span hidden></span>FACTURAR</a>
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
    var year = $('select[name=yearSelected]').val();
    var mount = $('input[name=mountSelected]').val();
    getAccountsFilter(year, mount);
    $('.bj-spinner').css('display', 'none');
    $('.sectionTable').css('display', 'flex');
  });

  $('.accountMount').on('click', function(e) {
    e.preventDefault();
    $('.bj-spinner').css('display', 'flex');
    $('.sectionTable').css('display', 'none');
    var year = $('select[name=yearSelected]').val();
    var mount = (parseInt($(this).attr('id')) < 10 ? '0' + $(this).attr('id') : $(this).attr('id'));
    getAccountsFilter(year, mount);
    $("input[name=mountSelected]").val('');
    $("input[name=mountSelected]").val(mount);
    setTimeout(function() {
      $('.bj-spinner').css('display', 'none');
      $('.sectionTable').css('display', 'flex');
    }, 500);
  });

  $('select[name=yearSelected]').on('change', function(e) {
    $('.bj-spinner').css('display', 'flex');
    $('.sectionTable').css('display', 'none');
    var selectedYear = e.target.value;
    var mount = $('input[name=mountSelected]').val();
    getAccountsFilter(selectedYear, mount);
    setTimeout(function() {
      $('.bj-spinner').css('display', 'none');
      $('.sectionTable').css('display', 'flex');
    }, 500);
  });

  $('#tableAccount tbody').on('click', 'a.btn-details', function(e) {
    /** SE DEBE VALIDAR PORQUE NO CARGA LOS ITEM EN EL FORMULARIO DE FACTURACIÓN **/
    e.preventDefault();
    var yearandmount = $(this).parents('tr').find('td:first').find('span').text();
    var separated = yearandmount.split('-');
    var year = separated[0];
    var mount = separated[1];
    var legId = separated[2];
    $.get("{{ route('accounts.items') }}", {
      legId: legId,
      year: year,
      mount: mount
    }, function(objectConcepts) {
      var count = Object.keys(objectConcepts).length; //registros total de cuentas de enero
      $('.table-modal tbody').empty();
      if (count > 0) {
        for (var i = 0; i < count; i++) {
          if (i == 0 && objectConcepts[i][0] == 'DATOS') {
            $('input[name=idLegalization-modal]').val('');
            $('input[name=idLegalization-modal]').val(legId);
            $('.nameStudent-modal').text('');
            $('.nameStudent-modal').text(objectConcepts[i][1]);
            $('.nameGrade-modal').text('');
            $('.nameGrade-modal').text(objectConcepts[i][2]);
            $('.nameFatherAttendant-modal').text('');
            $('.nameFatherAttendant-modal').text(objectConcepts[i][3]);
            $('.nameMotherAttendant-modal').text('');
            $('.nameMotherAttendant-modal').text(objectConcepts[i][4]);
            $('.mailAttendant-modal').text('');
            $('.mailAttendant-modal').text(objectConcepts[i][5]);
            $('.phoneAttendant-modal').text('');
            $('.phoneAttendant-modal').text('TELs: ' + objectConcepts[i][6]);
            $('.legDateCreate-modal').text('');
            $('.legDateCreate-modal').text(objectConcepts[i][7]);
            $('.legDateInitial-modal').text('');
            $('.legDateInitial-modal').text(objectConcepts[i][8]);
            $('.legDateFinal-modal').text('');
            $('.legDateFinal-modal').text(objectConcepts[i][9]);
          } else if (objectConcepts[i][0] == 'CONCEPTO') {
            if (objectConcepts[i][5] == 'PENDIENTE') {
              console.log(new Intl.NumberFormat().format(objectConcepts[i][4]));
              $(".table-modal tbody").append("<tr id='" + objectConcepts[i][1] + "'>" +
                "<td>" + objectConcepts[i][2] + "</td>" +
                "<td>" + objectConcepts[i][3] + "</td>" +
                "<td>" + new Intl.NumberFormat().format(objectConcepts[i][4]) + "</td>" +
                "<td><input type='checkbox' name='item-concept' id='" + objectConcepts[i][1] + "'></td>" +
                "</tr>");
            } else {
              $(".table-modal tbody").append("<tr id='" + objectConcepts[i][1] + "'>" +
                "<td>" + objectConcepts[i][2] + "</td>" +
                "<td>" + objectConcepts[i][3] + "</td>" +
                "<td>" + new Intl.NumberFormat().format(objectConcepts[i][4]) + "</td>" +
                "<td><span class='badge badge-success'>FACTURADO</span></td>" +
                "</tr>");
            }
          }
        }
        $('#modal-details').modal();
      }
    });
  });

  $(".table-modal tbody").on('change', 'input[name=item-concept]', function(e) {
    var i = 0;
    var ids = '';
    $('.table-modal tbody tr').each(function() {
      var checked = $(this).find('td').find('input[name=item-concept]');
      if (checked.is(":checked")) {
        i++;
        ids += checked.attr('id') + ':';
      }
    });
    if (i > 0) {
      var newIds = ids.substr(0, (ids.length - 1));
      $('a.link-saveAccountsStatus').find('span').text(newIds);
      $('a.link-saveAccountsStatus').css('display', 'block');
    } else {
      $('a.link-saveAccountsStatus').find('span').text('');
      $('a.link-saveAccountsStatus').css('display', 'none');
    }
  });

  //EVENTO CLICK DEL BOTON GUARDAR LOS ITEMS SELECCIONADOS POR UN CHECKBOX
  $('.link-saveAccountsStatus').on('click', function(e) {
    e.preventDefault();
    var ids = $(this).find('span').text();
    var legId = $('input[name=idLegalization-modal]').val();
    $.ajax({
      url: "{{ route('accounts.factureTo') }}",
      type: 'POST',
      data: {
        "_token": "{{ csrf_token() }}",
        ids: ids,
        legId: legId
      },
      beforeSend: function() {
        $('.link-saveAccountsStatus').html("<div class='spinner-border' align='center' role='status'>" +
          "<span class='sr-only' align='center'>Procesando...</span></div>");
      },
      success: function(response) {
        console.log(response);
        var join = '';
        var countConcepts = 1;
        for (var i = 0; i < response.length; i++) {
          if (response[i][0] == 'ALUMNO') {
            join += 'nameStudent=' + response[i][1] + '&typeStudent=' + response[i][2] + '&numberStudent=' + response[i][3] + '&';
          }
          if (response[i][0] == 'PADRE') {
            join += 'nameFather=' + response[i][1] + '&typeFather=' + response[i][2] + '&numberFather=' + response[i][3] + '&';
          }
          if (response[i][0] == 'MADRE') {
            join += 'nameMother=' + response[i][1] + '&typeMother=' + response[i][2] + '&numberMother=' + response[i][3] + '&';
          }
          if (response[i][0] == 'CONCEPTO') {
            join += 'conDate' + countConcepts + '=' + response[i][1] + '&conConcept' + countConcepts + '=' + response[i][2] + '&conValue' + countConcepts + '=' + response[i][3] + '&';
            countConcepts++;
          }
          if (response[i][0] == 'FACTURA') {
            join += 'codeFacture=' + response[i][1] + '&dateFacture=' + response[i][2] + '&totalFacture=' + response[i][3] + '&legalization=' + response[i][4] + '&';
          }
          if (response[i][0] == 'TOTAL') {
            join += 'totalConcept=' + response[i][1] + '&concepts=' + response[i][2];
          }
        }
        if (join.length > 50) {
          const num = response.length - 1;
          if (response[num] === "Kindersoft Test") {
            window.location = `/testkindersoft/financial/accounttants/facturations?${join}`;
          } else if (response[num] === "Dream Home By Creatyvia") {
            window.location = `/dreamhome/financial/accounttants/facturations?${join}`;
          } else if (response[num] === "Colchildren Kindergarten") {
            window.location = `/colchildren/financial/accounttants/facturations?${join}`;
          }
        } else {
          $('.link-saveAccountsStatus').css('display', 'none');
          $('.link-saveAccountsStatus').html("<span hidden></span>FACTURAR");
          $('.link-saveAccountsStatus').parent('div').append("<p style='color: red; font-size: 10px; font-weight: bold;'>NO ES POSIBLE FACTURAR SIN NUMERACION, DIRIJASE A ==> FINANCIERO >> DOCUMENTOS CONTABLES >> Información general; y complete el formulario de numeración</p>");
        }
        // var ok = response.indexOf('OK');
        // if(ok >= 0){
        // 	$('.table-modal tbody tr').each(function(){
        // 		var id = $(this).attr('id');
        // 		var find = response.indexOf(id);
        // 		if(find >= 0){
        // 			$(this).find('td:last').empty();
        // 			$(this).find('td:last').append("<span class='badge badge-success'>FACTURADO</span>");
        // 		}
        // 	});
        // 	var totalInput = 0;
        // 	$('.table-modal tbody tr').each(function(){
        // 		var input = $(this).find('td:last').find('input[type=checkbox]').length;
        // 		if(input){
        // 			totalInput++;
        // 		}
        // 	});
        // 	$('.link-saveAccountsStatus').html("<span hidden></span><i class='fas fa-save'></i> GUARDAR");
        // 	if(totalInput <= 0){
        // 		$('.link-saveAccountsStatus').css("display","none");
        // 	}else{

        // 	}
        // }else{
        // 	$('.link-saveAccountsStatus').html("<span hidden></span><i class='fas fa-save'></i> ERROR!!");
        // 	setTimeout(function(){
        // 		$('.link-saveAccountsStatus').html("<span hidden></span><i class='fas fa-save'></i> GUARDAR");
        // 	},1000);
        // }
      }
    });
  });

  function getAccountsFilter(year, mount) {
    $('input[name=infoPlusmount]').val('');
    $.get("{{ route('accounts.get') }}", {
      year: year,
      mount: mount
    }, function(objectAccounts) {
      var count = Object.keys(objectAccounts).length; //registros total de cuentas de enero
      // $('#tableAccount tbody').empty();
      $('#tableAccount').DataTable().rows().remove().draw();
      if (count > 0) {
        var rows = '';
        for (var i = 0; i < count; i++) {
          var rownow = $('#tableAccount').DataTable().row;
          rownow.add(
            [
              "<span hidden>" + year + '-' + mount + '-' + objectAccounts[i][0] + "</span>" + objectAccounts[i][2],
              objectAccounts[i][3],
              objectAccounts[i][4],
              "<a href='#' class='btn btn-outline-success btn-details form-control-sm' title='DETALLES'><i class='fas fa-eye'></i></a>"
            ]).draw(false).node().id = objectAccounts[i][1];

          // rows += "<tr id='" + objectAccounts[i]['idStudent'] + "' class='" + objectAccounts[i]['legId'] + "'>" +
          // 	"<td><span hidden>" + year + '-' + mount + "</span>" + objectAccounts[i]['nameStudent'] + "</td>" +
          // 	"<td>" + objectAccounts[i]['nameGrade'] + "-" + objectAccounts[i]['nameCourse'] + "</td>" +
          // 	"<td>" + objectAccounts[i]['nameAttendant'] + "</td>" +
          // 	"<td><a href='#' class='btn btn-outline-success btn-details' title='DETALLES'><i class='fas fa-eye'></i></a></td>" +
          // 	"</tr>"; 
          // $("#tableAccount tbody").append("<tr id='" + objectAccounts[i]['idStudent'] + "' class='" + objectAccounts[i]['legId'] + "'>" +
          // 	"<td><span hidden>" + year + '-' + mount + "</span>" + objectAccounts[i]['nameStudent'] + "</td>" +
          // 	"<td>" + objectAccounts[i]['nameGrade'] + "-" + objectAccounts[i]['nameCourse'] + "</td>" +
          // 	"<td>" + objectAccounts[i]['nameAttendant'] + "</td>" +
          // 	"<td><a href='#' class='btn btn-outline-success btn-details' title='DETALLES'><i class='fas fa-eye'></i></a></td>" +
          // "</tr>");
        }
        // $('#tableAccount tbody').html(rows);
        // console.log(rows);
      }
      $('input[name=xlsYear]').val(year);
      $('input[name=xlsMount]').val(mount);
      tramitedCount(year, mount);
      $('.table-title').text('CUENTAS DE ' + converterMountToString(mount) + ' DEL ' + year);
    });
  }

  function tramitedCount(year, mount) {
    if (year != '' && mount != '') {
      $.ajax({
        url: "{{ route('accounts.tramited.count') }}",
        type: 'GET',
        data: {
          xlsYear: year,
          xlsMount: mount
        },
        success: function(response) {
          $('input[name=infoPlusmount]').val(new Intl.NumberFormat().format(response));
          if (response > 0) {
            $('.btn-facturesTramited').attr('disabled', false);
          } else {
            $('.btn-facturesTramited').attr('disabled', true);
          }
        }
      });
    }
  }

  function converterMountToString(value) {
    switch (value) {
      case '01':
        return 'ENERO';
        break;
      case '02':
        return 'FEBRERO';
        break;
      case '03':
        return 'MARZO';
        break;
      case '04':
        return 'ABRIL';
        break;
      case '05':
        return 'MAYO';
        break;
      case '06':
        return 'JUNIO';
        break;
      case '07':
        return 'JULIO';
        break;
      case '08':
        return 'AGOSTO';
        break;
      case '09':
        return 'SEPTIEMBRE';
        break;
      case '10':
        return 'OCTUBRE';
        break;
      case '11':
        return 'NOVIEMBRE';
        break;
      case '12':
        return 'DICIEMBRE';
        break;
    }
  }
</script>
@endsection