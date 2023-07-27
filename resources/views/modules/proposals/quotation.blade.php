@extends('modules.proposal')

@section('proposalComercial')
<div class="row">
  <div class="card col-md-12">
    <div class="row">
      <div class="col-md-6">
        <h3>REGISTRO DE COTIZACIONES</h3>
      </div>
      <div class="col-md-6 align-items-center">
        <!-- Mensajes de actualizacion de cotizaciones -->
        @if(session('SuccessSaveQuotation'))
        <div class="alert alert-success">
          {{ session('SuccessSaveQuotation') }}
        </div>
        @endif
        @if(session('SecondarySaveQuotation'))
        <div class="alert alert-secondary">
          {{ session('SecondarySaveQuotation') }}
        </div>
        @endif
      </div>
    </div>
    <form action="{{ route('quotation.save') }}" method="POST">
      @csrf
      <div class="card-body col-md-12">
        <small class="text-muted">DATOS DE CLIENTE</small><br>
        <!-- <div class="row border-top border-bottom my-2">
						<div class="col-md-6 text-right">
							<small class="text-muted">¿EL CLIENTE YA ESTA REGISTRADO?</small>
						</div>
						<div class="col-md-6 text-left">
							<small class="text-muted mr-5">
								<input type="radio" name="proCustomerOption" value="SI" checked>
								SI
							</small>
							<small class="text-muted mr-5">
								<input type="radio" name="proCustomerOption" value="NO">
								NO
							</small>
						</div>
					</div> -->
        <div class="row border-top mt-2 old">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <small class="text-muted">Nombre de cliente:</small>
                      <select id="proCustomer_id" name="proCustomer_id" class="form-control form-control-sm" required>
                        <option value="">Seleccione un cliente...</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->cusId }}">{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted">Número de contacto:</small>
                    <input type="text" name="cusPhoneOld" class="form-control form-control-sm" readonly required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">Correo electrónico:</small>
                      <input type="text" name="cusMailOld" class="form-control form-control-sm" readonly required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-9">
                    <div class="form-group">
                      <small class="text-muted">Nombre de alumno:</small>
                      <input type="text" name="cusChildOld" class="form-control form-control-sm" readonly required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <small class="text-muted">Edad:</small>
                      <input type="text" name="cusChildYearsold_old" class="form-control form-control-sm" readonly required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <small class="text-muted">Notas/Observaciones:</small>
                      <textarea type="text" name="cusNotesOld" class="form-control form-control-sm" readonly required></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row border-top new">
          <div class="col-md-12">
            <small class="text-muted">DATOS DEL NUEVO CLIENTE</small>
            <div class="row border-top">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Nombres:</small>
                  <input type="text" name="cusFirstnameNew" class="form-control form-control-sm">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Apellidos:</small>
                  <input type="text" name="cusLastnameNew" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Número de contacto:</small>
                  <input type="number" name="cusPhoneNew" class="form-control form-control-sm">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Correo electrónico:</small>
                  <input type="email" name="cusMailNew" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <small class="text-muted">DATOS DE ASPIRANTE</small>
            <div class="row border-top">
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Nombres:</small>
                  <input type="text" name="cusChildNew" class="form-control form-control-sm">
                  <small class="text-muted">Edad:</small>
                  <input type="number" name="cusChildYearsoldNew" class="form-control form-control-sm">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small class="text-muted">Nota:</small>
                  <textarea type="text" id="cusNotesNew" name="cusNotesNew" class="form-control form-control-sm" placeholder="Máximo de 200 caracteres" maxlength="200"></textarea>
                  <small class="text-muted">Carácteres restantes: <b id="lenChar"></b></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="row border-top mt-2 old scheduleYes">
						<div class="col-md-12">
							<div class="row border-bottom">
							<small class="text-muted">EL CLIENTE SELECCIONADO CUENTA CON CITA PROGRAMADA:</small>
							</div>
							<div class="row">
								<div class="col-md-4">
									<input type="hidden" name="proScheduling_id" class="form-control form-control-sm" readonly>
									<div class="form-group">
										<small class="text-muted">Fecha:</small>
										<input type="text" name="schDateVisit" class="form-control form-control-sm" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<small class="text-muted">Dia:</small>
										<input type="text" name="schDayVisit" class="form-control form-control-sm" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<small class="text-muted">Hora:</small>
										<input type="time" name="schHourVisit" class="form-control form-control-sm" readonly>
									</div>
								</div>
							</div>
						</div>
					</div> -->
        <!-- <div class="row border-bottom old scheduleNo">
						<small class="infoScheduling"></small>
					</div> -->
        <small class="text-muted">COTIZACION:</small>
        <div class="row border-top border-bottom my-2">
          <div class="col-md-12">

            <div class="row">
              <div class="col-md-6 border-right">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group border-bottom my-3">
                      <input type="hidden" name="proScheduling_id" class="form-control form-control-sm" readonly>
                      <small class="text-muted">Grado:</small>
                      <select name="proGrade_id" class="form-control form-control-sm" required>
                        <option value="">Seleccione un grado...</option>
                        @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Admisión:</small>
                      <select name="proAdmission_id" class="form-control form-control-sm">
                        <option value="">Seleccione tipo de admisión...</option>
                        @foreach($admissions as $admission)
                        <option value="{{ $admission->id }}">{{ $admission->admConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addAdmission btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Jornada:</small>
                      <select name="proJourney_id" class="form-control form-control-sm">
                        <option value="">Seleccione una jornada...</option>
                        @foreach($journeys as $journey)
                        <option value="{{ $journey->id }}">{{ $journey->jouJourney }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addJourney btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Tipo de alimentación:</small>
                      <select name="proFeeding_id" class="form-control form-control-sm">
                        <option value="">Seleccione una alimentacion...</option>
                        @foreach($feedings as $feeding)
                        <option value="{{ $feeding->id }}">{{ $feeding->feeConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addFeeding btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Uniforme:</small>
                      <select name="proUniform_id" class="form-control form-control-sm">
                        <option value="">Seleccione un uniforme...</option>
                        @foreach($uniforms as $uniform)
                        <option value="{{ $uniform->id }}">{{ $uniform->uniConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addUniform btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Material escolar:</small>
                      <select name="proSupplie_id" class="form-control form-control-sm">
                        <option value="">Seleccione el material escolar...</option>
                        @foreach($supplies as $supplie)
                        <option value="{{ $supplie->id }}">{{ $supplie->supConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addSupplie btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Transporte:</small>
                      <select name="proTransport_id" class="form-control form-control-sm">
                        <option value="">Seleccione tipo de transporte...</option>
                        @foreach($transports as $transport)
                        <option value="{{ $transport->id }}">{{ $transport->traConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addTransport btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Tiempo extra:</small>
                      <select name="proExtratime_id" class="form-control form-control-sm">
                        <option value="">Seleccione el tiempo...</option>
                        @foreach($extratimes as $extratime)
                        <option value="{{ $extratime->id }}">{{ $extratime->extTConcept }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addExtratime btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <small class="text-muted mx-3">Extracurricular:</small>
                      <select name="proExtracurricular_id" class="form-control form-control-sm">
                        <option value="">Seleccione extracurricular...</option>
                        @foreach($extracurriculars as $extracurricular)
                        <option value="{{ $extracurricular->id }}">{{ $extracurricular->extConcept }} - {{ $extracurricular->extIntensity }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 pt-3 text-center">
                    <button type="button" class="btn-add addExtracurricular btn btn-outline-primary" style="width: 50px; line-height: 30px;" title="AÑADIR"><i class="fas fa-arrow-alt-circle-right"></i></button>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" style="background-color: #a4b068; border: none; outline: none; padding: 20px; color: #fff; font-size: 20px; font-weight: bold;" name="proValueQuotation" class="form-control text-center" value="$0" readonly required>
                </div>
              </div>
              <div class="col-md-6 border-left">
                <div class="row border-bottom mb-2">
                  <small class="text-muted">COSTOS Y CONCEPTOS: </small>
                </div>
                <div class="row">
                  <table id="relationQuotation" class="table">
                    <thead>
                      <tr>
                        <th>ITEM:</th>
                        <th>CONCEPTO:</th>
                        <th>VALOR:</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><b>GRADO:</b></td>
                        <td colspan="2"><span class="conceptGrade"></span></td>
                      </tr>
                      <tr>
                        <td><b>ADMISION:</b></td>
                        <td><span class="conceptAdmission"></span></td>
                        <td><span class="valueAdmission itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>JORNADA:</b></td>
                        <td>
                          <div class="conceptJourney">
                            <span class="conceptJourne"></span><br>
                          </div>
                        </td>
                        <td><span class="valueJourney itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>ALIMENTACION:</b></td>
                        <td><span class="conceptFeeding"></span></td>
                        <td><span class="valueFeeding itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>UNIFORME:</b></td>
                        <td><span class="conceptUniform"></span></td>
                        <td><span class="valueUniform itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>MATERIAL:</b></td>
                        <td><span class="conceptSupplie"></span></td>
                        <td><span class="valueSupplie itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>TRANSPORTE:</b></td>
                        <td><span class="conceptTransport"></span></td>
                        <td><span class="valueTransport itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>TIEMPO EXTRA:</b></td>
                        <td><span class="conceptExtratime"></span></td>
                        <td><span class="valueExtratime itemValue"></span></td>
                      </tr>
                      <tr>
                        <td><b>EXTRACURRICULAR:</b></td>
                        <td>
                          <span class="conceptExtracurricular"></span><br>
                          <span class="intensityExtracurricular"></span>
                        </td>
                        <td><span class="valueExtracurricular itemValue"></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <input type="hidden" name="detailsAdmission_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsJourney_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsFeeding_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsUniform_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsSupplie_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsTransport_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsExtratime_input" class="form-control form-control-sm" required>
            <input type="hidden" name="detailsExtracurricular_input" class="form-control form-control-sm" required>
            <button type="submit" class="btn btn-outline-success form-control-sm btn-send" style="display: none;">COTIZAR</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('.new').css('display', 'none');
    $('.scheduleNo').css('display', 'none');
    $('.scheduleYes').css('display', 'none');

    $('textarea[name=schDateVisit]').attr('required', false);
    $('textarea[name=schDayVisit]').attr('required', false);
    $('textarea[name=schHourVisit]').attr('required', false);
  });

  $('input[name=proCustomerOption]').on('change', function() {
    if ($(this).val() == 'SI') {

      $('.old').css('display', 'flex');
      $("#proCustomer_id option:contains('Seleccione un cliente...')").attr('selected', 'selected');
      $('#proCustomer_id').attr('required', true);
      $('input[name=cusPhoneOld]').val('');
      $('input[name=cusPhoneOld]').attr('required', true);
      $('input[name=cusMailOld]').val('');
      $('input[name=cusMailOld]').attr('required', true);
      $('input[name=cusChildOld]').val('');
      $('input[name=cusChildOld]').attr('required', true);
      $('input[name=cusChildYearsold_old]').val('');
      $('input[name=cusChildYearsold_old]').attr('required', true);
      $('textarea[name=cusNotesOld]').val('');
      $('textarea[name=cusNotesOld]').attr('required', true);

      $('.new').css('display', 'none');
      $('input[name=cusFirstnameNew]').val('');
      $('input[name=cusFirstnameNew]').attr('required', false);
      $('input[name=cusLastnameNew]').val('');
      $('input[name=cusLastnameNew]').attr('required', false);
      $('input[name=cusPhoneNew]').val('');
      $('input[name=cusPhoneNew]').attr('required', false);
      $('input[name=cusMailNew]').val('');
      $('input[name=cusMailNew]').attr('required', false);
      $('input[name=cusChildNew]').val('');
      $('input[name=cusChildNew]').attr('required', false);
      $('input[name=cusChildYearsoldNew]').val('');
      $('input[name=cusChildYearsoldNew]').attr('required', false);
      $('textarea[name=cusNotesNew]').val('');
      $('textarea[name=cusNotesNew]').attr('required', false);
      $('.scheduleNo').css('display', 'none');
      $('.scheduleYes').css('display', 'none');
      $('textarea[name=schDateVisit]').val('');
      $('textarea[name=schDayVisit]').val('');
      $('textarea[name=schHourVisit]').val('');
    } else if ($(this).val() == 'NO') {

      $('.old').css('display', 'none');
      $("#proCustomer_id option:contains('Seleccione un cliente...')").attr('selected', 'selected');
      $('#proCustomer_id').attr('required', false);
      $('input[name=cusPhoneOld]').val('');
      $('input[name=cusPhoneOld]').attr('required', false);
      $('input[name=cusMailOld]').val('');
      $('input[name=cusMailOld]').attr('required', false);
      $('input[name=cusChildOld]').val('');
      $('input[name=cusChildOld]').attr('required', false);
      $('input[name=cusChildYearsold_old]').val('');
      $('input[name=cusChildYearsold_old]').attr('required', false);
      $('textarea[name=cusNotesOld]').val('');
      $('textarea[name=cusNotesOld]').attr('required', false);

      $('.new').css('display', 'flex');
      $('input[name=cusFirstnameNew]').val('');
      $('input[name=cusFirstnameNew]').attr('required', true);
      $('input[name=cusLastnameNew]').val('');
      $('input[name=cusLastnameNew]').attr('required', true);
      $('input[name=cusPhoneNew]').val('');
      $('input[name=cusPhoneNew]').attr('required', true);
      $('input[name=cusMailNew]').val('');
      $('input[name=cusMailNew]').attr('required', true);
      $('input[name=cusChildNew]').val('');
      $('input[name=cusChildNew]').attr('required', true);
      $('input[name=cusChildYearsoldNew]').val('');
      $('input[name=cusChildYearsoldNew]').attr('required', true);
      $('textarea[name=cusNotesNew]').val('');
      $('textarea[name=cusNotesNew]').attr('required', true);
      $('.scheduleNo').css('display', 'none');
      $('.scheduleYes').css('display', 'none');
      // $('input[name=proScheduling_id]').val('');
      // $('input[name=schDateVisit]').val('');
      // $('input[name=schDayVisit]').val('');
      // $('input[name=schHourVisit]').val('');
    }
  });

  $('#proCustomer_id').on('change', function(e) {
    var customer_id = e.target.value;
    $.get("{{ route('selectedCustomerForQuotation') }}", {
      customerSelected: customer_id
    }, function(customerObject) {

      if (customerObject !== null) {
        $("input[name=cusPhoneOld]").val('');
        $("input[name=cusPhoneOld]").val(customerObject['cusPhone']);
        $("input[name=cusMailOld]").val('');
        $("input[name=cusMailOld]").val(customerObject['cusMail']);
        $("input[name=cusChildOld]").val('');
        $("input[name=cusChildOld]").val(customerObject['cusChild']);
        $("input[name=cusChildYearsold_old]").val('');
        $("input[name=cusChildYearsold_old]").val(customerObject['cusChildYearsold']);
        $("textarea[name=cusNotesOld]").val('');
        $("textarea[name=cusNotesOld]").val(customerObject['cusNotes']);
      }
      $.get("{{ route('schedulingActiveFromCustomer') }}", {
        customerSelected: customer_id
      }, function(schedulingObject) {
        if (schedulingObject !== null) {
          // $('.scheduleNo').css('display','none');
          // $('.scheduleYes').css('display','flex');
          $("input[name=proScheduling_id]").val('');
          $("input[name=proScheduling_id]").attr('required', true);
          $("input[name=proScheduling_id]").val(schedulingObject['id']);
          // $("input[name=schDateVisit]").val('');
          // $("input[name=schDateVisit]").attr('required',true);
          // $("input[name=schDateVisit]").val(schedulingObject['schDateVisit']);
          // $("input[name=schDayVisit]").val('');
          // $("input[name=schDayVisit]").attr('required',true);
          // $("input[name=schDayVisit]").val(schedulingObject['schDayVisit']);
          // $("input[name=schHourVisit]").val('');
          // $("input[name=schHourVisit]").attr('required',true);
          // $("input[name=schHourVisit]").val(schedulingObject['schHourVisit']);
        }
        // else{
        // $("input[name=proScheduling_id]").val('');
        // $("input[name=proScheduling_id]").attr('required',false);
        // $("input[name=schDateVisit]").val('');
        // $("input[name=schDateVisit]").attr('required',false);
        // $("input[name=schDayVisit]").val('');
        // $("input[name=schDayVisit]").attr('required',false);
        // $("input[name=schHourVisit]").val('');
        // $("input[name=schHourVisit]").attr('required',false);
        // $('.scheduleNo').css('display','flex');
        // $('.scheduleYes').css('display','none');
        // $('.infoScheduling').html("<b>INFORMACIÓN: </b></small class='text-muted'>CLIENTE SIN CITA PREVIA</small>");
        // }
      });
    });
  });

  //SELECTOR DE GRADO
  $('select[name=proGrade_id]').on('change', function(e) {
    if (e.target.value !== '') {
      $.get("{{ route('selectedGradeQuotation') }}", {
        selectedConcept: e.target.value
      }, function(gradeObject) {
        $('.conceptGrade').text('');
        $('.conceptGrade').text(gradeObject['name']);
      });
    } else {
      $('.conceptGrade').text('');
    }
  });

  //ITEMS DE ADMISIONES
  $('.addAdmission').on('click', function() {
    var admission = $('select[name=proAdmission_id]').val();
    if (admission !== '') {
      $.get("{{ route('selectedAdmissionQuotation') }}", {
        selectedConcept: admission
      }, function(admissionObject) {
        var count = $('.conceptAdmission > .admItem').length + 1;
        if ($('#relationQuotation .admissionItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .admissionItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .admissionItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptAdmission').html() !== '') {
          $('.conceptAdmission').append("<div class='admItem admissionItem" + count + "'><br><a href='#' title='QUITAR' class='link-delAdmission px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idAdmission' value='" + admissionObject['id'] + "' required>" + admissionObject['admConcept'] + "</div>");
          $('.valueAdmission').append("<div class='admissionItem" + count + "'><br>" + admissionObject['admValue'] + "</div>");
        } else {
          $('.conceptAdmission').append("<div class='admItem admissionItem" + count + "'><a href='#' title='QUITAR' class='link-delAdmission px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idAdmission' value='" + admissionObject['id'] + "' required>" + admissionObject['admConcept'] + "</div>");
          $('.valueAdmission').append("<div class='admissionItem" + count + "'>" + admissionObject['admValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delAdmission', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.admItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE JORNADAS
  $('.addJourney').on('click', function() {
    var journey = $('select[name=proJourney_id]').val();
    if (journey !== '') {
      $.get("{{ route('selectedJourneyQuotation') }}", {
        selectedConcept: journey
      }, function(journeyObject) {
        var count = $('.conceptJourney > .jouItem').length + 1;
        if ($('#relationQuotation .journeyItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .journeyItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .journeyItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptJourney').html() !== '') {
          $('.conceptJourney').append("<div class='jouItem journeyItem" + count + "'><br><a href='#' title='QUITAR' class='link-delJourney px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idJourney' value='" + journeyObject['id'] + "' required>" + journeyObject['jouJourney'] + "<br>" + journeyObject['jouDays'] + "<br>" + journeyObject['jouHourEntry'] + "<br>" + journeyObject['jouHourExit'] + "</div>");
          $('.valueJourney').append("<div class='journeyItem" + count + "'><br>" + journeyObject['jouValue'] + "</div>");
        } else {
          $('.conceptJourney').append("<div class='jouItem journeyItem" + count + "'><a href='#' title='QUITAR' class='link-delJourney px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idJourney' value='" + journeyObject['id'] + "' required>" + journeyObject['jouJourney'] + "<br>" + journeyObject['jouDays'] + "<br>" + journeyObject['jouHourEntry'] + "<br>" + journeyObject['jouHourExit'] + "</div>");
          $('.valueJourney').append("<div class='journeyItem" + count + "'>" + journeyObject['jouValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delJourney', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.jouItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE ALIMENTACION
  $('.addFeeding').on('click', function() {
    var feeding = $('select[name=proFeeding_id]').val();
    if (feeding !== '') {
      $.get("{{ route('selectedFeedingQuotation') }}", {
        selectedConcept: feeding
      }, function(feedingObject) {
        var count = $('.conceptFeeding > .feeItem').length + 1;
        if ($('#relationQuotation .feedingItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .feedingItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .feedingItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptFeeding').html() !== '') {
          $('.conceptFeeding').append("<div class='feeItem feedingItem" + count + "'><br><a href='#' title='QUITAR' class='link-delFeeding px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idFeeding' value='" + feedingObject['id'] + "' required>" + feedingObject['feeConcept'] + "</div>");
          $('.valueFeeding').append("<div class='feedingItem" + count + "'><br>" + feedingObject['feeValue'] + "</div>");
        } else {
          $('.conceptFeeding').append("<div class='feeItem feedingItem" + count + "'><a href='#' title='QUITAR' class='link-delFeeding px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idFeeding' value='" + feedingObject['id'] + "' required>" + feedingObject['feeConcept'] + "</div>");
          $('.valueFeeding').append("<div class='feedingItem" + count + "'>" + feedingObject['feeValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delFeeding', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.feeItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE UNIFORMES
  $('.addUniform').on('click', function() {
    var uniform = $('select[name=proUniform_id]').val();
    if (uniform !== '') {
      $.get("{{ route('selectedUniformQuotation') }}", {
        selectedConcept: uniform
      }, function(uniformObject) {
        var count = $('.conceptUniform > .uniItem').length + 1;
        if ($('#relationQuotation .uniformItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .uniformItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .uniformItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptUniform').html() !== '') {
          $('.conceptUniform').append("<div class='uniItem uniformItem" + count + "'><br><a href='#' title='QUITAR' class='link-delUniform px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idUniform' value='" + uniformObject['id'] + "' required>" + uniformObject['uniConcept'] + "</div>");
          $('.valueUniform').append("<div class='uniformItem" + count + "'><br>" + uniformObject['uniValue'] + "</div>");
        } else {
          $('.conceptUniform').append("<div class='uniItem uniformItem" + count + "'><a href='#' title='QUITAR' class='link-delUniform px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idUniform' value='" + uniformObject['id'] + "' required>" + uniformObject['uniConcept'] + "</div>");
          $('.valueUniform').append("<div class='uniformItem" + count + "'>" + uniformObject['uniValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delUniform', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.uniItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE MATERIALES ESCOLARES
  $('.addSupplie').on('click', function() {
    var supplie = $('select[name=proSupplie_id]').val();
    if (supplie !== '') {
      $.get("{{ route('selectedSupplieQuotation') }}", {
        selectedConcept: supplie
      }, function(supplieObject) {
        var count = $('.conceptSupplie > .supItem').length + 1;
        if ($('#relationQuotation .supplieItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .supplieItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .supplieItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptSupplie').html() !== '') {
          $('.conceptSupplie').append("<div class='supItem supplieItem" + count + "'><br><a href='#' title='QUITAR' class='link-delSupplie px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idSupplie' value='" + supplieObject['id'] + "' required>" + supplieObject['supConcept'] + "</div>");
          $('.valueSupplie').append("<div class='supplieItem" + count + "'><br>" + supplieObject['supValue'] + "</div>");
        } else {
          $('.conceptSupplie').append("<div class='supItem supplieItem" + count + "'><a href='#' title='QUITAR' class='link-delSupplie px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idSupplie' value='" + supplieObject['id'] + "' required>" + supplieObject['supConcept'] + "</div>");
          $('.valueSupplie').append("<div class='supplieItem" + count + "'>" + supplieObject['supValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delSupplie', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.supItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE TRANSPORTE
  $('.addTransport').on('click', function() {
    var transport = $('select[name=proTransport_id]').val();
    if (transport !== '') {
      $.get("{{ route('selectedTransportQuotation') }}", {
        selectedConcept: transport
      }, function(transportObject) {
        var count = $('.conceptTransport > .traItem').length + 1;
        if ($('#relationQuotation .transportItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .transportItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .transportItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptTransport').html() !== '') {
          $('.conceptTransport').append("<div class='traItem transportItem" + count + "'><br><a href='#' title='QUITAR' class='link-delTransport px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idTransport' value='" + transportObject['id'] + "' required>" + transportObject['traConcept'] + "</div>");
          $('.valueTransport').append("<div class='transportItem" + count + "'><br>" + transportObject['traValue'] + "</div>");
        } else {
          $('.conceptTransport').append("<div class='traItem transportItem" + count + "'><a href='#' title='QUITAR' class='link-delTransport px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idTransport' value='" + transportObject['id'] + "' required>" + transportObject['traConcept'] + "</div>");
          $('.valueTransport').append("<div class='transportItem" + count + "'>" + transportObject['traValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delTransport', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.traItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE TIEMPO EXTRA
  $('.addExtratime').on('click', function() {
    var extratime = $('select[name=proExtratime_id]').val();
    if (extratime !== '') {
      $.get("{{ route('selectedExtratimeQuotation') }}", {
        selectedConcept: extratime
      }, function(extratimeObject) {
        var count = $('.conceptExtratime > .extTItem').length + 1;
        if ($('#relationQuotation .extratimeItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .extratimeItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .extratimeItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptExtratime').html() !== '') {
          $('.conceptExtratime').append("<div class='extTItem extratimeItem" + count + "'><br><a href='#' title='QUITAR' class='link-delExtratime px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idExtratime' value='" + extratimeObject['id'] + "' required>" + extratimeObject['extTConcept'] + "</div>");
          $('.valueExtratime').append("<div class='extratimeItem" + count + "'><br>" + extratimeObject['extTValue'] + "</div>");
        } else {
          $('.conceptExtratime').append("<div class='extTItem extratimeItem" + count + "'><a href='#' title='QUITAR' class='link-delExtratime px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idExtratime' value='" + extratimeObject['id'] + "' required>" + extratimeObject['extTConcept'] + "</div>");
          $('.valueExtratime').append("<div class='extratimeItem" + count + "'>" + extratimeObject['extTValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delExtratime', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.extTItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  //ITEMS DE EXTRACURRICULARES
  $('.addExtracurricular').on('click', function() {
    var extracurricular = $('select[name=proExtracurricular_id]').val();
    if (extracurricular !== '') {
      $.get("{{ route('selectedExtracurricularQuotation') }}", {
        selectedConcept: extracurricular
      }, function(extracurricularObject) {
        var count = $('.conceptExtracurricular > .extItem').length + 1;
        if ($('#relationQuotation .extracurricularItem' + count).length > 0) {
          count++;
          if ($('#relationQuotation .extracurricularItem' + count).length > 0) {
            count++;
            if ($('#relationQuotation .extracurricularItem' + count).length > 0) {
              count++;
            }
          }
        }
        if ($('.conceptExtracurricular').html() !== '') {
          $('.conceptExtracurricular').append("<div class='extItem extracurricularItem" + count + "'><br><a href='#' title='QUITAR' class='link-delExtracurricular px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idExtracurricular' value='" + extracurricularObject['id'] + "' required>" + extracurricularObject['extConcept'] + "<br>" + extracurricularObject['extIntensity'] + "</div>");
          $('.valueExtracurricular').append("<div class='extracurricularItem" + count + "'><br>" + extracurricularObject['extValue'] + "</div>");
        } else {
          $('.conceptExtracurricular').append("<div class='extItem extracurricularItem" + count + "'><a href='#' title='QUITAR' class='link-delExtracurricular px-1' style='color: #ff5500'><i class='fas fa-minus-circle'></i></a><input type='hidden' name='idExtracurricular' value='" + extracurricularObject['id'] + "' required>" + extracurricularObject['extConcept'] + "<br>" + extracurricularObject['extIntensity'] + "</div>");
          $('.valueExtracurricular').append("<div class='extracurricularItem" + count + "'>" + extracurricularObject['extValue'] + "</div>");
        }
        getValuesAndTotal();
      });
    }
  });
  $('#relationQuotation').on('click', '.link-delExtracurricular', function(e) {
    e.preventDefault();
    var value = $(this).parent('div.extItem').attr('class');
    var classReal = value.split(' ');
    $('#relationQuotation .' + classReal[1]).remove();
    getValuesAndTotal();
  });

  function getValuesAndTotal() {
    var totalAdmission = 0;
    $('.valueAdmission > div').each(function() {
      totalAdmission += parseInt($(this).text());
    });
    var detailsAdmission = '';
    var totalFieldAdmission = $('.conceptAdmission input').length;
    var indexAdmission = 1;
    $('.conceptAdmission input').each(function() {
      if (indexAdmission === totalFieldAdmission) {
        detailsAdmission += $(this).val();
      } else {
        detailsAdmission += $(this).val() + ':';
      }
      indexAdmission++;
    });
    $('input[name=detailsAdmission_input]').val('');
    $('input[name=detailsAdmission_input]').val(detailsAdmission);

    var totalJourney = 0;
    $('.valueJourney > div').each(function() {
      totalJourney += parseInt($(this).text());
    });
    var detailsJourney = '';
    var totalFieldJourney = $('.conceptJourney input').length;
    var indexJourney = 1;
    $('.conceptJourney input').each(function() {
      if (indexJourney === totalFieldJourney) {
        detailsJourney += $(this).val();
      } else {
        detailsJourney += $(this).val() + ':';
      }
      indexJourney++;
    });
    $('input[name=detailsJourney_input]').val('');
    $('input[name=detailsJourney_input]').val(detailsJourney);

    var totalFeeding = 0;
    $('.valueFeeding > div').each(function() {
      totalFeeding += parseInt($(this).text());
    });
    var detailsFeeding = '';
    var totalFieldFeeding = $('.conceptFeeding input').length;
    var indexFeeding = 1;
    $('.conceptFeeding input').each(function() {
      if (indexFeeding == totalFieldFeeding) {
        detailsFeeding += $(this).val();
      } else {
        detailsFeeding += $(this).val() + ':';
      }
      indexFeeding++;
    });
    $('input[name=detailsFeeding_input]').val('');
    $('input[name=detailsFeeding_input]').val(detailsFeeding);

    var totalUniform = 0;
    $('.valueUniform > div').each(function() {
      totalUniform += parseInt($(this).text());
    });
    var detailsUniform = '';
    var totalFieldUniform = $('.conceptUniform input').length;
    var indexUniform = 1;
    $('.conceptUniform input').each(function() {
      if (indexUniform == totalFieldUniform) {
        detailsUniform += $(this).val();
      } else {
        detailsUniform += $(this).val() + ':';
      }
      indexUniform++;
    });
    $('input[name=detailsUniform_input]').val('');
    $('input[name=detailsUniform_input]').val(detailsUniform);

    var totalSupplie = 0;
    $('.valueSupplie > div').each(function() {
      totalSupplie += parseInt($(this).text());
    });
    var detailsSupplie = '';
    var totalFieldSupplie = $('.conceptSupplie input').length;
    var indexSupplie = 1;
    $('.conceptSupplie input').each(function() {
      if (indexSupplie == totalFieldSupplie) {
        detailsSupplie += $(this).val();
      } else {
        detailsSupplie += $(this).val() + ':';
      }
      indexSupplie++;
    });
    $('input[name=detailsSupplie_input]').val('');
    $('input[name=detailsSupplie_input]').val(detailsSupplie);

    var totalTransport = 0;
    $('.valueTransport > div').each(function() {
      totalTransport += parseInt($(this).text());
    });
    var detailsTransport = '';
    var totalFieldTransport = $('.conceptTransport input').length;
    var indexTransport = 1;
    $('.conceptTransport input').each(function() {
      if (indexTransport == totalFieldTransport) {
        detailsTransport += $(this).val();
      } else {
        detailsTransport += $(this).val() + ':';
      }
      indexTransport++;
    });
    $('input[name=detailsTransport_input]').val('');
    $('input[name=detailsTransport_input]').val(detailsTransport);

    var totalExtratime = 0;
    $('.valueExtratime > div').each(function() {
      totalExtratime += parseInt($(this).text());
    });
    var detailsExtratime = '';
    var totalFieldExtratime = $('.conceptExtratime input').length;
    var indexExtratime = 1;
    $('.conceptExtratime input').each(function() {
      if (indexExtratime == totalFieldExtratime) {
        detailsExtratime += $(this).val();
      } else {
        detailsExtratime += $(this).val() + ':';
      }
      indexExtratime++;
    });
    $('input[name=detailsExtratime_input]').val('');
    $('input[name=detailsExtratime_input]').val(detailsExtratime);

    var totalExtracurricular = 0;
    $('.valueExtracurricular > div').each(function() {
      totalExtracurricular += parseInt($(this).text());
    });
    var detailsExtracurricular = '';
    var totalFieldExtracurricular = $('.conceptExtracurricular input').length;
    var indexExtracurricular = 1;
    $('.conceptExtracurricular input').each(function() {
      if (indexExtracurricular == totalFieldExtracurricular) {
        detailsExtracurricular += $(this).val();
      } else {
        detailsExtracurricular += $(this).val() + ':';
      }
      indexExtracurricular++;
    });
    $('input[name=detailsExtracurricular_input]').val('');
    $('input[name=detailsExtracurricular_input]').val(detailsExtracurricular);

    var totalQuotation = totalAdmission + totalJourney + totalFeeding + totalUniform + totalSupplie + totalTransport + totalExtratime + totalExtracurricular;
    $('input[name=proValueQuotation]').val('');
    $('input[name=proValueQuotation]').val('$' + totalQuotation);
    if (totalQuotation > 0) {
      $('button.btn-send').css('display', 'block');
    } else {
      $('button.btn-send').css('display', 'none');
    }
  }
</script>
@endsection