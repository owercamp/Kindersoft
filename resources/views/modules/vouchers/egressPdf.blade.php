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
    @page {
      margin: 50px 50px;
    }

    .title-field {
      background: rgba(178);
      background: rgba(217, 217, 217, 1);
      font-weight: bold;
      color: #000;
    }

    td {
      padding-left: 5px;
    }
  </style>
</head>

<body>
  @php

  function basico($numero) {
  $valor = array ('un','dos','tres','cuatro','cinco','seis','siete','ocho',
  'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno','veintidos','veintitres','veinticuatro','veinticinco',
  'veintiséis','veintisiete','veintiocho','veintinueve');
  return $valor[$numero - 1];
  }

  function decenas($n) {
  $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
  70=>'setenta',80=>'ochenta',90=>'noventa');
  if( $n <= 29) return basico($n); $x=$n % 10; if ( $x==0 ) { return $decenas[$n]; } else return $decenas[$n - $x].' y '. basico($x);
            }

            function centenas($n) {
                $cientos = array (100 =>' cien',200=>'doscientos',300=>'trecientos',
    400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
    700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
    if( $n >= 100) {
    if ( $n % 100 == 0 ) {
    return $cientos[$n];
    } else {
    $u = (int) substr($n,0,1);
    $d = (int) substr($n,1,2);
    return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
    }
    } else return decenas($n);
    }

    function miles($n) {
    if($n > 999) {
    if( $n == 1000) {return 'mil';}
    else {
    $l = strlen($n);
    $c = (int)substr($n,0,$l-3);
    $x = (int)substr($n,-3);
    if($c == 1) {$cadena = 'mil '.centenas($x);}
    else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
    else $cadena = centenas($c). ' mil';
    return $cadena;
    }
    } else return centenas($n);
    }

    function millones($n) {
    if($n == 1000000) {return 'un millón';}
    else {
    $l = strlen($n);
    $c = (int)substr($n,0,$l-6);
    $x = (int)substr($n,-6);
    if($c == 1) {
    $cadena = ' millón ';
    } else {
    $cadena = ' millones ';
    }
    return miles($c).$cadena.(($x > 0)?miles($x):'');
    $result = basico($c).$cadena.miles($c).(($x > 0)?miles($x):'');
    }
    }

    function convertir($n) {
    switch (true) {
    case ( $n >= 1 && $n <= 29) : return basico($n); break; case ( $n>= 30 && $n < 100) : return decenas($n); break; case ( $n>= 100 && $n < 1000) : return centenas($n); break; case ($n>= 1000 && $n <= 999999): return miles($n); break; case ($n>= 1000000): return millones($n);
            }
            }

            function getFormatDate($date) {
            $year = substr($date,0,4);
            $mount = substr($date,5,2);
            $day = substr($date,8,2);
            return $day . '/' . $mount . '/' . $year;
            }
            @endphp
            <br><br>
            <table class="table-hero" border="1" width="100%">
              <tr>
                <td colspan="4" rowspan="3" style="text-align: center; border-bottom: none;">
                  <h6 style="font-size: 20px;"><b>{{ $garden->garReasonsocial }}</b></h6>
                  <small style="font-size: 11px;"><b>{{ $garden->garAddress . ', ' . $garden->garNameDistrict . ' - ' . $garden->garNameCity . ' ' . $garden->garNameLocation }}</b></small><br>
                  <small style="font-size: 14px;"><a href='#' style="text-decoration: none; color: #000;">{{ $garden->garMailone . ' / + 57 ' . $garden->garPhone }}</a></small>
                </td>
                <td colspan="2" class="title-field" style="border: 1px solid #000; border-collapse: separate;">
                  <small class="text-left">NIT:</small>
                </td>
                <td colspan="2" class="text-center" style="border-collapse: separate;">
                  <small>{{ $garden->garNit }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="title-field" style="border: 1px solid #000; border-collapse: separate;">
                  <small class="text-left">Comprobante Egreso N°</small>
                </td>
                <td colspan="2" class="text-center" style="border-collapse: separate;">
                  <small class="text-center">{{ $voucher->vegCode }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="title-field" style="border: 1px solid #000; border-collapse: separate;">
                  <small class="text-left">Fecha Emisión</small>
                </td>
                <td colspan="2" class="text-center" style="border-collapse: separate;">
                  <small class="text-center">{{ getFormatDate($voucher->vegDate) }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="8" style="background: rgba(242,242,242,1); height: 15px; border-top: none;"></td>
              </tr>
              <tr>
                <td colspan="1" class="text-left title-field">
                  <small class="text-left">PROVEEDOR:</small>
                </td>
                <td colspan="3" class="text-left">
                  <small class="text-left">
                    {{ $voucher->namecompany }}
                  </small>
                </td>
                <td colspan="1" class="text-center title-field">
                  <small class="text-center">DOCUMENTO</small>
                </td>
                <td colspan="3" class="text-center">
                  <small class="text-center">{{ $voucher->numberdocument . '-' . $voucher->numbercheck }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="1" class="title-field text-left">
                  <small>La suma de:</small>
                </td>
                <td colspan="7" class="text-left">
                  <small style="font-size: 10px;">
                    {{ mb_strtoupper(convertir(round($voucher->vegPay))) . ' PESOS M/CTE' }}
                  </small>
                </td>
              </tr>
              <tr>
                <td colspan="1" class="title-field text-left">
                  <small>por concepto de:</small>
                </td>
                <td colspan="7" class="text-left" style="font-weight: bold;">
                  @if($voucher->vegConcept != null)
                  <small class="text-left">{{ mb_strtoupper($voucher->vegConcept) }}</small>
                  @endif
                </td>
              </tr>
              <tr>
                <td colspan="8" style="height: 15px; background: rgba(217,217,217,1); border-bottom: none;"></td>
              </tr>
              <tr>
                <td rowspan="3" colspan="2" class="text-center" style="border-bottom: none; border-right: none; border-top: none;">
                  @if(file_exists('storage/garden/logo.png'))
                  <img style="width: 90px; height: auto; margin-left: 10px; margin-top: 10px;" src="{{ asset('storage/garden/logo.png') }}">
                  @else
                  @if(file_exists('storage/garden/logo.jpg'))
                  <img style="width: 100px; height: auto; margin-left: 10px;" src="{{ asset('storage/garden/logo.jpg') }}">
                  @else
                  <img style="width: 100px; height: auto; margin-left: 10px;" src="{{ asset('storage/garden/default.png') }}">
                  @endif
                  @endif
                </td>
                <td rowspan="3" colspan="2" class="text-left" style="border-bottom: none; border-left: none; border-top: none; text-align: center; font-size: 12px;">
                  <b style="text-align: left;">Elaborado por,</b><br>
                  @if($firm != 'N/A')
                  @if(isset($firm->firm))
                  <img src="{{ asset('storage/firms/'.$firm->firm) }}" style="width: 140px; height: auto; margin-top: 10px;"><br>
                  {{ $firm->firstname . ' ' . $firm->threename . ' ' . $firm->fourname }}<br>
                  {{ $firm->position }}
                  @else
                  <h6 style="font-size: 12px; font-weight: bold;">SIN FIRMA</h6>
                  @endif
                  @else
                  <h6 style="font-size: 12px; font-weight: bold;">SIN FIRMA</h6>
                  @endif
                </td>
                <td colspan="2" class="title-field text-center">
                  <small class="text-center">Subtotal</small>
                </td>
                <td colspan="2" class="text-center">
                  <small>${{ round($voucher->vegSubpay) }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="title-field text-center">
                  <small class="text-center">Total IVA</small>
                </td>
                <td colspan="2" class="text-center">
                  <small>${{ round($voucher->vegValueiva) }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="title-field text-center">
                  <small>Total Retención</small>
                </td>
                <td colspan="2" class="text-center">
                  <small>${{ round($voucher->vegValueretention) }}</small>
                </td>
              </tr>
              <tr>
                <td colspan="4" class="text-left" style="border-top: none; height: 15px;">
                </td>
                <td colspan="2" class="title-field text-center">
                  <small>TOTAL EGRESO</small>
                </td>
                <td colspan="2" class="title-field text-center">
                  <small>${{ round($voucher->vegPay) }}</small>
                </td>
              </tr>
            </table>
</body>

</html>