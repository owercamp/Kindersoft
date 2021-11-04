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
            @page { margin: 100px 50px; }
            header {
                width: 100%;
                position: fixed; 
                left: 0px; 
                top: -50px; 
                right: 0px; 
                height: 150px;
                text-align: center;
                overflow-y: hidden;
            }
            /*footer {
                width: 100%;
                position: fixed;
                left: 0px;
                bottom: -180px;
                right: 0px;
                height: 150px;
                text-align: center;
                overflow-y: hidden;
            }
            footer .page:after {
                content: counter(page, upper-roman);
            }*/
            table td{
                border: 1px solid #ccc;
                padding: 2px;
            }
        </style>

    </head>
    <body>
        @php
            function getDateString($dateValue){
                $separatedDate = explode('-',$dateValue);
                switch($separatedDate[1]){
                    case '01': return $separatedDate[2] . ' de ENERO del ' . $separatedDate[0]; break;
                    case '02': return $separatedDate[2] . ' de FEBRERO del ' . $separatedDate[0]; break;
                    case '03': return $separatedDate[2] . ' de MARZO del ' . $separatedDate[0]; break;
                    case '04': return $separatedDate[2] . ' de ABRIL del ' . $separatedDate[0]; break;
                    case '05': return $separatedDate[2] . ' de MAYO del ' . $separatedDate[0]; break;
                    case '06': return $separatedDate[2] . ' de JUNIO del ' . $separatedDate[0]; break;
                    case '07': return $separatedDate[2] . ' de JULIO del ' . $separatedDate[0]; break;
                    case '08': return $separatedDate[2] . ' de AGOSTO del ' . $separatedDate[0]; break;
                    case '09': return $separatedDate[2] . ' de SEPTIEMBRE del ' . $separatedDate[0]; break;
                    case '10': return $separatedDate[2] . ' de OCTUBRE del ' . $separatedDate[0]; break;
                    case '11': return $separatedDate[2] . ' de NOVIEMBRE del ' . $separatedDate[0]; break;
                    case '12': return $separatedDate[2] . ' de DICIEMBRE del ' . $separatedDate[0]; break;
                }
            }
        @endphp
        <header>
            <table width="100%">
                <tr>
                    <td class="text-right"><small class="text-muted text-right"><b>Curso:</b></small></td>
                    <td class="text-left"><small class="text-muted text-left">{{ $course->nameCourse }}</small></td><!-- Curso -->
                    <td colspan="2" class="text-right">
                        <small class="text-muted text-right">CRONOGRAMA POR CURSO</small>
                    </td>
                </tr>
                <tr>
                    <td class="text-right"><small class="text-muted text-right"><b>Grado:</b></small></td>
                    <td class="text-left"><small class="text-muted text-left"> {{ $course->nameGrade }} </small></td> <!-- Grado -->
                    <td colspan="2" class="text-right">
                        @php $datenow = Date('Y-m-d');  @endphp
                        <small class="text-muted text-right">{{ getDateString($datenow) }}</small>
                    </td>
                </tr>
            </table>
        </header>
        <hr>
        <table width="100%" class="text-center">
            <tr>
                <td><small class="text-muted"><b>INTELIGENCIA</b></small></td>
                <td><small class="text-muted"><b>PERIODO</b></small></td>
                <td><small class="text-muted"><b>SEMANA</b></small></td>
                <td><small class="text-muted"><b>DOCENTE</b></small></td>
                <td><small class="text-muted"><b>ACTIVIDAD</b></small></td>
            </tr>
            @foreach($resultFilter as $result)
                <tr>
                    <td><small class="text-muted">{{ $result->typeIntelligence }}</small></td>
                    <td><small class="text-muted">{{ $result->apNameperiod }}</small></td>
                    @php
                        $separatedRange = explode('/',$result->chRangeWeek);

                        $getDateInitialString = '';
                        $getDateFinalString = '';
                    @endphp
                    <td><small class="text-muted">
                        SEMANA: {{ $result->chNumberWeek }} <br> 
                        <br>{{ $getDateInitialString }} <br> - <br> {{ $getDateFinalString }}</small>
                    </td>
                    <td><small class="text-muted">{{ $result->nameCollaborator }}</small></td>
                    <td><small class="text-muted">{{ $result->chDescription }}</small></td>
                </tr>
            @endforeach
        </table>
    </body>
</html>