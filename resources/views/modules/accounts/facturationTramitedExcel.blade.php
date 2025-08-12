<table style="text-align: center;" border="1">
    <thead>
	    <tr>
	        <th style="width: 30px; background: green; font-weight: bold;">FECHA DE FACTURACION</th>
	        <th style="width: 30px; background: green; font-weight: bold;">FACTURA #</th>
            <th style="width: 30px; background: green; font-weight: bold;">ALUMNO</th>
            <th style="width: 30px; background: green; font-weight: bold;">VALOR FACTURA</th>
	    </tr>
    </thead>
    <tbody>
    @foreach($tramited as $t)
        <tr>
            <td>{{ $t->facDateInitial }}</td>
            <td>{{ $t->facCode }}</td>
            <td>{{ $t->nameStudent }}</td>
            <td>{{ $t->facValue }}</td>
        </tr>
    @endforeach
    </tbody>
</table>