<table style="text-align: center;">
    <thead>
	    <tr>
	        <th colspan="16" rowspan="2"
                style="
                    width: 100px;
                    background: #70AD47;
                    border: 6px solid #000000;
                    color: #ffffff;
                    font-size: 20px;
                    text-align: center;
                    line-height: 30px;
                ">
                {{ $garden->garNamecomercial }} / PRESUPUESTO PERIODO {{ $yearReport }}
            </th>
	    </tr>
        <tr></tr>
    </thead>
    <tbody>
        <tr style="border: 6px solid #000000;">
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 6px;
                    font-weight: bold;
                "
            >
                ITEM
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 30px;
                    font-weight: bold;
                " colspan="2" 
            >
                DESCRIPCION DE LA ACTIVIDAD
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                ENERO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                FEBRERO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                MARZO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                ABRIL
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                MAYO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                JUNIO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                JULIO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                AGOSTO
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                SEPTIEMBRE
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                OCTUBRE
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                NOVIEMBRE
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                DICIEMBRE
            </td>
            <td 
                style="
                    background-color: #00B050;
                    border: 6px solid #000000;
                    text-align: center;
                    color: #ffffff;
                    width: 17px;
                    font-weight: bold;
                "
            >
                TOTAL GENERAL
            </td>
        </tr>
    </tbody>
