<div>   
  <h2>Data Organisasi </h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>           
   <br />
   <br />
   <div id="result"style ="width:100%" class="table-responsive">
		<table id="tblorganisasi" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
					<th style="vertical-align: middle;">No.</th>
					<th style="vertical-align: middle;">Id.</th>
                    <th style="vertical-align: middle;">Nama Organisasi</th>
                    <th style="vertical-align: middle;">Negara Asal</th>                  
                    <th style="vertical-align: middle;">Alamat</th>  
					<th style="vertical-align: middle;">Tingkat Kerawanan</th>   
					<th style="vertical-align: middle;">Ubah</th>                    
                    <th style="vertical-align: middle;">Hapus</th>                    
                    
			   </tr>
            </thead>
		</table>
   </div>
</div>
  
  <!-- This is Modal. It will be use for Create new Records and Update Existing Records!-->
<div id="modal" class="modal fade">
 <div class="modal-dialog" style="width:60%">
  <div class="modal-content ">
   <div class="modal-header ">
    <h4 class="modal-title">Tambah Data</h4>    
   </div>
   <div class="modal-body ">
   <form role="form" id="myform">         
   <div class="row">
   <div id="diverror" class="col-md-12"></div> 
    <div class="col-md-6">    
    <div class="form-group">
		<label>Nama Organisasi</label>
			<input type="text" name="nama_organisasi" id="nama_organisasi" class="form-control" required />
		</div>
        <div class="form-group">
		<label>Kepala Perwakilan</label>
			<input type="text" name="representasi" id="representasi" class="form-control" required />
		</div>
        <div class="form-group">
            <div class="form-group col-md-6" style="padding-left:0px">                
				<label>Tahun berdiri</label>
                <select class="form-control" name="tahun_berdiri" id="tahun_berdiri">
					<option value=""></option>
					<?php
					$thn_skr = date('Y');
					for ($x = $thn_skr; $x >= 1850; $x--) {
					?>
						<option value="<?php echo $x ?>"><?php echo $x ?></option>
					<?php
					}
					?>
				</select>
			</div>         
            <div class="form-group col-md-6">
                <label>Tahun di Indonesia</label>
                <select class="form-control" name="tahun_beroperasi" id="tahun_beroperasi">
					<option value=""></option>
					<?php
					$thn_skr = date('Y');
					for ($x = $thn_skr; $x >= 1945; $x--) {
					?>
						<option value="<?php echo $x ?>"><?php echo $x ?></option>
					<?php
					}
					?>
				</select>
			</div>
        </div>
        <div class="form-group">
        <label>Alamat</label>
			<textarea rows="4" name="alamat" id="alamat" class="form-control" required></textarea>
	    </div>
        <div class="form-group">
		<label>Bidang Kerja</label>
            <select id="bidangkerjaorganisasi" multiple="multiple" class="form-control" required></select>
		</div>

    </div>
    <div class="col-md-6">        
        <div class="form-group">
		<label>Asal Negara</label>
			<select id="id_negara_asal" class="form-control" required></select>
		</div>
        
        <div class="form-group">    
        <label>Mitra</label>
			<select id="id_mitra" name="ddlMitra" class="form-control" name="id_mitra" required>
				
			</select>
	    </div>
        <div class="form-group">
		<label>Data Collection</label>
			<select id="id_datacollection" class="form-control" name="id_datacollection" required>
				
			</select>
	    </div>
        <div class="form-group">
		<label>Status Perizinan</label>
			<select type="text" name="id_statusperizinan" id="id_statusperizinan" class="form-control" required></select>
	    </div>
        <div class="form-group">
		<label>Anggaran</label>
			<input type="text" name="anggaran" id="anggaran" class="form-control" required />            
	    </div>
        <div class="form-group">
		<label>Mitra Lokal</label>
            <select id="mitralokalorganisasi" multiple="multiple" class="form-control" required></select>
		</div>
    </div>    
   </div>
 		<input type="hidden" name="id" id="id" />
		<input type="hidden" id="mode" name="mode" value="save">
    </form>
   </div>
   <div class="modal-footer">    
    <button type="button" class="btn btn-default" onclick="cancel()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
    <button type="button" class="btn btn-primary" onclick="save()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
   </div>   
  </div>
 </div>
