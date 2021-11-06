@extends('modules.services')

@section('services')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('admission.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <input type="text" class="form-control my-2 form-control-sm" name="admConcept" placeholder="Concepto" required>
              <input type="number" max="1000000" class="form-control my-2 form-control-sm" name="admValue" placeholder="Valor" required>
            </div>
          </div>
          <div class="col-md-3 align-self-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de admisiones -->
      @if(session('SuccessSaveAdmission'))
      <div class="alert alert-success">
        {{ session('SuccessSaveAdmission') }}
      </div>
      @endif
      @if(session('SecondarySaveAdmission'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAdmission') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de admisiones -->
      @if(session('PrimaryUpdateAdmission'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAdmission') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAdmission'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAdmission') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de admisiones -->
      @if(session('WarningDeleteAdmission'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAdmission') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAdmission'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAdmission') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tableadmissions" class="table table-hover text-center" width="100%">
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
      @foreach($admissions as $admission)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $admission->admConcept }}</td>
        <td>${{ $admission->admValue }}</td>
        <td>
          <a href="{{ route('admission.edit',$admission->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <!--<a href="{{ route('admission.delete',$admission->id) }}" title="EDITAR" class="btn btn-outline-tertiary  edit-city" onclick="return confirm('¿Desea eliminar el concepto de admisión y los regitros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection