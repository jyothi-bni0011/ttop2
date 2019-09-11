<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Account Login</title>
	<link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iconic/css/material-design-iconic-font.min.css'); ?>">
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/pages/extra_pages.css'); ?>">
</head>
<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<div>
					<span class="login100-form-logo"> <img alt="" src="<?php echo base_url('assets/img/logo1.png') ;?>"></span> 
					<p>Sorry, We broke something. Its been reported to developer.</p>
					<?php echo $message; ?>
				</div>
			</div>
			<div class="footer col-md-12 text-center">Copyright @Leica Biosystems Nussloch GmbH - 2018. Powered by <a href="https://www.bluenettech.com/" target="_blank">Bluenet</a></div>
		</div>
	</div>
	<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>" ></script> 
	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>" ></script> 
	<script src="<?php echo base_url('assets/js/pages/extra_pages/extra_pages.js'); ?>"></script> 
	<script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.js'); ?>"></script>
	<script type="text/javascript" language="javascript">
		/*function validationForm()
		{
			var user_name= document.getElementById('user_name').value;
			var user_password= document.getElementById('user_password').value;
			var user_role= document.getElementById('user_role').value;
			document.getElementById('nameErr').innerHTML = "";
			document.getElementById('pwdErr').innerHTML = "";
			document.getElementById('roleErr').innerHTML = "";
			if(user_name =="" || user_name == null)
			{	
				document.getElementById('nameErr').innerHTML = "Please Enter Your Username/E-Mail";
				document.getElementById('user_name').focus();	
				return false;
			}

			if(user_password =="" || user_password == null)
			{	
				document.getElementById('pwdErr').innerHTML = "Please Enter Your Password";
				document.getElementById('user_password').focus();	
				return false;
			}

			if(user_role =="" || user_role == null)
			{	
				document.getElementById('roleErr').innerHTML = "Please Select Your Role";
				document.getElementById('user_role').focus();	
				return false;
			}

		}*/

		$(document).ready(function(){
			$( "#login_form" ).validate({
				rules: {
					username: {
			      		required: true,
			      		minlength: 4
			    	},
			    	password: {
			      		required: true
			    	}
				}
				
			});
		});

	</script>
</body>
</html>