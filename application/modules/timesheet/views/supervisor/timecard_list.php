<!-- start page content -->

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

        <div><?php echo $this->session->flashdata('message');?></div>
        
        <div class="row">

        	<div class="col-md-12">

        		<div class="card  card-box">

                    <div class="card-body">
                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'filter_timecard', 'method' => 'GET', 'autocomplete' => "off"); 
                                            echo form_open('timesheet/others_timesheet', $attributes);
                                        ?>


                            <div class="row">
                                <!--<div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12 text-left">Role </label>
                                        <div class="col-md-12">
                                                <?php 
                                                $options['']  = 'Select Option';
                                                
                                                foreach($assign_permission as $role){
                                                    $options[$role->role_id] = $role->role_name;
                                                }
                                                
                                                
                                                $css = array(
                                                        'id'       => 'assign_to',
                                                        'class'    => 'form-control input-height'
                                                        
                                                );

                                                echo form_dropdown('assign_to', $options, $selected_role, $css);
                                            ?>
                                        </div>
                                    </div>
                                </div>-->

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12 text-left">Employee Name </label>
                                        <div class="col-md-12">
                                                <?php 
                                                    $options_reg['']  = 'All Employees';
                                                    foreach($employee_list as $employee){
                                                        $options_reg[$employee->user_id]  = $employee->first_name.' '.$employee->last_name;
                                                    }
                                                    
                                                    $css = array(
                                                            'id'       => 'emp_id',
                                                            'class'    => 'form-control input-height',
                                                            'onchange' => 'get_sites(this.value)'
                                                    );

                                                    echo form_dropdown('emp_id', $options_reg, $emp_id, $css);
                                                ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                      <label class="control-label col-md-12 text-left">Status </label>
                                      <div class="col-md-12">
                                            <?php 
                                                $option['']  = 'All';
                                                $option['2']  = 'Pending';
                                                $option['3']  = 'Approved';
                                                $option['4']  = 'Rejected';
                                                
                                                $css = array(
                                                        'id'       => 'status',
                                                        'class'    => 'form-control input-height'
                                                );

                                                echo form_dropdown('status', $option, $status, $css);
                                            ?>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                   <div class="form-group row">
                                        <label class="col-md-5 control-label text-left">From Date </label>
                                        <div class="input-group date form_date1 col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

                                        <?php 
                                            $data = array(
                                                'name' => 'from_date',
                                                'id' => 'from_date',
                                                'placeholder' => 'Select Date',
                                                'class' => 'form-control',
                                                'size' => 16,
                                                'readonly' => 1,
                                                'value' => $from
                                            );
                                            echo form_input($data); ?>

                                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span> 
                                        </div>

                                        <input type="hidden" id="dtp_input2" value="" />
                                        <span id="startErr" style="color:#C00;" > </span> <br/>
                                    </div>
                               </div>

                               <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-md-5 control-label text-left">To Date </label>
                                        <div class="input-group date form_date1 col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="d M YY">
                                          <?php 
                                            $data = array(
                                                'name' => 'to_date',
                                                'id' => 'to_date',
                                                'placeholder' => 'Select Date',
                                                'class' => 'form-control',
                                                'size' => 16,
                                                'readonly' => 1,
                                                'value' => $to
                                            );
                                            echo form_input($data); ?>
                                          
                                          <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                                        <input type="hidden" id="dtp_input2" value="" />
                                        <span id="endErr" style="color:#C00;" > </span> <br/>
                                      </div>
                               </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                     <div class="form-actions text-center">
                                       
                                            <?php 
                                                $data = array(
                                                        'class'            => 'btn btn-danger mt-3',
                                                        'type'          => 'submit',
                                                        'content'       => 'Search'

                                                );


                                                echo form_button($data);                                             
                                            ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            echo form_close();
                        ?>
                    


                        <div class="table-scrollable">
                            <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Employee ID</th>
                                        <th> Employee Name</th>
                                        <th> Role</th>
                                        <th>Time Period</th>
                                        <th> Status </th>
                                        
                                 </tr>
                             </thead>
                             <tbody>
                                <?php if ( ! empty($mytimesheets) ) : ?>
                                <?php  $i=1; foreach($mytimesheets as $timesheet){ ?>

                                    <tr class="odd gradeX">
                                        <td><?= $i++; ?></td>
                                        <td><?php echo $timesheet->employee_id; ?></td>
                                        <td><?php echo $timesheet->first_name.' '.$timesheet->last_name; ?></td> 
                                        <td><?php echo rtrim($timesheet->role_name,','); ?></td>
                                        <td><?php 
                                        
                                            $url = 'timesheet/others_timesheet_details/'.$timesheet->user_id.'/'.$timesheet->timecard_id;
                                        
                                        echo "<a href='".base_url($url)."'> From  <b>".date('M d, Y', strtotime($timesheet->start_date))."</b>  To  <b>".date('M d, Y', strtotime($timesheet->end_date))."</b></a>"; 

                                        ?></td>
                                        <td><?php if($timesheet->status == 0 ){ echo "Pending"; }
                                        else if($timesheet->status == 1 ) { echo "Saved"; }
                                        else if($timesheet->status == 2 ) { echo "Submitted"; }
                                        else if($timesheet->status == 3 ) { echo "Approved"; }
                                        else{ echo "Rejected"; } ?></td>
                                    </tr>
                                <?php } ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>

<script type="text/javascript">
    $(document).ready(function(){

        $('.form_date1').datetimepicker({
            weekStart: 1,
            //todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0,2,3,4,5,6"
        });

    });
</script>