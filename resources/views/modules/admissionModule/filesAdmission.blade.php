@extends('admissions')

@section('modulesAdmission')
<div class="row">
  <div class="col-md-12">
    <div class="row text-center border-bottom mb-4" style="font-size: 13px;">
      <div class="col-md-12">
        <!-- Mensajes de modificación de formularios -->
        @if(session('SuccessForm'))
        <div class="alert alert-success">
          {{ session('SuccessForm') }}
        </div>
        @endif
        <!-- Mensajes de errores de procesamiento de formularios -->
        @if(session('SecondaryForm'))
        <div class="alert alert-secondary">
          {{ session('SecondaryForm') }}
        </div>
        @endif
      </div>
    </div>
    <table id="table-data" class="table table-hover text-center" width="100%">
      <thead>
        <tr>
          <th>NIÑO - NIÑA</th>
          <th>DOCUMENTO</th>
          <th>PERIODO ESCOLAR</th>
          <th>ACUDIENTE 1</th>
          <th>CONTACTO 1</th>
          <th>ACUDIENTE 2</th>
          <th>CONTACTO 2</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<div aria-hidden="true" hidden>
  <form action="{{ route('pdfAdmission') }}" method="post" id="PDFDownload">
    @csrf
    <input type="text" name="id" id="id" value="">
  </form>
</div>

@endsection

@section('scripts')
  <script>
    $(document).ready(function () {
      $('#table-data').DataTable({
        processing: true,
        serverSide: true,
        order: [
          [0, 'asc']
        ],
        ajax:{
          url:"{{ route('serverSide') }}",
          dataType: "JSON",
          type: "GET",
          data: {
            "_token": "{{ csrf_token() }}"
          }
        },
        columns:[
          {data: 'nombres'},
          {data: 'documento'},
          {data: 'periodo'},
          {data: 'acudiente_1'},
          {data: 'contacto_1'},
          {data: 'acudiente_2'},
          {data: 'contacto_2'},
          {data: 'action',
          render: function (data,type,full,meta) {
            return `<div class='btn-group'>
            <a href="javascript:void(0)" class="btn btn-outline-tertiary rounded-circle form-control-sm pdf" data-id="${data.id}"><i class="fas fa-file-pdf"></i></a>
            </div>`;
          },
          orderable: false
        }],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        resposive: true,
        pagingType: 'full_numbers',
      })
  });

  $(document).on('click', '.pdf', function(event){
    let id = $(this).data('id');
    $('#id').val(id);
    $('#PDFDownload').submit();
  });
  </script>
@endsection