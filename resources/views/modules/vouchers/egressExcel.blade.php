<table style="text-align: center;">
    <thead>
	    <tr>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">COMPROBANTE</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">FECHA DE EGRESO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">TERCERO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">DOCUMENTO DE TERCERO</th>
	        <th style="width: 30px; background: #ccc; font-weight: bold;">VALOR PAGADO</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">VALOR IVA</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">VALOR RETENCION</th>
            <th style="width: 30px; background: #ccc; font-weight: bold;">VALOR RETEICA</th>
	    </tr>
    </thead>
    <tbody>
    @foreach($vouchers as $voucher)
        <tr>
            <td>{{ $voucher->vegCode }}</td>
            <td>{{ $voucher->vegDate }}</td>
            <td>{{ $voucher->namecompany }}</td>
            @if($voucher->numbercheck != null)
                <td>{{ $voucher->numberdocument . '-' . $voucher->numbercheck }}</td>
            @else
                <td>{{ $voucher->numberdocument }}</td>
            @endif
            <td>{{ $voucher->vegPay }}</td>
            <td>{{ $voucher->vegValueiva }}</td>
            <td>{{ $voucher->vegValueretention }}</td>
            <td>{{ $voucher->vegValuereteica }}</td>
        </tr>
    @endforeach
    </tbody>
</table>