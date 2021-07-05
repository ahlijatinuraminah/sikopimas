<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-5">
		<div class="panel panel-default">
			<div class="sidebar-header">
				<a href="index.php">
					<img src="img/logo.jpeg" width="250" height="150" style="margin-left: auto; margin-right:auto; display:block">
				</a>
	        </div>	
		    <div class="panel-body">			
				<form role="form" id="myform">     
					<div id="checkresponse"></div> 
			        <div class="form-group">
			            <label>Email address</label>
			            <input id="email" type="email" maxlength="50" required class="form-control" placeholder="Email" autocomplete="off" />
			        </div>
			        <button name="btn_forgotpassword" id="btn_forgotpassword" class="btn btn-default btn-block btn-primary">SEND NEW PASSWORD TO EMAIL</button>
				</form>
		    	<hr />
				<div class="text-center">
					<a href="index.php?p=login">Back to Login</a>
				</div>
		    </div>
		</div>
	</div>
</div>

<script type="text/javascript">
    function showError(message) {
        var errorAlert = '<div class="alert alert-danger alert-dismissible">' + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + message + "</div>";
        $("#checkresponse").html(errorAlert);
    }

    function showSuccess(message) {
        var successAlert = '<div class="alert alert-success alert-dismissible">' + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + message + "</div>";
        $("#checkresponse").html(successAlert);
    }

    $(document).ready(function () {
        $("#btn_forgotpassword").click(function (e) {
            e.preventDefault();
            var email = $("#email").val().trim();
            var mode = "forgotpassword";

            if ($("form")[0].checkValidity()) {
                $.ajax({
                    url: "controller/controllerauth.php",
                    type: "POST",
                    data: {
                        email: email,
                        mode: mode,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.hasil) {
                            showSuccess(response.message);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function (error) {
                        showError(error.responseText);
                    },
                });
            } else {
                $("form")[0].reportValidity();
            }
        });
    });
</script>
