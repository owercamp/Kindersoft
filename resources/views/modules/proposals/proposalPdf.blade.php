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
      margin: 150px 50px;
    }

    #header {
      position: fixed;
      top: -150px;
      height: 100px;
      background-color: transparent;
      text-align: center;
    }

    #footer {
      position: fixed;
      bottom: -100;
      height: 70px;
      background-color: transparent;
    }

    span {
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
    <table width="100%" class="text-center" style="margin-top: 10px; margin-bottom: 10px; padding: 10px;">
      <tr>
        <td>
          <small class="text-muted"><b>COTIZACION</b></small><br>
        </td>
        <td>
          <small class="text-muted"><b>Fecha de cotización: </b><span> {{ $arrayProposal[0][0] }}</span></small><br>
        </td>
        <td>
          <small class="text-muted"><b>Total a pagar: </b></small><br>
        </td>
      </tr>
      <tr>
        <td>
          <small class="text-muted"><b>Código: </b><span> {{ $idProposal }}</span></small>
        </td>
        <td>
          <small class="text-muted"><b>Estado de cotización: </b></small><br>
          <h4 class="text-muted">{{ $arrayProposal[0][1] }}</h4>
        </td>
        <td>
          <h4 class="text-muted">${{ $arrayProposal[0][3] }}</h4>
        </td>
      </tr>
    </table>
    <hr>
    <table width="100%">
      <tr>
        <td colspan="3" style="padding: 5px; border-bottom: 1px solid #ccc;">
          <small class="text-muted">INFORMACION DE COTIZACION:</small>
        </td>
      </tr>
      <tr>
        <td class="text-left border-right" style="width: 30%; float: left; padding: 3px;">
          <small class="text-muted">Nombres de cliente:</small><br>
          <span>{{ $arrayProposal[0][4] }}</span><br>
          <small class="text-muted">Número de contacto:</small><br>
          <span>{{ $arrayProposal[0][5] }}</span><br>
          <small class="text-muted">Correo eletrónico:</small><br>
          <span>{{ $arrayProposal[0][6] }}</span><br>
          <small class="text-muted">Nombres de estudiante:</small><br>
          <span>{{ $arrayProposal[0][7] }}</span><br>
          <small class="text-muted">EDAD:</small><br>
          <span>{{ $arrayProposal[0][8] }}</span><br>
          <small class="text-muted">Grado:</small><br>
          <span>{{ $arrayProposal[0][9] }}</span>
        </td>
        <td colspan="2" style="margin: 0; padding: 0;">
          <table class="table text-right" width="100%" style="padding: 5px; border-collapse: collapse;">
            <thead>
              <tr style="border-bottom: 1px solid #ccc;">
                <th>ITEM</th>
                <th>CONCEPTO</th>
                <th>VALOR</th>
              </tr>
            </thead>
            <tbody>
              @php
              for( $i = 0 ; $i < count($arrayProposal) ; $i++ ){ if($i> 0){
                if($arrayProposal[$i][0] == 'ADMISION'){
                @endphp
                <tr>
                  <td><b><small class="text-center">ADMISION:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'JORNADA'){
                @endphp
                <tr>
                  <td><b><small class="text-center">JORNADA:</small></b></td>
                  <td>
                    <small class="text-muted">{{ $arrayProposal[$i][1] }}</small><br>
                    <small class="text-muted"><b>Detalles de jornada:</b></small><br>
                    <small class="text-muted">Dias: </small>{{ $arrayProposal[$i][2] }}<br>
                    <small class="text-muted">Entrada: </small>{{ $arrayProposal[$i][3] }}<br>
                    <small class="text-muted">Salida: </small>{{ $arrayProposal[$i][4] }}<br>
                  </td>
                  <td>
                    <small class="text-muted"><span>${{ $arrayProposal[$i][5] }}</span></small>
                  </td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'ALIMENTACION'){
                @endphp
                <tr>
                  <td><b><small class="text-center">ALIMENTACION:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'UNIFORME'){
                @endphp
                <tr>
                  <td><b><small class="text-center">UNIFORME:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'MATERIAL ESCOLAR'){
                @endphp
                <tr>
                  <td><b><small class="text-center">MATERIAL ESCOLAR:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'TRANSPORTE'){
                @endphp
                <tr>
                  <td><b><small class="text-center">TRANSPORTE:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'TIEMPO EXTRA'){
                @endphp
                <tr>
                  <td><b><small class="text-center">TIEMPO EXTRA:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][2] }}</small></td>
                </tr>
                @php
                }
                if($arrayProposal[$i][0] == 'EXTRACURRICULAR'){
                @endphp
                <tr>
                  <td><b><small class="text-center">EXTRACURRICULAR:</small></b></td>
                  <td><small class="text-muted">{{ $arrayProposal[$i][1] }} {{ $arrayProposal[$i][2] }}</small></td>
                  <td><small class="text-muted">${{ $arrayProposal[$i][3] }}</small></td>
                </tr>
                @php
                }
                }
                }
                @endphp
            </tbody>
          </table>
        </td>
      </tr>
      <tr style="border-top: 1pc solid #ccc;">
        <td>
          @if($arrayProposal[0][10] != 'N/A')
          @if(isset($arrayProposal[0][10]))
          <small class="text-muted">FIRMA:</small><br>
          <img src="{{ asset('storage/firms/'.$arrayProposal[0][10]) }}" style="width: 140px; height: auto;"><br>
          @else
          <h6 style="font-size: 12px; font-weight: bold;">SIN FIRMA</h6>
          @endif
          <span style="font-size: 12px; font-weight: bold;" class="text-muted">{{ $arrayProposal[0][11] }}</span><br>
          <span style="font-size: 12px; font-weight: bold;" class="text-muted">{{ $arrayProposal[0][12] }}</span>
          @else
          <h6 style="font-size: 12px; font-weight: bold;">SIN FIRMA</h6>
          @endif
        </td>
        <td style="text-align: center; padding-top: 5px;">
          <img src="{{ asset('storage/garden/'.$garden->garCode) }}" style="width: 100px; height: auto;">
        </td>
        <td style="text-align: right; font-size: 9px;">
          <small class="text-muted">Realizar pago en:</small><br>
          <small>{{ $general->fgBank }}</small><br>
          <small><b>CUENTA {{ $general->fgAccounttype }} N°: </b>{{ $general->fgNumberaccount }}</small><br>
          <small><b>TITULAR: </b>{{ $garden->garReasonsocial }}</small><br>
          <small><b>NIT: </b>{{ $garden->garNit }}</small>
        </td>
      </tr>
    </table>
    <footer id="footer">
      <img src="{{ asset('storage/garden/footerPdf.png') }}">
    </footer>
  </div>
</body>

</html>