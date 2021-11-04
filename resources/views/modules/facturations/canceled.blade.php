@extends('modules.accountants')

@section('financialModules')
<div class="col-md-12">
  <div class="row my-3 border-bottom">
    <div class="col-md-6">
      <h5>FACTURAS ANULADAS</h5>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de cambios -->
      @if(session('SuccessFacture'))
      <div class="alert alert-success">
        {{ session('SuccessFacture') }}
      </div>
      @endif
      @if(session('SecondaryFacture'))
      <div class="alert alert-secondary">
        {{ session('SecondaryFacture') }}
      </div>
      @endif
      <div class="alert message">
        <!-- Mensajes -->
      </div>
    </div>
    <form action="{{ route('factureCanceled') }}" method="post" class="d-flex container-fluid py-2 justify-content-center">
      @csrf
      <div class="col-md-7 d-flex border border-secondary rounded justify-content-center">
        <div class="form-group py-2 px-4 mb-0 row">
          <small class="text-muted">Fecha Inicio</small>
          <input type="date" name="searchInitial" class="form-control form-control-sm">
        </div>
        <div class="form-group py-2 px-4 mb-0 row">
          <small class="text-muted">Fecha Final</small>
          <input type="date" name="searchFinal" class="form-control form-control-sm">
        </div>
        <div class="form-group py-2 px-4 mb-0 align-self-center">
          <Button class="btn btn-outline-success" id="searchAll">Consultar</Button>
        </div>
      </div>
    </form>
  </div>
  <table id="tableDatatable" class="table table-hover text-center" width="100%">
    <thead>
      <tr>
        <th>FACTURA</th>
        <th>FECHA DE VENCIMIENTO</th>
        <th>ALUMNO</th>
        <th>VALOR A PAGAR</th>
        <th>ACCION</th>
      </tr>
    </thead>
    <tbody>
      @foreach($facturations as $facture)
      <tr>
        <td>{{ $facture->facCode }}</td>
        <td>{{ $facture->facDateFinal }}</td>
        <td>{{ $facture->nameStudent }}</td>
        <td>{{ $facture->facValue }}</td>
        <td>
          <form action="{{ route('canceled.pdf') }}" method="GET" style="display: inline;">
            @csrf
            <input type="hidden" name="facId" value="{{ $facture->facId }}" class="form-control form-control-sm">
            <button type="submit" title="PDF DE FACTURA" class="bj-btn-table-delete">
              <i class="fas fa-file-pdf"></i>
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@section('scripts')
<script>

</script>
@endsection