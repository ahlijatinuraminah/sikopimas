<div id="dvMap" style="width: auto; height: 600px; margin-bottom:20px"></div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript">
var id_provinsi ='';
var id_negara;
var id_mitra;
var markers;
var map;
var mapmarkers =[];
	
	function gotoTable(divid){
		var target = $('#'+divid);
		debugger;
					$('html, body').animate({
						  scrollTop: target.offset().top
						}, 500, function() {
			
				var $target = $(target);
				  //$target.focus();
				  if ($target.is(":focus")) { // Checking if the target was focused
					return false;
				  } else {
					$target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
					//$target.focus(); // Set focus again
				  };
				});
	}
	function createInfoWindow(marker, key) {
				//create an infowindow for this marker
				var infowindow = new google.maps.InfoWindow({
				  content: "<h2>" + markers[key].nama_provinsi + "</h2><div style='font-size:12px;'>Gr. Floor, Madhava Building, Bandra Kurla Complex, Near Family Court, Bandra - East, Mumbai - 400 051 </div>",
				  maxWidth:250
				});				
				google.maps.event.addListener(marker, 'click', function(e) {								
					map.setZoom(9);
					map.setCenter(e.latLng);
					//gotoTable();
					id_provinsi= markers[key].id;
					$("#ddlProvinsi").val(id_provinsi).trigger('change.select2');					
					readRecords();
					$("#splokasi").html(markers[key].nama_provinsi);							
				});
				
		}
	
	function createTooltip(marker, key) {
		
				//create a tooltip 
				var tooltipOptions={
					marker:marker,
					content: "<h4 class='tooltipHeader'>"+markers[key].nama_provinsi+"</h4><div class='tooltipDetail'>"+markers[key].jumlah_ormas+" organizations</div>",
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
            
            map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
			loadmarker();
						
        }
		function setMapOnAll() {
			for (var i = 0; i < mapmarkers.length; i++) {
			  mapmarkers[i].setMap(null);
			}
		}
		
		function loadmarker() {	
			setMapOnAll();				
			$.post("controller/controllerprovinsi.php", { 
				id_provinsi: id_provinsi,
				id_mitra: id_mitra,
				id_negara: id_negara,				
				mode: 'loadmap'
			},
			function (data, status) {				
				markers = JSON.parse(data);						
				
				for (var key in markers){
				var myPlace = markers[key];				
					var marker = new google.maps.Marker({
						map: map,
						label: myPlace.jumlah_ormas,						
						position: new google.maps.LatLng(myPlace.lati, myPlace.longi)
					});
					
					
					mapmarkers.push(marker);
				    createInfoWindow(marker, key);
				    createTooltip(marker, key);
				}
				
			});
		}
		
		$(document).ready(function () {    	
			createMap();						
		});
    </script>	