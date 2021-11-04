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
    	@if(file_exists('storage/garden/logo.png'))
            <img src="{{ asset('storage/garden/logo.png') }}">
        @else
            @if(file_exists('storage/garden/logo.jpg'))
                <img src="{{ asset('storage/garden/logo.jpg') }}">
            @else
                <img src="{{ asset('storage/garden/default.png') }}">
            @endif
        @endif
		<div>
			<h2>LISTADO DE ASISTENCIA</h2>
			<h2>{{ $course }}</h2>
			<h2>{{ $date }}</h2>
		</div>
		<hr>
		<table border="1" width="100%">
			<caption align="top">ALUMNOS PRESENTES</caption>
			<thead>
				<tr>
					<th>NOMBRE</th>
					<th>IDENTIFICACION</th>
					<th>EDAD</th>
					<th>FECHA DE NACIMIENTO</th>
					<th>RANGO DE HORAS</th>
					<th>OBSERVACION DE LLEGADA</th>
					<th>OBSERVACION DE SALIDA</th>
					<th>JORNADA</th>
				</tr>
			</thead>
			<tbody>
				@if(count($datesStudentPresent) > 0)
					@for($i = 0; $i < count($datesStudentPresent); $i++)
						<tr>
							<td>{{ $datesStudentPresent[$i][0] }}</td>
							<td>{{ $datesStudentPresent[$i][1] }}</td>
							<td>{{ $datesStudentPresent[$i][2] }}</td>
							<td>{{ $datesStudentPresent[$i][3] }}</td>
							<td>{{ $datesStudentPresent[$i][4] . ' - ' . $datesStudentPresent[$i][5] }}</td>
							<td>{{ $datesStudentPresent[$i][6] }}</td>
							<td>{{ $datesStudentPresent[$i][7] }}</td>
							<td>{{ $datesStudentPresent[$i][8] }}</td>
						</tr>
					@endfor
				@else
					<tr>
						<td colspan="7">{{ __('SIN ALUMNOS PRESENTES REGISTRADOS') }}</td>
					</tr>
				@endif
					
			</tbody>
		</table>
		<hr>
		<table border="1" width="100%">
			<caption align="top">ALUMNOS AUSENTES</caption>
			<thead>
				<tr>
					<th>NOMBRE</th>
					<th>IDENTIFICACION</th>
					<th>EDAD</th>
					<th>FECHA DE NACIMIENTO</th>
					<th>JORNADA</th>
				</tr>
			</thead>
			<tbody>
				@if(count($datesStudentAbsent) > 0)
					@for($i = 0; $i < count($datesStudentAbsent); $i++)
						<tr>
							<td>{{ $datesStudentAbsent[$i][0] }}</td>
							<td>{{ $datesStudentAbsent[$i][1] }}</td>
							<td>{{ $datesStudentAbsent[$i][2] }}</td>
							<td>{{ $datesStudentAbsent[$i][3] }}</td>
							<td>{{ $datesStudentAbsent[$i][4] }}</td>
						</tr>
					@endfor
				@else
					<tr>
						<td colspan="4">{{ __('SIN AUSENCIAS REGISTRADAS') }}</td>
					</tr>
				@endif
					
			</tbody>
		</table>
    </body>
</html>