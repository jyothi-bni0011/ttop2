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
					$hidden = array('region_id' => $this->session->userdata('region_id'), 'site_id' => $this->session->userdata('site_id'));
					$attributes = array('class' => 'form-horizontal', 'id' => 'create_project', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('project/create', $attributes, $hidden);
					if($this->session->userdata('role_id') == 1){
						$selected_reg = $selected_site = '';
						$disabled = '0';
					}else{
						$selected_reg = $this->session->userdata('region_id');
						$selected_site = $this->session->userdata('site_id'); 
						$disabled = "1";
						$options_st[$userdata->site_id]  = $userdata->site_name;
					}
				?>
				
					<div class="form-body">

						<div class="form-group row">
			                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
			                  <?php //if( (int)$this->session->userdata('role_id') == 1 ) : ?>
			                  		<div class="col-md-5">
										<?php 
											$options['']  = 'Select Region';
											foreach ($regions as $region) {
												$options[$region->reg_id]  = $region->region_name;
											}

											if($disabled == 1){
												$css = array(
											        'id'       => 'region_name',
											        'class'    => 'form-control input-height',
											        'disabled'	=> 'disabled'
												);
											}else{
												$css = array(
											        'id'       => 'region_name',
											        'class'    => 'form-control input-height',
											    );
											}

											echo form_dropdown('region_name', $options, $selected_reg, $css);
										?>
		                    	  	</div>	
			                  
		              	</div>

		              	<div class="form-group row">
							<label class="control-label col-md-3">Site
								<span class="required"> * </span>
							</label>
							
							<?php //if( (int)$this->session->userdata('role_id') == 1 ) : ?>
		                  		<div class="col-md-5">
									<?php 
										$options_st['']  = 'Select Site';
										if($disabled == 1){
											$css = array(
										        'id'       => 'site_name',
										        'class'    => 'form-control input-height',
										        'disabled'=> 'disabled'
											);
										}else{
											$css = array(
										        'id'       => 'site_name',
										        'class'    => 'form-control input-height'
										        
											);
										}
										

										echo form_dropdown('site_name', $options_st, $selected_site, $css);
									?>
	                    	  	</div>	
		                  	
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">SAP Number
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'project_id',
									'placeholder' => 'Enter SAP Number',
									'class' => 'form-control input-height',
									'value' => set_value('project_id'),
									'data-required' => "1"
								);
								echo form_input($data); ?>
								<span id="sap_duplicate_span"></span>
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
								'value' => set_value('project_name'),
								'data-required' => "1"
							);
							echo form_input($data); ?>
							<span id="proj_duplicate_span"></span>
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
								'value' => set_value('project_budget'),
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
									$options1['']  = 'Select Project Type';
									$options1['region']  = 'Region';
									$options1['site']  = 'Site';
									$options1['global']  = 'Global';
									
									$css = array(
									        'id'       => 'project_type',
									        'class'    => 'form-control input-height',
									        'onchange' => 'togglesupervisor()'
									);

									echo form_dropdown('project_type', $options1, '', $css);
								?>
		                  </div>
		              	</div>

		              	<div style="display:none;" class="form-group row" id="supervisorblock">
		                  <label class="control-label col-md-3">Supervisor <span class="required"> * </span> </label>
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
									echo form_dropdown('supervisor_id', $options_sv, '', $css);
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

									echo form_dropdown('explicite_subtask', $options2, '', $css);
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
									'value' => set_value('owner'),
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
									        
									);

									// if ( ! empty( $userdata->cost_center_id ) ) 
									// {
									// 	$css['disabled'] = 'disabled';	
									// }
									echo form_dropdown('cost_center', $options_ccn, '', $css);
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
							echo form_input($data); ?>
		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="start_date_error" value="" />
		                  
		                </div>

		                <div class="form-group row">
		                  <label class="col-md-3 control-label">End Date <span class="required"> * </span></label>
		                  <div class="input-group date form_date_end col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'end_date',
								'id' =>	'end_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'readonly' => 1
							);
							echo form_input($data); ?>

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
									'value' => set_value('project_description'),
									'rows' => "3"
								);
								echo form_textarea($data); ?>
							</div>
						</div>
						<input type="hidden" name="continue_with_subtask" id="continue_with_subtask" value="" />
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger continue_subtask',
										        'type'          => 'button',
										        'content'       => 'Continue'
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

<!-- Subtask Confirmation Modal -->
<div class="modal fade" id="activation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" rloe="document">
        <div class="modal-content">
            <div class="modal-body">
                Do you want to create subtask?
            </div>
            <div class="modal-footer">
                	
                    <button type="button" class="btn btn-secondary submit_form" data-val='no' data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger submit_form" data-val='yes' data-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- Activation Modal End -->

<script type="text/javascript">
	$(document).ready(function(){

		// $('#proj_duplicate').hide();
		// $('#sap_duplicate').hide();

		$('.continue_subtask').on('click', function(){   
			if($( "#create_project" ).valid()){
            	$('#activation_modal').modal('show');
   //          var id = $(this).attr('data-val');  
			// alert(id);
			}               
        });

        $('.submit_form').click(function(){
        	var value = $(this).attr('data-val');
        	//alert(value);
        	$('#continue_with_subtask').val(value);
        	$( "#create_project" ).submit();
        	
        });

        
		$( "#create_project" ).validate({
			
			rules: {
				region_name: {
		      		required: true
		    	},
		    	site_name: {
		      		required: true
		    	},
				project_id: {
		      		required: true,
                                remote: {
                        url: "<?php echo base_url('project/create/check_duplicate'); ?>",
                        type: "post",
                        data: {
                             feild:"project_id",
                            user_name: function () {
                                return $("#project_id").val();
                            }
                        }
                    }
		    	},
		    	project_name: {
		      		required: true,
                        remote: {
                        url: "<?php echo base_url('project/create/check_duplicate'); ?>",
                        type: "post",
                        data: {
                             feild:"project_name",
                            user_name: function () {
                                return $("#project_name").val();
                            }
                        }
                    }
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
                        messages: {
        
        project_id: {
            remote: "Project ID already in use",
        },
        project_name:{
        remote: "Project name already in use",
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
        //code for validation of enddate; creted by: jyothi; created on :13/07/2019
	$('#end_date').on('click',function(){
            var start_date=$('#start_date').val();
            if(start_date==""){
               alert("Please Select Start Date"); 
            }
        });
        //code end
	$('#start_date').on('change',function(){

      if ( $('#start_date').val() ) {
        //$('#start_date_error').show();
        $('#start_date-error').hide(); 
      }
      
    });

    $('#end_date').on('change',function(){

      if ( $('#end_date').val() ) {
        //$('#end_date_error').show();
        $('#end_date-error').hide(); 
      }
      
    });

    $('[name=project_id]').on('change', function(){
    	$('#sap_duplicate').hide();
    });

    $('[name=project_name]').on('change', function(){
    	$('#proj_duplicate').hide();
    });

	$('#create_project').submit(function(e){

		if ( $('#cost_center').attr('disabled') == 'disabled' && $(this).valid() ) 
		{
			$('#cost_center').attr('disabled', false);	
		}
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