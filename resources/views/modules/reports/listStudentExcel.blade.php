<table style="text-align: center;">
    <thead>
	    <tr>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">NOMBRE</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">DOCUMENTO</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">FECHA DE NACIMIENTO</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">EDAD ACTUAL</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">GRADO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">CORREO ACUDIENTE 1</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">CORREO ACUDIENTE 2</th>
	    </tr>
    </thead>
    <tbody>
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
    @endphp
    @for($i = 0; $i < count($students); $i++)
        <tr>
            <td>{{ $students[$i][0] }}</td>
            <td>{{ $students[$i][1] }}</td>
            <td>{{ $students[$i][2] }}</td>
            <td>{{ getYearsold(converterYearsoldFromBirtdate($students[$i][2])) }}</td>
            <td>{{ $students[$i][3] }}</td>
            <td>{{ $students[$i][4] }}</td>
            <td>{{ $students[$i][5] }}</td>
        </tr>
    @endfor
    </tbody>
</table>