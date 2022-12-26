@extends('modules.menuFinancial')

@section('financialModules')
<div class="w-100 row">
  <div class="col-6">
    <div id="carouselExampleCaptions" class="carousel slide w-100" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner border border-dark">
        <div class="carousel-item active">
          <img src="" class="d-block w-100 bg-secondary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block">
            <h5>Logo Corporativo</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="" class="d-block w-100 bg-tertiary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block">
            <h5>Codigo QR</h5>
            <p>Some representative placeholder content for the second slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="" class="d-block w-100 bg-primary" alt="" height="350">
          <div class="carousel-caption d-none d-md-block">
            <h5>Hoja Membrete</h5>
            <p>Some representative placeholder content for the third slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="" class="d-block w-100 bg-dark" alt="" height="350">
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
  </div>
  <div class="col-6">
    <div class="col-12 row mt-3">
      <div class="col-6 p-2">
        <div class="m-1 border border-secondary rounded">
          <div class="media">
            <img src="..." class="align-self-start mr-3 bg-secondary border border-secondary" alt="" height="64" width="64">
            <div class="media-body text-center">
              <h5 class="mt-0">Logo Corporativo</h5>
            </div>
          </div>
        </div>
        <div class="m-1 border border-tertiary rounded">
          <div class="media">
            <img src="..." class="align-self-start mr-3 bg-tertiary border border-tertiary" alt="" height="64" width="64">
            <div class="media-body">
            <h5 class="mt-0">Codigo QR</h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 p-2">
        <div class="m-1 border border-primary rounded">
          <div class="media">
            <img src="..." class="align-self-start mr-3 bg-primary border border-primary" alt="" height="64" width="64">
            <div class="media-body text-center">
              <h5 class="mt-0">Hoja Membrete</h5>
            </div>
          </div>
        </div>
        <div class="m-1 border border-dark rounded">
          <div class="media">
            <img src="..." class="align-self-start mr-3 bg-dark border border-dark" alt="" height="64" width="64">
            <div class="media-body">
            <h5 class="mt-0">Formato Carnet</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection