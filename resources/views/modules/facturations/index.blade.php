@extends('modules.accountants')

@section('financialModules')

  <div class="col-md-12">
    <div class="row border-bottom my-3">
      <div class="col-md-6">
        <h3>MODULO DE FACTURACION</h3>
      </div>

      <div class="col-md-6">

        <!-- Mensajes de creación de facturaciones -->

        @if (session('SuccessSaveFacturation'))
          <div class="alert alert-success">
            {{ session('SuccessSaveFacturation') }}
          </div>
        @endif

        @if (session('SecondarySaveFacturation'))
          <div class="alert alert-secondary">
            {{ session('SecondarySaveFacturation') }}
          </div>
        @endif

        <!-- Mensajes de actualizacion de facturaciones -->

        @if (session('PrimaryUpdateFacturation'))
          <div class="alert alert-primary">
            {{ session('PrimaryUpdateFacturation') }}
          </div>
        @endif

        @if (session('SecondaryUpdateFacturation'))
          <div class="alert alert-secondary">
            {{ session('SecondaryUpdateFacturation') }}
          </div>
        @endif

        <!-- Mensajes de eliminación de facturaciones -->

        @if (session('WarningDeleteFacturation'))
          <div class="alert alert-warning">
            {{ session('WarningDeleteFacturation') }}
          </div>
        @endif

        @if (session('SecondaryDeleteFacturation'))
          <div class="alert alert-secondary">
            {{ session('SecondaryDeleteFacturation') }}
          </div>
        @endif

        <div class="alert message">

          <!-- Mensajes -->

        </div>
      </div>
    </div>
    @if (isset($all) && $all != null)
      <div class="row p-3">
        <div class="col-md-4 border-right p-2">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-key"></i>
              </span>
            </div>

            <input class="form-control form-control-sm text-center" disabled name="codeFacture" required
              style="font-weight: bold;" type="text" value="{{ $all['codeFacture'] }}">

            <input class="form-control form-control-sm" disabled name="legalization" type="hidden"
              value="{{ $all['legalization'] }}">

          </div>
          <hr>
          <small class="text-muted">FECHA DE EMISION:</small><br>
          <h6 class="dateInitialFacture-view">{{ $all['dateFacture'] }}</h6>
          <span class="dateInitialFacture-hidden" hidden>{{ $all['dateFacture'] }}</span><br>
          <small class="text-muted">FECHA DE VENCIMIENTO:</small><br>
          <div class="form-group">
            <select class="form-control form-control-sm select2" name="dateFinalFacture">
              <option selected value="">INMEDIATA</option>
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

          @if (isset($all['nameFather']) && isset($all['typeFather']) && isset($all['numberFather']))
            <h6>{{ $all['nameFather'] }}</h6>
            <h6>{{ $all['typeFather'] . ': ' . $all['numberFather'] }}</h6>
          @else
            <h6>{{ __('SIN REGISTRO') }}</h6>
          @endif

          <hr>

          <small class="text-muted">ACUDIENTE 2:</small><br>

          @if (isset($all['nameMother']) && isset($all['typeMother']) && isset($all['numberMother']))
            <h6>{{ $all['nameMother'] }}</h6>
            <h6>{{ $all['typeMother'] . ': ' . $all['numberMother'] }}</h6>
          @else
            <h6>{{ __('SIN REGISTRO') }}</h6>
          @endif

          <span class="concepts" hidden>{{ $all['concepts'] }}</span>

        </div>

        <div class="col-md-8 border-left p-2">
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
              @for ($i = 1; $i <= $all['totalConcept']; $i++)
                <tr>
                  <td>{{ $row }}</td>
                  <td>{{ $all['conDate' . $i] }}</td>
                  <td>{{ $all['conConcept' . $i] }}</td>
                  <td>{{ number_format($all['conValue' . $i], 0, ',', '.') }}</td>
                </tr>
                @php $row++ @endphp
              @endfor
            </tbody>
          </table>
        </div>
      </div>

      <div class="row border-top border-right border-bottom border-left p-2 text-center">
        <div class="col-md-3">
          <small class="text-muted">SUBTOTAL:</small><br>
          <span aria-hidden="true" class="form-control form-control-sm badge badge-success subtotalFacture" hidden
            style="color: #fff; font-weight: bold; font-size: 20px;">{{ $all['totalFacture'] }}</span>

          <span class="form-control form-control-sm badge badge-success"
            style="color: #fff; font-weight: bold; font-size: 20px;">{{ number_format($all['totalFacture'], 0, ',', '.') }}</span>
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

              <input class="form-control form-control-sm text-center" maxlength="8" name="facValuediscount"
                pattern="[0-9]{1,8}" title="Máximo 8 carácteres numéricos" type="text" value="0">
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <small class="text-muted">% DEL IVA PARA CADA ITEM:</small>
            <div class="input-group">
              <input class="form-control form-control-sm text-center" maxlength="2" name="facPorcentageIva"
                pattern="[0-9]{1,2}" title="Máximo 2 carácteres numéricos" type="text" value="0">

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

              <input class="form-control form-control-sm text-center" disabled name="facValueIva" type="text"
                value="{{ $all['totalFacture'] }}">
            </div>
          </div>
        </div>
      </div>

      <div class="row border-top border-right border-bottom border-left p-2 text-center">
        <div class="col-md-12">
          <button class="btn btn-outline-success btn-getModal mt-3" type="button">GENERAR FACTURA</button>
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
                  <h6 class="text-muted">SE GUARDARÁ EL REGISTRO DE FACTURA Y SE GENERARÁ UN ARCHIVO PDF EL CUAL PUEDE
                    DESCARGAR DESDE GESTION DE CARTERA, ¿DESEA CONTINUAR?</h6>
                </div>
              </div>

              <div class="row text-center">
                <div class="col-md-12">
                  <button class="btn btn-outline-success btn-saveFacture" type="button">CONTINUAR</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="row p-4 text-center">
        <div class="col-md-12">
          <h6 class="text-muted">PARA ACCEDER A ESTE MODULO DEBE SELECCIONAR UN ESTADO DE CUENTA EN EL
            MODULO
            <b>FINANCIERO</b>, DANDO CLIC EN EL BOTON DE <b>FACTURAR</b>
          </h6>
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
  </script>
@endsection
