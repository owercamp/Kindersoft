@extends('modules.analysis')

@section('financialModules')
	<div class="col-md-12">
		<div class="row mt-5">
			<div class="col-md-12">
				<h4>INFORME DE CIERRE</h4>
				@php
					$yearnow = date('Y');
					$mountnow = date('m');
					$yearbeforeThree = date('Y') - 3;
					$yearbeforeTwo = date('Y') - 2;
					$yearbeforeOne = date('Y') - 1;
					$yearfutureOne = date('Y') + 1;
					$yearfutureTwo = date('Y') + 2;
					$yearfutureThree = date('Y') + 3;
					$yearfutureFour = date('Y') + 4;
				@endphp
			</div>
		</div>
		<div class="row border">
			<form action="{{ route('analysis.reportclose.excel') }}" method="GET" class="col-md-12">
				@csrf
				<div class="row p-2">
					<div class="col-md-6">
						<div class="form-group">
							<small class="text-muted">SELECCIONE EL AÑO DEL INFORME:</small>
							<select name="rYear" class="form-control form-control-sm" required>
								<option value="">Seleccione...</option>
								<option value="{{ $yearbeforeThree }}">{{ $yearbeforeThree }}</option>
								<option value="{{ $yearbeforeTwo }}">{{ $yearbeforeTwo }}</option>
								<option value="{{ $yearbeforeOne }}">{{ $yearbeforeOne }}</option>
								<option value="{{ $yearnow }}">{{ $yearnow }}</option>
								<option value="{{ $yearfutureOne }}">{{ $yearfutureOne }}</option>
								<option value="{{ $yearfutureTwo }}">{{ $yearfutureTwo }}</option>
								<option value="{{ $yearfutureThree }}">{{ $yearfutureThree }}</option>
								<option value="{{ $yearfutureFour }}">{{ $yearfutureFour }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<button type="submit" class="bj-btn-table-add form-control-sm mt-4 btn-report">GENERAR EXCEL</button>
					</div>
				</div>		
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){

		});
	</script>
@endsection