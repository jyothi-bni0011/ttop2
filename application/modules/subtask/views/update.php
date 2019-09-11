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
				<?php 
				$hidden = array('region_id' => $project_reg_id, 'site_id' => $project_site_id, 'subtask_id' => $subtask_id, 'project_id' => $project_id);
				$attributes = array('class' => 'form-horizontal', 'id' => 'update_subtask', 'method' => 'POST', 'autocomplete' => "off"); 
				echo form_open('subtask/update', $attributes, $hidden); ?>
					<div class="form-body">
						
						<div class="form-group row">
			                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
			                  <div class="col-md-5">
			                  		<?php 
										$data = array(
											'name' => 'region_name',
											'placeholder' => 'Enter Region Name',
											'class' => 'form-control input-height',
											'value' => $project_reg_name,
											'data-required' => "1",
											'readonly' => 'readonly'
										);
										echo form_input($data); 
									?>
	                    	  </div>
		                  
		              	</div>

		              	<div class="form-group row">
							<label class="control-label col-md-3">Site
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$data = array(
										'name' => 'site_name',
										'placeholder' => 'Enter Site Name',
										'class' => 'form-control input-height',
										'value' => $project_site_name,
										'data-required' => "1",
										'readonly' => 'readonly'
									);
									echo form_input($data); 
								?>
                    		</div>
						</div>

						
						
						<div class="form-group row">
							<label class="control-label col-md-3">Project
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$options['']  = 'Select Project';
									foreach((array)$projects as $project){
										$options[$project->id] = $project->project_name;
									}
									$css = array(
									        'id'       => 'project_id',
									        'class'    => 'form-control input-height',
									        'disabled'	=> 'disabled'
									);
									echo form_dropdown('project_id', $options, $project_id, $css);
								?>
							</div>
						</div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Subtask Name
		                  		<span class="required"> * </span> 
		                  </label>
		                  <div class="col-md-5">
		                  <?php 
							$data = array(
								'name' => 'subtask_name',
								'placeholder' => 'Enter Subtask Name',
								'class' => 'form-control input-height',
								'value' => $subtask_name,
								'data-required' => "1"
							);
							echo form_input($data); ?>
						</div>
		                </div>

		                <div class="form-group row">
							<label class="control-label col-md-3">SAP Number
								
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'sap_number',
									'placeholder' => 'Enter SAP Number',
									'class' => 'form-control input-height',
									'value' => $sap_number,
									'data-required' => "1"
								);
								echo form_input($data); ?>
							</div>
						</div>

		                <div class="form-group row">
		                  <label class="control-label col-md-3">Estimated Hours
		                  	<span class="required"> * </span> 
		                  </label>
		                  <div class="col-md-5">
		                  <?php 
							$data = array(
								'name' => 'estimated_hours',
								'placeholder' => 'Enter Estimated Hours',
								'class' => 'form-control input-height',
								'value' => $estimated_hours,
								'data-required' => "1"
							);
							echo form_input($data); ?>
						</div>
		                </div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Status </label>
		                  <div class="col-md-5">
		                    	<?php 
									
									$options3['1']  = 'Active';
									$options3['0']  = 'Inactive';
									
									$css = array(
									        'id'       => 'status',
									        'class'    => 'form-control input-height',
									        
									);

									echo form_dropdown('status', $options3, $status, $css);
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
		$( "#update_subtask" ).validate({
			rules: {
				project_id: {
		      		required: true
		    	},
		    	project_name:{
		    		required: true	
		    	},
		    	estimated_hours: {
		      		required: true,
		      		number: true
		    	}
			}
			
		});
	});
</script>