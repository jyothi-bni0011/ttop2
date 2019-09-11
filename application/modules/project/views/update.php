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
				$hidden = array('region_id' => $project_reg_id, 'site_id' => $project_site_id, 'project_id' => $project_id);
				$attributes = array('class' => 'form-horizontal', 'id' => 'update_project', 'method' => 'POST', 'autocomplete' => "off"); 
				echo form_open('project/update', $attributes, $hidden); ?>
					<div class="form-body">
						
						<div class="form-group row">
			                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
			                  <?php if( (int)$this->session->userdata('role_id') == 1 ) : ?>
			                  		<div class="col-md-5">
										<?php 
											$options['']  = 'Select Region';
											foreach ($regions as $region) {
												$options[$region->reg_id]  = $region->region_name;
											}
											
											$css = array(
											        'id'       => 'region_name',
											        'class'    => 'form-control input-height',
											);

											echo form_dropdown('region_name', $options, $project_reg_id, $css);
										?>
		                    	  	</div>	
			                  <?php else : ?>
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
		                  	  <?php endif; ?>
		              	</div>

		              	<div class="form-group row">
							<label class="control-label col-md-3">Site
								<span class="required"> * </span>
							</label>
							<?php if( (int)$this->session->userdata('role_id') == 1 ) : ?>
		                  		<div class="col-md-5">
									<?php 
										$options_st['']  = 'Select Site';
										if ( ! empty( $site_list ) ) 
										{
											foreach ($site_list as $key => $sites) 
											{
												$options_st[$sites->site_id]  = $sites->site_name;		
											}
										}
										$css = array(
										        'id'       => 'site_name',
										        'class'    => 'form-control input-height',
										);

										echo form_dropdown('site_name', $options_st, $project_site_id, $css);
									?>
	                    	  	</div>	
		                  	<?php else : ?>
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
                    	<?php endif; ?>
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">SAP Number
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'sap_id',
									'placeholder' => 'Enter SAP Number',
									'class' => 'form-control input-height',
									'value' => $sap_no,
									'data-required' => "1"
								);
								echo form_input($data); ?>
							</div>
						</div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Project Name
		                  		<span class="required"> * </span> 
		                  </label>
		                  <div class="col-md-5">
		                  <?php 
							$data = array(
								'name' => 'project_name',
								'placeholder' => 'Enter Project Name',
								'class' => 'form-control input-height',
								'value' => $project_name,
								'data-required' => "1"
							);
							echo form_input($data); ?>
						</div>
		                </div>

		                <div class="form-group row">
		                  <label class="control-label col-md-3">Project Budget</label>
		                  <div class="col-md-5">
		                  <?php 
							$data = array(
								'name' => 'project_budget',
								'placeholder' => 'Enter Project Budget',
								'class' => 'form-control input-height',
								'value' => $project_budget,
								'data-required' => "1",
								'type' => 'number'
							);
							echo form_input($data); ?>
						</div>
		                </div>

          				<div class="form-group row">
		                  <label class="control-label col-md-3">Project Type <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    	<?php 
									$options['']  = 'Select Project Type';
									$options['region']  = 'Region';
									$options['site']  = 'Site';
									$options['global']  = 'Global';
									
									$css = array(
									        'id'       => 'project_type',
									        'class'    => 'form-control input-height',
									        'onchange' => 'togglesupervisor()'
									);

									echo form_dropdown('project_type', $options, $project_type, $css);
								?>
		                  </div>
		              	</div>
		              	<?php 
		              		$display = '';
		              		if($project_type != 'site'){ 
		              			$display = 'display:none;';
		              		} 
		              	?>
		              	<div style="<?php echo $display;?>" class="form-group row" id="supervisorblock">
		                  <label class="control-label col-md-3">Supervisor <span class="required"> * </span></label>
		                  <div class="col-md-5">
		                    	<?php 
									$options_sv['']  = 'Select Supervisor';
									foreach($supervisordata as $supervisor_data)  {
										$options_sv[$supervisor_data->user_id]  = $supervisor_data->name;
									}
									
									$css = array(
									        'id'       => 'supervisor_id',
									        'class'    => 'form-control input-height',
									);

									echo form_dropdown('supervisor_id', $options_sv, $supervisor_id, $css);
								?>
		                  </div>
		              	</div>

		              	<div class="form-group row">
		                  <label class="control-label col-md-3">Assign Subtasks Explicitly to Engineers/Supervisors <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    	<?php 
									$options2['']  = 'Select an option';
									$options2['yes']  = 'Yes';
									$options2['no']  = 'No';
									
									$css = array(
									        'id'       => 'explicite_subtask',
									        'class'    => 'form-control input-height',
									);

									echo form_dropdown('explicite_subtask', $options2, $exp_subtask, $css);
								?>
		                  </div>
		              	</div>

		              	<div class="form-group row">
		                  	<label class="control-label col-md-3">Owner</label>
		                  	<div class="col-md-5">
			                  <?php 
								$data = array(
									'name' => 'owner',
									'placeholder' => 'Enter Project Owner Name',
									'class' => 'form-control input-height',
									'value' => $owner,
									'data-required' => "1"
								);
								echo form_input($data); ?>
							</div>
		                </div>

		                <div class="form-group row" id="costcenterblock">
		                  <label class="control-label col-md-3">Cost Center Name <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    	<?php 
									$options_ccn['']  = 'Select Cost Center';
									foreach($cost_centers as $cost_center)  {
										$options_ccn[$cost_center->{CC_ID}]  = $cost_center->{CC_NAME};
									}
									
									$css = array(
									        'id'       => 'cost_center',
									        'class'    => 'form-control input-height',
									        'disabled' => true
									);

									
									echo form_dropdown('cost_center', $options_ccn, $selected_cost_center, $css);	
									

								?>
		                  </div>
		              	</div>

		              	<div class="form-group row">
		                  <label class="col-md-3 control-label">Start Date <span class="required"> * </span></label>
		                  <div class="input-group date form_date form_date_start col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                  	<?php 
							$data = array(
								'name' => 'start_date',
								'id' =>	'start_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'readonly' => 1
							);
							echo form_input($data, $start_date); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="start_date_error" value="" />
		                </div>

		                <div class="form-group row">
		                  <label class="col-md-3 control-label">End Date <span class="required"> * </span></label>
		                  <div class="input-group date form_date form_date_end col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'end_date',
								'id' =>	'end_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'readonly' => 1
							);
							echo form_input($data, $end_date); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="end_date_error" value="" />
		                </div>

		                <div class="form-group row">
							<label class="control-label col-md-3">Project Description
								<span class="required">  </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'project_description',
									'placeholder' => 'Enter Project Description',
									'class' => 'form-control',
									'value' => $project_description,
									'rows' => "3"
								);
								echo form_textarea($data); ?>
							</div>
						</div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Status </label>
		                  <div class="col-md-5">
		                    	<?php 
									$options3['']  = 'Select Status';
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
										        'onclick'		=> "javascript:window.location.replace('" . base_url('project') . "')"
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
		$( "#update_project" ).validate({
			rules: {
				project_id: {
		      		required: true
		    	},
		    	project_name: {
		      		required: true
		    	},
		    	explicite_subtask: {
		      		required: true
		    	},
		    	project_type: {
		      		required: true
		    	},
		    	cost_center:{
		    		required: true	
		    	},
		    	start_date:{
		    		required: true	
		    	},
		    	end_date:{
		    		required: true	
		    	},
		    	supervisor_id:{
		    		required: true	
		    	}
			},
			errorPlacement: function (error, element) {
                error.insertAfter(element);
                if (element.attr("name") == "start_date")
                    error.insertAfter(".start_date_error");
                else if (element.attr("name") == "end_date")
                    error.insertAfter(".end_date_error");

            }
			
		});

	});

	function togglesupervisor()
	{
		var project_type=$("#project_type").val();
		if(project_type=='site')
		{
			$("#supervisorblock").show();
		}
		else
		{
			$("#supervisorblock").hide();
		}
	}

	$('#region_name').change(function(){
		$.ajax
			({
				type: "POST",
				url: "<?php echo base_url('project/find_sites_by_region');?>",
				data: {
					id : $(this).val()
				},
				cache: false,
				dataType: "JSON",
				success: function(data)
				{
					if ( data.success ) 
					{
						var len = data.sites.length;
						var options_data = '<option>Select Site</option>';
						for(var i=0; i<len; i++){
							options_data += '<option value='+data.sites[i].site_id+'>'+data.sites[i].site_name+'</option>';
						}
						$('#site_name').html(options_data);
					}
					else
					{
						var options_data = '<option>Select Site</option>';
						$('#site_name').html(options_data);	
					}
				} 
			});
	});

	$('#site_name').change(function(){
		$.ajax
			({
				type: "POST",
				url: "<?php echo base_url('project/find_cost_center_by_site');?>",
				data: {
					site_id : $(this).val()
				},
				cache: false,
				dataType: "JSON",
				success: function(data)
				{
					if ( data.success ) 
					{
						$('#cost_center').val(data.cost_center.cc_id);
						$('#cost_center').prop('disabled','disabled');
					}
					else
					{
						$('#cost_center').val('');
						$('#cost_center').prop('disabled',false);
					}
				} 
			});
	});
</script>