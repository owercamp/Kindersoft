@extends('modules.academic')

@section('academics')

	<div class="col-md-12 bj-scroll">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<!-- Mensajes de actualizacion de programas consolidados -->
				@if(session('PrimaryUpdateAchievementConsolidated'))
				    <div class="alert alert-primary">
				        {{ session('PrimaryUpdateAchievementConsolidated') }}
				    </div>
				@endif
				@if(session('SecondaryUpdateAchievementConsolidated'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryUpdateAchievementConsolidated') }}
				    </div>
				@endif
				<!-- Mensajes de eliminación de programas consolidados -->
				@if(session('WarningDeleteAchievementConsolidated'))
				    <div class="alert alert-warning">
				        {{ session('WarningDeleteAchievementConsolidated') }}
				    </div>
				@endif
				@if(session('SecondaryDeleteAchievementConsolidated'))
				    <div class="alert alert-secondary">
				        {{ session('SecondaryDeleteAchievementConsolidated') }}
				    </div>
				@endif
			</div>
			<div class="col-md-6">
				<a href="{{ route('achievementsAcademics') }}" class="bj-btn-table-delete my-4 form-control-sm">REGISTRAR PROGRAMA</a>
			</div>
		</div>
		<table id="tableconsolideachievements" class="table table-responsive table-hover text-center" style="width:100%;">
			<thead>
				<tr>
					<th>GRADO</th>
					<th>PERIODO</th>
					<th>INICIO</th>
					<th>FIN</th>
					<th>CURSO</th>
					<th>LOGRO</th>
					<th>INTELIGENCIA</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				@foreach($allConsolidated as $allAchievement)
					<tr>
						<td>{{ $allAchievement->gradeName }}</td>
						<td>{{ $allAchievement->periodName }}</td>
						<td>{{ $allAchievement->initialDate }}</td>
						<td>{{ $allAchievement->finalDate }}</td>
						<td>{{ $allAchievement->courseName }}</td>
						<td>{{ $allAchievement->achievementName }}</td>
						<td>{{ $allAchievement->type }}</td>
						<td><!--<a href="{{ route('consolideAchievement.edit', $allAchievement->id) }}" title="EDITAR" class="bj-btn-table-edit"><i class="fas fa-edit"></i></a>--><a href="{{ route('consolideAchievement.delete', $allAchievement->id) }}" title="ELIMINAR" class="bj-btn-table-delete" onclick="return confirm('¿Desea eliminar el logro establecido?')"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>

@endsection