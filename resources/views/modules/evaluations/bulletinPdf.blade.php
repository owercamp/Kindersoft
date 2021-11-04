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
            *{
                padding: 0;
                text-align: center;
            }
            section{
                width: 100%;
            }

            article{
                display: inline-block;
                text-align: center;
            }

            table td{
                
            }
            .titles-table-intelligence{
                background: rgb(255,242,204);
                color: #000;
                font-weight: bold;
                border-color: #000;
            }
            .titles-table-results{
                background: rgb(255,242,204);
                color: rgb(237,125,49);
                font-size: 20px;
                font-weight: bold;
                border-color: #000;
            }
            .numbers{
                color: rgb(250,125,0);
                font-weight: bold;
                border-color: #000;
            }
        </style>
    </head>
    <body>
        @php
            function converterYearsoldFromBirtdate($date){
                $values = explode('-',$date);
                $day = $values[2];
                $mount = $values[1];
                $year = $values[0];
                $yearNow = Date('Y');
                $mountNow = Date('m');
                $dayNow = Date('d');
                //Cálculo de años
                $old = ($yearNow + 1900) - $year;
                if ( $mountNow < $mount ){ $old--; }
                if ($mount == $mountNow && $dayNow <$day){ $old--; }
                if ($old > 1900){ $old -= 1900; }
                //Cálculo de meses
                $mounts=0;
                if($mountNow>$mount && $day > $dayNow){ $mounts=($mountNow-$mount)-1; }
                else if ($mountNow > $mount){ $mounts=$mountNow-$mount; }
                else if($mountNow<$mount && $day < $dayNow){ $mounts=12-($mount-$mountNow); }
                else if($mountNow<$mount){ $mounts=12-($mount-$mountNow+1); }
                if($mountNow==$mount && $day>$dayNow){ $mounts=11; }
                $processed = $old . '-' . $mounts;
                return $processed;
            }
            
            function getYearsold($yearsold){
                $len = strlen($yearsold);
                if($len < 5 & $len > 0){
                    $separated = explode('-',$yearsold);
                    $mounts = ($separated[1]>1 ? $separated[1] . ' meses' : $separated[1] . ' mes');
                    return $separated[0] . ' años ' . $mounts;
                }else{
                    return $yearsold;
                }
            }

            function getFormatDate($date){
                $separatedDate = explode('-',$date);
                switch($separatedDate[1]){
                    case '01': return 'Enero ' . $separatedDate[2]; break; 
                    case '02': return 'Febrero ' . $separatedDate[2]; break; 
                    case '03': return 'Marzo ' . $separatedDate[2]; break; 
                    case '04': return 'Abril ' . $separatedDate[2]; break; 
                    case '05': return 'Mayo ' . $separatedDate[2]; break; 
                    case '06': return 'Junio ' . $separatedDate[2]; break; 
                    case '07': return 'Julio ' . $separatedDate[2]; break; 
                    case '08': return 'Agosto ' . $separatedDate[2]; break; 
                    case '09': return 'Septiembre ' . $separatedDate[2]; break; 
                    case '10': return 'Octubre ' . $separatedDate[2]; break; 
                    case '11': return 'Noviembre ' . $separatedDate[2]; break; 
                    case '12': return 'Diciembre ' . $separatedDate[2]; break; 
                }
            }
        @endphp
        <table width="100%" style="text-align: center;">
            <tr>
                <td style="width: 25%;">
                    @if(file_exists('storage/garden/logo.png'))
                        <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/logo.png') }}">
                    @else
                        @if(file_exists('storage/garden/logo.jpg'))
                            <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/logo.jpg') }}">
                        @else
                            <img style="width: 100px; height: auto;" src="{{ asset('storage/garden/default.png') }}">
                        @endif
                    @endif
                </td>
                <td style="width: 75%; font-family: 'Arial Black', 'Arial Bold'; font-size: 20px; font-weight: bold; color: rgb(0,32,96);">
                    <h4>BOLETIN ESCOLAR</h4>
                    @php
                        $letter = substr($course->name,-1);  
                        $year = substr($period->apDateInitial, 0, 4);
                    @endphp
                    <h4>{{ $period->apNameperiod }} - CALENDARIO {{ $letter }}</h4>
                    <h4>{{ $year }}</h4>
                </td>
            </tr>
        </table>
        <table width="100%" border="1">
            <tr>
                <td rowspan="4" style="background: #ccc;" nowrap>
                    <p style="transform: rotate(-90deg); color: #fff; font-weight: bold;">ALUMNO</p>
                </td>
                <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">CURSO</td>
                <td nowrap style="font-size: 15px font-weight: bold;">{{ $course->name }}</td>
                <td nowrap rowspan="4" style="align-items: center; border: none;">
                    @if(asset('storage/students/' . $student->photo))
                        <img style="width: 80px; height: auto;" src="{{ asset('storage/students/'.$student->photo) }}">
                    @else
                        <img style="width: 80px; height: auto;" src="{{ asset('storage/students/default.png') }}">
                    @endif
                </td>
            </tr>
            <tr>
                <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">NOMBRE</td>
                <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;">{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</td>
            </tr>
            <tr>
                <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">EDAD</td>
                <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;"><b class="yearsstudent">{{ getYearsold(converterYearsoldFromBirtdate($student->birthdate)) }}</b></td>
            </tr>
            <tr>
                <td nowrap style="font-style: 15px; font-weight: bold; color: rgb(0,32,96);">FECHA</td>
                <td nowrap style="text-align: left; padding-left: 5px; font-size: 15px font-weight: bold;">{{ getFormatDate($period->apDateInitial) }} a {{ getFormatDate($period->apDateFinal) }}</td>
            </tr>
        </table> 
        <hr>
        @php $validateRepeat = ''; @endphp
        @for($i = 0; $i < count($infoIntelligence); $i++)
            @php $findIntelligence = strpos($validateRepeat,(string)$infoIntelligence[$i][0]); @endphp
            @if($findIntelligence === false)
                <section>
                    <table width="100%" border="1" style="font-size: 11px; margin-top: 10px; max-width: 100%;">
                        <thead>
                            <tr>
                                <th class="titles-table-intelligence" colspan="2" style="width: 70px;">INTELIGENCIA</th>
                                <th class="titles-table-intelligence">LOGRO</th>
                                <th class="titles-table-intelligence">CALIFICACION</th>
                                <th class="titles-table-intelligence">ETAPA</th>
                            </tr>
                        </thead>
                        @php $row = 1; $validate = 0; ; @endphp
                        <tbody>
                            @if(count($infoAchievement) > 0)
                                @php 
                                    $validateOther = false;
                                    $totalPercentaje = 0;
                                    $itemsPercentaje = 0;
                                    $countAchievementFromThisIntelligence = 0;
                                @endphp

                                @for($m = 0; $m < count($infoAchievement); $m++)
                                    @if($infoAchievement[$m][0] == $infoIntelligence[$i][0])
                                        @php $countAchievementFromThisIntelligence++; @endphp
                                    @endif
                                @endfor

                                @for($a = 0; $a < count($infoAchievement); $a++)
                                    @if($infoAchievement[$a][0] == $infoIntelligence[$i][0])
                                        @php $validate++; @endphp
                                        @php $itemsPercentaje++; @endphp
                                        <tr>
                                            @if(!$validateOther)
                                                <td nowrap rowspan="{{ $countAchievementFromThisIntelligence }}" class="titles-table-intelligence" style="overflow: hidden; width: 5px;">
                                                    @php $len = strlen($infoIntelligence[$i][1]); @endphp
                                                    @if($len > 10)
                                                        @php $separatedSpace = explode(' ',$infoIntelligence[$i][1]); @endphp
                                                        @if(count($separatedSpace) > 1)
                                                            <p style="transform: rotate(-90deg);">
                                                                {{ $separatedSpace[0] }}
                                                                    <br>
                                                                {{ $separatedSpace[1] }}
                                                            </p>
                                                        @else
                                                            <p style="transform: rotate(-90deg);">
                                                                {{ $infoIntelligence[$i][1] }}
                                                            </p>
                                                        @endif
                                                    @else
                                                        <p style="transform: rotate(-90deg);">
                                                            {{ $infoIntelligence[$i][1] }}
                                                        </p>
                                                    @endif
                                                    @php $validateOther = true; @endphp
                                                </td>
                                            @endif
                                            @if($row%2 == 0)
                                                <td nowrap style="width: 20px; background: rgb(217,217,217);" class="numbers">{{ $row++ }}</td>
                                                <td nowrap style="text-align: left; padding-left: 5px; background: rgb(217,217,217);">{{ $infoAchievement[$a][1] }}</td>
                                                @if($infoAchievement[$a][3] == 'PENDIENTE' || $infoAchievement[$a][3] == 'INICIADO')
                                                    <!-- Color danger -->
                                                    <td nowrap style="background: #F7BE5D;">{{ $infoAchievement[$a][3] }}</td>
                                                @elseif($infoAchievement[$a][3] == 'EN PROCESO' || $infoAchievement[$a][3] == 'POR TERMINAR')
                                                    <!-- Color warning -->
                                                    <td nowrap style="background: #E8B3A9;">{{ $infoAchievement[$a][3] }}</td>
                                                @elseif($infoAchievement[$a][3] == 'COMPLETADO')
                                                    <!-- Color success -->
                                                    <td nowrap style="background: #A9BFE8;">{{ $infoAchievement[$a][3] }}</td>
                                                @endif
                                                <td nowrap class="numbers" style="background: rgb(217,217,217);">{{ $infoAchievement[$a][2] }}</td>
                                            @else
                                                <td nowrap style="width: 20px;" class="numbers">{{ $row++ }}</td>
                                                <td nowrap style="text-align: left; padding-left: 5px;">{{ $infoAchievement[$a][1] }}</td>
                                                @if($infoAchievement[$a][3] == 'PENDIENTE' || $infoAchievement[$a][3] == 'INICIADO')
                                                    <!-- Color danger -->
                                                    <td nowrap style="background: #F7BE5D;">{{ $infoAchievement[$a][3] }}</td>
                                                @elseif($infoAchievement[$a][3] == 'EN PROCESO' || $infoAchievement[$a][3] == 'POR TERMINAR')
                                                    <!-- Color warning -->
                                                    <td nowrap style="background: #E8B3A9;">{{ $infoAchievement[$a][3] }}</td>
                                                @elseif($infoAchievement[$a][3] == 'COMPLETADO')
                                                    <!-- Color success -->
                                                    <td nowrap style="background: #A9BFE8;">{{ $infoAchievement[$a][3] }}</td>
                                                @endif
                                                <td nowrap class="numbers" >{{ $infoAchievement[$a][2] }}</td>
                                            @endif
                                            @php $totalPercentaje +=  $infoAchievement[$a][2]; @endphp
                                        </tr>
                                    @endif
                                @endfor
                                @if($itemsPercentaje > 0)
                                    @php $total = bcdiv(($totalPercentaje / $itemsPercentaje), '1', 1); @endphp
                                @else
                                    @php $total = ''; @endphp
                                @endif

                                @if($validate > 0)
                                    <tr>
                                        <td nowrap colspan="3" class="titles-table-intelligence">
                                            PORCENTAJE LOGROS ALCANZADOS
                                        </td>
                                        <td nowrap class="titles-table-results">{{ $total }}%</td>
                                        <td nowrap class="titles-table-results">{{ $total }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td nowrap colspan="5" class="titles-table-intelligence">
                                            {{ $infoIntelligence[$i][1] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap colspan="5" class="titles-table-intelligence">
                                            SIN LOGROS PROGRAMADOS
                                        </td>
                                    </tr>
                                @endif

                                <!-- @if($validate == 0)
                                    <tr>
                                        <td colspan="5" class="titles-table-intelligence">
                                            {{ $infoIntelligence[$i][1] }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    @if($validate > 0)
                                        <td nowrap colspan="3" class="titles-table-intelligence">
                                            PORCENTAJE LOGROS ALCANZADOS
                                        </td>                                        
                                    @else
                                        <td nowrap colspan="3" class="titles-table-intelligence">
                                            SIN LOGROS PROGRAMADOS
                                        </td>
                                        @php
                                            $total = 'N/A';
                                        @endphp
                                    @endif
                                    <td nowrap class="titles-table-results">{{ $total }}%</td>
                                    <td nowrap class="titles-table-results">{{ $total }}</td>
                                </tr> -->
                            @endif
                        </tbody>
                    </table>
                </section>
                @php $validateRepeat .= $infoIntelligence[$i][0] . ':'; @endphp
            @endif
        @endfor
        <hr>
        <section>
            <table width="100%" border="1" style="font-size: 12px; max-width: 100%;">
                <thead>
                    <tr>
                        <td nowrap class="titles-table-intelligence">PORCENTAJE DEL PERIODO</td>
                        <td nowrap class="titles-table-intelligence">INTELIGENCIA</td>
                        <td nowrap class="titles-table-intelligence">PORCENTAJE</td>
                    </tr>
                    @php $totalIntelligence = 0;  @endphp
                    @php $itemsCountIntelligences = 0;  @endphp
                    @for($in = 0; $in < count($resultIntelligences); $in++)
                        <tr>
                            @if($in == 0)
                                <td style="font-size: 11px;" rowspan="{{ count($resultIntelligences) + 1 }}">
                                    <!-- Grafic -->
                                </td>
                            @endif
                            @if($resultIntelligences[$in][1] != 'N/A')
                                @php
                                    $totalIntelligence += $resultIntelligences[$in][1];
                                    $itemsCountIntelligences++;
                                @endphp
                            @endif
                            <td nowrap style="font-size: 11px; text-align: center; text-align: left; padding-left: 5px;">{{ $resultIntelligences[$in][0] }}</td>
                            <td nowrap style="font-size: 11px; text-align: center; font-weight: bold; text-align: center;">{{ $resultIntelligences[$in][1] }}%</td>
                        </tr>
                    @endfor
                    <tr>
                        <td class="titles-table-intelligence">PROMEDIO</td>
                        <td class="titles-table-results">{{ $totalIntelligence / $itemsCountIntelligences }}</td>
                    </tr>
                </thead>
            </table>
        </section>
        <section>
            
        </section>

        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

        <script>
        </script>
    </body>

</html>

