<!-- start page content -->



<div class="page-bar">

    <div class="page-title-breadcrumb">

        <div class=" pull-left">

            <div class="page-title"><?php echo $title; ?></div>

        </div>

        <ol class="breadcrumb page-breadcrumb pull-right">

            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard'); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

            </li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();  ?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

            <li class="active"><?php echo $title; ?></li>

        </ol>

    </div>

</div>

<div><?php echo $this->session->flashdata('message'); ?></div>

<div class="row">

    <div class="col-md-12">

        <div class="card  card-box">

            <div class="card-body ">

                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'search_criteria', 'method' => 'POST', 'autocomplete' => "off");
                echo form_open('emp_report/hours_to_sap_report', $attributes);
                ?>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">From Date </label>
                            <div class="input-group date form_date form_date_start col-md-7 startD" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

                                <?php
                                $data = array(
                                    'name' => 'from_date',
                                    'id' => 'start_date',
                                    'placeholder' => 'Select Date',
                                    'class' => 'form-control',
                                    'size' => 16,
                                    'readonly' => 1,
                                    'value' => $from_date
                                );
                                echo form_input($data);
                                ?>

                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span> 
                            </div>

                            <input type="hidden" id="dtp_input2" value="" />

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-5 control-label">To Date </label>
                            <div class="input-group date form_date form_date_end col-md-7 endD" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="d M YY">
                                <?php
                                $data = array(
                                    'name' => 'to_date',
                                    'id' => 'end_date',
                                    'placeholder' => 'Select Date',
                                    'class' => 'form-control',
                                    'size' => 16,
                                    'readonly' => 1,
                                    'value' => $to_date
                                );
                                echo form_input($data);
                                ?>

                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                            <input type="hidden" id="dtp_input2" value="" />

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Site Name </label>
                            <div class="col-md-7">
                                <?php
                                if (!empty($this->session->userdata('site_id'))) {
                                    $css = array(
                                        'id' => 'site_name',
                                        'class' => 'form-control input-height',
                                        'readonly' => 'readonly'
                                    );
                                } else {
                                    $options_st[''] = 'Select Site';
                                    $css = array(
                                        'id' => 'site_name',
                                        'class' => 'form-control input-height',
                                        'onchange' => "get_projects_user(this.value)"
                                    );
                                }

                                foreach ($sites as $sitedata) {
                                    $options_st[$sitedata->site_id] = $sitedata->site_name;
                                }

                                echo form_dropdown('site_name', $options_st, $site, $css);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Timesheets</label>
                            <div class="col-md-7">

                                <?php
                                $options_ts[''] = 'All';
                                $options_ts['3'] = 'Supervisors';
                                $options_ts['4'] = 'Engineers';

                                $css = array(
                                    'id' => 'timesheets',
                                    'class' => 'form-control input-height',
                                    'onchange' => 'get_user(this.value)'
                                );

                                echo form_dropdown('timesheets', $options_ts, $timesheets, $css);
                                ?>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Hours Type</label>
                            <div class="col-md-7">

                                <?php
                                $options_ht[''] = 'All';
                                $options_ht['sub'] = 'Submitted Hours';
                                $options_ht['unsub'] = 'Unsubmitted Hours';
                                //$options_ht['missing']  = 'Missing Hours';

                                $css = array(
                                    'id' => 'hours_type',
                                    'class' => 'form-control input-height',
                                );

                                echo form_dropdown('hours_type', $options_ht, $hours_type, $css);
                                ?>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5 pt-0" style="line-height: 17px;">Include Period Closed Hours </label>
                            <div class="col-md-7">

                                <?php
                                $options_hr['yes'] = 'Yes';
                                $options_hr['no'] = 'No';

                                $css = array(
                                    'id' => 'period_closed_hours',
                                    'class' => 'form-control input-height',
                                );

                                echo form_dropdown('period_closed_hours', $options_hr, $period_closed_hours, $css);
                                ?>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Project</label>
                            <div class="col-md-7">

                                <?php
                                $options_pj[''] = 'All';
                                foreach ((array) $projects as $proj) {
                                    $options_pj[$proj->id] = $proj->project_name;
                                }

                                $css = array(
                                    'id' => 'project_id',
                                    'class' => 'form-control input-height',
                                    'onchange' => 'get_subtask(this.value)'
                                );

                                echo form_dropdown('project_id', $options_pj, $project, $css);
                                ?>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Subtask</label>
                            <div class="col-md-7">

                                <?php
                                $options_sb[''] = 'All';

                                if (!empty($subtask_array)) {
                                    foreach ($subtask_array as $subtasks) {
                                        $options_sb[$subtasks->subtask_id] = $subtasks->subtask_name;
                                    }
                                }

                                $css = array(
                                    'id' => 'subtask_id',
                                    'class' => 'form-control input-height',
                                );

                                echo form_dropdown('subtask_id', $options_sb, $subtask, $css);
                                ?>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-5">Engineer / Supervisor</label>
                            <div class="col-md-7">

                                <?php
                                $options_emp[''] = 'All';
                                foreach ($employees as $employee) {
                                    $options_emp[$employee->user_id] = $employee->username;
                                }

                                $css = array(
                                    'id' => 'employee_id',
                                    'class' => 'form-control input-height',
                                );

                                echo form_dropdown('employee_id', $options_emp, $emp_id, $css);
                                ?>

                            </div>

                        </div>
                    </div>

                </div>


                <!-- <div class="row">
              <div class="col-md-4">
                  
              </div>
              <div class="col-md-4">
                  
              </div>
              <div class="col-md-4">
                  
              </div>
           </div> -->


                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger" onclick="return validationForm();">Search</button>
                            <a href="<?php echo base_url('emp_report/hours_to_sap_report'); ?>">
                                <button type="button" class="btn btn-default">Reset</button>
                            </a>
                        </div>
                    </div>
                </div>
                </form>


                <div class="table-scrollable">
                    <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                        <thead>
                            <tr>
                                <th> S.NO </th>
                                <th> Cost Center Code </th>
                                <th> Cost Center Name </th>
                                <th> Project </th>
                                <th> Normalized Hours </th>
                                <th> Actual Hours </th>
                                <th> Supervisor/Eng Name </th>
                                <!--<th> Action </th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ((array) $hours_report_data as $data) {
                                //$week = date('W', strtotime($data->start_date));
                                $role_array = explode(",", $data->roles);
                                if (in_array('3', $role_array))
                                    $emp_role = 'Supervisor';
                                else if (in_array('4', $role_array))
                                    $emp_role = 'Engineer';
                                else
                                    $emp_role = '';
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $data->cost_center_code; ?></td>
                                    <td><?php echo $data->cost_center_name; ?></td>
                                    <td><?php echo $data->project_name; ?></td>
                                    <td><?php echo $data->normalized_hours; ?></td>
                                    <td><?php echo round($data->total_hours, 2); ?></td>
                                    <td><?php echo $data->username . "/" . $emp_role; ?></td>
                                    <!--<td><a href="javascript::" onclick="open_modal('<?php echo $i ?>', '<?php echo $data->username . " / " . $emp_role ?>', '<?php echo $data->project_name; ?>', '<?php echo $data->group_dates; ?>', '<?php echo $data->group_hours; ?>')" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="View Dates"><i class="fa fa-calendar"></i></a></td>-->
                                </tr>
                                <?php $i++;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to Approve this record?
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="act_region_submit" class="btn btn-danger change_status" data-val='2'>Approve</button>
            </div>
        </div>
    </div>
</div>
<!-- Activation Modal End -->

<div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to Reject this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="site_submit" class="btn btn-danger change_status" data-val='3'>Reject</button>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="click_for_dates" tabindex="-1" role="dialog" aria-labelledby="changeroleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; margin: auto !important;"><span id="engineer_name"></span> -  
                    <span aria-hidden="true" id="project_name"></span>
                </button>
            </div>
            <div class="modal-body">

                <table style="width:100%; text-align: center;" id="modal_dates_table">
                    <tr><th>Date</th><th>Hours</th></tr>

                </table>

            </div>

        </div>
    </div>
</div> 


<script type="text/javascript">

    $('.approve_record').on('click', function () {
        var id = $(this).attr('data-record_id');
        $('#approve_modal').modal('show');
        $('.change_status').attr('data-id', id);
    });

    /////// Activate Record //////////////
    $('.reject_record').on('click', function () {
        var id = $(this).attr('data-record_id');
        $('#reject_modal').modal('show');
        $('.change_status').attr('data-id', id);
    });

    $('.change_status').on('click', function () {
        var id = $(this).attr('data-id');
        var value = $(this).attr('data-val');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('notification/change_status'); ?>',
            data: {
                where: id,
                table: 'notification',
                value: value,
                column: 'notification_id'
            },
            success: function (data) {
                console.log(data);
                if (data.success == "1") {
                    window.location.href = "<?php echo base_url('notification'); ?>";
                }
            },
            error: function ()
            {
                //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
            }
        });
    });

    /*function validationForm(){
     
     rules: {
     'from_date': {required: true},
     'to_date': {required: true}
     
     },
     messages: { 
     'from_date': { required: "" }, 
     'to_date': { required: "" }
     }
     }*/
    function validationForm() {

        var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());
        if (startDate > endDate) {
            alert('Please ensure that the To Date is greater than From Date.');return false;
        }
    }
    $('#from_date').change(function () {
        $('.form_date_end').datetimepicker('remove');
        $('.form_date_end').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            startDate: new Date($(this).val())
        });
    });

    function sendemail(date, engineer_id, engineer_full_name, engineer_email_id, resource_manager, manager_email_id, email_to)
    {
        $.ajax({

            type: "POST",
            url: '<?php echo base_url('emp_report/sendTimesheetRemainderEmail') ?>',

            data: {week_number: date, engineer_id: engineer_id, engineer_full_name: engineer_full_name, engineer_email_id: engineer_email_id, resource_manager: resource_manager, manager_email_id: manager_email_id, email_to: email_to},

            success: function (data)

            {

                alert('Mail has been sent successfully');

            },

            error: function ()

            {

                alert('Mail has not been sent successfully');

            }

        });
    }

    function open_modal(id, eng_name, project_name, dates, hours) {
        //alert(eng_name);
        var dates_array, hours_array = '';
        $('#engineer_name').html(eng_name);
        $('#project_name').html(project_name);

        dates_array = dates.split(",");
        hours_array = hours.split(",");
        //alert($.type(res));
        var table_data = '<tr><th>Date</th><th>Hours</th></tr>';
        $.each(dates_array, function (i, val) {
            table_data += '<tr><td>' + val + '</td><td>' + hours_array[i] + '</td></tr>';
        });
        $('#modal_dates_table').html(table_data);
        $('#click_for_dates').modal('show');
    }

    function get_projects_user(id) {

        $('#employee_id').html('');
        $('#project_id').html('');
        var role = $('#timesheets').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('emp_report/get_projects_users'); ?>',
            cache: false,
            dataType: "JSON",
            data: {site_id: id, role: role
            },
            success: function (data) {
                var len = data.project.length;
                var options_data = '<option value="">All</option>';
                for (var i = 0; i < len; i++) {
                    options_data += '<option value=' + data.project[i].project_id + '>' + data.project[i].project_name + '</option>';
                }
                var len_user = data.user.length;
                var options_user_data = '<option value="">All</option>';
                for (var i = 0; i < len_user; i++) {
                    options_user_data += '<option value=' + data.user[i].user_id + '>' + data.user[i].user_name + '</option>';
                }
                //alert(len_user); 
                $('#project_id').html(options_data);
                $('#employee_id').html(options_user_data);
            },

        });
    }

    function get_user(role_id) {
        $('#employee_id').html('');
        var site_id = $('#site_name').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('emp_report/get_users'); ?>',
            cache: false,
            dataType: "JSON",
            data: {role_id: role_id, site_id: site_id
            },

            success: function (data) {

                var len_user = data.user.length;
                //alert(len_user);
                var options_user_data = '<option value="">All</option>';
                for (var i = 0; i < len_user; i++) {
                    options_user_data += '<option value=' + data.user[i].user_id + '>' + data.user[i].user_name + '</option>';
                }

                $('#employee_id').html(options_user_data);

            },

        });
    }

    function get_subtask(project_id) {
        var dataString = 'project_id=' + project_id;
        $.ajax
                ({
                    type: "POST",
                    url: "<?php echo base_url('assign_project/getsubtasks'); ?>",
                    data: dataString,
                    cache: false,
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data.subtask_opt);
                        var len = data.subtask_opt.length;
                        var options_data = '<option>All</option>';
                        var selected = '';

                        for (var i = 0; i < len; i++) {
                            /*if($.inArray(data.subtask_opt[i].subtask_id, data.selected_subtask)){
                             var selected = 'selected';
                             }*/
                            options_data += '<option ' + selected + ' value=' + data.subtask_opt[i].subtask_id + '>' + data.subtask_opt[i].subtask_name + '</option>';
                        }

                        $('#subtask_id').html(options_data);

                        if (data.project_info.explicite_subtask == 'no') {
                            //$('#subtask_id').prop('disabled',true); 
                            //$('#subtask_id').prop('title', 'Explicite Subtask field is No');
                        } else {
                            //$('#subtask_id').prop('disabled',false);  
                        }
                    }
                });
    }

</script>



<!-- end page container -->


