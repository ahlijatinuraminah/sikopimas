<div class="tab-content">
    <div class="tab-pane active" id="mhs">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <a data-toggle="collapse" data-parent="#accordion" href="#collapsemlo">
					Jejaring/Mitra Lokal
					</a>
                </div>
                <div id="collapsemlo" class="panel-collapse collapse">
                    <div class="panel-body">
                    <button type="button" class="btn btn-xs btn-primary" onclick="addMitraLokal()"><i class="fas fa-plus" aria-hidden="true"></i> Add </button>   
                    
                    <div id="divAddMitraLokal" style="display:none; margin-top:20px"> 
                            
                        <label>Mitra Lokal</label>
                        <select name="ddlMitraLokal" id="ddlMitraLokal" class="form-control" required></select>
                        <br />
                        <br />
                        <button type="button" class="btn btn-xs btn-primary" onclick="saveMitraLokal()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
                        <button type="button" class="btn btn-xs btn-default" onclick="cancelMitraLokal()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
                    </div>
                    <div id="divMitraLokal" style="width:100%; margin-top:10px" class="table-responsive">
                        <table id="tblMitraLokal" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                        <th style="vertical-align: middle;">No.</th>
                                        <th style="vertical-align: middle;">Id Mitra Lokal</th>                                        
                                            <th style="vertical-align: middle;">Nama Mitra Lokal</th>                                        
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

<script>
var tableMitraLokal;
var dataMitraLokal = [];
var id_kabupaten = 0;

function addMitraLokal(){
    $('#divAddMitraLokal').show();
}
function saveMitraLokal(){
    
    if ( $('#ddlMitraLokal')[0].checkValidity()){
        var id_mitralokal = $('#ddlMitraLokal').val();
        var nama_mitralokal = $('#ddlMitraLokal option:selected').text();
        var obj = {
            'id_mitralokal': id_mitralokal,
            'nama_mitralokal': nama_mitralokal
        }              
        
        dataMitraLokal.push(obj);
        tableMitraLokal.clear().draw();
        tableMitraLokal.rows.add(dataMitraLokal).draw();
        $('#divAddMitraLokal').hide();
        $('#ddlMitraLokal').val('').trigger('change');
    } else
        $('#ddlMitraLokal')[0].reportValidity();  
}

function cancelMitraLokal(){    
    $('#ddlMitraLokal').val('').trigger('change');
    $('#divAddMitraLokal').hide();
}

function loadmitralokal() { // function ini harus dipanggil di event button update click di tabel organisasi
        $.post(
            "controller/controllermitralokal.php",
            {
                   mode: "loadmitralokal",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlMitraLokal").append(new Option("Pilih Mitra Lokal", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlMitraLokal").append('<option value="' + value.id + '">' + value.nama_mitralokal + "</option>");                 
                });

                $("#ddlMitraLokal").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }

function loadmitralokalorganisasi(id_organisasi){ // function ini harus dipanggil di event button update click di tabel organisasi
     debugger;
    $.ajax({
        url : "controller/controllermitralokalorganisasi.php",
            type: "POST",
            data: {          
                id_organisasi: id_organisasi,      
                mode: "load",
            },
            success: function (json) {
                dataMitraLokal = JSON.parse(json);                
                tableMitraLokal.clear().draw();
                if (dataMitraLokal != null) 
                   tableMitraLokal.rows.add(dataMitraLokal).draw();
            },
        });
 }

 function initializeTableMitraLokal() 
 {    
    tableMitraLokal = $("#tblMitraLokal").DataTable({
            serverSide: false,
            processing: false,
            sDom: 'lrtip',
            lengthChange: false,
            columns: [
                { data: null }, 
                { data: "id_mitralokal" },                
                { data: "nama_mitralokal" },                
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>'
                }
            ],   
            columnDefs: [
                { targets: [1], visible: false },                
            ],         
            pageLength: 5,
            autoWidth:false,
            responsive:true 
        });  

        tableMitraLokal.on( 'order.dt search.dt', function () {
                tableMitraLokal.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
 }
 $(document).ready(function(){
    
    initializeTableMitraLokal();    
    
$('#tblMitraLokal').on('click', '.delete', function (e) {
    debugger;
    var data = tableMitraLokal.row( $(this).closest('tr') ).data();    
    
    dataMitraLokal = $.grep(dataMitraLokal,
                function(o,i) { return o.id_mitralokal === data.id_mitralokal; },
                true);
    tableMitraLokal.clear().draw();
    tableMitraLokal.rows.add(dataMitraLokal).draw();

});

});

</script>
