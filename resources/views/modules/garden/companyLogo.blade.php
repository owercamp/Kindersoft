@extends('modules.menuFinancial')

@section('financialModules')
<div id="carouselExampleCaptions" class="carousel slide w-100" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner border border-dark">
    <div class="carousel-item active">
      <img src="" class="d-block w-100 bg-secondary" alt="..." height="200">
      <div class="carousel-caption d-none d-md-block">
        <h5>Logo Corporativo</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100 bg-tertiary" alt="..." height="200">
      <div class="carousel-caption d-none d-md-block">
        <h5>Codigo QR</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100 bg-primary" alt="..." height="200">
      <div class="carousel-caption d-none d-md-block">
        <h5>Hoja Membrete</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100 bg-primary" alt="..." height="200">
      <div class="carousel-caption d-none d-md-block">
        <h5>Formato Carnet</h5>
        <p>Some representative placeholder content for the third slide.</p>
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
@endsection