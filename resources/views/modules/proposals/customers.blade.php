@extends('modules.proposal')

@section('proposalComercial')
	<div class="col-md-12">
		<div class="row text-center my-2">
			<div class="col-md-6">
				<h3>TABLA GENERAL DE CLIENTES</h3>
			</div>
			<div class="col-md-6">
				<!-- Mensajes de actualizacion de cotizaciones -->
				@if(session('PrimaryUpdateCustomer'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateCustomer') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateCustomer'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateCustomer') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de cotizaciones -->
				@if(session('WarningDeleteCustomer'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteCustomer') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteCustomer'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteCustomer') }}
				    </div>
				@endif
			</div>
		</div>
		<table id="tablecustomers" class="table table-responsive" width="100%">
			<thead>
				<tr>
					<th>NOMBRES</th>
					<th>TELEFONO</th>
					<th>CORREO</th>
					<th>ASPIRANTE</th>
					<th>EDAD</th>
					<th>OBSERVACION</th>
				</tr>
			</thead>
			<tbody>
				@foreach($customers as $customer)
					<tr>
						<td>{{ $customer->cusFirstname }} {{ $customer->cusLastname }}</td>
						<td>{{ $customer->cusPhone }}</td>
						<td>{{ $customer->cusMail }}</td>
						<td>{{ $customer->cusChild }}</td>
						<td>{{ $customer->cusChildYearsold }}</td>
						<td>{{ $customer->cusNotes }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection


@section('scripts')
	<script>
		$(function(){

		});
	</script>
@endsection

		