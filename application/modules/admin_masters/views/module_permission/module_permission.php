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
				<form id="assign_doc" method="POST" action="<?php echo base_url('admin_masters/module_permission/assign_module_permissions/').$role_id; ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">
						<input type="hidden" name="role_id" value="<?= $role_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-3">Menues
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php foreach( $menues as $menu ): ?>
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" class="form-check-input" name="menu[]" value="<?= $menu->{MENU_ID} ?>" <?php if($menu->{MENU_ID} == 1) : ?> checked onclick="return false;" <?php endif; ?> ><?= $menu->{MENU_NAME} ?>
									  </label>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						
						
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<button type="submit" class="btn btn-danger">Create</button>
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
	});
</script>