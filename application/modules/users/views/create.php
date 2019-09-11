<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
    <div class="page-title-breadcrumb">
        <div class=" pull-left">
            <div class="page-title"><?php echo $title; ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard'); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php if (!empty($message)) echo $message; ?>
        <div><?php echo $this->session->flashdata('message'); ?></div>
        <div class="card card-box">
            <div class="card-body" id="bar-parent">
                <?php
                //If login user is not superadmin
                $selected_reg_id = $selected_site_id = $disable = $hidden = '';
                if ($this->session->userdata('role_id') != 1) {
                    $selected_reg_id = $reg_id;
                    $selected_site_id = $site_id;
                    //$disable = 'disabled';
                    //$options_site[$site_id]  = $site_name;
                    $hidden = array('region_id' => $reg_id, 'site_id' => $site_id);
                }
                //End condition for not superadmin

                $attributes = array('class' => 'form-horizontal', 'id' => 'create_user', 'method' => 'POST', 'autocomplete' => "off");
                echo form_open('users/create', $attributes, $hidden);
                ?>
                <div class="form-body">

                    <div class="form-group row">
                        <label class="control-label col-md-3">Employee ID
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <?php
                            $data = array(
                                'name' => 'employee_id',
                                'id' => 'employee_id',
                                'placeholder' => 'Enter Employee ID',
                                'class' => 'form-control input-height check_unique',
                                'data-required' => "1"
                            );
                            echo form_input($data, set_value('employee_id'));
                            ?>
                        </div>

                    </div> 

                    <div class="form-group row">
                        <label class="control-label col-md-3">Username
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <?php
                            $data = array(
                                'name' => 'user_name',
                                'id' => 'user_name',
                                'placeholder' => 'Enter Username',
                                'class' => 'form-control input-height check_unique',
                                'data-required' => "1"
                            );
                            echo form_input($data, set_value('user_name'));
                            ?>
                        </div>
                        <span id="username_error" class="error" style="padding: 10px;display: none;">This Username is already exist.</span>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">First Name
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <?php
                            $data = array(
                                'name' => 'user_first_name',
                                'id' => 'user_first_name',
                                'placeholder' => 'Enter First Name',
                                'class' => 'form-control input-height',
                                'data-required' => "1"
                            );
                            echo form_input($data, set_value('user_first_name'));
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Middle Name

                        </label>
                        <div class="col-md-5">
                            <?php
                            $data = array(
                                'name' => 'user_middle_name',
                                'id' => 'user_middle_name',
                                'placeholder' => 'Enter Middle Name',
                                'class' => 'form-control input-height',
                                'data-required' => "1"
                            );
                            echo form_input($data, set_value('user_middle_name'));
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Last Name
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <?php
                            $data = array(
                                'name' => 'user_last_name',
                                'id' => 'user_last_name',
                                'placeholder' => 'Enter Last Name',
                                'class' => 'form-control input-height',
                                'data-required' => "1"
                            );
                            echo form_input($data, set_value('user_last_name'));
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Email
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="user_email" id="user_email" data-required="1" placeholder="Enter Email ID" class="form-control input-height check_unique" value="<?php echo set_value('user_email'); ?>">
                        </div>
                        <span id="email_error" class="error" style="padding: 10px;display: none;">This Email is already exist.</span>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Password
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <input type="password" id="password" name="password" data-required="1" placeholder="Enter Password" class="form-control input-height" autocomplete="new-password" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Confirm Password
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <input type="password" name="confirm_password" data-required="1" placeholder="Confirm Password" class="form-control input-height" value="<?php echo set_value('confirm_password'); ?>">
                        </div>
                    </div>


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
                                    <?php foreach ((array) $roles as $role): ?>

                                        <option value="<?php echo $role->{ROLE_ID}; ?>"> <?php echo $role->{ROLE_NAME}; ?> </option>

                                    <?php endforeach; ?>
                                </select> 

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
                            <div class="col-md-5">
                                <?php
                                $options[''] = 'Select Region';
                                foreach ((array) $regions as $region) {
                                    $options[$region->reg_id] = $region->region_name;
                                }
                                $css = array(
                                    'id' => 'region_id_0',
                                    'class' => 'form-control input-height',
                                    'onchange' => 'get_sites(this.value, 0)',
                                    $disable => $disable
                                );
                                echo form_dropdown('region_id[]', $options,'', $css);
                                ?>

                            </div>

                        </div>

                        <div class="form-group row" id="site_dropdown_0">
                            <label class="control-label col-md-3">Site <span class="required"> * </span> </label>
                            <div class="col-md-5">
                                <?php
                                $options_site[''] = 'Select Site';
                                if (!empty($site_array)) {
                                    foreach ((array) $site_array as $site_val) {
                                        $options_site[$site_val->site_id] = $site_val->site_name;
                                    }
                                }
                                $css = array(
                                    'id' => 'site_id_0',
                                    'class' => 'form-control input-height',
                                    'onchange' => 'get_supervisors(this.value, 0)',
                                    $disable => $disable
                                );
                                echo form_dropdown('site_id[]', $options_site,'', $css);
                                ?>

                            </div>
                        </div>

                        <div class="form-group row" style="display: none;" id="fm_site_dropdown_0">
                            <label class="control-label col-md-3">Site </label>
                            <div class="col-md-5">
                                <?php
                                $options_site[''] = 'Select Site';
                                if (!empty($site_array)) {
                                    foreach ((array) $site_array as $site_val) {
                                        $options_site[$site_val->site_id] = $site_val->site_name;
                                    }
                                }
                                $css = array(
                                    'id' => 'fm_site_id_0',
                                    'class' => 'form-control input-height',
                                    //'onchange' => 'get_supervisors(this.value, 0)',
                                    $disable => $disable
                                );
                                echo form_dropdown('fm_site_id[]', $options_site, $selected_site_id, $css);
                                ?>

                            </div>
                        </div>


                    </div>

                    <div class="form-group row" id="supervisor_selection_div" style="display:none;margin-top: 2%;">
                        <label class="control-label col-md-3">Supervisor 
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-5">
                            <select class="form-control input-height" name="select_supervisor" id="select_supervisor">
                                <option value="">Select Supervisor </option>
                                <?php foreach ((array) $supervisors as $sv): ?>

                                    <option value="<?php echo $sv->user_id; ?>"> <?php echo $sv->name; ?> </option>

                                <?php endforeach; ?>
                            </select> 
                            <label style="color:#bbb; ">Please select supervisor for engineer</label>
                        </div>
                    </div>

                    <input type="hidden" value="<?php echo "1"; ?>" name="addrowcount" id="addrowcount">

                    <div class="form-actions">
                        <div class="row">
                            <div class="offset-md-3 col-md-9">
                                <?php
                                $data = array(
                                    'class' => 'btn btn-danger',
                                    'type' => 'submit',
                                    'content' => 'Create'
                                );

                                echo form_button($data);

                                $data1 = array(
                                    'class' => 'btn btn-default',
                                    'type' => 'button',
                                    'content' => 'Cancel',
                                    'onclick' => "javascript:window.location.replace('" . base_url('users') . "')"
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
    $(document).ready(function () {

        $('#supervisor_selection_div').hide(); //Initialy supervisor should be hide

        $("#create_user").on('submit', function (e) {

            if ($('[name=select_supervisor]').is(':visible'))
            {
                // console.log($('[name=select_supervisor]').val()); e.preventDefault();
                $('[name=select_supervisor]').rules("add",
                        {
                            required: true,
                            messages: {
                                required: "This field is required",
                            }
                        });
            } else
            {
                $('[name=select_supervisor]').rules('remove');
            }

            $("[name^=user_role]").each(function () {
                // alert($(this).val());
                $(this).rules("add",
                        {
                            required: true,
                            messages: {
                                required: "Role is required",
                            }
                        });
            });

            $("[name^=region_id]").each(function () {
                // alert($(this).val());
                $(this).rules("add",
                        {
                            required: true,
                            messages: {
                                required: "Region is required",
                            }
                        });
            });

            $("[name^=site_id]").each(function () {
                // alert($(this).val());
                $(this).rules("add",
                        {
                            required: true,
                            messages: {
                                required: "Site is required",
                            }
                        });
            });

        });

        $("#create_user").validate({
            rules: {
                employee_id: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url('users/create/check_duplicate'); ?>",
                        type: "post",
                        data: {
                            feild:"employee_id",
                            user_name: function () {
                                return $("#user_name").val();
                            }
                        }
                    }
                },
                user_name: {
                    required: true,
                    minlength: 4,
                    remote: {
                        url: "<?php echo base_url('users/create/check_duplicate'); ?>",
                        type: "post",
                        data: {
                            feild:"username",
                            user_name: function () {
                                return $("#user_name").val();
                            }
                        }
                    }
                },
                user_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url('users/create/check_duplicate'); ?>",
                        type: "post",
                        data: {
                            feild:"email",
                            user_name: function () {
                                return $("#user_email").val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
                user_first_name: {
                    required: true,
                },
                user_last_name: {
                    required: true,
                }
            },
            messages: {
        
        user_name: {
            remote: "Username already in use",
        },
        user_email: {
            remote: "Email already in use",
        },
        employee_id:{
        remote: "Employee ID already in use",
        }
        
        }
        });

        $('.check_unique').on('blur', function () {

            var table = 'users';
            var id = $(this).attr('id');
            var column, value;

            switch (id) {

                case "user_name":
                    column = 'username';
                    value = $(this).val();
                    break;

                case "user_email":
                    column = 'email_id';
                    value = $(this).val();
                    break;

                case "employee_id":
                    column = 'employee_id';
                    value = $(this).val();
                    break;

                default:
            }
            // console.log(column);

        });
    });

    $('#create_user').disableAutoFill();
</script>

<script type="text/javascript">

    function addRow() {
        tr_id = $('#addrowcount').val();
        //alert(tr_id); 
        var roles = <?php echo json_encode($roles); ?>;
        //var supervisors = <?php //echo json_encode($supervisors);   ?>;
        //var portals = <?php //echo json_encode($portals);   ?>;
        var regions = <?php echo json_encode($regions); ?>;
        //alert(roles); 
        var div_content = '<div id="group_div_' + tr_id + '"><hr style="border-top:1px solid #ccc;" /><div class="form-group row"><div class="col-md-10" style="text-align: right;"><a href="javascript:void(0);" onclick="removeRow(' + tr_id + '); return false;" class="btn btn-danger add_button1_0"><i class="fa fa-minus" style="padding-top:08px;"></i></a></div></div>';

        div_content += '<div class="form-group row role_group_div_' + tr_id + '"><label class="control-label col-md-3">Role<span class="required"> * </span></label>';
        div_content += '<div class="col-md-5"><select class="user_role_class form-control input-height role_class" name="user_role[' + tr_id + ']" id="user_role_' + tr_id + '" onchange="check_role(this.value, ' + tr_id + ');"><option value="">Select User Role </option>';

        $.each(roles, function (key, value) {
            div_content += "<option value=" + value.role_id + ">" + value.role_name + "</option>";
        });

        div_content += '</select></div></div>';

        div_content += '<div class="form-group row"><label class="control-label col-md-3">Region <span class="required"> * </span> </label><div class="col-md-5"><select name="region_id[' + tr_id + ']" id="region_id_' + tr_id + '" onchange="get_sites(this.value, ' + tr_id + ')" class="form-control input-height" ><option value="">Select Region</option>';
        $.each(regions, function (key3, value3) {
            div_content += "<option value=" + value3.reg_id + ">" + value3.region_name + "</option>";
        });

        div_content += '</select></div></div>';

        div_content += '<div id="site_dropdown_' + tr_id + '" class="form-group row"><label class="control-label col-md-3">Site  <span class="required"> * </span></label><div class="col-md-5"><select name="site_id[' + tr_id + ']" id="site_id_' + tr_id + '" class="form-control input-height" onchange="get_supervisors(this.value, ' + tr_id + ')" ><option value="">Select Site</option>';


        div_content += '</select></div></div>';

        div_content += '<div style="display: none;" id="fm_site_dropdown_' + tr_id + '" class="form-group row"><label class="control-label col-md-3">Site  </label><div class="col-md-5"><select name="fm_site_id[' + tr_id + ']" id="fm_site_id_' + tr_id + '" class="form-control input-height" ><option value="">Select Site</option>';


        div_content += '</select></div></div>';


        div_content += '</div>';


        $('#outer_div').append(div_content);
        $('#addrowcount').val(parseInt(tr_id) + 1);
    }

    function removeRow(tr_id) {
        $('#group_div_' + tr_id).remove();
        var tr_remove_id = $('#addrowcount').val();
        $('#addrowcount').val(parseInt(tr_remove_id) - 1);
    }

    function get_supervisors(site_id, row_id) {
        if (site_id != '') {
            roles = $('#user_role_' + row_id).val();
            if (roles == 4) {
                var dataString = 'site_id=' + site_id;
                $.ajax
                        ({

                            type: "POST",
                            url: "<?php echo base_url('users/getSupervisors'); ?>",
                            data: dataString,
                            cache: false,
                            dataType: "JSON",
                            success: function (data)
                            {
                                var sv_len = data.sv_opt.length;
                                var options_svdata = '<option value="">Select Supervisor</option>';
                                for (var j = 0; j < sv_len; j++) {
                                    options_svdata += '<option value=' + data.sv_opt[j].user_id + '>' + data.sv_opt[j].user_name + '</option>';
                                }

                                $('#select_supervisor').html(options_svdata);
                            }
                        });
            }
        }
    }

    function get_sites(id, row_id) {
        if (id != '') {

            //var roles = new Array();
            roles = $('#user_role_' + row_id).val();

            //if (($.inArray('3', roles) >  -1) || ($.inArray('4', roles) >  -1)){
            var sv_show = 1;
            /*}else{ 
             var sv_show = 0;
             }*/

            var dataString = 'region_id=' + id + '&sv_show=' + sv_show + '&role=' + roles;
            $.ajax
                    ({

                        type: "POST",
                        url: "<?php echo base_url('users/getsite'); ?>",
                        data: dataString,
                        cache: false,
                        dataType: "JSON",
                        success: function (data)
                        {
                            var len = data.site_opt.length;
                            var options_data = '<option value="">Select Site</option>';
                            for (var i = 0; i < len; i++) {
                                options_data += '<option value=' + data.site_opt[i].site_id + '>' + data.site_opt[i].site_name + '</option>';
                            }

                            if (roles == 4) { //alert(roles);
                                var sv_len = data.sv_opt.length;
                                var options_svdata = '<option value="">Select Supervisor</option>';
                                for (var j = 0; j < sv_len; j++) {
                                    options_svdata += '<option value=' + data.sv_opt[j].user_id + '>' + data.sv_opt[j].user_name + '</option>';
                                }
                                $('#select_supervisor').html(options_svdata);
                            }

                            $('#site_id_' + row_id).html(options_data);
                            $('#fm_site_id_' + row_id).html(options_data);

                        }
                    });
        } else {
            $('#site_id_' + row_id).html('<option value="">Select Site</option>');
            $('#fm_site_id_' + row_id).html('<option value="">Select Site</option>');
            $('#select_supervisor').html('<option value="">Select Supervisor</option>');
        }
    }

    function check_role(id, row_id) {
        if (id == 7) {
            $('#site_dropdown_' + row_id).hide();
            $('#fm_site_dropdown_' + row_id).show();

        } else {
            $('#site_dropdown_' + row_id).show();
            $('#fm_site_dropdown_' + row_id).hide();
            //$('#supervisor_selection_div').hide();
        }

        var set_sv = 0;
        $(".role_class").each(function () {
            if (this.value == 4) {

                set_sv = 1;
                // var eng_id = this.id;
                // var res = eng_id.split("_");
                // var row_id = res[2];
                // var region = $('#region_id_'+row_id);
                // var site = $('#site_id_'+row_id);
                //get_supervisors(region, site);
            }
        });

        if (set_sv == 1) {
            $('#supervisor_selection_div').show();
        } else {
            $('#supervisor_selection_div').hide();
        }
    }



</script>