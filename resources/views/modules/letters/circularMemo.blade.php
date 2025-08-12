@extends('modules.circulars')

@section('logisticModules')
<div class="col-md-12">
  <form action="{{ route('circularmemo.pdf') }}" method="GET">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <h4>MEMORANDO INTERNO</h4>
      </div>
      <div class="col-md-6">
        <button type="submit" class="btn btn-outline-tertiary  form-control-sm my-3 btnDownload" style="display: none;">DESCARGAR</button>
        <div class="alert message" style="display: none;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group progress checkprogress">
          <input type="progress" class="progress-bar progress-bar-striped bg-warning ml-2" readonly>
        </div>
      </div>
    </div>
    <div class="row letter border-left border-right border-top border-bottom">
      <div class="col-md-12">
        <p style="text-align: center;"><b>MEMORANDO INTERNO</b></p>
        <p><b>MEMORANDO N° </b><input class="form-control form-control-sm" type="text" name="cirNumber" placeholder="Código"></p>
        <p><b>FECHA: </b><input class="form-control form-control-sm" type="date" name="cirDate" placeholder="Fecha"></p>
        <p><b>SEÑORES: </b>
          <input class="form-control form-control-sm" type="text" name="cirTo" placeholder="Receptor">
        </p>
        <p><textarea class="form-control form-control-sm" type="text" name="cirBody" placeholder="Mensaje"></textarea></p>
        <p><b>CORDIAL SALUDO,</b>
          <input class="form-control form-control-sm" type="text" name="cirFrom" placeholder="Emisor">
        </p>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('input[type=progress]').attr('style', 'width:0%;');
  });

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