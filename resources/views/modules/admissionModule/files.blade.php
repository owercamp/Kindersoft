@extends('admissions')

@section('modulesAdmission')
<div class="row">
  <div class="col-md-12">
    <div class="row text-center border-bottom mb-4" style="font-size: 13px;">
      <div class="col-md-12">
        <!-- Mensajes de modificación de formularios -->
        @if(session('SuccessForm'))
        <div class="alert alert-success">
          {{ session('SuccessForm') }}
        </div>
        @endif
        <!-- Mensajes de errores de procesamiento de formularios -->
        @if(session('SecondaryForm'))
        <div class="alert alert-secondary">
          {{ session('SecondaryForm') }}
        </div>
        @endif
      </div>
    </div>
    <table id="tableDatatable" class="table table-hover text-center" width="100%">
      <thead>
        <tr>
          <th>NIÑO/NIÑA</th>
          <th>DOCUMENTO</th>
          <th>MESES DE GESTACION</th>
          <th>ACUDIENTE 1</th>
          <th>CONTACTO 1</th>
          <th>ACUDIENTE 2</th>
          <th>CONTACTO 2</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($forms as $form)
        <tr>
          <td>{{ $form->nombres . ' ' . $form->apellidos }}</td>
          <td>{{ $form->numerodocumento }}</td>
          <td>{{ $form->mesesgestacion }}</td>
          <td>{{ $form->nombreacudiente1 }}</td>
          <td>{{ $form->celularacudiente1 }}</td>
          <td>{{ $form->nombreacudiente2 }}</td>
          <td>{{ $form->celularacudiente2 }}</td>
          <td>
            @if($form->migracion === 0)
            <a href="#" title="MIGRACION DE DATOS" class="btn btn-outline-primary rounded-circle form-control-sm migrationForm-link">
              <i class="fas fa-copy"></i>
              <!-- migrationAdmission -->
              <span hidden>{{ $form->fmId }}</span>
              <span hidden>{{ $form->nombres }}</span>
              <span hidden>{{ $form->apellidos }}</span>
              <span hidden>{{ $form->numerodocumento }}</span>
              <span hidden>{{ $form->fechanacimiento }}</span>
              <span hidden>{{ $form->direccionacudiente1 }}</span>
              <span hidden>{{ $form->barrioacudiente1 }}</span>
              <span hidden>{{ $form->localidadacudiente1 }}</span>
              <span hidden>{{ $form->ciudadempresaacudiente1 }}</span>
              @php
              if($form->foto == "photodefault.png" and $form->genero == "MASCULINO")
              {
              $foto = "niñodefault.jpg";
              }elseif($form->foto == "photodefault.png" and $form->genero == "FEMENINO")
              {
              $foto = "niñadefault.jpg";
              } else{
              $foto = $form->foto;
              }
              @endphp
              <img hidden src="{{ asset('storage/admisiones/fotosaspirantes/'.$foto) }}" class="img-thumbnail" width="3cm" height="4cm">
            </a>
            @endif
            <!-- <form action="{{ route('pdfAdmission') }}" method="GET" style="display: inline-block;">
							@csrf
							<input type="hidden" name="fmId" value="{{ $form->fmId }}"
								class="form-control form-control-sm" required>
							<button type="submit" title="DESCARGAR PDF" class="btn btn-outline-tertiary  form-control-sm">
								<i class="fas fa-file-pdf"></i>
							</button>
						</form> -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="migrationForm-modal">
  <div class="modal-dialog modal-lg" style="font-size: 12px;">
    <div class="modal-content">
      <div class="modal-header">
        <h6>MIGRACION DE DATOS</h6>
      </div>
      <div class="modal-body">
        <form action="{{ route('migrationAdmission') }}" method="POST">
          @csrf
          <!-- <div class="row">
							<div class="col-md-6 border-rigth">
								<h6><b>Datos de formulario</b></h6>
								<div class="row">
									<div class="col-md-12 d-flex flex-column justify-content-center align-items-center">
										<small class="text-muted">NIÑO/A</small>
										<span class="names_migration"></span>
										<img src="" class="img-responsive photo_migration" style="width: 120px; height: auto;">
										<small class="text-muted">DOCUMENTO</small>
										<span class="numberdocument_migration"></span>
										<small class="text-muted">FECHA NACIMIENTO</small>
										<span class="datebirth_migration"></span>
									</div>
								</div>
							</div>
							<div class="col-md-6 border-left section_infoExists"></div>
						</div> -->
          <table class="table tbl-migration-student text-center" width="100%" style="display: none;">
            <thead>
              <tr>
                <th colspan="4" style="background-color: #ccc; color: white; font-weight: bold;">DATOS
                  DE ASPIRANTE</th>
              </tr>
              <tr>
                <th></th>
                <th>Dato de formulario</th>
                <th></th>
                <th>Dato existente</th>
              </tr>
            </thead>
            <tbody>
              <!-- dinamic -->
            </tbody>
          </table>
          <hr>
          <table class="table tbl-migration-attendant1 text-center border" width="100%" style="display: none;">
            <thead>
              <tr>
                <th colspan="4" style="background-color: #ccc; color: white; font-weight: bold;">DATOS
                  DE ACUDIENTE 1</th>
              </tr>
              <tr>
                <th></th>
                <th>Dato de formulario</th>
                <th></th>
                <th>Dato existente</th>
              </tr>
            </thead>
            <tbody>
              <!-- dinamic -->
            </tbody>
          </table>
          <hr>
          <table class="table tbl-migration-attendant2 text-center border" width="100%" style="display: none;">
            <thead>
              <tr>
                <th colspan="4" style="background-color: #ccc; color: white; font-weight: bold;">DATOS
                  DE ACUDIENTE 2</th>
              </tr>
              <tr>
                <th></th>
                <th>Dato de formulario</th>
                <th></th>
                <th>Dato existente</th>
              </tr>
            </thead>
            <tbody>
              <!-- dinamic -->
            </tbody>
          </table>
          <hr>
          <div class="form-group text-center pt-2 border-top">
            <input type="hidden" name="sId_migration" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="a1Id_migration" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="a2Id_migration" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="fmId_migration" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="json_migration" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="json_dataAttendant1" class="form-control form-control-sm" readonly required>
            <input type="hidden" name="json_dataAttendant2" class="form-control form-control-sm" readonly required>
            <button type="submit" class="btn btn-outline-primary form-control-sm">MIGRAR INFORMACION</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $('.migrationForm-link').on('click', function(e) {
    e.preventDefault();
    var photo = $(this).find('img:first').attr('src');
    var fmId = $(this).find('span:nth-child(2)').text();
    var nombres = $(this).find('span:nth-child(3)').text();
    var apellidos = $(this).find('span:nth-child(4)').text();
    var numerodocumento = $(this).find('span:nth-child(5)').text();
    var fechanacimiento = $(this).find('span:nth-child(6)').text();
    var direccionacudiente1 = $(this).find('span:nth-child(7)').text();
    var barrioacudiente1 = $(this).find('span:nth-child(8)').text();
    var localidadacudiente1 = $(this).find('span:nth-child(9)').text();
    var ciudadempresaacudiente1 = $(this).find('span:nth-child(10)').text();
    $('.tbl-migration-student tbody').empty();
    $('.tbl-migration-attendant1 tbody').empty();
    $('.tbl-migration-attendant2 tbody').empty();
    $('input[name=sId_migration]').val('');
    $('input[name=a1Id_migration]').val('');
    $('input[name=a2Id_migration]').val('');
    $('input[name=fmId_migration]').val('');
    $('input[name=json_migration]').val('');
    $('input[name=json_dataAttendant1]').val('');
    $('input[name=json_dataAttendant2]').val('');
    console.log(photo);
    $.get("{{ route('getLegalizationMigration') }}", {
      fmId: fmId,
      numerodocumento: numerodocumento
    }, function(objectMigration) {
      // console.log(objectMigration);
      let count = Object.keys(objectMigration).length;
      let encode = '';
      let readyStudent = false;
      let readyAttendant1 = false;
      let readyAttendant2 = false;
      let DataAttendant1 = [objectMigration[1][2][1], objectMigration[1][1][3], objectMigration[1][3][1], objectMigration[1][14][1], objectMigration[1][5][1], objectMigration[1][4][1], objectMigration[1][6][2], objectMigration[1][7][2], objectMigration[1][8][2], 'INDEFINIDO', objectMigration[1][17][1], objectMigration[1][12][1], objectMigration[1][17][2], objectMigration[1][18][1], objectMigration[1][13][1], objectMigration[1][14][1], objectMigration[1][16][1], objectMigration[1][15][1], 'ACTIVO'];
      let DataAttendant2 = [objectMigration[2][2][1], objectMigration[2][1][3], objectMigration[2][3][1], objectMigration[2][14][1], objectMigration[2][5][1], objectMigration[2][4][1], objectMigration[2][6][2], objectMigration[2][7][2], objectMigration[2][8][2], 'INDEFINIDO', objectMigration[2][17][1], objectMigration[2][12][1], objectMigration[2][17][2], objectMigration[2][18][1], objectMigration[2][13][1], objectMigration[2][14][1], objectMigration[2][16][1], objectMigration[2][15][1], 'ACTIVO'];
      if (count > 0) {
        let iterationTable = ['student', 'attendant1', 'attendant2'];
        let titleNodates = ['aspirante', 'acudiente 1', 'acudiente 2'];
        let idsInputs = ['s', 'a1', 'a2'];
        // console.log(iterationTable);
        for (var f = 0; f < count; f++) {
          // console.log(objectMigration[f]);
          if (objectMigration[f] != null) {
            for (var i = 0; i < objectMigration[f].length; i++) {
              if (!readyStudent && f == 0) {
                encode += "|||"; // student array start
                readyStudent = true;
              } else if (!readyAttendant1 && f == 1) {
                encode += "|||";
                readyAttendant1 = true;
              } else if (!readyAttendant2 && f == 2) {
                encode += "|||";
                readyAttendant2 = true;
              }
              if (f == 0) {
                if (i == (objectMigration[f].length - 1)) {
                  encode += fieldStudent(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "|||";
                  // encode += "[" + objectMigration[f][i][0] + "," + objectMigration[f][i][1] + "," + objectMigration[f][i][2] + "]]";
                } else {
                  if (objectMigration[f][i][0] == 'Nombres y apellidos') {
                    // console.log(objectMigration[f][i]);
                    encode += fieldStudent(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "==>" + objectMigration[f][i][3] + "|=|";
                  } else if (objectMigration[f][i][0] == 'Fecha de nacimiento') {
                    // console.log(calculateBirthdate(objectMigration[f][i][2]));
                    encode += fieldStudent(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "==>" + calculateBirthdate(objectMigration[f][i][2]) + "|=|";
                  } else {
                    encode += fieldStudent(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "|=|";
                  }
                  // encode += "[" + objectMigration[f][i][0] + "," + objectMigration[f][i][1] + "," + objectMigration[f][i][2] + "],";
                }
              } else {
                if (i == (objectMigration[f].length - 1)) {
                  encode += fieldAttendant(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "|||";
                  // encode += "[" + objectMigration[f][i][0] + "," + objectMigration[f][i][1] + "," + objectMigration[f][i][2] + "]]";
                } else {
                  encode += fieldAttendant(objectMigration[f][i][0]) + "==>" + objectMigration[f][i][1] + "|=|";
                  // encode += "[" + objectMigration[f][i][0] + "," + objectMigration[f][i][1] + "," + objectMigration[f][i][2] + "],";
                }
              }
              // if(f < 2 && i == (objectMigration[f].length - 1)){ encode += "|=|" }
              if (objectMigration[f][i][0] == 'Foto') {
                var foto;
                if (objectMigration[f][i][2] == "studentdefault.png" & objectMigration[f][7][1] == "FEMENINO") {
                  foto = "niñadefault.jpg";
                } else if (objectMigration[f][i][2] == "studentdefault.png" & objectMigration[f][7][1] == "MASCULINO") {
                  foto = "niñodefault.jpg";
                } else if (objectMigration[f][i][2] == "No existe") {
                  foto = "studentdefault.png";
                } else {
                  foto = objectMigration[f][i][2];
                }
                $('.tbl-migration-' + iterationTable[f] + ' tbody').append(
                  "<tr>" +
                  "<th>" + objectMigration[f][i][0] + "</th>" +
                  "<td>" +
                  "<img src=" + photo + " class='img-responsive photo_migration img-thumbnail' style='width: 3cm; height: 4cm;'>" +
                  "</td>" +
                  "<td><i class='fa fa-arrow-right'></i></td>" +
                  "<td>" +
                  // "<img src='storage/students/" + objectMigration[f][i][2] + "' class='img-responsive photo_migration' style='width: 120px; height: auto;'>" +
                  "<img src='storage/admisiones/fotosaspirantes/" + foto + "' class='img-responsive photo_migration img-thumbnail' style='width: 3cm; height: 4cm;'>" +
                  "</td>" +
                  "</tr>"
                );
              } else {
                if (objectMigration[f][i][0] == 'id_student') {
                  // $('input[name=fmId_migration]').val(objectMigration[f][i][1]);
                  $('input[name=' + idsInputs[f] + 'Id_migration]').val(objectMigration[f][i][2]);
                } else {
                  $('.tbl-migration-' + iterationTable[f] + ' tbody').append(
                    "<tr>" +
                    "<th>" + objectMigration[f][i][0] + "</th>" +
                    "<td>" + objectMigration[f][i][1] + "</td>" +
                    "<td><i class='fa fa-arrow-right'></i></td>" +
                    "<td>" + objectMigration[f][i][2] + "</td>" +
                    "</tr>"
                  );
                }
              }
            }
          } else {
            encode += (f < 2) ? "null|||" : "null";
            $('input[name=' + idsInputs[f] + 'Id_migration]').val('null');
            $('.tbl-migration-' + iterationTable[f] + ' tbody').append(
              "<tr>" +
              "<td colspan='4'>No existe información del " + titleNodates[f] + ", se creará el registro!</td>" +
              "</tr>"
            );
          }
          // Solo se muestra por el momento la tabla del estudiante, no de los acudientes, por esto la condicion
          // No esta dentro del requerimiento la migracion de acudientes
          if (f == 0) {
            $('.tbl-migration-' + iterationTable[f]).css('display', 'block');
          }
        }
        // console.log('encode',JSON.stringify(encode));
        $('input[name=json_migration]').val(encode);
        $('input[name=json_dataAttendant1]').val(DataAttendant1);
        $('input[name=json_dataAttendant2]').val(DataAttendant2);
        // $('input[name=json_migration]').val(objectMigration);
      } else {
        $('input[name=json_migration]').val('null');
        $('.tbl-migration-student').css('display', 'block');
        $('.tbl-migration-student tbody').append(
          "<tr>" +
          "<td colspan='4'>No existe información del aspirante, se creará el registro!</td>" +
          "</tr>"
        );
        // $('.tbl-migration-attendant1').css('display','block');
        // $('.tbl-migration-attendant1 tbody').append(
        // 	"<tr>" +
        // 		"<td colspan='4'>No existe información del acudiente 1, se creará el registro!</td>" +
        // 	"</tr>"
        // );
        // $('.tbl-migration-attendant2').css('display','block');
        // $('.tbl-migration-attendant2 tbody').append(
        // 	"<tr>" +
        // 		"<td colspan='4'>No existe información del acudiente 2, se creará el registro!</td>" +
        // 	"</tr>"
        // );
      }
    });
    // $('input[name=legId_migration]').val(fmId);
    $('input[name=fmId_migration]').val(fmId);
    // $('.names_migration').text(nombres + ' ' + apellidos);
    // $('.photo_migration').attr('src',photo);
    // $('.numberdocument_migration').text(numerodocumento);
    // $('.datebirth_migration').text(fechanacimiento);
    $('#migrationForm-modal').modal();
  });

  function fieldStudent(field) {
    switch (field) {
      case 'id_student':
        return 'id';
        break;
      case 'Foto':
        return 'photo';
        break;
      case 'Tipo de documento':
        return 'typedocument_id';
        break;
      case 'Número de documento':
        return 'numberdocument';
        break;
      case 'Fecha de nacimiento':
        return 'birthdate';
        break;
      case 'Nombres y apellidos':
        return 'names';
        break;
      case 'Tipo de sangre':
        return 'bloodtype_id';
        break;
      case 'Género':
        return 'gender';
        break;
      case 'Salud':
        return 'health_id';
        break;
      case 'Salud adicional':
        return 'additionalHealt';
        break;
      case 'Descripción de salud adicional / Informacion adicional':
        return 'additionalHealtDescription';
        break;
      default:
        return field;
        break;
    }
  }

  function fieldAttendant(field) {
    switch (field) {
      case 'id_attendant1':
        return 'id';
        break;
      case 'Nombres':
        return 'namesA';
        break;
      case 'N° Documento':
        return 'numberdocument';
        break;
      case 'Dirección Residencia':
        return 'address';
        break;
      case 'Barrio':
        return 'dictricthome_id';
        break;
      case 'Localidad':
        return 'locationhome_id';
        break;
      case 'Celular':
        return 'phoneone';
        break;
      case 'Whatsapp':
        return 'whatsapp';
        break;
      case 'Correo eletrónico':
        return 'emailone';
        break;
      case 'Formación':
        return 'profession_id';
        break;
      case 'Título':
        return 'profession_id';
        break;
      case 'Tipo de ocupación':
        return 'profession';
        break;
      case 'Empresa':
        return 'company';
        break;
      case 'Dirección':
        return 'addresscompany';
        break;
      case 'Ciudad Empresa':
        return 'citycompany_id';
        break;
      case 'Barrio Empresa':
        return 'dictrictcompany_id';
        break;
      case 'Localidad Empresa':
        return 'locationcompany_id';
        break;
      case 'Cargo':
        return 'position';
        break;
      case 'Fecha Ingreso':
        return 'antiquity';
        break;
      default:
        return field;
        break;
    }
  }

  function calculateBirthdate(date) {
    if (date != '') {
      var values = date.split("-");
      var day = values[2];
      var mount = values[1];
      var year = values[0];
      var now = new Date();
      var yearNow = now.getYear()
      var mountNow = now.getMonth() + 1;
      var dayNow = now.getDate();
      //Cálculo de años
      var old = (yearNow + 1900) - year;
      if (mountNow < mount) {
        old--;
      }
      if ((mount == mountNow) && (dayNow < day)) {
        old--;
      }
      if (old > 1900) {
        old -= 1900;
      }
      //Cálculo de meses
      var mounts = 0;
      if (mountNow > mount) {
        mounts = mountNow - mount;
      }
      if (mountNow < mount) {
        mounts = 12 - (mount - mountNow);
      }
      if (mountNow == mount && day > dayNow) {
        mounts = 11;
      }
      //Cálculo de dias
      var days = 0;
      if (dayNow > day) {
        days = dayNow - day
      }
      if (dayNow < day) {
        lastDayMount = new Date(yearNow, mountNow, 0);
        days = lastDayMount.getDate() - (day - dayNow);
      }
      // $('#yearsold').val(old);
      // $('#monthold').val(mounts);
      return old + '-' + mounts;
      //$('#dayold').val(days); //Opcional para mostrar dias también
    } else {
      console.log("La fecha " + date + " es incorrecta");
    }
  }
</script>
@endsection