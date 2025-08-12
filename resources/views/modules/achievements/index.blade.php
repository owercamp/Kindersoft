@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('achievement.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-6">
            <select class="form-control mb-2 form-control-sm select2" name="intelligence_id" required>
              <option value="">Seleccione inteligencia...</option>
              @foreach($intelligences as $intelligence)
              <option value="{{ $intelligence->id }}">{{ $intelligence->type }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control mb-2 form-control-sm" name="name" placeholder="Nombre logro" value="{{ old('name') }}" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <textarea class="form-control mb-2 form-control-sm" name="description" placeholder="Descripción del logro" required value="{{ old('description') }}"></textarea>
          </div>
          <div class="col-md-6 justify-content-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">CREAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de logros -->
      @if(session('SuccessSaveAchievement'))
      <div class="alert alert-success">
        {{ session('SuccessSaveAchievement') }}
      </div>
      @endif
      @if(session('SecondarySaveAchievement'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAchievement') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de logros -->
      @if(session('PrimaryUpdateAchievement'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAchievement') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAchievement'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAchievement') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de logros -->
      @if(session('WarningDeleteAchievement'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAchievement') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAchievement'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAchievement') }}
      </div>
      @endif
      <form action="{{ route('achievement.importExcel') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <div class="form-group">
          <input type="file" name="excel" class="form-control form-control-sm" accept=".xlsx,.xls" required>
          <button type="submit" class="btn btn-outline-success form-control-sm">IMPORTAR DE EXCEL</button>
        </div>
      </form>
    </div>
  </div>
  <table id="tableachievements" class="table table-hover text-center" width="100%">
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
      @foreach($achievements as $achievement)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $achievement->name }}</td>
        <td>{{ $achievement->description }}</td>
        <td><a href="{{ route('achievement.edit', $achievement->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('achievement.delete', $achievement->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary  rounded-circle" onclick="return confirm('¿Desea borrar el logro?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection