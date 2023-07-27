@extends('modules.menuFinancial')

@section('financialModules')
<div class="container">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h3>INFORMACION GENERAL</h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de informacion general -->
      @if(session('SuccessSaveGeneral'))
      <div class="alert alert-success">
        {{ session('SuccessSaveGeneral') }}
      </div>
      @endif
      @if(session('SecondarySaveGeneral'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveGeneral') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de informacion general -->
      @if(session('PrimaryUpdateGeneral'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateGeneral') }}
      </div>
      @endif
      @if(session('SecondaryUpdateGeneral'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateGeneral') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de informacion general -->
      @if(session('WarningDeleteGeneral'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteGeneral') }}
      </div>
      @endif
      @if(session('SecondaryDeleteGeneral'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteGeneral') }}
      </div>
      @endif
      <div class="alert message-general">
        <!-- Mensajes -->
      </div>
    </div>
  </div>
  <div class="row border-bottom pb-3">
    <form action="{{ route('general.save') }}" method="GET" class="col-md-6 border-right" autocomplete="off">
      @csrf
      <div class="row text-center p-3">
        <div class="col-md-12">
          <h6 class="text-muted p-2">FORMULARIO DE INFORMACION GENERAL</h6>
          @if(isset($general))
          <input type="hidden" name="fgId" class="form-control form-control-sm" value="{{ $general->fgId }}" readonly required>
          @else
          <input type="hidden" name="fgId" class="form-control form-control-sm" readonly>
          @endif
        </div>
      </div>
      <div class="form-group form-inline">
        <small class="text-muted mr-3">REGIMEN IVA:</small>
        <select name="fgRegime" class="form-control form-control-sm" required>
          <option value="">Seleccione un regimen...</option>
          <option value="COMUN">COMUN</option>
          <option value="SIMPLIFICADO">SIMPLIFICADO</option>
          <option value="ESPECIAL">ESPECIAL</option>
        </select>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group form-inline">
            <small class="text-muted mr-3">¿SOMOS GRANDES CONTRIBUYENTES?:</small>
            <small class="text-muted mr-3">
              <input type="radio" name="fgTaxpayer" class="form-control form-control-sm" value="NO" checked>
              NO
            </small>
            <small class="text-muted mr-3">
              <input type="radio" name="fgTaxpayer" class="form-control form-control-sm" value="SI">
              SI
            </small>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group form-inline">
            <small class="text-muted mr-3">¿SOMOS AUTORETENEDORES?:</small>
            <small class="text-muted mr-3">
              <input type="radio" name="fgAutoretainer" class="form-control form-control-sm" value="NO" checked>
              NO
            </small>
            <small class="text-muted mr-3">
              <input type="radio" name="fgAutoretainer" class="form-control form-control-sm" value="SI">
              SI
            </small>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted mr-3">ACTIVIDADES ECONOMICAS:</small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <input type="number" name="fgActivityOne" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000" required>
            </div>
            <div class="col-md-3">
              <input type="number" name="fgActivityTwo" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000">
            </div>
            <div class="col-md-3">
              <input type="number" name="fgActivityThree" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000">
            </div>
            <div class="col-md-3">
              <input type="number" name="fgActivityFour" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-2">
        <small class="text-muted mr-3">RESOLUCION DE FACTURACION:</small>
        <input type="text" name="fgResolution" class="form-control form-control-sm text-center" maxlength="25" placeholder="0000000000000000000000000" required>
      </div>
      <div class="row">
        <div class="col-md-6 text-right">
          <div class="form-group mt-1">
            <small class="text-muted">FECHA DE RESOLUCION:</small>
          </div>
          <div class="form-group mt-4">
            <small class="text-muted">MESES DE VIGENCIA:</small>
          </div>
          <div class="form-group mt-4">
            <small class="text-muted">FECHA DE VENCIMIENTO:</small>
          </div>
          <div class="form-group mt-4">
            <small class="text-muted">PREFIJO AUTORIZADO:</small>
          </div>
          <div class="form-group mt-4">
            <small class="text-muted">NUMERACION AUTORIZADA:</small>
          </div>
        </div>
        <div class="col-md-6 text-left">
          <div class="form-group">
            <input type="text" name="fgDateresolution" class="form-control form-control-sm text-center datepicker" required>
          </div>
          <div class="form-group">
            <input type="text" name="fgMountactive" class="form-control form-control-sm text-center" placeholder="00" maxlength="2" pattern="[0-9]{1,2}" required>
          </div>
          <div class="form-group">
            <input type="text" name="fgDatefallresolution" class="form-control form-control-sm text-center" readonly required>
          </div>
          <div class="form-group">
            <input type="text" name="fgPrefix" class="form-control form-control-sm text-center" placeholder="Ej: UH67G6" maxlength="6" pattern="[A-Z0-9]{1,6}">
          </div>
          <div class="row">
            <div class="col-md-5">
              <input type="text" name="fgNumerationsince" class="form-control form-control-sm text-center" width="100" placeholder="0000" maxlength="4" pattern="[0-9]{1,4}" required>
            </div>
            <div class="col-md-2">
              <small class="text-muted">A</small>
            </div>
            <div class="col-md-5">
              <input type="text" name="fgNumerationuntil" class="form-control form-control-sm text-center" width="100" placeholder="0000" maxlength="4" pattern="[0-9]{1,4}" required>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-2">
        <small class="text-muted mr-3">ENTIDAD BANCARIA:</small>
        <input type="text" name="fgBank" class="form-control form-control-sm" maxlength="30" required>
      </div>
      <div class="form-group form-inline">
        <small class="text-muted mr-3">TIPO DE CUENTA:</small>
        <select name="fgAccounttype" class="form-control form-control-sm" required>
          <option value="">Seleccione una cuenta...</option>
          <option value="AHORROS">AHORROS</option>
          <option value="CORRIENTE">CORRIENTE</option>
          <option value="RECAUDO">RECAUDO</option>
          <option value="FIDUCIA">FIDUCIA</option>
        </select>
      </div>
      <div class="form-group mt-2">
        <small class="text-muted mr-3">NUMERO DE CUENTA:</small>
        <input type="text" name="fgNumberaccount" class="form-control form-control-sm text-center" maxlength="30" placeholder="0000000000000000000000000" required>
      </div>
      <div class="form-group mt-2">
        <small class="text-muted mr-3">NOTAS ADICIONALES:</small>
        <textarea type="text" name="fgNotes" class="form-control form-control-sm" maxlength="500" placeholder="Máximo de 500 caracteres alfanuméricos" required></textarea>
      </div>
      <div class="row text-center">
        <div class="col-md-12">
          @if(isset($general))
          <button type="submit" class="btn btn-outline-success">ACTUALIZAR INFORMACION GENERAL</button>
          @else
          <button type="submit" class="btn btn-outline-success">GUARDAR INFORMACION GENERAL</button>
          @endif
        </div>
      </div>
    </form>
    <!-- INFORMACION ACTUAL -->
    <div class="col-md-6 border-left text-center">
      <div class="row border-top border-bottom p-3">
        <form action="{{ route('general.numberinitial') }}" method="GET" class="col-md-12" autocomplete="off">
          @csrf
          <div class="row text-center p-3">
            <div class="col-md-12">
              <h6 class="text-muted p-2">FORMULARIO DE NUMERACION</h6>
              @if(isset($numeration))
              <input type="hidden" name="niId" class="form-control form-control-sm" value="{{ $numeration->niId }}" readonly required>
              @else
              <input type="hidden" name="niId" class="form-control form-control-sm" readonly>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h6 class="text-muted p-2">NUMEROS INICIALES</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-right">
              <div class="form-group mt-1">
                <small class="text-muted">FACTURA DE VENTA:</small>
              </div>
              <div class="form-group mt-4">
                <small class="text-muted">COMPROBANTE DE INGRESO:</small>
              </div>
              <div class="form-group mt-4">
                <small class="text-muted">COMPROBANTE DE EGRESO:</small>
              </div>
            </div>
            <div class="col-md-6 text-left">
              <div class="form-group">
                <input type="text" name="fgNumberinitialFacture" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000" pattern="[0-9]{1,4}" required>
              </div>
              <div class="form-group">
                <input type="text" name="fgNumberinitialVoucherentry" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000" pattern="[0-9]{1,4}" required>
              </div>
              <div class="form-group">
                <input type="text" name="fgNumberinitialVoucheregress" class="form-control form-control-sm text-center" maxlength="4" placeholder="0000" pattern="[0-9]{1,4}" required>
              </div>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-md-12">
              @if(isset($numeration))
              <button type="submit" class="btn btn-outline-success">ACTUALIZAR NUMEROS INICIALES</button>
              @else
              <button type="submit" class="btn btn-outline-success">GUARDAR NUMEROS INICIALES</button>
              @endif
            </div>
          </div>
        </form>
      </div>
      <div class="row border-top p-3">
        <div class="col-md-12 text-left" style="background: rgba(128,128,128,0.2);">
          <h6 class="text-muted p-3">INFORMACION GENERAL</h6>
          <div class="row border-bottom" style="min-height: 200px;">
            <div class="col-md-12">
              @if(isset($general))
              <div class="form-group">
                <small class="text-muted mr-3">REGIMEN IVA: </small><br>
                <b class="fgRegime-info">{{ $general->fgRegime }}</b><br>
                <small class="text-muted mr-3">CONTRIBUYENTES: </small><br>
                <b class="fgTaxpayer-info">{{ $general->fgTaxpayer }}</b><br>
                <small class="text-muted mr-3">RETENEDORES: </small><br>
                <b class="fgAutoretainer-info">{{ $general->fgAutoretainer }}</b><br>
                <small class="text-muted mr-3">ACTIVIDAD ECONOMICA: </small><br>
                <b class="fgActivityOne-info">{{ $general->fgActivityOne }}</b> -
                <b class="fgActivityTwo-info">
                  @if(isset($general->fgActivityTwo) && $general->fgActivityTwo != '')
                  {{ $general->fgActivityTwo }}
                  @else
                  {{ __('N/A') }}
                  @endif
                </b>
                -
                <b class="fgActivityThree-info">
                  @if(isset($general->fgActivityThree) && $general->fgActivityThree != '')
                  {{ $general->fgActivityThree }}
                  @else
                  {{ __('N/A') }}
                  @endif
                </b>
                -
                <b class="fgActivityFour-info">
                  @if(isset($general->fgActivityFour) && $general->fgActivityFour != '')
                  {{ $general->fgActivityFour }}
                  @else
                  {{ __('N/A') }}
                  @endif
                </b>
                <br>
                <small class="text-muted mr-3">RESOLUCION DE FACTURACION: </small><br>
                <b class="fgResolution-info">{{ $general->fgResolution }}</b><br>
                <small class="text-muted mr-3">FECHA DE RESOLUCION: </small><br>
                <b class="fgDateresolution-info">{{ $general->fgDateresolution }}</b><br>
                <small class="text-muted mr-3">MESES DE VIGENCIA: </small><br>
                <b class="fgMountactive-info">{{ $general->fgMountactive }}</b><br>
                <small class="text-muted mr-3">FECHA DE VENCIMIENTO: </small><br>
                <b class="fgDatefallresolution-info">{{ $general->fgDatefallresolution }}</b><br>
                <small class="text-muted mr-3">PREFIJO AUTORIZADO: </small><br>
                <b class="fgPrefix-info">{{ $general->fgPrefix }}</b><br>
                <small class="text-muted mr-3">NUMERACION AUTORIZADA: </small><br>
                DESDE: <b class="fgNumerationsince-info mr-4">{{ $general->fgNumerationsince }}</b> HASTA: <b class="fgNumerationuntil-info">{{ $general->fgNumerationuntil }}</b><br>
                <small class="text-muted mr-3">BANCO: </small><br>
                <b class="fgBank-info">{{ $general->fgBank }}</b><br>
                <small class="text-muted mr-3">TIPO DE CUENTA: </small><br>
                <b class="fgAccounttype-info">{{ $general->fgAccounttype }}</b><br>
                <small class="text-muted mr-3">NUMERO DE CUENTA: </small><br>
                <b class="fgNumberaccount-info">{{ $general->fgNumberaccount }}</b><br>
                <small class="text-muted mr-3">NOTAS ADICIONALES: </small><br>
                <b class="fgNotes-info">{{ $general->fgNotes }}</b><br>
              </div>
              @else
              <div class="form-group text-center">
                <h5 class="text-muted">Actualmente no existe información</h5>
              </div>
              @endif
            </div>
          </div>
          <div class="row border-top p-3" style="min-height: 200px;">
            <div class="col-md-12">
              <div class="form-group p-3">
                <h6>NUMEROS INICIALES</h6>
              </div>
              @if(isset($numeration))
              <div class="form-group">
                <small class="text-muted mr-3">FACTURA: </small><br>
                <b class="fgNumberinitialFacture-info">{{ $numeration->niFacture }}</b><br>
                <small class="text-muted mr-3">COMPROBANTE DE INGRESO: </small><br>
                <b class="fgNumberinitialVoucherentry-info">{{ $numeration->niVoucherentry }}</b><br>
                <small class="text-muted mr-3">COMPROBANTE DE EGRESO: </small><br>
                <b class="fgNumberinitialVoucheregress-info">{{ $numeration->niVoucheregress }}</b><br>
              </div>
              @else
              <div class="form-group text-center">
                <h5 class="text-muted">Actualmente no existe numeración</h5>
              </div>
              @endif
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

  $('input[name=fgDateresolution]').on('change', ':input', function(e) {
    var date = e.target.value;
    var mount = $('input[name=fgMountactive]').val();
    if (date != '' && mount != '') {
      console.log('FECHA: ' + date + ', MESES: ' + mount);
      var dateResult = new Date(date);
      var totalDays = 31 * parseInt(mount);
      var timeAdd = totalDays * 86400;
      dateResult.setSeconds(timeAdd);
      var dateComplete = dateResult.getFullYear() + "-" + getMount(dateResult.getMonth() + 1) + "-" + getDay(dateResult.getDate());
      $('input[name=fgDatefallresolution]').val('');
      $('input[name=fgDatefallresolution]').val(dateComplete);
    }
  });

  $('input[name=fgMountactive]').on('keyup', function(e) {
    var mount = e.target.value;
    var date = $('input[name=fgDateresolution]').val();
    if (mount != '' && date != '') {
      console.log('FECHA: ' + date + ', MESES: ' + mount);
      var dateResult = new Date(date);
      var totalDays = 31 * parseInt(mount);
      var timeAdd = totalDays * 86400;
      dateResult.setSeconds(timeAdd);
      var dateComplete = dateResult.getFullYear() + "-" + getMount(dateResult.getMonth() + 1) + "-" + getDay(dateResult.getDate());
      $('input[name=fgDatefallresolution]').val('');
      $('input[name=fgDatefallresolution]').val(dateComplete);
    }
  });

  function getMount($numberMount) {
    return ($numberMount < 10 ? '0' : '') + $numberMount;
  }

  function getDay($numberDay) {
    return ($numberDay < 10 ? '0' : '') + $numberDay;
  }
</script>
@endsection