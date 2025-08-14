@extends('modules.accountants')

@section('financialModules')
  <div class="col-md-12">
    <div class="col-md-12">
      <div class="row border-bottom mb-3">
        <div class="col-md-6">
          <h3>COMPROBANTES DE INGRESO</h3>
        </div>

        <div class="col-md-6">

          <!-- Mensajes de creación de comprobantes de ingreso -->

          @if (session('SuccessSaveEntry'))
            <div class="alert alert-success">
              {{ session('SuccessSaveEntry') }}
            </div>
          @endif

          @if (session('SecondarySaveEntry'))
            <div class="alert alert-secondary">
              {{ session('SecondarySaveEntry') }}
            </div>
          @endif

          <!-- Mensajes de actualizacion de comprobantes de ingreso -->

          @if (session('PrimaryUpdateEntry'))
            <div class="alert alert-primary">
              {{ session('PrimaryUpdateEntry') }}
            </div>
          @endif

          @if (session('SecondaryUpdateEntry'))
            <div class="alert alert-secondary">
              {{ session('SecondaryUpdateEntry') }}
            </div>
          @endif

          <!-- Mensajes de eliminación de comprobantes de ingreso -->

          @if (session('WarningDeleteEntry'))
            <div class="alert alert-warning">
              {{ session('WarningDeleteEntry') }}
            </div>
          @endif

          @if (session('SecondaryDeleteEntry'))
            <div class="alert alert-secondary">
              {{ session('SecondaryDeleteEntry') }}
            </div>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <form action="{{ route('entryVouchers.excel') }}" method="GET">
            @csrf
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <small class="text-muted">FECHA INICIAL:</small>
                  <input class="form-control form-control-sm datepicker" name="venDateInitial" required type="text">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <small class="text-muted">FECHA FINAL:</small>
                  <input class="form-control form-control-sm datepicker" name="venDateFinal" required type="text"
                    value="{{ $day }}">
                </div>
              </div>

              <div class="col-md-4">
                <button class="btn btn-outline-success form-control-sm mt-4" type="submit">GENERAR EXCEL</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <table class="table-hover table text-center" id="tableDatatable" width="100%">
        <thead>
          <tr>
            <th>COMPROBANTE</th>
            <th>FECHA DE INGRESO</th>
            <th>ALUMNO</th>
            <th>FACTURA</th>
            <th>VALOR PAGADO</th>
            <th>DETALLES</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($voucherentrys as $entry)
            <tr>
              <td>{{ $entry->venCode }}</td>
              <td>{{ $entry->venDate }}</td>
              <td>{{ $entry->venStudent }}</td>
              <td>{{ $entry->facCode }}</td>
              <td>{{ $entry->venPaid }}</td>
              <td>
                <a class="btn btn-outline-success rounded-circle detailsVoucherentry-link" href="#"
                  title="VER DETALLES">
                  <i class="fas fa-eye"></i>
                  <span hidden>{{ $entry->venId }}</span>
                  <span hidden>{{ $entry->facId }}</span>
                  <span hidden>{{ $entry->idStudent }}</span>
                </a>

                <form action="{{ route('entryVouchers.pdf') }}" method="GET" style="display: inline;">
                  @csrf
                  <input class="form-control form-control-sm" name="venId" type="hidden" value="{{ $entry->venId }}">
                  <button class="btn btn-outline-tertiary rounded-circle" title="PDF DE COMPROBANTE" type="submit">
                    <i class="fas fa-file-pdf"></i>
                    <span hidden>{{ $entry->venId }}</span>
                    <span hidden>{{ $entry->idStudent }}</span>
                  </button>
                </form>

                <form action="{{ route('entryVouchersFacturation.pdf') }}" method="GET" style="display: inline;">
                  @csrf
                  <input class="form-control form-control-sm" name="facId" type="hidden" value="{{ $entry->facId }}">
                  <button class="btn btn-outline-primary rounded-circle" title="PDF DE FACTURA" type="submit">
                    <i class="fas fa-file-pdf"></i>
                    <span hidden>{{ $entry->facId }}</span>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


  <div class="modal fade" id="detailsVoucherEntry-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-12 d-flex">
              <h4 class="text-muted">DETALLES DE COMPROBANTE DE INGRESO</h4>
            </div>
          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>

        </div>

        <div class="row modal-body">
          <div class="col-md-4">
            <small class="text-muted">ALUMNO:</small>
            <h6 class="nameStudent"></h6>
            <h6 class="documentStudent"></h6>
            <h6 class="yearsStudent"></h6>
            <h6 class="courseStudent"></h6>

            <hr>

            <small class="text-muted">ACUDIENTE/S:</small>

            <hr>

            <h6 class="nameFather"></h6>
            <h6 class="documentFather"></h6>
            <h6 class="phoneFather"></h6>
            <h6 class="mailFather"></h6>

            <hr>

            <h6 class="nameMother"></h6>
            <h6 class="documentMother"></h6>
            <h6 class="phoneMother"></h6>
            <h6 class="mailMother"></h6>

            <hr>

            <small class="text-muted">CONTRATO:</small>

            <hr>

            <h6 class="dateInitial"></h6>
            <h6 class="dateFinal"></h6>

          </div>

          <div class="col-md-5">

            <table class="table-concepts table" width="100%">
              <thead>
                <tr>
                  <th>CONCEPTO</th>
                  <th>VALOR</th>
                  <th>IVA</th>
                </tr>
              </thead>
              <tbody>

                <!-- Dinamico -->

              </tbody>
            </table>
          </div>

          <div class="col-md-3">
            <small class="text-muted">COMPROBANTE:</small><br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-key"></i>
                </span>
              </div>

              <input class="form-control form-control-sm text-center" disabled name="codeVoucher"
                style="font-weight: bold;" title="CÓDIGO DE COMPROBANTE" type="text">
            </div>

            <small class="text-muted">FECHA DE EMISION:</small><br>

            <h6 class="dateVoucher"></h6>

            <small class="text-muted">DESCRIPCION:</small><br>

            <h6 class="descriptionVoucher"></h6>

            <hr>

            <small class="text-muted">FACTURA:</small><br>

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-key"></i>
                </span>
              </div>

              <input class="form-control form-control-sm text-center" disabled name="codeFacture"
                style="font-weight: bold;" title="CÓDIGO DE FACTURA" type="text">
            </div>

            <small class="text-muted">VALOR PAGADO (+ IVA):</small>

            <h6 class="valuePaid"></h6>

            <small class="text-muted">PORCENTAJE DE IVA:</small>

            <h6 class="porcentageIva"></h6>

            <small class="text-muted">FECHA DE EMISION:</small>

            <h6 class="dateInitialFacture"></h6>

            <small class="text-muted">FECHA DE VENCIMIENTO:</small>

            <h6 class="dateFinalFacture"></h6>

            <small class="text-muted">VALOR SIN IVA:</small>

            <h6 class="valueFacture"></h6>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="excelVoucherEntry-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-12 d-flex">
              <h4 class="text-muted">EXPORTAR COMPROBANTES A EXCEL</h4>
            </div>
          </div>

          <button class="close" data-dismiss="modal" type="button">&times;</button>

        </div>

        <div class="row modal-body">
          <form action="">
            <div class="row">
              <div class="col-md-12">
                @php $datenow = Date('Y-m-d'); @endphp
                <div class="form-group">
                  <small>FECHA:</small>
                  <input class="form-control form-control-sm datepicker" required type="text"
                    value='{{ $day }}'>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 text-center">
                <button class="btn btn-outline-success" type="submit">GENERAR EXCEL</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
  <script>
    $(function() {});

    $('.detailsVoucherentry-link').on('click', function(e) {
      e.preventDefault();
      var voucher = $(this).find('span:nth-child(2)').text();
      var facturation = $(this).find('span:nth-child(3)').text();
      var student = $(this).find('span:nth-child(4)').text();

      // CONSULTA DE DETALLES DE COMPROBANTE

      $.get("{{ route('getDetailsVoucherEntry') }}", {
        venId: voucher,
        facId: facturation,
        student: student
      }, function(objectsEntry) {
        var count = Object.keys(objectsEntry).length;
        if (count > 0) {
          $('.table-concepts tbody').empty();
          for (var i = 0; i < count; i++) {
            if (objectsEntry[i][0] == 'INFORMACION') {
              // ALUMNO
              $('.nameStudent').text('');
              $('.nameStudent').text(objectsEntry[i][1]);
              $('.documentStudent').text('');
              $('.documentStudent').text(objectsEntry[i][2]);
              $('.yearsStudent').text('');
              $('.yearsStudent').text(objectsEntry[i][3]);
              $('.courseStudent').text('');
              $('.courseStudent').text(objectsEntry[i][4]);

              //PADRE
              $('.nameFather').text('');
              $('.nameFather').text(objectsEntry[i][5]);
              $('.documentFather').text('');
              $('.documentFather').text(objectsEntry[i][6]);
              $('.phoneFather').text('');
              $('.phoneFather').text(objectsEntry[i][7]);
              $('.mailFather').text('');
              $('.mailFather').text(objectsEntry[i][8]);

              //MADRE

              $('.nameMother').text('');
              $('.nameMother').text(objectsEntry[i][9]);
              $('.documentMother').text('');
              $('.documentMother').text(objectsEntry[i][10]);
              $('.phoneMother').text('');
              $('.phoneMother').text(objectsEntry[i][11]);
              $('.mailMother').text('');
              $('.mailMother').text(objectsEntry[i][12]);

              //CONTRATO

              $('.dateInitial').text('');
              $('.dateInitial').text(objectsEntry[i][13]);
              $('.dateFinal').text('');
              $('.dateFinal').text(objectsEntry[i][14]);

              //COMPROBANTE

              $('input[name=codeVoucher]').val('');
              $('input[name=codeVoucher]').val(objectsEntry[i][15]);
              $('.dateVoucher').text('');
              $('.dateVoucher').text(objectsEntry[i][16]);
              $('.descriptionVoucher').text('');
              $('.descriptionVoucher').text(objectsEntry[i][17]);

              //FACTURA

              $('input[name=codeFacture]').val('');
              $('input[name=codeFacture]').val(objectsEntry[i][18]);
              $('.valuePaid').text('');
              $('.valuePaid').text(objectsEntry[i][25]);
              $('.porcentageIva').text('');
              $('.porcentageIva').text(objectsEntry[i][19]);
              $('.dateInitialFacture').text('');
              $('.dateInitialFacture').text(objectsEntry[i][20]);
              $('.dateFinalFacture').text('');
              $('.dateFinalFacture').text(objectsEntry[i][21]);
              $('.valueFacture').text('');
              $('.valueFacture').text(objectsEntry[i][25]);
            } else {
              $('.table-concepts tbody').append('<tr><td>' + objectsEntry[i][1] + '</td><td>' + objectsEntry[i][
                2
              ] + '</td><td>' + objectsEntry[i][3] + '</td></tr>');
            }
          }
        } else {

          //ALUMNO
          $('.nameStudent').text('');
          $('.documentStudent').text('');
          $('.yearsStudent').text('');
          $('.courseStudent').text('');

          //PADRE
          $('.nameFather').text('');
          $('.documentFather').text('');
          $('.phoneFather').text('');
          $('.mailFather').text('');

          //MADRE
          $('.nameMother').text('');
          $('.documentMother').text('');
          $('.phoneMother').text('');
          $('.mailMother').text('');

          //CONTRATO
          $('.dateInitial').text('');
          $('.dateFinal').text('');

          //COMPROBANTE
          $('input[name=codeVoucher]').val('');
          $('.dateVoucher').text('');
          $('.descriptionVoucher').text('');

          //FACTURA
          $('input[name=codeFacture]').val('');
          $('.valuePaid').text('');
          $('.porcentageIva').text('');
          $('.dateInitialFacture').text('');
          $('.dateFinalFacture').text('');
          $('.valueFacture').text('');

          //TABLA
          $('.table-concepts tbody').empty();
        }
      });
      $('#detailsVoucherEntry-modal').modal();
    });
  </script>
@endsection
