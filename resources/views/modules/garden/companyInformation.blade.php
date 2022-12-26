@extends('modules.menuFinancial')

@section('financialModules')
<div class="container-lg container-md container-sm">
  <div class="text-center">
    <h4 class="mt-3">DATOS DE JARDIN: </h4><br>
    @if($garden != null || $garden != '')
    <small class="text-muted">LOGO: </small><br>
    <img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/'.$garden->garNamelogo) }}"><br>
    @if($garden->garCode == 'defaultcode.png')
    <small class="text-muted">CODIGO QR: </small><br>
    <h6>NO HAY CODIGO QR</h6>
    @else
    <small class="text-muted">CODIGO QR: </small><br>
    <img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/'.$garden->garCode) }}"><br>
    @endif
    @php asset(storage_path() . '/' . $garden->garNamelogo) @endphp
    <small class="text-muted">RAZON SOCIAL: </small>
    <h6>{{ $garden->garReasonsocial }}</h6>
    <small class="text-muted">NOMBRE COMERCIAL: </small>
    <h6>{{ $garden->garNamecomercial }}</h6>
    <small class="text-muted">NIT: </small>
    <h6>{{ $garden->garNit }}</h6>
    <small class="text-muted">CIUDAD: </small>
    <h6>{{ $garden->nameCity }}</h6>
    <small class="text-muted">LOCALIDAD: </small>
    <h6>{{ $garden->nameLocation }}</h6>
    <small class="text-muted">BARRIO: </small>
    <h6>{{ $garden->nameDistrict }}</h6>
    <small class="text-muted">DIRECCION: </small>
    <h6>{{ $garden->garAddress }}</h6>
    <small class="text-muted">CELULAR / WHATSAPP: </small>
    <h6>{{ $garden->garPhone . ' / ' . $garden->garWhatsapp }}</h6>
    <small class="text-muted">TELEFONOS: </small>
    <h6>{{ $garden->garPhoneone . ' - ' . $garden->garPhonetwo . ' - ' . $garden->garPhonethree }}</h6>
    <small class="text-muted">WEB: </small>
    <h6>{{ $garden->garWebsite }}</h6>
    <small class="text-muted">CORREOS: </small>
    <h6>{{ $garden->garMailone . ' - ' . $garden->garMailtwo }}</h6>
    <small class="text-muted">REPRESENTANTE LEGAL: </small>
    <h6>{{ $garden->garNamerepresentative . ' C.C N° ' . $garden->garCardrepresentative }}</h6>
    <small class="text-muted">FIRMA DE REPRESENTANTE: </small><br>
    @if($garden->garFirm == null)
    <h6>SIN FIRMA DIGITAL</h6>
    @else
    <img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/firm/'.$garden->garFirm) }}"><br>
    @endif
    <small class="text-muted">TESTIGO DE CONTRATOS: </small>
    @if($garden->garNamewitness == null && $garden->garCardwitness == null)
    <h6>SIN TESTIGO</h6>
    @else
    <h6>{{ $garden->garNamewitness . ' C.C N° ' . $garden->garCardwitness }}</h6>
    @endif
    <small class="text-muted">FIRMA DE TESTIGO: </small><br>
    @if($garden->garFirmwitness == null)
    <h6>SIN FIRMA DE TESTIGO</h6>
    @else
    <img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/firm/'.$garden->garFirmwitness) }}"><br>
    @endif
    @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
    <a href="#" class="btn btn-outline-success form-control-sm m-4 updateGarden-link">
      <span hidden>{{ $garden->garLocation_id }}</span> <!-- Se guarda id de localizacion para que se seleccione el select al abrir modal de actualización -->
      <span hidden>{{ $garden->garDistrict_id }}</span> <!-- Se guarda id de barrio para que se seleccione el select al abrir modal de actualización -->
      ACTUALIZAR DATOS DEL JARDIN
    </a>
    @endhasanyrole
    @else
    @hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
    <span class="text-muted">No existe ningun dato creado del jardin, De clic en configurar para crear los datos</span>
    <a href="#" class="btn btn-outline-success form-control-sm m-4 newGarden-link">
      CONFIGURAR DATOS DE JARDIN
    </a>
    @endhasanyrole
    @endif
  </div>
</div>
@endsection