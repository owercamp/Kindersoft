@extends('modules.circulars')

@section('logisticModules')

<div class="container">
  <div class="w-100 rounded text-center">
    @if(session('ErrorCircular'))
    <div class="alert alert-danger" role="alert">
      {{ session('ErrorCircular') }}
    </div>
    @endif
    @if(session('DeleteCircular'))
    <div class="alert alert-secondary" role="alertdialog">
      {{ session('DeleteCircular') }}
    </div>
    @endif
  </div>
  <table id="tableDatatable" class=" table table-striped w-100 text-center justify-content-center">
    <thead>
      <tr>
        <th>#</th>
        <th>N° CIRCULAR</th>
        <th>FECHA</th>
        <th>COLABORADOR</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $row= 1; @endphp
      @foreach($lists as $list)
      <tr>
        <td>{{ $row++ }}</td>
        <td>{{ $list->acf_cirNumber}}</td>
        <td>{{ $list->acf_cirDate }}</td>
        <td>{{ $list->firstname }} {{ $list->threename }} {{ $list->fourname }}</td>
        <td>
          <button class="btn btn-outline-primary" onclick="view('{{ $list->acf_id }}')"><i class="fas fa-eye"></i></button>
          <button class="btn btn-outline-danger" data-toggle="modal" data-target="#ModalCircular" onclick="del('{{ $list->acf_id }}')"><i class="far fa-trash-alt"></i></button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div hidden>
  <form action="{{ route('circularacademic.view') }}" method="POST" id="formCircular">
    @csrf
    <input type="text" name="circular_id">
  </form>
</div>

<div class="modal fade" id="ModalCircular" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminación Circular</h5>
        <button type="button" class="Close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid m-auto">
          <div class="d-flex justify-content-center">
            <p class="w-50 text-right pr-1">N° de la Circular: </p>
            <p id="NCircular" class="w-50 text-left pl-1"></p>
          </div>
          <div class="d-flex justify-content-center">
            <p class="w-50 text-right pr-1">Fecha: </p>
            <p id="FechaC" class="w-50 text-left pl-1"></p>
          </div>
          <div class="d-flex justify-content-center">
            <p class="w-50 text-right pr-1">Colaborador: </p>
            <p id="CollaboratorC" class="w-50 text-left pl-1"></p>
          </div>
        </div>
      </div>
      <form action="{{ route('circularacademic.delete') }}" id="deleteCircular" method="POST" hidden>
        @csrf
        <input type="text" name="circularDelete">
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="clearForm()">Cancelar</button>
        <button type="button" class="btn btn-outline-danger" onclick="formDel()">Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function view(id) {
    $('input[name=circular_id]').val(id);
    $('#formCircular').submit();
  }

  function del(id) {
    $('input[name=circularDelete]').val(id);
    $.get("{{route('getCircularDel')}}", {
      data: id
    }, function(objectDel) {
      $('#NCircular').text(objectDel['acf_cirNumber']);
      $('#FechaC').text(objectDel['acf_cirDate']);
      $('#CollaboratorC').text(objectDel['firstname'] + ' ' + objectDel['threename']);
    });
  }

  function formDel() {
    $('#deleteCircular').submit();
  }

  function clearForm() {
    $('#NCircular').empty();
    $('#FechaC').empty();
    $('#CollaboratorC').empty();
  }
</script>
@endsection