@extends('modules.accountants')

@section('financialModules')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <h6>ESTADISTICA DE VENTAS:</h6>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      @php $yearNow = date('Y') @endphp
      <div class="btn-group mx-3" role='group'>
        <a href="#" class="btn btn-outline-primary btn-less"><i class="fas fa-angle-left"></i></a>
        <button class="px-3" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"> AÑO: </button>
        <button class="btn btn-default year" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">{{ $yearNow }}</button>
        <a href="#" class="btn btn-default btn-plus" disabled><i class="fas fa-angle-right"></i></a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <input type="hidden" class="form-control form-control-sm" name="year" value="{{ $yearNow }}" readonly required>
        <input type="hidden" name="view_file" class="form-control form-control-sm" readonly required>
        <button type="button" class="btn btn-outline-tertiary  mx-3 my-3 form-control-sm" id="btn-drawPdf"><i class="fas fa-file-pdf"></i> DESCARGAR</button>
      </div>
    </div>
  </div>
  <div class="row border-top mt-10 pdf-table-wrap">
    <div class="col-md-9">
      <canvas id="statisticProposals" width="300" height="150"></canvas>
    </div>
    <div class="col-md-3 d-flex justify-content-center" id="tblTable">
      <table id="tblProposals" border="1" class="text-center mt-4 border-top" style="font-size: 12px; text-align: center;">
        <thead>
          <tr>
            <th class="mountTable">{{ $yearNow }}</th>
            <th>COSTO DE VENTAS</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <!-- dinamic -->
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var months = [];
  var count = 0;
  let search = $(' .year').text();
  $.get("{{route('getSales')}}", {
    data: search
  }, function(objectSales) {
    // console.log(objectSales);
    var Meses = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    var mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    Meses.forEach(element => {
      count = 0;
      for (const iterator of objectSales) {
        let ven = iterator['venDate'];
        let sales = iterator['venPaid'];
        let mon = ven.split("-");
        if (mon[1] == element) {
          count += sales;
        }
      }
      months.push(count);
    });
    let num = 0;
    mes.forEach(element => {
      $('#tblProposals tbody').append("<tr><td class='text-info'>" + element + "</td><td>" + new Intl.NumberFormat().format(months[num]) + "</td></tr>");
      num++;
    });
    // grafica
    let ctx = document.getElementById('statisticProposals');
    let myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
          data: months,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        legend: {
          display: false,
        },
        title: {
          display: true,
          text: "COSTOS DE VENTAS",
          fontColor: "#819233",
          fontSize: 15,
        },
        tooltips: {
          backgroundColor: "#007bff",
          titleSpacing: 3,
          borderColor: "#000000"
        }
      }
    });
  });
  //add event listener to 2nd button
  document.getElementById('btn-drawPdf').addEventListener("click", downloadPDF2);

  //download pdf form hidden canvas
  function downloadPDF2() {

    var newCanvas = document.querySelector('#statisticProposals');
    //create image from dummy canvas
    var newCanvasImg = newCanvas.toDataURL("image/png", 1.0);

    //creates PDF from img
    var doc = new jsPDF({
      orientation: 'landscape',
      format: "letter"
    });

    doc.addImage(newCanvasImg, 'PNG', 12, 12, 200, 140);
    // carga los datos
    doc.fromHTML($('#tblProposals tbody').get(0), 10, 12, {
      "width": 192,
    });
    let date = new Date();
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
    let nows = date.toLocaleDateString("es-ES", options);
    doc.save("VENTAS DEL " + $('button.year').text() + "- GENERADO El " + nows.toUpperCase() + ".pdf");
  }
