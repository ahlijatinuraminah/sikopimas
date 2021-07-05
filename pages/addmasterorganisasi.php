<ul class="nav nav-tabs nav-justified">
    <li class="active"><a href="#lokasikerja" data-toggle="tab">LokasiKerja</a></li>
    <li><a href="#bidangkerja" data-toggle="tab">Bidang Kerja</a></li>
    <li><a href="#isu" data-toggle="tab">Isu Sensitif</a></li>
    <li><a href="#mitralokal" data-toggle="tab">Mitra Lokal</a></li>
    <li><a href="#donor" data-toggle="tab">Donor</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="lokasikerja">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <button type="button" class="btn btn-xs btn-primary" onclick="addLokasi()"><i class="fas fa-plus" aria-hidden="true"></i> Add</button>

<div id="divAddLokasi" style="display: none; margin-top: 10px;">
    <div class="form-group">
        <label>Nama Provinsi</label>
        <select id="ddlProvinsi" name="ddlProvinsi" class="form-control" required></select>
    </div>
    <div id="divKabupaten" class="form-group" style="display:none">
        <label>Nama Kabupaten</label>
        <select id="ddlKabupaten" name="ddlKabupaten" class="form-control" required multiple="multiple"></select>
    </div>
    <button type="button" class="btn btn-xs btn-primary" onclick="saveLokasi()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
    <button type="button" class="btn btn-xs btn-default" onclick="cancelLokasi()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
</div>
<div id="divlokasi" style="width: 100%; margin-top: 10px;" class="table-responsive">
    <table id="tbllokasi" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No.</th>
                <th style="vertical-align: middle;">Id</th>
                <th style="vertical-align: middle;">Nama Provinsi</th>
                <th style="vertical-align: middle;">Nama Kabupaten</th>                                        
                <th style="vertical-align: middle;">Hapus</th>
            </tr>
        </thead>
    </table>
</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="bidangkerja">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <button type="button" class="btn btn-xs btn-primary" onclick="addBidangKerja()"><i class="fas fa-plus" aria-hidden="true"></i> Add</button>
                        <br>
                        <div id="divAddBidangKerja"  style="display: none; margin: 10px 0;padding-left:0px">
                            <div class="form-group">
                                <label>Nama Bidang Kerja</label>
                                <select id="ddlBidangKerja" class="form-control" required></select>
                            </div>
                            <button type="button" class="btn btn-xs btn-primary" onclick="saveBidangKerja()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
                            <button type="button" class="btn btn-xs btn-default" onclick="cancelBidangKerja()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
                        </div>
                        <div id="divbidang_kerja" style="width: 100%; margin-top: 10px;" class="table-responsive">
                            <table id="tblbidang_kerja" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;">No.</th>
                                        <th style="vertical-align: middle;">Id Bidang Kerja</th>
                                        <th style="vertical-align: middle;">Nama Bidang Kerja</th>
                                        <th style="vertical-align: middle;">Hapus</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="isu">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <button type="button" class="btn btn-xs btn-primary" onclick="addIsu()"><i class="fas fa-plus" aria-hidden="true"></i> Add</button>

<div id="divAddIsu" style="display: none; margin-top: 10px;">
    <div class="form-group col-md-6" style="padding-left:0px">
        <label>Nama Isu</label>
        <select id="ddlIsu" class="form-control" required></select>
    </div>
    <div class="form-group col-md-6">
        <label>Keterangan</label>
        <input type="text" name="keterangan" id="keterangan" class="form-control" required />
    </div>
    <button type="button" class="btn btn-xs btn-primary" onclick="saveIsu()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
    <button type="button" class="btn btn-xs btn-default" onclick="cancelIsu()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
</div>
<div id="divisu" style="width: 100%; margin-top: 10px;" class="table-responsive">
    <table id="tblisu" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No.</th>
                <th style="vertical-align: middle;">Id Isu</th>
                <th style="vertical-align: middle;">Nama Isu</th>
                <th style="vertical-align: middle;">Keterangan</th>
                <th style="vertical-align: middle;">Hapus</th>
            </tr>
        </thead>
    </table>
