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
            <div class="msg"><?php if (!empty($message)) echo $message; ?></div>
            <div class="container-login100 page-background">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" onsubmit="return validationForm();this.js_enabled.value = 1;return true;" method="post" action="">
                        <span class="login100-form-logo"> <img alt="" src="<?php echo base_url('assets/img/logo1.png'); ?>"></span> 
                        <span class="login100-form-title p-b-20 p-t-27"> Forgot Password </span> <?php echo $this->session->flashdata('msg'); ?>
                        <div class="wrap-input100 validate-input" data-validate = "Enter username">
                            <?php
                            $data = array(
                                'name' => 'username',
                                'placeholder' => 'E-Mail',
                                'class' => 'input100',
                                'id' => 'username'
                            );
                            echo form_input($data);
                            ?>
                            <span class="focus-input100" data-placeholder="&#xf207;"></span> 
                        </div>
                        <span id="nameErr" style="color:#ff0059;" > </span>

                        <div class="container-login100-form-btn">
                            <?php
                            $data = array(
                                'class' => 'login100-form-btn',
                                'type' => 'submit',
                                'name' => 'submit'
                            );

                            echo form_button($data, 'Send Email');
                            ?>
                        </div>

                    </form>
                </div>
                <div class="footer col-md-12 text-center">Copyright @Leica Biosystems Nussloch GmbH - 2018. Powered by <a href="https://www.bluenettech.com/" target="_blank">Bluenet</a></div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>" ></script> 
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>" ></script> 
        <script src="<?php echo base_url('assets/js/pages/extra_pages/extra_pages.js'); ?>"></script> 
        <script type="text/javascript" language="javascript">
                        $(document).ready(function () {
                            if ($(".msg").text().length > 0) {
                                setTimeout(function () {
                                    $(".msg").hide();
                                    window.location = "<?php echo base_url('login'); ?>";
                                }, 3000);


                            }
                        });
                        function validationForm()
                        {
                            var user_name = document.getElementById('username').value;
                            //var user_password= document.getElementById('user_password').value;
                            //var user_role= document.getElementById('user_role').value;
                            document.getElementById('nameErr').innerHTML = "";
                            //document.getElementById('pwdErr').innerHTML = "";
                            //document.getElementById('roleErr').innerHTML = "";
                            if (user_name == "" || user_name == null)
                            {
                                document.getElementById('nameErr').innerHTML = "Please Enter Your E-Mail";
                                document.getElementById('user_name').focus();
                                return false;
                            }

                            /*if(user_password =="" || user_password == null)
                             {	
                             document.getElementById('pwdErr').innerHTML = "Please Enter Your Password";
                             document.getElementById('user_password').focus();	
                             return false;
                             }*/

                            /*if(user_role =="" || user_role == null)
                             {	
                             document.getElementById('roleErr').innerHTML = "Please Select Your Role";
                             document.getElementById('user_role').focus();	
                             return false;
                             }*/

                        }
                        $("#msg").fadeIn(3000);
        </script>
    </body>
</html>