</script>
<!-- codigo antiguo -->
<!-- <script>
  var img = new Image();
  var canvas = document.getElementById('statisticProposals');
  var ctx = document.getElementById('statisticProposals').getContext('2d');
  var statistic = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          datasets: [{
              label: 'COSTO DE VENTAS',
              data: [
              		{!! $salesAll[1] !!},
              		{!! $salesAll[2] !!},
              		{!! $salesAll[3] !!},
              		{!! $salesAll[4] !!},
              		{!! $salesAll[5] !!},
              		{!! $salesAll[6] !!},
              		{!! $salesAll[7] !!},
              		{!! $salesAll[8] !!},
              		{!! $salesAll[9] !!},
              		{!! $salesAll[10] !!},
              		{!! $salesAll[11] !!},
              		{!! $salesAll[12] !!}
              	],
              backgroundColor: [
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068'
              ],
              borderColor: [
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068',
                  '#a4b068'
              ],
              borderWidth: 1
          }
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
  $(function() {
    convertCanvasToImage();
  });

  $('.btn-drawPdf').on('click', function(e) {
    e.preventDefault();
    convertCanvasToImage();
    var pdf = new jsPDF();
    pdf.setFontSize(15);
    pdf.text('REPORTE DE VENTAS DURANTE EL AÑO ' + $('button.year').text(), 30, 25);
    pdf.addImage(img, 'png', 20, 40, 170, 90);
    pdf.save("VENTAS_" + $('button.year').text() + "_GENERADO EL " + Date() + ".pdf");
  });

  function convertCanvasToImage() {
    img.src = canvas.toDataURL("image/png");
  }

  $('.btn-less').on('click',function(e){
  	e.preventDefault();
  	var year = parseInt($('.year').text()) - 1;
  	var yearnow = new Date().getFullYear();
  	if(year <= parseInt(yearnow)){
  		if(year == parseInt(yearnow)){
  			$('.btn-plus').attr('disabled',true);
  			$('.btn-plus').removeClass('btn-outline-primary');
  			$('.btn-plus').addClass('btn-default');
  		}
  		// statistic.data.datasets[0].data = [];
  		$.ajax({
  			type: 'GET',
  			url: "{{ route('statistics.financial.filter') }}",
  			data: {year: year},
  			dataType: 'json',
  			async: false
  		}).done(function(response){
  			statistic.data.datasets[0].data = [
  				response[1],
  				response[2],
  				response[3],
  				response[4],
  				response[5],
  				response[6],
  				response[7],
  				response[8],
  				response[9],
  				response[10],
  				response[11],
  				response[12]
  			];
  			var i = 1;
  			$('#tblProposals tbody tr').each(function(){
  				$(this).find('td:nth-child(2)').text('$' + response[i]);
  				i++;
  			});
  		});
  		$('.year').text(year);
  		$('input[name=year]').val(year);
  		if(year == parseInt(yearnow)){
  			$('.btn-plus').attr('disabled',true);
  			$('.btn-plus').removeClass('btn-outline-primary');
  			$('.btn-plus').addClass('btn-default');
  		}else{
  			$('.btn-plus').attr('disabled',false);
  			$('.btn-plus').removeClass('btn-default');
  			$('.btn-plus').addClass('btn-outline-primary');
  		}
  		$('.mountTable').html(year);
  		statistic.update();
  		convertCanvasToImage();
  	}else{
  		$('.btn-plus').attr('disabled',true);
  		$('.btn-plus').removeClass('btn-outline-primary');
  		$('.btn-plus').addClass('btn-default');
  	}
  });

  $('.btn-plus').on('click',function(e){
  	e.preventDefault();
  	var year = parseInt($('.year').text()) + 1;
  	var yearnow = new Date().getFullYear();
  	if(year <= parseInt(yearnow)){
  		$.ajax({
  			type: 'GET',
  			url: "{{ route('statistics.financial.filter') }}",
  			data: {year: year},
  			dataType: 'json',
  			async: false
  		}).done(function(response){
  			statistic.data.datasets[0].data = [
  				response[1],
  				response[2],
  				response[3],
  				response[4],
  				response[5],
  				response[6],
  				response[7],
  				response[8],
  				response[9],
  				response[10],
  				response[11],
  				response[12]
  			];
  			var i = 1;
  			$('#tblProposals tbody tr').each(function(){
  				$(this).find('td:nth-child(2)').text('$' + response[i]);
  				i++;
  			});
  		});
  		$('.year').text(year);
  		$('input[name=year]').val(year);
  		if(year == parseInt(yearnow)){
  			$('.btn-plus').attr('disabled',true);
  			$('.btn-plus').removeClass('btn-outline-primary');
  			$('.btn-plus').addClass('btn-default');
  		}else{
  			$('.btn-plus').attr('disabled',false);
  			$('.btn-plus').removeClass('btn-default');
  			$('.btn-plus').addClass('btn-outline-primary');
  		}
  		$('.mountTable').html(year);
  		statistic.update();
  		convertCanvasToImage();
  	}else{
  		$('.btn-plus').attr('disabled',true);
  		$('.btn-plus').removeClass('btn-outline-primary');
  		$('.btn-plus').addClass('btn-default');
  	}
  });
</script> -->
@endsection