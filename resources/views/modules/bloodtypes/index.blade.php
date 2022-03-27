@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('bloodtype.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <select class="form-control my-2 form-control-sm select2" name="group" required>
              <option value="">Seleccione grupo...</option>
              <option value="AB">AB</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="O">O</option>
              <option value="NO REPORTADA">NO REPORTADA</option>
            </select>
          </div>
          <div class="col-md-6">
            <select class="form-control my-2 form-control-sm select2" name="type" required>
              <option value="">Seleccion tipo...</option>
              <option value="POSITIVO">POSITIVO</option>
              <option value="NEGATIVO">NEGATIVO</option>
            </select>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-outline-success my-2 form-control-sm">CREAR</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de grupos sanguineos -->
      @if(session('SuccessSaveBloodtype'))
      <div class="alert alert-success">
        {{ session('SuccessSaveBloodtype') }}
      </div>
      @endif
      @if(session('SecondarySaveBloodtype'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveBloodtype') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de grupos sanguineos -->
      @if(session('PrimaryUpdateBloodtype'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateBloodtype') }}
      </div>
      @endif
      @if(session('SecondaryUpdateBloodtype'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateBloodtype') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de grupos sanguineos -->
      @if(session('WarningDeleteBloodtype'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteBloodtype') }}
      </div>
      @endif
      @if(session('SecondaryDeleteBloodtype'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteBloodtype') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablebloodtypes" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>GRUPO</th>
        <th>TIPO</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($bloodtypes as $bloodtype)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $bloodtype->group }}</td>
        <td>{{ $bloodtype->type }}</td>
        <!--<td><a href="{{ route('bloodtype.edit', $bloodtype->id) }}">Editar</a></td>-->
        <td><a href="{{ route('bloodtype.delete', $bloodtype->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('- Se borrará el grupo sanguineo')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });

  $('select[name=group]').on('change', function(e) {
    var value = e.target.value;
    if (value == 'NO REPORTADA') {
      $('select[name=type]').attr('required', false);
      $('select[name=type]').attr('disabled', true);
      $('select[name=type]').val('');
    } else {
      $('select[name=type]').attr('required', true);
      $('select[name=type]').attr('disabled', false);
      $('select[name=type]').val('');
    }
  });
</script>
@endsection