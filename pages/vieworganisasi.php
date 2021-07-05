<?php
    include "authorizationuser.php";
?>
<div  style="width:100%">
    <h5><span id="splokasi"></span>&nbsp <span id="spnegara"></span> &nbsp <span id="spmitra"></span></h5>
    <div class="records_content">
        <table id="tblorganisasi" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                   <th style="vertical-align: middle;">No.</th>
                    <th style="vertical-align: middle;">Nama Organisasi</th>
                    <th style="vertical-align: middle;">Id Negara</th>                    
                    <th style="vertical-align: middle;">Id Bidang Kerja</th>
                    <th style="vertical-align: middle;">Lokasi Kerja Provinsi</th>
                    <th style="vertical-align: middle;">Lokasi Kerja Kabupaten</th>
                    <th style="vertical-align: middle;">Id Mitra</th>
                    <th style="vertical-align: middle;">Id Status Perizinan</th>
                    <th style="vertical-align: middle;">Id Isu</th>
                    <th style="vertical-align: middle;">Id Mitra Lokal</th>
                    <th style="vertical-align: middle;">Negara Asal</th>                  
                    <th style="vertical-align: middle;">Alamat</th>       
                    <th style="vertical-align: middle;">Nilai Tingkat Kerawanan</th>     
                    <th style="vertical-align: middle;">Tingkat Kerawanan</th>                   
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->

<div class="modal fade" id="orgmodal">
 <div class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><label id="nama_organisasi"> </label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
             <table class="table table-bordered table-hover table-striped">
                             <tr>
                <td>Status Perizinan</td>
                <td>:</td>
                <td><label id="status_perizinan"> </label></td>
                <td><span id="statusizin"></span></td>
                </tr>
                <tr>
                <td>Isu Sensitif</td>
                <td>:</td>
                <td><label id="isu_organisasi"> </label></td>
                <td><span id="statusisu"></span></td>
                </tr>
                <tr>
                <td>Tahun di Indonesia</td>
                <td>:</td>
                <td>
                    <label id="tahun_beroperasi"> </label>                                    
                </td>
                <td><span id="statustahunoperasi"></span></td>
                </tr>
                <tr>
                <td>Jumlah Wilayah</td>
                <td>:</td>
                <td><label id="jumlah_wilayah"> </label></td>
                <td><span id="statuswilayah"></span></td>
                </tr>
                <tr>
                <td>Jumlah Mitra Lokal</td>
                <td>:</td>
                <td><label id="jejaring_mitra"> </label></td>
                <td><span id="statusmitra"></span></td>
                </tr>
                <tr>
                <td>Data Collection</td>
                <td>:</td>
                <td><label id="data_collection"> </label></td>
                <td><span id="statusdatacollection"></span></td>
                </tr>
                <tr>
                <td>Besaran Dana</td>
                <td>:</td>
                <td><label id="anggaran"> </label></td>
                <td><span id="statusanggaran"></span></td>
                </tr>                
                <tr>
                <td>Tingkat Kerawanan</td>
                <td>:</td>
                <td colspan="2"><label id="tingkat_kerawanan"> </label></td>
                </tr>
            </table>
            

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>        
    </div>
</div>

