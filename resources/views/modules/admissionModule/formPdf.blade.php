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

    .page:before {
      content: counter(page, upper-roman);
    }

    @media print {
      small.text-index {
        page-break-before: always;
        text-align: center;
        font-size: 12px;
      }
    }

    /*small.text-index:before { content: counter(contador-pag) " de " counter(page); }*/
    small.text-index:before {
      content: counter(contador-pag);
    }

    small.text-index {
      counter-increment: contador-pag;
      counter-reset: contador-total;
    }

    /*==================================
				HEADER
            ==================================*/
    #photoSelected {
      opacity: 0;
    }

    .sectionPhoto {
      cursor: pointer;
    }

    .sectionPhoto:hover {
      background: rgba(0, 0, 0, 0.1);
      color: white;
    }

    /*==================================
				CAJAS
            ==================================*/
    .box {
      border-radius: 30px 30px 30px 30px;
      border: 1px solid #6481FF;
      padding: 12px;
      height: 250px;
    }

    .box-auto {
      height: auto;
    }

    .title-box {
      font-size: 15px;
      font-weight: bold;
      display: block;
      padding-bottom: 6px;
    }

    .title-box-small {
      font-size: 12px;
    }

    .line {
      display: block;
      position: relative;
    }

    .left-content {
      width: 48%;
      text-align: center;
      position: absolute;
      left: -20px;
      top: 0;
    }

    .right-content {
      width: 48%;
      text-align: center;
      position: absolute;
      right: -20px;
      top: 0;
    }

    .center-content {
      width: 90%;
      text-align: justify;
      position: absolute;
      right: 0;
      left: 0;
      top: 0;
    }

    input.data {
      border: none;
      border-bottom: 2px solid #000;
      text-align: center;
      background: transparent;
      font-size: 13px;
    }

    p.row-data {
      font-size: 12px;
      font-weight: bold;
      text-align: left;
      padding: 0;
      margin: 0;
    }
  </style>
</head>

