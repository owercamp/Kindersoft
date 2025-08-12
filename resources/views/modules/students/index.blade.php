@extends('modules.humans')

@section('humans')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <!-- Mensajes de actualizacion de estudiantes -->
      @if(session('PrimaryUpdateStudent'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateStudent') }}
      </div>
      @endif
      @if(session('SecondaryUpdateStudent'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateStudent') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de estudiantes -->
      @if(session('WarningDeleteStudent'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteStudent') }}
      </div>
      @endif
      @if(session('SecondaryDeleteStudent'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteStudent') }}
      </div>
      @endif
    </div>
    <div class="col-md-6">
      <a href="{{ route('student.new') }}" class="btn btn-outline-success mx-5 my-2 form-control-sm">REGISTRAR ALUMNO</a>
    </div>
  </div>
  <table id="tablestudents" class="table table-hover text-center">
    <thead>
      <tr>
        <th>DOCUMENTO</th>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>EDAD</th>
        <th>GENERO</th>
        <th>SALUD</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $student)
      @if ($student->status == "ACTIVO")
      <tr>
        <td>{{ $student->numberdocument }}</td>
        <td>{{ $student->threename }} {{ $student->fourname }}</td>
        <td>{{ $student->firstname }}</td>
        <td>{{ $student->yearsold }}</td>
        <td>{{ $student->gender }}</td>
        <td>{{ $student->additionalHealt }}</td>
        <td class="d-flex justify-content-between">
          <a href="{{ route('student.details', $student->id) }}" title="VER DETALLES" class="btn btn-outline-success rounded-circle"><i class="fas fa-eye"></i></a>
          <a href="{{ route('student.edit', $student->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <a href="{{route('student.active', $student->id)}}" title="ACTIVO" class="btn btn-outline-success rounded-circle"><i class="fa fa-check-circle"></i></a>
          <!--<a href="{{ route('student.delete', $student->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary " onclick="return confirm('* Se eliminará el alumno con los registros relacionados')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @else
      <tr>
        <td class="text-muted">{{ $student->numberdocument }}</td>
        <td class="text-muted">{{ $student->threename }} {{ $student->fourname }}</td>
        <td class="text-muted">{{ $student->firstname }}</td>
        <td class="text-muted">{{ $student->yearsold }}</td>
        <td class="text-muted">{{ $student->gender }}</td>
        <td class="text-muted">{{ $student->additionalHealt }}</td>
        <td class="d-flex justify-content-between">
          <a href="{{ route('student.details', $student->id) }}" title="VER DETALLES" class="btn btn-outline-success rounded-circle"><i class="fas fa-eye"></i></a>
          <a href="{{ route('student.edit', $student->id) }}" title="EDITAR" class="btn btn-outline-primary rounded-circle"><i class="fas fa-edit"></i></a>
          <a href="{{route('student.inactive', $student->id)}}" title="INACTIVO" class="btn btn-outline-secondary rounded-circle"><i class="fa fa-ban"></i></a>
          <!--<a href="{{ route('student.delete', $student->id) }}" title="ELIMINAR" class="btn btn-outline-tertiary " onclick="return confirm('* Se eliminará el alumno con los registros relacionados')"><i class="fas fa-trash-alt"></i></a>-->
        </td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>
@endsection