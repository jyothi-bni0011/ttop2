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

                    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'filter_timesheets', 'method' => 'POST', 'autocomplete' => "off"); 
                        echo form_open('timesheet/my_timesheet', $attributes);
                    ?>
                    <br /><br />
                    <div class="form-group row">
                      <label class="control-label col-md-3">From Date </label>
                      <div class="col-md-5">
                            <div class="input-group date form_date form_date_start col-md-8" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

                            <?php 
                            $data = array(
                                'name' => 'from_date',
                                'id' => 'start_date',
                                'placeholder' => 'Select Date',
                                'class' => 'form-control',
                                'size' => 16,
                                'readonly' => 1,
                                'value' => $selected_from
                            );
                            echo form_input($data); ?>

                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-3">To Date </label>
                      <div class="col-md-5">
                            <div class="input-group date form_date form_date_end col-md-8" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

                            <?php 
                            $data = array(
                                'name' => 'to_date',
                                'id' => 'end_date',
                                'placeholder' => 'Select Date',
                                'class' => 'form-control',
                                'size' => 16,
                                'readonly' => 1,
                                'value' => $selected_to
                            );
                            echo form_input($data); ?>

                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-3">Status </label>
                      <div class="col-md-5">
                        <div class="col-md-8">
                            <?php 
                                $options['']  = 'Select Option';
                                $options['0']  = 'Pending';
                                $options['1']  = 'Saved';
                                $options['2']  = 'Submitted';
                                $options['3']  = 'Approved';
                                $options['4']  = 'Rejected';
                                
                                $css = array(
                                    'id'       => 'status',
                                    'class'    => 'form-control input-height'
                                );

                                echo form_dropdown('status', $options, $selected_status, $css);
                            ?>
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="offset-md-3 col-md-9">
                                <?php 
                                    $data = array(
                                            'class'            => 'btn btn-danger',
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
                                    <th>Time Period</th>
                                    <th> Status </th>
                                    

                             </tr>
                         </thead>
                         <tbody>
                            <?php if ( ! empty($mytimesheets) ) : ?>

                            <?php  $i=1; foreach($mytimesheets as $timesheet){ ?>

                                <tr class="odd gradeX">
                                    <td><?= $i++; ?></td> 
                                    <td><?php 
                                    //$url = 'timesheet/index/'.$timesheet->timecard_id.'/direct_mode';
                                    $url = 'timesheet/my_timesheet/direct_mode/'.$timesheet->timecard_id;
                                    
                                    echo "<a href='".base_url($url)."'> From  <b>".date('M d, Y', strtotime($timesheet->start_date))."</b>  To  <b>".date('M d, Y', strtotime($timesheet->end_date))."</b></a>"; 

                                    ?></td>
                                    <td><?php if($timesheet->status == 0 ){ echo "Pending"; }
                                    else if($timesheet->status == 1 ) { echo "Saved"; } 
                                    else if($timesheet->status == 2 ) { echo "Submitted"; }
                                    else if($timesheet->status == 3 ) { echo "Approved"; }
                                    else if($timesheet->status == 4 ) { echo "Rejected"; }?></td>
                                </tr>
                            <?php } ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        