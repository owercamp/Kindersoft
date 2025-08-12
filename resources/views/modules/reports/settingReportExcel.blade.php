<table style="text-align: center;">
    <thead>
	    <tr>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">NOMBRE</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">EDAD ACTUAL</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">FECHA DE NACIMIENTO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">TIPO DE DOCUMENTO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">No DE DOCUMENTO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">GENERO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">TIPO DE SANGRE</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">AFILIACION EPS</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">SALUD ADICIONAL</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">DESCRIPCION DE SALUD ADICIONAL</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">CIUDAD</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">LOCALIDAD</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">BARRIO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">DIRECCION</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">GRADO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">NOMBRE DE ACUDIENTE 1</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">DOCUMENTO DE ACUDIENTE 1</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">CORREO ELECTRONICO 1</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">MOVIL DE ACUDIENTE 1</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">NOMBRE DE ACUDIENTE 2</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">DOCUMENTO DE ACUDIENTE 2</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">CORREO ELECTRONICO 2</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">MOVIL DE ACUDIENTE 2</th>
	        <!-- <th style="width: 30px; background: #ddc; font-weight: bold;">FECHA DE INICIO</th>
	        <th style="width: 30px; background: #ddc; font-weight: bold;">FECHA DE FINALIZACION</th> -->
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
		@for($i = 0; $i < count($contract); $i++)
			<tr>
				<td>{{ $contract[$i][0] }}</td>
				<td>{{ getYearsold(converterYearsoldFromBirtdate($contract[$i][2])) }}</td>
				<td>{{ $contract[$i][2] }}</td>
				<td>{{ $contract[$i][3] }}</td>
				<td>{{ $contract[$i][4] }}</td>
				<td>{{ $contract[$i][5] }}</td>
				<td>{{ $contract[$i][6] }}</td>
				<td>{{ $contract[$i][7] }}</td>
				<td>{{ $contract[$i][8] }}</td>
				<td>{{ $contract[$i][9] }}</td>
				<td>{{ $contract[$i][10] }}</td>
				<td>{{ $contract[$i][11] }}</td>
				<td>{{ $contract[$i][12] }}</td>
				<td>{{ $contract[$i][13] }}</td>
				<td>{{ $contract[$i][14] }}</td>
				<td>{{ $contract[$i][15] }}</td>
				<td>{{ $contract[$i][16] }}</td>
				<td>{{ $contract[$i][17] }}</td>
				<td>{{ $contract[$i][18] }}</td>
				<td>{{ $contract[$i][19] }}</td>
				<td>{{ $contract[$i][20] }}</td>
				<td>{{ $contract[$i][21] }}</td>
				<td>{{ $contract[$i][22] }}</td>
			</tr>
		@endfor
    </tbody>
</table>