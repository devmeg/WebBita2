<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 style="color:#ffffff;">Ruta de mi viaje</h3> </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <!-- Row -->
            
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="card card-outline-info">
                            
                            <div class="card-body m-t-15">
                            	<legend>Mapa</legend>
                                
                                    <div class="form-body">
                                       <div id="container"></div>
                                   </div>
                                    
                            
                            </div>
                        </div>
                    </div>
                </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.4/proj4.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/gb/gb-all.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/south-america.js"></script>
<script>
	

// Initialize the chart
var chart = Highcharts.mapChart('container', {

	chart:{
		height:500
	},

  title: {
    text: 'Ruta de mi viaje'
  },

  legend: {
    align: 'left',
    layout: 'vertical',
    floating: true
  },

  mapNavigation: {
    enabled: true
  },

  tooltip: {
    formatter: function () {
      return (this.point.lat ?'<br>'+this.point.mensaje : '');
    }
  },

  plotOptions: {
    series: {
      marker: {
        fillColor: '#FFFFFF',
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[1]
      }
    }
  },

  series: [{
    // Use the gb-all map with no data as a basemap
    mapData: Highcharts.maps['custom/south-america'],
    name: 'Basemap',
    borderColor: '#707070',
    nullColor: 'rgba(200, 200, 200, 0.3)',
    showInLegend: false
  }, {
    name: 'Separators',
    type: 'mapline',
    data: Highcharts.geojson(Highcharts.maps['custom/south-america'], 'mapline'),
    color: '#707070',
    showInLegend: false,
    enableMouseTracking: false
  }, {
    // Specify cities using lat/lon
    type: 'mappoint',
    name: 'Hitos',
    dataLabels: {
      format: '{point.lugar}'
    },
    // Use id instead of name to allow for referencing points later using
    // chart.get
    data: [
    	<?php echo $s_hitos; ?>
      <?php echo $s_hitosVuelta; ?>
     ,{
     	mensaje: 'La mejor aventura',
     	lugar:'Encuentro Sudamericano',
      	id: 'V Campori', //Barretos
      	lat: -20.5094371,
      	lon: -48.6014118,
      	dataLabels: {
        	align: 'left',
        	x: 5,
        	verticalAlign: 'middle'
      	}
    }]
  }]
});

// Function to return an SVG path between two points, with an arc
function pointsToPath(from, to, invertArc) {
  var arcPointX = (from.x + to.x) / (invertArc ? 2.4 : 1.6),
    arcPointY = (from.y + to.y) / (invertArc ? 2.4 : 1.6);

  return 'M' + from.x + ',' + from.y +',' + to.x + ' ' + to.y;
  //return 'M' + from.x + ',' + from.y + 'Q' + arcPointX + ' ' + arcPointY + ',' + to.x + ' ' + to.y;
}

var londonPoint = chart.get('London'), // Primer punto
  campori = chart.get('V Campori'); // Barretos

// Add a series of lines for London
chart.addSeries({
  name: 'IDA',
  type: 'mapline',
  lineWidth: 2,
  color: Highcharts.getOptions().colors[3],
  data: [
  <?php echo $rutas; ?>
   ]
});

// Add a series of lines for Lerwick
chart.addSeries({
  name: 'VUELTA',
  type: 'mapline',
  lineWidth: 2,
  color: Highcharts.getOptions().colors[5],
  data: [
  <?php echo $rutasVuelta; ?>
    ]
});

</script>

          