</div>
<script>
    // Save Record
    var table;
    var errorMessage ='';

    const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
    });


    function showError(){
    var errorAlert = '<div class="alert alert-danger alert-dismissible">'+
						'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
						errorMessage +
						'</div>';
	$('#diverror').html(errorAlert);
    errorMessage = '';				    	

}
    function resetForm(){
	$("#id").val("");
    $('#nama_organisasi').val(''); 
    $('#representasi').val(''); 
	$('#alamat').val(''); 
    $('#id_negara_asal').val('').trigger('change');
    $('#id_mitra').val('').trigger('change');
	$('#id_datacollection').val('').trigger('change');
    $('#tahun_berdiri').val('');
	$('#tahun_beroperasi').val('');
	$('#id_statusperizinan').val('').trigger('change');
	$('#anggaran').val('');    
    errorMessage = '';		
    $('#diverror').hide();		    	
/*
    dataMitraLokal = [];
    tableMitraLokal.clear().draw();
    $('#ddlMitraLokal').val('').trigger('change'); 

    dataLokasi = [];
    dataKabupaten = [];
    tableLokasi.clear().draw();
    $('#ddlprovinsi').val('').trigger('change'); 
    $('#ddlKabupaten').empty();

    dataBidangKerja = [];
    tableBidangKerja.clear().draw();
    $('#ddlBidangKerja').val('').trigger('change'); 

    dataIsu = [];
    tableIsu.clear().draw();
    $('#ddlIsu').val('').trigger('change'); 

    dataDonor = [];
    tableDonor.clear().draw();
    $('#ddlDonor').val('').trigger('change'); 
    $('#ddlJumlah').val('');
    */
}

function bindForm(data){	
    $("#id").val(data.id);
    $('#nama_organisasi').val(data.nama_organisasi); 
    $('#representasi').val(data.representasi);
    $('#id_negara_asal').val(data.id_negara_asal).trigger('change');
    $('#id_mitra').val(data.id_mitra).trigger('change');
	$('#alamat').val(data.alamat);
	$('#id_datacollection').val(data.id_datacollection).trigger('change');
	$('#tahun_beroperasi').val(data.tahun_beroperasi);
    $('#tahun_berdiri').val(data.tahun_berdiri);
	$('#id_statusperizinan').val(data.id_statusperizinan).trigger('change');
	$('#anggaran').val(data.anggaran);
    $('#bidangkerjaorganisasi').val(data.bidangkerjaorganisasi).trigger('change');
    $('#mitralokalorganisasi').val(data.mitralokalorganisasi).trigger('change');

}
function cancel(){
    resetForm();
    $('#modal').modal('hide'); 
}

function isValidDetail(){
    var isValid = true;
    if(dataLokasi.length == 0){    
        isValid = false;
        errorMessage = "Lengkapi data lokasi organisasi <br>";
      // $('#collapse1').addClass('in');
    }
    if(dataIsu.length == 0){    
        isValid = false;
        errorMessage += "Lengkapi data isu sensitif <br>";
        //$('#collapse2').addClass('in');
    }

    if(dataBidangKerja.length == 0){    
        isValid = false;
        errorMessage += "Lengkapi data bidang kerja <br>";
        //$('#collapse3').addClass('in');
    }
    if(dataMitraLokal.length == 0){    
        isValid = false;
        errorMessage += "Lengkapi data mitra lokal <br>";
        //$('#collapsemlo').addClass('in');
    }
    if(dataDonor.length == 0){    
        isValid = false;
        errorMessage += "Lengkapi data donor<br>";
        //$('#collapsedonor').addClass('in');
    }


    return isValid;

}
function save(){
    if (!$("form")[0].checkValidity()){
        $("form")[0].reportValidity();  
    } //else if(!isValidDetail()){
        //showError();        
   // }
    else{
        
        $.ajax({
            url : "controller/controllerorganisasi.php",    
            method:"POST",     
            data: {
                mode: "save",
                nama_organisasi: $('#nama_organisasi').val(), 				   
                alamat: $('#alamat').val(), 				   
                representasi: $('#representasi').val(), 	
                tahun_berdiri: $('#tahun_berdiri').val(), 	
                tahun_beroperasi: $('#tahun_beroperasi').val(), 	
                id_negara_asal: $('#id_negara_asal').val(), 	
                id_mitra: $('#id_mitra').val(), 	
                id_datacollection: $('#id_datacollection').val(), 	
                id_statusperizinan: $('#id_statusperizinan').val(), 
                anggaran: $('#anggaran').val(), 
                id: $('#id').val(), 				   
                mitralokalorganisasi: $('#mitralokalorganisasi').val(),//JSON.stringify(dataMitraLokal),
                //lokasiprovinsiorganisasi: JSON.stringify(dataLokasi),
                bidangkerjaorganisasi: $('#bidangkerjaorganisasi').val(),//JSON.stringify(dataBidangKerja),
                //isuorganisasi: JSON.stringify(dataIsu),
                //donororganisasi: JSON.stringify(dataDonor),
                //lokasikabupatenorganisasi: JSON.stringify(dataKabupaten)
			},
            success:function(data){     
                console.log(data);
                swal("Success", data.trim(), "success");
                resetForm();
                $('#modal').modal('hide'); 
                loadOrganisasi();    
            }
        });
    }    
 }

 function loadOrganisasi(){
    $.ajax({
        url : "controller/controllerorganisasi.php",
            type: "POST",
            data: {                
                mode: "read",
            },
            success: function (json) {
                var data = JSON.parse(json);                
                table.clear().draw();
                if (data != null) 
                   table.rows.add(data).draw();
            },
        });
 }


