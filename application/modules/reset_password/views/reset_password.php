<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta name="description" content="" />
<meta name="author" content="" />
<title></title>

<!-- icons -->

<link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iconic/css/material-design-iconic-font.min.css">

<!-- bootstrap -->

<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- style -->

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/pages/extra_pages.css">
</head>

<body>
<div class="limiter">
  <div class="container-login100 page-background">
    <div class="wrap-login100">
      <form method="post" id="confirm-form" class="login100-form validate-form">
        <span class="login100-form-logo"> <img alt="" src="<?php echo base_url();?>/assets/img/logo1.png"> </span> <span style="text-align:center !important; padding-left:1px;font-size:14px; font-weight:bold;" id="confirm-response"></span> <br>
        <br>
        <br>
        <div class="wrap-input100 validate-input" data-validate="Enter New Password*">
          <input class="input100" type="password" name="new_password" id="new_password" placeholder="Enter New Password*">
          <span class="focus-input100" data-placeholder="&#xf191;"></span> <span id="newErr" style="color:red;" > </span> </div>
        <div class="wrap-input100 validate-input" data-validate="Enter Confirm Password*">
          <input class="input100" type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password*">
          <span class="focus-input100" data-placeholder="&#xf191;"></span> <span id="confirmErr" style="color:red;" > </span> </div>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
        <p id="errGlobal"></p>
        <div class="container-login100-form-btn">
          <button type="submit" id="changepass_submit" class="login100-form-btn"> Update </button>
        </div>
      </form>
    </div>
    <div class="footer col-md-12 text-center">Copyright @Leica Biosystems Nussloch GmbH - 2018. Powered by <a href="https://www.bluenettech.com/" target="_blank">Bluenet</a></div>
  </div>
</div>

<!-- start js include path --> 

<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js" ></script> 

<!-- bootstrap --> 

<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js" ></script> 
<script src="<?php echo base_url();?>assets/js/pages/extra_pages/extra_pages.js"></script> 

<!-- end js include path --> 

<script type="text/javascript" language="javascript">

 

		$(document).ready(function(){

		$("#errGlobal").html("<B>Password Policy:</B> Must be at least 8 characters long. It should necessarily contain one Letter in Caps, one Symbol and one Number.").css({"color": "black", "margin-top":"0px", "margin-bottom":"10px"});

		$("#changepass_submit").click(function(e){

		e.preventDefault();

		var user_id = $("#user_id").val();

		var new_password = $("#new_password").val();

		var confirm_password = $("#confirm_password").val();

	

		var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");

	  if(new_password==""){

      $("#errGlobal").html("Enter New Password ").css("color", "red");

      $("#new_password").focus();

      return false; 

      }

      else{

      if(new_password!="" && new_password.match(strongRegex)) 

      {

      $("#errGlobal").html("");

      }

      else{

      $("#errGlobal").html("<B>Password Policy:</B> Must be at least 8 characters long. It should necessarily contain one Letter in Caps, one Symbol and one Number.").css({"color": "red", "margin-top":"0px", "margin-bottom":"10px"});

      $("#new_password").focus();

      return false;

      } 

      }

	  

	 if(confirm_password==""){

      $("#confirmErr").html("Enter Confirm Password ").css("color", "red");

      $("#confirm_password").focus();

      return false; 

      }

      else{

      if(new_password == confirm_password) 

      {

      $("#confirmErr").html("");

      }

      else{

      $("#confirmErr").html("Passwords do not match").css("color", "red");

      $("#confirm_password").focus();

      return false;

      } 

      } 

	    

		$.ajax({

		type: "POST",

		url: '<?php echo base_url("reset_password/update_firsttimepwd") ?>',

		data: {user_id: user_id,new_password:new_password},

		success:function(data)

		{

		if(data == 1)

		{

			$("#confirm-response").html("Password Updated Successfully! Redirecting to Dashboard Page.").css("color", "green");

			$('#confirm-form')[0].reset();

			var seconds = 3;

			

			setInterval(function () {

            seconds--;

            if (seconds == 0) {

               
                window.location.href = "<?php echo base_url(); ?>login";

            }

        }, 1000);

			

		}

		}

		});

		

		});

		});

	

	

</script>
</body>
</html>