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
					//$hidden = array('region_id' => $userdata->region_id, 'site_id' => $userdata->site_id);
					$attributes = array('class' => 'form-horizontal', 'id' => 'create_subtask', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('subtask/create', $attributes);
					//echo "<pre>"; print_r($continue_from_project); exit;
					if(isset($continue_from_project) && $continue_from_project == 1){
						$selected_reg = $region_id;
						$selected_site = $site_id;
						$selected_project = $project_id;
						$disabled = "disabled";
						$disable_project = 'disabled';
						$options_site[$selected_site]  = $site_name;
						echo "<input type='hidden' name='project_id' value=$project_id>";
					}else if($this->session->userdata('role_id') == 1){
						$selected_reg = $selected_site = $selected_project = '';
						$disabled = 'enabled';
						$disable_project = 'enabled';
					}else{
						$selected_reg = $this->session->userdata('region_id');
						$selected_site = $this->session->userdata('site_id'); 
						$selected_project = '';
						$disabled = "disabled";
						$disable_project = 'enabled';
						$options_site[$userdata->site_id]  = $userdata->site_name;
					}
				?>
				
					<div class="form-body">

						<div class="form-group row">
			                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
			                  <div class="col-md-5">
			                  		<?php 
										$options_reg['']  = 'Select Region';
										foreach((array)$regions as $region){
											$options_reg[$region->reg_id] = $region->region_name;
										}
										
										$css = array(
									        'id'       => 'region_id',
									        'class'    => 'form-control input-height',
									        'onchange' => 'get_sites(this.value)',
									        $disabled => 1
										);
																				
										echo form_dropdown('region_id', $options_reg, $selected_reg, $css);
									?>
	                    	  </div>
		                  
		              	</div>

		              	<div class="form-group row">
							<label class="control-label col-md-3">Site
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$options_site['']  = 'Select Site';
									/*foreach($site_array as $site_val){
										$options_site[$site_val->site_id]  = $site_val->site_name;
									}*/
									$css = array(
								        'id'       => 'site_id',
								        'class'    => 'form-control input-height',
								        $disabled => 1
									);
									
									echo form_dropdown('site_id', $options_site, $selected_site, $css);
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
									        $disable_project => 1
									        
									);
									echo form_dropdown('project_id', $options, $selected_project, $css);

								?>
							</div>
						</div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Sub Task Name
		                  		<span class="required"> * </span> 
		                  </label>
		                  <div class="col-md-5">
		                  	<?php 
							$data = array(
								'name' => 'subtask_name',
								'placeholder' => 'Enter Subtask Name',
								'class' => 'form-control input-height',
								'value' => set_value('subtask_name'),
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
									'value' => set_value('sap_number'),
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
								'value' => set_value('estimated_hours'),
								'data-required' => "1",
								'type' => 'number',
                                                            'min'=>'0','max'=>'9999',
							);
							echo form_input($data); ?>
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

										if(isset($project_flag) && $project_flag == 1){
											$base_url_path = 'project';
											//$this->session->set_flashdata('message', '<div class="alert alert-success">Project created successfuly..</div>');
											// echo "In project";
										}else{
											$base_url_path = 'subtask';
										}
										$data1 = array(
										        'class'            => 'btn btn-default',
										        'type'          => 'button',
										        'content'       => 'Cancel',
										        'onclick'		=> "javascript:window.location.replace('" . base_url("$base_url_path") . "')"
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
		$( "#create_subtask" ).validate({
			rules: {
				region_id:{
					required: true
				},
				site_id:{
					required: true
				},
				project_id: {
		      		required: true
		    	},
		    	subtask_name: {
		      		required: true
		    	},
		    	estimated_hours: {
		      		required: true,
		      		number: true
		    	}
			}
			
		});

	});

	function get_sites(id){ 
	if(id!=''){ 

		var dataString = 'region_id='+ id;
		$.ajax
		({

			type: "POST",
			url: "<?php echo base_url('users/getsite');?>",
			data: dataString,
			cache: false,
			dataType: "JSON",
			success: function(data)
			{ 
				var len = data.site_opt.length;
				var options_data = '<option>Select Site</option>';
				for(var i=0; i<len; i++){
					options_data += '<option value='+data.site_opt[i].site_id+'>'+data.site_opt[i].site_name+'</option>';
				}
				$('#site_id').html(options_data);			
			} 
		});
	}else{
		$('#site_id').html('<option>Select Site</option>');
		
	}
}
</script>