@extends('home')

@section('modules')
	<div class="container">
		<div class="row">
			<div class="card col-md-12">
				<div class="card-header">
					<div class="col-md-4 float-left text-left">
						<h5 class="text-muted">MI PERFIL</h5>
						<h4 class="text-muted">Gestión de acceso</h4>
					</div>
					<div class="col-md-4 float-left text-center">
						<!-- Mensajes de modificaciones de usuario -->
						@if(session('PrimaryUpdateUser'))
						    <div class="alert alert-success">
						        {{ session('PrimaryUpdateUser') }}
						    </div>
						@endif
						@if(session('SecondaryUpdateUser'))
						    <div class="alert alert-secondary">
						        {{ session('SecondaryUpdateUser') }}
						    </div>
						@endif
						<!-- Mensajes de creación de Jardin -->
						@if(session('SuccessSaveGarden'))
						    <div class="alert alert-success">
						        {{ session('SuccessSaveGarden') }}
						    </div>
						@endif
						@if(session('SecondarySaveGarden'))
						    <div class="alert alert-secondary">
						        {{ session('SecondarySaveGarden') }}
						    </div>
						@endif
						<!-- Mensajes de modificación de Jardin -->
						@if(session('PrimaryUpdateGarden'))
						    <div class="alert alert-success">
						        {{ session('PrimaryUpdateGarden') }}
						    </div>
						@endif
						@if(session('SecondaryUpdateGarden'))
						    <div class="alert alert-secondary">
						        {{ session('SecondaryUpdateGarden') }}
						    </div>
						@endif
					</div>
					<div class="col-md-4 float-right text-right">
						<h6>{{ $user->firstname }} {{ $user->lastname }}</h6>
						<h6>{{ $user->roles->implode('name',',') }}, Es su rol actual</h6>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 border-right py-3 px-3">
							<h4 class="text-center">MIS DATOS DE ACCESO</h4><br>
							<form action="{{ route('changePassword') }}" method="POST" class="p-3">
								@csrf
								<div class="form-group">
									<small class="text-muted">IDENTIFICACION/USUARIO:</small>
									<input type="text" name="id" class="form-control form-control-sm" value="{{ $user->id }}" required>
								</div>
								<div class="form-group">
									<small class="text-muted">NOMBRE/S:</small>
									<input type="text" name="firstname" class="form-control form-control-sm" value="{{ $user->firstname }}" required>
								</div>
								<div class="form-group">
									<small class="text-muted">APELLIDO/S:</small>
									<input type="text" name="lastname" class="form-control form-control-sm" value="{{ $user->lastname }}" required>
								</div>
								<div class="row border-bottom border-top">
									<div class="col-md-4 text-center">
										<small class="text-muted">¿CAMBIAR CONTRASEÑA?:</small>
									</div>
									<div class="col-md-4 text-center">
										<small class="text-muted">
											<input type="radio" name="changePassword" value="NO" checked>
											NO
										</small>
									</div>
									<div class="col-md-4 text-center">
										<small class="text-muted">
											<input type="radio" name="changePassword" value="SI">
											SI
										</small>
									</div>
								</div>
								<div id="inputPasswords" style="display: none;">
									<div class="form-group">
										<small class="text-muted">CONTRASEÑA ACTUAL:</small>
										<input type="password" name="nowPassword" class="form-control form-control-sm" disabled>
									</div>
									<div class="form-group">
										<small class="text-muted">NUEVA CONTRASEÑA:</small>
										<input type="password" name="newPassword" class="form-control form-control-sm" disabled>
									</div>
									<div class="form-group">
										<small class="text-muted">CONFIRMAR NUEVA CONTRASEÑA:</small>
										<input type="password" name="confirmPassword" class="form-control form-control-sm" disabled>
									</div>
								</div>
								<div class="row text-center px-4 py-4">
									<div class="col-md-12">
										<button type="submit" class="bj-btn-table-add form-control-sm">ACTUALIZAR MIS DATOS</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6 text-center">
							<h4 class="mt-3">DATOS DE JARDIN: </h4><br>
							@if($garden != null || $garden != '')
								<small class="text-muted">LOGO: </small><br>
								<img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/'.$garden->garNamelogo) }}"><br>
								@if($garden->garCode == 'defaultcode.png')
									<small class="text-muted">CODIGO QR: </small><br>
									<h6>NO HAY CODIGO QR</h6>
								@else
									<small class="text-muted">CODIGO QR: </small><br>
									<img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/'.$garden->garCode) }}"><br>
								@endif
								@php asset(storage_path() . '/' . $garden->garNamelogo) @endphp
								<small class="text-muted">RAZON SOCIAL: </small>
								<h6>{{ $garden->garReasonsocial }}</h6>
								<small class="text-muted">NOMBRE COMERCIAL: </small>
								<h6>{{ $garden->garNamecomercial }}</h6>
								<small class="text-muted">NIT: </small>
								<h6>{{ $garden->garNit }}</h6>
								<small class="text-muted">CIUDAD: </small>
								<h6>{{ $garden->nameCity }}</h6>
								<small class="text-muted">LOCALIDAD: </small>
								<h6>{{ $garden->nameLocation }}</h6>
								<small class="text-muted">BARRIO: </small>
								<h6>{{ $garden->nameDistrict }}</h6>
								<small class="text-muted">DIRECCION: </small>
								<h6>{{ $garden->garAddress }}</h6>
								<small class="text-muted">CELULAR / WHATSAPP: </small>
								<h6>{{ $garden->garPhone . ' / ' . $garden->garWhatsapp }}</h6>
								<small class="text-muted">TELEFONOS: </small>
								<h6>{{ $garden->garPhoneone . ' - ' . $garden->garPhonetwo . ' - ' . $garden->garPhonethree }}</h6>
								<small class="text-muted">WEB: </small>
								<h6>{{ $garden->garWebsite }}</h6>
								<small class="text-muted">CORREOS: </small>
								<h6>{{ $garden->garMailone . ' - ' . $garden->garMailtwo }}</h6>
								<small class="text-muted">REPRESENTANTE LEGAL: </small>
								<h6>{{ $garden->garNamerepresentative . ' C.C N° ' . $garden->garCardrepresentative }}</h6>
								<small class="text-muted">FIRMA DE REPRESENTANTE: </small><br>
								@if($garden->garFirm == null)
									<h6>SIN FIRMA DIGITAL</h6>
								@else
									<img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/firm/'.$garden->garFirm) }}"><br>
								@endif
								<small class="text-muted">TESTIGO DE CONTRATOS: </small>
								@if($garden->garNamewitness == null && $garden->garCardwitness == null)
									<h6>SIN TESTIGO</h6>
								@else
									<h6>{{ $garden->garNamewitness . ' C.C N° ' . $garden->garCardwitness }}</h6>
								@endif
								<small class="text-muted">FIRMA DE TESTIGO: </small><br>
								@if($garden->garFirmwitness == null)
									<h6>SIN FIRMA DE TESTIGO</h6>
								@else
									<img class="img img-responsive" style="width: 100px; height: auto;" src="{{ asset('storage/garden/firm/'.$garden->garFirmwitness) }}"><br>
								@endif
								@hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
									<a href="#" class="bj-btn-table-add form-control-sm m-4 updateGarden-link">
										<span hidden>{{ $garden->garLocation_id }}</span> <!-- Se guarda id de localizacion para que se seleccione el select al abrir modal de actualización -->
										<span hidden>{{ $garden->garDistrict_id }}</span> <!-- Se guarda id de barrio para que se seleccione el select al abrir modal de actualización -->
										ACTUALIZAR DATOS DEL JARDIN
									</a>
								@endhasanyrole
							@else
								@hasanyrole('ADMINISTRADOR SISTEMA|ADMINISTRADOR|ADMINISTRADOR JARDIN')
									<span class="text-muted">No existe ningun dato creado del jardin, De clic en configurar para crear los datos</span>
									<a href="#" class="bj-btn-table-add form-control-sm m-4 newGarden-link">
										CONFIGURAR DATOS DE JARDIN
									</a>
								@endhasanyrole
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="newGarden-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-12">
							<h4 class="text-muted">DATOS DE JARDIN:</h4>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-4">
					<div class="row">
						<div class="col-md-12">
							<form action="{{ route('garden.new') }}" method="POST" enctype="multipart/form-data">
			        			@csrf
			        			<div class="row">
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">RAZON SOCIAL:</small>
			        						<input type="text" name="garReasonsocial" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">NOMBRE COMERCIAL:</small>
			        						<input type="text" name="garNamecomercial" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<div class="row">
			        							<div class="col-md-8">
			        								<small class="text-muted">NIT:</small>
			        								<input type="text" name="garNit" class="form-control form-control-sm" required>
			        							</div>
			        							<div class="col-md-4">
			        								<small class="text-muted">CODIGO:</small>
			        								<input type="text" name="garVerification" class="form-control form-control-sm" required>
			        							</div>
			        						</div>
			        					</div>
			        					<div class="form-group">
			        						<div class="row">
			        							<div class="col-md-6">
			        								<small class="text-muted">CELULAR:</small>
			        								<input type="text" name="garPhone" class="form-control form-control-sm" required>
			        							</div>
			        							<div class="col-md-6">
			        								<small class="text-muted">WHATSAPP:</small>
			        								<input type="text" name="garWhatsapp" class="form-control form-control-sm" required>
			        							</div>
			        						</div>
			        					</div>
			        				</div>
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">CIUDAD:</small>
			        						<select name="garCity" class="form-control form-control-sm" required>
			        							<option value="">Seleccione una ciudad...</option>
			        							@foreach($citys as $city)
			        								<option value="{{ $city->id }}">{{ $city->name }}</option>
			        							@endforeach
			        						</select>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">LOCALIDAD:</small>
			        						<select name="garLocation" class="form-control form-control-sm" required>
			        							<option value="">Seleccione una localidad...</option>
			        							<!-- Localidades dinamicas -->
			        						</select>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">BARRIO:</small>
			        						<select name="garDistrict" class="form-control form-control-sm" required>
			        							<option value="">Seleccione un barrio...</option>
			        							<!-- Barrios dinamicos -->
			        						</select>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">DIRECCION:</small>
			        						<input type="text" name="garAddress" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-4">
			        					<div class="form-group">
			        						<small class="text-muted">TELEFONO 1:</small>
			        						<input type="number" name="garPhoneone" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        				<div class="col-md-4">
			        					<div class="form-group">
			        						<small class="text-muted">TELEFONO 2:</small>
			        						<input type="number" name="garPhonetwo" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        				<div class="col-md-4">
			        					<div class="form-group">
			        						<small class="text-muted">TELEFONO 3:</small>
			        						<input type="number" name="garPhonethree" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">CORREO ELECTRONICO 1:</small>
			        						<input type="email" name="garMailone" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">CORREO ELECTRONICO 2:</small>
			        						<input type="email" name="garMailtwo" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-12">
			        					<div class="form-group">
			        						<small class="text-muted">PAGINA WEB 1:</small>
			        						<input type="text" name="garWebsite" class="form-control form-control-sm" required>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="row">
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">REPRESENTANTE LEGAL:</small>
			        						<input type="text" name="garNamerepresentative" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">CEDULA DE REPRESENTANTE:</small>
			        						<input type="text" name="garCardrepresentative" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">FIRMA DIGITAL DE REPRESENTANTE:</small>
			        						<input type="file" name="garFirm" lang="es" placeholder="Seleccione una imagen .PNG" accept="image/png">
			        					</div>
			        				</div>
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">TESTIGO DE CONTRATOS:</small>
			        						<input type="text" name="garNamewitness" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">CEDULA DE TESTIGO:</small>
			        						<input type="text" name="garCardwitness" class="form-control form-control-sm" required>
			        					</div>
			        					<div class="form-group">
			        						<small class="text-muted">FIRMA DIGITAL DE TESTIGO:</small>
			        						<input type="file" name="garFirmwitness" lang="es" placeholder="Seleccione una imagen .PNG" accept="image/png">
			        					</div>
			        				</div>
			        			</div>
			        			<hr>
			        			<div class="row">
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">LOGO DE JARDIN:</small>
										    <div class="custom-file">
										        <input type="file" name="garLogo" lang="es" placeholder="Seleccione una imagen .PNG" accept="image/png">
										    </div>
			        					</div>
			        				</div>
			        				<div class="col-md-6">
			        					<div class="form-group">
			        						<small class="text-muted">CODIGO QR:</small>
										    <div class="custom-file">
										        <input type="file" name="garCode" lang="es" placeholder="Seleccione una imagen .PNG/.JPG" accept="image/png|image/jpg">
										    </div>
			        					</div>
			        				</div>
			        			</div>
			        			<div class="row text-center">
			        				<div class="col-md-12">
			        					<div class="form-group">
											<button type="submit" class="bj-btn-table-add mx-3 form-control-sm">GUARDAR DATOS</button>
					        			</div>
			        				</div>
			        			</div>
			        		</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="updateGarden-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-12">
							<h4 class="text-muted">ACTUALIZACION DE JARDIN:</h4>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-4">
					<div class="row">
						@if($garden != null || $garden != '')
							<div class="col-md-12">
								<form action="{{ route('garden.update') }}" method="POST" enctype="multipart/form-data">
				        			@csrf
				        			<div class="row">
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">RAZON SOCIAL:</small>
				        						<input type="text" name="garReasonsocial_update" class="form-control form-control-sm" value="{{ $garden->garReasonsocial }}" required>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">NOMBRE COMERCIAL:</small>
				        						<input type="text" name="garNamecomercial_update" class="form-control form-control-sm" value="{{ $garden->garNamecomercial }}" required>
				        					</div>
				        					<div class="form-group">
				        						<div class="row">
				        							<div class="col-md-8">
				        								<small class="text-muted">NIT:</small>
				        								@php 
															$separatedNit = explode('-', $garden->garNit);
				        								@endphp
				        								<input type="text" name="garNit_update" class="form-control form-control-sm" value="{{ $separatedNit[0] }}" required>
				        							</div>
				        							<div class="col-md-4">
				        								<small class="text-muted">CODIGO:</small>
				        								<input type="text" name="garVerification_update" class="form-control form-control-sm" value="{{ $separatedNit[1] }}" required>
				        							</div>
				        						</div>
				        					</div>
				        					<div class="form-group">
				        						<div class="row">
				        							<div class="col-md-6">
				        								<small class="text-muted">CELULAR:</small>
				        								<input type="text" name="garPhone_update" class="form-control form-control-sm" value="{{ $garden->garPhone }}" required>
				        							</div>
				        							<div class="col-md-6">
				        								<small class="text-muted">WHATSAPP:</small>
				        								<input type="text" name="garWhatsapp_update" class="form-control form-control-sm" value="{{ $garden->garWhatsapp }}" required>
				        							</div>
				        						</div>
				        					</div>
				        				</div>
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">CIUDAD:</small>
				        						<select name="garCity_update" class="form-control form-control-sm" required>
				        							<option value="">Seleccione una ciudad...</option>
				        							@foreach($citys as $city)
				        								@if($city->id == $garden->garCity_id)
				        									<option value="{{ $city->id }}" selected>{{ $city->name }}</option>
				        								@else
				        									<option value="{{ $city->id }}">{{ $city->name }}</option>
				        								@endif
				        							@endforeach
				        						</select>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">LOCALIDAD:</small>
				        						<select name="garLocation_update" class="form-control form-control-sm" required>
				        							<option value="">Seleccione una localidad...</option>
				        							<!-- Localidades dinamicas -->
				        						</select>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">BARRIO:</small>
				        						<select name="garDistrict_update" class="form-control form-control-sm" required>
				        							<option value="">Seleccione un barrio...</option>
				        							<!-- Barrios dinamicos -->
				        						</select>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">DIRECCION:</small>
				        						<input type="text" name="garAddress_update" class="form-control form-control-sm" value="{{ $garden->garAddress }}" required>
				        					</div>
				        				</div>
				        			</div>
				        			<div class="row">
				        				<div class="col-md-4">
				        					<div class="form-group">
				        						<small class="text-muted">TELEFONO 1:</small>
				        						<input type="number" name="garPhoneone_update" class="form-control form-control-sm" value="{{ $garden->garPhoneone }}" required>
				        					</div>
				        				</div>
				        				<div class="col-md-4">
				        					<div class="form-group">
				        						<small class="text-muted">TELEFONO 2:</small>
				        						<input type="number" name="garPhonetwo_update" class="form-control form-control-sm" value="{{ $garden->garPhonetwo }}" required>
				        					</div>
				        				</div>
				        				<div class="col-md-4">
				        					<div class="form-group">
				        						<small class="text-muted">TELEFONO 3:</small>
				        						<input type="number" name="garPhonethree_update" class="form-control form-control-sm" value="{{ $garden->garPhonethree }}" required>
				        					</div>
				        				</div>
				        			</div>
				        			<div class="row">
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">CORREO ELECTRONICO 1:</small>
				        						<input type="email" name="garMailone_update" class="form-control form-control-sm" value="{{ $garden->garMailone }}" required>
				        					</div>
				        				</div>
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">CORREO ELECTRONICO 2:</small>
				        						<input type="email" name="garMailtwo_update" class="form-control form-control-sm" value="{{ $garden->garMailtwo }}" required>
				        					</div>
				        				</div>
				        			</div>
				        			<div class="row">
				        				<div class="col-md-12">
				        					<div class="form-group">
				        						<small class="text-muted">PAGINA WEB 1:</small>
				        						<input type="text" name="garWebsite_update" class="form-control form-control-sm" value="{{ $garden->garWebsite }}" required>
				        					</div>
				        				</div>
				        			</div>
				        			<div class="row">
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">REPRESENTANTE LEGAL:</small>
				        						<input type="text" name="garNamerepresentative_update" class="form-control form-control-sm" value="{{ $garden->garNamerepresentative }}" required>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">CEDULA DE REPRESENTANTE:</small>
				        						<input type="text" name="garCardrepresentative_update" class="form-control form-control-sm" value="{{ $garden->garCardrepresentative }}" required>
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">FIRMA DIGITAL DE REPRESENTANTE:</small><br>
				        						@if($garden->garFirm == null)
				        							<h6>SIN FIRMA REPRESENTANTE</h6>
				        						@else
				        							@if($garden->garFirm == 'firm.png')
				        								<img src="{{ asset('storage/garden/firm/firm.png') }}" style="width: 100px; height: auto;">
				        							@else
				        								<img src="{{ asset('storage/garden/firm/firm.jpg') }}" style="width: 100px; height: auto;">
				        							@endif
				        						@endif
											    <div class="custom-file">
											        <input type="file" name="garFirm_update" lang="es" placeholder="Cambiar firma .PNG" accept="image/png" style="width: 100px; height: auto;">
											    </div>
				        					</div>
				        				</div>
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">TESTIGO DE CONTRATOS:</small>
				        						<input type="text" name="garNamewitness_update" class="form-control form-control-sm" value="{{ $garden->garNamewitness }}">
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">CEDULA DE TESTIGO:</small>
				        						<input type="text" name="garCardwitness_update" class="form-control form-control-sm" value="{{ $garden->garCardwitness }}">
				        					</div>
				        					<div class="form-group">
				        						<small class="text-muted">FIRMA DIGITAL DE TESTIGO:</small><br>
				        						@if($garden->garFirmwitness == null)
				        							<h6>SIN FIRMA TESTIGO</h6>
				        						@else
				        							@if($garden->garFirmwitness == 'firmwitness.png')
				        								<img src="{{ asset('storage/garden/firm/firmwitness.png') }}" style="width: 100px; height: auto;">
				        							@else
				        								<img src="{{ asset('storage/garden/firm/firmwitness.jpg') }}" style="width: 100px; height: auto;">
				        							@endif
				        						@endif
											    <div class="custom-file">
											        <input type="file" name="garFirmwitness_update" lang="es" placeholder="Cambiar firma .PNG" accept="image/png" style="width: 100px; height: auto;">
											    </div>
				        					</div>
				        				</div>
				        			</div>
				        			<hr>
				        			<div class="row">
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">LOGO ACTUAL:</small><br>
				        						@if($garden->garNamelogo == 'default.png')
				        							<h6>NO HAY LOGO</h6>
				        						@else
				        							@if($garden->garNamelogo == 'logo.png')
				        								<img src="{{ asset('storage/garden/logo.png') }}" style="width: 100px; height: auto;">
				        							@else
				        								<img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 100px; height: auto;">
				        							@endif
				        						@endif
											    <div class="custom-file">
											        <input type="file" name="garLogo_update" lang="es" placeholder="Cambiar logo .PNG" accept="image/png" style="width: 100px; height: auto;">
											    </div>
				        					</div>
				        				</div>
				        				<div class="col-md-6">
				        					<div class="form-group">
				        						<small class="text-muted">CODIGO QR:</small><br>
				        						@if($garden->garCode == 'defaultcode.png')
				        							<h6>NO HAY CODIGO QR</h6>
				        						@else
				        							@if($garden->garCode == 'code.png')
				        								<img src="{{ asset('storage/garden/code.png') }}" style="width: 100px; height: auto;">
				        							@else
				        								<img src="{{ asset('storage/garden/code.jpg') }}" style="width: 100px; height: auto;">
				        							@endif
				        						@endif
											    <div class="custom-file">
											        <input type="file" name="garCode_update" lang="es" placeholder="Seleccione una imagen .PNG/.JPG" accept="image/png|image/jpg" style="width: 100px; height: auto;">
											    </div>
				        					</div>
				        				</div>
				        			</div>
				        			<hr>
				        			<div class="row text-center">
				        				<div class="col-md-12">
				        					<div class="form-group">
				        						<input type="hidden" name="garId_update" class="form-control form-control-sm" value="{{ $garden->garId }}" readonly required>
												<button type="submit" class="bj-btn-table-add mx-3 form-control-sm">GUARDAR CAMBIOS</button>
						        			</div>
				        				</div>
				        			</div>
				        		</form>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(function(){

		});

		$('.newGarden-link').on('click',function(e){
			e.preventDefault();
			$('#newGarden-modal').modal();
		});

		$('.updateGarden-link').on('click',function(e){
			e.preventDefault();
			var location_id = $(this).find('span:nth-child(1)').text();
			var district_id = $(this).find('span:nth-child(2)').text();
			var city_id = $('select[name=garCity_update] option:selected').val();
			if(city_id != null && city_id != ''){
				$.get("{{ route('getLocationsGarden') }}", {city: city_id}, function(locationObject){
					var count = Object.keys(locationObject).length //total de localidades devueltas
					$('select[name=garLocation_update]').empty();
					$('select[name=garLocation_update]').append("<option value=''>Seleccione una localidad...</option>");
					$('select[name=garDistrict_update]').empty();
					$('select[name=garDistrict_update]').append("<option value=''>Seleccione un barrio...</option>");
					for (var i = 0; i < count; i++) {
						if(location_id == locationObject[i]['id']){
							$('select[name=garLocation_update]').append('<option value=' + locationObject[i]['id'] + ' selected>' + locationObject[i]['name'] + '</option>');
						}else{
							$('select[name=garLocation_update]').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
						}
					}
					$.get("{{ route('getDistrictsGarden') }}", {location: location_id}, function(districtObject){
						var count = Object.keys(districtObject).length //total de barrios devueltos
						$('select[name=garDistrict_update]').empty();
						$('select[name=garDistrict_update]').append("<option value=''>Seleccione un barrio...</option>");
						for (var i = 0; i < count; i++) {
							if(district_id == districtObject[i]['id']){
								$('select[name=garDistrict_update]').append('<option value=' + districtObject[i]['id'] + ' selected>' + districtObject[i]['name'] + '</option>');
							}else{
								$('select[name=garDistrict_update]').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
							}
						}
					});
				});
			}
			$('#updateGarden-modal').modal();
		});

		//CONSULTAR LAS LOCALIDADES DE ACUERDO A LA CIUDAD SELECCIONADA DEL MODAL DE CREACION
		$("select[name=garCity]").on("change", function(e){
			var city_id = e.target.value;
			$.get("{{ route('getLocationsGarden') }}", {city: city_id}, function(locationObject){
				var count = Object.keys(locationObject).length //total de localidades devueltas
				$('select[name=garLocation]').empty();
				$('select[name=garLocation]').append("<option value=''>Seleccione una localidad...</option>");
				$('select[name=garDistrict]').empty();
				$('select[name=garDistrict]').append("<option value=''>Seleccione un barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('select[name=garLocation]').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			});
		});

		//CONSULTAR LOS BARRIOS DE ACUERDO A LA LOCALIDAD SELECCIONADA DEL MODAL DE CREACION
		$("select[name=garLocation]").on("change", function(e){
			var location_id = e.target.value;
			$.get("{{ route('getDistrictsGarden') }}", {location: location_id}, function(districtObject){
				var count = Object.keys(districtObject).length //total de localidades devueltas
				$('select[name=garDistrict]').empty();
				$('select[name=garDistrict]').append("<option value=''>Seleccione un barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('select[name=garDistrict]').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
				}
			});
		});

		//CONSULTAR LAS LOCALIDADES DE ACUERDO A LA CIUDAD SELECCIONADA DEL MODAL DE ACTUALIZACION
		$("select[name=garCity_update]").on("change", function(e){
			var city_id = e.target.value;
			$.get("{{ route('getLocationsGarden') }}", {city: city_id}, function(locationObject){
				var count = Object.keys(locationObject).length //total de localidades devueltas
				$('select[name=garLocation_update]').empty();
				$('select[name=garLocation_update]').append("<option value=''>Seleccione una localidad...</option>");
				$('select[name=garDistrict_update]').empty();
				$('select[name=garDistrict_update]').append("<option value=''>Seleccione un barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('select[name=garLocation_update]').append('<option value=' + locationObject[i]['id'] + '>' + locationObject[i]['name'] + '</option>');
				}
			});
		});

		//CONSULTAR LOS BARRIOS DE ACUERDO A LA LOCALIDAD SELECCIONADA DEL MODAL DE ACTUALIZACION
		$("select[name=garLocation_update]").on("change", function(e){
			var location_id = e.target.value;
			$.get("{{ route('getDistrictsGarden') }}", {location: location_id}, function(districtObject){
				var count = Object.keys(districtObject).length //total de localidades devueltas
				$('select[name=garDistrict_update]').empty();
				$('select[name=garDistrict_update]').append("<option value=''>Seleccione un barrio...</option>");
				for (var i = 0; i < count; i++) {
					$('select[name=garDistrict_update]').append('<option value=' + districtObject[i]['id'] + '>' + districtObject[i]['name'] + '</option>');
				}
			});
		});

		$('input[name=changePassword]').on('change',function(e){
			var option = e.target.value
			if(option == 'SI'){
				$('#inputPasswords').css('display','block');
				$('input[name=nowPassword]').val('');
				$('input[name=nowPassword]').attr('required',true);
				$('input[name=nowPassword]').attr('disabled',false);
				$('input[name=newPassword]').val('');
				$('input[name=newPassword]').attr('required',true);
				$('input[name=newPassword]').attr('disabled',false);
				$('input[name=confirmPassword]').val('');
				$('input[name=confirmPassword]').attr('required',true);
				$('input[name=confirmPassword]').attr('disabled',false);
			}else if(option == 'NO'){
				$('#inputPasswords').css('display','none');
				$('input[name=nowPassword]').val('');
				$('input[name=nowPassword]').attr('required',false);
				$('input[name=nowPassword]').attr('disabled',true);
				$('input[name=newPassword]').val('');
				$('input[name=newPassword]').attr('required',false);
				$('input[name=newPassword]').attr('disabled',true);
				$('input[name=confirmPassword]').val('');
				$('input[name=confirmPassword]').attr('required',false);
				$('input[name=confirmPassword]').attr('disabled',true);
			}
		});
	</script>
@endsection