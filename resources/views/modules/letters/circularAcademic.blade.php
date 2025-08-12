@extends('modules.circulars')

@section('logisticModules')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12 text-center">
      <!-- Mensajes de circulares academicas -->
      @if(session('SuccessCircularacademic'))
      <div class="alert alert-success">
        {{ session('SuccessCircularacademic') }}
      </div>
      @endif
      @if(session('SecondaryCircularacademic'))
      <div class="alert alert-secondary">
        {{ session('SecondaryCircularacademic') }}
      </div>
      @endif
    </div>
  </div>
  @php $datenow = Date('Y-m-d') @endphp
  <form action="{{ route('circularacademic.pdf') }}" method="GET" class="mt-4">
    @csrf
    <div class="row">
      <div class="col-md-12 text-center">
        <h4>CIRCULAR ACADEMICA</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">FECHA:</small>
          <input type="text" name="cirDate" class="form-control form-control-sm datepicker" value="{{ $datenow }}" required>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <!-- VACIO -->
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <small class="text-muted">CIRCULAR N°:</small>
          <input type="text" name="cirNumber" class="form-control form-control-sm" maxlength="5" value="{{ $numbernext }}" readonly required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">SEÑORES:</small>
          <input type="text" name="cirTo" maxlength="100" class="form-control form-control-sm" placeholder="RECEPTOR" required>
        </div>
      </div>
      <div class="col-md-6">
        <!-- VACIO -->
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <small class="text-muted">CUERPO:</small>
          <select name="cirBody_id" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un cuerpo...</option>
            @foreach($bodys as $body)
            <option value="{{ $body->bcId }}">{{ $body->bcName }}</option>
            @endforeach
          </select>
          <textarea class="form-control form-control-sm" type="text" name="cirBody" placeholder="Mensaje" readonly required></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CORDIAL SALUDO,</small>
          <select name="cirFrom" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un emisor...</option>
            @foreach($collaborators as $collaborator)
            <option value="{{ $collaborator->id }}">{{ $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <button type="submit" class="btn btn-outline-tertiary  form-control-sm my-3 btnDownload">GENERAR CIRCULAR</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    // $('input[type=progress]').attr('style', 'width:0%;');
  });

  $('select[name=cirBody_id]').on('change', function(e) {
    var selected = e.target.value;
    if (selected != '') {
      $.get("{{ route('getBodyselected') }}", {
        body_id: selected
      }, function(objectBody) {
        if (objectBody != null) {
          $('textarea[name=cirBody]').val(objectBody['bcDescription']);
        } else {
          $('textarea[name=cirBody]').val('');
        }
      });
    } else {
      $('textarea[name=cirBody]').val('');
    }
  });

  $('.btnDownload').on('click', function(e) {
    // e.preventDefault();
    // if($(this).submit()){
    // 	var numbernow = $('input[name=cirNumber]').val();
    // 	var next = parseInt(numbernow) + 1;
    // 	$('input[name=cirNumber]').val(getCompletesNumber(next));
    // }
    // e.preventDefault();
    // var numbernow = $('input[name=cirNumber]').val();
    // var next = parseInt(numbernow) + 1;
    // $('input[name=cirNumber]').val(getCompletesNumber(next));
    // // RESETEAR FORMULARIO
    // $('input[name=cirTo]').val('');
    // $('select[name=cirBody_id]').val('');
    // $('textarea[name=cirBody]').val('');
    // $('select[name=cirFrom]').val('');
  });

  //FUNCION PARA RETORNAR SIGUIENTE NUMERO DE CIRCULAR CON LOS CEROS
  function getCompletesNumber(number) {
    var len = number.toString().length;
    console.log('LONGITUD: ' + len);
    switch (len) {
      case 1:
        return '0000' + number;
        break;
      case 2:
        return '000' + number;
        break;
      case 3:
        return '00' + number;
        break;
      case 4:
        return '0' + number;
        break;
      case 5:
        return number;
        break;
      default:
        return number;
        break;
    }
  }


  $('input').on('keyup', function() {
    progress();
  });

  function progress() {
    $('input[type=progress]').attr('max', 100 + '%');
    var count = 0;
    var total = $('.letter input').length + $('.letter textarea').length;
    $('.letter input').each(function() {
      var value = $(this).val();
      if (value != '') {
        count++;
      }
    });
    $('.letter textarea').each(function() {
      var value = $(this).val();
      if (value != '') {
        count++;
      }
    });
    var newValue = (count * 100) / total;
    $('input[type=progress]').attr('style', 'width:' + newValue + '%;');
    if (newValue < 100) {
      $('input[type=progress]').removeClass('bg-success');
      $('input[type=progress]').addClass('bg-warning');
      $('input[type=progress]').val('INCOMPLETO');
      $('.btnDownload').css('display', 'none');
    } else {
      $('input[type=progress]').removeClass('bg-warning');
      $('input[type=progress]').addClass('bg-success');
      $('input[type=progress]').val('COMPLETO');
      $('.btnDownload').css('display', 'block');
    }
  }
</script>
@endsection