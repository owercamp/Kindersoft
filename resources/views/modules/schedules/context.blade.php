@extends('modules.schedules')

@section('scheduleModules')
    <div class="w-100 mr-2 ml-2">
        <div class="w-100 m-2 p-2 row">
            <div class="col-md-6">
                PLANTILLAS DE CONTEXTO
            </div>
            <div class="col-md-6">
                @if (session('SuccessCreation'))
                    <div class="alert alert-success">
                        {{session('SuccessCreation')}}
                    </div>
                @endif
                @if (session('SecondaryCreation'))
                    <div class="alert alert-secondary">
                        {{session('SecondaryCreation')}}
                    </div>
                @endif
                @if (session('PrimaryCreation'))
                    <div class="alert alert-info">
                        {{session('PrimaryCreation')}}
                    </div>
                @endif
                @if (session('WarningCreation'))
                    <div class="alert alert-danger">
                        {{session('WarningCreation')}}
                    </div>
                @endif
            </div>
        </div>
        <div class="container border border-secondary p-2 w-50">
            <form action="{{route('context.save')}}" method="post" class="row w-100">
                @csrf
                <div class="col-12 ml-3">
                    <div class="row ml-1 d-flex justify-content-between mr-1">
                        <div class="form-group mt-2">
                        <small>N° PLANTILLA: </small>
                            <strong class="contextNumber">0</strong>
                        </div>
                        <div class="mt-1">
                            <button type="submit" class="btn btn-outline-success"><strong>Guardar</strong></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <small>CONTEXTO</small>
                        <textarea name="contextText" cols="30" rows="5" class="form-control form-control-sm" required></textarea>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="container">
            <table id="tableperiods" class="table table-hover text-center table-striped" style="width: 100%">
                <thead>
                    <tr>
                        <th>N° PLANTILLA</th>
                        <th>CONTEXTO PLANTILLA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)    
                        <tr>
                            <td>{{$item->sch_id}}</td>
                            <td>{{$item->sch_body}}</td>
                            <td class="d-flex justify-content-center">
                                <a title="EDITAR" class="bj-btn-table-edit edit-hi" data-toggle="modal" data-target="#formEdit" style="margin-right: 5px"><i class="fas fa-edit"></i><span hidden>{{$item->sch_id}}</span>
                                <span hidden>{{$item->sch_body}}</span></a>
                                <a title="ELIMINAR" class="bj-btn-table-delete delete-hi" data-toggle="modal" data-target="#formDelete" style="margin-left: 5px"><i class="fas fa-trash-alt"></i><span hidden>{{$item->sch_id}}</span>
                                    <span hidden>{{$item->sch_body}}</span></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- formulario de edición --}}
        <div class="modal fade" id="formEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">EDITAR PLANTILLA</h5>                  
                    </div>
                    <div class="modal-body">
                        <form action="{{route('context.edit')}}" method="post" class="row w-100 Hiform">
                            @csrf
                            <div class="col-12 ml-3">
                                <div class="row ml-1 d-flex justify-content-between mr-1">
                                    <div class="form-group mt-2">
                                    <small>N° PLANTILLA: </small>
                                        <strong class="contextNumberEdit">0</strong>
                                        <input type="hidden" name="contextNumberEdit">
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <small>SALUDO</small>
                                    <textarea name="contextTextEdit" cols="30" rows="5" class="form-control form-control-sm" required></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bj-btn-table-delete" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="bj-btn-table-add">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- formulario de eliminación --}}
        <div class="modal fade" id="formDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLongTitle">ELIMINAR PLANTILLA</h5>                  
                    </div>
                    <div class="modal-body">
                        <form action="{{route('context.delete')}}" method="post" class="row w-100 Delform">
                            @csrf
                            <div class="col-12 ml-3">
                                <div class="row ml-1 d-flex justify-content-between mr-1">
                                    <div class="form-group mt-2">
                                    <small>N° PLANTILLA: </small>
                                        <strong class="contextNumberDelete">0</strong>
                                        <input type="hidden" name="contextNumberDelete">
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <small>SALUDO</small>
                                    <pre class="form-control form-control-sm contextTextDelete"></pre>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bj-btn-table-edit" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="bj-btn-table-cancel delform">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $('.delform').click(function (e) { 
            e.preventDefault();
            let status = confirm('¿Desea eliminar el saludo?');
            if (status == true) {
                $('.Delform').submit();
            }
        });
        $('.bj-btn-table-add').click(function (e) { 
            e.preventDefault();
            $('.Hiform').submit();
        });

        $('textarea[name=contextText]').focus(function () { 
            $.get("{{route('getNumbercontext')}}",
                function (objectNumber) {
                    console.log(objectNumber);
                    let {sch_id} = objectNumber;
                    let val = 1;
                    if (sch_id == undefined) {
                        $('.contextNumber').text(val);
                    } else {
                        val = sch_id + 1;
                        $('.contextNumber').text(val);
                    }
                }
            );
        });

        $('.edit-hi').click(function (e) { 
            e.preventDefault();
            let id, body;
            id = $(this).find('span:nth-child(2)').text();
            body = $(this).find('span:nth-child(3)').text();
            $('.contextNumberEdit').text(id);
            $('input[name=contextNumberEdit]').val(id);
            $('textarea[name=contextTextEdit]').val(body);
        });

        $('.delete-hi').click(function (e) { 
            e.preventDefault();
            let id, body;
            id = $(this).find('span:nth-child(2)').text();
            body = $(this).find('span:nth-child(3)').text();
            $('.contextNumberDelete').text(id);
            $('input[name=contextNumberDelete]').val(id);
            $('.contextTextDelete').text(body);
        });
    </script>
@endsection