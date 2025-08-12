@extends('modules.humans')

@section('humans')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de proveedores -->
      @if(session('PrimaryUpdateProvider'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateProvider') }}
      </div>
      @endif
      @if(session('SecondaryUpdateProvider'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateProvider') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de proveedores -->
      @if(session('WarningDeleteProvider'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteProvider') }}
      </div>
      @endif
      @if(session('SecondaryDeleteProvider'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteProvider') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="{{ route('provider.new') }}" class="btn btn-outline-success mx-5 my-2 form-control-sm">REGISTRAR PROVEEDOR</a>
    </div>
  </div>
  <table id="tableproviders" class="table table-hover text-center">
    <thead>
      <tr>
        <th>DOCUMENTO</th>
        <th>NOMBRE</th>
        <th>DIRECCION</th>
        <th>TELEFONO</th>
        <th>CORREO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody style="font-size: .85rem">
      @foreach($providers as $provider)
      <tr>
        <td>{{ $provider->numberdocument }}{{ "-" . $provider->numbercheck }}</td>
        <td>{{ $provider->namecompany }}</td>
        <td>{{ $provider->address }}</td>
        <td>{{ $provider->phoneone }}</td>
        <td>{{ $provider->emailone }}</td>
        <td class="d-flex justify-content-between">
          <a href="{{ route('provider.details', $provider->id) }}" title="VER DETALLES" class="btn btn-outline-success rounded-circle"><i class="fas fa-eye"></i></a>
          <a href="{{ route('provider.edit', $provider->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <a href="{{ route('provider.delete', $provider->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle " onclick="return confirm('* Se eliminará el proveedor')"><i class="fas fa-trash-alt"></i></a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection