@extends('modules.humans')

@section('humans')
<div class="col-md-12 card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">FICHA DE AUTORIZADO/A:</h6>
      </div>
      <div class="col-md-6">
        <a href="{{ url()->previous() }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER A LA TABLA GENERAL</a>
      </div>
    </div>
  </div>
  <div class="card-body col-md-12">
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="{{ asset('storage/authorized/'.$authorized->autPhoto) }}" class="img-thumbnail" style="width: 150px; height: auto;" alt="{{ asset('storage/authorized/'.$authorized->autPhoto) }}"><br>
        <small class="text-muted"><b>{{ $authorized->autFirstname . ' ' . $authorized->autLastname }}</b></small><br>
        <small class="text-muted"><b>{{ $authorized->type }}</b></small><br>
        <small class="text-muted"><b>N° {{ $authorized->autNumberdocument }}</b></small><br>
        <small class="text-muted">TEL/S: <b>{{ $authorized->autPhoneone . ' ' . $authorized->autPhonetwo }}</b></small><br>
        <small class="text-muted">PARENTESCO: <b>{{ $authorized->autRelationship }}</b></small><br>
        <small class="text-muted"><b>{{ $authorized->autObservations }}</b></small><br>
      </div>
    </div>
  </div>
</div>
@endsection