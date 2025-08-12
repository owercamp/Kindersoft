@extends('modules.services')

@section('services')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('uniform.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <input type="text" class="form-control my-2 form-control-sm" name="uniConcept" placeholder="Concepto" required>
              <input type="number" max="1000000" class="form-control my-2 form-control-sm" name="uniValue" placeholder="Valor" required>
            </div>
          </div>
          <div class="col-md-3 align-self-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de uniformes -->
      @if(session('SuccessSaveUniform'))
      <div class="alert alert-success">
        {{ session('SuccessSaveUniform') }}
      </div>
      @endif
      @if(session('SecondarySaveUniform'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveUniform') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de uniformes -->
      @if(session('PrimaryUpdateUniform'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateUniform') }}
      </div>
      @endif
      @if(session('SecondaryUpdateUniform'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateUniform') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de uniformes -->
      @if(session('WarningDeleteUniform'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteUniform') }}
      </div>
      @endif
      @if(session('SecondaryDeleteUniform'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteUniform') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableuniforms" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>CONCEPTO</th>
        <th>VALOR</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 1 @endphp
      @foreach($uniforms as $uniform)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $uniform->uniConcept }}</td>
        <td>${{ $uniform->uniValue }}</td>
        <td>
          <a href="{{ route('uniform.edit',$uniform->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <!--<a href="{{ route('uniform.delete',$uniform->id) }}" title="EDITAR" class="btn btn-outline-tertiary  edit-city" onclick="return confirm('¿Desea eliminar el concepto de uniforme y los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection