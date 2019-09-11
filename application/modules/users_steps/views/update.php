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
				$hidden = array('region_id' => $reg_id, 'site_id' => $site_id);
				$attributes = array('class' => 'form-horizontal', 'id' => 'update_user', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('users/update', $attributes, $hidden);
				?>
					<div class="form-body">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

						<div class="form-group row">
		                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    <?php 
		                    	$options[$reg_id]  = $reg_name;
								
								$css = array(
								        'id'       => 'region_id',
								        'class'    => 'form-control input-height',
								        'disabled' => 'disabled'
								);
								echo form_dropdown('region_id', $options, $reg_id, $css);
							?>

		                  </div>
		                  
		              	</div>

		              	<div class="form-group row">
		                  <label class="control-label col-md-3">Site <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    <?php 
								$options_site[$site_id]  = $site_name;
								
								$css = array(
								        'id'       => 'site_id',
								        'class'    => 'form-control input-height',
								        'disabled' => 'disabled'
								);
								echo form_dropdown('site_id', $options_site, $site_id, $css);
							?>

		                  </div>
		                  
		              	</div>

		              	<div class="form-group row">
							<label class="control-label col-md-3">Employee ID
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="employee_id" data-required="1" placeholder="Enter Employee ID" class="form-control input-height" value="<?php echo $employee_id; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Username
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" name="user_name" data-required="1" placeholder="Enter Username" class="form-control input-height" value="<?php echo $user_name; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">First Name
								
							</label>
							<div class="col-md-5">
								<input type="text" name="user_first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" value="<?php echo $user_first_name; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Middle Name
								
							</label>
							<div class="col-md-5">
								<input type="text" name="user_middle_name" data-required="1" placeholder="Enter Middle Name" class="form-control input-height" value="<?php echo $user_middle_name; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Last Name
								
							</label>
							<div class="col-md-5">
								<input type="text" name="user_last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" value="<?php echo $user_last_name; ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Role
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select class="form-control input-height select2-multiple" name="user_role[]" id="user_role" multiple>
                                   <option value="">Select User Role </option>
                                   <?php foreach($roles as $role): ?>
                                   		
		                           			<option value="<?php echo $role->{ROLE_ID}; ?>"<?php  if(in_array($role->{ROLE_ID}, $user_roles) ) echo "selected"; ?> > <?php echo $role->{ROLE_NAME}; ?> </option>
		                           		
		                           <?php endforeach; ?>
                                </select> 

                                <label id="user_role-error_custome" class="error" style="display: none;">This field is required.</label>

							</div>
						</div>

						<?php 
							if(in_array(3, $user_roles) || in_array(4, $user_roles)){
								$display = '';
							}else{
								$display = 'display : none';
							}
						?>

						<div class="form-group row" id="supervisor_selection_div" style="<?php echo $display;?>;">
							<label class="control-label col-md-3">Supervisor 
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<select class="form-control input-height" name="select_supervisor" id="select_supervisor">
                                   <option value="">Select Supervisor </option>
                                   <?php foreach($supervisors as $sv): ?>
                                   		
			                           <option <?php if((!empty($supervisor_id)) && $supervisor_id == $sv->user_id) echo "selected";  ?> value="<?php echo $sv->user_id; ?>"> <?php echo $sv->name; ?> </option>
			                       
		                       		<?php endforeach; ?>
                                </select> 
							</div>
						</div>

						<?php 
							if(in_array(2, $user_roles)){
								$display1 = '';
							}else{
								$display1 = 'display : none';
							}
						?>
						
						<div class="form-group row" id="portal_selection_div" style="<?php echo $display1;?>;">
							<label class="control-label col-md-3">Portals
								
							</label>
							<div class="col-md-5">

								<select class="form-control input-height select2-multiple" name="portal_selection[]" id="portal_selection" multiple>
                                   <option value="">Select Portal </option>
                                   <?php foreach($portals as $portal): ?>
                                   	   <option value="<?php echo $portal->{PORTAL_ID}; ?>" <?php if(in_array($portal->{PORTAL_ID}, (array)$selected_portal) ) echo "selected";?>> <?php echo $portal->{PORTAL_NAME}; ?> </option>
			                       
		                       		<?php endforeach; ?>
                                </select> 

								
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Email
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="text" readonly name="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height" value="<?php echo $email_id; ?>">
							</div>
						</div>

						
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger',
										        'type'          => 'submit',
										        'content'       => 'Update'
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
		$( "#update_user" ).validate({
			rules: {
				user_name: {
		      		required: true,
		      		minlength: 4
		    	},
		    	user_email: {
		    		required: true,
		    		email: true
		    	}
			}
			
		});



		$( "#update_user" ).on('submit', function(e){
			
			var album_text = [];
			$("select[name='user_role[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text.push(value);
			    }
			});
			    	
			if (album_text.length === 0) {
			    console.log('field is empty');
			    $( "#user_role-error_custome" ).show();
			    $( "#user_role-error_custome" ).text('This field is required.');
			    e.preventDefault();
			}

		});

		$('#user_role').on('change', function() { 
			var roles = new Array();
			roles = $('#user_role').val();
			//alert(jQuery.type(roles));
		 	if($.inArray('2', roles) >  -1){ 
		 	 	$('#portal_selection_div').show();
		 	}else{
		 		$('#portal_selection_div').hide();
		 	}

		 	if (($.inArray('3', roles) >  -1) || ($.inArray('4', roles) >  -1)){
		 		$('#supervisor_selection_div').show();
		 	}else{ 
		 		$('#supervisor_selection_div').hide();
		 	}
		 	
		 	
		});
	});
</script>