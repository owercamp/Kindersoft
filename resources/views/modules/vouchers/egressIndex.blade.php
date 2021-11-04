@extends('modules.accountants')

@section('financialModules')
<div class="col-md-12">
  <div class="col-md-12">
    <div class="row border-bottom mb-3">
      <div class="col-md-4">
        <h5>COMPROBANTES DE EGRESO</h5>
      </div>
      <div class="col-md-4">
        <a href="#" title="AGREGAR" class="bj-btn-table-add form-control-sm newVoucherEgress-link">NUEVO COMPROBANTE</a>
      </div>
      <div class="col-md-4">
        <!-- Mensajes de creación de comprobantes de egreso -->
        @if(session('SuccessSaveEgress'))
        <div class="alert alert-success">
          {{ session('SuccessSaveEgress') }}
        </div>
        @endif
        @if(session('SecondarySaveEgress'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveEgress') }}
        </div>
        @endif
        <!-- Mensajes de actualizacion de comprobantes de egreso -->
        @if(session('PrimaryUpdateEgress'))
        <div class="alert alert-primary">
          {{ session('PrimaryUpdateEgress') }}
        </div>
        @endif
        @if(session('SecondaryUpdateEgress'))
        <div class="alert alert-secondary">
          {{ session('SecondaryUpdateEgress') }}
        </div>
        @endif
        <!-- Mensajes de eliminación de comprobantes de egreso -->
        @if(session('WarningDeleteEgress'))
        <div class="alert alert-warning">
          {{ session('WarningDeleteEgress') }}
        </div>
        @endif
        @if(session('SecondaryDeleteEgress'))
        <div class="alert alert-secondary">
          {{ session('SecondaryDeleteEgress') }}
        </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        @php $datenow = Date('Y-m-d'); @endphp
        <form action="{{ route('egressVouchers.excel') }}" method="GET">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <small class="text-muted">FECHA INICIAL:</small>
                <input type="text" name="vegDateInitial" class="form-control form-control-sm datepicker" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <small class="text-muted">FECHA FINAL:</small>
                <input type="text" name="vegDateFinal" class="form-control form-control-sm datepicker" value='{{ $datenow }}' required>
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="bj-btn-table-add form-control-sm mt-4">GENERAR EXCEL</button>
            </div>
          </div>

        </form>
      </div>
    </div>
    <table id="tableDatatable" class="table table-hover text-center" width="100%">
      <thead>
        <tr>
          <th>COMPROBANTE</th>
          <th>FECHA DE EGRESO</th>
          <th>TERCERO</th>
          <th>VALOR PAGADO</th>
          <th>PDF</th>
        </tr>
      </thead>
      <tbody>
        @foreach($voucheregress as $egress)
        <tr>
          <td>{{ $egress->vegCode }}</td>
          <td>{{ $egress->vegDate }}</td>
          <td>{{ $egress->namecompany }}</td>
          <td>{{ $egress->vegPay }}</td>
          <td>{{ $egress->vegConcept }}</td>
          <td>
            <form action="{{ route('egressVouchers.pdf') }}" method="GET">
              @csrf
              <input type="hidden" name="vegId" value="{{ $egress->vegId }}" class="form-control form-control-sm" required>
              <button type="submit" title="DESCARGAR" class="bj-btn-table-delete">
                <i class="fas fa-file-pdf"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="newVoucherEgress-modal">
  <div class="modal-dialog">
    <!-- modal-lg -->
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="row">
          <div class="col-md-12 d-flex">
            <h4 class="text-muted">NUEVO COMPROBANTE DE EGRESO</h4>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <form action="{{ route('egressVouchers.save') }}" method="POST" autocomplete="off">
        @csrf
        <div class="row modal-body">
          <div class="col-md-12">
            <div class="row border-bottom">
              <div class="col-md-12">
                <div class="form-group">
                  <small class="text-muted">PROVEDOR:</small>
                  <select name="vegProvider" class="form-control form-control-sm" required>
                    <option value="">Seleccione un provedor...</option>
                    @foreach($providers as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->namecompany }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row p-2 text-center">
              <div class="col-md-12">
                @php $datenow = date('Y-m-d'); @endphp
                <small class="text-muted">FECHA:</small>
                <input type="text" name="vegDate" class="form-control form-control-sm text-center datepicker" value="{{ $datenow }}" required>
              </div>
            </div>
            <table width="100%" class="border-bottom">
              <tr>
                <td rowspan="10" class="text-right p-2" style="width: 50%;">
                  <small class="text-muted">TIPO DE IDENTIFICACION:</small><br>
                  <small class="text-muted">NUMERO DE IDENTIFICACION:</small><br>
                  <small class="text-muted">RAZON SOCIAL:</small><br>
                  <small class="text-muted">DIRECCION:</small><br>
                  <small class="text-muted">CIUDAD:</small><br>
                  <small class="text-muted">TELEFONO 1:</small><br>
                  <small class="text-muted">TELEFONO 2:</small><br>
                  <small class="text-muted">WHATSAPP:</small><br>
                  <small class="text-muted">CORREO 1:</small><br>
                  <small class="text-muted">CORREO 2:</small><br>
                </td>
                <td rowspan="10" class="text-left p-2" style="width: 50%;">
                  <small class="text-muted"><b class="proTypedocument"></b></small><br>
                  <small class="text-muted"><b class="proNumberdocument"></b></small><br>
                  <small class="text-muted"><b class="proNamecompany"></b></small><br>
                  <small class="text-muted"><b class="proAddress"></b></small><br>
                  <small class="text-muted"><b class="proCity"></b></small><br>
                  <small class="text-muted"><b class="proPhoneOne"></b></small><br>
                  <small class="text-muted"><b class="proPhoneTwo"></b></small><br>
                  <small class="text-muted"><b class="proPhoneApp"></b></small><br>
                  <small class="text-muted"><b class="proMailOne"></b></small><br>
                  <small class="text-muted"><b class="proMailTwo"></b></small><br>
                </td>
              </tr>
            </table>
            <div class="sectionPay" style="display: none;" id="app">
              <div class="col-md-12">
                <div class="row border-bottom border-top p-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">CODIGO DE COMPROBANTE:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="text" pattern="[0-9]" class="form-control form-control-sm text-center" name="vegCode" style="font-weight: bold;" required readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row border-bottom border-top p-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">SUB-TOTAL:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" pattern="[0-9]{1,20}" class="form-control form-control-sm text-center" name="vegSubpay" style="font-weight: bold;" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <small class="text-muted">IVA:</small>
                      <div class="input-group">
                        <input type="text" minlength="1" maxlength="3" pattern="[0-9.]{1,3}" name="vegIva" class="form-control form-control-sm text-center" value="19" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-percentage"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">VALOR IVA:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" pattern="[0-9]" class="form-control form-control-sm text-center" name="vegValueiva" style="font-weight: bold;" readonly required hidden>
                        <input type="text" pattern="[0-9]" class="form-control form-control-sm text-center" name="vegValueivaView" style="font-weight: bold;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1 m-auto pt-2 pl-0">
                    <button type="button" class="btn btn-secondary btn-sm" id="iva"><i class="fas fa-times-circle fa-lg"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <small class="text-muted">RETENCION:</small>
                      <div class="input-group">
                        <input type="text" maxlength="3" pattern="[0-9.]{1,3}" name="vegRetention" class="form-control form-control-sm text-center" value="3.5" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-percentage"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">VALOR RETENCION:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" minlength="1" class="form-control form-control-sm text-center" name="vegValueretention" style="font-weight: bold;" readonly required hidden>
                        <input type="text" minlength="1" class="form-control form-control-sm text-center" name="vegValueretentionView" style="font-weight: bold;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1 m-auto pt-2 pl-0">
                    <button type="button" class="btn btn-secondary btn-sm" id="retencion"><i class="fas fa-times-circle fa-lg"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <small class="text-muted">RETEICA:</small>
                      <div class="input-group">
                        <input type="text" maxlength="4" pattern="[0-9.]{1,4}" step="0.01" name="vegReteica" class="form-control form-control-sm text-center" value="0.41" required>
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-percentage"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">VALOR RETEICA:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" minlength="1" class="form-control form-control-sm text-center" name="vegValuereteica" style="font-weight: bold;" readonly required hidden>
                        <input type="text" minlength="1" class="form-control form-control-sm text-center" name="vegValuereteicaView" style="font-weight: bold;" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1 m-auto pt-2 pl-0">
                    <button type="button" class="btn btn-secondary btn-sm" id="ica"><i class="fas fa-times-circle fa-lg"></i></button>
                  </div>
                </div>
                <div class="row border-top border-bottom p-2">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">TOTAL:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                          </span>
                        </div>
                        <input type="text" name="vegPay" class="form-control form-control-sm text-center" readonly required hidden>
                        <input type="text" name="vegPayView" class="form-control form-control-sm text-center" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">DESCRIBA EL CONCEPTO DE PAGO:</small>
                      <textarea name="vegConcept" class="form-control form-control-sm" maxlength="1000" cols="10" rows="5" placeholder="Maximo de 1000 carácteres" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">ESTRUCTURA DE COSTO:</small>
                      <select name="vegCoststructure" class="form-control form-control-sm" required>
                        <option value="">Seleccione una estructura de costo...</option>
                        @foreach($structures as $structure)
                        <option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">DESCRIPCION DE COSTO:</small>
                      <select name="vegCostdescription" class="form-control form-control-sm" required>
                        <option value="">Seleccione una descripción de costo...</option>
                        <!-- rows dinamics -->
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row border-top p-2 text-center">
              <div class="col-md-12">
                <button type="submit" class="bj-btn-table-add form-control-sm">CONFIRMAR</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // sacamos el iva luego de dar click en el boton
  $('#iva').click(function() {
    const subtotal = $('input[name=vegSubpay]').val(),
      iva = $('input[name=vegIva]').val();
    let total = $('input[name=vegPay]').val(),
      result = $('input[name=vegValueiva]').val();
    if ($('#iva').hasClass('btn-secondary') == true) {
      $(this).removeClass('btn-secondary').addClass('btn-primary');
      $(this).find('svg').attr('data-icon', 'check-circle');
      result = Math.floor(subtotal * iva / 100);
      $('input[name=vegValueiva]').val(result);
      resultView = $('input[name=vegValueiva]').val();
      $('input[name=vegValueivaView]').val(new Intl.NumberFormat('es-CO').format(result));
      total = parseInt(total) + parseInt(result);
      $('input[name=vegPay]').val(total);
      totalView = $('input[name=vegPay]').val();
      $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
    } else {
      $(this).removeClass('btn-primary').addClass('btn-secondary');
      $(this).find('svg').attr('data-icon', 'times-circle');
      if (subtotal != $('input[name=vegPay]').val()) {
        total = parseInt(total) - parseInt(result);
        $('input[name=vegPay]').val(total);
        totalView = $('input[name=vegPay]').val();
        $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
        $('input[name=vegValueiva]').val(0);
        $('input[name=vegValueivaView]').val(0);
      }
    }
  });

  // sacamos la retencion
  $('#retencion').click(function() {
    const subtotal = $('input[name=vegSubpay]').val(),
      ret = $('input[name=vegRetention]').val();
    let total = $('input[name=vegPay]').val(),
      result = $('input[name=vegValueretention]').val();
    if ($('#retencion').hasClass('btn-secondary') == true) {
      $(this).removeClass('btn-secondary').addClass('btn-primary');
      $(this).find('svg').attr('data-icon', 'check-circle');
      result = Math.floor(subtotal * ret / 100);
      $('input[name=vegValueretention]').val(result);
      resultView = $('input[name=vegValueretention]').val();
      $('input[name=vegValueretentionView]').val(new Intl.NumberFormat('es-CO').format(result));
      total = parseInt(total) + parseInt(result);
      $('input[name=vegPay]').val(total);
      totalView = $('input[name=vegPay]').val();
      $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
    } else {
      $(this).removeClass('btn-primary').addClass('btn-secondary');
      $(this).find('svg').attr('data-icon', 'times-circle');
      if (subtotal != $('input[name=vegPay]').val()) {
        total = parseInt(total) - parseInt(result);
        $('input[name=vegPay]').val(total);
        totalView = $('input[name=vegPay]').val();
        $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
        $('input[name=vegValueretention]').val(0);
        $('input[name=vegValueretentionView]').val(0);
      }
    }
  });

  // sacamos reteica
  $('#ica').click(function() {
    const subtotal = $('input[name=vegSubpay]').val(),
      ret = $('input[name=vegReteica]').val();
    let total = $('input[name=vegPay]').val(),
      result = $('input[name=vegValuereteica]').val();
    if ($('#ica').hasClass('btn-secondary') == true) {
      $(this).removeClass('btn-secondary').addClass('btn-primary');
      $(this).find('svg').attr('data-icon', 'check-circle');
      result = Math.floor(subtotal * ret / 100);
      $('input[name=vegValuereteica]').val(result);
      resultView = $('input[name=vegValuereteica]').val();
      $('input[name=vegValuereteicaView]').val(new Intl.NumberFormat('es-CO').format(result));
      total = parseInt(total) + parseInt(result);
      $('input[name=vegPay]').val(total);
      totalView = $('input[name=vegPay]').val();
      $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
    } else {
      $(this).removeClass('btn-primary').addClass('btn-secondary');
      $(this).find('svg').attr('data-icon', 'times-circle');
      if (subtotal != $('input[name=vegPay]').val()) {
        total = parseInt(total) - parseInt(result);
        $('input[name=vegPay]').val(total);
        totalView = $('input[name=vegPay]').val();
        $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(totalView));
        $('input[name=vegValuereteica]').val(0);
        $('input[name=vegValuereteicaView]').val(0);
      }
    }
  });

  $('.newVoucherEgress-link').on('click', function(e) {
    e.preventDefault();
    $('input[name=vegValueretention]').val(0);
    $('input[name=vegValueretentionView]').val(0);
    $('input[name=vegValueiva]').val(0);
    $('input[name=vegValueivaView]').val(0);
    $('input[name=vegValuereteica]').val(0);
    $('input[name=vegValuereteicaView]').val(0);
    $('#newVoucherEgress-modal').modal();
  });

  $('select[name=vegProvider]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $.get("{{ route('getProvider') }}", {
        selected: selected
      }, function(objectProvider) {
        if (objectProvider != null && objectProvider != '') {
          $('.proTypedocument').text('');
          $('.proTypedocument').text(objectProvider['typeDocument']);
          $('.proNumberdocument').text('');
          $('.proNumberdocument').text(objectProvider['numberdocument']);
          $('.proNamecompany').text('');
          $('.proNamecompany').text(objectProvider['namecompany']);
          $('.proAddress').text('');
          $('.proAddress').text(objectProvider['address']);
          $('.proCity').text('');
          $('.proCity').text(objectProvider['nameCity']);
          $('.proPhoneOne').text('');
          $('.proPhoneOne').text(objectProvider['phoneone']);
          $('.proPhoneTwo').text('');
          $('.proPhoneTwo').text(objectProvider['phonetwo']);
          $('.proPhoneApp').text('');
          $('.proPhoneApp').text(objectProvider['whatsapp']);
          $('.proMailOne').text('');
          $('.proMailOne').text(objectProvider['emailone']);
          $('.proMailTwo').text('');
          $('.proMailTwo').text(objectProvider['emailtwo']);
          $('.sectionPay').css('display', 'flex');
        }
        $.get("{{ route('getNumberVoucherEgress') }}", function(objectNumbernext) {
          if (objectNumbernext != null) {
            $('input[name=vegCode]').val('');
            $('input[name=vegCode]').val(objectNumbernext);
          }
        });
      });
    } else {
      resetModal();
    }
  });

  // al insertar el subtotal si demas campos
  $('input[name=vegSubpay]').on('keyup', function(e) {
    var subtotal = parseInt(e.target.value);
    var iva = parseFloat($('input[name=vegIva]').val());
    var retention = parseFloat($('input[name=vegRetention]').val());
    var reteica = parseFloat($('input[name=vegReteica]').val());
    $('input[name=vegPay]').val(subtotal);
    var subtotalformat = $('input[name=vegPay]').val();
    $('input[name=vegPayView]').val(new Intl.NumberFormat('es-CO').format(subtotalformat));
  });

  // $('input[name=vegIva]').on('keyup', function(e) {
  //   var iva = parseFloat(e.target.value);
  //   var subtotal = parseFloat($('input[name=vegSubpay]').val());
  //   if (!isNaN(subtotal)) {
  //     if (!isNaN(iva)) {
  //       var valueiva = (subtotal * iva) / 100;
  //       $('input[name=vegValueiva]').val(Math.round(valueiva));
  //     } else {
  //       $('input[name=vegValueiva]').val('0');
  //     }
  //     setTotal(subtotal, $('input[name=vegValueretention]').val(), $('input[name=vegValuereteica]').val(), $('input[name=vegValueiva]').val());
  //   } else {
  //     $('input[name=vegValueiva]').val('0');
  //   }
  // });

  // $('input[name=vegRetention]').on('keyup', function(e) {
  //   var retention = parseFloat(e.target.value);
  //   var subtotal = parseFloat($('input[name=vegSubpay]').val());
  //   if (!isNaN(subtotal)) {
  //     if (!isNaN(retention)) {
  //       var valueretention = (subtotal * retention) / 100;
  //       $('input[name=vegValueretention]').val(Math.round(valueretention));
  //     } else {
  //       $('input[name=vegValueretention]').val('0');
  //     }
  //     setTotal(subtotal, $('input[name=vegValueretention]').val(), $('input[name=vegValuereteica]').val(), $('input[name=vegValueiva]').val());
  //   } else {
  //     $('input[name=vegValueretention]').val('0');
  //   }
  // });

  // $('input[name=vegReteica]').on('keyup', function(e) {
  //   var reteica = parseFloat(e.target.value);
  //   var subtotal = parseFloat($('input[name=vegSubpay]').val());
  //   if (!isNaN(subtotal)) {
  //     if (!isNaN(reteica)) {
  //       var valuereteica = (subtotal * reteica) / 100;
  //       $('input[name=vegValuereteica]').val(Math.round(valuereteica));
  //     } else {
  //       $('input[name=vegValuereteica]').val('0');
  //     }
  //     setTotal(subtotal, $('input[name=vegValueretention]').val(), $('input[name=vegValuereteica]').val(), $('input[name=vegValueiva]').val());
  //   } else {
  //     $('input[name=vegValuereteica]').val('0');
  //   }
  // });

  $('select[name=vegCoststructure]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $.get("{{ route('getCostdescriptions') }}", {
        idCoststructure: selected
      }, function(objectCostdescriptions) {
        var count = Object.keys(objectCostdescriptions).length;
        $('select[name=vegCostdescription]').empty();
        $('select[name=vegCostdescription]').append("<option value=''>Seleccione una descripción  de costo...</option>");
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=vegCostdescription]').append(
              "<option value='" + objectCostdescriptions[i]['cdId'] + "'>" +
              objectCostdescriptions[i]['cdDescription'] +
              "</option>"
            );
          }
        }
      });
    } else {
      $('select[name=vegCostdescription]').empty();
      $('select[name=vegCostdescription]').append("<option value=''>Seleccione una descripción  de costo...</option>");
    }
  });

  // function setTotal(subtotal, retention, reteica, iva, ) {
  //   var pay = parseFloat((parseFloat(subtotal - retention) + parseFloat(iva)) - reteica);
  //   $('input[name=vegPay]').val(Math.round(pay));
  // }

  //DETECTAR CIERRE DE MODAL
  $("#newVoucherEgress-modal").on('hidden.bs.modal', function() {
    resetModal();
  });

  function resetModal() {
    $('.proTypedocument').text('');
    $('.proNumberdocument').text('');
    $('.proNamecompany').text('');
    $('.proAddress').text('');
    $('.proCity').text('');
    $('.proPhoneOne').text('');
    $('.proPhoneTwo').text('');
    $('.proPhoneApp').text('');
    $('.proMailOne').text('');
    $('.proMailTwo').text('');
    $('select[name=vegProvider]').val('');
    $('input[name=vegCode]').val('');
    $('input[name=vegSubpay]').val('');
    $('input[name=vegIva]').val('19');
    $('input[name=vegValueiva]').val('');
    $('input[name=vegRetention]').val('3.5');
    $('input[name=vegValueretention]').val('');
    $('input[name=vegPay]').val('');
    $('textarea[name=vegConcept]').val('');
    $('.sectionPay').css('display', 'none');
  }
</script>
@endsection