</table>
@php $structure = 1; @endphp
@for($s = 0; $s < count($report); $s++)
    <table border>
        <thead>
            <tr style="border: 3px solid #000000;">
                <td colspan="16"
                    style="
                        background-color: #00B050;
                        border: 3px solid #000000;
                        font-weight: bold;
                        color: #ffffff;
                    "
                >
                    {{ $structure++ . '. ' . $report[$s][0] }}
                </td>
            </tr>
            <tr>
                <td colspan="16" style="height: 5px;"></td>
            </tr>
        </thead>
        <tbody>
            @php
                $item = 1;
                $totalJanuaryP = 0;
                $totalFebruaryP = 0;
                $totalMarchP = 0;
                $totalAprilP = 0;
                $totalMayP = 0;
                $totalJuneP = 0;
                $totalJulyP = 0;
                $totalAugustP = 0;
                $totalSeptemberP = 0;
                $totalOctoberP = 0;
                $totalNovemberP = 0;
                $totalDecemberP = 0;
                $totalMountP = 0;

                $totalJanuaryE = 0;
                $totalFebruaryE = 0;
                $totalMarchE = 0;
                $totalAprilE = 0;
                $totalMayE = 0;
                $totalJuneE = 0;
                $totalJulyE = 0;
                $totalAugustE = 0;
                $totalSeptemberE = 0;
                $totalOctoberE = 0;
                $totalNovemberE = 0;
                $totalDecemberE = 0;
                $totalMountE = 0;
            @endphp
            @for($d = 0; $d < count($report[$s][1]); $d++)
                <tr>
                    <td rowspan="2"
                        style="
                            background-color: #00B050;
                            text-align: center;
                            font-weight: bold;
                            border: 3px solid #000000;
                        "

                    >
                        {{ $item++ }}.
                    </td>
                    <td rowspan="2"
                        style="
                            border: 3px solid #000000;
                            background-color: #A9D08E;
                            text-align: center;
                        "
                    >
                        {{ $report[$s][1][$d][0] }}
                    </td>
                    <td style="background-color: #548235; border: 3px solid #000000; font-weight: bold; text-align: center; width: 10px;">P</td><!-- PRESUPUESTO -->
                    @for($v = 0; $v < count($report[$s][1][$d][1]); $v++)
                        @if($v == 0)
                            @php $totalJanuaryP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 1)
                            @php $totalFebruaryP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 2)
                            @php $totalMarchP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 3)
                            @php $totalAprilP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 4)
                            @php $totalMayP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 5)
                            @php $totalJuneP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 6)
                            @php $totalJulyP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 7)
                            @php $totalAugustP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 8)
                            @php $totalSeptemberP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 9)
                            @php $totalOctoberP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 10)
                            @php $totalNovemberP += $report[$s][1][$d][1][$v]; @endphp
                        @elseif($v == 11)
                            @php $totalDecemberP += $report[$s][1][$d][1][$v]; @endphp
                        @endif
                        @if($v%2==0)
                            <td style="background-color: #E2EFDA; border: 3px solid #000000; text-align: center;">
                                ${{ $report[$s][1][$d][1][$v] }}
                            </td>    
                        @else 
                            <td style="background-color: #C6E0B4; border: 3px solid #000000; text-align: center;">
                                ${{ $report[$s][1][$d][1][$v] }}
                            </td>    
                        @endif
                    @endfor
                    <td style="background-color: #E2EFDA; border: 3px solid #000000; text-align: center;">${{ $report[$s][1][$d][3] }}</td>
                    @php $totalMountP += $report[$s][1][$d][3]; @endphp
                </tr>
                <tr>
                    <td style="background-color: #00B050; border: 3px solid #000000; font-weight: bold; text-align: center; width: 10px;">E</td><!-- EJECUTADO -->
                    @for($v = 0; $v < count($report[$s][1][$d][2]); $v++)
                        @if($v == 0)
                            @php $totalJanuaryE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 1)
                            @php $totalFebruaryE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 2)
                            @php $totalMarchE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 3)
                            @php $totalAprilE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 4)
                            @php $totalMayE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 5)
                            @php $totalJuneE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 6)
                            @php $totalJulyE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 7)
                            @php $totalAugustE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 8)
                            @php $totalSeptemberE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 9)
                            @php $totalOctoberE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 10)
                            @php $totalNovemberE += $report[$s][1][$d][2][$v]; @endphp
                        @elseif($v == 11)
                            @php $totalDecemberE += $report[$s][1][$d][2][$v]; @endphp
                        @endif
                        @if($v%2==0)
                            <td style="background-color: #E2EFDA; border: 3px solid #000000; text-align: center;">
                                ${{ $report[$s][1][$d][2][$v] }}
                            </td>    
                        @else 
                            <td style="background-color: #C6E0B4; border: 3px solid #000000; text-align: center;">
                                ${{ $report[$s][1][$d][2][$v] }}
                            </td>    
                        @endif
                    @endfor
                    <td style="background-color: #E2EFDA; border: 3px solid #000000; text-align: center;">${{ $report[$s][1][$d][4] }}</td>
                </tr>
            @endfor
            <tr>
                <td style="height: 15px;"></td>
                <td style="height: 15px; text-align: right; font-weight: bold;">
                    TOTAL PRESUPUESTO MES
                </td>
                <td style="background-color: #548235; border: 3px solid #000000; font-weight: bold; text-align: center; width: 10px;">
                    P
                </td>
                @for($t = 0; $t <= 11; $t++)
                    @if($t == 0)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJanuaryP }}
                        </td>
                    @elseif($t == 1)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalFebruaryP }}
                        </td>
                    @elseif($t == 2)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalMarchP }}
                        </td>
                    @elseif($t == 3)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalAprilP }}
                        </td>
                    @elseif($t == 4)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalMayP }}
                        </td>
                    @elseif($t == 5)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJuneP }}
                        </td>
                    @elseif($t == 6)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJulyP }}
                        </td>
                    @elseif($t == 7)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalAugustP }}
                        </td>
                    @elseif($t == 8)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalSeptemberP }}
                        </td>
                    @elseif($t == 9)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalOctoberP }}
                        </td>
                    @elseif($t == 10)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalNovemberP }}
                        </td>
                    @elseif($t == 11)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalDecemberP }}
                        </td>
                    @endif
                @endfor
                <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                    ${{ $totalMountP }}
                </td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td style="height: 15px; text-align: right; font-weight: bold;">
                    TOTAL EJECUTADO MES
                </td>
                <td style="background-color: #00B050; border: 3px solid #000000; font-weight: bold; text-align: center; width: 10px;">
                    E
                </td>
                @for($t = 0; $t <= 11; $t++)
                    @if($t == 0)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJanuaryE }}
                        </td>
                    @elseif($t == 1)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalFebruaryE }}
                        </td>
                    @elseif($t == 2)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalMarchE }}
                        </td>
                    @elseif($t == 3)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalAprilE }}
                        </td>
                    @elseif($t == 4)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalMayE }}
                        </td>
                    @elseif($t == 5)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJuneE }}
                        </td>
                    @elseif($t == 6)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalJulyE }}
                        </td>
                    @elseif($t == 7)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalAugustE }}
                        </td>
                    @elseif($t == 8)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalSeptemberE }}
                        </td>
                    @elseif($t == 9)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalOctoberE }}
                        </td>
                    @elseif($t == 10)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalNovemberE }}
                        </td>
                    @elseif($t == 11)
                        <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                            ${{ $totalDecemberE }}
                        </td>
                    @endif
                @endfor
                <td style="background-color: #70AD47; text-align: center; font-weight: bold; color: #ffffff; border: 6px solid #000000;">
                    ${{ $totalMountE }}
                </td>
            </tr>
        </tbody>
    </table>
@endfor


<!-- 


SUBTITULOS DE TABLA y NUMERO DE ITEMS: rgb(0,176,80) = #00B050 
TITULO PRINCIPAL: rgb(112,173,71) = #70AD47

TITULOS ITEMS: rgb(169,208,142) = #A9D08E

P: rgb(84,130,53) = #548235
E: rgb(0,176,80) = #00B050
$ OSCURO: rgb(198,224,180) = #C6E0B4
$ CLARO: rgb(226,239,218) = #E2EFDA


-->