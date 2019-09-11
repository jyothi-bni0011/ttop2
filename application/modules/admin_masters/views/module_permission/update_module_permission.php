<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?= $title; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<form id="assign_doc" method="POST" action="<?php echo base_url('admin_masters/module_permission/update_module_permissions/').$role_id; ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="role_id" value="<?= $role_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-2"><b>Menues</b>
								<span class="required"> * </span>
							</label>
							<div class="col-md-2">
								<?php foreach( $menues as $menu ): ?>
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" class="form-check-input" id="<?= $menu->{MENU_NAME}; ?>" name="menu[]" value="<?= $menu->{MENU_ID} ?>" <?php foreach( $assigned_menues as $assign_menu ){ if($assign_menu->{MENU_ID} == $menu->{MENU_ID}) echo 'checked'; } ?> <?php if($menu->{MENU_ID} == 1) : ?> checked onclick="return false;" <?php endif; ?> ><?= $menu->{MENU_NAME} ?>
									  </label>
									</div>
								<?php endforeach; ?>
							</div>
						<!--</div>

						<div class="form-group row">-->
							<label class="control-label col-md-2"><b>Create User Permission</b>
							</label>
							<div class="col-md-2">
								<?php 
								foreach( $roles as $role ): 
									?>
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" class="form-check-input user_toggle" name="roles[]" value="<?= $role->{ROLE_ID} ?>" <?php if(in_array($role->{ROLE_ID}, (array)$permissions)) echo 'checked'; ?>><?= $role->{ROLE_NAME} ?>
									  </label>
									</div>
								<?php endforeach; ?>
							</div>

							<label class="control-label col-md-2"><b>Project Assign Permission</b>
							</label>
							<div class="col-md-2">
								<?php 
								foreach( $roles as $role ): 
									?>
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" class="form-check-input" name="roles_ps[]" value="<?= $role->{ROLE_ID} ?>" <?php if(in_array($role->{ROLE_ID}, (array)$permissions_ps)) echo 'checked'; ?>><?= $role->{ROLE_NAME} ?>
									  </label>
									</div>
								<?php endforeach; ?>
							</div>

						</div>
						
						
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-5 col-md-9">
									<button type="submit" class="btn btn-danger">Update</button>
									<button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#create_department" ).validate({
			rules: {
				department_name: {
		      		required: true,
		      		maxlength: 50
		    	},
		    	department_description: {
		      		required: true,
		      		maxlength: 255
		    	}
			}
			
		});

		if ( ! $('#Users').prop("checked") ) 
		{
			$('.user_toggle').prop('disabled', true);
		}
	});

	$('#Users').on('click',function(){
		if ($(this).prop("checked")) 
		{
	        $('.user_toggle').prop('disabled', false);
	    }
	    else
	    {
	        // $('.user_toggle').prop('checked', false);
	        $('.user_toggle').prop('disabled', true);
	    }
	});
</script>