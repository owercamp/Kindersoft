@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">FICHA DE PERSONAL: <b>{{ $collaborator->threename }} {{ $collaborator->fourname }}, {{ $collaborator->firstname }}</b></h6>
      </div>
      <div class="col-md-6">
        <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER A LA TABLA GENERAL</a>
      </div>
    </div>
  </div>
  <div class="card-body col-md-12">
    <div class="row">
      <div class="col-md-6 border-right">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">TIPO DE DOCUMENTO:</small>
              @foreach($documents as $document)
              @if($document->id == $collaborator->typedocument_id)
              <input class="form-control form-control-sm" disabled value="{{ $document->type }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">NUMERO DE DOCUMENTO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->numberdocument }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">NOMBRES:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->firstname }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">PRIMER APELLIDO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->threename }}">
            </div>
            <div class="col-md-6">
              <small class="text-muted">SEGUNDO APELLIDO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->fourname }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <img src="{{ asset('storage/collaborators/'.$collaborator->photo) }}" class="img-thumbnail" alt="Foto" style="width: 150px; height: auto;">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">TIPO DE SANGRE:</small>
              @foreach($bloodtypes as $bloodtype)
              @if($bloodtype->id == $collaborator->bloodtype_id)
              <input class="form-control form-control-sm" disabled value="{{ $bloodtype->group }} {{ $bloodtype->type }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">GENERO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->gender }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">PROFESION:</small>
          @foreach($professions as $profession)
          @if($profession->id == $collaborator->profession_id)
          <input class="form-control form-control-sm" disabled value="{{ $profession->title }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">CARGO:</small>
              <input type="text" name="position_edit" class="form-control form-control-sm" value="{{ $collaborator->position }}" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 border-left">
        <div class="form-group">
          <small class="text-muted">CIUDAD:</small>
          @foreach($citys as $city)
          @if($city->id == $collaborator->cityhome_id)
          <input class="form-control form-control-sm" disabled value="{{ $city->name }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">LOCALIDAD:</small>
              @foreach($locations as $location)
              @if($location->id == $collaborator->locationhome_id)
              <input class="form-control form-control-sm" disabled value="{{ $location->name }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">BARRIO:</small>
              @foreach($districts as $district)
              @if($district->id == $collaborator->dictricthome_id)
              <input class="form-control form-control-sm" disabled value="{{ $district->name }}">
              @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">DIRECCION:</small>
          <input class="form-control form-control-sm" disabled value="{{ $collaborator->address }}">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 1:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->phoneone }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 2:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->phonetwo }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">WHATSAPP:</small>
              <input class="form-control form-control-sm" disabled value="{{ $collaborator->whatsapp }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 1:</small>
          <input class="form-control form-control-sm" disabled value="{{ $collaborator->emailone }}">
        </div>
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 2:</small>
          <input class="form-control form-control-sm" disabled value="{{ $collaborator->emailtwo }}">
        </div>
        @if($collaborator->firm != null)
        <div class="form-group">
          <small class="text-muted">FIRMA DIGITAL:</small>
          <img src="{{ asset('storage/firms/'.$collaborator->firm) }}" class="img-thumbnail" alt="Firma" style="width: 150px; height: auto;">
        </div>
        @else
        <div class="form-group">
          <small class="text-muted">FIRMA DIGITAL:</small>
          <h6 class="text-muted">SIN FIRMA DIGITAL</h6>
        </div>
        @endif
      </div>

    </div>
  </div>
</div>

@endsection