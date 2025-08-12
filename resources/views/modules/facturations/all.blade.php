@extends('modules.accountants')

@section('financialModules')
  <div class="col-md-12">
    <div class="row border-bottom my-3">
      <div class="col-md-6">
        <h3>GESTION DE CARTERA</h3>
      </div>

      <div class="col-md-6">
        <form action="{{ route('facturation.defeatedPdf') }}" method="GET" style="display: inline;">
          <button class="btn btn-outline-tertiary form-control-sm pdfFacturation-link" title="PDF" type="submit">
            <i class="fas fa-file-pdf"></i>
            CARTERA VENCIDA
          </button>
        </form>

        <!-- Mensajes de creación de comprobantes de ingreso -->

        @if (session('SuccessSaveEntry'))
          <div class="alert alert-success mt-3">
            {{ session('SuccessSaveEntry') }}
          </div>
        @endif

        @if (session('SecondarySaveEntry'))
          <div class="alert alert-secondary mt-3">
            {{ session('SecondarySaveEntry') }}
          </div>
        @endif

        <!-- Mensajes de actualizacion de comprobantes de ingreso -->

        @if (session('PrimaryUpdateFacturation'))
          <div class="alert alert-primary mt-3">
            {{ session('PrimaryUpdateFacturation') }}
          </div>
        @endif

        @if (session('WarningUpdateFacturation'))
          <div class="alert alert-warning mt-3">
            {{ session('WarningUpdateFacturation') }}
          </div>
        @endif

        @if (session('SecondaryUpdateFacturation'))
          <div class="alert alert-secondary mt-3">
            {{ session('SecondaryUpdateFacturation') }}
          </div>
        @endif

        <!-- Mensajes de eliminación de facturaciones -->

        @if (session('WarningDeleteFacturation'))
          <div class="alert alert-warning mt-3">
            {{ session('WarningDeleteFacturation') }}
          </div>
        @endif

        @if (session('SecondaryDeleteFacturation'))
          <div class="alert alert-secondary mt-3">
            {{ session('SecondaryDeleteFacturation') }}
          </div>
        @endif
      </div>
    </div>

    <table class="table-hover table text-center" id="tableDatatable" width="100%">
      <thead>
        <tr>
          <th>FACTURA</th>
          <th>FECHA DE VENCIMIENTO</th>
          <th>ALUMNO</th>
          <th>VALOR A PAGAR</th>
          <th>ACCION</th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < count($allDates); $i++)
          <tr>
            <td>{{ $allDates[$i][2] }}</td>
            <td>{{ $allDates[$i][3] }}</td>
            <td>{{ $allDates[$i][4] }}</td>
            <td>${{ $allDates[$i][5] }}</td>
            <td>
              <a class="btn btn-outline-primary rounded-circle editFacture-link" href="#" title="EDITAR FACTURA">
                <i class="fas fa-edit"></i>
                <span hidden>{{ $allDates[$i][1] }}</span><!-- ID DE FACTURA -->
                <span hidden>{{ $allDates[$i][4] }}</span><!-- NOMBRE DE ALUMNO -->
              </a>

              <a class="btn btn-outline-success rounded-circle createVoucher-link" href="#"
                title="GENERAR COMPROBANTE">
                <i class="fas fa-sync"></i>
                <span hidden>{{ $allDates[$i][0] }}</span>
                <span hidden>{{ $allDates[$i][1] }}</span>
                <span hidden>{{ $allDates[$i][2] }}</span><!-- CODIGO DE FACTURA -->
                <span hidden>{{ $allDates[$i][5] }}</span><!-- VALOR -->
              </a>

              <form action="{{ route('facturation.pdf') }}" method="GET" style="display: inline;">
                <input name="legId" readonly type="hidden" value="{{ $allDates[$i][0] }}">
                <input name="facId" readonly type="hidden" value="{{ $allDates[$i][1] }}">
                <button class="btn btn-outline-tertiary rounded-circle pdfFacturation-link" title="PDF" type="submit">
                  <i class="fas fa-file-pdf"></i>
                </button>
              </form>

              <form action="{{ route('facturation.pdf-mail') }}" method="GET" style="display: inline;">
                <input name="legId" readonly type="hidden" value="{{ $allDates[$i][0] }}">
                <input name="facId" readonly type="hidden" value="{{ $allDates[$i][1] }}">
                <button class="btn btn-outline-info rounded-circle pdfFacturation-mail" title="EMAIL - PDF"
                  type="submit">
                  <i class="fas fa-mail-bulk"></i>
                </button>
              </form>

              <a class="btn btn-outline-primary rounded-circle accountsPending-link" href="#"
                title="CARTERA PENDIENTE">
                <i class="fas fa-funnel-dollar"></i>
                <span hidden>{{ $allDates[$i][0] }}</span><!-- ID DE LEGALIZACION -->
                <span hidden>{{ $allDates[$i][4] }}</span><!-- NOMBRE DE ALUMNO -->
              </a>

              <a class="btn btn-outline-secondary rounded-circle accountsCanceled-link" href="#"
                title="ANULAR FACTURA">
                <i class="fas fa-times"></i>
                <span hidden>{{ $allDates[$i][0] }}</span><!-- ID DE LEGALIZACION -->
                <span hidden>{{ $allDates[$i][1] }}</span><!-- ID DE FACTURA -->
                <span hidden>{{ $allDates[$i][2] }}</span><!-- CODIGO DE FACTURA -->
                <span hidden>{{ $allDates[$i][3] }}</span><!-- FECHA DE VENCIMIENTO -->
                <span hidden>{{ $allDates[$i][4] }}</span><!-- NOMBRE DE ALUMNO -->
                <span hidden>{{ $allDates[$i][5] }}</span><!-- VALOR A PAGAR -->
              </a>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>



  <!-- Modal de modificación de valores de factura -->

  <div class="modal fade" id="editFacture-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted">MODIFICAR VALORES DE FACTURA:</h6>
            </div>
          </div>
          <button class="close" data-dismiss="modal" type="button">&times;</button>
        </div>

        <!-- Modal body -->

        <div class="row modal-body">
          <div class="col-md-12">
            <form action="{{ route('facturations.edit') }}" class="row" method="POST">
              @csrf
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <small class="text-muted">INFORMACION DE FACTURA:</small><br>
                    <span class="text-muted">Código: <b class="facCode_edit"></b></span><br>
                    <span class="text-muted">Valor: <b>$</b><b class="facValue_edit"></b></span><br>
                    <span class="text-muted">Estado: <b class="facStatus_edit"></b></span><br>
                    <span class="text-muted">Contrato de: <b class="facStudent_edit"></b></span><br>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">VALOR DE DESCUENTO ACTUAL:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" disabled name="facValuediscountnow_edit"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">NUEVO VALOR DESCUENTO:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" name="facValuediscountnew_edit"
                          pattern="[0-9]{1,10}" style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">FECHA DE EMISION ACTUAL:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" disabled name="facDateInitialnow_edit"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">NUEVA FECHA DE EMISION:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>

                        <input class="form-control form-control-sm datepicker text-center" name="facDateInitialnew_edit"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">FECHA DE VENCIMIENTO ACTUAL:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" disabled name="facDateFinalnow_edit"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">NUEVA FECHA DE VENCIMIENTO:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>

                        <input class="form-control form-control-sm datepicker text-center" name="facDateFinalnew_edit"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 p-3 text-center">
                    <small class="message_edit"
                      style="display: none; transition: all .2s; color: red; font-size: 14px;"></small>
                  </div>
                </div>

                <div class="form-group text-center">
                  <input class="form-control form-control-sm" name="facId_edit" readonly required type="hidden">

                  <button class="btn btn-outline-primary form-control-sm btn-editFacture" disabled
                    type="submit">GUARDAR CAMBIOS</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de generación de comprobantes de ingreso -->

  <div class="modal fade" id="createVoucher-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->

        <div class="modal-header">
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted">GENERAR COMPROBANTE DE INGRESO</h6>
            </div>
          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>
        </div>

        <!-- Modal body -->

        <div class="row modal-body">
          <div class="col-md-12">
            <form action="{{ route('entryVouchers.save') }}" class="row" method="POST">
              @csrf
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">CODIGO DEL COMPROBANTE</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" disabled name="codeNext_voucher"
                          required style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">CODIGO DE FACTURA:</small>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>

                        <input class="form-control form-control-sm text-center" disabled name="venFacturation" required
                          style="font-weight: bold;" type="text">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <small class="text-muted">TIPO DE PAGO:</small>
                      <select class="form-control form-control-sm select2" name="venTypepaid" required>
                        <option value="">Seleccione...</option>
                        <option selected value="TOTAL">PAGO TOTAL</option>
                        <option value="PARCIAL">ABONO PARCIAL</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group venDatePaid">
                      <small class="text-muted">FECHA DE PAGO:</small>
                      <input class="form-control form-control-sm datepicker" name="venDate" required type="text">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group venValuePaid">
                      <small class="text-muted">VALOR DE PAGO:</small>
                      <input class="form-control form-control-sm" name="venPaid" readonly required type="text">
                      <input class="form-control form-control-sm" name="venPaid_hidden" readonly required
                        type="hidden">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input class="form-control form-control-sm" name="venCode" readonly required type="hidden">
                        <input class="form-control form-control-sm" name="venFacturation_id" readonly required
                          type="hidden">
                        <input class="form-control form-control-sm" name="venLegalization_id" readonly required
                          type="hidden">
                        <small class="text-muted">DESCRIPCION DEL COMPROBANTE</small>
                        <textarea class="form-control form-control-sm" maxlength="500" name="venDescrimtion"
                          placeholder="Descripcion de comprobante" readonly required></textarea>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <small class="text-muted">OBSERVACIONES</small>
                      <textarea class="form-control form-control-sm" maxlength="100" name="venObs" placeholder="Observaciones" required></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-group text-center">
                  <button class="btn btn-outline-success btn-savevoucherentry" type="submit">GENERAR
                    COMPROBANTE</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal de cartera pendiente y exportacion a PDF -->

  <div class="modal fade" id="accountsPending-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->

        <div class="modal-header">
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted">CARTERA PENDIENTE DE ALUMN@ <b class="nameStudent-modalPending"></b></h6>
            </div>
          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>
        </div>

        <!-- Modal body -->

        <div class="row modal-body">
          <div class="col-md-12">
            <span class="concemtsAccounts-modal" hidden></span>
            <table class="table-striped table" id="table-accounts" width="100%">
              <thead>
                <th>FECHA DE COMPROMISO</th>
                <th>CONCEmtO</th>
                <th>VALOR SIN IVA</th>
              </thead>
              <tbody>
                <!-- Filas dinámicas -->
              </tbody>
            </table>

            <form action="{{ route('facturation.accountsPendingPdf') }}">
              @csrf
              <div class="form-group text-center" style="font-size: 12px;">
                <input class="form-control form-control-sm text-center" name="concemts" readonly required
                  type="hidden">
                <input class="form-control form-control-sm text-center" name="legalization" readonly required
                  type="hidden">
                <button class='btn btn-outline-tertiary' type="submit">DESCARGAR EN PDF <i
                    class='fas fa-file-pdf'></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de factura a ser anulada -->

  <div class="modal fade" id="accountsCanceled-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->

        <div class="modal-header">
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted">ANULAR FACTURA <b class="codeFacture-modalCanceled"></b> DE ALUMN@ <b
                  class="nameStudent-modalCanceled"></b></h6>
            </div>
          </div>
          <button class="close" data-dismiss="modal" type="button">&times;</button>
        </div>

        <!-- Modal body -->

        <div class="row modal-body">
          <div class="col-md-12">
            <form action="{{ route('canceled.change') }}">
              @csrf
              <div class="form-group" style="font-size: 13px;">
                <span class="text-muted"><b>La siguiente información sobre la factura pasará a estado ANULADA y ya no se
                    podrá visualizar en este módulo:</b></span><br>
                <small class="text-muted">INFORMACION DE FACTURA:</small><br>
                <span>CODIGO: <b class="codeFacture-modalCanceled"></b></span><br>
                <span>FECHA DE VENCIMIENTO: <b class="dateFacture-modalCanceled"></b></span><br>
                <span>ALUMNO: <b class="nameStudent-modalCanceled"></b></span><br>
                <span>VALOR A PAGAR: <b class="valueFacture-modalCanceled"></b></span><br>
              </div>

              <div class="form-group">
                <small class="text-muted">ARGUMENTO DE ANULACION:</small>
                <textarea class="form-control form-control-sm" cols="1" maxlength="500" name="argumentCanceled" required
                  rows="2"></textarea>
              </div>

              <div class="form-group text-center" style="font-size: 12px;">
                <input class="form-control form-control-sm text-center" name="facId_canceled" readonly required
                  type="hidden">

                <input class="form-control form-control-sm text-center" name="legId_canceled" readonly required
                  type="hidden">

                <button class='btn btn-outline-secondary' type="submit">ANULAR FACTURA</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    var countVouchers = 1;

    $(function() {});

    $('.editFacture-link').on('click', function(e) {
      e.preventDefault();
      var facId = $(this).find('span:nth-child(2)').text();
      var nameStudent = $(this).find('span:nth-child(3)').text();

      $('input[name=facId_edit]').val(facId);
      $('.facStudent_edit').text(nameStudent);
      $.get("{{ route('getFactureFromEdit') }}", {
        facId: facId
      }, function(objectFacturation) {
        if (objectFacturation != null) {
          $('.facCode_edit').text(objectFacturation['facCode']);
          $('.facValue_edit').text(objectFacturation['facValueIva']);
          $('.facStatus_edit').text(objectFacturation['facStatus']);
          $('input[name=facValuediscountnow_edit]').val(objectFacturation['facValuediscount']);
          $('input[name=facValuediscountnew_edit]').val(objectFacturation['facValuediscount']);
          $('input[name=facDateInitialnow_edit]').val(objectFacturation['facDateInitial']);
          $('input[name=facDateInitialnew_edit]').val(objectFacturation['facDateInitial']);
          $('input[name=facDateFinalnow_edit]').val(objectFacturation['facDateFinal']);
          $('input[name=facDateFinalnew_edit]').val(objectFacturation['facDateFinal']);
          $('.btn-editFacture').attr('disabled', false);
        } else {
          $('.btn-editFacture').attr('disabled', true);
        }
      });
      $('#editFacture-modal').modal();
    });

    $('.btn-editFacture').on('click', function(e) {
      var dateInitial = new Date($('input[name=facDateInitialnew_edit]').val());
      var dateFinal = new Date($('input[name=facDateFinalnew_edit]').val());

      if (dateInitial <= dateFinal) {
        var total = parseInt($('.facValue_edit').text());
        var discount = parseInt($('input[name=facValuediscountnew_edit]').val());
        if (discount <= total) {
          $(this).submit();
        } else {
          e.preventDefault();
          $('.message_edit').css('display', 'block');
          $('.message_edit').text('El valor de descuento no puede superar el total de la factura');
          setTimeout(function() {
            $('.message_edit').css('display', 'none');
            $('.message_edit').text('');
          }, 3000);
        }
      } else {
        e.preventDefault();
        $('.message_edit').css('display', 'block');
        $('.message_edit').text('La fecha de vencimiento no puede ser anterior a la fecha de emisión');
        setTimeout(function() {
          $('.message_edit').css('display', 'none');
          $('.message_edit').text('');
        }, 3000);
      }
    });

    $('.accountsCanceled-link').on('click', function(e) {
      e.preventDefault();
      var legId = $(this).find('span:nth-child(2)').text();
      var facId = $(this).find('span:nth-child(3)').text();
      var codeFacture = $(this).find('span:nth-child(4)').text();
      var dateFacture = $(this).find('span:nth-child(5)').text();
      var nameStudent = $(this).find('span:nth-child(6)').text();
      var valueFacture = $(this).find('span:nth-child(7)').text();
      $('input[name=legId_canceled]').val(legId);
      $('input[name=facId_canceled]').val(facId);
      $('.codeFacture-modalCanceled').text(codeFacture);
      $('.dateFacture-modalCanceled').text(dateFacture);
      $('.nameStudent-modalCanceled').text(nameStudent);
      $('.valueFacture-modalCanceled').text(valueFacture);
      $('#accountsCanceled-modal').modal();
    });

    // EVENTO PARA VER MODAL DE GENERAR EL COMPROBANTE

    $('.createVoucher-link').on('click', function(e) {
      e.preventDefault();
      var legId = $(this).find('span:nth-child(2)').text();
      var facId = $(this).find('span:nth-child(3)').text();
      var facCode = $(this).find('span:nth-child(4)').text();
      var value = $(this).find('span:nth-child(5)').text();

      // var value = $(this).parents('tr').find('td:nth-child(4)').html();

      $.get("{{ route('getNumberVoucherEntry') }}", function(objectNumbernext) {
        $('input[name=codeNext_voucher]').val(objectNumbernext);
        $('input[name=venCode]').val(objectNumbernext);
        $('input[name=venFacturation_id]').val(facId);
        $('input[name=venFacturation]').val(facCode);
        $('input[name=venLegalization_id]').val(legId);
        $('input[name=venPaid]').attr('readonly', true);
        $('input[name=venPaid]').val(new Intl.NumberFormat().format(value));
        $('input[name=venPaid_hidden]').val(value);
        var date = new Date();
        var dateComplete = date.getFullYear() + '-' + ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() +
          1) + '-' + (date.getDate() < 10 ? '0' : '') + date.getDate();
        $('input[name=venDate]').val(dateComplete);
        $('textarea[name=venDescrimtion]').val(
          "Pago realizado el " + getFormatDate(date) + " para dejar a paz y salvo la factura No. " + facCode
        );
      });
      $('#createVoucher-modal').modal();
    });

    // EVENTO PARA CAMBIAR ELEMENTOS DEL FORMULARIO DEPENDIENDO SO ES PAGO TOTAL O PARCIAL

    $('select[name=venTypepaid]').on('change', function(e) {
      var selected = e.target.value;
      if (selected != '') {
        var date = new Date($('input[name=venDate]').val());
        $('.venValuePaid').css('visible', 'visible');
        if (selected == 'TOTAL') {
          $('input[name=venPaid]').attr('readonly', true);
          $('input[name=venPaid]').val($('input[name=venPaid_hidden]').val());
          $('textarea[name=venDescrimtion]').val(
            "Pago realizado el " + getFormatDate(date) + " para dejar a paz y salvo la factura No. " + $(
              'input[name=venFacturation]').val()
          );
        } else if (selected == 'PARCIAL') {
          $('input[name=venPaid]').attr('readonly', false);
          $('input[name=venPaid]').attr('required', true);
          $('input[name=venPaid]').val('');
          var facCode = $('input[name=venFacturation]').val();
          $.get("{{ route('getCountvoucherBefore') }}", {
            facCode: facCode
          }, function(objectCountvoucher) {
            if (objectCountvoucher != null) {
              countVouchers = parseInt(objectCountvoucher['facCountVoucher']);
              if (parseInt(objectCountvoucher['facCountVoucher']) > 1) {
                $('textarea[name=venDescrimtion]').val(
                  "Pago número " + (parseInt(objectCountvoucher['facCountVoucher']) + 1) + " realizado el " +
                  getFormatDate(date) + " de la factura No. " + $('input[name=venFacturation]').val()
                );
              } else {
                $('textarea[name=venDescrimtion]').val(
                  "Pago número 1 realizado el " + getFormatDate(date) + " de la factura No. " + $(
                    'input[name=venFacturation]').val()
                );
              }
            }
          });
        }
      } else {
        $('.venValuePaid').css('visible', 'hidden');
        $('input[name=venPaid]').val('');
        $('input[name=venPaid]').attr('readonly', true);
        $('input[name=venPaid]').attr('required', false);
      }
    });

    // EVENTO PARA CAMBIAR ELEMENTOS TEXTO DE LA DESCRIPCION DEL COMPROBANTE DEPENDIENDO DE LA FECHA SELECCIONADA

    $('input[name=venDate]').on('change', function(e) {
      var date = new Date(e.target.value);
      var selectedType = $('select[name=venTypepaid]').val();
      if (selectedType != '' && selectedType == 'TOTAL') {
        $('textarea[name=venDescrimtion]').val(
          "Pago realizado el " + getFormatDate(date) + " para dejar a paz y salvo la factura No. " + $(
            'input[name=venFacturation]').val()
        );
      } else if (selectedType != '' && selectedType == 'PARCIAL') {
        $('textarea[name=venDescrimtion]').val(
          "Pago número " + countVouchers + " realizado el " + getFormatDate(date) + " de la factura No. " + $(
            'input[name=venFacturation]').val()
        );
      }
    });

    $('.accountsPending-link').on('click', function(e) {
      e.preventDefault();
      var leg = $(this).find('span:nth-child(2)').text();
      var stu = $(this).find('span:nth-child(3)').text();
      $('.nameStudent-modalPending').text(stu);
      $.get("{{ route('accounts.report') }}", {
        legalization: leg
      }, function(objectAccounts) {
        var count = Object.keys(objectAccounts).length;
        if (count > 0) {
          var concemts = '';
          for (var i = 0; i < count; i++) {
            if (i == (count - 1)) {
              concemts += objectAccounts[i]['conId'];
            } else {
              concemts += objectAccounts[i]['conId'] + ':';
            }

            $('#table-accounts tbody').append("<tr>" +
              "<td>" + getFormatDate(objectAccounts[i]['conDate']) + "</td>" +
              "<td>" + objectAccounts[i]['conConcemt'] + "</td>" +
              "<td>$" + objectAccounts[i]['conValue'] + "</td>" +
              "</tr>");
          }
          $('input[name=concemts]').val(concemts);
          $('input[name=legalization]').val(leg);
          $('input[name=concemtsAccounts-modal]').val(concemts);
        }
      });
      $('#accountsPending-modal').modal();
    });

    //BOTON DE CIERRE DE MODAL DE CARTERA PENDIENTE

    $("#accountsPending-modal").on('hidden.bs.modal', function() {
      $('.nameStudent-modalPending').text('');
      $('input[name=concemts]').val('');
      $('input[name=legalization]').val('');
      $('#table-accounts tbody').emmty();
    });

    //BOTON DE CIERRE DE MODAL

    $("#detailsFacturation-modal").on('hidden.bs.modal', function() {

      // Code...

    });

    function getFormatDate(date) {
      var dateJ = new Date(date);
      var year = dateJ.getFullYear();
      var mount = ((dateJ.getMonth() + 1) < 10 ? '0' : '') + (dateJ.getMonth() + 1);
      var day = (dateJ.getDate() < 10 ? '0' : '') + dateJ.getDate();
      switch (mount) {
        case '01':
          return day + ' de enero del ' + year;
          break;
        case '02':
          return day + ' de febrero del ' + year;
          break;
        case '03':
          return day + ' de marzo del ' + year;
          break;
        case '04':
          return day + ' de abril del ' + year;
          break;
        case '05':
          return day + ' de mayo del ' + year;
          break;
        case '06':
          return day + ' de junio del ' + year;
          break;
        case '07':
          return day + ' de julio del ' + year;
          break;
        case '08':
          return day + ' de agosto del ' + year;
          break;
        case '09':
          return day + ' de semtiembre del ' + year;
          break;
        case '10':
          return day + ' de octubre del ' + year;
          break;
        case '11':
          return day + ' de noviembre del ' + year;
          break;
        case '12':
          return day + ' de diciembre del ' + year;
          break;
      }
    }
  </script>
@endsection
