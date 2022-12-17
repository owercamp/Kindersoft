<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Para bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <style>
    @page {
      margin: 180px 70px 50px 70px;
    }

    #header {
      position: fixed;
      left: 0px;
      top: -150px;
      right: 0px;
      height: 150px;
      background-color: transparent;
      text-align: center;
    }

    #footer {
      position: fixed;
      left: 0px;
      bottom: -50px;
      right: 0px;
      height: 50px;
      background-color: transparent;
    }

    #footer .page:after {
      content: counter(page, upper-roman);
    }

    .pagination-page {
      position: absolute;
      bottom: -50px;
      left: 0;
      right: 0;
    }

    small.text-index:before {
      content: "Página "counter(contador-tema);
    }

    small.text-index {
      counter-increment: contador-tema;
      counter-reset: contador-parte;
    }

    /*h6.text-index:before {content: counter(contador-tema) "." counter(contador-parte); }*/
    /*h6.text-index {counter-increment: contador-parte; }*/
    @media print {
      * {
        color: black;
      }

      small.text-index {
        page-break-before: always;
      }
    }

    small.text-index {
      text-align: center;
      display: block;
      width: 50px;
      height: 50px;
      border: 1px solid #ccc;
      padding: 5px;
    }
  </style>
</head>

<body>
  <div id="header">
    @php $index = 1; @endphp
    <table width="100%" style="border: 1px solid #ccc;">
      <tr>
        <td rowspan="2" style="border: 1px solid #ccc; border-collapse: collapse; text-align: center;">
          @if(file_exists('storage/garden/logo.png'))
          <img style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany" src="{{ asset('storage/garden/logo.png') }}">
          @else
          @if(file_exists('storage/garden/logo.jpg'))
          <img style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany" src="{{ asset('storage/garden/logo.jpg') }}">
          @else
          <img style="width: 100px; height: 100px; margin-top: 10px;" class="infoImgCompany" src="{{ asset('storage/garden/default.png') }}">
          @endif
          @endif
        </td>
        <td rowspan="2" style="border: 1px solid #ccc; border-collapse: collapse;">
          <h5 class="text-muted" style="font-size: 10; font-weight: bold; text-align: center;">
            <b>CONTRATO DE COOPERACIÓN EDUCATIVA</b><br>
            {{ mb_strtoupper($garden->garReasonsocial) }}<br>
            {{ mb_strtoupper($garden->garAddress) }}<br>
            {{ mb_strtoupper($garden->garPhoneone) . ' - ' . mb_strtoupper($garden->garPhone) }}<br>
            {{ mb_strtoupper($garden->garMailone) }}
          </h5>
        </td>
        <td colspan="2" style="border: 1px solid #ccc; border-collapse: collapse; text-align: center;">
          <script type="text/php">
            if ( isset($pdf) ) {
                                $pdf->page_script('
                                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                                    $pdf->text(435, 36, "Página $PAGE_NUM de $PAGE_COUNT", $font, 13);
                                ');
                            }
                        </script>
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid #ccc; border-collapse: collapse; text-align: center;">
          <h6 class="text-muted" style="margin-top: 0.5rem;">CONTRATO N°</h6>
        </td>
        <td style="border: 1px solid #ccc; border-collapse: collapse; text-align: center; vertical-align: 1.5rem; font-size: 2rem;">
          {{ returnLegalization($legalization->legId) }}
        </td>
      </tr>
    </table>
  </div>
  {{-- <div id="footer" align="center">
            <div>
                <small class="text-muted text-index">
                    <!-- <h6 class="text-muted text-index"></h6> -->
                </small>
                <!-- <p class="pagination-page">{{ $index++ }}</p> -->
  </div>
  </div> --}}
  @php
  function returnYearsold($value){
  $separated = explode('-',$value);
  return $separated[0] . ' año/s con ' . $separated[1] . ' mes/es';
  }
  function returnLegalization($id){
  $len = strlen($id);
  if($len > 1){
  return '0' . $id;
  }else{
  return '00' . $id;
  }
  }
  function returnNumberDay($date){
  $day = substr($date,-2);
  return $day;
  }
  function returnFormatDate($date){
  $mount= '';
  $find = strpos($date,'-');
  if($find > 0){
  $separated = explode('-',$date);
  return getStringFormatMount($separated[1]) . ' ' . $separated[2] . ' de ' . $separated[0];
  }else{
  $separated = explode('/',$date);
  return getStringFormatMount($separated[1]) . ' ' . $separated[2] . ' de ' . $separated[0];
  }
  }

  function getStringFormatMount($mount){
  switch($mount){
  case '01': return 'Enero'; break;
  case '02': return 'Febrero'; break;
  case '03': return 'Marzo'; break;
  case '04': return 'Abril'; break;
  case '05': return 'Mayo'; break;
  case '06': return 'Junio'; break;
  case '07': return 'Julio'; break;
  case '08': return 'Agosto'; break;
  case '09': return 'Septiembre'; break;
  case '10': return 'Octubre'; break;
  case '11': return 'Noviembre'; break;
  case '12': return 'Diciembre'; break;
  }
  }
  function returnFormatMount($date){
  $mount = substr($date,5,2);
  return getStringFormatMount($mount);
  }

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
  if ( $mountNow < $mount ){ $old--; } if ($mount==$mountNow && $dayNow <$day){ $old--; } if ($old> 1900){ $old -= 1900; }
    //Cálculo de meses
    $mounts=0;
    if($mountNow>$mount && $day > $dayNow){ $mounts=($mountNow-$mount)-1; }
    else if ($mountNow > $mount){ $mounts=$mountNow-$mount; }
    else if($mountNow<$mount && $day < $dayNow){ $mounts=12-($mount-$mountNow); } else if($mountNow<$mount){ $mounts=12-($mount-$mountNow+1); } if($mountNow==$mount && $day>$dayNow){ $mounts=11; }
      $processed = $old . '-' . $mounts;
      return $processed;
      }

      function getYearsold($yearsold){
      $len = strlen($yearsold);
      if($len < 5 & $len> 0){
        $separated = explode('-',$yearsold);
        $mounts = ($separated[1]>1 ? $separated[1] . ' meses' : $separated[1] . ' mes');
        return $separated[0] . ' años ' . $mounts;
        }else{
        return $yearsold;
        }
        }
        @endphp
        <div id="content">
          <p style="text-align: justify; font-size: 12px;">
            {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }} identificado con el NIT {{ mb_strtoupper($garden->garNit) }}, representada legalmente por {{ mb_strtoupper($garden->garNamerepresentative) }}, mayor de edad, domiciliada en la ciudad de Bogotá, identificada con la cédula de ciudadanía No. C.C. No. {{ mb_strtoupper($garden->garCardrepresentative) }} de Bogotá, en mi condición de representante legal y Directora de {{ mb_strtoupper($garden->garNamecomercial) }}, beneficiario <b>{{ $student->firstname . ' ' . $student->threename . ' ' . $student->fourname }}</b> edad {{ getYearsold(converterYearsoldFromBirtdate($student->birthdate)) }}, realizamos este contrato de atención a la primera infancia con
            @php
            if(isset($attendantFather)){
            echo '<b>' . $attendantFather->firstname . ' ' . $attendantFather->threename . ' (Acudiente 1)</b>';
            }else{
            echo '____________________________________ (Acudiente 1)';
            }
            echo ' y ';
            if(isset($attendantMother)){
            echo '<b>' . $attendantMother->firstname . ' ' . $attendantMother->threename . ' (Acudiente 2)</b>';
            }else{
            echo '____________________________________ (Acudiente 2)';
            }
            @endphp
            , domiciliados en la ciudad de Bogotá, personas igualmente mayores de edad, identificadas como aparece al pie de sus firmas en su condición de Padres de Familia o Acudiente, Deudor y Codeudor del Beneficiario, celebramos el presente contrato, el cual se regirá de conformidad con las siguientes cláusulas: <b>CLÁUSULA PRIMERA</b>. DEFINICIÓN DEL CONTRATO: Obedeciendo las normas constitucionales y la Ley, el presente contrato es un compromiso de atención a la primera infancia, en donde se establece de la estimulación en desarrollo y consecuencialmente, unas obligaciones de los cuidadores, beneficiarios, Padres de Familia o Acudiente, Deudor y Codeudor, en procura de una mejor prestación del servicio, de manera que el incumplimiento de las obligaciones aquí adquiridas, haría imposible la consecución del fin propuesto. <b>CLÁUSULA SEGUNDA</b>. OBJETO: El presente contrato busca unir esfuerzos recíprocos entre los aquí comprometidos, para obtener una excelente estimulación en el desarrollo y en valores, correspondiente al programa de la edad en el cual se matrícula. <b>CLÁUSULA TERCERA</b>. OBLIGACIONES ESENCIALES DEL CONTRATO: Por ser éste un Contrato de atención a la primera infancia, son obligaciones esenciales el cumplimiento continuado de los contratantes considerándose interrumpido por las siguientes razones:
            <b>A)</b>
            POR PARTE DE {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}:
            No impartir la estimulación en el desarrollo y en valores aquí contratada
            <b>B)</b>
            POR PARTE DEL ESTUDIANTE BENEFICIARIO: No asistir a la Institución ni cumplir lo estipulado en el Pacto de Corresponsabilidad. El incumplimiento de éste es imputable al Estudiante, Padres de Familia o Acudientes. <b>C)</b> POR PARTE DE LOS PADRES DE FAMILIA O ACUDIENTE, DEUDOR Y CODEUDOR: <b>A)</b> No conocer el Pacto de Convivencia y El modelo aplicado, en los cuales se comparten los principios de desarrollo en que se fundamentan y se comprometen a cumplirlos en la parte que les corresponde.
            <b>PARÁGRAFO: </b>Para todos los efectos legales, tanto el Pacto de Corresponsabilidad y el modelo aplicado., se consideran incorporados al presente contrato. <b>B) </b>El no pago oportuno del costo del servicio aquí pactado y el suministro inmediato de los implementos determinados por el Jardin al Beneficiario.
            <b>CLÁUSULA CUARTA</b>. DURACIÓN: Este contrato tiene vigencia por el año lectivo
            @if (date('m') == 12)
            {{date('Y') + 1}}
            @else
            {{date('Y')}}
            @endif 
             contado a partir de <b>
              {{ returnFormatDate($legalization->legDateInitial) }} </b> hasta <b> {{ returnFormatDate($legalization->legDateFinal) }} </b>, Su ejecución será sucesiva por periodos mensuales y podrá renovarse para el año siguiente, siempre y cuando el Beneficiario, los Padres de Familia o Acudiente, Deudor y Codeudor hayan cumplido estrictamente las condiciones estipuladas en el presente contrato, en el Pacto de Corresponsabilidad y modelo aplicado y estar a paz y salvo por todo concepto con {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}. En caso que un beneficiario se matricule extemporáneo la duración y el monto a cancelar se ajustará en relación al tiempo faltante para la finalización del año lectivo.
            <b>CLÁUSULA QUINTA</b>.
            @if(isset($paid))
            COSTOS: El presente contrato por este servicio tendrá un costo anual de <b>${{ number_format($paid[0]['payValueContract'],0,',','.') }}</b> que corresponde a <b>${{ number_format($paid[0]['payValuemountContract'],0,',','.') }}</b> por concepto de pensión mensual del año lectivo, el cual debe ser cancelado en (<b>{{ $paid[0]['payDuesQuotationContract'] }}</b>) cuota/s mensuales dentro de los (<b>{{ returnNumberDay($paid[0]['payDatepaidsContract']) }}</b>) primeros días de cada mes y <b>${{ number_format($paid[0]['payValueEnrollment'],0,',','.') }}</b> por concepto de matrícula. El costo anual se ajustará cada año, según lo autorizado por la Ley.
            @else
            COSTOS: El presente contrato por este servicio tendrá un costo anual especificado en la matrícula que corresponde a un concepto de pensión mensual del año lectivo, el cual debe ser cancelado en varias cuotas mensuales dentro de los plazos establecidos cada mes y un concepto de matrícula. El costo anual se ajustará cada año, según lo autorizado por la Ley.
            @endif
            <b>PARÁGRAFO PRIMERO:</b> Las partes contratantes acuerdan que en caso de incumplimiento en las fechas estipuladas para la matrícula, los Padres de Familia o Acudiente, Deudor y Codeudor deberán cancelar el costo estipulado para la matrícula extemporánea. <b>PARÁGRAFO SEGUNDO:</b> Las partes acuerdan que {{ mb_strtoupper($garden->garReasonsocial) }}, no reembolsará suma alguna de dinero por este concepto por retiro anticipado del beneficiario. <b>PARÁGRAFO TERCERO:</b> El departamento de Cartera genera el primer (1er) día hábil de cada mes, la cuenta de cobro para que los Padres de Familia o Acudiente, Deudor y Codeudor, realicen el pago oportuno durante los diez (10) primeros días calendario en la entidad bancaria que la Institución asigne, en efectivo o en cheque de gerencia girado a {{ mb_strtoupper($garden->garReasonsocial) }}; o por transferencia de fondos. A partir del onceavo (11°) día se liquidarán intereses moratorios a la tasa máxima mensual según lo autorizado por la Superintendencia Financiera, mediante la cual se permite utilizar los mecanismos legales vigentes para exigir el cumplimiento de las obligaciones contraídas por los Padres de Familia o Acudiente, Deudor y Codeudor que deberán ser cancelados con el pago del siguiente mes. La fecha límite para efectuar el pago es el 10 de cada mes. <b>PARÁGRAFO CUARTO:</b> La ausencia temporal o total dentro del mes por enfermedad u otra causa atribuible al Beneficiario, así sea por fuerza mayor, no dará derecho a los Padres de Familia o Acudiente, Deudor y Codeudor, a descontar suma alguna de lo obligado a pagar o que el {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}. les haga devoluciones o abonos a meses posteriores.
            <b>PARÁGRAFO QUINTO:</b>
            El incumplimiento o atraso en el pago de las obligaciones económicas previstas en el presente contrato, son causas suficientes y sin que medie requerimiento alguno, para que {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }} proceda de inmediato al diligenciamiento y cobro de los títulos valores aquí estipulados.
            <b>PARÁGRAFO SEXTO:</b>
            El departamento de Cartera les recuerda que en caso de mora en el pago correspondiente a 2 meses, reportará la deuda a la central de riesgo Datacrédito o cualquier otra central de riesgo. Al completar 3 meses se suspenderá al Beneficiario de los servicios de lonchera, almuerzo, transporte, extracurriculares y cualquier otro adicional, entregará el pagaré al departamento jurídico del Jardin y los Padres de Familia o Acudiente, Deudor y Codeudor asumirán las siguientes consecuencias:
            <b>a)</b>
            Asumirán el costo de honorarios del abogado. <b>b)</b> En caso que los Padres de Familia o Acudiente, Deudor y Codeudor no hagan de inmediato la cancelación de la deuda, deberán asumir la acción jurídica.
            <b>PARÁGRAFO SEPTIMO:</b>
            El jardín podrá cobrar por horas adicionales el costo que defina si el horario de recogida se extiende al estipulado en la hoja de matrícula.
            <b>PARÁGRAFO OCTAVO:</b>
            Cobros Periódicos: Son las sumas que pagan periódicamente los padres de familia o acudientes que voluntariamente lo hayan aceptado, por concepto de servicios de transporte y/o alimentación, prestados por el establecimiento. Estos cobros no constituyen elementos propios de la prestación del servicio, pero se originan como consecuencia del mismo. Este pago tiene una duración de un (1) año denominado lectivo que corresponde a diez (10) meses calendario, el que empezará a contar a partir del mes de <b>
              {{ returnFormatMount($legalization->legDateInitial) }} </b> a <b> {{ returnFormatMount($legalization->legDateFinal) }}
            </b>. Otros Cobros Periódicos: Son las sumas que se pagan por servicio del establecimiento, distintos de los anteriores conceptos y fijados de manera expresa en el reglamento o Pacto de Corresponsabilidad, y se deriven de manera directa de los servicios ofrecidos; estos serán variables cuando el beneficiario tome un servicio o utilice un insumo que no esté incluido en su pensión; estos serán ofrecidos al beneficiario con o sin autorización del padre velando siempre por el derecho superior del niño.
            <b>PARÁGRAFO NOVENO:</b>
            Las partes acuerdan que {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }} no reembolsará suma alguna de dinero por concepto que se le pueda atribuir a estados de emergencia en el territorio nacional, así como tampoco se reembolsaran dineros por casos de contingencias atribuibles a situaciones de orden público o salud pública.
            <b>CLÁUSULA SEXTA.</b>
            CERTIFICADOS: En caso de incumplimiento en el pago estipulado en la cláusula quinta del presente contrato, {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}. de conformidad con las normas vigentes en materia de costos, se reserva la facultad de retener constancias, certificados que correspondan a la vigencia del presente contrato, diligenciar formularios de colegios, y en especial la de emitir el paz y salvo expedir el acta de grado y en especial la de emitir el paz y salvo, requisito indispensable para que el Beneficiario pueda renovar la matrícula del año siguiente.
            <b>CLÁUSULA SÉPTIMA.</b>
            OBLIGACIONES DE {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}: Constituirán obligaciones correlativas al cumplimiento con el Beneficiario, los Padres de Familia o Acudiente, Deudor y Codeudor las siguientes: <b>A).-</b> Ofrecer el uso de la infraestructura física, elementos y dotación necesarios para el desarrollo de todos los procesos de desarrollo y de apoyo. <b>B).-</b> Prestar el servicio contratado dentro de los lineamientos legales y exigencias de las autoridades competentes. <b>C).-</b> El Jardin queda obligado a exigir al Beneficiario el cumplimiento de las normas consagradas en el Pacto de Corresponsabilidad y los deberes esenciales para la obtención del fin común que comparten el Jardín, el Beneficiario, los Padres de Familia o Acudiente, Deudor y Codeudor. <b>D).-</b> El Jardin no responde por el bajo rendimiento del Beneficiario, cuando sea imputable a los Padres de Familia o Acudiente o al Beneficiario. <b>E).-</b> Prestar en forma oportuna y eficaz los servicios complementarios de medias nueves, almuerzo, transporte, extracurriculares y cualquier otro adicional que voluntariamente soliciten los acudientes.
            <b>CLÁUSULA OCTAVA.</b>
            OBLIGACIONES DE LOS PADRES DE FAMILIA O ACUDIENTE, DEUDOR Y CODEUDOR: En cumplimiento a lo normado en el artículo 67 de la Constitución Nacional y en concordancia con el objeto del presente contrato, los Padres de Familia o Acudiente, Deudor y Codeudor, se obligan desde el momento en que el Beneficiario es aceptado en el Jardin a cumplir con los siguientes requisitos: <b>A).-</b>
            Matricularlo en los días estipulados con los requisitos exigidos, cancelando el valor correspondiente en las fechas señaladas, so pena que el Jardin disponga del cupo para designárselo a otro aspirante, si así lo estimare conveniente.
            <b>B).-</b> Firmar la carta de instrucciones y pagaré como garantía de cumplimiento al presente contrato y de los servicios adicionales de medias nueves, almuerzo, transporte, extracurriculares y cualquier otro adicional que sean contratados voluntariamente por los Padres de Familia o Acudiente, Deudor y Codeudor.
            <b>C).-</b> Comunicar y hacer cumplir a sus hijos todas y cada una de las cláusulas consagradas en el Pacto de Corresponsabilidad y modelo aplicado.
            <b>D).-</b> Velar por el progreso del Beneficiario, estando en permanente contacto con el Jardin y consultando las comunicaciones enviadas.
            <b>E).-</b> Prestar la mayor y decidida colaboración a las Directivas y Colaboradores para la obtención del fin propuesto.
            <b>F).-</b> Asistir al Jardin en el día y hora en que se les notifique.
            <b>G).-</b> Se obliga con {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }} a cancelar periódicamente o mensualmente el valor acá pactado pese a circunstancias que puedan ocurrir como las descritas en el parágrafo noveno de la cláusula quinta.
            <b>CLÁUSULA NOVENA.</b>
            DERECHOS DE LOS PADRES DE FAMILIA O ACUDIENTE, DEUDOR Y CODEUDOR: Exigir la prestación del servicio contratado, que éste se ajuste a los programas oficiales y tenga las condiciones necesarias para operar, de acuerdo con las evaluaciones que realicen las autoridades oficiales correspondientes.
            <b>CLÁUSULA DÉCIMA.</b>
            TERMINACIóN UNILATERAL: Para hacer cesar este contrato en forma unilateral por cualquiera de las partes aquí contratantes deberá cumplirse lo siguiente. <b>Primero:</b> POR PARTE DE {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}: Comunicación escrita a los Padres de Familia o Acudiente, Deudor y Codeudor y al Beneficiario de la cancelación inmediata de la matrícula por incumplimiento a las Cláusulas del presente contrato, normas del Pacto de corresponsabilidad y modelo aplicado. <b>PARÁGRAFO:</b> En caso de no pagar el total de lo adeudado hasta la fecha de la cancelación definitiva del Beneficiario, {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }} se reserva el derecho consagrado en la Ley y en lo especial lo acordado en la Cláusula Sexta del presente contrato. <b>Segundo:</b> POR PARTE DE LOS PADRES DE FAMILIA O ACUDIENTE, DEUDOR Y CODEUDOR: Comunicación escrita dirigida a la Directora, con una antelación de quince (15) días hábiles informando las causas del retiro del Beneficiario. <b>PARÁGRAFO PRIMERO:</b> Es obligación de los Padres de Familia o Acudiente, registrar la firma de cancelación en el libro de matrículas para evitar la continuidad del contrato. <b>PARÁGRAFO SEGUNDO:</b> La obligación se causará en su totalidad por el valor correspondiente al mes en curso, siempre y cuando el servicio sea prestado posterior al día quinto (5o) del mes.
            <b>CLÁUSULA DÉCIMA PRIMERA:</b>
            Las partes de común acuerdo manifiestan que fijan como cláusula penal el 10% del valor del contrato, al incumplimiento de cualquiera de las obligaciones aquí pactadas sin necesidad de requerimiento alguno.
            <b>CLÁUSULA DÉCIMA SEGUNDA:</b>
            El presente contrato por sí solo, presta mérito ejecutivo en los términos del artículo 422 del Código General del Proceso y demás normas concordantes, sin previo requerimiento privado o judicial y consecuencialmente acuerdan que los costos y demás gastos extrajudiciales y judiciales que se ocasionen por el incumplimiento de cualquiera de las cláusulas de este contrato, serán por cuenta de los Padres de Familia o Acudiente, Deudor y Codeudor.
            <b>CLÁUSULA DÉCIMA TERCERA:</b>
            Los Padres de Familia o Acudiente, Deudor y Codeudor de acuerdo con la Ley Estatutaria 1581 de 2012 y el Decreto 1377 de 2013 de Habeas Data (Protección de Datos Personales), los cuales tienen por objeto "Desarrollar el derecho constitucional que tienen todas las personas a conocer, actualizar y rectificar las informaciones que se hayan recogido sobre ellas en bases de datos o archivos", autorizan como titulares de sus datos y los de su hijo(a) a {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}, para que realice el manejo de la información que se encuentra en la base de datos, únicamente para fines pertinentes de la Institución en lo referente a la relación contractual y se comprometen a conocer y dar cumplimiento al Manual de Políticas y Procedimientos implementado por {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}, en donde se consagran los derechos y deberes como Padres de Familia, Acudiente, Deudor y Codeudor. <b>PARÁGRAFO:</b> Para conocimiento de los Padres de Familia o Acudiente, Deudor y Codeudor, el Manual de Políticas y Procedimientos de la Ley de Habeas Data se encuentra publicado en la página principal del portal web.
            <b>CLÁUSULA DÉCIMA CUARTA.</b>
            AUTORIZACIONES VOLUNTARIAS: Los Padres de Familia o Acudiente, Deudor y Codeudor que se obligan en el presente contrato y en los pagarés, autorizan voluntaria e irrevocablemente a {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNameComercial) }}; para:
            <b>1).</b>
            Verificar en las fuentes de información los datos consignados en el presente contrato, obtener referencias sobre su comportamiento comercial cuando lo considere necesario, reportar la obligación al día o en mora a las entidades sometidas a la vigilancia de la Superintendencia Financiera o a la Central de Información de la Asociación Bancaria, Datacrédito o cualquier otra entidad que maneje bases de datos con los mismos fines.
            <b>2).</b>
            IMÁGENES, FOTOGRAFIAS Y VIDEOS. El fondo de las Naciones Unidas para la Infancia (UNICEF) elaboró un documento de las "recomendaciones para filmar o fotografiar a niños, niñas y adolescentes respetando sus derechos", en el que incorpora la necesidad de tener una actitud sensible y respetuosa al momento de tomar la imagen. El Código de la Infancia y la Adolescencia permite realizar dichas publicaciones previa autorización de los padres competentes según los artículos 97 y 98. “Es procedente publicar en los medios de comunicación, incluidas las redes sociales, mensajes positivos mediante imágenes de las actividades que realiza el JARDIN con los niños, niñas y, para lo cual se requerirá la autorización respectiva de los padres; al firmar este contrato, los Padres de Familia o Acudiente, Deudor y Codeudor, dan la autorización explícita al Jardín para publicar con fines educativos estas imágenes; siempre y cuando cumplan con estos preceptos. Sin embargo, en cualquier momento podrán enviar un comunicado al Jardín negando la autorización, lo cual se acatará inmediatamente.
            <b>PARÁGRAFO PRIMERO:</b>
            Los padres de familia o acudiente, deudor y codeudor una vez acepten el punto 2 de la cláusula décimo cuarta, no podrán enviar solicitud alguna para negar el permiso aquí otorgado, salvo que se estén violando los preceptos jurídicos del código de infancia y adolescencia.
            <b>CLÁUSULA DÉCIMA QUINTA.</b>
            HORARIOS, EXCURSIONES, SALIDAS Y EVENTOS. HORARIOS: {{ mb_strtoupper($garden->garNamecomercial) }}, está inscrito como calendario @if (config('app.name') == "Dream Home By Creatyvia") B @elseif(config('app.name') == "Colchildren Kindergarten") A  @endif , desde los meses de @if(config('app.name') == "Dream Home By Creatyvia") agosto de @php echo date('Y') @endphp hasta junio de @php echo date('Y') + 1 @endphp @elseif(config('app.name') == "Colchildren Kindergarten") febrero de @php
            if(date('m') == 12){
              echo (date('Y') + 1);
            }else{
              echo (date('Y'));
            }
            @endphp hasta noviembre de @php
            if(date('m') == 12){
              echo (date('Y') + 1);
            }else{
              echo (date('Y'));
            }
            @endphp @endif. En @if(config('app.name') == "Dream Home By Creatyvia") noviembre @elseif(config('app.name') == "Colchildren Kindergarten") junio @endif tendremos receso previamente informado hasta @if(config('app.name') == "Dream Home By Creatyvia") diciembre de @php echo (date('Y')) @endphp @elseif(config('app.name') == "Colchildren Kindergarten") julio de @php
            if(date('m') == 12){
              echo (date('Y') + 1);
            } else {
              echo (date('Y'));
            }
            @endphp @endif. Parte de @if(config('app.name') == "Dream Home By Creatyvia") noviembre y diciembre @elseif(config('app.name') == "Colchildren Kindergarten") junio y julio @endif de @php
            if(date('m') == 12){
              echo (date('Y') + 1);
            }else{
              echo (date('Y'));
            }
            @endphp por vacaciones de mitad de año lectivo. El Jardín ofrece vacaciones divertidas por semanas con cobro adicional y de manera voluntaria para el beneficiario que quiera tomarlas; De igual manera también tendremos los recesos de semana Mayor.
            <b>PARÁGRAFO PRIMERO:</b>
            Cuando se presentes disturbios, Huelgas, paros cívico-urbanos o nacionales, daños locativos, servicios públicos restringidos. u otros que las directivas determinen que puedan arriesgar la integridad de los Beneficiarios o trabajadores física o emocional, el servicio se prestará con restricción o no se prestara. <b>PARÁGRAFO SEGUNDO:</b> Con el fin de dar cumplimiento a nuestro modelo aplicado. {{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}, ha formalizado la realización sin obligatoriedad por parte del jardin a realizarla de por lo menos una salida lúdica al año por edades, eventos que sin perjuicios de su valor lúdico no tienen carácter obligatorio y requieren, para la asistencia del Beneficiario, la autorización expresa, irrevocable y anticipada de los Padres de Familia o Acudiente, Deudor y Codeudor; por lo cual estos asumen de forma directa y solidaria la responsabilidad civil de los riesgos inherentes que impliquen tales eventos desde el transporte hasta la ejecución.
          </p>
          <p style="text-align: justify; font-size: 12px;">
            @php
            function getStringFormatMonth($month){
            switch($month){
            case '01': return 'ENERO'; break;
            case '02': return 'FEBRERO'; break;
            case '03': return 'MARZO'; break;
            case '04': return 'ABRIL'; break;
            case '05': return 'MAYO'; break;
            case '06': return 'JUNIO'; break;
            case '07': return 'JULIO'; break;
            case '08': return 'AGOSTO'; break;
            case '09': return 'SEPTIEMBRE'; break;
            case '10': return 'OCTUBRE'; break;
            case '11': return 'NOVIEMBRE'; break;
            case '12': return 'DICIEMBRE'; break;
            }
            }
            @endphp
            En constancia se firma el presente contrato en la ciudad de Bogotá, el día ( @php echo date('d'); @endphp ) del mes de @php echo getStringFormatMonth(date('m')); @endphp del año @php echo (date('Y')); @endphp ante un testigo.
            <br>
            <b>{{ mb_strtoupper($garden->garReasonsocial) }} - {{ mb_strtoupper($garden->garNamecomercial) }}</b>
          </p>
          <table width="100%" style="text-align: left; font-size: 12px;">
            <tr>
              <td style="width: 59%;">
                @if($garden->garFirm != null)
                <img src="{{ asset('storage/garden/firm/'.$garden->garFirm) }}" style="width: 70px; height: auto; transform:  scale(1.9); margin-left: 50px; background: transparent;"><br>
                @else
                <br>________________________________<br>
                @endif
                Representante Legal <br>
                {{ mb_strtoupper($garden->garNamerepresentative) }} <br>
                C.C N° {{ mb_strtoupper($garden->garCardrepresentative) }} <br>
              </td>
              <td style="width: 59%;">
                @if($garden->garFirmwitness != null)
                <img src="{{ asset('storage/garden/firm/'.$garden->garFirmwitness) }}" style="width: 70px; height: auto; transform:  scale(1.9); margin-left: 50px; background: transparent;"><br>
                @else
                <br>________________________________<br>
                @endif
                Testigo <br>
                {{ mb_strtoupper($garden->garNamewitness) }} <br>
                C.C N° {{ mb_strtoupper($garden->garCardwitness) }} <br>
                <!-- ________________________________  <br>
                        Testigo <br>
                        ERIKA PATRICIA PERTUZ RUDAS <br>
                        C.C N° 32.880.434 <br><br> -->
              </td>
            </tr>
            <tr>
              <td>
                <b>Firma del acudiente 1:</b><br><br>
                ________________________________ <br>
                Nombre: <br>
                C.C:
              </td>
              <td>
                <b>Firma del acudiente 2:</b><br><br>
                ________________________________ <br>
                Nombre: <br>
                C.C:
              </td>
            </tr>
            <tr>
              <td>
                <b>Firma del Deudor:</b><br><br>
                ________________________________ <br>
                Nombre: <br>
                C.C:
              </td>
              <td>
                <b>Firma del Codeudor:</b><br><br>
                ________________________________ <br>
                Nombre: <br>
                C.C:
              </td>
            </tr>
          </table>
        </div>
</body>

</html>