@extends('modules.accountants')

@section('financialModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>CONCILIACION DE SALDOS</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de conciliacion de saldos -->
      @if(session('SuccessSaveBalances'))
      <div class="alert alert-success">
        {{ session('SuccessSaveBalances') }}
      </div>
      @endif
      @if(session('SecondarySaveBalances'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveBalances') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  @php
  $yearnow = date('Y');
  $mountnow = date('m');
  $yearfutureOne = date('Y') + 1;
  $yearfutureTwo = date('Y') + 2;
  $yearfutureThree = date('Y') + 3;
  $yearfutureFour = date('Y') + 4;
  $yearfutureFive = date('Y') + 5;
  @endphp
  <div class="row border-top p-4">
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">AÑO:</small>
        <select name="yearSelected" class="form-control form-control-sm select2">
          <option value="">Seleccione...</option>
          <option value="{{ $yearnow }}">{{ $yearnow }}</option>
          <option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
          <option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
          <option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
          <option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
          <option value="{{ $yearfutureFive }}">{{ $yearfutureFive }}</option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <small class="text-muted">MES:</small>
        <select name="mountSelected" class="form-control form-control-sm select2">
          <option value="">Seleccione...</option>
          <option value="01">ENERO</option>
          <option value="02">FEBRERO</option>
          <option value="03">MARZO</option>
          <option value="04">ABRIL</option>
          <option value="05">MAYO</option>
          <option value="06">JUNIO</option>
          <option value="07">JULIO</option>
          <option value="08">AGOSTO</option>
          <option value="09">SEPTIEMBRE</option>
          <option value="10">OCTUBRE</option>
          <option value="11">NOVIEMBRE</option>
          <option value="12">DICIEMBRE</option>
        </select>
        <input type="hidden" name="mountnow" value="{{ $mountnow }}" class="form-control form-control-sm" disabled>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-md-12">
      <button type="button" class="btn btn-outline-success btnQueryBalance">CONSULTAR</button>
    </div>
  </div>
  <div class="row text-center bj-spinner">
    <div class="col-md-12">
      <div class="spinner-border" align="center" role="status">
        <span class="sr-only" align="center">Procesando...</span>
      </div>
    </div>
  </div>
  <div class="row p-3 border sectionBalance" style="display: none;">
    <div class="col-md-12">
      <div class="row border-bottom pb-1">
        <div class="col-md-4">
          <div class="form-group">
            <small class="text-muted">VALOR INGRESOS:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" maxlength="2" name="balValueentry" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <small class="text-muted">VALOR EGRESO:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" maxlength="2" name="balValueegress" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <small class="text-muted">VALOR SALDO:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" maxlength="2" name="balValuebalance" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top pt-1">
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">SALDO ANTERIOR:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" maxlength="2" name="previousValuebalance" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">SALDO DISPONIBLE:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" maxlength="2" name="valueAvailable" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top pt-1">
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">TOTAL IVA PAGADO:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" name="totalIvaPaid" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <small class="text-muted">TOTAL RETENCION REALIZADA:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-dollar-sign"></i>
                </span>
              </div>
              <input type="text" name="totalRetention" class="form-control form-control-sm text-center" disabled>
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
  var idAutorization = 0;
  $(function() {
    $('.bj-spinner').css('display', 'none');
  });

  $('.btnQueryBalance').on('click', function(e) {
    e.preventDefault();
    var year = $('select[name=yearSelected]').val();
    var mount = $('select[name=mountSelected]').val();
    if (year != '' && mount != '') {
      $.ajax({
        url: "{{ route('getBalances') }}",
        data: {
          year: year,
          mount: mount
        },
        beforeSend: function() {
          $('.bj-spinner').css('display', 'block');
          $('.sectionBalance').css('display', 'none');
        },
        success: function(objectBalances) {
          console.log(objectBalances);
          $('input[name=balValueentry]').val(new Intl.NumberFormat().format(objectBalances[0]));
          $('input[name=balValueegress]').val(new Intl.NumberFormat().format(objectBalances[1]));
          $('input[name=balValuebalance]').val(new Intl.NumberFormat().format(objectBalances[2]));
          $('input[name=previousValuebalance]').val(new Intl.NumberFormat().format(objectBalances[3]));
          $('input[name=valueAvailable]').val(new Intl.NumberFormat().format(objectBalances[4]));
          $('input[name=totalIvaPaid]').val(new Intl.NumberFormat().format(objectBalances[5]));
          $('input[name=totalRetention]').val(new Intl.NumberFormat().format(objectBalances[6]));
        }, //success
        complete: function() {
          $('.bj-spinner').css('display', 'none');
          $('.sectionBalance').css('display', 'block');
        }
      });
    } else {
      $('.sectionBalance').css('display', 'none');
    }
  });
</script>
@endsection