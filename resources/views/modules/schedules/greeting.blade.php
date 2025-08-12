@extends('modules.schedules')

@section('scheduleModules')
<div class="w-100 mr-2 ml-2">
  <div class="w-100 m-2 p-2 row">
    <div class="col-md-6">
      PLANTILLAS DE SALUDO
    </div>
    <div class="col-md-6">
      @if (session('SuccessCreation'))
      <div class="alert alert-success">
        {{session('SuccessCreation')}}
      </div>
      @endif
      @if (session('SecondaryCreation'))
      <div class="alert alert-secondary">
        {{session('SecondaryCreation')}}
      </div>
      @endif
      @if (session('PrimaryCreation'))
      <div class="alert alert-info">
        {{session('PrimaryCreation')}}
      </div>
      @endif
      @if (session('WarningCreation'))
      <div class="alert alert-danger">
        {{session('WarningCreation')}}
      </div>
      @endif
    </div>
  </div>
  <div class="container border border-secondary p-2 w-50">
    <form action="{{route('greeting.save')}}" method="post" class="row w-100">
      @csrf
      <div class="col-12 ml-3">
        <div class="row ml-1 d-flex justify-content-between mr-1">
          <div class="form-group mt-2">
            <small>N° PLANTILLA: </small>
            <strong class="greetingNumber">0</strong>
          </div>
          <div class="mt-1">
            <button type="submit" class="btn btn-outline-success"><strong>Guardar</strong></button>
          </div>
        </div>
        <div class="form-group">
          <small>SALUDO</small>
          <textarea name="greetingText" cols="30" rows="5" id="greetingText" class="form-control form-control-sm" required></textarea>
        </div>
      </div>
    </form>
  </div>
  <hr>
  <div class="container">
    <table id="tableperiods" class="table table-hover text-center table-striped" style="width: 100%">
      <thead>
        <tr>
          <th>N° PLANTILLA</th>
          <th>SALUDO PLANTILLA</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $item)
        <tr>
          <td>{{$item->sch_id}}</td>
          <td>{{$item->sch_body}}</td>
          <td class="d-flex justify-content-center">
            <button title="EDITAR" class="btn btn-outline-primary rounded-circle edit-hi" data-toggle="modal" data-target="#formEdit" style="margin-right: 5px"><i class="fas fa-edit"></i><span hidden>{{$item->sch_id}}</span>
              <span hidden>{{$item->sch_body}}</span></button>
            <button title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  delete-hi" data-toggle="modal" data-target="#formDelete" style="margin-left: 5px"><i class="fas fa-trash-alt"></i><span hidden>{{$item->sch_id}}</span>
              <span hidden>{{$item->sch_body}}</span></button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- formulario de edición --}}
  <div class="modal fade" id="formEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLongTitle">EDITAR PLANTILLA</h5>
        </div>
        <div class="modal-body">
          <form action="{{route('greeting.edit')}}" method="post" class="row w-100 Hiform">
            @csrf
            <div class="col-12 ml-3">
              <div class="row ml-1 d-flex justify-content-between mr-1">
                <div class="form-group mt-2">
                  <small>N° PLANTILLA: </small>
                  <strong class="greetingNumberEdit">0</strong>
                  <input type="hidden" name="greetingNumberEdit">
                </div>
              </div>
              <div class="form-group">
                <small>SALUDO</small>
                <textarea name="greetingTextEdit" id="greetingTextEdit" cols="30" rows="5" class="form-control form-control-sm" required></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-tertiary " data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-outline-success">Actualizar</button>
        </div>
      </div>
    </div>
  </div>

  {{-- formulario de eliminación --}}
  <div class="modal fade" id="formDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLongTitle">ELIMINAR PLANTILLA</h5>
        </div>
        <div class="modal-body">
          <form action="{{route('greeting.delete')}}" method="post" class="row w-100 Delform">
            @csrf
            <div class="col-12 ml-3">
              <div class="row ml-1 d-flex justify-content-between mr-1">
                <div class="form-group mt-2">
                  <small>N° PLANTILLA: </small>
                  <strong class="greetingNumberDelete">0</strong>
                  <input type="hidden" name="greetingNumberDelete">
                </div>
              </div>
              <div class="form-group">
                <small>SALUDO</small>
                <pre class="form-control form-control-sm greetingTextDelete"></pre>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-outline-secondary delform">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $("#greetingText").emojioneArea({
      template: "<filters/><tabs/><editor/>"
    });

    $("#greetingTextEdit").emojioneArea({
      template: "<filters/><tabs/><editor/>"
    });
  });
</script>

<script>
  $('.delform').click(function(e) {
    e.preventDefault();
    let status = confirm('¿Desea eliminar el saludo?');
    if (status == true) {
      $('.Delform').submit();
    }
  });
  $('.btn btn-outline-success').click(function(e) {
    e.preventDefault();
    $('.Hiform').submit();
  });

  $('textarea[name=greetingText]').focus(function() {
    $.get("{{route('getNumberGreeting')}}",
      function(objectNumber) {
        console.log(objectNumber);
        let {
          sch_id
        } = objectNumber;
        let val = 1;
        if (sch_id == undefined) {
          $('.greetingNumber').text(val);
        } else {
          val = sch_id + 1;
          $('.greetingNumber').text(val);
        }
      }
    );
  });

  $('.edit-hi').click(function(e) {
    e.preventDefault();
    let id, body;
    id = $(this).find('span:nth-child(2)').text();
    body = $(this).find('span:nth-child(3)').text();
    $('.greetingNumberEdit').text(id);
    $('input[name=greetingNumberEdit]').val(id);
    $('textarea[name=greetingTextEdit]').val(body);
  });

  $('.delete-hi').click(function(e) {
    e.preventDefault();
    let id, body;
    id = $(this).find('span:nth-child(2)').text();
    body = $(this).find('span:nth-child(3)').text();
    $('.greetingNumberDelete').text(id);
    $('input[name=greetingNumberDelete]').val(id);
    $('.greetingTextDelete').text(body);
  });
</script>
@endsection