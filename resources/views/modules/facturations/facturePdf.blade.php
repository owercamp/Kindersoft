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
                font-size: 10px;
                font-weight: bold;
                color: #ccc;
                font-style: italic;
                line-height: 0;
            }
            .dates{
                font-size: 10px;
                color: #000;
                font-style: normal;
                font-weight: bold;
            }
            .dates-green{
                color: #a4b068;
                text-align: left;
            }
            .dates-small{
                font-size: 9px;
                color: #000;
            }
            .title-items{
                font-size: 11px;
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
        @php
        function returnType($value){
            switch($value){
                case 'Cedula de ciudadania' || 'Cédula de ciudadania':
                    return 'C.C:';
                break;
                case 'NUIP' || 'nuip':
                    return 'NUIP:';
                break;
                default: return $value; break;
            }
        }
        function returnDate($date){
            $mount = $date[5] . $date[6];
            $day = $date[8] . $date[9];
            $year = $date[0] . $date[1] . $date[2] . $date[3];
            switch($mount){
                case '01': return 'Enero ' . $day . ' de ' . $year; break;
                case '02': return 'Febrero ' . $day . ' de ' . $year; break;
                case '03': return 'Marzo ' . $day . ' de ' . $year; break;
                case '04': return 'Abril ' . $day . ' de ' . $year; break;
                case '05': return 'Mayo ' . $day . ' de ' . $year; break;
                case '06': return 'Junio ' . $day . ' de ' . $year; break;
                case '07': return 'Julio ' . $day . ' de ' . $year; break;
                case '08': return 'Agosto ' . $day . ' de ' . $year; break;
                case '09': return 'Septiembre ' . $day . ' de ' . $year; break;
                case '10': return 'Octubre ' . $day . ' de ' . $year; break;
                case '11': return 'Noviembre ' . $day . ' de ' . $year; break;
                case '12': return 'Diciembre ' . $day . ' de ' . $year; break;
            }
        }
        function returnRegime($value){
            switch($value){
                case 'COMUN': return 'IVA regimen común'; break;
                case 'SIMPLIFICADO': return 'IVA regimen simplificado'; break;
                case 'ESPECIAL': return 'IVA regimen especial'; break;
            }
        }
        function returnAutoretainer($value){
            switch($value){
                case 'SI': return 'somos autoretenedores'; break;
                case 'NO': return 'no somos autoretenedores'; break;
            }
        }
        function returnTaxpayer($value){
            switch($value){
                case 'SI': return 'somos grandes contribuyentes'; break;
                case 'NO': return 'no somos grandes contribuyentes'; break;
            }
        }
        function returnAccount($value){
            switch($value){
                case 'AHORRO': return 'Cuenta de ahorro'; break;
                case 'CORRIENTE': return 'Cuenta corriente'; break;
                case 'RECAUDO': return 'Cuenta de recaudo'; break;
                case 'FIDUCIA': return 'Cuenta fiducia'; break;
            }
        }
        function returnValueIva($value,$iva){
            return ($value * $iva) / 100;
        }
        @endphp
        <table width="100%">
            <tr>
                <td colspan="2" style="text-align: center;">
                    <h1 style="font-weight: bold; color: #ccc; font-size: 28px">ORDEN DE PAGO</h1>
                </td>
                <td rowspan="2" style="text-align: center;">
                    <img src="{{ asset('storage/garden/code.png') }}" style="width: 100px; height: auto;">
                </td>
                <td rowspan="2" style="padding-right: 10px;">
                    <p class="titles" style="line-height: 20px; text-align: right;">
                        <small class="text-muted titles"><span>{{ $facture[0][4] }} </span></small><br>
                        <small class="text-muted titles">NIT  <span>{{ $facture[0][6] }}</span></small><br>
                    <small class="text-muted titles"><span>{{ $facture[0][7] }}</span></small><br>
                    <small class="text-muted titles"><span>{{ $facture[0][8] }}</span> - <span>{{ $facture[0][9] }}</span></small><br>
                    <small class="text-muted titles"><span>{{ $facture[0][10] }}</span> / <span>+57 {{ $facture[0][11] }}</span></small>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <p class="titles" style="line-height: 15px; text-align: right;">
                        <small class="text-muted titles">Número:</small><br>
                        <small class="text-muted titles">Fecha:</small><br>
                        <small class="text-muted titles">Vencimiento:</small>
                    </p>
                </td>
                <td style="text-align: left; padding-left: 2px;">
                    <p class="titles" style="line-height: 15px; text-align: left;">
                        <small style="text-align: center; font-size: 12px; font-weight: bold; color: #54ADFF; line-height: 10px;">{{ $facture[0][1] }}</small><br>
                        <small class="text-muted dates" style="font-size: 12px;">{{ returnDate($facture[0][2]) }}</small><br>
                        <small class="text-muted dates" style="font-size: 12px;">{{ returnDate($facture[0][3]) }}</small>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" style="border: 1px solid #ccc;">
            <tr>
                <td style="text-align: right; width: 80px;">
                    <p class="titles" style="line-height: 15px; text-align: right;"><br>
                        <small class="text-muted titles" style="margin-top: 5px;">Cliente/s con {{ returnType($facture[1][3]) }}</small><br>
                        <small class="text-muted titles">Alumno:</small><br>
                        <small class="text-muted titles">Grado:</small><br>
                        <small class="text-muted titles">Domicilio:</small>
                    </p>
                </td>
                <td style="text-align: left;">

                    <p class="titles" style="line-height: 15px; text-align: left;">
                        <small class="dates dates-green" style="margin-top: 7px;">{{ $facture[1][1] }}<br>{{ $facture[1][2] }}</small><br>
                        <small class="dates dates-green">{{ $facture[1][4] . ' ' . $facture[1][5] . ' ' . $facture[1][6] }} </small><br>
                        <small class="dates dates-green">{{ $facture[1][7] }}</small><br>
                        <small class="dates dates-green">{{ $facture[1][8]  . ' CIUDAD: ' . $facture[1][9] }}</small>
                    </p>
                </td>
                <td style="border-left: 1px solid #ccc;">
                    <p class="titles" style="line-height: 15px; text-align: center;">
                        <small class="dates dates-small" style="margin-top: 5px;"><span>{{ returnRegime($facture[1][10]) }}</span> - <span>{{ returnTaxpayer($facture[1][11]) }}</span>, <span>{{ returnAutoretainer($facture[1][12]) }}</span></small><br>
                        <small class="dates dates-small"><span>Actividad económica: {{ $facture[1][13] }}</span></small><br>
                        <small class="dates dates-small"><span>Resolución de facturación: {{ $facture[1][14] }}</span></small><br>
                        <small class="dates dates-small"><span>{{ returnDate($facture[1][15]) }}</span> Autoriza <span>{{ $facture[1][16] . ' al ' . $facture[1][17] }}</span></small>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" style="border: 1px solid #ccc; text-align: center;" cellpadding="2">
            <tr class="text-center" style="border: 1px solid #ccc;">
                <th class="title-items">Código</th>
                <th class="title-items" colspan="2">Concepto</th>
                <th class="title-items">Unidades</th>
                <th class="title-items">valor unitario</th>
                <th class="title-items">Subtotal</th>
                <th class="title-items">% IVA</th>
                <th class="title-items">Valor IVA</th>
                <th class="title-items">Total</th>
            </tr>
            @php $countRow = 0; @endphp
            @for($i = 2;$i < count($facture);$i++)
                <tr style="border: 1px solid #ccc;">
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        {{ $facture[$i][1] }}
                    </td>
                    <td colspan="2" style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        {{ $facture[$i][2] }}
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        1
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        ${{ $facture[$i][3] }}
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        ${{ $facture[$i][3] }}
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        {{ $facture[$i][6] }}%
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        ${{ returnValueIva($facture[$i][3],$facture[$i][6]) }}
                    </td>
                    <td style="border: 1px solid #ccc; font-size: 10px; height: 20px;">
                        ${{ $facture[$i][5] }}
                    </td>
                </tr>
                @php $countRow++; @endphp
            @endfor
            @php $missingRow = 10 - $countRow; @endphp
            @for($i = 1; $i <= $missingRow; $i++)
                <tr style="border: 1px solid #ccc;">
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td colspan="2" style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                    <td style="border: 1px solid #ccc; height: 20px;"></td>
                </tr>
            @endfor
            <tr style="border: 1px solid #ccc;">
                <td rowspan="7" colspan="2" style="border: 1px solid #ccc; text-align: center;">
                    @if(file_exists('storage/garden/logo.png'))
                        <img src="{{ asset('storage/garden/logo.png') }}" style="width: 140px; height: auto; position: relative;margin-top: 15px">
                    @else
                        @if(file_exists('storage/garden/logo.jpg'))
                            <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 140px; height: auto; position: relative;margin-top: 15px">
                        @else
                            <img src="{{ asset('storage/garden/default.png') }}" style="width: 140px; height: auto; position: relative;margin-top: 15px">
                        @endif
                    @endif
                </td>
                <td style="text-align: right; border-bottom: 1px solid #ccc; color: #000; font-size: 11px;">
                    Subtotal
                </td>
                <td style="text-align: center; border-bottom: 1px solid #ccc; font-size: 10px;">
                    {{ $countRow }}
                </td>
                <td colspan="5" style="text-align: left; border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; font-size: 11px; margin-left: 5px;">
                    $ {{ $totalAbsolutNotIva }}
                </td>
            </tr>
            <tr style="border: 1px solid #ccc;">
                <td style="text-align: right;  border-bottom: 1px solid #ccc; color: #000; font-size: 11px;">
                    Descuento
                </td>
                <td colspan="6" style="text-align: right;  border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" class="text-muted titles">
                    $ {{ $discount }}
                </td>
            </tr>
            <tr style="border: 1px solid #ccc;">
                <td style="text-align: right;  border-bottom: 1px solid #ccc; color: #000; font-size: 11px;">
                    Base Imponible
                </td>
                <td colspan="6" style="text-align: right;  border-bottom: 1px solid #ccc; border-right: 1px solid #ccc;" class="text-muted titles">
                    $ {{ $totalAbsolutNotIva }}
                </td>
            </tr>
            <tr>
                <td style="text-align: right; color: #000; font-size: 11px;">
                    I.V.A.
                </td>
                <td style="border: 1px solid #ccc;"></td>
                <td style="border: 1px solid #ccc;"></td>
                <td style="border: 1px solid #ccc; text-align: center;" class="text-muted titles">
                    {{ $iva }},00%
                </td>
                <td colspan="3" style="border-right: 1px solid #ccc;"></td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid #ccc; text-align: center; padding: 2px; font-size: 11px;">
                    $ -
                </td>
                <td style="border: 1px solid #ccc; text-align: center; padding: 2px; font-size: 11px;">
                    $ -
                </td>
                <td style="border: 1px solid #ccc; text-align: center; padding: 2px; font-size: 11px;">
                    $ {{ $totalAbsolutOnlyIva }}
                </td>
                <td colspan="3" style="border-right: 1px solid #ccc; text-align: right; padding: 2px; font-size: 11px;">
                    $ {{ $totalAbsolutNotIva }}
                </td>   
            </tr>
            <tr>
                <td style="text-align: right; color: #000; font-size: 11px;">
                    Recargo equivalencia
                </td>
                <td colspan="6" style="text-align: right; border-right: 1px solid #ccc; font-size: 11px;">
                    $     -
                </td>
            </tr>
            <tr>
                <td colspan="4" class="title-items" style="text-align: right;">
                    TOTAL A PAGAR
                </td>
                <td colspan="3" class="title-items title-blue" style="border-right: 1px solid #ccc; font-size: 20px;">
                    ${{ number_format($totalAbsolut,0,',','.') }}
                </td>
            </tr>
            <tr>
                <td colspan="9" style="height: 15px;"></td>
            </tr>
            <tr>
                <td colspan="9" class="dates dates-small" style="text-align: center; height: 15px;">
                    Realizar pago <b>{{ $facture[1][18] }}</b> - {{ returnAccount($facture[1][19]) }} N° {{ $facture[1][20] }} - <b>Titular</b> {{ $facture[0][4] }}
                </td>
            </tr>
            <tr>
                <td colspan="9" style="background-color: #ccc; height: 15px;"></td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: center;" class="dates dates-small">
                    Impreso por computador - Software web KINDERSOFT
                </td>
            </tr>
            <tr>
                <td colspan="9" style="height: 15px;"></td>
            </tr>
            <tr>
                <td colspan="4" class="dates" style="border: 1px solid #ccc; text-align: justify; line-height: 15px; font-size: 12px;">
                        La presente factura cambiaría  de compraventa se asimila
                        en todos sus efectos legales a una letra de cambio, según
                        artículo 77a y s.s. del código de comercio, Asi mismo por
                        medio de esta factura el comprador aceptante declara
                        haber recibido real y a satisfacción descritas en este título
                        valor y se obliga a pagar el precio en la forma pactada
                </td>
                <td colspan="5" style="border: 1px solid #ccc; text-align: center; padding: 2px;" class="dates dates-small">
                    <p style="text-align: left; color: #000; font-size: 12px; margin-left: 50px;">Elaborado por,</p>
                    @if($facture[1][22] != 'N/A')
                        @if(isset($facture[1][22]))
                            <img src="{{ asset('storage/firms/'.$facture[1][22]) }}" style="width: 100px; height: auto;"><br>
                            {{ $facture[1][23] }} <br> {{ $facture[1][24] }}
                        @else
                            <h6 style="font-size: 13px; font-weight: bold; color: #ccc; text-align: center;">SIN FIRMA</h6><br>
                        @endif
                    @else
                        <h6 style="font-size: 13px; font-weight: bold; color: #ccc; text-align: center;">SIN FIRMA</h6>
                    @endif
                </td>
            </tr>
        </table>
    </body>
</html>