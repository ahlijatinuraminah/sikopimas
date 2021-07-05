<?php
    include "authorizationadmin.php";
?>
<div>
    <h2>Master Data User</h2>
    <button type="button" id="modal_button" class="btn btn-info"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Data</button>
    <br />
    <br />
    <div id="result" style="width: 100%;" class="table-responsive">
        <table id="tblUser" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="vertical-align: middle;">No.</th>
                    <th style="vertical-align: middle;">Id.</th>
                    <th style="vertical-align: middle;">Nama User</th>
                    <th style="vertical-align: middle;">Email</th>
                    <th style="vertical-align: middle;">Role</th>
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
                        <label>Nama User</label>
                        <input type="text" name="nama" id="nama" maxlength="50" class="form-control"  autocomplete="off" required />
                    </div>
                    <div class="form-group"> 
                        <label>Email</label>
                        <input type="text" name="email" id="email" maxlength="50" class="form-control"  autocomplete="off" required />
                    </div>
                    <div class="form-group" id="fieldpassword"> 
                        <label>Password</label>
                        <input type="password" name="password" id="password" maxlength="8" class="form-control" data-toggle="password" required />
                    </div>
                    <div class="form-group"> 
                        <label>Role</label>
                        <select id="ddlRole" name="role_id" class="form-control" required></select>
                    </div>
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
        $("#nama").val("");
        $("#email").val("");
        $("#password").val("");
        $('#ddlRole').val('').trigger('change');
    }

    function bindForm(data) {
        $("#id").val(data.id);
        $("#nama").val(data.nama);
        $("#email").val(data.email);
        $("#password").val(data.password);
        $('#ddlRole').val(data.role_id).change();
    }

    function save() {
        if ($("form")[0].checkValidity()) {
            var objData = $("form#myform").serialize();
            $.ajax({
                url: "controller/controlleruser.php",
                method: "POST",
                data: objData,
                dataType:"json",  
                success:function(data){     
                    showMessage(data);
                    resetForm();
                    $("#modal").modal("hide");
                    loadUser();
                },
            });
        } else $("form")[0].reportValidity();
    }

    function loadUser() {
        $.ajax({
            url: "controller/controlleruser.php",
            type: "POST",
            data: {
                mode: "loaduser",
            },
            success: function (json) {
                var data = JSON.parse(json);
                table.clear().draw();
                if (data != null) table.rows.add(data).draw();
            },
        });
    }

    function loadRole() {
        $.post(
            "controller/controlleruser.php",
            {
                mode: 'loadrole',
            },
            function (data, status) {
                var arrdata = JSON.parse(data);
                $("#ddlRole").append(new Option("Pilih Role", "", true, true));

                $.each(arrdata, function (index, value) {
                    $("#ddlRole").append('<option value="' + value.id + '">' + value.name + "</option>");
                });

                $("#ddlRole").select2({
                    width: "100%",
                });
            }
        );
    }

    function initializeTable() {
        table = $("#tblUser").DataTable({
            serverSide: false,
            processing: false,
            ajax: {
                url: "controller/controlleruser.php",
                type: "POST",
                dataSrc: "",
                data: {
                    mode: "loaduser",
                },
            },
            columns: [
                { data: null },
                { data: "id" },
                { data: "nama" },
                { data: "email" },
                { data: "role_name" },
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
        loadRole();

        $("#modal_button").click(function () {
            resetForm();
            $("#modal").modal("show");
            $("#fieldpassword").show();
            $(".modal-title").text("Tambah User");
        });

        $("#tblUser").on("click", ".update", function (e) {
            var data = table.row($(this).closest("tr")).data();           
            bindForm(data);
            $("#modal").modal("show");
            $("#fieldpassword").hide();
            $(".modal-title").text("Update User");            
        });

        $("#tblUser").on("click", ".delete", function (e) {
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
                        url: "controller/controlleruser.php",
                        method: "POST",
                        data: {
                            id: id,
                            mode: "delete",
                        },
                        dataType:"json",  
                        success:function(data){     
                            showMessage(data);
                            loadUser();
                        },
                        error: function (error) {
                            alert(error.responseText);
                        }
                    });
                } else {
                }
            });
        });
    });
</script>
