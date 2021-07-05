

 
 <!--<div class="share">
    <div class="line3"></div>
    <div class="line2"></div>
    <div class="line"></div>
 
      <a class="btn btn-primary btn-xs"><h1>view organisasi</h1></a>
      <div class="btn">+</div>
    
    
  </div>
	<div id="hide" class="active">-->

		<div id="divdata" class="container">
			<!--<div class="row">
					<div class="col-md-3">
					<label>PROJECT LOCATION</label>
					<select id="ddlProvinsi" class="form-control">		  
					</select>		
					</div>
					<div class="col-md-3">
					<label>ORIGIN COUNTRY</label>
					<select id="ddlNegara" class="form-control">		  
					</select>		
					</div>		
					<div class="col-md-3">
					<label>PARTNER</label>
					<select id="ddlMitra" class="form-control">		  
					</select>		
					</div>
					<div class="col-md-3">
					<label>TINGKAT KERAWANAN</label>
					<select id="ddlKerawanan" class="form-control">
					  <option value="">ALL</option>          
					  <option value="1">Aman</option>          
					  <option value="2">Bahaya</option>          
					  <option value="3">Rawan</option>          
					</select>		
					</div>
			</div>-->
			

			<div class="content-panel">
				<h5><span id="splokasi"></span>&nbsp <span id="spnegara"></span> &nbsp <span id="spmitra"></span></h5>							
				<div class="records_content">
				<table id="tblorganisasi" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th style="vertical-align: middle;"> No.</th>
							<th style="vertical-align: middle;"> Id Negara</th>
							<th style="vertical-align: middle;"> Id mitra</th>
							<th style="vertical-align: middle;">Nama Organisasi</th>
							<th style="vertical-align: middle;">Representasi</th>
							<th style="vertical-align: middle;">Lokasi Kerja</th>
							<th style="vertical-align: middle;">Tahun Beroperasi</th>
							<th style="vertical-align: middle;">Negara Asal</th>
							<th style="vertical-align: middle;">Bidang Kerja</th>										
						</tr>
									</thead>
				</table>
									
				</div>		    
			</div>			  

			<!-- Bootstrap Modals -->
			<!-- Modal - Add New Record/User -->
			<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Organization Detail</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							
						</div>
						<div class="modal-body">			
						
						  <form role="form" id="myform">                
							  
							  <div class="form-group">					
								<label id="nama_organisasi" name="nama_organisasi"></label>					
							  </div>                                      
							<div class="form-group">					
								<label id="alamat" name="alamat">alamat</label>					  					
							</div>                    
						  </form>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
						</div>
					</div>
				</div>
			</div>

			</div>


  </div>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
// Save Record
var table;
function resetForm(){
	
	$("#id").val("");
    $("#nama_organisasi").val("");
    $("#representasi").val("");
	$("#alamat").val("");
	$("#tahun_beroperasi").val("");
	$("#nama_negara").val("");
	$("#nama_bidang").val("");
	
	

	
}

function bindForm(data){	
	$("#id").val(data.id);
    $("#nama_organisasi").html(data.nama_organisasi);
	$("#representasi").html(data.representasi);
	$("#alamat").html(data.alamat);
	$("#tahun_beroperasi").html(data.tahun_beroperasi);
	$("#nama_negara").html(data.nama_negara);
	$("#nama_bidang").html(data.nama_bidang);
	
}

function openModal(){
	resetForm();
	 $("#add_new_record_modal").modal("show");
}

function initializeTable(){
	table = $("#tblorganisasi").DataTable({			
				"serverSide": false,
				"processing": false,      				
				"ajax": {
					"url" : "controller/controllerorganisasi.php",
					"type": "POST",
					"dataSrc": "",
					"data" : {
						'id_provinsi': id_provinsi,
						'mode': 'read'
					}
				},
				"columns": [
					{ "data": "id" },
					{ "data": "id_negara_asal" },		
					{ "data": "id_mitra" },		
					{ "data": "nama_organisasi" },
					{ "data": "representasi" },	
					{ "data": "alamat" },					
					{ "data": "tahun_beroperasi" },
					{ "data": "nama_negara" },
					{ "data": "nama_bidang" }
				],
				"columnDefs": [
				{
					"targets": [ 1, 2],
					"visible": false
				}
        	],
				responsive: true,
				pageLength : 10,
				lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
		});
	
}
function readRecords() {		

	$.ajax({
		url : "controller/controllerorganisasi.php",
		type: "POST",					
		data : {
				'id_provinsi': id_provinsi,
				'mode': 'read'
		},
      success: function (json) {		  
        var data = JSON.parse(json);        		
		var table = $("#tblorganisasi").DataTable();        
        table.clear().draw();        
		if(data != null)
        	table.rows.add(data).draw();         
      }
    });
        
}

