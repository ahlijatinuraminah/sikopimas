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
					<div id="loginerror"></div> 
			        <div class="form-group">
			            <label>Email address</label>
			            <input id="email" type="email" maxlength="50" required class="form-control" placeholder="Email" autocomplete="off" />
			        </div>
			        <div class="form-group">
			            <label>Password</label>
			            <input id="password" type="password" maxlength="8" required class="form-control" placeholder="Password" data-toggle="password"/>
			            
			        </div>
			        <button name="btn_login" id="btn_login" class="btn btn-default btn-block btn-primary">LOGIN</button>
				</form>
		    	<hr />
				<div class="text-center">
					<a href="index.php?p=forgotpassword">Forgot Password</a>
				</div>
		    </div>
		</div>
	</div>
</div>

<script type="text/javascript">

function showError(message){
	var errorAlert = '<div class="alert alert-danger alert-dismissible">'+
							'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
							message +
						'</div>';
	$('#loginerror').html(errorAlert);						

}
	$(document).ready(function(){
	    $("#btn_login").click(function(e){
			e.preventDefault();
	        var email = $("#email").val().trim();
	        var password = $("#password").val().trim();
	        var mode = 'login';

	        if ($("form")[0].checkValidity()){
			
	            $.ajax({
	                url:'controller/controllerauth.php',
	                type:'POST',
	                data:{
	                	email: email,
	                	password: password,
	                	mode: mode
	                },
					dataType:"json",  
	                success: function(response) {		
	                    if(response == ''){
	                        window.location = "index.php";
	                    } else {
							showError(response);
	                    }
	                },
					error: function (error) {
						showError(error.responseText);
					}
	            });
	        } else {
	        	$("form")[0].reportValidity();  
	        }
	    });
	});
</script>