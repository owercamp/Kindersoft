@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">REGISTRAR NUEVO AUTORIZADO</h6>
      </div>
      <div class="col-md-6">
        <a href="{{ route('authorized') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
      </div>
    </div>
  </div>
  <form id="formNewAttendant" action="{{ route('authorized.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body col-md-12">
      <div class="row">
        <div class="col-md-6 border-right">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TIPO DE DOCUMENTO: *</small>
                <select class="form-control form-control-sm" name="autDocument_id" required value="{{ old('autDocument_id') }}">
                  <option value="">Seleccione tipo...</option>
                  @foreach($documents as $document)
                  <option value="{{ $document->id }}">{{ $document->type }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <small class="text-muted">NÚMERO DE DOCUMENTO:</small>
                <input type="number" name="autNumberdocument" class="form-control form-control-sm" required value="{{ old('autNumberdocument') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">NOMBRE/S:</small>
                <input type="text" name="autFirstname" class="form-control form-control-sm" required value="{{ old('autFirstname') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">APELLIDO/S:</small>
                <input type="text" name="autLastname" class="form-control form-control-sm" required value="{{ old('autLastname') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">PARENTESCO</small>
                <input class="form-control form-control-sm" name="autRelationship" required value="{{ old('autRelationship') }}">
              </div>
            </div>
          </div>
        </div><!-- fin panel izquierdo 1 -->


        <div class="col-md-6 border-left">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">TELEFONO 1:</small>
                <input type="number" name="autPhoneone" class="form-control form-control-sm" required value="{{ old('phoneone') }}">
              </div>
              <div class="col-md-6">
                <small class="text-muted">TELEFONO 2:</small>
                <input type="number" name="autPhonetwo" class="form-control form-control-sm" value="{{ old('phonetwo') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">OBSERVACIONES:</small>
                <textarea type="number" name="autObservations" class="form-control form-control-sm" value="{{ old('phonetwo') }}"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <small class="text-muted">FOTO DE AUTORIZADO:</small>
                <div class="custom-file">
                  <input type="file" name="autPhoto" lang="es" placeholder="Unicamente con extensión .jpg .jpeg o .png" accept="image/jpg,image/jpeg,image/png">
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin panel derecho 1 -->
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <button id="saveAuthorized" type="submit" class="btn btn-outline-success form-control-sm">GUARDAR AUTORIZADO</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection