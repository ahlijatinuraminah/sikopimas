<?php
    include "authorizationadmin.php";
?>
<div>
    <h2>Master Data Bidang Kerja</h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>
    <br />
    <br />
    <div id="result" style="width: 100%;" class="table-responsive">
        <table id="tblBidangKerja" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="vertical-align: middle;">No.</th>
                    <th style="vertical-align: middle;">Id.</th>
                    <th style="vertical-align: middle;">Nama Bidang Kerja</th>
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
                    <label>Nama Bidang Kerja</label>
                    <input type="text" name="nama_bidang" id="nama_bidang" class="form-control" required />
                    <br />
                    <input type="hidden" name="id" id="id" />
                    <input type="hidden" id="mode" name="mode" value="save" />
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
    function resetForm() {
        $("#id").val("");
        $("#nama_bidang").val("");
    }

    function bindForm(data) {
        $("#id").val(data.id);
        $("#nama_bidang").val(data.nama_bidang);
    }

    function save() {
        if ($("form")[0].checkValidity()) {
            var objData = $("form#myform").serialize();
            $.ajax({
                url: "controller/controllerbidangkerja.php",
                method: "POST",
                data: objData,
                dataType:"json",  
                success: function (data) {
                    showMessage(data);
                    resetForm();
                    $("#modal").modal("hide");
                    loadBidangKerja();
                },
            });
        } else $("form")[0].reportValidity();
    }

    function loadBidangKerja() {
        $.ajax({
            url: "controller/controllerbidangkerja.php",
            type: "POST",
            data: {
                mode: "loadbidangkerja",
            },
            success: function (json) {
                var data = JSON.parse(json);
                table.clear().draw();
                if (data != null) table.rows.add(data).draw();
            },
        });
    }

    function initializeTable() {
        table = $("#tblBidangKerja").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url: "controller/controllerbidangkerja.php",
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "loadbidangkerja",
                },
            },
            columns: [
                { data: null },
                { data: "id" },
                { data: "nama_bidang" },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<button type="button" class="btn btn-warning btn-xs update"><i class="fas fa-edit" aria-hidden="true"></i> Ubah</button>',
                },
                {
                    data: null,
                    className: "center",
                    defaultContent: '<td><button type="button" class="btn btn-danger btn-xs delete"><i class="fas fa-trash" aria-hidden="true"></i> Hapus</button></td>',
                },
            ],
            columnDefs: [{ targets: [1], visible: false }],
            pageLength: 10,
            autoWidth: false,
            responsive: true,
        });

        table
            .on("order.dt search.dt", function () {
                table
                    .column(0, { search: "applied", order: "applied" })
                    .nodes()
                    .each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
            })
            .draw();
    }

    $(document).ready(function () {
        initializeTable();

        $("#modal_button").click(function () {
            resetForm();
            $("#modal").modal("show");
            $(".modal-title").text("Tambah Bidang Kerja");
        });

        $("#tblBidangKerja").on("click", ".update", function (e) {
            var data = table.row($(this).closest("tr")).data();
            bindForm(data);
            $("#modal").modal("show");
            $(".modal-title").text("Update Bidang Kerja");                
        });

        $("#tblBidangKerja").on("click", ".delete", function (e) {
            var data = table.row($(this).closest("tr")).data();
            var id = data.id;
            swal({
                title: "Apakah anda yakin akan menghapus data ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "controller/controllerbidangkerja.php",
                        method: "POST",
                        dataType:"json",  
                        data: {
                            id: id,
                            mode: "delete",
                        },
                        success: function (data) {
                            loadBidangKerja();
                            showMessage(data);
                        },
                    });
                } else {
                }
            });
        });
    });
</script>
