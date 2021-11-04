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
            @page { margin: 50px 50px; }
            .titles{
                text-align: left;
                font-size: 12px;
                font-weight: bold;
                color: #ccc;
                font-style: italic;
                line-height: 0;
            }
            .dates{
                font-size: 9px;
                color: #000;
                font-style: normal;
                font-weight: bold;
            }
            .dates-green{
                color: #a4b068;
                text-align: left;
            }
            .dates-small{
                font-size: 12px;
                color: #000;
            }
            .title-items{
                font-size: 10px;
                font-weight: bold;
                color: #ff5500;
                padding-right: 2px;
                text-align: center;
                background-color: #ccc;
                border: 1px solid #ccc;
            }
            .title-blue{
                color: #54ADFF;
            }
        </style>
    </head>
    <body>
        @php $datenow = Date('Y-m-d'); @endphp
        <!-- <div class="container-fluid"> -->
            <p style="font-size: 12px; font-weight: bold;">Se relaciona a continuación la cartera vencida anterior a la fecha: {{ $datenow }}</p>
            <hr>
            @for($i = 0; $i < count($result); $i++)
                @php $total = 0; @endphp
                <table width="100%" class="table-striped text-center" style="text-align: center; font-size: 12px;" cellpadding="2">
                    <thead>
                        <tr>
                            <td colspan="5" style="font-size: 15px; background-color: #000; color: #fff; font-weight: bold;">{{ $result[$i][0] . ' - ' . $result[$i][1] }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>FACTURA</td>
                            <td>FECHA DE VENCIMIENTO</td>
                            <td>VALOR PENDIENTE</td>
                            <td>PAGOS DE FACTURA</td>
                            <td>COMPROBANTES</td>
                        </tr>
                        @for($f = 0; $f < count($result[$i][2]); $f++)
                            @php $total += $result[$i][2][$f][2]; @endphp
                            <tr>
                                <td>{{ $result[$i][2][$f][0] }}</td>
                                <td>{{ $result[$i][2][$f][1] }}</td>
                                <td>${{ $result[$i][2][$f][2] }}</td>
                                <td>{{ $result[$i][2][$f][3] }}</td>
                                <td>{{ $result[$i][2][$f][4] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <span style="font-size: 12px; font-weight: bold; color: red;">TOTAL DE CARTERA: ${{ $total }}</span>
                <hr>
            @endfor
        <!-- </div> -->
    </body>
</html>