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
				<?php $hidden = array('project_type'=> $assign_project_type, 'project_name'=>$assign_project_id, 'assign_project_id'=>$assign_id);
					$attributes = array('class' => 'form-horizontal', 'id' => 'update_assign_project', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('assign_project/update', $attributes, $hidden); ?>
					<div class="form-body">
						
						<input type="hidden" name="assign_role" id="assign_role" value="<?php echo $assigned_role; ?>">
						
						<div class="form-group row">
							<label class="control-label col-md-3">Project Type
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$site_id = $this->session->userdata('site_id');
									$options1['']  = 'Select Project Type';
									$options1['global']  = 'Global';
									$options1['region']  = 'Region';
									$options1['site']  = 'Site';
									
									$css = array(
									        'id'       => 'project_type',
									        'class'    => 'form-control input-height',
									        'disabled' => 'disabled'
									);

									echo form_dropdown('project_type', $options1, $assign_project_type, $css);
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Project 
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$options_projects['']  = 'Select Project';
									$options_projects[$assign_project_id]  = $assign_project_name;
									
									$css = array(
									        'id'       => 'project_name',
									        'class'    => 'form-control input-height',
									        'disabled' => 'disabled'
									);

									echo form_dropdown('project_name', $options_projects, $assign_project_id, $css);
								?>

							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Sub Task
							</label>
							<div class="col-md-5">
								<?php 

									$st_id = explode(",", $all_subtaskids);
									$st_name = explode(",", $all_subtasks);
                                    //$options_st['']  = 'Select Project';   

                                    foreach($st_id as $k=>$st){
                                    	$options_st[$st]  = $st_name[$k];
                                    }

                                    if($exp_subtask == 'no'){
                                    	$css = array(
									        'id'       => 'subtask_id',
									        'class'    => 'form-control input-height select2-multiple',
									        'multiple' => 'multiple',
									        'disabled' => 'disabled'
										);
										$assigned_subtask = $st_id;
                                    }else{
                                    	$css = array(
									        'id'       => 'subtask_id',
									        'class'    => 'form-control input-height select2-multiple',
									        'multiple' => 'multiple'
									        
										);
                                    }
                                                        
									echo form_dropdown('subtask_id[]', $options_st, $assigned_subtask, $css);
								?>
							</div>
						</div>
						<?php if($assign_project_type != 'site'){ ?>
						<div class="form-group row" id="site_div">
							<label class="control-label col-md-3">Sites
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								
								<?php 
									$options_site['']  = 'Select Site';
									foreach($sites as $site){
										$options_site[$site->site_id]  = $site->site_name;
									}
									
									$css = array(
									        'id'       => 'site_name',
									        'class'    => 'form-control input-height',
									        'onchange' => 'get_uservalue(this.value);',
									        //'multiple' => 'multiple'
									);

									echo form_dropdown('site_name', $options_site, array($assign_site_id), $css);
								?>

							</div>
						</div>
					<?php }?>
						<div class="form-group row">
							<label class="control-label col-md-3"><?php if($this->session->userdata('role_name')=='Supervisor'){
                                                                echo "Engineer";
                                                            }else{
                                                                echo "Engineer / Supervisor";
                                                            }?>
								<span class="required"> * </span>
							</label>
							<div class="col-md-5 ">
								
								<?php 
									$options_user['']  = 'Select Engineer/Supervisor';
									foreach($users as $user){
										$options_user[$user->user_id]  = $user->name;
									}
									
									$css = array(
									        'id'       => 'user_name',
									        'class'    => 'form-control input-height',
									        //'disabled' => 'disabled'
									);

									echo form_dropdown('user_name', $options_user, $assign_user_id, $css);
								?>

							</div>
						</div>

						<div class="form-group row">
		                  <label class="col-md-3 control-label">Start Date <span class="required"> * </span></label>
		                  <div class="input-group date form_date form_date_start col-md-5 startD" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'start_date',
								'id' =>	'start_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'readonly' => 1,
								'value' => $from_date
							);
							echo form_input($data); ?>
                                      
		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="start_date_error" value="" />
		                </div>

		                <div class="form-group row">
		                  <label class="col-md-3 control-label">End Date<span class="required"> * </span></label>
		                  <div class="input-group date form_date form_date_end col-md-5 endD" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'end_date',
								'id' =>	'end_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'readonly' => 1,
								'value' => $to_date
							);
							echo form_input($data); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="end_date_error" value="" />
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
										        'onclick'		=> "javascript:window.location.replace('" . base_url('assign_project') . "')"
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
<style type="text/css">


.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}

</style>
<script type="text/javascript">
	var st_date = "<?php echo $project_start_date; ?>";
	var ed_date = "<?php echo $project_end_date; ?>";

	$(document).ready(function(){
		$( "#update_assign_project" ).validate({
			rules: {
				site_name:{
					required: true	
				},
		    	start_date:{
		    		required: true	
		    	},
		    	end_date:{
		    		required: true	
		    	},
		    	user_name:{
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

	//Before form submit make the subtask dropdown enable to submit data by post
	$('#update_assign_project').submit(function() {
            var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());
        if (startDate > endDate) {
            alert('Please ensure that the End Date is greater than Start Date.');return false;
        }
		$('#subtask_id').prop('disabled',false);
		$('#user_name').prop('disabled',false);
	});

	function get_uservalue(site){
		
		site = $('select#site_name').val();
		user_type = $('#assign_role').val();

		var dataString = 'user_type='+ user_type +'&site_id='+site;
		
		$.ajax
		({
			type: "POST",
			url: "<?php echo base_url('assign_project/getuserdata');?>",
			data: dataString,
			cache: false,
			dataType: "JSON",
			success: function(data)
			{
				
				var len = data.length;
				var options_data = '';
				for(var i=0; i<len; i++){
					options_data += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				
				$('#user_name').html(options_data);
			
			} 
		});
	}

	$('#start_date').change(function(){
		$('.form_date_end').datetimepicker('remove');
		$('.form_date_end').datetimepicker({
		    weekStart: 1,
		    todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0,
			startDate : new Date( $(this).val() ),
			endDate : ed_date
		});
	});

	$('#end_date').change(function(){
		$('.form_date_start').datetimepicker('remove');
		$('.form_date_start').datetimepicker({
		    weekStart: 1,
		    todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0,
			startDate : st_date,
			endDate : new Date( $(this).val() )
		});
	});

</script>