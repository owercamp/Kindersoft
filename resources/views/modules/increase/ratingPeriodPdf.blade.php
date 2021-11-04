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
            @page { margin: 40px 100px; }
            p{
                font-size: 13px;
            }
            ul > li{
                font-size: 10px;
            }
            small{
                font-size: 12px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td colspan="2" style="text-align: center;">
                    <h3 style="font-weight: bold;">VALORACION PERIODICA</h3>
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    <small>ALUMNO:</small><br>
                    <small>N° DOCUMENTO:</small><br>
                    <small>EDAD ACTUAL:</small><br>
                    <small>CURSO:</small><br>
                    <small>PERIODO:</small>
                    <hr>
                </td>
                <td style="text-align: left;">
                    <small class="text-muted">{{ $infoBasic[0] }}</small><br>
                    <small class="text-muted">{{ $infoBasic[1] }}</small><br>
                    <small class="text-muted">{{ $infoBasic[2] }}</small><br>
                    <small class="text-muted">{{ $infoBasic[3] }}</small><br>
                    <small class="text-muted">{{ $infoBasic[4] }}</small>
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <h6>TOMA ANTROPOMETRICA 1</h6>
                    <hr>
                </td>
                <td style="text-align: center;">
                    <h6>TOMA ANTROPOMETRICA 2</h6>
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <small>PESO</small><br>
                    <p>{{ $validateRating->rpWeight_one }}</p>
                    <small>TALLA</small><br>
                    <p>{{ $validateRating->rpHeight_one }}</p>
                    <small>OBSERVACION</small><br>
                    <p>{{ $validateRating->rpObservation_one }}</p>
                    <hr>
                </td>
                <td style="text-align: center;">
                    <small>PESO</small><br>
                    <p>{{ $validateRating->rpWeight_two }}</p>
                    <small>TALLA</small><br>
                    <p>{{ $validateRating->rpHeight_two }}</p>
                    <small>OBSERVACION</small><br>
                    <p>{{ $validateRating->rpObservation_two }}</p>
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>TAMIZAJE AUDITIVO:</small><br>
                    <p>{{ $validateRating->rpHealtear }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>TAMIZAJE VISUAL:</small><br>
                    <p>{{ $validateRating->rpHealteye }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>VALORACION SALUD ORAL:</small><br>
                    <div style="width: 100%;font-size: 12px;">
                        <p>{{ $validateRating->rpHealthoral }}</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>OBSERVACIONES DE SALUD:</small><br>
                    <ul>
                        @for($o = 0; $o < count($observations); $o++)
                            <li>{{ $observations[$o] }}</li>
                        @endfor
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>ESQUEMAS DE VACUNACION:</small><br>
                    <ul>
                        @for($v = 0; $v < count($vaccinations); $v++)
                            <li>{{ $vaccinations[$v][0] . ' - ' . $vaccinations[$v][1] }}</li>
                        @endfor
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify;">
                    <small>PROFESIONALES DE LA SALUD:</small><br>
                    <ul>
                        @for($p = 0; $p < count($professionals); $p++)
                            <li>{{ $professionals[$p] }}</li>
                        @endfor
                    </ul>
                </td>
            </tr>
        </table>
    </body>
</html>