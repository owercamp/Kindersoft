@extends('modules.services')

@section('services')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <form action="{{ route('transport.new') }}" method="PUT">
        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm my-2" name="traConcept" placeholder="Concepto" required>
              <input type="number" max="1000000" class="form-control form-control-sm my-2" name="traValue" placeholder="Valor" required>
            </div>
          </div>
          <div class="col-md-3 align-self-center">
            <button type="submit" class="btn btn-outline-success form-control-sm">REGISTRAR</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creación de transporte -->
      @if(session('SuccessSaveTransport'))
      <div class="alert alert-success">
        {{ session('SuccessSaveTransport') }}
      </div>
      @endif
      @if(session('SecondarySaveTransport'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveTransport') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de transporte -->
      @if(session('PrimaryUpdateTransport'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateTransport') }}
      </div>
      @endif
      @if(session('SecondaryUpdateTransport'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateTransport') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de transporte -->
      @if(session('WarningDeleteTransport'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteTransport') }}
      </div>
      @endif
      @if(session('SecondaryDeleteTransport'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteTransport') }}
      </div>
      @endif
    </div>
  </div>
  <table id="tabletransports" class="table table-hover text-center" width="100%">
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
      @foreach($transports as $transport)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $transport->traConcept }}</td>
        <td>${{ $transport->traValue }}</td>
        <td>
          <a href="{{ route('transport.edit',$transport->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <!--<a href="{{ route('transport.delete',$transport->id) }}" title="EDITAR" class="btn btn-outline-tertiary  edit-city" onclick="return confirm('¿Desea eliminar el concepto de transporte y los registros relacionados?')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection