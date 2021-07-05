<?php
include "inc.koneksi.php";
?>
<html>
<head>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="DataTables/media/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
.maptooltip{
	border:thin 1px #eee;
	background-color:#FFFFFF;
	padding:5px;
	width:200px;
}
h2.tooltipHeader {
    color: blue;    
	text-align:center;
    font-weight: normal;	
}

.tooltipDetail {
	font-size:12px;
	text-align:center;
	margin-bottom:5px;
}
</style>

</head>
<body>
<div id="dvMap" style="width: auto; height: 600px; margin-bottom:20px"></div>
	
	<?php
				$pages_dir = 'pages';
				if(!empty($_GET['p'])){
					$pages = scandir($pages_dir, 0);
					unset($pages[0], $pages[1]);
					
					$p = $_GET['p'];
					if(in_array($p.'.php', $pages)){
						include($pages_dir.'/'.$p.'.php');
					} else {
						echo 'Halaman tidak ditemukan! :(';
					}
				} else {
					//include($pages_dir.'/home.php');
				}
	?>
</body>	
<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBOoyCah2yPwDW8XFBtmWumZrpaTlAGNY"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script type="text/javascript">
		var markers = [
		<?php
		$conn = mysqli_connect("localhost","root", "");
		mysqli_select_db($conn, "ngo");
		//$this->connection = $conn;	
		
		$sql = mysqli_query($conn, "SELECT * FROM v_lokasiormas");
		while(($data =  mysqli_fetch_assoc($sql))) {
		?>
		{
                 "lat": '<?php echo $data['lati']; ?>',
				 "long": '<?php echo $data['longi']; ?>',
				 "kode_provinsi": '<?php echo $data['kode_provinsi']; ?>',
				 "nama_provinsi": '<?php echo $data['nama_provinsi']; ?>',
				 "jumlah_ormas": '<?php echo $data['jumlah_ormas']; ?>'
		},
		<?php
		}
		?>
		];

	
	function createInfoWindow(marker, key) {
				//create an infowindow for this marker
				var infowindow = new google.maps.InfoWindow({
				  content: "<h2>" + markers[key].nama_provinsi + "</h2><div style='font-size:12px;'>Gr. Floor, Madhava Building, Bandra Kurla Complex, Near Family Court, Bandra - East, Mumbai - 400 051 </div>",
				  maxWidth:250
				});
				//open infowindo on click event on marker.
				google.maps.event.addListener(marker, 'click', function() {
					window.location ='lat3.php';
					//if(lastOpenInfoWin) lastOpenInfoWin.close();
					//lastOpenInfoWin = infowindow;
				  //infowindow.open(marker.get('map'), marker);
				});
				
		}
	
	function createTooltip(marker, key) {
				//create a tooltip 
				var tooltipOptions={
					marker:marker,
					content: "<h2 class='tooltipHeader'>"+markers[key].nama_provinsi+"</h2><div class='tooltipDetail'>"+markers[key].jumlah_ormas+" organizations</div>",
					cssClass:'maptooltip' // name of a css class to apply to tooltip
				};
				var tooltip = new Tooltip(tooltipOptions);
				
	}
	var lastOpenInfoWin = null;
        function createMap() {

            var mapOptions = {
		        center: new google.maps.LatLng(-2.2459632,116.2409634),
                zoom: 5,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }; 
            var infoWindow = new google.maps.InfoWindow();
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
			
			for (var key in markers){
				var myPlace = markers[key];				
				
					var marker = new google.maps.Marker({
						map: map,
						label: myPlace.jumlah_ormas,
						icon: 'img/icon.png',
						position: new google.maps.LatLng(myPlace.lat, myPlace.long)
					});
				createInfoWindow(marker, key);
				createTooltip(marker, key);
			}
        }
		
		$(document).ready(function () {    	
			createMap();
		});
		
    </script>	
	</html>