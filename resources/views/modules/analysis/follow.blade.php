@extends('modules.analysis')

@section('financialModules')
<div class="col-md-12">
  <div class="row mt-5">
    <div class="col-md-12">
      <h4>SEGUIMIENTO MENSUAL</h4>
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
    </div>
  </div>
  <div class="row p-2 border">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <small class="text-muted">AÑO:</small>
            <select name="fYear" class="form-control form-control-sm select2" required>
              <option value="">Seleccione...</option>
              <option value="{{ $yearbeforeThree }}">{{ $yearbeforeThree }}</option>
              <option value="{{ $yearbeforeTwo }}">{{ $yearbeforeTwo }}</option>
              <option value="{{ $yearbeforeOne }}">{{ $yearbeforeOne }}</option>
              <option value="{{ $yearnow }}">{{ $yearnow }}</option>
              <option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
              <option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
              <option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
              <option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
            </select>
          </div>
          <div class="form-group">
            <small class="text-muted">MES:</small>
            <select name="fMount" class="form-control form-control-sm select2" required>
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
          </div>
          <div class="form-group">
            <small class="text-muted">ESTRUCTURA DE COSTO:</small>
            <select name="fCoststructure" class="form-control form-control-sm select2" required>
              <option value="">Seleccione una estructura de costo...</option>
              @foreach($structures as $structure)
              <option value="{{ $structure->csId }}">{{ $structure->csDescription }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <small class="text-muted">DESCRIPCION DE COSTO:</small>
            <select name="fCostdescription" class="form-control form-control-sm select2" required>
              <option value="">Seleccione una descripción de costo...</option>
              <!-- rows dinamics -->
            </select>
          </div>
          <button type="button" class="btn btn-outline-success text-rigth form-control form-control-sm btn-query">CONSULTAR</button>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row text-center">
        <div class="col-md-12 text-center">
          <center>
            <div class="spinner-border" align="center" role="status">
              <span class="sr-only" align="center">Procesando...</span>
            </div>
          </center>
        </div>
      </div>
      <div class="row resultQuery" style="display: none;">
        <div class="col-md-12">
          <div class="form-group">
            <small>AÑO:</small>
            <h6 class="resultYear"></h6>
            <small>MES:</small>
            <h6 class="resultMount"></h6>
            <small>ESTRUCTURA DE COSTO:</small>
            <h6 class="resultStructure"></h6>
            <small>DESCRIPCION DE COSTO:</small>
            <h6 class="resultDescription"></h6>
            <small>VALOR DE PRESUPUESTO:</small>
            <h6 class="resultBudgetvalue"></h6>
            <small>VALOR EJECUTADO:</small>
            <h6 class="resultVouchersvalue"></h6>
            <small>PORCENTAJE EJECUTADO:</small>
            <h6 class="resultPorcentage"></h6>
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
    $('.spinner-border').css('display', 'none');
  });

  $('select[name=fCoststructure]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $.get("{{ route('getCostdescriptions') }}", {
        idCoststructure: selected
      }, function(objectCostdescriptions) {
        var count = Object.keys(objectCostdescriptions).length;
        $('select[name=fCostdescription]').empty();
        $('select[name=fCostdescription]').append("<option value=''>Seleccione una descripción  de costo...</option>");
        if (count > 0) {
          for (var i = 0; i < count; i++) {
            $('select[name=fCostdescription]').append(
              "<option value='" + objectCostdescriptions[i]['cdId'] + "'>" +
              objectCostdescriptions[i]['cdDescription'] +
              "</option>"
            );
          }
        }
      });
    } else {
      $('select[name=fCostdescription]').empty();
      $('select[name=fCostdescription]').append("<option value=''>Seleccione una descripción  de costo...</option>");
    }
  });

  $('.btn-query').on('click', function() {
    var year = $('select[name=fYear]').val();
    var mount = $('select[name=fMount]').val();
    var coststructure = $('select[name=fCoststructure]').val();
    var namestructure = $('select[name=fCoststructure] option:selected').text();
    var costdescription = $('select[name=fCostdescription]').val();
    var namedescription = $('select[name=fCostdescription] option:selected').text();
    if (year != '' && mount != '' && coststructure != '' && costdescription != '') {
      $('.spinner-border').css('display', 'block');
      $('.resultQuery').css('display', 'none');
      $.get(
        "{{ route('getFollowYearMount') }}", {
          year: year,
          mount: mount,
          coststructure: coststructure,
          costdescription: costdescription
        },
        function(objectQuery) {
          var count = Object.keys(objectQuery).length;
          if (count > 0) {
            console.log(objectQuery);
            $('.resultYear').text(year);
            $('.resultMount').text(getStringMount(mount));
            $('.resultStructure').text(namestructure);
            $('.resultDescription').text(namedescription);
            $('.resultBudgetvalue').text('$' + objectQuery[0]);
            $('.resultVouchersvalue').text('$' + objectQuery[1]);
            $('.resultPorcentage').text(objectQuery[2]);
          } else {
            $('.resultYear').text('Sin resultado');
            $('.resultMount').text(getStringMount('Sin resultado'));
            $('.resultStructure').text('Sin resultado');
            $('.resultDescription').text('Sin resultado');
            $('.resultBudgetvalue').text('Sin resultado');
            $('.resultVouchersvalue').text('Sin resultado');
            $('.resultPorcentage').text('Sin resultado');
          }
          setTimeout(function() {
            $('.spinner-border').css('display', 'none');
            $('.resultQuery').css('display', 'block');
          }, 500);
        });
    }

  });

  function getStringMount(mount) {
    switch (mount) {
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