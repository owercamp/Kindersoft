@extends('modules.database')

@section('databases')
<div class="row col-md-12">
  <div class="card col-md-12">
    <div class="card-header">
      <div class="form-inline">
        <div class="form-group">
          <small class="text-muted mx-2 my-2">MODIFICACION DE ROL:</small>
          <input class="form-control mx-2 my-2" type="text" name="rol" value="{{ $role->name }}" id="rol" disabled="disabled">
          <small class="label-control mx-2 my-2" for="checkRol">Editar nombre del rol</small>
          <input class="form-control mx-2 my-2" type="checkbox" name="checkRol" id="checkRol">
          <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  mx-2 my-2">Volver</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 border-right">
          Permisos
        </div>
        <div class="col-md-6 border-left">
          Roles
        </div>
      </div>
    </div>
    <div class="card-footer">
      <a href="#" class="btn btn-outline-primary">Guardar cambios</a>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
  $(document).ready(function() {
    $('#checkRol').removeAttr('checked');

    var valueOriginal = $('#rol').val();

    $('#checkRol').on('change', function() {

      if ($('#checkRol').is(':checked')) {
        $('#rol').removeAttr('disabled');
        $('#rol').attr('required', 'required');
      } else {
        $('#rol').attr('disabled', 'disabled');
        $('#rol').val(valueOriginal);
        $('#rol').attr('required', false);
      }
    });

  });
</script>
@endsection