<script>
    // Save Record
    var table;
    var rowData;
    const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
    });

    function resetForm() {
        $("#id").val("");
        $("#nama_organisasi").val("");
        $("#status_perizinan").html("");
        $("#statusizin").html("");
        $("#isu_organisasi").html("");
        $("#statusisu").html("");
        $("#tahun_beroperasi").html("");
        $("#statustahunoperasi").html("");
        $("#jumlah_wilayah").html("");
        $("#statuswilayah").html('');
        $("#jejaring_mitra").html("");
        $("#statusmitra").html('');        
        $("#anggaran").html("");
        $("#statusdatacollection").html('');
        $("#statusanggaran").html('');
        $("#tingkat_kerawanan").html("");        
    }

    function bindForm(data) {        
        resetForm();               
        $("#id").val(data.id);        
        $("#nama_organisasi").html(data.nama_organisasi);
        $("#status_perizinan").html(data.status_perizinan);
        setLabelBadgeStatus('statusizin', data.statusizin);  

        if(data.statusisu == 1){
            $("#isu_organisasi").html("None");                 
        }
        else{
            $("#isu_organisasi").html(data.isu_organisasi);            
        }
        setLabelBadgeStatus('statusisu', data.statusisu);  
       
        $("#tahun_beroperasi").html(data.tahun_beroperasi);
        setLabelBadgeStatus('statustahunoperasi', data.statustahunoperasi);  
        
        $("#jumlah_wilayah").html(data.jumlah_wilayah + ' provinsi');
        setLabelBadgeStatus('statuswilayah', data.statuswilayah);  
       
        $("#jejaring_mitra").html(data.jumlah_mitralokal + ' jejaring lokal');
        setLabelBadgeStatus('statusmitra', data.statusmitra);   
       
        $("#data_collection").html(data.data_collection);
        setLabelBadgeStatus('statusdatacollection', data.statusdatacollection);   
        
        $("#anggaran").html(formatter.format(data.anggaran));
        setLabelBadgeStatus('statusanggaran', data.statusanggaran);        
        $("#tingkat_kerawanan").html(data.tingkat_kerawanan);
        //$("#alamat").html(data.alamat);
    }

    function openModal() {  
        debugger;             
        $('#orgmodal').modal('show');        
    }

    function setLabelBadgeStatus(name, data){
        if(data == 1){              
            $("#" + name).html('<span class="label label-success labelKerawanan">' + 'AMAN' +'</span>');
        }
        else if(data == 2){              
            $("#" + name ).html('<span class="label label-warning labelKerawanan">' + 'SEDANG'+'</span>');
        }
        else{
            $("#" + name).html('<span class="label label-danger labelKerawanan">' +'RAWAN' +'</span>');
        }

    }
    
    function format (data) {        
    var childRow = '<div class="row">';
    var datalokasi = data.lokasiprovinsikabupaten;
    
    if(datalokasi == null)
           datalokasi = data.lokasi_kerja_provinsi;

    if(data.lokasi_kerja_provinsi == null)
            datalokasi = "<span class='spanNone'>Tidak ada data</span>";                     
    if(data.bidang_kerja == null)
        data.bidang_kerja = "<span class='spanNone'>Tidak ada data</span>";                     

    if(data.mitralokal_organisasi == null)
        data.mitralokal_organisasi ='';

    if(data.statusisu == 1){
        if(data.isu_organisasi == null)
            data.isu_organisasi = "<span class='spanNone'>Tidak ada data</span>";                     
        else
            data.isu_organisasi = "<span class='spanNone'>None</span>";                     
    }

    var childRowLevel1 =
    '<div class="col-md-6">' +
    '<table class="table">'+
        '<tr>'+
            '<td width="130">Kepala Perwakilan</td>'+
            '<td>:</td>'+
            '<td>'+data.representasi+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Tahun Berdiri</td>'+
            '<td>:</td>'+
            '<td>'+data.tahun_berdiri+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Tahun di Indonesia</td>'+
            '<td>:</td>'+
            '<td>'+data.tahun_beroperasi+'</td>'+
        '</tr>'+        
        '<tr>'+            
            '<td colspan="3">'+ 'Bidang Kerja <br> ' +data.bidang_kerja+'</td>'+
        '</tr>'+        
        '<tr>'+            
        '<td colspan="3">'+ 'Lokasi Kerja <br>' +datalokasi+'</td>'+
        '</tr>'+
        '</table>' +
        '</div>';

        var childRowLevel2 =
        '<div class="col-md-6">' +
        '<table class="table">' +
        '<tr>'+
             '<td width="130">Status Perizinan</td>'+
            '<td>:</td>'+
            '<td>'+data.status_perizinan+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Kementerian/ Mitra</td>'+
            '<td>:</td>'+
            '<td>'+data.nama_mitra+'</td>'+
        '</tr>'+
        '<tr>'+
             '<td colspan="3">'+ 'Isu Sensitif <br>' + data.isu_organisasi+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Anggaran per Tahun</td>'+
            '<td>:</td>'+
            '<td>'+formatter.format(data.anggaran)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td colspan="3"><span id="donor'+data.id +'">'+data.donor_organisasi + '</span></td>'+
        '</tr>'+
        '<tr>'+
            '<td>Jejaring Mitra</td>'+
            '<td>:</td>'+
            '<td>'+data.jumlah_mitralokal + ' jejaring lokal</td>'+
        '</tr>'+
        '<tr>'+            
            '<td colspan="3">'+data.mitralokal_organisasi+'</td>'+
        '</tr>'+
        
       '</table>'+
       '</div>';

       childRow += childRowLevel1;       
       if (userRole == 3 || userRole == 1)
            childRow += childRowLevel2;

       childRow += '</div>';
       return childRow;
}

    function initializeTable() {
        table = $("#tblorganisasi").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url: "controller/controllerorganisasi.php",
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "read",
                },
            },
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },//0
                { data: "nama_organisasi" },//1                 
                { data: "id_negara_asal" },//2 
                { data: "id_bidang_kerja" },//3
                { data: "id_provinsi" }, //4               
                { data: "id_kabupaten" }, //5       
                { data: "id_mitra" }, //6       
                { data: "id_statusperizinan" }, //7       
                { data: "id_isu" }, //8       
                { data: "id_mitralokal" }, //9       
                { data: "nama_negara" }, //10
                { data: "alamat" },  //11
                { data: "tingkat_kerawanan" },  //12
                {
                    className:'center',                    
                    data:null,
                    defaultContent:'<p></p>'                    
                },//13                             
            ],
            columnDefs: [
                { targets: [2,3,4,5,6,7,8,9, 12], visible: false },
                { targets: [1], width: 200 },
                { targets: [8, 9], width: 200 },
            ],                  
            pageLength: 5,
            autoWidth:false,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "All"],
            ],
            createdRow: function (row, data, dataIndex, cells) {     
                
                if (data['tingkat_kerawanan'] === 'RAWAN') {
                   $(cells[13]).addClass('Rawan');                   
                }
                else if (data['tingkat_kerawanan'] === 'SEDANG') {
                   $(cells[13]).addClass('Sedang');
                }
                else if (data['tingkat_kerawanan'] === 'AMAN') {
                   $(cells[13]).addClass('Aman');
                }
                
                var url ="";
                if(userRole == 3 || userRole == 1){
                    url = '<button type="button" class="btn-link btn-anchor">' +'<i class="fas fa-plus-circle" aria-hidden="true"></i> ' + data['tingkat_kerawanan'] + '</button>';
                } else {
                    url =  data['tingkat_kerawanan'];
                }

                
                $(cells[13]).append(url);                
            },      
            //responsive:true,
            
        
        });

        table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    
}

    function readRecords() {
        $.ajax({
            url: "controller/controllerorganisasi.php",
            type: "POST",
            data: {                
                mode: "read",
            },
            success: function (json) {
                var data = JSON.parse(json);
                var table = $("#tblorganisasi").DataTable();
                table.clear().draw();
                if (data != null) table.rows.add(data).draw();
            },
        });
    }

 
    
    function getOne(id) {
        resetForm();
        $.post(
            "controller/controllerorganisasi.php",
            {
                id: id,
                mode: "get",
            },
            function (data, status) {
                bindForm(JSON.parse(data));
            }
        );

//        $("#add_new_record_modal").modal("show");
    }

    function loadnegara() {
        $.post(
            "controller/controllernegara.php",
            {
                   mode: "loadnegara",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlNegara").append(new Option("Semua Negara Asal", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlNegara").append('<option value="' + value.id + '">' + value.nama_negara + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#ddlNegara").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }

    function loadbidangkerja() {
        $.post(
            "controller/controllerbidangkerja.php",
            {
                   mode: "loadbidangkerja",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlBidangKerja").append(new Option("Semua Bidang Kerja", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlBidangKerja").append('<option value="' + value.id + '">' + value.nama_bidang + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#ddlBidangKerja").select2({
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
                $("#ddlMitra").append(new Option("Semua Mitra", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlMitra").append('<option value="' + value.id + '">' + value.nama_mitra + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#ddlMitra").select2({
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
                $("#ddlStatusPerizinan").append(new Option("Semua Status Perizinan", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlStatusPerizinan").append('<option value="' + value.id + '">' + value.deskripsi + "</option>");
                    //$('#ddlNegara').append('<option value="' + value.id + '">' + value.nama_negara +'('+ value.jumlah_ormas +')' + '</option>');
                });

                $("#ddlStatusPerizinan").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }

    

    function loadprovinsi() {
        $.post(
            "controller/controllerprovinsi.php",
            {
                mode: "loadprovinsi",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlProvinsi").append(new Option("Semua Lokasi Kerja", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlProvinsi").append('<option value="' + value.id + '" data-lati="' + value.lati + '" data-longi="' + value.longi + '">' + value.nama_provinsi + "</option>");
                });

                $("#ddlProvinsi").select2({
                    width: "100%"
                });

                $("#ddlKerawanan").select2({
                    width: "100%",
                });
            }
        );
    }

    function loadisu() {
        $.post(
            "controller/controllerisu.php",
            {
                   mode: "loadisu",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlIsu").append(new Option("Semua Isu Sensitif", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlIsu").append('<option value="' + value.id + '">' + value.nama_isu + "</option>");
                });

                $("#ddlIsu").select2({
                    //    placeholder: "SELECT ORIGIN COUNTRY",
                    width: "100%",
                });
            }
        );
    }
    function loadmitralokal() {
        $.post(
            "controller/controllermitralokal.php",
            {
                   mode: "loadmitralokal",
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlMitraLokal").append(new Option("Semua Mitra Lokal", "", true, true));

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

    function filterByProvinsi() {                        
            if (id_provinsi != "") {
                table
                    .rows()
                    .column(4)
                    .search('(' + id_provinsi +')')
                    .draw();
            } else {
                table.search("").columns().search("").draw();
            }
    }
    function filterByKabupatenKota() {                        
            if (id_kabupatenkota != "") {
                table
                    .rows()
                    .column(5)
                    .search('(' + id_kabupatenkota +')')
                    .draw();
            } else {
                table.search("").columns().search("").draw();
            }
    }


    function showDonorChart(id){
        var donor = $("#donor"+id).html();                
        var arrseries = []; 
        
            $("#donor"+ id +" li" ).each(function( index ) {
                var text = $(this).text().split(":");  
                var obj = {
                    'name': text[0],
                    'y': parseInt(text[1])
                }              
                arrseries.push(obj);                
            });

        if(arrseries.length > 0){            
            var chartName = 'donor' + id;
            Highcharts.chart(chartName, {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                width: 400,
                height:250
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Donor'
            },
            tooltip: {
                pointFormat: '<b> {point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        //format: '<b>{point.name} <br> {point.y} </b>',
                        formatter: function() {                            
                            return this.point.name +'<br>' + '$' + Highcharts.numberFormat(this.y, 2, '.', ',')
                        },
                        showInLegend: true
                  }
                }
            },
            series: [{
                name: 'Donor',
                colorByPoint: true,
                data: arrseries
                 }]
            });
        }else{
            $("#donor"+id).html("Donor <br> <span class='spanNone'>Tidak ada data donor</span>");  
            ;                                
        }
    }

    function resetAll(){
        id_negara = "";
            id_provinsi = "";
            id_bidangkerja = "";
            id_kabupatenkota = "";
            tingkat_kerawanan = "";
            id_mitra = "";
            id_statusperizinan = "";
            id_isu = "";
            id_mitralokal = "";
            nama_organisasi = "";
            $('#namaorg').val(''); 
            $("#ddlProvinsi").val('').trigger('change');
            $("#ddlNegara").val('').trigger('change');
            $("#ddlBidangKerja").val('').trigger('change');
            $("#ddlKerawanan").val('').trigger('change');
            $("#ddlMitra").val('').trigger('change');
            $("#ddlStatusPerizinan").val('').trigger('change');
            $("#ddlIsu").val('').trigger('change');
            $("#ddlMitraLokal").val('').trigger('change');
            $("#splokasi").html("");
            table.search("").columns().search("").draw();
    }

   
    $(document).ready(function () {
        initializeTable();
        //readRecords(); // calling function
        loadnegara();
        loadbidangkerja();
        loadprovinsi();

        if(userRole == 3 || userRole == 1){
            loadmitra();
            loadstatusperizinan();
            loadisu();
            loadmitralokal();
        }

        $('#tblorganisasi tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                
                row.child( format(row.data())).show();                
                tr.addClass('shown');                
                showDonorChart(row.data().id);
            }
        });
        $('#tblorganisasi').on('click', '.btn-anchor', function (e) {            
                var data = table.row( $(this).closest('tr') ).data(); 
                bindForm(data);
                debugger;
                openModal();               
        });

        
        $("#ddlProvinsi").change(function () {
            if (this.value != "") {
                latProv = $(this).find(":selected").data("lati");
                lngProv = $(this).find(":selected").data("longi");                           
            } 
        });

        $("#btnReset").click(function () {    
            resetMap = true        
                        
            resetAll();
            
            map.flyTo([defaultLat, defaultLng], defaultZoom);
            if(map.hasLayer(markers_provinsi))
                map.removeLayer(markers_provinsi);
            markers_provinsi.clearLayers();       
            loadProvinsiMarkers();

            
            resetMap = false;
        });

        $("#btnSearch").click(function () {        
            nama_organisasi = $('#namaorg').val();  
            id_negara = $('#ddlNegara').val();  
            id_bidangkerja = $('#ddlBidangKerja').val();  
            id_mitra = $('#ddlMitra').val();  
            id_negara = $('#ddlNegara').val();  
            id_provinsi = $('#ddlProvinsi').val();  
            id_statusperizinan = $('#ddlStatusPerizinan').val();  
            tingkat_kerawanan = $('#ddlKerawanan').val(); 
            id_isu = $('#ddlIsu').val();  
            id_mitralokal = $('#ddlMitraLokal').val();  
        
            markers_provinsi.clearLayers();
            if(!resetMap) 
                loadProvinsiMarkers();       

            table.search("").columns().search("").draw();        
            
            if (nama_organisasi != "") {
                table.rows().column(1).search(nama_organisasi).draw();
            }            
            if (id_negara != "") {
                table.rows().column(2).search("^" + id_negara + "$", true, false, true).draw();
            }
            if (id_bidangkerja != "") {
                table.rows().column(3).search('(' + id_bidangkerja +')').draw();
            } 
            
            if (id_provinsi != "") {
                table.rows().column(4).search('(' + id_provinsi +')').draw();
                $("#splokasi").html($('#ddlProvinsi option:selected').text());
                map.flyTo([latProv, lngProv], 8);
                loadKabupatenKotaMarkers(id_provinsi);
            } 

            if (id_mitra != "") {
                table.rows().column(6).search("^" + id_mitra  + "$", true, false, true).draw();
            }
            if (id_statusperizinan != "") {
                table.rows().column(7).search("^" + id_statusperizinan + "$", true, false, true).draw();
            }            
            if (id_isu != "") {
                table.rows().column(8).search('(' + id_isu+')').draw();
            }            
            if (id_mitralokal != "") {
                table.rows().column(9).search('(' + id_mitralokal +')').draw();
            }            
            if (tingkat_kerawanan != "") {
                table.rows().column(12).search(tingkat_kerawanan).draw();
            }
        });

 
    });
</script>