</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="mitralokal">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <button type="button" class="btn btn-xs btn-primary" onclick="addMitraLokal()"><i class="fas fa-plus" aria-hidden="true"></i> Add </button>   
                    <br>
                    <div id="divAddMitraLokal" class="col-md-12" style="display: none; margin: 10px 0;padding-left:0px">
                            
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
                <div class="tab-pane" id="donor">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <button type="button" class="btn btn-xs btn-primary" onclick="addDonor()"><i class="fas fa-plus" aria-hidden="true"></i> Add </button>   
                    
                    <div id="divAddDonor" style="display:none; margin-top:10px"> 
                        <div class="form-group col-md-6" style="padding-left:0px">
                            <label>Donor</label>
                            <select name="ddlDonor" id="ddlDonor" class="form-control" required></select>
                        </div>
                        <div class="form-group col-md-6">    
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required />
                        </div>
                        <button type="button" class="btn btn-xs btn-primary" onclick="saveDonor()"><i class="fas fa-save" aria-hidden="true"></i> Save</button>
                        <button type="button" class="btn btn-xs btn-default" onclick="cancelDonor()"><i class="fas fa-times" aria-hidden="true"></i> Cancel</button>
                    </div>
                    <div id="divDonor" style="width:100%; margin-top:10px" class="table-responsive">
                        <table id="tblDonor" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;">No.</th>
                                    <th style="vertical-align: middle;">Id Donor</th>                                        
                                    <th style="vertical-align: middle;">Nama Donor</th>                                        
                                    <th style="vertical-align: middle;">Jumlah</th>     
                                    <th style="vertical-align: middle;">Hapus</th>    
                                </tr>
                            </thead>
                        </table>
                    </div>                
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
    var tableLokasi;
    var tableIsu;
    var tableBidangKerja;
    var tableMitraLokal;
    var tableDonor;
    var dataLokasi = [];
    var dataIsu = [];
    var dataBidangKerja = [];
    var dataMitraLokal = [];
    var dataDonor = [];
    var dataKabupaten = [];
    var id_kabupaten = 0;

    // LOKASI
    function addLokasi(){
        $('#divAddLokasi').show();        
        //loadKabupatenKota();
    }
    
    function loadProvinsi() {
        $.post(
            "controller/controllerprovinsi.php",
            {
                mode: 'loadprovinsi',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlProvinsi").append(new Option("Pilih Provinsi", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlProvinsi").append('<option value="' + value.id + '">' + value.nama_provinsi + "</option>");
                });

                $("#ddlProvinsi").select2({
                    width: "100%",
                });
            }
        );
    }

    function loadKabupatenKota(id_provinsi) {
        $.post(
            "controller/controllerkabupatenkota.php",
            {
                id_provinsi: id_provinsi,
                mode: 'loadkabupatenkota',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                
                $.each(arrdata, function (index, value) {
                    $("#ddlKabupaten").append('<option value="' + value.id + '">' + value.nama_kabupatenkota + "</option>");
                });

                $("#ddlKabupaten").select2({
                    width: "100%",
                });
            }
        );

    }

    function saveLokasi(){
        
        if ($('#ddlProvinsi')[0].checkValidity() && $('#ddlKabupaten')[0].checkValidity()){
            
            var id = 0;
            if (dataLokasi.length == 0)
                id++;
            else
                id = Number(dataLokasi[dataLokasi.length  - 1].id) +1;

            var id_provinsi = $('#ddlProvinsi').val();
            var nama_provinsi = $('#ddlProvinsi option:selected').text();
            var allkabupaten ='';
            
            $('#ddlKabupaten :selected').each(function(){                   
                allkabupaten += $(this).text() +'<br>';
                var objKab = {
                    'id_provinsi': id_provinsi,                
                    'id_kabupaten': $(this).val()                                
                }
                dataKabupaten.push(objKab);
            });


            var obj = {
                'id' : id,
                'id_provinsi': id_provinsi,                
                'nama_provinsi': nama_provinsi,
                'nama_kabupaten': allkabupaten,                                
            }              
            
            dataLokasi.push(obj);
            tableLokasi.clear().draw();
            tableLokasi.rows.add(dataLokasi).draw();
            $('#divAddLokasi').hide();
            $('#divKabupaten').hide();
            $('#ddlProvinsi').val('').trigger('change');
            $('#ddlKabupaten').empty();            
        } else {
            $('#ddlProvinsi')[0].reportValidity(); 
            $('#ddlKabupaten')[0].reportValidity(); 
        }
    }

    function cancelLokasi(){    
        $('#ddlProvinsi').val('').trigger('change');
        $('#ddlKabupaten').empty();
        $('#divAddLokasi').hide();
        $('#divKabupaten').hide();      
//        dataKabupaten = [];  
    }

    function initializeTableLokasi() {
        tableLokasi = $("#tbllokasi").DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_provinsi" },
                { data: "nama_provinsi" },                
                { data: "nama_kabupaten"},
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableLokasi
            .on("order.dt search.dt", function () {
                tableLokasi
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
            
    }

    function initializeTableKabupaten(id) {
        var idtable = 'tblchildprovinsi' + id;
        tableKabupaten = $("#"+idtable).DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_provinsi" },
                { data: "id_kabupaten" },
                { data: "nama_kabupaten" },                                
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1,2], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableKabupaten
            .on("order.dt search.dt", function () {
                tableKabupaten
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
            
    }

    // ISU
    function addIsu(){
        $('#divAddIsu').show();        
    }

    function loadIsu() {
        $.post(
            "controller/controllerisu.php",
            {
                mode: 'loadisu',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlIsu").append(new Option("Pilih Isu", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlIsu").append('<option value="' + value.id + '">' + value.nama_isu + "</option>");
                });

                $("#ddlIsu").select2({
                    width: "100%",
                });
            }
        );
    }

    
    function saveIsu(){
        if ($('#ddlIsu')[0].checkValidity() && $('#keterangan')[0].checkValidity()){
            var id = 0;
            if (dataIsu.length == 0)
                id++;
            else
                id = Number(dataIsu[dataIsu.length  - 1].id) +1;

            var id_isu = $('#ddlIsu').val();
            var nama_isu = $('#ddlIsu option:selected').text();
            var keterangan = $('#keterangan').val();
            var obj = {
                'id': id,
                'id_isu': id_isu,
                'nama_isu': nama_isu,
                'keterangan': keterangan,
            }              
            
            dataIsu.push(obj);
            tableIsu.clear().draw();
            tableIsu.rows.add(dataIsu).draw();
            $('#divAddIsu').hide();
            $('#ddlIsu').val('').trigger('change');
            $('#keterangan').val('');
        } else {
            $('#ddlIsu')[0].reportValidity(); 
            $('#keterangan')[0].reportValidity(); 
        }
    }

    function cancelIsu(){    
        $('#ddlIsu').val('').trigger('change');
        $('#keterangan').val('');
        $('#divAddIsu').hide();
    }

    function initializeTableIsu() {
        tableIsu = $("#tblisu").DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_isu" },
                { data: "nama_isu" },
                { data: "keterangan" },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableIsu
            .on("order.dt search.dt", function () {
                tableIsu
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    // BIDANG KERJA
    function addBidangKerja(){
        $('#divAddBidangKerja').show();        
    }

    function loadBidangKerja() {
        $.post(
            "controller/controllerbidangkerja.php",
            {
                mode: 'loadbidangkerja',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlBidangKerja").append(new Option("Pilih Bidang Kerja", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlBidangKerja").append('<option value="' + value.id + '">' + value.nama_bidang + "</option>");
                });

                $("#ddlBidangKerja").select2({
                    width: "100%",
                });
            }
        );
    }

    
    function saveBidangKerja(){
        if ($('#ddlBidangKerja')[0].checkValidity()){
            var id = 0;
            if (dataBidangKerja.length == 0)
                id++;
            else
                id = Number(dataBidangKerja[dataBidangKerja.length  - 1].id) +1;


            var id_bidangkerja = $('#ddlBidangKerja').val();
            var nama_bidang = $('#ddlBidangKerja option:selected').text();
            var obj = {
                'id':id,
                'id_bidangkerja':id_bidangkerja,
                'nama_bidang': nama_bidang
            }              
            
            dataBidangKerja.push(obj);
            tableBidangKerja.clear().draw();
            tableBidangKerja.rows.add(dataBidangKerja).draw();
            $('#divAddBidangKerja').hide();
            $('#ddlBidangKerja').val('').trigger('change');
        } else {
            $('#ddlBidangKerja')[0].reportValidity(); 
        }
    }

    function cancelBidangKerja(){    
        $('#ddlBidangKerja').val('').trigger('change');
        $('#divAddBidangKerja').hide();
    }

    function initializeTableBidangKerja() {
        tableBidangKerja = $("#tblbidang_kerja").DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_bidangkerja" },
                { data: "nama_bidang" },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableBidangKerja
            .on("order.dt search.dt", function () {
                tableBidangKerja
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    // MITRA LOKAL
    function addMitraLokal(){
        $('#divAddMitraLokal').show();
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
                    width: "100%",
                });
            }
        );
    }

    

    function saveMitraLokal(){
        if ( $('#ddlMitraLokal')[0].checkValidity()){
            var id = 0;
            if (dataMitraLokal.length == 0)
                id++;
            else
                id = Number(dataMitraLokal[dataMitraLokal.length  - 1].id) +1;

            var id_mitralokal = $('#ddlMitraLokal').val();
            var nama_mitralokal = $('#ddlMitraLokal option:selected').text();
            var obj = {
                'id':id,
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

    function initializeTableMitraLokal() {
        tableMitraLokal = $("#tblMitraLokal").DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_mitralokal" },
                { data: "nama_mitralokal" },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableMitraLokal
            .on("order.dt search.dt", function () {
                tableMitraLokal
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    // DONOR
    function addDonor(){
        $('#divAddDonor').show();
    }

    function loaddonor() { // function ini harus dipanggil di event button update click di tabel organisasi
        $.post(
            "controller/controllerdonor.php",
            {
                   mode: "loaddonor",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlDonor").append(new Option("Pilih Donor", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlDonor").append('<option value="' + value.id + '">' + value.nama_donor + "</option>");                 
                });

                $("#ddlDonor").select2({
                    width: "100%",
                });
            }
        );
    }

   
    function saveDonor(){
        if ( $('#ddlDonor')[0].checkValidity()){
            var id = 0;
            if (dataDonor.length == 0)
                id++;
            else
                id = Number(dataDonor[dataDonor.length  - 1].id) +1;

            var id_donor = $('#ddlDonor').val();
            var nama_donor = $('#ddlDonor option:selected').text();
            var jumlah = $('#jumlah').val();
            var obj = {
                'id':id,
                'id_donor': id_donor,
                'nama_donor': nama_donor,
                'jumlah':jumlah
            }              
            
            dataDonor.push(obj);
            tableDonor.clear().draw();
            tableDonor.rows.add(dataDonor).draw();
            $('#divAddDonor').hide();
            $('#ddlDonor').val('').trigger('change');
            $('#jumlah').val('');
        } else
            $('#ddlDonor')[0].reportValidity();  
    }

    function cancelDonor(){    
        $('#ddlDonor').val('').trigger('change');
        $('#divAddDonor').hide();
    }

    function initializeTableDonor() {
        tableDonor = $("#tblDonor").DataTable({
            serverSide: false,
            processing: false,
            sDom: "lrtip",
            lengthChange: false,
            columns: [
                { data: "id" },
                { data: "id_donor" },
                { data: "nama_donor" },
                { data: "jumlah",
                  render: $.fn.dataTable.render.number( ',', '.', 2, '$' )                
                },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> </button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 5,
            autoWidth: false,
            responsive: true,
        });

        tableDonor
            .on("order.dt search.dt", function () {
                tableDonor
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    // DOCUMENT IS READY
    $(document).ready(function () {
        initializeTableLokasi();
        initializeTableKabupaten();
        loadmitralokal();
        loadIsu();
        loadBidangKerja();
        loadProvinsi();
        loaddonor();

        $("#tbllokasi").on("click", ".delete", function (e) {
            debugger;
            var data = tableLokasi.row($(this).closest("tr")).data();

            dataLokasi = $.grep(
                dataLokasi,
                function (o, i) {
                    return o.id === data.id;
                },
                true
            );
            tableLokasi.clear().draw();
            tableLokasi.rows.add(dataLokasi).draw();
        });

        

        initializeTableIsu();
        $("#tblisu").on("click", ".delete", function (e) {
            debugger;
            var data = tableIsu.row($(this).closest("tr")).data();

            dataIsu = $.grep(
                dataIsu,
                function (o, i) {
                    return o.id === data.id;
                },
                true
            );
            tableIsu.clear().draw();
            tableIsu.rows.add(dataIsu).draw();
        });

        initializeTableBidangKerja();
        $("#tblbidang_kerja").on("click", ".delete", function (e) {
            debugger;
            var data = tableBidangKerja.row($(this).closest("tr")).data();

            dataBidangKerja = $.grep(
                dataBidangKerja,
                function (o, i) {
                    return o.id === data.id;
                },
                true
            );
            tableBidangKerja.clear().draw();
            tableBidangKerja.rows.add(dataBidangKerja).draw();
        });


        initializeTableMitraLokal();
        $("#tblMitraLokal").on("click", ".delete", function (e) {
            debugger;
            var data = tableMitraLokal.row($(this).closest("tr")).data();

            dataMitraLokal = $.grep(
                dataMitraLokal,
                function (o, i) {
                    return o.id === data.id;
                },
                true
            );
            tableMitraLokal.clear().draw();
            tableMitraLokal.rows.add(dataMitraLokal).draw();
        });

        initializeTableDonor();
        $("#tblDonor").on("click", ".delete", function (e) {
            debugger;
            var data = tableDonor.row($(this).closest("tr")).data();

            dataDonor = $.grep(
                dataDonor,
                function (o, i) {
                    return o.id === data.id;
                },
                true
            );
            tableDonor.clear().draw();
            tableDonor.rows.add(dataDonor).draw();
        });

        $("#ddlProvinsi").change(function () {
            if (this.value != "") {
              loadKabupatenKota(this.value);
              $('#divKabupaten').show();
            } 
        });


    });


</script>