function getOne(id) {		
	resetForm();
    $.post("controller/controllerorganisasi.php", {
        id: id,
		mode: 'get'
    },
	function (data, status) {    			        	
		bindForm(JSON.parse(data));
	});
    
	$("#add_new_record_modal").modal("show");
}

function loadnegara() {
	
    $.post("controller/controllernegara.php", { 
		id_mitra: id_mitra,
		id_negara: id_negara,
	    mode: 'loadnegara'
	},
function (data, status) {
		
		var arrdata = JSON.parse(data);		
		$('#ddlNegara').append(new Option('ALL', '', true, true));
		
		$.each(arrdata, function (index, value) {
           $('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara + '</option>');
		   //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
        }); 
		
		$("#ddlNegara").select2({
				//    placeholder: "SELECT ORIGIN COUNTRY",
			width: '100%'
        });		
	});
}

function loadmitra() {
	
    $.post("controller/controllermitra.php", { 
		id_mitra: id_mitra,
		id_negara: id_negara,
	    mode: 'loadmitra'
	},
	function (data, status) {
		
		var arrdata = JSON.parse(data);		
		$('#ddlMitra').append(new Option('ALL', '', true, true));
		
		$.each(arrdata, function (index, value) {
           $('#ddlMitra').append('<option value="' + value.id + '">' + value.nama_mitra + '</option>');
		   //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
        }); 
		
		$("#ddlMitra").select2({				
			width: '100%'
        });		
	});
}

function loadprovinsi() {
	
    $.post("controller/controllerprovinsi.php", { 
		mode: 'loadprovinsi'
	},
	function (data, status) {
		
		var arrdata = JSON.parse(data);		
		$('#ddlProvinsi').append(new Option('ALL', '', true, true));
		
		$.each(arrdata, function (index, value) {
           $('#ddlProvinsi').append('<option value="' + value.id + '" data-lati="'+value.lati+'" data-longi="'+value.longi+'">' + value.nama_provinsi + '</option>');		
        }); 
		
		$("#ddlProvinsi").select2({				
			width: '100%'
        });		
	});
}



$(document).ready(function () {    
	initializeTable();
    //readRecords(); // calling function	
	loadnegara();
	loadmitra();
	loadprovinsi();
	
	$("#ddlNegara").change(function () {			
		if(this.value != '')	{
			table.rows().column(1).search("^" + this.value + "$", true, false, true).draw(); 
		}
		else{
			table.search( '' ).columns().search( '' ).draw();
		}
		loadmarker();
		if(this.value != '')
			$("#spnegara").html($(this).find("option:selected").text());
		else
			$("#spnegara").html('');
	});
			
	$("#ddlMitra").change(function () {		
		if(this.value != '')	{
			table.rows().column(2).search("^" + this.value + "$", true, false, true).draw(); 
		}
		else{
			table.search( '' ).columns().search( '' ).draw();
		}
		loadmarker();
		if(this.value != '')
			$("#spmitra").html($(this).find("option:selected").text());
		else
			$("#spmitra").html('');
	});
	
	$("#ddlProvinsi").change(function () {
		id_provinsi = this.value;				
		readRecords();
		loadmarker();
		if(id_provinsi !=''){
			$("#splokasi").html($(this).find("option:selected").text());			
			var lati = $(this).find(':selected').data('lati');
			var longi = $(this).find(':selected').data('longi');
			var pt = new google.maps.LatLng(lati, longi);
			map.setCenter(pt);				
			map.setZoom(9);
		}		
		else{
			$("#splokasi").html('All Indonesia');			
			var pt = new google.maps.LatLng(-2.2459632,116.2409634)
			map.setCenter(pt);
			map.setZoom(5);
		}
	});

	$('#add_new_record_modal').on('hidden.bs.modal', function (e) { 	
		resetForm();		
	}) 
});

</script>
		  