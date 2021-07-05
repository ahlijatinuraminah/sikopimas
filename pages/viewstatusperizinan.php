<?php
    include "authorizationadmin.php";
?>
<div>
    <h2>Master Data Status Perizinan</h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>
    <br />
    <br />
    <div id="result" style="width: 100%;" class="table-responsive">
        <table id="tblStatusPerizinan" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="vertical-align: middle;">No.</th>
                    <th style="vertical-align: middle;">Id.</th>
                    <th style="vertical-align: middle;">Deskripsi</th>
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
                    <label>Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control" required />
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
        $("#deskripsi").val("");
    }

    function bindForm(data) {
        $("#id").val(data.id);
        $("#deskripsi").val(data.deskripsi);
    }

    function save() {
        if ($("form")[0].checkValidity()) {
            var objData = $("form#myform").serialize();
            $.ajax({
                url: "controller/controllerstatusperizinan.php",
                method: "POST",
                data: objData,
                dataType:"json",  
                success:function(data){     
                    showMessage(data);
                    resetForm();
                    $("#modal").modal("hide");
                    loadStatusPerizinan();
                },
            });
        } else $("form")[0].reportValidity();
    }

    function loadStatusPerizinan() {
        $.ajax({
            url: "controller/controllerstatusperizinan.php",
            type: "POST",
            data: {
                mode: "loadstatusperizinan",
            },
            success: function (json) {
                var data = JSON.parse(json);
                table.clear().draw();
                if (data != null) table.rows.add(data).draw();
            },
        });
    }

    function initializeTable() {
        table = $("#tblStatusPerizinan").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url: "controller/controllerstatusperizinan.php",
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "loadstatusperizinan",
                },
            },
            columns: [
                { data: null },
                { data: "id" },
                { data: "deskripsi" },
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
            $(".modal-title").text("Tambah Status Perizinan");
        });

        $("#tblStatusPerizinan").on("click", ".update", function (e) {
            var data = table.row($(this).closest("tr")).data();
            bindForm(data);
            $("#modal").modal("show");
            $(".modal-title").text("Update Status Perizinan");            
        });

        $("#tblStatusPerizinan").on("click", ".delete", function (e) {
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
                        url: "controller/controllerstatusperizinan.php",
                        method: "POST",
                        data: {
                            id: id,
                            mode: "delete",
                        },
                        dataType:"json",  
                        success:function(data){     
                            showMessage(data);
                            loadStatusPerizinan();
                        },
                    });
                } else {
                }
            });
        });
    });
</script>
