@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">MODIFICACION DE AUTORIZADO/A: <br><b>{{ $authorized->autLastname }}, {{ $authorized->autFirstname }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('authorized') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form action="{{ route('authorized.update', $authorized->autId) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">

        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE DOCUMENTO: *</small>
                <select class="form-control form-control-sm" name="autDocument_id" required>
                  <option value="">Seleccione identificación...</option>
                  @php $namedocument = '' @endphp
                  @foreach($documents as $document)
                  @if($document->id == $authorized->autDocument_id)
                  @php $namedocument = $document->type @endphp
                  <option value="{{ $document->id }}" selected="selected">{{ $document->type }}</option>
                  @else
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO:</small>
                <input type="number" name="autNumberdocument" class="form-control form-control-sm" required value="{{ $authorized->autNumberdocument }}">
                <small class="text-muted">Actualmente es <b>{{ $authorized->autNumberdocument }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">NOMBRE/S:</small>
                <input type="text" name="autFirstname" class="form-control form-control-sm" value="{{ $authorized->autFirstname }}" required>
                <small class="text-muted">Actualmente es <b>{{ $authorized->autFirstname }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">APELLIDO/S:</small>
                <input type="text" name="autLastname" class="form-control form-control-sm" value="{{ $authorized->autLastname }}" required>
                <small class="text-muted">Actualmente es <b>{{ $authorized->autLastname }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">PARENTESCO:</small>
                <input type="text" name="autRelationship" class="form-control form-control-sm" value="{{ $authorized->autRelationship }}" required>
                <small class="text-muted">Actualmente es <b>{{ $authorized->autRelationship }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <small class="text-muted">FOTO ACTUAL:</small><br>
            <input type="hidden" name="photo_hidden" class="form-control form-control-sm" value="{{ $authorized->autPhoto }}" required>
            <img class="img-thumbnail" src="{{ asset('storage/authorized/'.$authorized->autPhoto) }}" style="width: 150px; height: auto;">
          </div>
        </div><!-- Fin panel izquierdo superior -->

        <div class="col-md-6 border-left">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TELEFONO 1:</small>
                <input type="number" name="autPhoneone" class="form-control form-control-sm" required value="{{ $authorized->autPhoneone }}">
                <small class="text-muted">Actualmente es <b>{{ $authorized->autPhoneone }}</b></small>
              </div>
              <div class="col-md-6">
                <small class="text-muted">TELEFONO 2:</small>
                <input type="number" name="autPhonetwo" class="form-control form-control-sm" value="{{ $authorized->autPhonetwo }}">
                <small class="text-muted">Actualmente es <b>{{ $authorized->autPhonetwo }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">OBSERVACIONES:</small>
                <textarea type="number" name="autObservations" class="form-control form-control-sm text-left" style="min-height: 200px;">
                {{ $authorized->autObservations }}
                </textarea>
                <small class="text-muted">Actualmente es <b>{{ $authorized->autObservations }}</b></small>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <small class="text-muted">CAMBIAR FOTO:</small>
            <div class="custom-file">
              <input type="file" name="autPhoto" lang="es" title="Unicamente con extensión .jpg .jpeg o .png" accept="image/jpg,image/jpeg,image/png">
            </div>
          </div>
        </div><!-- Fin panel derecho superior -->
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <button type="submit" id="saveAuthorized" class="btn btn-outline-primary form-control-sm">GUARDAR CAMBIOS</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection