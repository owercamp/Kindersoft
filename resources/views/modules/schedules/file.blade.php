@extends('modules.schedules')

@section('scheduleModules')
<div class="col-md-12">
  ARCHIVO DE AGENDA
</div>
<div class="container">
  <table id="tableperiods" class="table table-hover text-center table-striped" style="width: 100%">
    <thead>
      <tr>
        <th>FECHA</th>
        <th>CONTEXTO</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($archive as $item)
      <tr>
        <td style="max-width: fit-content!important;">{{$item->id_fulldate}}</td>
        <td>{{$item->id_cont}}</td>
        <td class="d-flex justify-content-center">
          <button title="VER" class="btn btn-outline-primary rounded-circle view-mail" data-toggle="modal" data-target="#formView" style="margin-right: 5px" onclick="view('{{$item->id_id}}')"><i class="fas fa-eye"></i>
          </button>
          <button title="ELIMINAR" class="btn btn-outline-tertiary rounded-circle  delete-mail" style="margin-right: 5px" onclick="del('{{$item->id_id}}')"><i class="fas fa-minus-circle"></i>
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="formView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  @include('modules.schedules.partials.modal');
</div>
@endsection

@section('scripts')
<script>
  function del(id) {
    $.ajax({
      url: "{{route('file.destroy')}}",
      type: "POST",
      data: {
        "_token": $("meta[name='csrf-token']").attr("content"),
        DelID: id
      },
      dataType: "json",
      beforeSend() {
        Swal.fire({
          icon: 'info',
          title: 'Realizando Eliminación',
          showConfirmButton: false,
        })
      },
      complete() {
        Swal.fire({
          icon: 'success',
          title: 'Eliminación Completada',
          showConfirmButton: false,
          timer: 2000
        })
        window.location.href = "{{route('scheduleFile')}}";
      }
    })
  }

  function view(id) {
    $.get("{{route('getInfoMail')}}", {
      data: id
    }, function(objectInfoMail) {
      $("#hi").text("");
      $("#cont").text("");
      $("#list").empty();
      $("#hi").text(objectInfoMail[0]["id_hi"]);
      $("#cont").text(objectInfoMail[0]["id_cont"]);
      let json = JSON.parse(objectInfoMail[0]['id_NamesSin']);
      json.forEach(element => {
        $("#list").append("<li>" + element + "</li>")
      });
    });
  }
</script>
@endsection