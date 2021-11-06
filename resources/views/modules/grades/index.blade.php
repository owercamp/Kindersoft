@extends('modules.academic')

@section('academics')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('grade.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <input type="text" class="form-control mb-4 form-control-sm" name="name" placeholder="Nombre de grado" required>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-outline-success form-control-sm">CREAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de grados -->
      @if(session('SuccessSaveGrade'))
      <div class="alert alert-success">
        {{ session('SuccessSaveGrade') }}
      </div>
      @endif
      @if(session('SecondarySaveGrade'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveGrade') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de grados -->
      @if(session('PrimaryUpdateGrade'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateGrade') }}
      </div>
      @endif
      @if(session('SecondaryUpdateGrade'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateGrade') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de grados -->
      @if(session('WarningDeleteGrade'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteGrade') }}
      </div>
      @endif
      @if(session('SecondaryDeleteGrade'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteGrade') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablegrades" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>NOMBRE</th>
        <th colspan="2">ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($grades as $grade)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $grade->name }}</td>
        <td><a href="{{ route('grade.edit', $grade->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a></td>
        <td><a href="{{ route('grade.delete', $grade->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('Si borra este grado, se eliminarán los cursos relacionados. ¿Desea borrar el grado?')"><i class="fas fa-trash-alt"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
@endsection