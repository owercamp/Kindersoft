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
            span{
                font-size: 12px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <header id="header">
                <img src="{{ asset('storage/garden/headerPdf.png') }}">
            </header>
            <br>
            <div class="row mx-3 px-4 py-4">
                <div class="col-md-12 text-center">
                    <br>
                    <h6>{{ $garden->garNamecomercial }}</h6>
                    <h6>{{ $garden->garNit }}</h6>
                    <br>
                    <h5>CERTIFICA QUE</h5>
                    <br>
                    <br>
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
                        
                        function getStringDate($date){
                            $separatedDate = explode('-',$date);
                            switch($separatedDate[1]){
                                case '01': return $separatedDate[2] . ' dias del mes de enero de ' . $separatedDate[0]; break;
                                case '02': return $separatedDate[2] . ' dias del mes de febrero de ' . $separatedDate[0]; break;
                                case '03': return $separatedDate[2] . ' dias del mes de marzo de ' . $separatedDate[0]; break;
                                case '04': return $separatedDate[2] . ' dias del mes de abril de ' . $separatedDate[0]; break;
                                case '05': return $separatedDate[2] . ' dias del mes de mayo de ' . $separatedDate[0]; break;
                                case '06': return $separatedDate[2] . ' dias del mes de junio de ' . $separatedDate[0]; break;
                                case '07': return $separatedDate[2] . ' dias del mes de julio de ' . $separatedDate[0]; break;
                                case '08': return $separatedDate[2] . ' dias del mes de agosto de ' . $separatedDate[0]; break;
                                case '09': return $separatedDate[2] . ' dias del mes de septiembre de ' . $separatedDate[0]; break;
                                case '10': return $separatedDate[2] . ' dias del mes de octubre de ' . $separatedDate[0]; break;
                                case '11': return $separatedDate[2] . ' dias del mes de noviembre de ' . $separatedDate[0]; break;
                                case '12': return $separatedDate[2] . ' dias del mes de diciembre de ' . $separatedDate[0]; break;
                            }
                        }

                        function getFormatDate($date){
                            $separatedDate = explode('-',$date);
                            switch($separatedDate[1]){
                                case '01': return $separatedDate[2] . ' de Enero de ' . $separatedDate[0]; break; 
                                case '02': return $separatedDate[2] . ' de Febrero de ' . $separatedDate[0]; break; 
                                case '03': return $separatedDate[2] . ' de Marzo de ' . $separatedDate[0]; break; 
                                case '04': return $separatedDate[2] . ' de Abril de ' . $separatedDate[0]; break; 
                                case '05': return $separatedDate[2] . ' de Mayo de ' . $separatedDate[0]; break; 
                                case '06': return $separatedDate[2] . ' de Junio de ' . $separatedDate[0]; break; 
                                case '07': return $separatedDate[2] . ' de Julio de ' . $separatedDate[0]; break; 
                                case '08': return $separatedDate[2] . ' de Agosto de ' . $separatedDate[0]; break; 
                                case '09': return $separatedDate[2] . ' de Septiembre de ' . $separatedDate[0]; break; 
                                case '10': return $separatedDate[2] . ' de Octubre de ' . $separatedDate[0]; break; 
                                case '11': return $separatedDate[2] . ' de Noviembre de ' . $separatedDate[0]; break; 
                                case '12': return $separatedDate[2] . ' de Diciembre de ' . $separatedDate[0]; break; 
                            }
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

                    @endphp
                    <p class="text-justify">
                        <b>{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</b> identificado/a con el documento Nº <b>{{ $student->numberdocument }}</b> con fecha de nacimiento el día <b>{{ getFormatDate($student->birthdate) }}</b> y con una edad actual de <b>{{ getYearsold(converterYearsoldFromBirtdate($student->birthdate)) }}</b> se encuentra matriculado/a en el programa de  compromiso de atención a la primera infancia con el respectivo acudiente <b>{{ $attendant->firstname . ' ' . $attendant->threename }}</b> identificado/a con documento No. <b>{{ $attendant->numberdocument }}</b> mediante contrato de cooperación educativa No. <b>{{ $legalization->legId }}</b> con vigencia de <b>{{ getFormatDate($legalization->legDateInitial) }}</b> a <b>{{ getFormatDate($legalization->legDateFinal) }}</b>.<br>
                    </p>
                    <br>
                    @php $datenow = date('Y-m-d'); @endphp
                    Se expide en la ciudad de Bogotá D.C, a los <b>{{ getStringDate($datenow) }}</b>
                    <br>
                    <br>
                    <p class="text-left">
                        @if($garden->garFirm != null)
                            <img src="{{ asset('storage/garden/firm/'.$garden->garFirm) }}" style="width: 120px; height: auto;"><br>
                        @else
                            ____________________________________________________<br>
                        @endif
                        <small class="text-muted"><b>{{ $garden->garNamerepresentative }}</b></small><br>
                        DIRECTORA<br>
                    </p>
                </div>
            </div>
            <footer id="footer">
                <img src="{{ asset('storage/garden/footerPdf.png') }}">
            </footer>
        </div>       
    </body>

</html>