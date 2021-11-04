<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Para bootstrap -->
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
        <style>
            @page { margin: 150px 50px; }
            #header { position: fixed; top: -150px; height: 100px; background-color: transparent; text-align: center; }
            #footer { position: fixed; bottom: -100; height: 70px; background-color: transparent; }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <header id="header">
                <img src="{{ asset('storage/garden/headerPdf.png') }}">
            </header>
            <hr>
            <div class="row" style="width: 100%;">
                <div class="col-md-12" style="width: 100%;">
                    <h6><b>ASUNTO:</b> SOLICITUD DE ENTREGA DE DOCUMENTOS PENDIENTES</h6>
                    <hr>
                    <p style="text-align: justify; font-size: 12px;">
                        Se solicita a la brevedad posible la entrega de los documentos faltantes para consolidar la matricula del alumno <b>{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</b>, Se relacionan los documentos con su estado a continuación:
                    </p>
                    <small class="text-muted"><b>PROGRESO: {{ round($porcentage) . '%' }} de 100%</b></small>
                    <span style="background: #ccc; width: 100%;" class="badge badge-warning">
                        
                    </span>
                    <input type="progress" class="progress-bar progress-bar-striped" value="{{ round($porcentage) . '%' }}">
                    <hr>
                    <ol>
                        @for($i = 0; $i < count($arrayDocuments); $i++)
                            <li style="font-size: 13px;">
                                @if($arrayDocuments[$i][2] == 'ENTREGADO')
                                    @if($arrayDocuments[$i][1] == 'SI')
                                        {{ $arrayDocuments[$i][0] . ' (Obligatorio) - ' }}<b style="font-size: 12px; color: green;">ENTREGADO</b>
                                    @else
                                        {{ $arrayDocuments[$i][0] . ' (Opcional) - ' }}<b style="font-size: 12px; color: green;">ENTREGADO</b>
                                    @endif
                                @else
                                    @if($arrayDocuments[$i][1] == 'SI')
                                        {{ $arrayDocuments[$i][0] . ' (Obligatorio) - ' }}<b style="font-size: 12px; color: red;">PENDIENTE</b>
                                    @else
                                        {{ $arrayDocuments[$i][0] . ' (Opcional) - ' }}<b style="font-size: 12px; color: red;">PENDIENTE</b>
                                    @endif
                                @endif
                            </li>
                        @endfor
                    </ol>
                    <div style="width: 50%; float: right;">
                        <p style="font-size: 13px; font-weight: bold; text-align: left;">
                            Recibí, <br>
                            ________________________________    <br>  
                            Nombre: <br>
                            Documento: <br>
                            Fecha: {{ $datenow }}
                        </p>
                    </div>
                </div>
            </div>
            <footer id="footer">
                <img src="{{ asset('storage/garden/footerPdf.png') }}">
            </footer>
        </div>
    </body>

</html>