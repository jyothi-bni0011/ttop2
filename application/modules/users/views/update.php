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
                //$hidden = array('region_id' => $reg_id, 'site_id' => $site_id);
                $attributes = array('class' => 'form-horizontal', 'id' => 'update_user', 'method' => 'POST', 'autocomplete' => "off"); 
                    echo form_open('users/update', $attributes, $hidden);
                ?>
                    <div class="form-body">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                        

                        <div class="form-group row">
                            <label class="control-label col-md-3">Employee ID
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="employee_id" data-required="1" placeholder="Enter Employee ID" class="form-control input-height" value="<?php echo $employee_id; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Username
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="user_name" data-required="1" placeholder="Enter Username" class="form-control input-height" value="<?php echo $user_name; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">First Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="user_first_name" data-required="1" placeholder="Enter First Name" class="form-control input-height" value="<?php echo $user_first_name; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Middle Name
                                
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="user_middle_name" data-required="1" placeholder="Enter Middle Name" class="form-control input-height" value="<?php echo $user_middle_name; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Last Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" name="user_last_name" data-required="1" placeholder="Enter Last Name" class="form-control input-height" value="<?php echo $user_last_name; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Email
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <input type="text" readonly name="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height" value="<?php echo $email_id; ?>">
                            </div>
                        </div>
                        <?php  if(!empty($user_roles)){?>
                        <div id="outer_div" style="border :1px solid #ccc; /*margin: 1%;*/">
                        <?php //echo "<pre>"; print_r($user_roles); exit;
                        $j=0; foreach($user_roles as $role_data){ 
                            $options_site = $options_sitefm = '';
                            ?>
                        
                            <?php if($j==0){ ?>
                                <div class="form-group row">
                                    <div class="col-md-10" style="text-align: right;">
                                        <a href="javascript:void(0);" onclick="addRow(); return false;" class="btn btn-success add_button1_0"><i class="fa fa-plus" style="padding-top:08px;"></i></a>
                                    </div>  
                                </div>
                            <?php }else{ ?>
                                <hr style="border-top: 1px solid #ccc;" /><div id="group_div_<?php echo $j; ?>"><div class="form-group row"><div class="col-md-10" style="text-align: right;"><a href="javascript:void(0);" onclick="removeRow(<?php echo $j; ?>); return false;" class="btn btn-danger add_button1_0"><i class="fa fa-minus" style="padding-top:08px;"></i></a></div></div>
                            <?php } ?>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Role
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <select class="form-control input-height role_class" name="user_role[<?php echo $j; ?>]" id="user_role_<?php echo $j; ?>" onchange="check_role(this.value, <?php echo $j; ?>);">
                                       <option value="">Select User Role </option>
                                       <?php foreach($roles as $role): ?>
                                            
                                                <option value="<?php echo $role->{ROLE_ID}; ?>"<?php  if($role->{ROLE_ID} == $role_data['role_id']) echo "selected"; ?> > <?php echo $role->{ROLE_NAME}; ?> </option>
                                            
                                       <?php endforeach; ?>
                                    </select> 

                                    <label id="user_role-error_custome" class="error" style="display: none;">This field is required.</label>

                                </div>
                            </div>

                            <div class="form-group row">
                              <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
                              <div class="col-md-5">
                                <?php 
                                    $selected_reg = (!empty($role_data['region_id'])) ? $role_data['region_id'] : '';
                                    $options['']  = 'Select Region';
                                    foreach((array)$regions as $region){
                                        $options[$region->reg_id] = $region->region_name;
                                    }
                                    
                                    $css = array(
                                            'id'       => 'region_id_'.$j,
                                            'class'    => 'form-control input-height',
                                            'onchange' => "get_sites(this.value, $j)"
                                    );
                                    echo form_dropdown("region_id[$j]", $options, $selected_reg, $css);
                                ?>

                              </div>
                              
                            </div>
                            <?php if($role_data['role_id'] != 7){ 
                                $site = '';
                                $fm_site = 'display : none';
                                
                            }else{
                                $site = 'display : none';
                                $fm_site = '';
                                
                            }?>

                            <div class="form-group row" style="<?php echo $site;?>" id="site_dropdown_<?php echo $j;?>">
                              <label class="control-label col-md-3">Site <span class="required"> * </span></label>
                              <div class="col-md-5">
                                <?php 
                                    //$options_site[$site_id]  = $site_name;
                                    $options_site[''] = 'Select Site';
                                    $selected_site = (!empty($role_data['site_id'])) ? $role_data['site_id'] : '';
                                    foreach((array)$role_data['site_array'] as $site){
                                        $options_site[$site->site_id] = $site->site_name;
                                    }
                                    $css = array(
                                        'id'       => 'site_id_'.$j,
                                        'class'    => 'form-control input-height',
                                        'onchange' => 'get_supervisors(this.value, 0)',
                                        
                                    );
                                    echo form_dropdown("site_id[$j]", $options_site, $selected_site, $css);
                                ?>

                              </div>
                            </div>
                          
                            <div class="form-group row" style="<?php echo $fm_site;?>" id="site_dropdown_fm_<?php echo $j;?>">
                              <label class="control-label col-md-3">Site</label>
                              <div class="col-md-5">
                                <?php 
                                    //$options_site[$site_id]  = $site_name;
                                    $options_sitefm[''] = 'Select Site';
                                    $selected_site = (!empty($role_data['site_id'])) ? $role_data['site_id'] : '';
                                    foreach((array)$role_data['site_array'] as $site){
                                        $options_sitefm[$site->site_id] = $site->site_name;
                                    }
                                    $css = array(
                                        'id'       => 'site_id_fm_'.$j,
                                        'class'    => 'form-control input-height',
                                        //'onchange' => "check_duplicate()"
                                        
                                    );
                                    echo form_dropdown("fm_site_id[$j]", $options_sitefm, $selected_site, $css);
                                ?>

                              </div>
                            </div>
                          
                            <?php if($j!=0) echo "</div>";?>
                        
                        <?php $j++; }  ?>
                   
                        </div>

                        <br />
                        <div class="form-group row" id="supervisor_selection_div">
                            <label class="control-label col-md-3">Supervisor 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <select class="form-control input-height" name="select_supervisor" id="select_supervisor">
                                   <option value="">Select Supervisor </option>
                                   <?php foreach($supervisors as $sv): ?>
                                        
                                       <option <?php if((($supervisor_id != 0)) && $supervisor_id == $sv->user_id) echo "selected";  ?> value="<?php echo $sv->user_id; ?>"> <?php echo $sv->name; ?> </option>
                                   
                                    <?php endforeach; ?>
                                </select> 
                                <label style="color:#bbb; ">Please select supervisor for engineer</label>
                            </div>
                        </div>
                    <?php } else{ ?>
                        <div id="outer_div" style="border :1px solid #ccc;">
                            <div class="form-group row">
                                <div class="col-md-10" style="text-align: right;">
                                    <a href="javascript:void(0);" onclick="addRow(); return false;" class="btn btn-success add_button1_0"><i class="fa fa-plus" style="padding-top:08px;"></i></a>
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Role
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <select class="form-control input-height role_class" onchange="check_role(this.value, 0);" name="user_role[0]" id="user_role_0">
                                       <option value="">Select User Role </option>
                                       <?php foreach((array)$roles as $role): ?>
                                            
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
                                    echo form_dropdown('region_id[]', $options, '', $css);
                                ?>

                              </div>
                              
                            </div>

                            <div class="form-group row" id="site_dropdown_0">
                              <label class="control-label col-md-3">Site <span class="required"> * </span> </label>
                              <div class="col-md-5">
                                <?php 
                                    $options_site['']  = 'Select Site';
                                    if(!empty($site_array)){
                                        foreach((array)$site_array as $site_val){
                                            $options_site[$site_val->site_id]  = $site_val->site_name;
                                        }
                                    }
                                    $css = array(
                                            'id'       => 'site_id_0',
                                            'class'    => 'form-control input-height',
                                            'onchange' => 'get_supervisors(this.value, 0)',
                                            $disable => $disable
                                    );
                                    echo form_dropdown('site_id[]', $options_site, '', $css);
                                ?>

                              </div>
                            </div>

                            <div class="form-group row" style="display: none;" id="fm_site_dropdown_0">
                              <label class="control-label col-md-3">Site </label>
                              <div class="col-md-5">
                                <?php 
                                    $options_site['']  = 'Select Site';
                                    if(!empty($site_array)){
                                    foreach((array)$site_array as $site_val){
                                        $options_site[$site_val->site_id]  = $site_val->site_name;
                                    }
                                    }
                                    $css = array(
                                            'id'       => 'fm_site_id_0',
                                            'class'    => 'form-control input-height',
                                            //'onchange' => 'get_supervisors(this.value, 0)',
                                            $disable => $disable
                                    );
                                    echo form_dropdown('fm_site_id[]', $options_site, '', $css);
                                ?>

                              </div>
                            </div>

                            
                        </div>
                    <?php } ?>
                        <input type="hidden" value="<?php  echo count($user_roles); ?>" name="addrowcount" id="addrowcount">

                        <div class="form-actions">
                            <div class="row">
                                <div class="offset-md-3 col-md-9">
                                    <?php 
                                        $data = array(
                                                'class'            => 'btn btn-danger',
                                                'type'          => 'submit',
                                                'content'       => 'Update',
                                                'id'            => 'update_btn'
                                        );

                                        echo form_button($data);

                                        $data1 = array(
                                                'class'            => 'btn btn-default',
                                                'type'          => 'button',
                                                'content'       => 'Cancel',
                                                'onclick'       => "javascript:window.location.replace('" . base_url('users') . "')"
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

        $('#supervisor_selection_div').hide(); //Initialy it should 

        $("[name^=user_role]").each(function() {
            // alert($(this).val());
            if ( $(this).val() == 4 ) 
            {
                $('#supervisor_selection_div').show();
            }
        });

        $( "#update_user" ).on('submit', function(e){
            //check duplicate role
            // $(function(){
                // var role = region = site = [];
                // // alert();
                // $("[name^=user_role]").each(function() {
    //             // alert($(this).val());
    //              role.push($(this).val());
    //              alert($(this).val());
       //          });

                // $("[name^=region_id]").each(function() {
       //              // alert($(this).val());
       //              region.push($(this).val());
       //          });

       //          $("[name^=site_id]").each(function() {

       //              // alert($(this).val());
       //              site.push($(this).val());
       //          });  

       //          console.log(role); 

       //          e.preventDefault();              
            // })

            if ( $('[name=select_supervisor]').is(':visible') ) 
            {
                // alert();
                $('[name=select_supervisor]').rules("add", 
                    {
                        required: true,
                        messages: {
                            required: "This field is required",
                        }
                    });
            }
            else
            {
                 $('[name=select_supervisor]').rules( 'remove' );
            }

            $("[name^=user_role]").each(function() {
                // alert($(this).val());
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "Role is required",
                    }
                });
            });

            $("[name^=region_id]").each(function() {
                // alert($(this).val());

                // alert($(this).attr('name')+' '+$(this).val());

                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "Region is required",
                    }
                });
            });

            $("[name^=site_id]").each(function() {

                // alert($(this).attr('name')+' '+$(this).val());
                $(this).rules("add", 
                {
                    required: true,
                    messages: {
                        required: "Site is required",
                    }
                });
            });
        });


        $( "#update_user" ).validate({
            rules: {
                user_name: {
                    required: true,
                    minlength: 4
                },
                user_email: {
                    required: true,
                    email: true
                },
                employee_id:{
                    required: true
                },              
                user_first_name:{
                    required: true,
                },
                user_last_name:{
                    required: true,
                }
            }
            
        });


        /*$('#user_role').on('change', function() { 
            var roles = new Array();
            roles = $('#user_role').val();
            //alert(jQuery.type(roles));
            if($.inArray('2', roles) >  -1){ 
                $('#portal_selection_div').show();
            }else{
                $('#portal_selection_div').hide();
            }

            if (($.inArray('3', roles) >  -1) || ($.inArray('4', roles) >  -1)){
                $('#supervisor_selection_div').show();
            }else{ 
                $('#supervisor_selection_div').hide();
            }
            
            
        });*/
    });

    function addRow(){
        tr_id = $('#addrowcount').val();
        //alert(tr_id); 
        var roles = <?php echo json_encode($roles); ?>;
        //var supervisors = <?php //echo json_encode($supervisors); ?>;
        //var portals = <?php //echo json_encode($portals); ?>;
        var regions = <?php echo json_encode($regions); ?>;
        //alert(roles); 
        var div_content = '<div id="group_div_'+tr_id+'"><hr style="border-top:1px solid #ccc;" /><div class="form-group row"><div class="col-md-10" style="text-align: right;"><a href="javascript:void(0);" onclick="removeRow('+tr_id+'); return false;" class="btn btn-danger add_button1_0"><i class="fa fa-minus" style="padding-top:08px;"></i></a></div></div>';

        div_content +='<div class="form-group row role_group_div_'+tr_id+'"><label class="control-label col-md-3">Role<span class="required"> * </span></label>';
        div_content += '<div class="col-md-5"><select class="user_role_class form-control input-height role_class" name="user_role['+tr_id+']" id="user_role_'+tr_id+'" onchange="check_role(this.value, '+tr_id+');"><option value="">Select User Role </option>';

            $.each( roles, function( key, value ) {
                div_content += "<option value="+value.role_id+">"+value.role_name+"</option>";
            });

        div_content += '</select></div></div>'; 

        div_content += '<div class="form-group row"><label class="control-label col-md-3">Region <span class="required"> * </span> </label><div class="col-md-5"><select name="region_id['+tr_id+']" id="region_id_'+tr_id+'" onchange="get_sites(this.value, '+tr_id+')" class="form-control input-height" ><option value="">Select Region</option>';
            $.each( regions, function( key3, value3 ) {
                div_content += "<option value="+value3.reg_id+">"+value3.region_name+"</option>";
            });

        div_content += '</select></div></div>';

        div_content += '<div id="site_dropdown_'+tr_id+'" class="form-group row"><label class="control-label col-md-3">Site  <span class="required"> * </span></label><div class="col-md-5"><select name="site_id['+tr_id+']" id="site_id_'+tr_id+'" class="form-control input-height" onchange="get_supervisors(this.value, '+tr_id+')"><option value="">Select Site</option>';
            

        div_content += '</select></div></div>';

        div_content += '<div style="display:none;" id="site_dropdown_fm_'+tr_id+'" class="form-group row"><label class="control-label col-md-3">Site</label><div class="col-md-5"><select name="fm_site_id['+tr_id+']" id="site_id_fm_'+tr_id+'" class="form-control input-height"><option value="">Select Site</option>';
            

        div_content += '</select></div></div>';


        div_content += '</div>'; 

        
        $('#outer_div').append(div_content);
        $('#addrowcount').val(parseInt(tr_id) + 1);
    }

    function removeRow(tr_id){
        $('#group_div_'+tr_id).remove();
        var tr_remove_id = $('#addrowcount').val();
        $('#addrowcount').val(parseInt(tr_remove_id) - 1);
    }

    function get_sites(id, row_id){ 
        if(id!=''){ 

            var roles = new Array();
            roles = $('#user_role_'+row_id).val();
            var sv_show = 1;

            var dataString = 'region_id='+ id + '&sv_show='+sv_show+'&role='+roles;;
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
                    var options_data = '<option value="">Select Site</option>';
                    for(var i=0; i<len; i++){
                        options_data += '<option value='+data.site_opt[i].site_id+'>'+data.site_opt[i].site_name+'</option>';
                    }

                    if(roles == 4){ //alert(roles);
                        var sv_len = data.sv_opt.length;
                        var options_svdata = '<option>Select Supervisor</option>';
                        for(var j=0; j<sv_len; j++){
                            options_svdata += '<option value='+data.sv_opt[j].user_id+'>'+data.sv_opt[j].user_name+'</option>';
                        }
                        $('#select_supervisor').html(options_svdata);
                    }
                    $('#site_id_'+row_id).html(options_data);
                    $('#site_id_fm_'+row_id).html(options_data);            
                } 
            });
        }else{
            $('#site_id_'+row_id).html('<option value="">Select Site</option>');
            $('#site_id_fm_'+row_id).html('<option value="">Select Site</option>');
            $('#select_supervisor').html('<option>Select Supervisor</option>');
        }
    }

    function get_supervisors(site_id, row_id){
        if(site_id!=''){ 
            roles = $('#user_role_'+row_id).val();
            if(roles == 4){
                var dataString = 'site_id='+ site_id;
                $.ajax
                ({

                    type: "POST",
                    url: "<?php echo base_url('users/getSupervisors');?>",
                    data: dataString,
                    cache: false,
                    dataType: "JSON",
                    success: function(data)
                    { 
                        var sv_len = data.sv_opt.length;
                        var options_svdata = '<option>Select Supervisor</option>';
                        for(var j=0; j<sv_len; j++){
                            options_svdata += '<option value='+data.sv_opt[j].user_id+'>'+data.sv_opt[j].user_name+'</option>';
                        }

                        $('#select_supervisor').html(options_svdata);
                    } 
                });
            }
        }
    }

    function check_role(id, row_id){
        if(id == 7){
            $('#site_dropdown_'+row_id).hide();
            $('#site_dropdown_fm_'+row_id).show();
        }else{
            $('#site_dropdown_'+row_id).show();
            $('#site_dropdown_fm_'+row_id).hide();
        }

        var set_sv = 0;
        $(".role_class").each(function() {
            if( this.value == 4){
                
                set_sv = 1;
                var eng_id = this.id;
                var res = eng_id.split("_");
                var row_id = res[2];
                var region = $('#region_id_'+row_id);
                var site = $('#site_id_'+row_id);
                //get_supervisors(region, site);
            }
        });

        if(set_sv==1){
            $('#supervisor_selection_div').show();
        }else{
            $('#supervisor_selection_div').hide();
        }
    }

    /*function check_duplicate(){
                 
        var $elements = $("select[name='site_id[]']");
        $('#update_btn').attr("disabled", false);//enable save & submit access
        $elements.removeClass('error').each(function () {
            var selectedValue = this.value;
            $elements.not(this).filter(function() {
                    return this.value === selectedValue;
                }).addClass('error');
        });
        //disable save & submit access
        if ( $elements.hasClass("error") ) {$('#update_btn').attr("disabled", true);}
    }*/
</script>