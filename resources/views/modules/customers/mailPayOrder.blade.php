<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title style="background-color: cornflowerblue; width:1280px; padding: 1.5% 2.5%; color: aliceblue; text-anchor: middle; font-weight: 800">ORDEN DE PAGO</title>
</head>
<hr>
<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
    <h5>buenos días,</h5> <br> <h6>{{$nameFat}}, {{$nameMot}}</h6> <br>
        <p style="text-align: justify; font-size: 12px; color: #000; padding: 20px; border: 1px solid green;">Adjunto encontrará la ORDEN DE PAGO número {{$code}} que emitimos el día {{date('d')}} del presente 
        mes por un valor de COP {{number_format($val,0,',','.')}}. Según los términos del contrato disponen hasta el día {{$dateFinal}} para proceder al pago que se realizará mediante ingreso o transferencia en la cuenta <strong>{{$countData->fgAccounttype}}</strong> del banco <strong>{{$countData->fgBank}}</strong> No. <strong>{{$countData->fgNumberaccount}}</strong>, a nombre de  {{ strtoupper($infoGarden->garReasonsocial) }}
        identificado con NIT No. <strong>{{ $infoGarden->garNit }}</strong>. En cualquier caso le agradeceríamos que nos comunicaran por este mismo medio el momento en el que realizan el pago de la factura para comprobar que todo es correcto y cerrar el seguimiento de la misma. Rogamos revisen los datos de la factura adjunta y si hubiera alguna incorrección nos lo indiquen lo antes posible para volver a emitirla. Sin otro particular y agradeciéndoles su confianza en nosotros <br><br>
        Atentamente,<br>
        Erika Patricia Pertuz<br>
        Directora Administrativa</p><br>
        <hr>
        <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 100px; height: auto;"><br>
    
</body>
</html>