function loadnegara() {
        $.post(
            "controller/controllernegara.php",
            {
                   mode: "loadnegara",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#id_negara_asal").append(new Option("Pilih Negara Asal", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#id_negara_asal").append('<option value="' + value.id + '">' + value.nama_negara + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#id_negara_asal").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }

function loadmitra() {
        $.post(
            "controller/controllermitra.php",
            {
                   mode: "loadmitra",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#id_mitra").append(new Option("Pilih Mitra", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#id_mitra").append('<option value="' + value.id + '">' + value.nama_mitra + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#id_mitra").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }
	
	function loaddatacollection() {
        $.post(
            "controller/controllerdatacollection.php",
            {
                   mode: "loaddatacollection",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#id_datacollection").append(new Option("Pilih Data Collection", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#id_datacollection").append('<option value="' + value.id + '">' + value.deskripsi + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#id_datacollection").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }
function loadstatusperizinan() {
        $.post(
            "controller/controllerstatusperizinan.php",
            {
                   mode: "loadstatusperizinan",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#id_statusperizinan").append(new Option("Pilih Status Perizinan", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#id_statusperizinan").append('<option value="' + value.id + '">' + value.deskripsi + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#id_statusperizinan").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }

    function loadBidangKerja() {
        $.post(
            "controller/controllerbidangkerja.php",
            {
                mode: 'loadbidangkerja',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $.each(arrdata, function (index, value) {
                    $("#bidangkerjaorganisasi").append('<option value="' + value.id + '">' + value.nama_bidang + "</option>");
                });

                $("#bidangkerjaorganisasi").select2({
                    width: "100%",
                    placeholder: 'Pilih bidang kerja'
                });
            }
        );
    }

    function loadmitralokal() { // function ini harus dipanggil di event button update click di tabel organisasi
        $.post(
            "controller/controllermitralokal.php",
            {
                   mode: "loadmitralokal",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                
                $.each(arrdata, function (index, value) {
                    $("#mitralokalorganisasi").append('<option value="' + value.id + '">' + value.nama_mitralokal + "</option>");                 
                });

                $("#mitralokalorganisasi").select2({
                    width: "100%",
                    placeholder:'Pilih Mitra Lokal'
                });
            }
        );
    }

    
 function initializeTable() 
 {    
    table = $("#tblorganisasi").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url : "controller/controllerorganisasi.php", 
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "read",
                },
            },
            columns: [
                { data: null }, 
                { data: "id" }, 
                { data: "nama_organisasi" }, 
                { data: "nama_negara" },
				{ data: "alamat" }, 
				{ data: "tingkat_kerawanan" },
				
                {
                    data: null,
                    className: "center",
                    defaultContent: '<button type="button" class="btn btn-warning btn-xs update"><i class="fas fa-edit" aria-hidden="true"></i> Ubah</button>'
                },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> Hapus</button></td>'
                }
            ],
            columnDefs: [
                { targets: [1], visible: false },                
            ],  
            pageLength: 10,
            autoWidth:false,
            responsive:true 
        });  

        table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
 }


$(document).ready(function(){
    initializeTable(); 
    loadnegara();
	loadmitra();
	loadstatusperizinan();
	loaddatacollection();
    loadBidangKerja();
    loadmitralokal();

 $('#modal_button').click(function(){
     resetForm();
    $('#modal').modal('show');     
    $('.modal-title').text("Tambah Organisasi");     
 });

 $('#tblorganisasi').on('click', '.update', function (e) {
    var data = table.row( $(this).closest('tr') ).data();    
    var id = data.id;

    //loadBidangKerjaOrganisasi(data.id);        
    //loadmitralokalorganisasi(data.id);      
    //loadIsuOrganisasi(data.id);
    //loadProvinsiOrganisasi(data.id);
    //loaddonororganisasi(data.id);
    $.ajax({
        url:"controller/controllerorganisasi.php",   
        method:"POST",    
        data:{
            id:id, 
            mode:"getone"
        },
    dataType:"json",  
    success:function(data){
        debugger;
        bindForm(data);
        $('#modal').modal('show');
        $('.modal-title').text("Update Organisasi");         
    }   
  });
        
});


$('#tblorganisasi').on('click', '.delete', function (e) {
    var data = table.row( $(this).closest('tr') ).data();    
    var id = data.id;
    swal({
    title: "Apakah anda yakin akan menghapus data ini?",    
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        $.ajax({
                url:"controller/controllerorganisasi.php",   
                method:"POST",     
                data:{
                    id:id, 
                    mode:'delete'
                }, 
                success:function(data){
                    loadOrganisasi();  
                    swal(data.trim(), {
                        icon: "success",
                    });
                }
            });
    } else {
        
    }
    });
});


});
</script>