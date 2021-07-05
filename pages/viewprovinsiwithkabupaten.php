<?php
    include "authorizationadmin.php";
?>
  <div>   
  <h2>Master Data Provinsi </h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>           
   <br />
   <br />
   <div id="result" style="width:100%" class="table-responsive">
   <table id="tblprovinsi" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                   <th style="vertical-align: middle;">No.</th>
                   <th style="vertical-align: middle;">Id.</th>
                    <th style="vertical-align: middle;">Kode Provinsi</th>
                    <th style="vertical-align: middle;">Nama Provinsi</th>                    
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
   <form role="form" id="myform" novalidate>      
    <label>Kode Provinsi</label>
    <input type="text" name="kode_provinsi" id="kode_provinsi" class="form-control" required/>
    <br />
    <label>Nama Provinsi</label>
    <input type="text" name="nama_provinsi" id="nama_provinsi" class="form-control" required />
    <br />
    <input type="hidden" name="id" id="id" />
    <input type="hidden" id="mode" name="mode" value="save">
    </form>
    <div class="tab-content">
    <div class="tab-pane active" id="mhs">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					Data Kabupaten
					</a>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                    <button type="button" class="btn btn-xs btn-primary" onclick="addKabupaten()"><i class="fas fa-plus" aria-hidden="true"></i> Add </button>   
                    
                    <div id="divAddKabupaten" style="display:none; margin-top:10px"> 
                            
                        <label>Nama Kabupaten</label>
                        <input type="text" name="nama_kabupaten" id="nama_kabupaten" class="form-control" required />
                        <br />
                        <button type="button" class="btn btn-xs btn-primary" onclick="saveKabupaten()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
                        <button type="button" class="btn btn-xs btn-default" onclick="cancelKabupaten()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
                    </div>
                    <div id="divkabupaten" style="width:100%; margin-top:10px" class="table-responsive">
                        <table id="tblkabupaten" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                        <th style="vertical-align: middle;">No.</th>
                                            <th style="vertical-align: middle;">Nama Kabupaten</th>                                        
                                            <th style="vertical-align: middle;">Hapus</th>    
                                        </tr>
                                    </thead>
                                </table>
                        </div>                      
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

    
   </div>
   <div class="modal-footer">    
    <button type="button" class="btn btn-default" onclick="closeModal()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
    <button type="button" class="btn btn-primary" onclick="save()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
   </div>   
  </div>
 </div>
</div>

<script>
var table;
var tableKab;
var dataKabupaten = [];
var id_kabupaten = 0;
function resetForm(){
	$("#id").val("");
    $('#kode_provinsi').val(''); 
    $('#nama_provinsi').val(''); 
    $('#nama_kabupaten').val('');
    dataKabupaten.splice(0, dataKabupaten.length);
    tableKab.clear().draw();
}

function bindForm(data){	
    $("#id").val(data.id);
    $('#kode_provinsi').val(data.kode_provinsi); 
    $('#nama_provinsi').val(data.nama_provinsi);	
}

function addKabupaten(){
    $('#divAddKabupaten').show();
}
function saveKabupaten(){
    
    if ( $('#nama_kabupaten')[0].checkValidity()){
        var nama_kabupaten = $('#nama_kabupaten').val();
        var obj = {
            'nama_kabupatenkota': nama_kabupaten
        }              
        
        dataKabupaten.push(obj);
        tableKab.clear().draw();
        tableKab.rows.add(dataKabupaten).draw();
        $('#divAddKabupaten').hide();
        $('#nama_kabupaten').val('');
    } else
        $('#nama_kabupaten')[0].reportValidity();  
}

function cancelKabupaten(){    
    $('#nama_kabupaten').val('');
    $('#divAddKabupaten').hide();
}

function closeModal(){    
    resetForm();
    $('#modal').modal('hide'); 
}

function save(){
    if ($("form")[0].checkValidity()){
        
        $.ajax({
            url : "controller/controllerprovinsi.php",    
            method:"POST",     
            data: {
                mode: "savewithkabupaten",
                kode_provinsi: $('#kode_provinsi').val(), 				   
                nama_provinsi: $('#nama_provinsi').val(), 				   
                id: $('#id').val(), 				   
                kabupaten: JSON.stringify(dataKabupaten)
			},
            success:function(data){     
                swal("Success", data.trim(), "success");
                resetForm();
                $('#modal').modal('hide'); 
                loadProvinsi();    
            }
        });
    }
    else
        $("form")[0].reportValidity();  
 }

 function loadProvinsi(){
    $.ajax({
        url : "controller/controllerprovinsi.php",
            type: "POST",
            data: {                
                mode: "loadprovinsi",
            },
            success: function (json) {
                var data = JSON.parse(json);                
                table.clear().draw();
                if (data != null) 
                   table.rows.add(data).draw();
            },
        });
 }

 function loadKabupaten(id_provinsi){
     debugger;
    $.ajax({
        url : "controller/controllerkabupatenkota.php",
            type: "POST",
            data: {          
                id_provinsi: id_provinsi,      
                mode: "loadkabupatenkota",
            },
            success: function (json) {
                dataKabupaten = JSON.parse(json);                
                tableKab.clear().draw();
                if (dataKabupaten != null) 
                   tableKab.rows.add(dataKabupaten).draw();
            },
        });
 }

 function initializeTableKabupaten() 
 {    
    tableKab = $("#tblkabupaten").DataTable({
            serverSide: false,
            processing: false,
            sDom: 'lrtip',
            lengthChange: false,
            columns: [
                { data: null }, 
                { data: "nama_kabupatenkota" },                
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>'
                }
            ],            
            pageLength: 5,
            autoWidth:false,
            responsive:true 
        });  

        tableKab.on( 'order.dt search.dt', function () {
                tableKab.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
 }

 function initializeTable() 
 {    
    table = $("#tblprovinsi").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url : "controller/controllerprovinsi.php", 
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "loadprovinsi",
                },
            },
            columns: [
                { data: null }, 
                { data: "id" }, 
                { data: "kode_provinsi" }, 
                { data: "nama_provinsi" }, 
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
    initializeTableKabupaten();

 $('#modal_button').click(function(){
     resetForm();
    $('#modal').modal('show');     
    $('.modal-title').text("Tambah Provinsi");     
 });

 $('#tblprovinsi').on('click', '.update', function (e) {
     debugger;
    var data = table.row( $(this).closest('tr') ).data();    
    var id = data.id;
    $.ajax({
        url:"controller/controllerprovinsi.php",   
        method:"POST",    
        data:{
            id:id, 
            mode:"getone"
        },
    dataType:"json",  
    success:function(data){
        bindForm(data);        
        loadKabupaten(data.id);
        $('#modal').modal('show');
        $('.modal-title').text("Update Provinsi");         
    }   
  });
        
});


$('#tblprovinsi').on('click', '.delete', function (e) {
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
                url:"controller/controllerprovinsi.php",   
                method:"POST",     
                data:{
                    id:id, 
                    mode:'delete'
                }, 
                success:function(data){
                    loadProvinsi();  
                    swal(data.trim(), {
                        icon: "success",
                    });
                }
            });
    } else {
        
    }
    });
});

$('#tblkabupaten').on('click', '.delete', function (e) {
    debugger;
    var data = tableKab.row( $(this).closest('tr') ).data();    
    var nama = data.nama_kabupatenkota;    
    
    dataKabupaten = $.grep(dataKabupaten,
                function(o,i) { return o.nama_kabupatenkota === nama; },
                true);
    tableKab.clear().draw();
    tableKab.rows.add(dataKabupaten).draw();

});



});
</script>