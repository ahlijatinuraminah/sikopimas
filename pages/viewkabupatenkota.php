
  <?php
    include "authorizationadmin.php";
?>
  <div>   
  <h2>Master Data Kabupaten </h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>           
   <br />
   <br />
   <div id="result" style="width:100%" class="table-responsive">
		<table id="tblKabupaten" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                   <th style="vertical-align: middle;">No.</th>
                   <th style="vertical-align: middle;">Id.</th>
                   <th style="vertical-align: middle;">Nama Provinsi</th>   
                    <th style="vertical-align: middle;">Nama Kabupaten</th>                    
                    <th style="vertical-align: middle;">Latitude</th>                    
                    <th style="vertical-align: middle;">Longitude</th>                                                     
                    <th style="vertical-align: middle;">Ubah</th>                    
                    <th style="vertical-align: middle;">Hapus</th>                    
                    
                </tr>
            </thead>
        </table>
   </div>
  </div>
  
  <!-- This is Modal. It will be use for Create new Records and Update Existing Records!-->
<div id="modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Tambah Data</h4> 
   </div>
   <div class="modal-body">
   <form role="form" id="myform">     
   <div class="form-group">
            <label>Provinsi</label>
            <select id="id_provinsi" name="id_provinsi"></select>
        </div>
        <div class="form-group">
            <label>Nama Kabupaten</label>
            <input type="text" name="nama_kabupatenkota" id="nama_kabupatenkota" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="lati" id="lati" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longi" id="longi" class="form-control" required />
        </div>

    <input type="hidden" name="id" id="id" />
    <input type="hidden" id="mode" name="mode" value="save">
    </form>
   </div>
   <div class="modal-footer">    
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
    <button type="button" class="btn btn-primary" onclick="save()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
   </div>   
  </div>
 </div>
</div>

<script>
var table;
function resetForm(){
	$("#id").val("");
    $('#id_provinsi').val('').trigger('change'); 
    $('#nama_kabupatenkota').val(''); 
    $('#lati').val(''); 
    $('#longi').val(''); 
}

function bindForm(data){	
    $("#id").val(data.id);
    $('#id_provinsi').val(data.id_provinsi).trigger('change'); 
    $('#nama_kabupatenkota').val(data.nama_kabupatenkota);	
    $('#lati').val(data.lati); 
    $('#longi').val(data.longi); 
}

function save(){
    if ($("form")[0].checkValidity()){
        var objData = $('form#myform').serialize();	
        $.ajax({
            url : "controller/controllerkabupatenkota.php",    
            method:"POST",     
            data: objData,            
            dataType:"json",  
            success:function(data){     
                showMessage(data);
                resetForm();
                $('#modal').modal('hide'); 
                loadKabupaten();    
            }
        });
    }
    else
        $("form")[0].reportValidity();  
 }

 function loadKabupaten(){
    $.ajax({
        url : "controller/controllerkabupatenkota.php",
            type: "POST",
            data: {                
                mode: "loadallkabupatenkota",
            },
            success: function (json) {
                var data = JSON.parse(json);                
                table.clear().draw();
                if (data != null) 
                   table.rows.add(data).draw();
            },
        });
 }

 function loadProvinsi() {
        $.post(
            "controller/controllerprovinsi.php",
            {
                mode: 'loadprovinsi',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#id_provinsi").append(new Option("Pilih Provinsi", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#id_provinsi").append('<option value="' + value.id + '">' + value.nama_provinsi + "</option>");
                });

                $("#id_provinsi").select2({
                    width: "100%",
                });
            }
        );
    }

 function initializeTable() 
 {    
    table = $("#tblKabupaten").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url : "controller/controllerkabupatenkota.php", 
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "loadallkabupatenkota",
                },
            },
            columns: [
                { data: null }, 
                { data: "id" }, 
                { data: "nama_provinsi" }, 
                { data: "nama_kabupatenkota" }, 
                { data: "lati" }, 
                { data: "longi" },                 
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
    loadProvinsi();

 $('#modal_button').click(function(){
     resetForm();
    $('#modal').modal('show');     
    $('.modal-title').text("Tambah Kabupaten");     
 });

 $('#tblKabupaten').on('click', '.update', function (e) {
    var data = table.row( $(this).closest('tr') ).data();        
    bindForm(data);
    $('#modal').modal('show');
    $('.modal-title').text("Update Kabupaten");      
});


$('#tblKabupaten').on('click', '.delete', function (e) {
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
                url:"controller/controllerkabupatenkota.php",   
                method:"POST",     
                data:{
                    id:id, 
                    mode:'delete'
                }, 
                dataType:"json",  
                success:function(data){     
                    showMessage(data);
                    loadKabupaten();                      
                }
            });
    } else {
        
    }
    });
});


});
</script>