<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">

</style>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Assign Role for <?php echo $post['user_name'];?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Assign Role</li>
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

				//If login user is not superadmin
            	$selected_reg_id = $selected_site_id = $disable = $hidden = '';
                if($this->session->userdata('role_id')!=1){
                	$selected_reg_id = $reg_id;
                	$selected_site_id = $site_id;
                	//$disable = 'disabled';
                	$options_site[$site_id]  = $site_name;
                	$hidden = array('region_id' => $reg_id, 'site_id' => $site_id);
                } 
                //End condition for not superadmin

				$attributes = array('class' => 'form-horizontal', 'id' => 'assign_user_role', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('users/create/assign_role', $attributes, $hidden);
				?>
					<div class="form-body">
						<div class="form-group row">
							<div class="col-md-10" style="text-align: right;">
								<a href="javascript:void(0);" onclick="addRow(); return false;" class="btn btn-success add_button1_0"><i class="fa fa-plus" style="padding-top:08px;"></i></a>
							</div>	
						</div>
						<div id="outer_div">
							<div class="form-group row role_group_div_0">
								<label class="control-label col-md-3">Role
									<span class="required"> * </span>
								</label>
								<div class="col-md-5">
									<select class="form-control input-height select2-multiple user_role_class" onchange="get_dropdowns(this.value, 0)" name="user_role[0][]" id="user_role_0" multiple>
	                                   <option value="">Select User Role </option>
	                                   <?php foreach($roles as $role): ?>
	                                   		
				                           <option value="<?php echo $role->{ROLE_ID}; ?>"> <?php echo $role->{ROLE_NAME}; ?> </option>
				                       
			                       		<?php endforeach; ?>
	                                </select> 
	                                
								</div>
							</div>

							<div class="form-group row">
			                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
			                  <div class="col-md-5">
			                    <?php 
			                    	$options['']  = 'Select Region';
									foreach((array)$regions as $region){
										$options[$region->reg_id] = $region->region_name;
									}
									$css = array(
									        'id'       => 'region_id_0',
									        'class'    => 'form-control input-height',
									        'onchange' => 'get_sites(this.value, 0)',
									        $disable => $disable
									);
									echo form_dropdown('region_id[0]', $options, $selected_reg_id, $css);
								?>

			                  </div>
			                  
			              	</div>

			              	<div class="form-group row">
			                  <label class="control-label col-md-3">Site <span class="required"> * </span> </label>
			                  <div class="col-md-5">
			                    <?php 
									$options_site['']  = 'Select Site';
									
									$css = array(
									        'id'       => 'site_id_0',
									        'class'    => 'form-control input-height',
									        $disable => $disable
									);
									echo form_dropdown('site_id[0]', $options_site, $selected_site_id, $css);
								?>

			                  </div>
			                  
			              	</div>
						</div>
						
			            <input type="hidden" value="<?php  echo "1"; ?>" name="addrowcount" id="addrowcount"> 
											
						
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger',
										        'type'          => 'submit',
										        'content'       => 'Submit'
										);

										echo form_button($data);

										$data2 = array(
										        'class'            => 'btn btn-default',
										        'type'          => 'button',
										        'content'       => 'Back',
										        'id'            => 'back_id'
										);

										echo form_button($data2);

										$data1 = array(
										        'class'            => 'btn btn-default',
										        'type'          => 'button',
										        'content'       => 'Cancel',
										        'onclick'		=> "javascript:window.history.go(-2);"
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

		$("#back_id").click(function(){
		  	var post_array = <?php echo json_encode($post); ?>;

		  	var dataString = 'post='+ post_array;
            $.ajax
            ({
                type: "POST",
                url: "<?php echo base_url('users/create');?>",
                data: dataString,
                cache: false,
                dataType: "JSON",
                success: function(data)
                {
                   $(body).html(data);
                
                } 
            });

		});	
		//$('.user_role_class').multiSelect();

		$( "#create_user" ).validate({
			rules: {
				region_id:{
					required: true
				},
				site_id:{
					required: true
				},
				user_name: {
		      		required: true,
		      		minlength: 4
		    	},
		    	user_email: {
		    		required: true,
		    		email: true
		    	},
				password: {
		      		required: true,
		      		minlength: 6
		    	},
				confirm_password: {
		      		required: true,
		      		equalTo: "#password"
		    	}
			}
		});

		$( "#create_user" ).on('submit', function(e){
			var album_text = [];
			$("select[name='user_role[]']").each(function() {
			    var value = $(this).val();
			    if (value != '') {
			        album_text.push(value);
			    }
			});
			    	
			if (album_text.length === 0) {
			    //console.log('field is empty');
			    $( "#user_role-error_custome" ).show();
			    $( "#user_role-error_custome" ).text('This field is required.');
			    e.preventDefault();
			}
		});

		$('.check_unique').on('blur',function(){

	      var table = 'users';
	      var id = $(this).attr('id');
	      var column, value;

	      switch (id) {

	          case "user_name":
	              column  = 'username';
	              value   = $(this).val();
	              break;

	          case "user_email":
	              column  = 'email_id';
	              value   = $(this).val();
	              break;

	          default:
	      }
	      console.log(column);

	    });
	});

	$('#create_user').disableAutoFill();
</script>

<script type="text/javascript">

