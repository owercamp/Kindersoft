@extends('modules.database')

@section('databases')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('profession.new') }}" method="PUT">
        @csrf
        <div class="row">
          <div class="col-md-8">
            <input type="text" class="form-control form-control-sm" name="title" placeholder="Nueva profesión" required>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-outline-success form-control-sm">CREAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de profesiones -->
      @if(session('SuccessSaveProfession'))
      <div class="alert alert-success">
        {{ session('SuccessSaveProfession') }}
      </div>
      @endif
      @if(session('SecondarySaveProfession'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveProfession') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de profesiones -->
      @if(session('PrimaryUpdateProfession'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateProfession') }}
      </div>
      @endif
      @if(session('SecondaryUpdateProfession'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateProfession') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de profesiones -->
      @if(session('WarningDeleteProfession'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteProfession') }}
      </div>
      @endif
      @if(session('SecondaryDeleteProfession'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteProfession') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableprofessions" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>TITULO</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($professions as $profession)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $profession->title }}</td>
        <td><a href="{{ route('profession.edit', $profession->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('profession.delete', $profession->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('- Se eliminará la profesión')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection