@extends('admissions')

@section('modulesAdmission')
<div class="row">
  <div class="col-md-12">
    <div class="row text-center border-bottom mb-4" style="font-size: 13px;">
      <div class="col-md-12">
        <!-- Mensajes de modificación de formularios -->
        @if(session('SuccessForm'))
        <div class="alert alert-success">
          {{ session('SuccessForm') }}
        </div>
        @endif
        <!-- Mensajes de errores de procesamiento de formularios -->
        @if(session('SecondaryForm'))
        <div class="alert alert-secondary">
          {{ session('SecondaryForm') }}
        </div>
        @endif
      </div>
    </div>
    <table id="tableDatatable" class="table table-hover text-center" width="100%">
      <thead>
        <tr>
          <th>NIÑO/NIÑA</th>
          <th>DOCUMENTO</th>
          <th>MESES DE GESTACION</th>
          <th>ACUDIENTE 1</th>
          <th>CONTACTO 1</th>
          <th>ACUDIENTE 2</th>
          <th>CONTACTO 2</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($forms as $form)
        <tr>
          <td>{{ $form->nombres . ' ' . $form->apellidos }}</td>
          <td>{{ $form->numerodocumento }}</td>
          <td>{{ $form->mesesgestacion }}</td>
          <td>{{ $form->nombreacudiente1 }}</td>
          <td>{{ $form->celularacudiente1 }}</td>
          <td>{{ $form->nombreacudiente2 }}</td>
          <td>{{ $form->celularacudiente2 }}</td>
          <td>
            <!-- @if($form->migracion === 0)
                        <a href="#" title="MIGRACION DE DATOS" class="bj-btn-table-edit form-control-sm migrationForm-link">
                            <i class="fas fa-copy"></i> -->
            <!-- migrationAdmission -->
            <!-- <span hidden>{{ $form->fmId }}</span>
                            <span hidden>{{ $form->nombres }}</span>
                            <span hidden>{{ $form->apellidos }}</span>
                            <span hidden>{{ $form->numerodocumento }}</span>
                            <span hidden>{{ $form->fechanacimiento }}</span>
                            <span hidden>{{ $form->direccionacudiente1 }}</span>
                            <span hidden>{{ $form->barrioacudiente1 }}</span>
                            <span hidden>{{ $form->localidadacudiente1 }}</span>
                            <span hidden>{{ $form->ciudadempresaacudiente1 }}</span>
                            <img hidden src="{{ asset('storage/admisiones/fotosaspirantes/'.$form->foto) }}">
                        </a>
                        @endif -->
            <form action="{{ route('pdfAdmission') }}" method="GET" style="display: inline-block;">
              @csrf
              <input type="hidden" name="fmId" value="{{ $form->fmId }}" class="form-control form-control-sm" required>
              <button type="submit" title="DESCARGAR PDF" class="bj-btn-table-delete form-control-sm">
                <i class="fas fa-file-pdf"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection