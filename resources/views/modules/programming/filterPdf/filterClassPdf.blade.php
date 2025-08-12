<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
            @page { margin: 100px 50px; }
            *{
                padding: 0;
                text-align: left;
                font-family: arial;
                font-size: 12px;
                text-align: center;
                z-index: 2;
            }
            section{
                width: 100%;
                display: flex;
                flex-flow: row nowrap;
            }
            section article{
                width: 50%;
                display: inline;
            }
            .art-info{
                border-left: solid;
                border-color: #ccC;
                padding: 10px;
                float: right;
            }
            h2{
                font-size: 15px;
            }
            .img-back{
                width: 350px;
                height: auto;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -50%);
                z-index: 1;
                opacity: 0.2;
            }
            table, caption{
                border-collapse: collapse;
                text-align: center;
            }
            td{
                padding: 5px;
            }
            .infoDay{
                /* background: rgba(116,52,96,0.3); */
                background: rgba(164,176,104,0.3);
            }
            .na{
                background: rgba(253,135,1,0.3);
            }

            table th, .infoDate{
                background: rgba(0,134,249,0.3);
                padding: 5px;
            }
        </style>     
    </head>
    <body>
        @if(asset('storage/garden/logo.png'))
            <img class="img-back" src="{{ asset('storage/garden/logo.png') }}">
        @else
            @if(asset('storage/garden/logo.jpg'))
                <img class="img-back" src="{{ asset('storage/garden/logo.jpg') }}">
            @else
                <img class="img-back" src="{{ asset('storage/garden/default.png') }}">
            @endif
        @endif        
        <section>
            <article>
                @if(asset('storage/garden/logo.png'))
                    <img src="{{ asset('storage/garden/logo.png') }}">
                @else
                    @if(asset('storage/garden/logo.jpg'))
                        <img src="{{ asset('storage/garden/logo.jpg') }}">
                    @else
                        <img src="{{ asset('storage/garden/default.png') }}">
                    @endif
                @endif
                <!-- 
                VARIABLES:
                $resultFilter->hwId
                $resultFilter->hwDate
                $resultFilter->hwHourInitial
                $resultFilter->hwHourFinal
                $resultFilter->hwDay
                $resultFilter->hwActivityClass_id
                $resultFilter->hwactivitySpace_id
                $resultFilter->hwCollaborator_id
                $resultFilter->hwCourse_id
                $resultFilter->name
                $resultFilter->hwStatus
                $resultFilter->asId
                $resultFilter->asSpace
                $resultFilter->asDescription
                $resultFilter->nameCollaborator
                 -->
            </article>
            <article class="art-info">
                <h2><b>HORARIO DE:</b> {{ $activityclass->acClass }}</h2><br>                
                <h2>{{ $activityclass->acDescription }}</h2><br>         
            </article>
        </section>
        <hr>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>HORAS</th>
                    <th>LUNES</th>
                    <th>MARTES</th>
                    <th>MIERCOLES</th>
                    <th>JUEVES</th>
                    <th>VIERNES</th>
                </tr>
            </thead>
            <tbody>
                @php
                    function getDayString($value){
                        switch ($value){
                            case 0: return 'DOMINGO'; break;
                            case 1: return "LUNES"; break;
                            case 2: return "MARTES"; break;
                            case 3: return "MIERCOLES"; break;
                            case 4: return "JUEVES"; break;
                            case 5: return "VIERNES"; break;
                            case 6: return "SABADO"; break;
                        }  
                    }

                    //dd(date('w',$request->hwDate));
                @endphp
                @foreach($resultFilter as $hourSpace)
                    @php $day = getDayString($hourSpace->hwDay); @endphp
                    <tr>
                        <td class="infoDate">{{ $day }} <br> {{ $hourSpace->hwDate }}</td>
                        <td class="infoDate">{{ $hourSpace->hwHourInitial }} A {{ $hourSpace->hwHourFinal }}</td>
                        @if($day == 'LUNES')
                            <td class="infoDay">
                                <b>Curso:</b><br>{{ $hourSpace->name }} <br>
                                <b>Docente:</b><br>{{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b><br>{{ $hourSpace->acDescription }} <br>
                            </td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                        @endif
                        @if($day == 'MARTES')
                            <td class="na"></td>
                            <td class="infoDay">
                                <b>Curso:</b><br>{{ $hourSpace->name }} <br>
                                <b>Docente:</b><br>{{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b><br>{{ $hourSpace->acDescription }} <br>
                            </td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                        @endif
                        @if($day == 'MIERCOLES')
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="infoDay">
                                <b>Curso:</b><br>{{ $hourSpace->name }} <br>
                                <b>Docente:</b><br>{{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b><br>{{ $hourSpace->acDescription }} <br>
                            </td>
                            <td class="na"></td>
                            <td class="na"></td>
                        @endif
                        @if($day == 'JUEVES')
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="infoDay">
                                <b>Curso:</b><br>{{ $hourSpace->name }} <br>
                                <b>Docente:</b><br>{{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b><br>{{ $hourSpace->acDescription }} <br>
                            </td>
                            <td class="na"></td>
                        @endif
                        @if($day == 'VIERNES')
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="na"></td>
                            <td class="infoDay">
                                <b>Curso:</b><br>{{ $hourSpace->name }} <br>
                                <b>Docente:</b><br>{{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b><br>{{ $hourSpace->acDescription }} <br>
                            </td>
                        @endif
                        @if($day == 'SABADO' || $day == 'DOMINGO')
                            <td class="infoDay" colspan="5">
                                FIN DE SEMANA: <br>
                                <b>Curso:</b> {{ $hourSpace->name }} <br>
                                <b>Docente:</b> {{ $hourSpace->nameCollaborator }} <br>
                                <b>Número y Clase:</b><br>{{ $hourSpace->acNumber }}-{{ $hourSpace->acClass }} <br>
                                <b>Descripción:</b> {{ $hourSpace->acDescription }} <br>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>

    </body>
</html>