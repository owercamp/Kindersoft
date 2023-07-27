@extends('modules.enrollment')

@section('enrollmentsComercial')
<div class="col-md-12">
  <div class="row text-center my-2">
    <div class="col-md-6">
      <h3>
        LEGALIZACION DE MATRICULAS
        <span><a href="#" title="LEGALIZACION DE CONTRATO: * Formalizará la matrícula con un contrato y el sistema pasará al alumno como ACTIVO dentro de la institución."><i class="fas fa-question-circle"></i></a></span>
      </h3>
    </div>
    <div class="col-md-6">
      <!-- Mensajes de creacion de legalización -->
      @if(session('SuccessNewLegalizationEnrollment'))
      <div class="alert alert-success">
        {{ session('SuccessNewLegalizationEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryNewLegalizationEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryNewLegalizationEnrollment') }}
      </div>
      @endif
      <!-- Mensajes de actualizacion de legalización -->
      @if(session('PrimaryUpdateLegalizationEnrollment'))
      <div class="alert alert-primary">
        {{ session('PrimaryUpdateLegalizationEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryUpdateLegalizationEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryUpdateLegalizationEnrollment') }}
      </div>
      @endif
      <!-- Mensajes de eliminación de legalización -->
      @if(session('WarningDeleteLegalizationEnrollment'))
      <div class="alert alert-warning">
        {{ session('WarningDeleteLegalizationEnrollment') }}
      </div>
      @endif
      @if(session('SecondaryDeleteLegalizationEnrollment'))
      <div class="alert alert-secondary">
        {{ session('SecondaryDeleteLegalizationEnrollment') }}
      </div>
      @endif
    </div>
  </div>
  <form action="{{ route('legalizationEnrollment.new') }}" method="POST" class="mb-3" autocomplete="off">
    @csrf
    <div class="row mt-3 border-top border-bottom">
      <!-- INFORMACION DEL ALUMNO -->
      <div class="col md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted">NOMBRE DE ALUMNO:</small>
              <select name="legStudent_id" class="form-control form-control-sm" required>
                <option value="">Seleccione un alumno...</option>
                @for($i = 0; $i < count($studentsUnique); $i++) <option value="{{ $studentsUnique[$i][0] }}">{{ $studentsUnique[$i][1] }}</option>
                  @endfor
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">TIPO DE DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationTypeDocumentStudent" class="form-control form-control-sm" disabled required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">N° DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationNumberDocumentStudent" class="form-control form-control-sm" disabled required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">FECHA DE NACIMIENTO:</small>
                  <input type="text" name="infoLegalizationBirthdateStudent" class="form-control form-control-sm" disabled required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">EDAD: AÑO-MESES</small>
                  <input type="text" name="infoLegalizationYearsoldStudent" class="form-control form-control-sm" disabled required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <small class="text-muted">GRADO:</small>
                  <select name="legGrade_id" class="form-control form-control-sm" required>
                    <option value="">Seleccione un grado...</option>
                    @foreach($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-6">
									<div class="form-group">
										<small class="text-muted">CURSO:</small>
										<select name="legCourse_id" class="form-control form-control-sm" required>
											<option value="">Seleccione un curso...</option>
											 SELECTOR DINAMICO DE CURSO
										</select>
									</div>
								</div> -->
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">FECHA DE INGRESO:</small>
                  <input type="text" name="infoLegalizationDateInitialStudent" class="form-control form-control-sm datepicker" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">FECHA DE TERMINACION:</small>
                  <input type="text" name="infoLegalizationDateFinalStudent" class="form-control form-control-sm datepicker" required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- INFORMACION DEL ACUDIENTE -->
      <div class="col md-6">
        <div class="row selectionAttendant">
          <div class="col-md-12">
            <div class="form-group">
              <small class="text-muted">NOMBRE DE ACUDIENTE 1:</small>
              <input type="hidden" name="legAttendantfather_id">
              <input type="text" name="acudiente1" class="form-control form-control-sm" disabled>
              <!-- <select name="legAttendantfather_id" class="form-control form-control-sm">
                <option value="">Seleccione el padre...</option>
                @foreach($attendants as $attendant)
                @if ($attendant->status == 'ACTIVO')
                <option value="{{ $attendant->id }}">{{ $attendant->firstname . ' ' . $attendant->threename }}</option>
                @endif
                @endforeach
              </select> -->
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">TIPO DE DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationTypeDocumentAttendantFather" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">N° DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationNumberDocumentAttendantFather" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <small class="text-muted">NOMBRE DE ACUDIENTE 2:</small>
              <input type="hidden" name="legAttendantmother_id">
              <input type="text" name="acudiente2" class="form-control form-control-sm" disabled>
              <!-- <select name="legAttendantmother_id" class="form-control form-control-sm">
                <option value="">Seleccione la madre...</option>
                @foreach($attendants as $attendant)
                @if ($attendant->status == 'ACTIVO')
                <option value="{{ $attendant->id }}">{{ $attendant->firstname . ' ' . $attendant->threename }}</option>
                @endif
                @endforeach
              </select> -->
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">TIPO DE DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationTypeDocumentAttendantMother" class="form-control form-control-sm" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">N° DOCUMENTO:</small>
                  <input type="text" name="infoLegalizationNumberDocumentAttendantMother" class="form-control form-control-sm" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <small class="text-muted">JORNADA:</small>
              <select name="legJourney_id" class="form-control form-control-sm" required>
                <option value="">Seleccione la jornada...</option>
                @foreach($journeys as $journey)
                <option value="{{ $journey->id }}">{{ $journey->jouJourney . ' - ' . $journey->jouDays . ' - ' . $journey->jouHourEntry . ' - ' . $journey->jouHourExit }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- INFORMACION DE PAGO -->
    <!-- <div class="row border-top border-bottom my-2">
				<div class="col-md-6 text-left">
					<small class="text-muted mr-5">
						¿Con informacion de pago?
					</small>
				</div>
				<div class="col-md-6 text-left">
					<small class="text-muted mr-5">
						<input type="radio" name="legPaid" value="SI">
						SI
					</small>
					<small class="text-muted mr-5">
						<input type="radio" name="legPaid" value="NO" checked>
						NO
					</small>
				</div>
			</div> -->
    <div class="row m-3 border-bottom sectionBank">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <h5 class="text-muted mr-5">
              INFORMACION DE PAGO:
            </h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <small class="text-muted">VALOR DEL CONTRATO:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm" name="payValueContract" pattern="[0-9]{1,10}" maxlength="10" required>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <small class="text-muted">Q CUOTAS:</small>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-tags"></i></span>
                </div>
                <input type="text" class="form-control form-control-sm" name="payDuesQuotationContract" pattern="[0-9]{1,2}" maxlength="2" required>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <small class="text-muted">VALOR MENSUAL:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm" name="payValuemountContract" readonly required>
            </div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">FECHA DE PAGO PRIMERA CUOTA:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm datepicker" name="payDatepaidsContract" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h5 class="text-muted mr-5">
              INFORMACION DE MATRICULA:
            </h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <small class="text-muted">VALOR DE MATRICULA:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm" name="payValueEnrollment" pattern="[0-9]{1,10}" maxlength="10" required>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <small class="text-muted">Q CUOTAS:</small>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-tags"></i></span>
                </div>
                <input type="text" class="form-control form-control-sm" name="payDuesQuotationEnrollment" pattern="[0-9]{1,2}" maxlength="2" required>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <small class="text-muted">VALOR MENSUAL:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm" name="payValuemountEnrollment" readonly required>
            </div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">FECHA DE PAGO PRIMERA CUOTA:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control form-control-sm datepicker" name="payDatepaidsEnrollment" required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="form-group">
          <button type="submit" class="btn btn-outline-success form-control-sm mt-3">GUARDAR LEGALIZACION</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection


@section('scripts')
<script>
  function converterYearsoldFromBirtdate(date) {
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
    if (mountNow > mount && day > dayNow) {
      mounts = (mountNow - mount) - 1;
    } else if (mountNow > mount) {
      mounts = mountNow - mount;
    } else if (mountNow < mount && day < dayNow) {
      mounts = 12 - (mount - mountNow);
    } else if (mountNow < mount) {
      mounts = 12 - (mount - mountNow + 1);
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
      lastDayMount = new Date(yearNow, mountNow - 1, 0);
      days = lastDayMount.getDate() - (day - dayNow);
    }
    var processed = parseInt(old) + '-' + parseInt(mounts);
    return processed;
    // days ==> Opcional para mostrar dias también
  }

  $(function() {});

  $('select[name=legStudent_id]').on('change', function(e) {
    let selectedStudent = $(this).val();
    $('input[name=infoLegalizationTypeDocumentStudent]').val("");
    $('input[name=infoLegalizationNumberDocumentStudent]').val("");
    $('input[name=infoLegalizationBirthdateStudent]').val("");
    $('input[name=infoLegalizationYearsoldStudent]').val("");
    $('input[name=legAttendantfather_id]').val("");
    $('input[name=infoLegalizationTypeDocumentAttendantFather]').val("");
    $('input[name=infoLegalizationNumberDocumentAttendantFather]').val("");
    $('input[name=legAttendantmother_id]').val("");
    $('input[name=infoLegalizationTypeDocumentAttendantMother]').val("");
    $('input[name=infoLegalizationNumberDocumentAttendantMother]').val("");
    $('input[name=acudiente1]').val("");
    $('input[name=acudiente2]').val("");
    if (selectedStudent !== null && selectedStudent !== '') {
      $.ajax({
        "_token": "{{ csrf_token() }}",
        type: "POST",
        dataType: "JSON",
        data: {
          selectedStudent: selectedStudent
        },
        url: "{{ route('legStudentSelected') }}",
        beforeSend() {
          Swal.fire({
            title:'Consultando datos',
            html: 'por favor espere',
            icon:'info',
            timer: 1500,
            showConfirmButton: false
          })
        },
        success(res) {
          $('input[name=infoLegalizationTypeDocumentStudent]').val(res[0]['type']);
          $('input[name=infoLegalizationNumberDocumentStudent]').val(res[0]['numberdocument']);
          $('input[name=infoLegalizationBirthdateStudent]').val(res[0]['birthdate']);
          $('input[name=infoLegalizationYearsoldStudent]').val(converterYearsoldFromBirtdate(res[0]['birthdate']));
          if (res[1] != null) {
            $('input[name=legAttendantfather_id]').val((res[1]['id'] != null) ? res[1]['id'] : '');
            $('input[name=infoLegalizationTypeDocumentAttendantFather]').val((res[1]['type'] != null) ? res[1]['type'] : '');
            $('input[name=infoLegalizationNumberDocumentAttendantFather]').val((res[1]['numberdocument'] != null) ? res[1]['numberdocument'] : '');
            $('input[name=acudiente1]').val(`${(res[1]['firstname'] != null) ? res[1]['firstname'] : ''} ${(res[1]['threename'] != null) ? res[1]['threename'] : ''}`);
          }
          if (res[2] != null) {
            $('input[name=legAttendantmother_id]').val((res[2]['id'] != null) ? res[2]['id'] : '');
            $('input[name=infoLegalizationTypeDocumentAttendantMother]').val((res[2]['type'] != null) ? res[2]['type'] : '');
            $('input[name=infoLegalizationNumberDocumentAttendantMother]').val((res[2]['numberdocument'] != null) ? res[2]['numberdocument'] : '');
            $('input[name=acudiente2]').val(`${(res[2]['firstname'] != null) ? res[2]['firstname'] : ''} ${(res[2]['threename'] != null) ? res[2]['threename'] : ''}`);
          }
        }
      })
    }
  });


  // POR SI SE UTILIZA EL CAMPO legCourse_id SE USAN ESTOS DOS PROXIMOS EVENTOS

  // $('select[name=legGrade_id]').on('change',function(e){
  // var selectedGrade = e.target.value;
  // if(selectedGrade !== null && selectedGrade !== ''){
  // 	$.get("{{ route('legGradeSelected') }}",{selectedGrade: selectedGrade},function(objectCourses){
  // 		var count = Object.keys(objectCourses).length //total de cursos del grado seleccionado
  // 		$('select[name=legCourse_id]').empty();
  // 		$('select[name=legCourse_id]').append("<option value=''>Seleccione un curso...</option>");
  // 		for (var i = 0; i < count; i++) {
  // 			$('select[name=legCourse_id]').append('<option value=' + objectCourses[i]['id'] + '>' + objectCourses[i]['name'] + '</option>');
  // 		}
  // 	});
  // }else{
  // 	$('select[name=legCourse_id]').empty();
  // 	$('select[name=legCourse_id]').append("<option value=''>Seleccione un curso...</option>");
  // }
  // });


  // $('select[name=legCourse_id]').on('change',function(e){
  // 	var selectedCourse = e.target.value;
  // 	var selectedGrade = $('select[name=legGrade_id] option:selected').val();
  // 	if(selectedGrade !== null && selectedGrade !== '' && selectedCourse !== null && selectedCourse !== ''){
  // 		$.get(
  // 			"{{ route('legCourseSelectedForList') }}",
  // 			{selectedCourse: selectedCourse, selectedGrade: selectedGrade},
  // 			function(objectListCourse){
  // 				$('#tablelistcourses tbody').empty();
  // 				var count = Object.keys(objectListCourse).length; //registros total de listado del grado y curso
  // 				for (var i = 0; i < count; i++) {
  // 					var nameStudent = objectListCourse[i]['firstname'] + ' ' + objectListCourse[i]['threename'] + ' ' + objectListCourse[i]['fourname'];
  // 					$('#tablelistcourses tbody').append('<tr><td>' + objectListCourse[i]['id'] + '</td><td>' + nameStudent + '</td><td>' + objectListCourse[i]['yearsold'] + '</td><td>' + objectListCourse[i]['gender'] + '</td></tr>');
  // 				}
  // 			}
  // 		);
  // 	}else{
  // 		$('select[name=legCourse_id]').empty();
  // 		$('select[name=legCourse_id]').append("<option value=''>Seleccione un curso...</option>");
  // 	}
  // });

  // $('select[name=legAttendantfather_id]').on('change', function(e) {
  //   var selectedAttendant = e.target.value;
  //   if (selectedAttendant !== null && selectedAttendant !== '') {
  //     $.get("{{ route('legAttendantSelected') }}", {
  //       selectedAttendant: selectedAttendant
  //     }, function(objectAttendant) {
  //       $('input[name=infoLegalizationTypeDocumentAttendantFather]').val('');
  //       $('input[name=infoLegalizationTypeDocumentAttendantFather]').val(objectAttendant['type']);
  //       $('input[name=infoLegalizationNumberDocumentAttendantFather]').val('');
  //       $('input[name=infoLegalizationNumberDocumentAttendantFather]').val(objectAttendant['numberdocument']);
  //     });
  //   } else {
  //     $('input[name=infoLegalizationTypeDocumentAttendantFather]').val('');
  //     $('input[name=infoLegalizationNumberDocumentAttendantFather]').val('');
  //   }
  // });

  // $('select[name=legAttendantmother_id]').on('change', function(e) {
  //   var selectedAttendant = e.target.value;
  //   if (selectedAttendant !== null && selectedAttendant !== '') {
  //     $.get("{{ route('legAttendantSelected') }}", {
  //       selectedAttendant: selectedAttendant
  //     }, function(objectAttendant) {
  //       $('input[name=infoLegalizationTypeDocumentAttendantMother]').val('');
  //       $('input[name=infoLegalizationTypeDocumentAttendantMother]').val(objectAttendant['type']);
  //       $('input[name=infoLegalizationNumberDocumentAttendantMother]').val('');
  //       $('input[name=infoLegalizationNumberDocumentAttendantMother]').val(objectAttendant['numberdocument']);
  //     });
  //   } else {
  //     $('input[name=infoLegalizationTypeDocumentAttendantMother]').val('');
  //     $('input[name=infoLegalizationNumberDocumentAttendantMother]').val('');
  //   }
  // });

  // EVENTOS DE SECCION DEL BANCO
  // $('input[name=legPaid]').on('click',function(e){
  // 	var value = e.target.value;
  // 	if(value == 'SI'){
  // 		$('input[name=payValueContract]').val('');
  // 		$('input[name=payValueContract]').attr('disabled',false);
  // 		$('input[name=payValueContract]').attr('required',true);
  // 		$('input[name=payDuesQuotationContract]').val('');
  // 		$('input[name=payDuesQuotationContract]').attr('disabled',false);
  // 		$('input[name=payDuesQuotationContract]').attr('required',true);
  // 		$('input[name=payValuemountContract]').val('');
  // 		$('input[name=payValuemountContract]').attr('disabled',false);
  // 		$('input[name=payValuemountContract]').attr('required',true);
  // 		$('input[name=payDatepaidsContract]').val('');
  // 		$('input[name=payDatepaidsContract]').attr('disabled',false);
  // 		$('input[name=payDatepaidsContract]').attr('required',true);
  // 		$('input[name=payValueEnrollment]').val('');
  // 		$('input[name=payValueEnrollment]').attr('disabled',false);
  // 		$('input[name=payValueEnrollment]').attr('required',true);
  // 		$('input[name=payDuesQuotationEnrollment]').val('');
  // 		$('input[name=payDuesQuotationEnrollment]').attr('disabled',false);
  // 		$('input[name=payDuesQuotationEnrollment]').attr('required',true);
  // 		$('input[name=payValuemountEnrollment]').val('');
  // 		$('input[name=payValuemountEnrollment]').attr('disabled',false);
  // 		$('input[name=payValuemountEnrollment]').attr('required',true);
  // 		$('input[name=payDatepaidsEnrollment]').val('');
  // 		$('input[name=payDatepaidsEnrollment]').attr('disabled',false);
  // 		$('input[name=payDatepaidsEnrollment]').attr('required',true);
  // 		$('.sectionBank').css('display','flex');
  // 	}else if(value == 'NO'){
  // 		$('input[name=payValueContract]').val('');
  // 		$('input[name=payValueContract]').attr('disabled',true);
  // 		$('input[name=payValueContract]').attr('required',false);
  // 		$('input[name=payDuesQuotationContract]').val('');
  // 		$('input[name=payDuesQuotationContract]').attr('disabled',true);
  // 		$('input[name=payDuesQuotationContract]').attr('required',false);
  // 		$('input[name=payValuemountContract]').val('');
  // 		$('input[name=payValuemountContract]').attr('disabled',true);
  // 		$('input[name=payValuemountContract]').attr('required',false);
  // 		$('input[name=payDatepaidsContract]').val('');
  // 		$('input[name=payDatepaidsContract]').attr('disabled',true);
  // 		$('input[name=payDatepaidsContract]').attr('required',false);
  // 		$('input[name=payValueEnrollment]').val('');
  // 		$('input[name=payValueEnrollment]').attr('disabled',true);
  // 		$('input[name=payValueEnrollment]').attr('required',false);
  // 		$('input[name=payDuesQuotationEnrollment]').val('');
  // 		$('input[name=payDuesQuotationEnrollment]').attr('disabled',true);
  // 		$('input[name=payDuesQuotationEnrollment]').attr('required',false);
  // 		$('input[name=payValuemountEnrollment]').val('');
  // 		$('input[name=payValuemountEnrollment]').attr('disabled',true);
  // 		$('input[name=payValuemountEnrollment]').attr('required',false);
  // 		$('input[name=payDatepaidsEnrollment]').val('');
  // 		$('input[name=payDatepaidsEnrollment]').attr('disabled',true);
  // 		$('input[name=payDatepaidsEnrollment]').attr('required',false);
  // 		$('.sectionBank').css('display','none');
  // 	}
  // });

  function cleanNumber(info) {
    if (info.length > 0 && info.length < 4) {
      if (info.length >= 4 && info.length <= 6) {
        var resultClean = info.replace('.', '');
        console.log('retorno de cleanNumber mayor a 4 y menor a 6: ' + resultClean);
        return resultClean;
      } else if (info.length > 6) {
        var value = info.replace('.', '');
        var resultClean = value.replace('.', '');
        console.log('retorno de cleanNumber mayor a 6: ' + resultClean);
        return resultClean;
      }
    } else {
      console.log('retorno de cleanNumber info: ' + info);
      return info;
    }
  }

  $('input[name=payValueContract]').on('keyup', function(e) {
    var writed = e.target.value;
    var count = $('input[name=payDuesQuotationContract]').val();
    if (writed.length > 0 && count.length > 0) {
      let valueNew = writed / count;
      if (isNaN(valueNew)) {
        valueNew = 0;
      }
      $('input[name=payValuemountContract]').val('');
      $('input[name=payValuemountContract]').val(Math.round(valueNew));
    } else {
      $('input[name=payValuemountContract]').val('');
    }
  });

  $('input[name=payDuesQuotationContract]').on('keyup', function(e) {
    var writed = e.target.value;
    var count = $('input[name=payValueContract]').val();
    if (writed.length > 0 && count.length > 0) {
      let valueNew = count / writed;
      if (isNaN(valueNew)) {
        valueNew = 0;
      }
      $('input[name=payValuemountContract]').val('');
      $('input[name=payValuemountContract]').val(Math.round(valueNew));
    } else {
      $('input[name=payValuemountContract]').val('');
    }
  });

  $('input[name=payValueEnrollment]').on('keyup', function(e) {
    var writed = e.target.value;
    var count = $('input[name=payDuesQuotationEnrollment]').val();
    if (writed.length > 0 && count.length > 0) {
      let valueNew = writed / count;
      if (isNaN(valueNew)) {
        valueNew = 0;
      }
      $('input[name=payValuemountEnrollment]').val('');
      $('input[name=payValuemountEnrollment]').val(Math.round(valueNew));
    } else {
      $('input[name=payValuemountEnrollment]').val('');
    }
  });

  $('input[name=payDuesQuotationEnrollment]').on('keyup', function(e) {
    var writed = e.target.value;
    var count = $('input[name=payValueEnrollment]').val();
    if (writed.length > 0 && count.length > 0) {
      let valueNew = count / writed;
      if (isNaN(valueNew)) {
        valueNew = 0;
      }
      $('input[name=payValuemountEnrollment]').val('');
      $('input[name=payValuemountEnrollment]').val(Math.round(valueNew));
    } else {
      $('input[name=payValuemountEnrollment]').val('');
    }
  });

  function formatNumber(n) {
    // n = String(n).replace(/\D/g, "");
    // return n === '' ? n : Number(n).toLocaleString();
    if (n.length > 0) {
      if (n.length === 4) {
        var first = n.substr(0, 1);
        var second = n.substr(1, 3);
        var completed = first + '.' + second;
        return completed;
      } else if (n.length === 5) {
        var first = n.substr(0, 2);
        var second = n.substr(2, 3);
        var completed = first + '.' + second;
        return completed;
      } else if (n.length == 6) {
        var first = n.substr(0, 3);
        var second = n.substr(3, 3);
        var completed = first + '.' + second;
        return completed;
      } else if (n.length === 7) {
        var first = n.substr(0, 1);
        var second = n.substr(2, 3);
        var three = n.substr(4, 3);
        var completed = first + '.' + second + '.' + three;
        return completed;
      }
    } else {
      return n;
    }
  }
</script>
@endsection