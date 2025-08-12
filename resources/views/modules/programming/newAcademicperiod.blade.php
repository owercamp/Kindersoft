@extends('modules.programming')

@section('academicModules')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <h3>REGISTRAR PERIODOS ACADEMICOS</h3>
    </div>
    <div class="col-md-6">
      <a href="{{ route('academicperiod') }}" class="btn btn-outline-tertiary  form-control-sm">VOLVER</a>
    </div>
  </div>
  <form action="{{ route('academicperiod.save') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">CURSO:</small>
          <select name="apCourse" class="form-control form-control-sm select2" required>
            <option value="">Seleccione un curso...</option>
            @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <small class="text-muted">GRADO:</small>
          <input type="text" name="apGrade" class="form-control form-control-sm" value="" disabled>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <small class="text-muted">DIRECTOR/A DE GRUPO:</small>
          <input type="text" name="apCollaborator" class="form-control form-control-sm" value="" disabled>
        </div>
        <div class="form-group">
          <small class="text-muted">ESTADO DEL CURSO:</small>
          <input type="text" name="apStatus" class="form-control form-control-sm" value="" disabled>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <div class="row mt-3">
            <div class="col-md-6 text-center">
              <small class="text-muted">
                <input type="radio" name="optionAll" value="SI" checked>
                Definir varios periodos
              </small>
            </div>
            <div class="col-md-6 text-center">
              <small class="text-muted">
                <input type="radio" name="optionAll" value="NO">
                Definir solo uno
              </small>
            </div>
          </div>
        </div>
        <div class="form-group sectionAll">
          <small class="text-muted">CANTIDAD DE PERIODOS:</small>
          <select name="countPeriod" class="form-control form-control-sm select2" required>
            <option value="">Seleccione una cantidad...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row my-3 border-top border-bottom">
      <div class="col-md-12">
        <div class="row unique my-4" style="display: none;">
          <div class="col-md-4 offset-md-4 border-left border-right">
            <div class="form-group">
              <h5>PERIODO:</h5>
              <select name="apNamePeriodUnique" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un periodo...</option>
                <option value="PRIMER PERIODO">PRIMER PERIODO</option>
                <option value="SEGUNDO PERIODO">SEGUNDO PERIODO</option>
                <option value="TERCER PERIODO">TERCER PERIODO</option>
                <option value="CUARTO PERIODO">CUARTO PERIODO</option>
              </select>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialUnique" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalUnique" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusUnique" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row one my-4" style="display: none;">
          <div class="col-md-4 offset-md-4 border-left border-right">
            <div class="form-group">
              <h5>PRIMER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialOne" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalOne" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusOne" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row two my-4" style="display: none;">
          <div class="col-md-4 offset-md-2 border-left border-right">
            <div class="form-group">
              <h5>PRIMER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialTwo_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalTwo_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusTwo_one" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 border-left border-right">
            <div class="form-group">
              <h5>SEGUNDO PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialTwo_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalTwo_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusTwo_two" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row three my-4" style="display: none;">
          <div class="col-md-4 border-left border-right">
            <div class="form-group">
              <h5>PRIMER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialThree_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalThree_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusThree_one" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 border-left border-right">
            <div class="form-group">
              <h5>SEGUNDO PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialThree_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalThree_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusThree_two" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 border-left border-right">
            <div class="form-group">
              <h5>TERCER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialThree_three" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalThree_three" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusThree_three" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row four my-4" style="display: none;">
          <div class="col-md-3 border-left border-right">
            <div class="form-group">
              <h5>PRIMER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialFour_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalFour_one" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusFour_one" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 border-left border-right">
            <div class="form-group">
              <h5>SEGUNDO PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialFour_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalFour_two" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusFour_two" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 border-left border-right">
            <div class="form-group">
              <h5>TERCER PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialFour_three" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalFour_three" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusFour_three" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 border-left border-right">
            <div class="form-group">
              <h5>CUARTO PERIODO</h5>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de inicio:</small>
              <input type="text" name="apDateInitialFour_four" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Fecha de terminación:</small>
              <input type="text" name="apDateFinalFour_four" class="form-control form-control-sm datepicker" disabled>
            </div>
            <div class="form-group">
              <small class="text-muted">Estado:</small>
              <select name="apStatusFour_four" class="form-control form-control-sm select2" disabled>
                <option value="">Seleccione un estado...</option>
                <option value="ACTIVO" selected>ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center boder-top py-3">
        <div class="form-group">
          <button type="submit" class="btn btn-outline-success form-control-sm mt-4">ESTABLECER PERIODOS</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(function() {

  });

  $('input[name=optionAll]').on('change', function(e) {
    var optionSelected = e.target.value;
    if (optionSelected == 'SI') {
      $('.sectionAll').css('display', 'flex');
      $('select[name=countPeriod]').attr('disabled', false);
      $('select[name=countPeriod]').attr('required', true);
      disabledUnique();
    } else if (optionSelected == 'NO') {
      $('.sectionAll').css('display', 'none');
      $('select[name=countPeriod]').attr('disabled', true);
      $('select[name=countPeriod]').attr('required', false);
      disabledAll();
    }
  });

  $('select[name=countPeriod]').on('change', function(e) {
    var count = e.target.value;

    if (count == 0) {
      $('.one').css('display', 'none');
      $('input[name=apNameperiodOne]').attr('disabled', true);
      $('input[name=apNameperiodOne]').attr('required', false);
      $('input[name=apDateInitialOne]').attr('disabled', true);
      $('input[name=apDateInitialOne]').attr('required', false);
      $('input[name=apDateFinalOne]').attr('disabled', true);
      $('input[name=apDateFinalOne]').attr('required', false);
      $('select[name=apStatusOne]').attr('disabled', true);
      $('select[name=apStatusOne]').attr('required', false);

      $('.two').css('display', 'none');
      $('input[name=apNameperiodTwo_one]').attr('disabled', true);
      $('input[name=apNameperiodTwo_one]').attr('required', false);
      $('input[name=apDateInitialTwo_one]').attr('disabled', true);
      $('input[name=apDateInitialTwo_one]').attr('required', false);
      $('input[name=apDateFinalTwo_one]').attr('disabled', true);
      $('input[name=apDateFinalTwo_one]').attr('required', false);
      $('select[name=apStatusTwo_one]').attr('disabled', true);
      $('select[name=apStatusTwo_one]').attr('required', false);
      $('input[name=apNameperiodTwo_two]').attr('disabled', true);
      $('input[name=apNameperiodTwo_two]').attr('required', false);
      $('input[name=apDateInitialTwo_two]').attr('disabled', true);
      $('input[name=apDateInitialTwo_two]').attr('required', false);
      $('input[name=apDateFinalTwo_two]').attr('disabled', true);
      $('input[name=apDateFinalTwo_two]').attr('required', false);
      $('select[name=apStatusTwo_two]').attr('disabled', true);
      $('select[name=apStatusTwo_two]').attr('required', false);

      $('.three').css('display', 'none');
      $('input[name=apNameperiodThree_one]').attr('disabled', true);
      $('input[name=apNameperiodThree_one]').attr('required', false);
      $('input[name=apDateInitialThree_one]').attr('disabled', true);
      $('input[name=apDateInitialThree_one]').attr('required', false);
      $('input[name=apDateFinalThree_one]').attr('disabled', true);
      $('input[name=apDateFinalThree_one]').attr('required', false);
      $('select[name=apStatusThree_one]').attr('disabled', true);
      $('select[name=apStatusThree_one]').attr('required', false);
      $('input[name=apNameperiodThree_two]').attr('disabled', true);
      $('input[name=apNameperiodThree_two]').attr('required', false);
      $('input[name=apDateInitialThree_two]').attr('disabled', true);
      $('input[name=apDateInitialThree_two]').attr('required', false);
      $('input[name=apDateFinalThree_two]').attr('disabled', true);
      $('input[name=apDateFinalThree_two]').attr('required', false);
      $('select[name=apStatusThree_two]').attr('disabled', true);
      $('select[name=apStatusThree_two]').attr('required', false);
      $('input[name=apNameperiodThree_three]').attr('disabled', true);
      $('input[name=apNameperiodThree_three]').attr('required', false);
      $('input[name=apDateInitialThree_three]').attr('disabled', true);
      $('input[name=apDateInitialThree_three]').attr('required', false);
      $('input[name=apDateFinalThree_three]').attr('disabled', true);
      $('input[name=apDateFinalThree_three]').attr('required', false);
      $('select[name=apStatusThree_three]').attr('disabled', true);
      $('select[name=apStatusThree_three]').attr('required', false);

      $('.four').css('display', 'none');
      $('input[name=apNameperiodFour_one]').attr('disabled', true);
      $('input[name=apNameperiodFour_one]').attr('required', false);
      $('input[name=apDateInitialFour_one]').attr('disabled', true);
      $('input[name=apDateInitialFour_one]').attr('required', false);
      $('input[name=apDateFinalFour_one]').attr('disabled', true);
      $('input[name=apDateFinalFour_one]').attr('required', false);
      $('select[name=apStatusFour_one]').attr('disabled', true);
      $('select[name=apStatusFour_one]').attr('required', false);
      $('input[name=apNameperiodFour_two]').attr('disabled', true);
      $('input[name=apNameperiodFour_two]').attr('required', false);
      $('input[name=apDateInitialFour_two]').attr('disabled', true);
      $('input[name=apDateInitialFour_two]').attr('required', false);
      $('input[name=apDateFinalFour_two]').attr('disabled', true);
      $('input[name=apDateFinalFour_two]').attr('required', false);
      $('select[name=apStatusFour_two]').attr('disabled', true);
      $('select[name=apStatusFour_two]').attr('required', false);
      $('input[name=apNameperiodFour_three]').attr('disabled', true);
      $('input[name=apNameperiodFour_three]').attr('required', false);
      $('input[name=apDateInitialFour_three]').attr('disabled', true);
      $('input[name=apDateInitialFour_three]').attr('required', false);
      $('input[name=apDateFinalFour_three]').attr('disabled', true);
      $('input[name=apDateFinalFour_three]').attr('required', false);
      $('select[name=apStatusFour_three]').attr('disabled', true);
      $('select[name=apStatusFour_three]').attr('required', false);
      $('input[name=apNameperiodFour_four]').attr('disabled', true);
      $('input[name=apNameperiodFour_four]').attr('required', false);
      $('input[name=apDateInitialFour_four]').attr('disabled', true);
      $('input[name=apDateInitialFour_four]').attr('required', false);
      $('input[name=apDateFinalFour_four]').attr('disabled', true);
      $('input[name=apDateFinalFour_four]').attr('required', false);
      $('select[name=apStatusFour_four]').attr('disabled', true);
      $('select[name=apStatusFour_four]').attr('required', false);

      $('.unique').css('display', 'none');
      $('select[name=apNamePeriodUnique]').attr('disabled', true);
      $('select[name=apNamePeriodUnique]').attr('required', false);
      $('input[name=apDateInitialUnique]').attr('disabled', true);
      $('input[name=apDateInitialUnique]').attr('required', false);
      $('input[name=apDateFinalUnique]').attr('disabled', true);
      $('input[name=apDateFinalUnique]').attr('required', false);
      $('select[name=apStatusUnique]').attr('disabled', true);
      $('select[name=apStatusUnique]').attr('required', false);
    } else if (count == 1) {
      $('.one').css('display', 'flex');
      $('input[name=apNameperiodOne]').attr('disabled', false);
      $('input[name=apNameperiodOne]').attr('required', true);
      $('input[name=apDateInitialOne]').attr('disabled', false);
      $('input[name=apDateInitialOne]').attr('required', true);
      $('input[name=apDateFinalOne]').attr('disabled', false);
      $('input[name=apDateFinalOne]').attr('required', true);
      $('select[name=apStatusOne]').attr('disabled', false);
      $('select[name=apStatusOne]').attr('required', true);

      $('.two').css('display', 'none');
      $('input[name=apNameperiodTwo_one]').attr('disabled', true);
      $('input[name=apNameperiodTwo_one]').attr('required', false);
      $('input[name=apDateInitialTwo_one]').attr('disabled', true);
      $('input[name=apDateInitialTwo_one]').attr('required', false);
      $('input[name=apDateFinalTwo_one]').attr('disabled', true);
      $('input[name=apDateFinalTwo_one]').attr('required', false);
      $('select[name=apStatusTwo_one]').attr('disabled', true);
      $('select[name=apStatusTwo_one]').attr('required', false);
      $('input[name=apNameperiodTwo_two]').attr('disabled', true);
      $('input[name=apNameperiodTwo_two]').attr('required', false);
      $('input[name=apDateInitialTwo_two]').attr('disabled', true);
      $('input[name=apDateInitialTwo_two]').attr('required', false);
      $('input[name=apDateFinalTwo_two]').attr('disabled', true);
      $('input[name=apDateFinalTwo_two]').attr('required', false);
      $('select[name=apStatusTwo_two]').attr('disabled', true);
      $('select[name=apStatusTwo_two]').attr('required', false);

      $('.three').css('display', 'none');
      $('input[name=apNameperiodThree_one]').attr('disabled', true);
      $('input[name=apNameperiodThree_one]').attr('required', false);
      $('input[name=apDateInitialThree_one]').attr('disabled', true);
      $('input[name=apDateInitialThree_one]').attr('required', false);
      $('input[name=apDateFinalThree_one]').attr('disabled', true);
      $('input[name=apDateFinalThree_one]').attr('required', false);
      $('select[name=apStatusThree_one]').attr('disabled', true);
      $('select[name=apStatusThree_one]').attr('required', false);
      $('input[name=apNameperiodThree_two]').attr('disabled', true);
      $('input[name=apNameperiodThree_two]').attr('required', false);
      $('input[name=apDateInitialThree_two]').attr('disabled', true);
      $('input[name=apDateInitialThree_two]').attr('required', false);
      $('input[name=apDateFinalThree_two]').attr('disabled', true);
      $('input[name=apDateFinalThree_two]').attr('required', false);
      $('select[name=apStatusThree_two]').attr('disabled', true);
      $('select[name=apStatusThree_two]').attr('required', false);
      $('input[name=apNameperiodThree_three]').attr('disabled', true);
      $('input[name=apNameperiodThree_three]').attr('required', false);
      $('input[name=apDateInitialThree_three]').attr('disabled', true);
      $('input[name=apDateInitialThree_three]').attr('required', false);
      $('input[name=apDateFinalThree_three]').attr('disabled', true);
      $('input[name=apDateFinalThree_three]').attr('required', false);
      $('select[name=apStatusThree_three]').attr('disabled', true);
      $('select[name=apStatusThree_three]').attr('required', false);

      $('.four').css('display', 'none');
      $('input[name=apNameperiodFour_one]').attr('disabled', true);
      $('input[name=apNameperiodFour_one]').attr('required', false);
      $('input[name=apDateInitialFour_one]').attr('disabled', true);
      $('input[name=apDateInitialFour_one]').attr('required', false);
      $('input[name=apDateFinalFour_one]').attr('disabled', true);
      $('input[name=apDateFinalFour_one]').attr('required', false);
      $('select[name=apStatusFour_one]').attr('disabled', true);
      $('select[name=apStatusFour_one]').attr('required', false);
      $('input[name=apNameperiodFour_two]').attr('disabled', true);
      $('input[name=apNameperiodFour_two]').attr('required', false);
      $('input[name=apDateInitialFour_two]').attr('disabled', true);
      $('input[name=apDateInitialFour_two]').attr('required', false);
      $('input[name=apDateFinalFour_two]').attr('disabled', true);
      $('input[name=apDateFinalFour_two]').attr('required', false);
      $('select[name=apStatusFour_two]').attr('disabled', true);
      $('select[name=apStatusFour_two]').attr('required', false);
      $('input[name=apNameperiodFour_three]').attr('disabled', true);
      $('input[name=apNameperiodFour_three]').attr('required', false);
      $('input[name=apDateInitialFour_three]').attr('disabled', true);
      $('input[name=apDateInitialFour_three]').attr('required', false);
      $('input[name=apDateFinalFour_three]').attr('disabled', true);
      $('input[name=apDateFinalFour_three]').attr('required', false);
      $('select[name=apStatusFour_three]').attr('disabled', true);
      $('select[name=apStatusFour_three]').attr('required', false);
      $('input[name=apNameperiodFour_four]').attr('disabled', true);
      $('input[name=apNameperiodFour_four]').attr('required', false);
      $('input[name=apDateInitialFour_four]').attr('disabled', true);
      $('input[name=apDateInitialFour_four]').attr('required', false);
      $('input[name=apDateFinalFour_four]').attr('disabled', true);
      $('input[name=apDateFinalFour_four]').attr('required', false);
      $('select[name=apStatusFour_four]').attr('disabled', true);
      $('select[name=apStatusFour_four]').attr('required', false);

      $('.unique').css('display', 'none');
      $('select[name=apNamePeriodUnique]').attr('disabled', true);
      $('select[name=apNamePeriodUnique]').attr('required', false);
      $('input[name=apDateInitialUnique]').attr('disabled', true);
      $('input[name=apDateInitialUnique]').attr('required', false);
      $('input[name=apDateFinalUnique]').attr('disabled', true);
      $('input[name=apDateFinalUnique]').attr('required', false);
      $('select[name=apStatusUnique]').attr('disabled', true);
      $('select[name=apStatusUnique]').attr('required', false);
    } else if (count == 2) {
      $('.one').css('display', 'none');
      $('input[name=apNameperiodOne]').attr('disabled', true);
      $('input[name=apNameperiodOne]').attr('required', false);
      $('input[name=apDateInitialOne]').attr('disabled', true);
      $('input[name=apDateInitialOne]').attr('required', false);
      $('input[name=apDateFinalOne]').attr('disabled', true);
      $('input[name=apDateFinalOne]').attr('required', false);
      $('select[name=apStatusOne]').attr('disabled', true);
      $('select[name=apStatusOne]').attr('required', false);

      $('.two').css('display', 'flex');
      $('input[name=apNameperiodTwo_one]').attr('disabled', false);
      $('input[name=apNameperiodTwo_one]').attr('required', true);
      $('input[name=apDateInitialTwo_one]').attr('disabled', false);
      $('input[name=apDateInitialTwo_one]').attr('required', true);
      $('input[name=apDateFinalTwo_one]').attr('disabled', false);
      $('input[name=apDateFinalTwo_one]').attr('required', true);
      $('select[name=apStatusTwo_one]').attr('disabled', false);
      $('select[name=apStatusTwo_one]').attr('required', true);
      $('input[name=apNameperiodTwo_two]').attr('disabled', false);
      $('input[name=apNameperiodTwo_two]').attr('required', true);
      $('input[name=apDateInitialTwo_two]').attr('disabled', false);
      $('input[name=apDateInitialTwo_two]').attr('required', true);
      $('input[name=apDateFinalTwo_two]').attr('disabled', false);
      $('input[name=apDateFinalTwo_two]').attr('required', true);
      $('select[name=apStatusTwo_two]').attr('disabled', false);
      $('select[name=apStatusTwo_two]').attr('required', true);

      $('.three').css('display', 'none');
      $('input[name=apNameperiodThree_one]').attr('disabled', true);
      $('input[name=apNameperiodThree_one]').attr('required', false);
      $('input[name=apDateInitialThree_one]').attr('disabled', true);
      $('input[name=apDateInitialThree_one]').attr('required', false);
      $('input[name=apDateFinalThree_one]').attr('disabled', true);
      $('input[name=apDateFinalThree_one]').attr('required', false);
      $('select[name=apStatusThree_one]').attr('disabled', true);
      $('select[name=apStatusThree_one]').attr('required', false);
      $('input[name=apNameperiodThree_two]').attr('disabled', true);
      $('input[name=apNameperiodThree_two]').attr('required', false);
      $('input[name=apDateInitialThree_two]').attr('disabled', true);
      $('input[name=apDateInitialThree_two]').attr('required', false);
      $('input[name=apDateFinalThree_two]').attr('disabled', true);
      $('input[name=apDateFinalThree_two]').attr('required', false);
      $('select[name=apStatusThree_two]').attr('disabled', true);
      $('select[name=apStatusThree_two]').attr('required', false);
      $('input[name=apNameperiodThree_three]').attr('disabled', true);
      $('input[name=apNameperiodThree_three]').attr('required', false);
      $('input[name=apDateInitialThree_three]').attr('disabled', true);
      $('input[name=apDateInitialThree_three]').attr('required', false);
      $('input[name=apDateFinalThree_three]').attr('disabled', true);
      $('input[name=apDateFinalThree_three]').attr('required', false);
      $('select[name=apStatusThree_three]').attr('disabled', true);
      $('select[name=apStatusThree_three]').attr('required', false);

      $('.four').css('display', 'none');
      $('input[name=apNameperiodFour_one]').attr('disabled', true);
      $('input[name=apNameperiodFour_one]').attr('required', false);
      $('input[name=apDateInitialFour_one]').attr('disabled', true);
      $('input[name=apDateInitialFour_one]').attr('required', false);
      $('input[name=apDateFinalFour_one]').attr('disabled', true);
      $('input[name=apDateFinalFour_one]').attr('required', false);
      $('select[name=apStatusFour_one]').attr('disabled', true);
      $('select[name=apStatusFour_one]').attr('required', false);
      $('input[name=apNameperiodFour_two]').attr('disabled', true);
      $('input[name=apNameperiodFour_two]').attr('required', false);
      $('input[name=apDateInitialFour_two]').attr('disabled', true);
      $('input[name=apDateInitialFour_two]').attr('required', false);
      $('input[name=apDateFinalFour_two]').attr('disabled', true);
      $('input[name=apDateFinalFour_two]').attr('required', false);
      $('select[name=apStatusFour_two]').attr('disabled', true);
      $('select[name=apStatusFour_two]').attr('required', false);
      $('input[name=apNameperiodFour_three]').attr('disabled', true);
      $('input[name=apNameperiodFour_three]').attr('required', false);
      $('input[name=apDateInitialFour_three]').attr('disabled', true);
      $('input[name=apDateInitialFour_three]').attr('required', false);
      $('input[name=apDateFinalFour_three]').attr('disabled', true);
      $('input[name=apDateFinalFour_three]').attr('required', false);
      $('select[name=apStatusFour_three]').attr('disabled', true);
      $('select[name=apStatusFour_three]').attr('required', false);
      $('input[name=apNameperiodFour_four]').attr('disabled', true);
      $('input[name=apNameperiodFour_four]').attr('required', false);
      $('input[name=apDateInitialFour_four]').attr('disabled', true);
      $('input[name=apDateInitialFour_four]').attr('required', false);
      $('input[name=apDateFinalFour_four]').attr('disabled', true);
      $('input[name=apDateFinalFour_four]').attr('required', false);
      $('select[name=apStatusFour_four]').attr('disabled', true);
      $('select[name=apStatusFour_four]').attr('required', false);

      $('.unique').css('display', 'none');
      $('select[name=apNamePeriodUnique]').attr('disabled', true);
      $('select[name=apNamePeriodUnique]').attr('required', false);
      $('input[name=apDateInitialUnique]').attr('disabled', true);
      $('input[name=apDateInitialUnique]').attr('required', false);
      $('input[name=apDateFinalUnique]').attr('disabled', true);
      $('input[name=apDateFinalUnique]').attr('required', false);
      $('select[name=apStatusUnique]').attr('disabled', true);
      $('select[name=apStatusUnique]').attr('required', false);
    } else if (count == 3) {
      $('.one').css('display', 'none');
      $('input[name=apNameperiodOne]').attr('disabled', true);
      $('input[name=apNameperiodOne]').attr('required', false);
      $('input[name=apDateInitialOne]').attr('disabled', true);
      $('input[name=apDateInitialOne]').attr('required', false);
      $('input[name=apDateFinalOne]').attr('disabled', true);
      $('input[name=apDateFinalOne]').attr('required', false);
      $('select[name=apStatusOne]').attr('disabled', true);
      $('select[name=apStatusOne]').attr('required', false);

      $('.two').css('display', 'none');
      $('input[name=apNameperiodTwo_one]').attr('disabled', true);
      $('input[name=apNameperiodTwo_one]').attr('required', false);
      $('input[name=apDateInitialTwo_one]').attr('disabled', true);
      $('input[name=apDateInitialTwo_one]').attr('required', false);
      $('input[name=apDateFinalTwo_one]').attr('disabled', true);
      $('input[name=apDateFinalTwo_one]').attr('required', false);
      $('select[name=apStatusTwo_one]').attr('disabled', true);
      $('select[name=apStatusTwo_one]').attr('required', false);
      $('input[name=apNameperiodTwo_two]').attr('disabled', true);
      $('input[name=apNameperiodTwo_two]').attr('required', false);
      $('input[name=apDateInitialTwo_two]').attr('disabled', true);
      $('input[name=apDateInitialTwo_two]').attr('required', false);
      $('input[name=apDateFinalTwo_two]').attr('disabled', true);
      $('input[name=apDateFinalTwo_two]').attr('required', false);
      $('select[name=apStatusTwo_two]').attr('disabled', true);
      $('select[name=apStatusTwo_two]').attr('required', false);

      $('.three').css('display', 'flex');
      $('input[name=apNameperiodThree_one]').attr('disabled', false);
      $('input[name=apNameperiodThree_one]').attr('required', true);
      $('input[name=apDateInitialThree_one]').attr('disabled', false);
      $('input[name=apDateInitialThree_one]').attr('required', true);
      $('input[name=apDateFinalThree_one]').attr('disabled', false);
      $('input[name=apDateFinalThree_one]').attr('required', true);
      $('select[name=apStatusThree_one]').attr('disabled', false);
      $('select[name=apStatusThree_one]').attr('required', true);
      $('input[name=apNameperiodThree_two]').attr('disabled', false);
      $('input[name=apNameperiodThree_two]').attr('required', true);
      $('input[name=apDateInitialThree_two]').attr('disabled', false);
      $('input[name=apDateInitialThree_two]').attr('required', true);
      $('input[name=apDateFinalThree_two]').attr('disabled', false);
      $('input[name=apDateFinalThree_two]').attr('required', true);
      $('select[name=apStatusThree_two]').attr('disabled', false);
      $('select[name=apStatusThree_two]').attr('required', true);
      $('input[name=apNameperiodThree_three]').attr('disabled', false);
      $('input[name=apNameperiodThree_three]').attr('required', true);
      $('input[name=apDateInitialThree_three]').attr('disabled', false);
      $('input[name=apDateInitialThree_three]').attr('required', true);
      $('input[name=apDateFinalThree_three]').attr('disabled', false);
      $('input[name=apDateFinalThree_three]').attr('required', true);
      $('select[name=apStatusThree_three]').attr('disabled', false);
      $('select[name=apStatusThree_three]').attr('required', true);

      $('.four').css('display', 'none');
      $('input[name=apNameperiodFour_one]').attr('disabled', true);
      $('input[name=apNameperiodFour_one]').attr('required', false);
      $('input[name=apDateInitialFour_one]').attr('disabled', true);
      $('input[name=apDateInitialFour_one]').attr('required', false);
      $('input[name=apDateFinalFour_one]').attr('disabled', true);
      $('input[name=apDateFinalFour_one]').attr('required', false);
      $('select[name=apStatusFour_one]').attr('disabled', true);
      $('select[name=apStatusFour_one]').attr('required', false);
      $('input[name=apNameperiodFour_two]').attr('disabled', true);
      $('input[name=apNameperiodFour_two]').attr('required', false);
      $('input[name=apDateInitialFour_two]').attr('disabled', true);
      $('input[name=apDateInitialFour_two]').attr('required', false);
      $('input[name=apDateFinalFour_two]').attr('disabled', true);
      $('input[name=apDateFinalFour_two]').attr('required', false);
      $('select[name=apStatusFour_two]').attr('disabled', true);
      $('select[name=apStatusFour_two]').attr('required', false);
      $('input[name=apNameperiodFour_three]').attr('disabled', true);
      $('input[name=apNameperiodFour_three]').attr('required', false);
      $('input[name=apDateInitialFour_three]').attr('disabled', true);
      $('input[name=apDateInitialFour_three]').attr('required', false);
      $('input[name=apDateFinalFour_three]').attr('disabled', true);
      $('input[name=apDateFinalFour_three]').attr('required', false);
      $('select[name=apStatusFour_three]').attr('disabled', true);
      $('select[name=apStatusFour_three]').attr('required', false);
      $('input[name=apNameperiodFour_four]').attr('disabled', true);
      $('input[name=apNameperiodFour_four]').attr('required', false);
      $('input[name=apDateInitialFour_four]').attr('disabled', true);
      $('input[name=apDateInitialFour_four]').attr('required', false);
      $('input[name=apDateFinalFour_four]').attr('disabled', true);
      $('input[name=apDateFinalFour_four]').attr('required', false);
      $('select[name=apStatusFour_four]').attr('disabled', true);
      $('select[name=apStatusFour_four]').attr('required', false);

      $('.unique').css('display', 'none');
      $('select[name=apNamePeriodUnique]').attr('disabled', true);
      $('select[name=apNamePeriodUnique]').attr('required', false);
      $('input[name=apDateInitialUnique]').attr('disabled', true);
      $('input[name=apDateInitialUnique]').attr('required', false);
      $('input[name=apDateFinalUnique]').attr('disabled', true);
      $('input[name=apDateFinalUnique]').attr('required', false);
      $('select[name=apStatusUnique]').attr('disabled', true);
      $('select[name=apStatusUnique]').attr('required', false);
    } else if (count == 4) {
      $('.one').css('display', 'none');
      $('input[name=apNameperiodOne]').attr('disabled', true);
      $('input[name=apNameperiodOne]').attr('required', false);
      $('input[name=apDateInitialOne]').attr('disabled', true);
      $('input[name=apDateInitialOne]').attr('required', false);
      $('input[name=apDateFinalOne]').attr('disabled', true);
      $('input[name=apDateFinalOne]').attr('required', false);
      $('select[name=apStatusOne]').attr('disabled', true);
      $('select[name=apStatusOne]').attr('required', false);

      $('.two').css('display', 'none');
      $('input[name=apNameperiodTwo_one]').attr('disabled', true);
      $('input[name=apNameperiodTwo_one]').attr('required', false);
      $('input[name=apDateInitialTwo_one]').attr('disabled', true);
      $('input[name=apDateInitialTwo_one]').attr('required', false);
      $('input[name=apDateFinalTwo_one]').attr('disabled', true);
      $('input[name=apDateFinalTwo_one]').attr('required', false);
      $('select[name=apStatusTwo_one]').attr('disabled', true);
      $('select[name=apStatusTwo_one]').attr('required', false);
      $('input[name=apNameperiodTwo_two]').attr('disabled', true);
      $('input[name=apNameperiodTwo_two]').attr('required', false);
      $('input[name=apDateInitialTwo_two]').attr('disabled', true);
      $('input[name=apDateInitialTwo_two]').attr('required', false);
      $('input[name=apDateFinalTwo_two]').attr('disabled', true);
      $('input[name=apDateFinalTwo_two]').attr('required', false);
      $('select[name=apStatusTwo_two]').attr('disabled', true);
      $('select[name=apStatusTwo_two]').attr('required', false);

      $('.three').css('display', 'none');
      $('input[name=apNameperiodThree_one]').attr('disabled', true);
      $('input[name=apNameperiodThree_one]').attr('required', false);
      $('input[name=apDateInitialThree_one]').attr('disabled', true);
      $('input[name=apDateInitialThree_one]').attr('required', false);
      $('input[name=apDateFinalThree_one]').attr('disabled', true);
      $('input[name=apDateFinalThree_one]').attr('required', false);
      $('select[name=apStatusThree_one]').attr('disabled', true);
      $('select[name=apStatusThree_one]').attr('required', false);
      $('input[name=apNameperiodThree_two]').attr('disabled', true);
      $('input[name=apNameperiodThree_two]').attr('required', false);
      $('input[name=apDateInitialThree_two]').attr('disabled', true);
      $('input[name=apDateInitialThree_two]').attr('required', false);
      $('input[name=apDateFinalThree_two]').attr('disabled', true);
      $('input[name=apDateFinalThree_two]').attr('required', false);
      $('select[name=apStatusThree_two]').attr('disabled', true);
      $('select[name=apStatusThree_two]').attr('required', false);
      $('input[name=apNameperiodThree_three]').attr('disabled', true);
      $('input[name=apNameperiodThree_three]').attr('required', false);
      $('input[name=apDateInitialThree_three]').attr('disabled', true);
      $('input[name=apDateInitialThree_three]').attr('required', false);
      $('input[name=apDateFinalThree_three]').attr('disabled', true);
      $('input[name=apDateFinalThree_three]').attr('required', false);
      $('select[name=apStatusThree_three]').attr('disabled', true);
      $('select[name=apStatusThree_three]').attr('required', false);

      $('.four').css('display', 'flex');
      $('input[name=apNameperiodFour_one]').attr('disabled', false);
      $('input[name=apNameperiodFour_one]').attr('required', true);
      $('input[name=apDateInitialFour_one]').attr('disabled', false);
      $('input[name=apDateInitialFour_one]').attr('required', true);
      $('input[name=apDateFinalFour_one]').attr('disabled', false);
      $('input[name=apDateFinalFour_one]').attr('required', true);
      $('select[name=apStatusFour_one]').attr('disabled', false);
      $('select[name=apStatusFour_one]').attr('required', true);
      $('input[name=apNameperiodFour_two]').attr('disabled', false);
      $('input[name=apNameperiodFour_two]').attr('required', true);
      $('input[name=apDateInitialFour_two]').attr('disabled', false);
      $('input[name=apDateInitialFour_two]').attr('required', true);
      $('input[name=apDateFinalFour_two]').attr('disabled', false);
      $('input[name=apDateFinalFour_two]').attr('required', true);
      $('select[name=apStatusFour_two]').attr('disabled', false);
      $('select[name=apStatusFour_two]').attr('required', true);
      $('input[name=apNameperiodFour_three]').attr('disabled', false);
      $('input[name=apNameperiodFour_three]').attr('required', true);
      $('input[name=apDateInitialFour_three]').attr('disabled', false);
      $('input[name=apDateInitialFour_three]').attr('required', true);
      $('input[name=apDateFinalFour_three]').attr('disabled', false);
      $('input[name=apDateFinalFour_three]').attr('required', true);
      $('select[name=apStatusFour_three]').attr('disabled', false);
      $('select[name=apStatusFour_three]').attr('required', true);
      $('input[name=apNameperiodFour_four]').attr('disabled', false);
      $('input[name=apNameperiodFour_four]').attr('required', true);
      $('input[name=apDateInitialFour_four]').attr('disabled', false);
      $('input[name=apDateInitialFour_four]').attr('required', true);
      $('input[name=apDateFinalFour_four]').attr('disabled', false);
      $('input[name=apDateFinalFour_four]').attr('required', true);
      $('select[name=apStatusFour_four]').attr('disabled', false);
      $('select[name=apStatusFour_four]').attr('required', true);

      $('.unique').css('display', 'none');
      $('select[name=apNamePeriodUnique]').attr('disabled', true);
      $('select[name=apNamePeriodUnique]').attr('required', false);
      $('input[name=apDateInitialUnique]').attr('disabled', true);
      $('input[name=apDateInitialUnique]').attr('required', false);
      $('input[name=apDateFinalUnique]').attr('disabled', true);
      $('input[name=apDateFinalUnique]').attr('required', false);
      $('select[name=apStatusUnique]').attr('disabled', true);
      $('select[name=apStatusUnique]').attr('required', false);
    }
  });

  $('select[name=apCourse]').on('change', function(e) {
    var courseSelected = e.target.value;
    $.get("{{ route('getInfoCourseConsolidated') }}", {
      courseSelected: courseSelected
    }, function(objectInfo) {
      if (objectInfo != null && objectInfo != '') {
        $('input[name=apGrade]').val('');
        $('input[name=apGrade]').val(objectInfo['nameGrade']);
        $('input[name=apCollaborator]').val('');
        $('input[name=apCollaborator]').val(objectInfo['nameCollaborator']);
        $('input[name=apStatus]').val('');
        $('input[name=apStatus]').val(objectInfo['ccStatus']);
      }
    });
  });

  function disabledAll() {
    $('.one').css('display', 'none');
    $('input[name=apNameperiodOne]').attr('disabled', true);
    $('input[name=apNameperiodOne]').attr('required', false);
    $('input[name=apDateInitialOne]').attr('disabled', true);
    $('input[name=apDateInitialOne]').attr('required', false);
    $('input[name=apDateFinalOne]').attr('disabled', true);
    $('input[name=apDateFinalOne]').attr('required', false);
    $('select[name=apStatusOne]').attr('disabled', true);
    $('select[name=apStatusOne]').attr('required', false);

    $('.two').css('display', 'none');
    $('input[name=apNameperiodTwo_one]').attr('disabled', true);
    $('input[name=apNameperiodTwo_one]').attr('required', false);
    $('input[name=apDateInitialTwo_one]').attr('disabled', true);
    $('input[name=apDateInitialTwo_one]').attr('required', false);
    $('input[name=apDateFinalTwo_one]').attr('disabled', true);
    $('input[name=apDateFinalTwo_one]').attr('required', false);
    $('select[name=apStatusTwo_one]').attr('disabled', true);
    $('select[name=apStatusTwo_one]').attr('required', false);
    $('input[name=apNameperiodTwo_two]').attr('disabled', true);
    $('input[name=apNameperiodTwo_two]').attr('required', false);
    $('input[name=apDateInitialTwo_two]').attr('disabled', true);
    $('input[name=apDateInitialTwo_two]').attr('required', false);
    $('input[name=apDateFinalTwo_two]').attr('disabled', true);
    $('input[name=apDateFinalTwo_two]').attr('required', false);
    $('select[name=apStatusTwo_two]').attr('disabled', true);
    $('select[name=apStatusTwo_two]').attr('required', false);

    $('.three').css('display', 'none');
    $('input[name=apNameperiodThree_one]').attr('disabled', true);
    $('input[name=apNameperiodThree_one]').attr('required', false);
    $('input[name=apDateInitialThree_one]').attr('disabled', true);
    $('input[name=apDateInitialThree_one]').attr('required', false);
    $('input[name=apDateFinalThree_one]').attr('disabled', true);
    $('input[name=apDateFinalThree_one]').attr('required', false);
    $('select[name=apStatusThree_one]').attr('disabled', true);
    $('select[name=apStatusThree_one]').attr('required', false);
    $('input[name=apNameperiodThree_two]').attr('disabled', true);
    $('input[name=apNameperiodThree_two]').attr('required', false);
    $('input[name=apDateInitialThree_two]').attr('disabled', true);
    $('input[name=apDateInitialThree_two]').attr('required', false);
    $('input[name=apDateFinalThree_two]').attr('disabled', true);
    $('input[name=apDateFinalThree_two]').attr('required', false);
    $('select[name=apStatusThree_two]').attr('disabled', true);
    $('select[name=apStatusThree_two]').attr('required', false);
    $('input[name=apNameperiodThree_three]').attr('disabled', true);
    $('input[name=apNameperiodThree_three]').attr('required', false);
    $('input[name=apDateInitialThree_three]').attr('disabled', true);
    $('input[name=apDateInitialThree_three]').attr('required', false);
    $('input[name=apDateFinalThree_three]').attr('disabled', true);
    $('input[name=apDateFinalThree_three]').attr('required', false);
    $('select[name=apStatusThree_three]').attr('disabled', true);
    $('select[name=apStatusThree_three]').attr('required', false);

    $('.four').css('display', 'none');
    $('input[name=apNameperiodFour_one]').attr('disabled', true);
    $('input[name=apNameperiodFour_one]').attr('required', false);
    $('input[name=apDateInitialFour_one]').attr('disabled', true);
    $('input[name=apDateInitialFour_one]').attr('required', false);
    $('input[name=apDateFinalFour_one]').attr('disabled', true);
    $('input[name=apDateFinalFour_one]').attr('required', false);
    $('select[name=apStatusFour_one]').attr('disabled', true);
    $('select[name=apStatusFour_one]').attr('required', false);
    $('input[name=apNameperiodFour_two]').attr('disabled', true);
    $('input[name=apNameperiodFour_two]').attr('required', false);
    $('input[name=apDateInitialFour_two]').attr('disabled', true);
    $('input[name=apDateInitialFour_two]').attr('required', false);
    $('input[name=apDateFinalFour_two]').attr('disabled', true);
    $('input[name=apDateFinalFour_two]').attr('required', false);
    $('select[name=apStatusFour_two]').attr('disabled', true);
    $('select[name=apStatusFour_two]').attr('required', false);
    $('input[name=apNameperiodFour_three]').attr('disabled', true);
    $('input[name=apNameperiodFour_three]').attr('required', false);
    $('input[name=apDateInitialFour_three]').attr('disabled', true);
    $('input[name=apDateInitialFour_three]').attr('required', false);
    $('input[name=apDateFinalFour_three]').attr('disabled', true);
    $('input[name=apDateFinalFour_three]').attr('required', false);
    $('select[name=apStatusFour_three]').attr('disabled', true);
    $('select[name=apStatusFour_three]').attr('required', false);
    $('input[name=apNameperiodFour_four]').attr('disabled', true);
    $('input[name=apNameperiodFour_four]').attr('required', false);
    $('input[name=apDateInitialFour_four]').attr('disabled', true);
    $('input[name=apDateInitialFour_four]').attr('required', false);
    $('input[name=apDateFinalFour_four]').attr('disabled', true);
    $('input[name=apDateFinalFour_four]').attr('required', false);
    $('select[name=apStatusFour_four]').attr('disabled', true);
    $('select[name=apStatusFour_four]').attr('required', false);

    $('.unique').css('display', 'flex');
    $('select[name=apNamePeriodUnique]').attr('disabled', false);
    $('select[name=apNamePeriodUnique]').attr('required', true);
    $('input[name=apDateInitialUnique]').attr('disabled', false);
    $('input[name=apDateInitialUnique]').attr('required', true);
    $('input[name=apDateFinalUnique]').attr('disabled', false);
    $('input[name=apDateFinalUnique]').attr('required', true);
    $('select[name=apStatusUnique]').attr('disabled', false);
    $('select[name=apStatusUnique]').attr('required', true);
  }

  function disabledUnique() {
    $('.one').css('display', 'none');
    $('input[name=apNameperiodOne]').attr('disabled', true);
    $('input[name=apNameperiodOne]').attr('required', false);
    $('input[name=apDateInitialOne]').attr('disabled', true);
    $('input[name=apDateInitialOne]').attr('required', false);
    $('input[name=apDateFinalOne]').attr('disabled', true);
    $('input[name=apDateFinalOne]').attr('required', false);
    $('select[name=apStatusOne]').attr('disabled', true);
    $('select[name=apStatusOne]').attr('required', false);

    $('.two').css('display', 'none');
    $('input[name=apNameperiodTwo_one]').attr('disabled', true);
    $('input[name=apNameperiodTwo_one]').attr('required', false);
    $('input[name=apDateInitialTwo_one]').attr('disabled', true);
    $('input[name=apDateInitialTwo_one]').attr('required', false);
    $('input[name=apDateFinalTwo_one]').attr('disabled', true);
    $('input[name=apDateFinalTwo_one]').attr('required', false);
    $('select[name=apStatusTwo_one]').attr('disabled', true);
    $('select[name=apStatusTwo_one]').attr('required', false);
    $('input[name=apNameperiodTwo_two]').attr('disabled', true);
    $('input[name=apNameperiodTwo_two]').attr('required', false);
    $('input[name=apDateInitialTwo_two]').attr('disabled', true);
    $('input[name=apDateInitialTwo_two]').attr('required', false);
    $('input[name=apDateFinalTwo_two]').attr('disabled', true);
    $('input[name=apDateFinalTwo_two]').attr('required', false);
    $('select[name=apStatusTwo_two]').attr('disabled', true);
    $('select[name=apStatusTwo_two]').attr('required', false);

    $('.three').css('display', 'none');
    $('input[name=apNameperiodThree_one]').attr('disabled', true);
    $('input[name=apNameperiodThree_one]').attr('required', false);
    $('input[name=apDateInitialThree_one]').attr('disabled', true);
    $('input[name=apDateInitialThree_one]').attr('required', false);
    $('input[name=apDateFinalThree_one]').attr('disabled', true);
    $('input[name=apDateFinalThree_one]').attr('required', false);
    $('select[name=apStatusThree_one]').attr('disabled', true);
    $('select[name=apStatusThree_one]').attr('required', false);
    $('input[name=apNameperiodThree_two]').attr('disabled', true);
    $('input[name=apNameperiodThree_two]').attr('required', false);
    $('input[name=apDateInitialThree_two]').attr('disabled', true);
    $('input[name=apDateInitialThree_two]').attr('required', false);
    $('input[name=apDateFinalThree_two]').attr('disabled', true);
    $('input[name=apDateFinalThree_two]').attr('required', false);
    $('select[name=apStatusThree_two]').attr('disabled', true);
    $('select[name=apStatusThree_two]').attr('required', false);
    $('input[name=apNameperiodThree_three]').attr('disabled', true);
    $('input[name=apNameperiodThree_three]').attr('required', false);
    $('input[name=apDateInitialThree_three]').attr('disabled', true);
    $('input[name=apDateInitialThree_three]').attr('required', false);
    $('input[name=apDateFinalThree_three]').attr('disabled', true);
    $('input[name=apDateFinalThree_three]').attr('required', false);
    $('select[name=apStatusThree_three]').attr('disabled', true);
    $('select[name=apStatusThree_three]').attr('required', false);

    $('.four').css('display', 'none');
    $('input[name=apNameperiodFour_one]').attr('disabled', true);
    $('input[name=apNameperiodFour_one]').attr('required', false);
    $('input[name=apDateInitialFour_one]').attr('disabled', true);
    $('input[name=apDateInitialFour_one]').attr('required', false);
    $('input[name=apDateFinalFour_one]').attr('disabled', true);
    $('input[name=apDateFinalFour_one]').attr('required', false);
    $('select[name=apStatusFour_one]').attr('disabled', true);
    $('select[name=apStatusFour_one]').attr('required', false);
    $('input[name=apNameperiodFour_two]').attr('disabled', true);
    $('input[name=apNameperiodFour_two]').attr('required', false);
    $('input[name=apDateInitialFour_two]').attr('disabled', true);
    $('input[name=apDateInitialFour_two]').attr('required', false);
    $('input[name=apDateFinalFour_two]').attr('disabled', true);
    $('input[name=apDateFinalFour_two]').attr('required', false);
    $('select[name=apStatusFour_two]').attr('disabled', true);
    $('select[name=apStatusFour_two]').attr('required', false);
    $('input[name=apNameperiodFour_three]').attr('disabled', true);
    $('input[name=apNameperiodFour_three]').attr('required', false);
    $('input[name=apDateInitialFour_three]').attr('disabled', true);
    $('input[name=apDateInitialFour_three]').attr('required', false);
    $('input[name=apDateFinalFour_three]').attr('disabled', true);
    $('input[name=apDateFinalFour_three]').attr('required', false);
    $('select[name=apStatusFour_three]').attr('disabled', true);
    $('select[name=apStatusFour_three]').attr('required', false);
    $('input[name=apNameperiodFour_four]').attr('disabled', true);
    $('input[name=apNameperiodFour_four]').attr('required', false);
    $('input[name=apDateInitialFour_four]').attr('disabled', true);
    $('input[name=apDateInitialFour_four]').attr('required', false);
    $('input[name=apDateFinalFour_four]').attr('disabled', true);
    $('input[name=apDateFinalFour_four]').attr('required', false);
    $('select[name=apStatusFour_four]').attr('disabled', true);
    $('select[name=apStatusFour_four]').attr('required', false);

    $('.unique').css('display', 'none');
    $('select[name=apNamePeriodUnique]').attr('disabled', true);
    $('select[name=apNamePeriodUnique]').attr('required', false);
    $('input[name=apDateInitialUnique]').attr('disabled', true);
    $('input[name=apDateInitialUnique]').attr('required', false);
    $('input[name=apDateFinalUnique]').attr('disabled', true);
    $('input[name=apDateFinalUnique]').attr('required', false);
    $('select[name=apStatusUnique]').attr('disabled', true);
    $('select[name=apStatusUnique]').attr('required', false);
  }
</script>
@endsection