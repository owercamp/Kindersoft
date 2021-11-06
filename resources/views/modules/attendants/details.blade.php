@extends('modules.humans')

@section('humans')
<div class="row card">
  <div class="card-header">
    <div class="row text-center">
      <div class="col-md-6">
        <h6 class="text-muted">FICHA DE ACUDIENTE: <b>{{ $attendant->threename }} {{ $attendant->fourname }}, {{ $attendant->firstname }}</b></h6>
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
              @if($document->id == $attendant->typedocument_id)
              <input class="form-control form-control-sm" disabled value="{{ $document->type }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">NUMERO DE DOCUMENTO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->numberdocument }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">NOMBRES:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->firstname }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <small class="text-muted">APELLIDOS:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->threename }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">TIPO DE SANGRE:</small>
              @foreach($bloodtypes as $bloodtype)
              @if($bloodtype->id == $attendant->bloodtype_id)
              <input class="form-control form-control-sm" disabled value="{{ $bloodtype->group }} {{ $bloodtype->type }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">GENERO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->gender }}">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 border-left">
        <div class="form-group">
          <small class="text-muted">CIUDAD:</small>
          @foreach($citys as $city)
          @if($city->id == $attendant->cityhome_id)
          <input class="form-control form-control-sm" disabled value="{{ $city->name }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">LOCALIDAD:</small>
              @foreach($locations as $location)
              @if($location->id == $attendant->locationhome_id)
              <input class="form-control form-control-sm" disabled value="{{ $location->name }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">BARRIO:</small>
              @foreach($districts as $district)
              @if($district->id == $attendant->dictricthome_id)
              <input class="form-control form-control-sm" disabled value="{{ $district->name }}">
              @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">DIRECCION:</small>
          <input class="form-control form-control-sm" disabled value="{{ $attendant->address }}">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 1:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->phoneone }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">TELEFONO 2:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->phonetwo }}">
            </div>
            <div class="col-md-4">
              <small class="text-muted">WHATSAPP:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->whatsapp }}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row border-top">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 1:</small>
          <input class="form-control form-control-sm" disabled value="{{ $attendant->emailone }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CORREO ELECTRONICO 2:</small>
          <input class="form-control form-control-sm" disabled value="{{ $attendant->emailtwo }}">
        </div>
      </div>
    </div>
    <div class="row border-top">
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">PROFESION:</small>
          @foreach($professions as $profession)
          @if($profession->id == $attendant->profession_id)
          <input class="form-control form-control-sm" disabled value="{{ $profession->title }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <small for="company" class="text-muted">EMPRESA DONDE TRABAJA:</small>
          <input class="form-control form-control-sm" disabled value="{{ $attendant->company }}">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <small for="position" class="text-muted">CARGO:</small>
              <input class="form-control form-control-sm" disabled value="{{ $attendant->position }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small for="dateInitial" class="text-muted">FECHA DE INICIO:</small>
              <input class="form-control form-control-sm" name="antiquity" disabled value="{{ $attendant->antiquity }}">
            </div>
            <div class="col-md-6">
              <small for="dateInitial" class="text-muted">ANTIGUEDAD EN AÑOS:</small>
              <input type="text" name="antiquity_years" class="form-control form-control-sm text-center" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <small class="text-muted">CIUDAD DE EMPRESA:</small>
          @foreach($citys as $city)
          @if($city->id == $attendant->citycompany_id)
          <input class="form-control form-control-sm" disabled value="{{ $city->name }}">
          @endif
          @endforeach
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <small class="text-muted">LOCALIDAD DE EMPRESA:</small>
              @foreach($locations as $location)
              @if($location->id == $attendant->locationcompany_id)
              <input class="form-control form-control-sm" disabled value="{{ $location->name }}">
              @endif
              @endforeach
            </div>
            <div class="col-md-6">
              <small class="text-muted">BARRIO DE EMPRESA:</small>
              @foreach($districts as $district)
              @if($district->id == $attendant->dictrictcompany_id)
              <input class="form-control form-control-sm" disabled value="{{ $district->name }}">
              @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="form-group">
          <small class="text-muted">DIRECCIÓN DE EMPRESA:</small>
          <input class="form-control form-control-sm" disabled value="{{ $attendant->addresscompany }}">
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    var dateAntiquity = $('input[name=antiquity]').val();
    calculateYears(dateAntiquity);
  });

  function calculateYears(date) {
    if (!date) {
      $('input[name=antiquity_years]').val('No se registra fecha de inicio');
    } else {
      let dayNow = new Date();
      let dateAntiquity = new Date(date);
      let year = dayNow.getFullYear();
      let dateAnti = dateAntiquity.getFullYear();
      let diff = year - dateAnti;
      $('input[name=antiquity_years]').val(("00" + diff).slice(-2) + " años");
    }
  }
</script>
@endsection