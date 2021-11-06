@extends('modules.humans')

@section('humans')
<div class="col-md-12">
  <div class="row text-center border-bottom mb-4">
    <div class="col-md-6">
      <!-- Mensajes de creación de autorizados -->
      @if(session('SuccessSaveAuthorized'))
      <div class="alert alert-success">
        {{ session('SuccessSaveAuthorized') }}
      </div>
      @endif
      @if(session('SecondarySaveAuthorized'))
      <div class="alert alert-secondary">
        {{ session('SecondarySaveAuthorized') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de autorizados -->
      @if(session('PrimaryUpdateAuthorized'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateAuthorized') }}
      </div>
      @endif
      @if(session('SecondaryUpdateAuthorized'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateAuthorized') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de autorizados -->
      @if(session('WarningDeleteAuthorized'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteAuthorized') }}
      </div>
      @endif
      @if(session('SecondaryDeleteAuthorized'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteAuthorized') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="{{ route('authorized.new') }}" class="btn btn-outline-success mx-5 my-2 form-control-sm">REGISTRAR AUTORIZADO</a>
    </div>
  </div>
  <table id="tableattendants" class="table table-hover text-center">
    <thead>
      <tr>
        <th>DOCUMENTO</th>
        <th>NOMBRES</th>
        <th>PARENTESCO</th>
        <th>TELEFONO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($authorizeds as $authorized)
      @if ($authorized->status == "ACTIVO")
      <tr>
        <td>{{ $authorized->autNumberdocument }}</td>
        <td>{{ $authorized->autFirstname." ".$authorized->autLastname }}</td>
        <td>{{ $authorized->autRelationship }}</td>
        <td>{{ $authorized->autPhoneone }}</td>
        <td class="d-flex justify-content-around">
          <a href="{{ route('authorized.details', $authorized->autId) }}" title="VER DETALLES" class="btn btn-outline-success rounded-circle"><i class="fas fa-eye"></i></a>
          <a href="{{ route('authorized.edit', $authorized->autId) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <a href="{{route('authorized.active', $authorized->autId)}}" title="ACTIVO" class="btn btn-outline-success rounded-circle"><i class="fa fa-check-circle"></i></a>
          <!--<a href="{{ route('authorized.delete', $authorized->autId) }}" title="ELIMINAR" class="btn btn-outline-tertiary " onclick="return confirm('* Se eliminará el acudiente y los registro relacionados')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @else
      <tr>
        <td class="text-muted">{{ $authorized->autNumberdocument }}</td>
        <td class="text-muted">{{ $authorized->autFirstname." ".$authorized->autLastname }}</td>
        <td class="text-muted">{{ $authorized->autRelationship }}</td>
        <td class="text-muted">{{ $authorized->autPhoneone }}</td>
        <td class="d-flex justify-content-around">
          <a href="{{ route('authorized.details', $authorized->autId) }}" title="VER DETALLES" class="btn btn-outline-success"><i class="fas fa-eye"></i></a>
          <a href="{{ route('authorized.edit', $authorized->autId) }}" title="EDITAR" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
          <a href="{{route('authorized.inactive', $authorized->autId)}}" title="INACTIVO" class="btn btn-outline-secondary"><i class="fa fa-ban"></i></a>
          <!--<a href="{{ route('authorized.delete', $authorized->autId) }}" title="ELIMINAR" class="btn btn-outline-tertiary " onclick="return confirm('* Se eliminará el acudiente y los registro relacionados')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>
@endsection