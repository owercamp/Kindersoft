<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Google Maps</title>
	<link rel="shortcut icon" href="">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style type="text/css">
		#map{
			width: 400px;
			height: 400px;
		}
	</style>
</head>
<body>
	<div class="container border-left border-right" style="min-height: 100vh;">
		<div class="row clearfix">
			<div class="col-md-6 border p-4">
				<!-- map -->
				<h6>Geolocalización</h6>
				<hr>
				<div id="map" style="width: 100%;"></div>
			</div>
			<div class="col-md-6 border p-4">
				<!-- opciones -->
				<h6>Panel de control</h6>
				<hr>
				<div class="form-group">
					<b class="text-muted">TODOS:</b>
					<hr>
					<?php
						$dates = [
							[ '1010', '100', 'B6', 'J3', 'GR7' ],
							[ '6372', '7TE', 'H3', 'H8', 'GR7' ],
							[ 'HGS6', 'Y89', 'Y2', 'H8', 'GR7' ],
							[ 'JA9I', 'Y6T', 'Y7', 'H8', 'GR7' ],
							[ 'H3T6', '627', 'L0', 'H2', 'GR7' ]
						]; 

						for ($i=0; $i < count($dates); $i++) {
					?>
						<div class="custom-control custom-radio">
						  <input type="radio" id="customRadio<?php echo $i; ?>" value="<?php echo $dates[$i][0] . $dates[$i][1] . $dates[$i][2] . $dates[$i][3] . $dates[$i][4]; ?>" name="customRadio" class="custom-control-input">
						  <label class="custom-control-label" for="customRadio<?php echo $i; ?>">
						  	<?php echo $dates[$i][0] . $dates[$i][1] . $dates[$i][2] . $dates[$i][3] . $dates[$i][4]; ?>
						  </label>
						</div>
					<?php
						}
					?>
					<hr>
					<button type="button" class="btn btn-primary btn-save">Guardar</button>
				</div>
			</div>
		</div>
		<div class="row p-4">
			<div class="col-md-12">
				<table class="table table-striped text-center tbl-info" width="100%">
					<thead>
						<tr>
							<th>NOMBRE</th>
							<th>COORDENADAS</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw4YZFfhFsSj0PwqChX1FVI1iJs68MHL0&callback=initMap"></script>
	<script>
		const storage = window.localStorage;
		$(function () {
			if(storage.length > 0){
				for (var i = 0; i < storage.length; i++) {
					$('.tbl-info tbody').append(
						"<tr>" +
							"<td>" + storage[i].name + "</td>" +
							"<td>" + storage[i].coords + "</td>" +
						"</tr>"
					);
				}
			}
			// initMap($('#map'));
		});

		$('.btn-save').on('click',function(){
			if($('input[name=customRadio]').is(':checked')){
				console.log($('input[name=customRadio]:checked').val());
			}else{
				console.log('ningun checked');
			}
		});
		
		// let map = google.maps.Map;
		function initMap () {
		  new google.maps.Map(document.getElementById('map'), {
		    center: { lat: -34.397, lng: 150.644 },
		    zoom: 8,
		  });
		}

		function setLocalstorage(data){
			storage.setItem('coords',data);
		}

		function getLocalstorage(){
			return storage.getItem('coords');
		}
		</script>
</body>
</html>