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
				<form id="change_password" method="POST" action="<?php echo base_url('admin_masters/change_password'); ?>" class="form-horizontal" autocomplete="off">
					<div class="form-body">

						<div class="form-group row">
							<label class="control-label col-md-3">Old Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" name="old_password" data-required="1" placeholder="Enter Old password" class="form-control input-height">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">New Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" name="new_password" id="new_password" data-required="1" placeholder="Enter New password" class="form-control input-height">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">Confirm Password
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<input type="password" name="confirm_password" data-required="1" placeholder="Confirm password" class="form-control input-height">
							</div>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<button type="submit" class="btn btn-danger">Change</button>
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
		$( "#change_password" ).validate({
			rules: {
				old_password: {
		      		required: true,
		    	},
		    	new_password: {
		      		required: true,
		      		minlength: 6
		    	},
		    	confirm_password: {
		    		required: true,
		      		equalTo: "#new_password"
		    	}
			}
			
		});
	});
</script>