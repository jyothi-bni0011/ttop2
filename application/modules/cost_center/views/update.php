<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?php echo $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?php echo $title; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php $attributes = array('class' => 'form-horizontal', 'id' => 'update_cost_center', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('cost_center/update', $attributes); ?>
					<div class="form-body">
						<input type="hidden" name="cost_center_id" value="<?php echo $cost_center_id; ?>">
						
						<div class="form-group row">
							<label class="control-label col-md-3">Cost Center Code
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'cost_center_code',
									'placeholder' => 'Enter Cost Center Code',
									'class' => 'form-control input-height',
									'value' => $cost_center_code,
									'data-required' => "1"
								);
								echo form_input($data); 
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Cost Center Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'cost_center_name',
									'placeholder' => 'Enter Cost Center Name',
									'class' => 'form-control input-height',
									'value' => $cost_center_name,
									'data-required' => "1"
								);
								echo form_input($data); 
								?>
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
		$( "#update_cost_center" ).validate({
			rules: {
				cost_center_name: {
		      		required: true
		    	},
		    	cost_center_code: {
		    		required: true
		    	}
			}
			
		});
	});
</script>