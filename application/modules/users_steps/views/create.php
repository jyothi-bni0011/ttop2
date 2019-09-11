<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Users</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Users</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php 

				//If login user is not superadmin
            	$selected_reg_id = $selected_site_id = $disable = $hidden = '';
                if($this->session->userdata('role_id')!=1){
                	$selected_reg_id = $reg_id;
                	$selected_site_id = $site_id;
                	$disable = 'disabled';
                	$options_site[$site_id]  = $site_name;
                	$hidden = array('region_id' => $reg_id, 'site_id' => $site_id);
                }
                //End condition for not superadmin

				$attributes = array('class' => 'form-horizontal', 'id' => 'create_user', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('users/create', $attributes, $hidden);
				?>
					<div class="form-body">

						<div class="form-group row">
							<label class="control-label col-md-3">Employee ID
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'employee_id',
									'id' => 'employee_id',
									'placeholder' => 'Enter Employee ID',
									'class' => 'form-control input-height',
									'data-required' => "1"
								);
								echo form_input($data, set_value('employee_id')); ?>
							</div>
							
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">Username
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'user_name',
									'id' => 'user_name',
									'placeholder' => 'Enter Username',
									'class' => 'form-control input-height check_unique',
									'data-required' => "1"
								);
								echo form_input($data, set_value('user_name')); ?>
							</div>
							<span id="username_error" class="error" style="padding: 10px;display: none;">This Username is already exist.</span>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">First Name
								
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'user_first_name',
									'id' => 'user_first_name',
									'placeholder' => 'Enter First Name',
									'class' => 'form-control input-height',
									'data-required' => "1"
								);
								echo form_input($data, set_value('user_first_name')); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Middle Name
								
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'user_middle_name',
									'id' => 'user_middle_name',
									'placeholder' => 'Enter Middle Name',
									'class' => 'form-control input-height',
									'data-required' => "1"
								);
								echo form_input($data, set_value('user_middle_name')); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Last Name
								
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'user_last_name',
									'id' => 'user_last_name',
									'placeholder' => 'Enter Last Name',
									'class' => 'form-control input-height',
									'data-required' => "1"
								);
								echo form_input($data, set_value('user_last_name')); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_email" id="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height check_unique" value="<?php echo set_value('user_email'); ?>">
							</div>
							<span id="email_error" class="error" style="padding: 10px;display: none;">This Email is already exist.</span>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" id="password" name="password" data-required="1" placeholder="Enter Password" class="form-control input-height" autocomplete="new-password" >
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Confirm Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" name="confirm_password" data-required="1" placeholder="Confirm Password" class="form-control input-height" value="<?php echo set_value('confirm_password'); ?>">
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger',
										        'type'          => 'submit',
										        'content'       => 'Create'
										);

										echo form_button($data);

										$data1 = array(
										        'class'            => 'btn btn-default',
										        'type'          => 'button',
										        'content'       => 'Cancel',
										        'onclick'		=> "javascript:window.history.go(-1);"
										);

										echo form_button($data1);
									?>
								</div>
							</div>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#create_user" ).validate({
			rules: {
				/*region_id:{
					required: true
				},
				site_id:{
					required: true
				},*/
				user_name: {
		      		required: true,
		      		minlength: 4
		    	},
		    	user_email: {
		    		required: true,
		    		email: true
		    	},
				password: {
		      		required: true,
		      		minlength: 6
		    	},
				confirm_password: {
		      		required: true,
		      		equalTo: "#password"
		    	}
			}
		});

		/*$( "#create_user" ).on('submit', function(e){
			var album_text = [];
			$("select[name='user_role[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text.push(value);
			    }
			});
			    	
			if (album_text.length === 0) {
			    //console.log('field is empty');
			    $( "#user_role-error_custome" ).show();
			    $( "#user_role-error_custome" ).text('This field is required.');
			    e.preventDefault();
			}
		});*/

		$('.check_unique').on('blur',function(){

	      var table = 'users';
	      var id = $(this).attr('id');
	      var column, value;

	      switch (id) {

	          case "user_name":
	              column  = 'username';
	              value   = $(this).val();
	              break;

	          case "user_email":
	              column  = 'email_id';
	              value   = $(this).val();
	              break;

	          default:
	      }
	      console.log(column);

	    });
	});

	$('#create_user').disableAutoFill();
</script>

