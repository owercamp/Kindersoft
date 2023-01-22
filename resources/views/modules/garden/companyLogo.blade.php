@extends('modules.menuFinancial')

@section('financialModules')
<div class="w-100 row">
  <div class="w-100">
    @include('layouts.partial.alerts')
  </div>
  <div class="col-6">
    <div id="carouselExampleCaptions" class="carousel slide w-100" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="4"></li>
      </ol>
      <div class="carousel-inner border border-dark">
        <div class="carousel-item active">
          <img src="{{ $logo }}" class="d-block w-100 bg-secondary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block text-dark" style="background-color: rgba(255, 255, 255, 0.6);">
            <h5 style="text-shadow: 1px 1px 1px black;">Logo Corporativo</h5>
            <p style="text-shadow: 1px 1px 1px black;">Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ $qr }}" class="d-block w-100 bg-tertiary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block text-dark" style="background-color: rgba(255, 255, 255, 0.6);">
            <h5 style="text-shadow: 1px 1px 1px black;">Codigo QR</h5>
            <p style="text-shadow: 1px 1px 1px black;">Some representative placeholder content for the second slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ $header }}" class="d-block w-100 bg-primary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block text-dark" style="background-color: rgba(255, 255, 255, 0.6);">
            <h5 style="text-shadow: 1px 1px 1px black;">Hoja Membrete (Cabecera)</h5>
            <p style="text-shadow: 1px 1px 1px black;">Some representative placeholder content for the third slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ $footer }}" class="d-block w-100 bg-primary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block text-dark" style="background-color: rgba(255, 255, 255, 0.6);">
            <h5 style="text-shadow: 1px 1px 1px black;">Hoja Membrete (Pie de Pagina)</h5>
            <p style="text-shadow: 1px 1px 1px black;">Some representative placeholder content for the four slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ $formato }}" class="d-block w-100 bg-dark" alt="" height="350">
          <div class="carousel-caption d-none d-md-block text-dark" style="background-color: rgba(255, 255, 255, 0.6);">
            <h5 style="text-shadow: 1px 1px 1px black;">Formato Carnet</h5>
            <p style="text-shadow: 1px 1px 1px black;">Some representative placeholder content for the five slide.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </button>
    </div>
  </div>
  <div class="col-6">
    <form action="{{ route('companylog') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="col-12 row mt-3">
        <div class="col-6 p-2">
          <div class="m-1 border border-secondary rounded">
            <div class="media">
              <img src="{{ $logo }}" class="align-self-start mr-3 bg-secondary border border-secondary" name="Logo" alt="" height="64" width="64">
              <div class="media-body text-center">
                <h5 class="mt-0" style="overflow: auto;">Logo Corporativo</h5>
                <input type="file" class="form-control-file" style="overflow: auto;" accept=".png,.pdf" name="logo">
              </div>
            </div>
          </div>
          <div class="m-1 border border-tertiary rounded">
            <div class="media">
              <img src="{{ $qr }}" class="align-self-start mr-3 bg-tertiary border border-tertiary" name="Codigo" alt="" height="64" width="64">
              <div class="media-body text-center">
                <h5 class="mt-0" style="overflow: auto;">Codigo QR</h5>
                <input type="file" class="form-control-file" style="overflow: auto;" accept=".png,.pdf" name="codigo">
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 p-2">
          <div class="m-1 border border-primary rounded">
            <div class="media">
              <img src="{{ $header }}" class="align-self-start mr-3 bg-primary border border-primary" name="Header" alt="" height="64" width="64">
              <div class="media-body text-center">
                <h5 class="mt-0" style="overflow: auto;">Membrete (CABECERA)</h5>
                <input type="file" class="form-control-file" style="overflow: auto;" accept=".png,.pdf" name="header">
              </div>
            </div>
          </div>
          <div class="m-1 border border-dark rounded">
            <div class="media">
              <img src="{{ $footer }}" class="align-self-start mr-3 bg-dark border border-dark" name="Footer" alt="" height="64" width="64">
              <div class="media-body text-center">
                <h5 class="mt-0" style="overflow: auto;">Membrete (PIE DE PAGINA)</h5>
                <input type="file" class="form-control-file"  style="overflow: auto;" accept=".png,.pdf" name="footer">
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 p-2">
          <div class="m-1 border border-primary rounded">
            <div class="media">
              <img src="{{ $formato }}" class="align-self-start mr-3 bg-primary border border-primary" name="Formato" alt="" height="64" width="64">
              <div class="media-body text-center">
                <h5 class="mt-0" style="overflow: auto;">Hoja Formato</h5>
                <input type="file" class="form-control-file" style="overflow: auto;" accept=".png,.pdf" name="formato">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container d-flex justify-content-center">
        <button class="btn btn-secondary m-4">ALMACENAR</button>
      </div>
    </form>
  </div>
</div>
@endsection