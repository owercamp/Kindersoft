@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('intelligence.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <small class="text-muted">INTELIGENCIA:</small>
            <input type="text" class="form-control mb-2 form-control-sm" name="type" placeholder="Inteligencia" required>
          </div>
          <div class="col-md-6">
            <small class="text-muted">DESCRIPCIÓN:</small>
            <input type="text" class="form-control mb-2 form-control-sm" name="description" placeholder="Descripción" required>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-outline-success mb-2 form-control-sm">CREAR</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de inteligencias -->
      @if(session('SuccessSaveIntelligence'))
      <div class="alert alert-success">
        {{ session('SuccessSaveIntelligence') }}
      </div>
      @endif
      @if(session('SecondarySaveIntelligence'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveIntelligence') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de inteligencias -->
      @if(session('PrimaryUpdateIntelligence'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateIntelligence') }}
      </div>
      @endif
      @if(session('SecondaryUpdateIntelligence'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateIntelligence') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de inteligencias -->
      @if(session('WarningDeleteIntelligence'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteIntelligence') }}
      </div>
      @endif
      @if(session('SecondaryDeleteIntelligence'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteIntelligence') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableintelligences" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($intelligences as $intelligence)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $intelligence->type }}</td>
        <td>{{ $intelligence->description }}</td>
        <td><a href="{{ route('intelligence.edit', $intelligence->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('intelligence.delete', $intelligence->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('Si borra esta inteligencia, tambien se eliminarán los logros asociados. ¿Desea borrar la inteligencia con sus logros?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection