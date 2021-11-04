<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @page { margin: 50px 50px; }
            *{
                padding: 0;
                text-align: left;
                font-family: arial;
                font-size: 12px;
                text-align: center;
                z-index: 2;
            }
            div{
                width: 100%;
            }
            h2{
                font-size: 20px;
            }
            img{
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
        </style>
    </head>
    <body style="width: 100%;">
        <img src="{{ asset('img/first_bulletin.png') }}">
        <div>
            <h2>INFORME INDIVIDUAL</h2>
            <h2>{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</h2>
            <h2>{{ $student->numberdocument }}</h2>
            <h2>{{ $student->yearsold }}</h2>
            <h2>{{ $course->name }}</h2>
        </div>
        <hr>
        <table border="1" width="100%">
            <caption align="top">INFORMACION DE ASISTENCIAS DE {{ $dateInitial }} A {{ $dateFinal }}</caption>
            <thead>
                <tr>
                    <th>FECHA REGISTRADA</th>
                    <th>ESTADO</th>
                    <th>RANGO DE HORAS</th>
                    <th>OBSERVACION DE LLEGADA</th>
                    <th>OBSERVACION DE SALIDA</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < count($findStudent);$i++)
                    <tr>
                        <td>{{ $findStudent[$i][1] }}</td>
                        <td>{{ $findStudent[$i][0] }}</td>
                        <td>{{ $findStudent[$i][2] }}</td>
                        <td>{{ $findStudent[$i][3] }}</td>
                        <td>{{ $findStudent[$i][4] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </body>
</html>