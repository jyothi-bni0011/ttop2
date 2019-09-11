<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?php echo $title;?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?php echo $title;?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php $attributes = array('class' => 'form-horizontal', 'id' => 'assign_project', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('assign_project/create', $attributes);
				?>
					<div class="form-body">

						<div class="form-group row">
		                  <label class="control-label col-md-3">Assign Project To <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    	<?php 
		                    		$options['']  = 'Select Option';
		                    		if(!empty($assign_permission)){  
			                    		foreach($assign_permission as $role){
			                    			$options[$role->role_id] = $role->role_name;
			                    		}
		                    		}
		                    		
									$css = array(
									        'id'       => 'assign_to',
									        'class'    => 'form-control input-height',
									        'onchange' => 'clearData();'
									);

									echo form_dropdown('assign_to', $options, '', $css);
								?>
		                  </div>
		              	</div>
						
						<div class="form-group row">
							<label class="control-label col-md-3">Project Type
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$site_id = $this->session->userdata('site_id');
									$options1['']  = 'Select Project Type';
									/*$options1['global']  = 'Global';
									$options1['region']  = 'Region';
									$options1['site']  = 'Site';*/
									
									$css = array(
									        'id'       => 'project_type',
									        'class'    => 'form-control input-height',
									        'onchange' => 'get_projects(this.value, '.$site_id.')'
									);

									echo form_dropdown('project_type', $options1, '', $css);
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
									
									$css = array(
									        'id'       => 'project_name',
									        'class'    => 'form-control input-height',
									        'onchange'  => 'get_subtask(this.value)'
									);

									echo form_dropdown('project_name', $options_projects, '', $css);
								?>

							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Sub Task
							</label>
							<div class="col-md-5">
								<?php 
									$options_st['']  = 'Select Project';
									
									$css = array(
									        'id'       => 'subtask_id',
									        'class'    => 'form-control input-height select2-multiple',
									        'multiple' => 'multiple'
									);

									echo form_dropdown('subtask_id[]', $options_st, '', $css);
								?>
							</div>
						</div>
						<div class="form-group row" id="site_div">
							<label class="control-label col-md-3">Sites
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								
								<?php 
//									$options_site['']  = 'Select Site';
									$options_site=[];
									$css = array(
									        'id'       => 'site_name',
									        'class'    => 'form-control input-height select2-multiple',
									        'onchange' => 'get_uservalue(this.value);',
									        'multiple' => 'multiple'
									);

									echo form_dropdown('site_name', $options_site, '', $css);
								?>
								<label id="site-error_custome" style="display: none; color: red;">This field is required.</label>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-3">
                                                            <?php if($this->session->userdata('role_name')=='Supervisor'){
                                                                echo "Engineer";
                                                            }else{
                                                                echo "Engineer / Supervisor";
                                                            }?>
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								
								<?php 
									//$options_user['0']  = 'Select Engineer/Supervisor';
									$options_user = array();
									$css = array(
									        'id'       => 'user_name',
									        'class'    => 'form-control input-height select2-multiple',
									        'multiple' => 'multiple'
									);

									echo form_dropdown('user_name[]', $options_user, '', $css);
								?>
								<label id="eng-error_custome" style="display: none; color: red;">This field is required.</label>
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
								'readonly' => 1
							);
							echo form_input($data); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" class="start_date_error" value="" />
		                </div>

		                <div class="form-group row">
		                  <label class="col-md-3 control-label">End Date <span class="required"> * </span></label>
		                  <div class="input-group date form_date form_date_end col-md-5 endD" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

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
	

	$(document).ready(function(){
		$( "#assign_project" ).validate({
			rules: {
				assign_to: {
		      		required: true
		    	},
		    	project_type: {
		    		required: true
		    	},
		    	project_name: {
		    		required: true
		    	},
		    	 // site_name: {
		    	 // 	required: true
		    	 // },
                         // "user_name[]":{
                         //     required: true
                         // },
		    	start_date:{
		    		required: true	
		    	},
		    	end_date:{
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


	function get_projects(val, site_id){
		if(val){

			if('site' == val){

				$('#site_div').hide();
			}else{

				$('#site_div').show();	
			}

			var role_id = $('#assign_to').val();
			var dataString = 'type='+ val + '&site_id=' + site_id + '&role_id=' + role_id;
			$.ajax
			({
				type: "POST",
				url: "<?php echo base_url('assign_project/getprojects_and_sites');?>",
				data: dataString,
				cache: false,
				dataType: "JSON",
				success: function(data)
				{
					//alert(data.project.length);
					$('#subtask_id').html('');
					var len = data.project.length;
					var options_data = '<option value="">Select Project</option>';
					for(var i=0; i<len; i++){
						options_data += '<option value='+data.project[i].project_id+'>'+data.project[i].project_name+'</option>';
					}
					var len_site = data.site.length;
					var options_site_data = '';
					for(var i=0; i<len_site; i++){
						options_site_data += '<option value='+data.site[i].site_id+'>'+data.site[i].site_name+'</option>';
					}

					var len_sv = data.supervisor.length;
					var options_sv_data = '';
					for(var i=0; i<len_sv; i++){
						options_sv_data += '<option value='+data.supervisor[i].id+'>'+data.supervisor[i].name+'</option>';
					}

					$('#project_name').html(options_data);
					$('#site_name').html(options_site_data);
					$('#user_name').html(options_sv_data);
				} 
			});
		}else{
			$('#project_name').html('<option>Select Project</option');
			$('#site_name').html('');
			$('#subtask_id').html('');
		}
	}

	function get_subtask(project_id){
		var dataString = 'project_id='+ project_id;
		$.ajax
		({
			type: "POST",
			url: "<?php echo base_url('assign_project/getsubtasks');?>",
			data: dataString,
			cache: false,
			dataType: "JSON",
			success: function(data)
			{
				// console.log(data.subtask_opt);
				var len = data.subtask_opt.length;
				var options_data = '';
				for(var i=0; i<len; i++){
					if($.inArray(data.subtask_opt[i].subtask_id, data.selected_subtask)){
						var selected = 'selected';
					}
					options_data += '<option '+selected+' value='+data.subtask_opt[i].subtask_id+'>'+data.subtask_opt[i].subtask_name+'</option>';
				}
				
				$('#subtask_id').html(options_data);

				if(data.project_info.explicite_subtask == 'no'){
					$('#subtask_id').prop('disabled',true);	
					//$('#subtask_id').prop('title', 'Explicite Subtask field is No');
				}else{
					$('#subtask_id').prop('disabled',false);	
				}
				
				
				//alert(data.project_info.end_date+ '' +data.project_info.start_date)

				// console.log(new Date( data.project_info.start_date ));
				//$('.startD').removeClass('form_date');
				start = new Date( data.project_info.start_date );
				end = new Date( data.project_info.end_date );

				$('.form_date').datetimepicker('remove');
				$('.form_date').datetimepicker({
				    weekStart: 1,
				    todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0,
					startDate : new Date( data.project_info.start_date ),
					endDate : new Date( data.project_info.end_date )
				});
			} 
		});
	}

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

	//Before form submit make the subtask dropdown enable to submit data by post
	$('#assign_project').submit(function(e) {

		// if($('#assign_project').valid()){
			// alert();
			var album_text = [];
			var album_text1 = [];
			if ( $('#site_name').is(":visible") ) {

				$("select[name='site_name']").each(function() {
				    var value = $(this).val();
				    if (value != '') {
				        album_text.push(value);
				    }
				});
			} else {
				album_text=[1];
			}
			$("select[name='user_name[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text1.push(value);
			    }
			});
			if ( album_text.length === 0 && album_text1.length === 0 ) {
			    //console.log('field is empty');
			    $( "#site-error_custome" ).show();
			    $( "#site-error_custome" ).text('This field is required.');

			    $( "#eng-error_custome" ).show();
			    $( "#eng-error_custome" ).text('This field is required.');
			    e.preventDefault();
			}
			else if( album_text.length === 0 )
			{
				$( "#site-error_custome" ).show();
			    $( "#site-error_custome" ).text('This field is required.');

			    e.preventDefault();
			}
			else if( album_text1.length === 0 )
			{

			    $( "#eng-error_custome" ).show();
			    $( "#eng-error_custome" ).text('This field is required.');
			    e.preventDefault();
			}
			else
			{

				$('#subtask_id').prop('disabled',false);
			}
		// }
	});

	$('#site_name').on('change',function(){

		if ( $( "#site-error_custome" ).is(":visible") ) {
			$( "#site-error_custome" ).hide();
		}

	});

	$('#user_name').on('change',function(){

		if ( $( "#eng-error_custome" ).is(":visible") ) {
			$( "#eng-error_custome" ).hide();
		}

	});

	function get_uservalue(site){
		
		site = $('select#site_name').val();
		
		user_type = $('#assign_to').val();
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

	function clearData(){

		$('#site_name').find('option').remove().end().append('<option value="">Select Site</option>');

		$('#project_type').html('<option value="">Select Option</option><option value="global">Global</option><option value="region">Region</option><option value="site">Site</option>');
    	//$('#user_name').find('option').remove().append('<option value="">Select Option</option>');
    	$('#user_name').html('');
	}

	
</script>