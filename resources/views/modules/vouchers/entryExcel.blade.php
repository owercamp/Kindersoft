<table style="text-align: center;">
    <thead>
	    <tr>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">COMPROBANTE</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">BENEFICIARIO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">TIPO DE DOCUMENTO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">N° DE DOCUMENTO</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">ACUDIENTE</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">DOCUMENTO DE ACUDIENTE</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">FACTURA</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">VALOR PAGADO</th>
	    </tr>
    </thead>
    <tbody>
    @foreach($vouchers as $voucher)
        <tr>
            <td>{{ $voucher->venCode }}</td>
            <td>{{ $voucher->nameStudent }}</td>
            <td>{{ $voucher->typeDocument }}</td>
            <td>{{ $voucher->documentStudent }}</td>
            <td>{{ $voucher->nameAttendant }}</td>
            <td>{{ $voucher->documentAttendant }}</td>
            <td>{{ $voucher->facCode }}</td>
            <td>{{ $voucher->venPaid }}</td>
        </tr>
    @endforeach
    </tbody>
</table>