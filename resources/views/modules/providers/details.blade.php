@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">FICHA DE PROVEEDOR: <b>{{ $provider->namecompany }}</b></h6>
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
          <small class="text-muted">TIPO DE DOCUMENTO:</small>
          @foreach($documents as $document)
          @if($document->id == $provider->typedocument_id)
          <input class="form-control form-control-sm" disabled value="{{ $document->type }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">NUMERO DE DOCUMENTO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $provider->numberdocument }}">
            </div>
            <div class="col-md-6">
              <small class="text-muted">VERIFICACION:</small>
              <input class="form-control form-control-sm" disabled value="{{ $provider->numbercheck }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">RAZON SOCIAL:</small>
          <input class="form-control form-control-sm" disabled value="{{ $provider->namecompany }}">
        </div>
      </div>
      <div class="col-md-6 border-left">
        <div class="form-group">
          <small class="text-muted">CIUDAD:</small>
          @foreach($citys as $city)
          @if($city->id == $provider->cityhome_id)
          <input class="form-control form-control-sm" disabled value="{{ $city->name }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">LOCALIDAD:</small>
              @foreach($locations as $location)
              @if($location->id == $provider->locationhome_id)
              <input class="form-control form-control-sm" disabled value="{{ $location->name }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">BARRIO:</small>
              @foreach($districts as $district)
              @if($district->id == $provider->dictricthome_id)
              <input class="form-control form-control-sm" disabled value="{{ $district->name }}">
              @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">DIRECCION:</small>
          <input class="form-control form-control-sm" disabled value="{{ $provider->address }}">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 1:</small>
              <input class="form-control form-control-sm" disabled value="{{ $provider->phoneone }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 2:</small>
              <input class="form-control form-control-sm" disabled value="{{ $provider->phonetwo }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">WHATSAPP:</small>
              <input class="form-control form-control-sm" disabled value="{{ $provider->whatsapp }}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row border-top">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 1:</small>
          <input class="form-control form-control-sm" disabled value="{{ $provider->emailone }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 2:</small>
          <input class="form-control form-control-sm" disabled value="{{ $provider->emailtwo }}">
        </div>
      </div>
    </div>
  </div>
</div>

@endsection