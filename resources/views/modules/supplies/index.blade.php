@extends('modules.services')

@section('services')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('supplie.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <input type="text" class="form-control my-2 form-control-sm" name="supConcept" placeholder="Concepto" required>
              <input type="number" max="1000000" class="form-control my-2 form-control-sm" name="supValue" placeholder="Valor" required>
            </div>
          </div>
          <div class="col-md-3 align-self-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de material escolar -->
      @if(session('SuccessSaveSupplie'))
      <div class="alert alert-success">
        {{ session('SuccessSaveSupplie') }}
      </div>
      @endif
      @if(session('SecondarySaveSupplie'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveSupplie') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de material escolar -->
      @if(session('PrimaryUpdateSupplie'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateSupplie') }}
      </div>
      @endif
      @if(session('SecondaryUpdateSupplie'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateSupplie') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de material escolar -->
      @if(session('WarningDeleteSupplie'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteSupplie') }}
      </div>
      @endif
      @if(session('SecondaryDeleteSupplie'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteSupplie') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tablesupplies" class="table table-hover text-center" width="100%">
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
      @foreach($supplies as $supplie)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $supplie->supConcept }}</td>
        <td>${{ $supplie->supValue }}</td>
        <td>
          <a href="{{ route('supplie.edit',$supplie->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <!--<a href="{{ route('supplie.delete',$supplie->id) }}" title="EDITAR" class="btn btn-outline-tertiary  edit-city" onclick="return confirm('¿Desea eliminar el concepto de material escolar y los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection