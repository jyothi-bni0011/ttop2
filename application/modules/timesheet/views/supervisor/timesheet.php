<style>

    select.error {

    border-color: red;

    background-color: #FFCCCC;

}

</style>

<!-- start page content -->



		<div class="page-bar">



			<div class="page-title-breadcrumb">



				<div class=" pull-left">



					<div class="page-title">Timesheet</div>



				</div>



				<ol class="breadcrumb page-breadcrumb pull-right">



					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>



					</li>

                    <li class="active">Timesheet</li>



                </ol>



            </div>



        </div>



        <div><?php echo $this->session->flashdata('message');?></div>

        

        <div class="row">



        	<div class="col-md-12">



        		<div class="card  card-box">



                

        		<div class="card-body ">

                    <?php  //echo "<pre>";print_r( ($timecard) );exit();

                        $current_week = date('W');

                        $current_year = date('Y');

                        

                        $firstweekday = date("M d, Y", strtotime("{$current_year}-W{$current_week}-1")); 

                        $lastweekday = date("M d, Y", strtotime("{$current_year}-W{$current_week}-7")); 

                        $update_flag = 0;

                        

                        /*if($this->uri->segment(5) && $this->uri->segment(6)){

                            $firstweekday = date("M d, Y", $this->uri->segment(6)); 

                            $lastweekday = date('d-m-Y',strtotime($firstweekday . "+6 days"));    

                        } else */

                        if(!empty($mytimesheet) && !empty($timecard->start_date)){

                            $firstweekday = date("M d, Y", strtotime($timecard->start_date)); 

                            $lastweekday = date('d-m-Y',strtotime($firstweekday . "+6 days"));

                            $update_flag = 1;    

                        }else{

                            //echo $firstweekday = $firstweekday; 

                            //$lastweekday = $lastweekday;

                        }



                        $days = array();

                        //$timestamp = strtotime('next Sunday');

                        for ($i = 0; $i < 7; $i++) {

                             $date = date('d-m-Y', strtotime("+$i day", strtotime($firstweekday)));

                             $day = date('l', strtotime("+$i day", strtotime($firstweekday)));

                             $days[$day] = $date;

                            //$days[] = strtotime('+1 day', $firstweekday);

                        }


                        $next_week_day = strtotime(date('d-m-Y',strtotime($lastweekday . "+1 days")));

                        $prev_week_day = strtotime(date('d-m-Y',strtotime($firstweekday . "-7 days")));


                        
                            
                        $mode = 'direct_mode';
                      


                    ?>

                    <div class="form-group row">
                        <div class="col-md-12">
                            
                            <div style="margin-left:1%;" id="alert_message_period_close"></div>
                        </div>
                    </div>

                    <div id="timesheet_direct_mode">

                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'timesheet_form', 'method' => 'POST', 'autocomplete' => "off"); 

                            echo form_open('timesheet/update_timesheet_by_supervisor', $attributes);

                            //echo "<pre>";print_r($my_timesheet);

                        ?>

                        

                        <input type="hidden" name="start_date" value="<?php echo ($firstweekday) ?>" id="start_date" >

                        <input type="hidden" name="end_date" value="<?php echo ($lastweekday) ?>" id="end_date" >

                        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">

                        <input type="hidden" name="timecard_id" value="<?php echo $timecard->timecard_id; ?>">

                        <input type="hidden" name="timecard_submit_btn" id="timecard_submit_btn" value="">

                        <input type="hidden" name="timecard_status" id="timecard_status" value="<?php echo $timecard->status; ?>">

                        <input type="hidden" name="next_date" value="<?php echo ($next_week_day) ?>" id="next_date" >

                        <input type="hidden" name="prev_date" value="<?php echo ($prev_week_day) ?>" id="prev_date" >

                    

                        <div style="margin-top:1%;">

                            <?php

                                $timesheet_status='';
                                //echo $timecard->status; exit;
                                switch ( $timecard->status ) {

                                    case '1':

                                        $timesheet_status = 'Saved';

                                        break;



                                    case '2':

                                        $timesheet_status = 'Submitted';

                                        break;

                                    

                                    case '3':

                                        $timesheet_status = 'Approved';

                                        break;



                                    case '4':

                                        $timesheet_status = 'Rejected';

                                        break;

                                    default:

                                        $timesheet_status = 'Pending';

                                        break;

                                }

                            ?>

                            <b>Timesheet for week starting <?php echo $firstweekday.' - '.$mytimesheet[0]->username; ?> - (Status - <?= $timesheet_status; ?>)</b>

                        </div>


                          <?php 
                                $hide_approve = 0;
                                //echo $timecard->status; exit;
                                if ( $timecard->status == 3 || $timecard->status == 4) {
                                    $hide_approve = 1;
                                }
                                //echo "<pre>"; print_r($close_flag); exit;
                                //if(!empty($close_flag) || $timecard->status == 4) 
                                if($timecard->status == 3 || $timecard->status == 4) 
                                {
                                    $table_flag = 1;    
                                }
                                else
                                {
                                    $table_flag = 0;
                                }

                            ?>


                        <div class="table-scrollable">

                            <table class="table table-bordered table-striped table-condensed width-adjust" <?=($table_flag ? 'id="tableExport1"' : 'id="tblTimegrid"');?> >

                                <thead>

                                    <th>Project</th>

                                    <th width="150">Subtask</th>

                                        <?php $i=0;

                                        foreach($days as $key=>$val){ ?>

                                        <td style="text-align:center; <?php if($i>4) echo "color:red";?>"><?php echo $key."<br />".$val; ?></td>

                                        <?php $i++; 
                                            } ?>

                                        <th style="text-align:center;">Total</th>
                                        <th style="text-align:center;"></th>
                                </thead>

                               

                                <!-- Venkatesh code -->

                                

                                <?php $holiday_flag = $friday_flag = 0;
                                if((date('l') == 'Friday') || date('l') == 'Saturday' || date('l') == 'Sunday'){
                                    $disable_submit = 'enabled';
                                    $friday_flag = 1;
                                }  
                                $tmp = $count = 0; foreach ($my_timesheet as $project_id => $value) : $options_st =[];  ?>

                                    <?php foreach ($value as $values) : ?>

                                    <tr id="<?= 'row_'.$tmp; ?>">

                                        <td style="width: 12%;">

                                            <?php 

                                                $options['']  = 'Select Project';

                                                foreach($projects as $project){

                                                    $options[$project->id]  = $project->project_name;    

                                                }

                                                                                            

                                                $css = array(

                                                        'id'       => 'selectProject_'.$tmp,

                                                        'class'    => 'form-control',

                                                       // 'onchange' => 'get_subtask(this.value, '.$tmp.')'
                                                        'onchange' => "get_subtask(this.value, ".$tmp.", $('option:selected', this).text())"

                                                );

                                                if ( $table_flag ) 

                                                  {

                                                       echo $values[0]->project_name;

                                                   }

                                                   else

                                                   {

   

                                                      echo form_dropdown('selectProject['.$tmp.']', $options, $values[0]->project_id, $css);

                                                   }    

                                                

                                            ?>

                                        </td>

                                        <td><?php $css = 'id="selectSubtask_'.$tmp.'" class="form-control" onchange="check_duplicate()"';

                                                $options_st[''] = 'Select';

                                                // print_r($subtasks);

                                                // print_r($values);

                                                if( !empty($subtasks[$project_id]['result']) ) {

                                                    foreach($subtasks[$project_id]['result'] as $keys => $sub){

                                                        $options_st[$sub->subtask_id] = $sub->subtask_name; 

                                                    }

                                                }

                                                if ( $table_flag ) 

                                                  {

                                                      echo $values[0]->subtask_name;

                                                   }

                                                  else

                                                  {

   

                                                   echo form_dropdown('selectSubtask[]', $options_st, $values[0]->subtask_id, $css); 

                                                   }

                                                 ?>

                                        </td> 

                                                                            

                                        <?php  $j=0;

                                        $total_hours = 0;
                                        $day_holiday = 0;
                                        foreach($days as $key=>$val){ 

                                            foreach ($values as $key1 => $val1) {

                                                if ( $j == $key1 ) 

                                                {
                                                    $loopdate = date('Y-m-d', strtotime($val));
                                                    echo "<td style='text-align: center;'>";

                                                    

                                                    foreach(HOLIDAY_PROJECTS as $hol){
                                                        if (strpos(strtolower($values[0]->project_name), $hol) !== false) {
                                                            $holiday_flag = 1;
                                                            $day_holiday = 1;
                                                        }
                                                    }

                                                    if($loopdate > date('Y-m-d') && $day_holiday == 0 && $friday_flag == 0){
                                                        $able = 'disabled';
                                                        $title = 'You cannot fill future dated timesheet';
                                                    }else if($val1->disabled == 1){
                                                        $able = 'disabled';

                                                        $title = 'Disabled box means Assigned project is out of date range';

                                                    }else{ 
                                                        $able = 'enabled';
                                                        $title = '';
                                                    }

                                                    $data = array(

                                                                    'name'        => 'hour_'.$j.'[]',

                                                                    'id'          => 'hour_'.$tmp.'_'.$j,

                                                                    'value'       => $val1->tot_hr,

                                                                    'maxlength'   => '100',

                                                                    'size'        => '50',

                                                                    'style'       => 'width:50%; text-align:center;',

                                                                    'onblur'      => 'callTotal(this.value, '.$tmp.')',

                                                                    'class'       => 'Hour_text_'.$tmp.' col_'.$j. ' hour_text_class',

                                                                    'onkeypress'  => 'return isNumber(this,event)',

                                                                    'onchange'     => 'return isGreater($(this).attr(\'id\'))',
                                                                    $able           => true,
                                                                    'title'         => $title

                                                                  );

                                                    if ( $table_flag ) 

                                                      {

                                                          echo $val1->tot_hr;

                                                      }

                                                      else

                                                      {

  

                                                           echo form_input($data);

                                                      }

                                                    

                                                    echo "</td>";



                                                    $total_hours += $val1->tot_hr;

                                                }

                                            }

                                          $j++;

                                        } ?>

                                        <td style='text-align: center;'>

                                            <?php 

                                            $data = array(

                                                    'name'        => 'hour_total[]',

                                                    'id'          => 'hour_total_'.$tmp,

                                                    'value'       => $total_hours,

                                                    'maxlength'   => '100',

                                                    'size'        => '50',

                                                    'style'       => 'width:50%; text-align:center;',

                                                    'class'       => 'total_text_'.$tmp,

                                                    'disabled'    => TRUE

                                                  );

                                                if ( $table_flag ) 

                                                   {

                                                       echo $total_hours;

                                                   }

                                                  else

                                                   {

   

                                                       echo form_input($data);

                                                   }

                                                

                                            ?>

                                        </td>
                                        <?php if(!($table_flag)) { ?>
                                        <td>
                                            <?php if ( $tmp == 0 ) { ?>

                                                <button onclick = 'addRow(); return false;' class="btn btn-success">+</button>
                                            <?php } else { ?>

                                                <button class="btn btn-danger rm_btn" id="rm_btn_id_'<?php echo $tmp ?>'" onclick="removeRow('<?php echo $tmp ?>'); return false;">-</button>
                                            <?php } ?>
                                        </td>
                                        <?php }
                                        $count++;?>

                                    </tr>

                                    <?php $tmp++; endforeach; ?>

                                <?php endforeach; ?>

                                

                                <!-- venkatesh code end -->

                            </table>

                            

                        </div>

                        <div class="form-actions text-center">

                            <div class="row">

                                <div class="col-md-12">

                                <a href="<?php echo base_url('timesheet/others_timesheet');?>">

                                    <button type="button" name="back_button" class="btn btn-default">Back</button>

                                </a>



                                <?php 

                                if (! $table_flag )

                                {

                                    // $data = array(

                                    //         'class'            => 'btn btn-default',

                                    //         'type'          => 'button',

                                    //         'content'       => 'Add Row',

                                    //         'onclick'       => 'addRow(); return false;'

                                    // );



                                    // echo form_button($data);



                                    //  $data1 = array(

                                    //         'class'            => 'btn btn-default',

                                    //         'type'          => 'button',

                                    //         'content'       => 'Remove Row',

                                    //         'onclick'       => 'removeRow(); return false;',

                                    //         'style'         => 'display:none;',

                                    //         'id'            => 'btnRemoveRow',

                                    //         'name'          => 'btnRemoveRow'

                                    // );



                                    // echo form_button($data1);



                                    /*$data = array(

                                            'class'            => 'btn btn-default',

                                            'id'            => 'save_btn',

                                            'type'          => 'button',

                                            'content'       => 'Save',

                                            'onclick'       => 'SaveData(2);'

                                    );



                                    echo form_button($data);*/

                                

                                    $data2 = array(

                                            'class'            => 'btn btn-danger',

                                            'id'            => 'submit_btn',

                                            'type'          => 'button',

                                            'content'       => 'Update',

                                            'data-toggle'   => 'modal',

                                            'data-target'   => '#update_modal',

                                            //'onclick'       => 'SaveData(2);'

                                    );



                                    echo form_button($data2);

                                }

                                ?>



                                </div>

                                <input type="hidden" value="<?php if($my_timesheet){ echo $count; } else { echo "1"; } ?>" name="addrowcount" id="addrowcount"> 

                                <input type="hidden" name="tasks">

                                <input type="hidden" name="subtasks">

                            </div>

                        </div>



                        <div class="form-actions text-center">

                            <div class="row">

                                <div class="col-md-12">

                                

                                <?php 

                                if (! $table_flag && $hide_approve != 1 ){

                                    $data = array(

                                            'class'         => 'btn btn-success',

                                            'id'            => 'approve_btn',

                                            'type'          => 'button',

                                            'content'       => 'Approve',

                                            'data-toggle'   => 'modal',

                                            'data-target'   => '#approve_modal',

                                            // 'onclick'       => 'approve_reject(3);'

                                    );



                                    echo form_button($data);

                                

                                    $data2 = array(

                                            'class'            => 'btn btn-danger',

                                            'id'            => 'reject_btn',

                                            'type'          => 'button',

                                            'content'       => 'Reject',

                                            'data-toggle'   => 'modal',

                                            'data-target'   => '#reject_modal',

                                            // 'onclick'       => 'approve_reject(4);'

                                    );



                                    echo form_button($data2);

                                }

                                ?>



                                </div>

                            </div>

                        </div>

                        

                      <?php  echo form_close(); ?>

                    </div>

        		

                </div>

                

                </div>



            </div>



        </div>



        <!-- Error message -->

        <div class="modal fade" id="day_time_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body" id="modal_error_message">

                        

                    </div>

                    <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Error message End -->



        <!-- Update confirmation modal -->

        <div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body">

                        Are you sure you want to update this timesheet?

                    </div>

                    <div class="modal-footer">

                        

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                            <button type="button" onclick="SaveData(2);" class="btn btn-danger change_status" data-val='1'>Update</button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Update confirmation modal -->



        <!-- approve confirmation modal -->

        <div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body">

                        Are you sure you want to approve this timesheet?

                    </div>

                    <div class="modal-footer">

                        

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                            <button type="button" onclick="approve_reject(3);" class="btn btn-success change_status" data-val='1'>Approve</button>

                    </div>

                </div>

            </div>

        </div>

        <!-- approve confirmation modal -->



        <!-- reject confirmation modal -->

        <div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body">

                        Are you sure you want to reject this timesheet?

                    </div>

                    <div class="modal-footer">

                        

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                            <button type="button" onclick="approve_reject(4);" class="btn btn-danger change_status" data-val='1'>Reject</button>

                    </div>

                </div>

            </div>

        </div>

        <!-- approve confirmation modal -->



         <!-- end page container -->

        <script type="text/javascript">

            function get_subtask(project_id, row_id, name){

                var dataString = 'project_id='+ project_id;
                var exist_holiday = '<?php echo $holiday_flag;?>';
                //$('.Hour_text_'+row_id).val(0);
                //$('#hour_total_'+row_id).val(0);
                
                var enable_submit_flag = 0;
                var cur_day = '<?php echo date('l');?>';
                var friday_flag = 0;
                if(cur_day == 'Friday' || cur_day == 'Saturday' || cur_day == 'Sunday'){
                    $('#submit_btn').attr("disabled", false);//enable save & submit access
                    friday_flag = 1;
                    enable_submit_flag = 1;
                }

                $("[name^=selectProject]").each(function() {
                    //alert($("option:selected", this).text());
                    var project_name = $("option:selected", this).text();
                    <?php foreach(HOLIDAY_PROJECTS as $proj){ ?>
                        name1 = project_name.toLowerCase();
                        incStr = name1.includes('<?php echo $proj; ?>');
                        //alert(incStr);
                        if(incStr == true){
                            enable_submit_flag = 1;
                        }

                    <?php } ?>
                });
                //alert(enable_submit_flag);

                $.ajax

                ({

                    type: "POST",

                    url: "<?php echo base_url('timesheet/getsubtasks');?>",

                    data: {

                        project_id : project_id,

                        user_id : $('#user_id').val()

                    },

                    cache: false,

                    dataType: "JSON",

                    success: function(data)

                    {

                        var len = data.subtask_opt.length;
                        var options_data = '<option value="">Select</option>';
                        for(var i=0; i<len; i++){
                            options_data += '<option value='+data.subtask_opt[i].subtask_id+'>'+data.subtask_opt[i].subtask_name+'</option>';
                        }

                        $('#selectSubtask_'+row_id).html(options_data);
                        $('#project_end_date_'+row_id).val(data.end_date);

                        //console.log(data.holiday_projects);
                        var incStr = '';
                        var Holiday_flag = 0;
                        var hol_len = data.holiday_projects.length;
                        for(var j=0; j<hol_len; j++){ 
                            name1 = name.toLowerCase(); 
                            incStr = name1.includes(data.holiday_projects[j]);
                            //alert(incStr);
                            if(incStr == true){
                                Holiday_flag = 1;
                            }
                        }
                        //alert(Holiday_flag);

                        var disabled_submit = 0;
                        //Disable days fields if end date 
                        <?php $i=0;  foreach($days as $key=>$val){ 
                            $newdate = date('Y-m-d', strtotime($val)); ?>
                            var new_date = '<?php echo $newdate; ?>';
                            var today_date = '<?php echo date('Y-m-d'); ?>';
                            //alert(friday_flag+'*'+Holiday_flag);
                            if(new_date > today_date && Holiday_flag == 0 && friday_flag == 0){ 
                                $('#hour_'+row_id+'_<?php echo $i?>').prop("disabled", true);
                                $('#row_'+row_id).prop("data-toggle", "tooltip");
                                $('#hour_'+row_id+'_<?php echo $i?>').attr("title", "You cannot fill future dated timesheet");
                                disabled_submit = 1;
                                //enable_submit_flag = 0;
                                //Holiday_flag = 0;
                            } else if(new_date > data.end_date){  
                                $('#hour_'+row_id+'_<?php echo $i?>').prop("disabled", true);
                                $('#row_'+row_id).prop("data-toggle", "tooltip");
                                $('#hour_'+row_id+'_<?php echo $i?>').attr("title", "Disabled box means Assigned project is out of date range");
                            } else if(new_date < data.start_date){  
                                $('#hour_'+row_id+'_<?php echo $i?>').prop("disabled", true);
                                $('#row_'+row_id).prop("data-toggle", "tooltip");

                                $('#hour_'+row_id+'_<?php echo $i?>').attr("title", "Disabled box means Assigned project is out of date range");
                            } else { 
                                $('#hour_'+row_id+'_<?php echo $i?>').prop("disabled", false);
                                //enable_submit_flag = 1;
                                //Holiday_flag = 1;
                            }


                            if(new_date < today_date){
                                $("#submit_btn").attr("disabled", false);
                            }else if(enable_submit_flag == 0){
                                $("#submit_btn").attr("disabled", true);
                            }else if(Holiday_flag == 1 || exist_holiday == 1){
                                $("#submit_btn").attr("disabled", false);
                            }else{
                                 $("#submit_btn").attr("disabled", false);
                            }

                            // if(disabled_submit == 1 || new_date > today_date){ 
                            //     $("#submit_btn").attr("disabled", true);
                            // }else if(enable_submit_flag == 0 || new_date > today_date){ 
                            //     $("#submit_btn").attr("disabled", true);
                            // }else if(Holiday_flag == 1 || exist_holiday == 1){ 
                            //     $("#submit_btn").attr("disabled", false);
                            // }else{
                            //     $("#submit_btn").attr("disabled", true);
                            // }
                        <?php $i++; } ?>

                    } 

                });

            }



            function callTotal(hour, row_id){

                var sum = 0;

                $(".Hour_text_"+row_id).each(function(){ 

                    sum += +$(this).val();

                });

                $(".total_text_"+row_id).val(sum.toFixed(2));

            }



            function addRow(){  

                $('#btnRemoveRow').show();
                //$('.rm_btn').remove();
                tr_id = $('#addrowcount').val();

                var projectarray = <?php echo json_encode($projects); ?>;

                

                tbl_content = "<tr id=row_"+tr_id+"><td><select name='selectProject["+tr_id+"]' id='selectProject_"+tr_id+"' class='form-control' onchange='get_subtask(this.value, "+tr_id+", $(\"option:selected\", this).text())'><option value=''>Select Project</option>";

                    $.each( projectarray, function( key, value ) {

                        tbl_content += "<option value="+value.id+">"+value.id1+"</option>";

                    });

                

                tbl_content += "</select></td>";

                tbl_content += '<td><select name="selectSubtask['+tr_id+']" id="selectSubtask_'+tr_id+'" class="form-control" onchange="check_duplicate()"><option value="">Select</option></td>';

                <?php 

                for($i=0; $i<count($days); $i++){?>

                    tbl_content += '<td style="text-align: center;"><input value="0" class="Hour_text_'+tr_id+' col_'+<?php echo $i;?>+' hour_text_class" type="text" name="hour_'+<?php echo $i;?>+'['+tr_id+']" id="hour_'+tr_id+'_'+<?php echo $i;?>+'" maxlength="25" size="50" style="width:50%; text-align: center;" onblur="callTotal(this.value, '+tr_id+')" onkeypress="return isNumber(this,event)" onchange="return isGreater($(this).attr(\'id\'))" ></td>';

                <?php } ?>

                    

                tbl_content += '<td style="text-align: center;"><input type="text" value="0" class="total_text_'+tr_id+'" name="hour_total['+tr_id+']" id="hour_total'+tr_id+'" size=50 style="width:50%;" disabled=1></td><td class="rm_btn_td"><button class="btn btn-danger rm_btn" onclick="removeRow('+tr_id+'); return false;">-</button></td></tr>';

                $('#tblTimegrid tr:last').after(tbl_content);

                $('#addrowcount').val(parseInt(tr_id) + 1); 

            }

            function removeRow(row_id){
                tr_id = $('#addrowcount').val();
                if(tr_id > 1){
                    $('#row_'+row_id).remove();
                }
            }      

            /*function removeRow(){

                 tr_id = $('#addrowcount').val();
                 
                 if(tr_id > 1){

                    $('#addrowcount').val(parseInt(tr_id) - 1);

                    $('#tblTimegrid tr:last').remove();

                }
                $('.rm_btn_td:last').html('<button class="btn btn-danger rm_btn" onclick="removeRow(); return false;">-</button>');
            }*/
            

            function SaveData(status){  

                $('.hour_text_class').prop('disabled',false); 

                $('#timecard_submit_btn').val(status);

                $("#timesheet_form" ).submit();

            }



            $("#timesheet_form" ).submit(function(){

                $("[name^=selectProject]").each(function() {

                    // alert($(this).val());

                    $(this).rules("add", 

                    {

                        required: true,

                        messages: {

                            required: "Project is required",

                        }

                    });

                });

                if ( $('#update_modal').is(':visible') ) 
                {
                    $('#update_modal').toggle();
                    $('.modal-backdrop').hide();   
                }

            });



            // function isNumber(evt) {

                

            //     evt = (evt) ? evt : window.event;

            //     var charCode = (evt.which) ? evt.which : evt.keyCode;

            //     if (charCode > 31 && (charCode < 48 || charCode > 57) ) {

            //         return false;

            //     }

            //     return true;

            // }

            function isNumber(el, evt) {
                
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                var number = el.value.split('.');
                if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57) ) {
                    return false;
                }
                //just one dot
                if(number.length>1 && charCode == 46){
                     return false;
                }

                //get the carat position
                var caratPos = getSelectionStart(el);
                var dotPos = el.value.indexOf(".");
                if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
                    return false;
                }
                return true;
            }

            function getSelectionStart(o) {
                if (o.createTextRange) {
                    var r = document.selection.createRange().duplicate()
                    r.moveEnd('character', o.value.length)
                    if (r.text == '') return o.value.length
                    return o.value.lastIndexOf(r.text)
                } else return o.selectionStart
            }

            function isGreater(id) 

            {

                var $modal = $('#day_time_error');

                id = '#'+id;

                //alert($(id).val());

                var sum_class = '.'+$(id).attr('class').split(' ')[1];



                var sum = 0;

                $(sum_class).each(function(){

                    if(parseInt(this.value) < 0) {
                        $('#modal_error_message').html('Value must be greater than 0.');
                        $modal.modal('show');
                        $(id).val('0');
                        return;
                    }

                    sum += parseInt(this.value);  // Or this.innerHTML, this.innerText

                });

                if ( parseInt(sum) > 24 ) 
                {
                    $('#modal_error_message').html('Day hours can not be greater than 24.');
                    $('#day_time_error').modal('show');
                    $(id).val('0');
                }

                /*if(isNaN(parseInt(sum))) {
                    $('#modal_error_message').html('Please enter numbers only.');
                    $modal.modal('show');
                    $(id).val('0');
                    return;
                }*/

                $(id).css('border-color','');

                return true;

            }



            /* validation part for project&subtask 

            *  @created on:29/05/2019 @created by:Jyothi

            *  @modified on:29/05/2019 @modified by:Jyothi

            */

            function check_duplicate(){

                 

                var $elements = $("select[name='selectSubtask[]']");
                var cur_day = '<?php echo date('l');?>';
                var flag = 0;
                var exist_holiday = '<?php echo $holiday_flag;?>';

                if(cur_day == 'Friday' || cur_day == 'Saturday' || cur_day == 'Sunday' || exist_holiday == 1){
                    $('#submit_btn').attr("disabled", false);//enable save & submit access
                    var flag = 1;
                }

                $elements.removeClass('error').each(function () {

                    var selectedValue = this.value;

                    $elements.not(this).filter(function() {

                            return this.value === selectedValue;

                        }).addClass('error');

                });

                //disable save & submit access

                if ( $elements.hasClass("error") ) {
                    $('#save_btn,#submit_btn').attr("disabled", true);
                } else {
                    $('#save_btn').attr("disabled", false);
                    if(flag == 1){
                        $('#submit_btn').attr("disabled", false);
                    }
                }

            }



            $(document).ready(function(){

                var status = $('#timecard_status').val();

                // if(status == 3 || status == 4){

                //     $("#timesheet_form :input").prop("disabled", true);

                // }

                $("#timesheet_form").validate();
                //Period is closed message and disable all inputs

                <?php if(!empty($close_flag)){ ?>
                    //Period is closed message and disable all inputs
                    var period_close = "<?php echo $close_flag['status']; ?>";
                    var period_close_date = "<?php echo $close_flag['end']; ?>";
                    var today_date = '<?php echo date('Y-m-d');?>';
                    
                    if(period_close == 2){
                        $("#timesheet_form :input").not("[name=back_button]")
                        .prop("disabled", true);
                        $('#timesheet_form').attr("data-toggle", "tooltip");
                        $('#timesheet_form').prop('title', 'Period is Closed - '+period_close_date);
                    } 
                        
                    //$("#timesheet_form :input").attr("disabled", true);
                   
                    $('#alert_message_period_close').html('Period Close Date '+period_close_date);
                    
                <?php } ?>

            });



            function approve_reject( status )

            {

                var id = $('input[name="timecard_id"]').val();

                var value = status;

                $.ajax({

                    type: "POST",

                    url: '<?php echo base_url('timesheet/change_status');?>',

                    data: {

                                where : id,

                                table : 'timecard',

                                value : value,

                                column : 'timecard_id'

                            },

                    success:function(data) {

                        console.log(data);

                        if(data.success == "1") {

                            window.location.href = "<?php echo base_url('timesheet/others_timesheet'); ?>";

                        }

                    },

                    error:function()

                    {

                        //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");

                    }

                });

            }



        </script>