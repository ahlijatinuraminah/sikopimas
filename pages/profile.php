<?php
    include "authorizationuser.php";
?>
<div>
    <br />
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#details" data-toggle="tab">Detail Profile</a></li>
                <li><a href="#changepassword" data-toggle="tab">Change Password</a></li>
            </ul>
            <br />
            <br />
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form role="form" id="profileform">
                                <div id="loginerror"></div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input id="nama" name="nama" type="text" required class="form-control" placeholder="Name" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input id="email" name="email" type="email" required class="form-control" placeholder="Email" autocomplete="off" value="" />
                                </div>
                                <input type="hidden" name="id" id="id" />
                                <input type="hidden" name="role_id" id="role_id" />
                                <input type="hidden" id="mode" name="mode" value="save" />
                                <div class="text-right">
                                    <button type="button" onclick="updateProfile()" class="btn btn-default btn-primary">UPDATE PROFILE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="changepassword">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form role="form" id="changepassworform">
                                <div id="loginerror"></div>
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input id="old_password" name="old_password" maxlength="8" type="password" required class="form-control" placeholder="Old Password" data-toggle="password"/>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input id="new_password" name="new_password" maxlength="8" type="password" required class="form-control" placeholder="New Password" data-toggle="password" />
                                </div>
                                <div class="form-group">
                                    <label>Re-type New Password</label>
                                    <input id="re_new_password" name="re_new_password" maxlength="8" type="password" required class="form-control" placeholder="Re-type New Password" data-toggle="password" />
                                </div>
                                <input type="hidden" name="id" id="id2" />
                                <input type="hidden" id="mode" name="mode" value="updatepassword" />
                                <div class="text-right">
                                    <button type="button" onclick="updatePassword()" class="btn btn-default btn-primary">UPDATE PASSWORD</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function resetFormPassword(){
        $('#old_password').val(''); 
        $('#new_password').val(''); 
        $('#re_new_password').val('');
    }

    function loadProfile() {
        $.ajax({
            url: "controller/controlleruser.php",
            type: "POST",
            data: {
                mode: "loadprofile",
            },
            dataType: "json",
            success: function (data) {
                $("#id").val(data.id);
                $("#id2").val(data.id);
                $("#nama").val(data.nama);
                $("#email").val(data.email);
                $("#role_id").val(data.role_id);
            },
        });
    }

    function updateProfile() {
        if ($("form")[0].checkValidity()) {
            var objData = $("form#profileform").serialize();
            console.log(objData);
            $.ajax({
                url : "controller/controlleruser.php",    
                method: "POST",     
                data: objData,            
                success:function(data){     
                    swal("Success", data.trim(), "success");
                    loadProfile();
                }
            });
        } else $("form")[0].reportValidity();
    }

    function updatePassword() {
        if ($("form")[0].checkValidity()) {
            var objData = $("form#changepassworform").serialize();
            console.log(objData);
            if ($("#new_password").val() == $("#re_new_password").val()) {
                $.ajax({
                    url: "controller/controlleruser.php",
                    method: "POST",
                    data: objData,
                    success: function (response) {
                        resetFormPassword();
                        if (response.trim() != "") {
                            swal("Success", response.trim(), "success");
                        } else {
                            swal("Error", "Password Lama Tidak Sesuai", "error");
                        }
                    },
                });
            } else {
                console.log("Password Doesnt Match");
                alert('Password Doesnt Match!');
            }
        } else $("form")[0].reportValidity();
    }

    $(document).ready(function () {
        loadProfile();
    });
</script>