<body style="font-size: 12px;">
  <header id="header">
    <table width="100%" style="text-align: center;">
      <tr>
        <td style="width: 20%; padding: 2px; align-items: center; vertical-align: middle;">
          <div style="align-items: center; display: flex; flex-flow: column; align-items: center; justify-content: center;">
            <img src="{{ asset('storage/garden/'.$garden->garNamelogo) }}" style="width: 100px; height: auto;">
          </div>
        </td>
        <td style="width: 60%; padding: 2; align-items: center; vertical-align: middle;">
          <h4 style="color: #1D006E; font-weight: bold;">FORMULARIO DE MATRICULA</h4>

          @if(config('app.name') == "Dream Home By Creatyvia")
              <h5 style="color: #FFCF35; font-weight: bold;">ADMISION</h5>
              <h6 style="color: #1200FF;">Año lectivo {{ (date('m') >= 07 ? date('Y') : date('Y') - 1) }} - {{ (date('m') >= 07 ? date('Y') + 1 : date('Y') )}}</h6>
              <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO B</h6>
              @elseif(config('app.name') == "Colchildren Kindergarten")
              <h5 style="color: #FFCF35; font-weight: bold;">ADMISION</h5>
              <h6 style="color: #1200FF;">Año lectivo {{ date('Y') + 1 }}</h6>
              <h6 style="color: #E0E608; text-shadow: 1px 1px 1px #000000;">CALENDARIO A</h6>
              @endif
        </td>
        <td>
          <img src="{{ asset('storage/admisiones/fotosaspirantes/'.$form->foto) }}" style="width: 100px; height: auto; border-radius: 20px;">
        </td>
      </tr>
    </table>
  </header>
  <hr>
  <!-- NIÑO/NIÑA Y INFORMACION DE SALUD -->
  <div class="line">
    <div class="box left-content">
      <b class="title-box">NIÑO/NIÑA</b>
      <p class="row-data">
        Nombres: <input type="text" class="data" value="{{ $form->nombres }}" style="width: 240px;">
      </p>
      <p class="row-data">
        Apellidos: <input type="text" class="data" value="{{ $form->apellidos }}" style="width: 240px;">
      </p>
      <b class="title-box">FECHA DE NACIMIENTO</b>
      <p class="row-data">
        Dia: <input type="text" class="data" value="{{ $dateborn[2] }}" style="width: 50px;">
        Mes: <input type="text" class="data" value="{{ $dateborn[1] }}" style="width: 50px;">
        Año: <input type="text" class="data" value="{{ $dateborn[0] }}" style="width: 50px;">
      </p>
      <p class="row-data">
        Tipo de documento: <input type="text" class="data" value="{{ $form->tipodocumento }}" style="width: 190px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->numerodocumento }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Nacionalidad: <input type="text" class="data" value="{{ $form->nacionalidad }}" style="width: 220px;">
      </p>
    </div>
    <div class="box right-content">
      <b class="title-box">INFORMACION DE SALUD</b>
      <p class="row-data">
        Meses de gestación:
        <input type="text" class="data" value="{{ $form->mesesgestacion }}" style="width: 40px;">
        Tipo de sangre:
        <input type="text" class="data" value="{{ $form->tiposangre }}" style="width: 40px;">
      </p>
      <p class="row-data">
        Tipo de parto: <input type="text" class="data" value="{{ $form->tipoparto }}" style="width: 190px;">
      </p>
      <p class="row-data">
        Enfermedades actuales:
        @if(strlen($form->enfermedades) <= 50) <input type="text" class="data" value="{{ $form->enfermedades }}" style="width: 140px;">
          @else
          <input type="text" class="data" value="{{ $form->enfermedades }}" style="width: 140px;">
          @endif
      </p>
      <p class="row-data">
        Tratamientos médicos:
        @if(strlen($form->tratamientos) <= 50) <input type="text" class="data" value="{{ $form->tratamientos }}" style="width: 140px;">
          @else
          <input type="text" class="data" value="{{ $form->tratamientos }}" style="width: 140px;">
          @endif
      </p>
      <p class="row-data">
        Descripción de alergias:
        @if(strlen($form->alergias) <= 50) <input type="text" class="data" value="{{ $form->alergias }}" style="width: 140px;">
          @else
          <input type="text" class="data" value="{{ $form->alergias }}" style="width: 140px;">
          @endif
      </p>
      <p class="row-data">
        Asiste o asistió a alguna terapia: <input type="text" class="data" value="{{ $form->asistenciaterapias }}" style="width: 110px;">
      </p>
      <p class="row-data">
        Cual? <input type="text" class="data" value="{{ $form->cual }}" style="width: 270px;">
      </p>
      <p class="row-data">
        Salud:
        <input type="text" class="data" value="{{ $health->entity }}" style="width: 100px;">
        Tipo:
        <input type="text" class="data" value="{{ $health->type }}" style="width: 100px;">
      </p>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- PROGRAMA A MATRICULAR Y CUIDADOS ESPECIALES -->
  <div class="line">
    <div class="box left-content">
      <b class="title-box">PROGRAMA A MATRICULAR</b>
      <p class="row-data">
        <input type="text" class="data" value="{{ $form->programa }}" style="width: 310px;">
      </p>
    </div>
    <div class="box right-content">
      <b class="title-box">CUIDADOS ESPECIALES</b>
      <p class="row-data">
        Número de hermanos:
        <input type="text" class="data" value="{{ $form->numerohermanos }}" style="width: 30px;">
        Lugar que ocupa:
        <input type="text" class="data" value="{{ $form->lugarqueocupa }}" style="width: 30px;">
      </p>
      <p class="row-data">
        Con quien vive: <input type="text" class="data" value="{{ $form->conquienvive }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Otros cuidados:
      </p>
      <p class="row-data">
        <input type="text" class="data" value="{{ $form->otroscuidados }}" style="width: 310px;">
      </p>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- INFORMACION ACUDIENTE 1 -->
  <div class="line">
    <div class="box left-content">
      <b class="title-box">INFORMACION ACUDIENTE 1</b>
      <p class="row-data">
        Nombre completo: <input type="text" class="data" value="{{ $form->nombreacudiente1 }}" style="width: 195px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->documentoacudiente1 }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Dirección residencia: <input type="text" class="data" value="{{ $form->direccionacudiente1 }}" style="width: 180px;">
      </p>
      <p class="row-data">
        Barrio:
        <input type="text" class="data" value="{{ $districtattendant1->name }}" style="width: 92px;">
        Localidad:
        <input type="text" class="data" value="{{ $locationattendant1->name }}" style="width: 92px;">
      </p>
      <p class="row-data">
        Celular:
        <input type="text" class="data" value="{{ $form->celularacudiente1 }}" style="width: 90px;">
        Whatsapp:
        <input type="text" class="data" value="{{ $form->whatsappacudiente1 }}" style="width: 90px;">
      </p>
      <p class="row-data">
        E-Mail: <input type="text" class="data" value="{{ $form->correoacudiente1 }}" style="width: 260px;">
      </p>
      <p class="row-data">
        Formación: <input type="text" class="data" value="{{ $form->formacionacudiente1 }}" style="width: 230px;">
      </p>
      <p class="row-data">
        Título: <input type="text" class="data" value="{{ $form->tituloacudiente1 }}" style="width: 260px;">
      </p>
    </div>
    <div class="box right-content">
      <b class="title-box">INFORMACION ACUDIENTE 1</b>
      <p class="row-data">
        Ocupación: <input type="text" class="data" value="{{ $form->tipoocupacionacudiente1 }}" style="width: 240px;">
      </p>
      <p class="row-data">
        Empresa: <input type="text" class="data" value="{{ $form->empresaacudiente1 }}" style="width: 250px;">
      </p>
      <p class="row-data">
        Dirección empresa: <input type="text" class="data" value="{{ $form->direccionempresaacudiente1 }}" style="width: 190px;">
      </p>
      <p class="row-data">
        Ciudad empresa: <input type="text" class="data" value="{{ $citybussinessattendant1->name }}" style="width: 200px;">
      </p>
      <p class="row-data">
        Barrio:
        <input type="text" class="data" value="{{ $districtbussinessattendant1->name }}" style="width: 95px;">
        Localidad:
        <input type="text" class="data" value="{{ $locationbussinessattendant1->name }}" style="width: 95px;">
      </p>
      <p class="row-data">
        Cargo: <input type="text" class="data" value="{{ $form->cargoempresaacudiente1 }}" style="width: 260px;">
      </p>
      <p class="row-data">
        Fecha de ingreso: <input type="text" class="data" value="{{ $form->fechaingresoempresaacudiente1 }}" style="width: 200px;">
      </p>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- INFORMACION ACUDIENTE 2 -->
  <div class="line">
    <div class="box left-content">
      <b class="title-box">INFORMACION ACUDIENTE 2</b>
      <p class="row-data">
        Nombre completo: <input type="text" class="data" value="{{ $form->nombreacudiente2 }}" style="width: 195px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->documentoacudiente2 }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Dirección residencia: <input type="text" class="data" value="{{ $form->direccionacudiente2 }}" style="width: 180px;">
      </p>
      <p class="row-data">
        Barrio:
        <input type="text" class="data" value="{{ $districtattendant2->name }}" style="width: 92px;">
        Localidad:
        <input type="text" class="data" value="{{ $locationattendant2->name }}" style="width: 92px;">
      </p>
      <p class="row-data">
        Celular:
        <input type="text" class="data" value="{{ $form->celularacudiente2 }}" style="width: 90px;">
        Whatsapp:
        <input type="text" class="data" value="{{ $form->whatsappacudiente2 }}" style="width: 90px;">
      </p>
      <p class="row-data">
        E-Mail: <input type="text" class="data" value="{{ $form->correoacudiente2 }}" style="width: 260px;">
      </p>
      <p class="row-data">
        Formación: <input type="text" class="data" value="{{ $form->formacionacudiente2 }}" style="width: 230px;">
      </p>
      <p class="row-data">
        Título: <input type="text" class="data" value="{{ $form->tituloacudiente2 }}" style="width: 260px;">
      </p>
    </div>
    <div class="box right-content">
      <b class="title-box">INFORMACION ACUDIENTE 2</b>
      <p class="row-data">
        Ocupación: <input type="text" class="data" value="{{ $form->tipoocupacionacudiente2 }}" style="width: 240px;">
      </p>
      <p class="row-data">
        Empresa: <input type="text" class="data" value="{{ $form->empresaacudiente2 }}" style="width: 250px;">
      </p>
      <p class="row-data">
        Dirección empresa: <input type="text" class="data" value="{{ $form->direccionempresaacudiente2 }}" style="width: 190px;">
      </p>
      <p class="row-data">
        Ciudad empresa: <input type="text" class="data" value="{{ $citybussinessattendant2->name }}" style="width: 200px;">
      </p>
      <p class="row-data">
        Barrio:
        <input type="text" class="data" value="{{ $districtbussinessattendant2->name }}" style="width: 95px;">
        Localidad:
        <input type="text" class="data" value="{{ $locationbussinessattendant2->name }}" style="width: 95px;">
      </p>
      <p class="row-data">
        Cargo: <input type="text" class="data" value="{{ $form->cargoempresaacudiente2 }}" style="width: 260px;">
      </p>
      <p class="row-data">
        Fecha de ingreso: <input type="text" class="data" value="{{ $form->fechaingresoempresaacudiente2 }}" style="width: 200px;">
      </p>
    </div>
  </div>
  <hr>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- DATOS EN CASO DE EMERGENCIA Y PERSONAS AUTORIZADAS PARA ENTREGAR Y RECOGER -->
  <div class="line">
    <div class="box left-content">
      <b class="title-box">DATOS EN CASO DE EMERGENCIA</b>
      <b class="title-box title-box-small">(Persona diferente a los acudientes)</b>
      <p class="row-data">
        Nombre completo: <input type="text" class="data" value="{{ $form->nombreemergencia }}" style="width: 195px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->documentoemergencia }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Dirección residencia: <input type="text" class="data" value="{{ $form->direccionemergencia }}" style="width: 180px;">
      </p>
      <p class="row-data">
        Barrio:
        <input type="text" class="data" value="{{ $districtemergency->name }}" style="width: 92px;">
        Localidad:
        <input type="text" class="data" value="{{ $locationemergency->name }}" style="width: 92px;">
      </p>
      <p class="row-data">
        Celular:
        <input type="text" class="data" value="{{ $form->celularemergencia }}" style="width: 90px;">
        Whatsapp:
        <input type="text" class="data" value="{{ $form->whatsappemergencia }}" style="width: 90px;">
      </p>
      <p class="row-data">
        Parentesco: <input type="text" class="data" value="{{ $form->parentescoemergencia }}" style="width: 230px;">
      </p>
      <p class="row-data">
        E-Mail: <input type="text" class="data" value="{{ $form->correoemergencia }}" style="width: 260px;">
      </p>
    </div>
    <div class="box right-content">
      <b class="title-box">PERSONAS AUTORIZADAS PARA ENTREGAR Y RECOGER</b>
      <b class="title-box title-box-small">(Diferentes a los padres y/o acudientes)</b>
      <p class="row-data">
        Nombre completo: <input type="text" class="data" value="{{ $form->nombreautorizado1 }}" style="width: 195px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->documentoautorizado1 }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Parentesco: <input type="text" class="data" value="{{ $form->parentescoautorizado1 }}" style="width: 230px;">
      </p>
      <p class="row-data">
        Nombre completo: <input type="text" class="data" value="{{ $form->nombreautorizado2 }}" style="width: 195px;">
      </p>
      <p class="row-data">
        No. Documento: <input type="text" class="data" value="{{ $form->documentoautorizado2 }}" style="width: 210px;">
      </p>
      <p class="row-data">
        Parentesco: <input type="text" class="data" value="{{ $form->parentescoautorizado2 }}" style="width: 230px;">
      </p>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>










  <div class="line">
    <div class="box box-auto left-content">
      <b class="title-box">INFORMACION Y EXPECTATIVAS</b>
      <br>
      <b>¿Qué es lo que más les gustaría que supiéramos de su hijo?</b><br>
      <small>{{ $form->expectatives_likechild }}</small><br>
      <b>¿Cuáles son las actividades preferidas de su niño?</b><br>
      <small>{{ $form->expectatives_activityschild }}</small><br>
      <b>¿Hay algún juguete que su hijo prefiera?</b><br>
      <small>{{ $form->expectatives_toychild }}</small><br>
      <b>¿En qué aspectos considera que se destaca su hijo?</b><br>
      <small>{{ $form->expectatives_aspectchild }}</small><br>
      <b>¿Qué esperanzas y sueños tiene para su niño?</b><br>
      <small>{{ $form->expectatives_dreamforchild }}</small><br>
      <b>¿Qué es lo que más desea que su niño aprenda con nuestro programa?</b><br>
      <small>{{ $form->expectatives_learnchild }}</small>
    </div>
    <div class="box box-auto right-content">
      <b class="title-box">INFORMACION CULTURAL</b>
      <br>
      <b>¿Hay alguna tradición, celebración o canción que sea de especial importancia para su familia y su niño?</b><br>
      <small>{{ $form->cultural_eventfamily }}</small><br>
      <b>¿Cómo desearía que apoyáramos en el jardín los valores y la identidad culturar de su familia?</b><br>
      <small>{{ $form->cultural_supportculturefamily }}</small><br>
      <b>¿Cómo podemos aprender más acerca de su herencia y cultura?</b><br>
      <small>{{ $form->cultural_gardenlearnculture }}</small><br>
      <b>¿Estarían dispuestos a compartir algo acerca de la herencia cultural de su familia con nuestros niños y equipo?</b><br>
      <small>{{ $form->cultural_shareculturefamily }}</small>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br>

















  <!-- FIRMAS -->
  <div class="line">
    <div class="center-content">
      <p class="row-data">
        Fecha de ingreso:
        Dia: <input type="text" class="data" value="{{ $dateentry[2] }}" style="width: 50px;">
        Mes: <input type="text" class="data" value="{{ $dateentry[1] }}" style="width: 50px;">
        Año: <input type="text" class="data" value="{{ $dateentry[0] }}" style="width: 50px;">
      </p>
    </div>
  </div>
  <br><br><br><br><br><br>
  <!-- FIRMAS -->
  <div class="line">
    <div class="left-content" style="text-align: center;">
      <p class="row-data">
        <input type="text" class="data" value="" style="width: 300px;">
      </p>
      <b class="title-box">Firma del acudiente 1</b>
    </div>
    <div class="right-content" style="text-align: center;">
      <p class="row-data">
        <input type="text" class="data" value="" style="width: 300px;">
      </p>
      <b class="title-box">Firma del acudiente 2</b>
    </div>
  </div>
  <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>