function get_dropdowns(role, row_id){

	var roles = new Array();
	roles = $('#user_role_'+row_id).val();
	//alert(jQuery.type(roles));
	
 	if($.inArray('2', roles) >  -1){ 
 	 	$('#portal_selection_div_'+row_id).show();
 	}else{
 		$('#portal_selection_div_'+row_id).hide();
 	}

 	if (($.inArray('3', roles) >  -1) || ($.inArray('4', roles) >  -1)){
 		$('#supervisor_selection_div_'+row_id).show();
 	}else{ 
 		$('#supervisor_selection_div_'+row_id).hide();
 	}

 	if (($.inArray('7', roles) >  -1)){
 		$('#site_id_'+row_id).hide();
 	}else{ 
 		$('#site_id_'+row_id).show();
 	}

}

function get_sites(id, row_id){ 
	if(id!=''){ 

		var roles = new Array();
		roles = $('#user_role_'+row_id).val();

		if (($.inArray('3', roles) >  -1) || ($.inArray('4', roles) >  -1)){
	 		var sv_show = 1;
	 	}else{ 
	 		var sv_show = 0;
	 	}

		var dataString = 'region_id='+ id + '&sv_show='+sv_show;
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
				$('#site_id_'+row_id).html(options_data);

				if($.isArray(data.sv_opt)){
					var sv_len = data.sv_opt.length;
					var options_sv = '<option value="">Select Supervisor</option>';
					for(var j=0; j<sv_len; j++){
						options_sv += '<option value='+data.sv_opt[j].user_id+'>'+data.sv_opt[j].user_name+'</option>';
					}
					$('#select_supervisor_'+row_id).html(options_sv);
				}
			
			} 
		});
	}else{
		$('#site_id_'+row_id).html('<option>Select Site</option>');
		$('#select_supervisor_'+row_id).html('');
	}
}

function addRow(){
	tr_id = $('#addrowcount').val();
	var roles = <?php echo json_encode($roles); ?>;
	var supervisors = <?php echo json_encode($supervisors); ?>;
	var portals = <?php echo json_encode($portals); ?>;
	var regions = <?php echo json_encode($regions); ?>;

	var div_content = '<div id="group_div_'+tr_id+'"><hr style="border-top:1px solid #ccc;" /><div class="form-group row"><div class="col-md-10" style="text-align: right;"><a href="javascript:void(0);" onclick="removeRow('+tr_id+'); return false;" class="btn btn-danger add_button1_0"><i class="fa fa-minus" style="padding-top:08px;"></i></a></div></div>';

	div_content +='<div class="form-group row role_group_div_'+tr_id+'"><label class="control-label col-md-3">Role<span class="required"> * </span></label>';
	div_content += '<div class="col-md-5"><select class="user_role_class form-control input-height select2-multiple" name="user_role['+tr_id+'][]" id="user_role_'+tr_id+'" onchange="get_dropdowns(this.value, '+tr_id+')" multiple><option value="">Select User Role </option>';

		$.each( roles, function( key, value ) {
            div_content += "<option value="+value.role_id+">"+value.role_name+"</option>";
        });

    div_content += '</select></div></div>'; 

    div_content += '<div class="form-group row"><label class="control-label col-md-3">Region <span class="required"> * </span> </label><div class="col-md-5"><select name="region_id['+tr_id+']" id="region_id_'+tr_id+'" onchange="get_sites(this.value, '+tr_id+')" class="form-control input-height" ><option value="">Select Region</option>';
    	$.each( regions, function( key3, value3 ) {
            div_content += "<option value="+value3.reg_id+">"+value3.region_name+"</option>";
        });

    div_content += '</select></div></div>';

    div_content += '<div class="form-group row"><label class="control-label col-md-3">Site <span class="required"> * </span> </label><div class="col-md-5"><select name="site_id['+tr_id+']" id="site_id_'+tr_id+'" class="form-control input-height" ><option value="">Select Site</option>';
    	/*$.each( supervisors, function( key4, value4 ) {
            div_content += "<option value="+value4.user_id+">"+value4.name+"</option>";
        });*/

    div_content += '</select></div></div>';

    div_content += '<div class="form-group row" id="supervisor_selection_div_'+tr_id+'" style="display: none;"><label class="control-label col-md-3">Supervisor <span class="required"> * </span></label><div class="col-md-5"><select class="form-control input-height" name="select_supervisor['+tr_id+']" id="select_supervisor_'+tr_id+'"><option value="">Select Supervisor </option>';
    	$.each( supervisors, function( key2, value2 ) {
            div_content += "<option value="+value2.user_id+">"+value2.name+"</option>";
        }); 

    div_content += '</select></div></div>';

    div_content += '<div class="form-group row" id="portal_selection_div_'+tr_id+'" style="display: none;"><label class="control-label col-md-3">Portals</label><div class="col-md-5"><select class="form-control input-height select2-multiple" name="portal_selection['+tr_id+'][]" id="portal_selection_'+tr_id+'" multiple><option value="">Select Portal </option>'; 
    	$.each( portals, function( key1, value1 ) {
            div_content += "<option value="+value1.portal_id+">"+value1.portal_name+"</option>";
        });

    div_content += '</select></div></div></div>'; 

	//$("#outer_div").clone().insertAfter("div#outer_div:last");
	// /$('.user_role_class').multiSelect();
	$('#outer_div').append(div_content);
	$('#addrowcount').val(parseInt(tr_id) + 1);
}





</script>