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
                        
                        
                        $firstweekday = date("M d, Y", strtotime($start_date)); 
                        $lastweekday = date("M d, Y", strtotime($end_date)); 
                        $update_flag = 0;

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

                        
                    ?>
                    
                    
                    <div class="form-group row">
                        
                      
                    </div>

                    <div id="timesheet_direct_mode">
                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'timesheet_form', 'method' => 'POST', 'autocomplete' => "off"); 
                            echo form_open('timesheet/update_timesheet_by_supervisor', $attributes);
                            //echo "<pre>";print_r($my_timesheet);
                        ?>
                        
                       
                    
                        <div style="margin-top:1%;">
                            
                            <!-- <b>Timesheet for week starting <?php //echo $firstweekday.' - '.$mytimesheet[0]->username; ?> - (Status - <?= $timesheet_status; ?>)</b> -->
                        </div>


                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-condensed width-adjust" id="tableExport1" >
                                <thead>
                                    <th>Project</th>
                                    <th width="150">Subtask</th>
                                        <?php $i=0;
                                        foreach($days as $key=>$val){ ?>
                                        <td style="text-align:center; <?php if($i>4) echo "color:red";?>"><?php echo $key."<br />".$val; ?></td>
                                        <?php $i++; } ?>
                                        <th style="text-align:center;">Total</th>
                                </thead>
                               
                                <!-- Venkatesh code -->
                                
                                <?php $tmp = $count = 0; foreach ($my_timesheet as $project_id => $value) : $options_st =[];  ?>
                                    <?php foreach ($value as $values) : ?>
                                    <tr id="<?= 'row_'.$tmp; ?>">
                                        <td style="width: 12%;">
                                            <?php 
                                                
                                                    echo $values[0]->project_name;
                                                
                                                
                                            ?>
                                        </td>
                                        <td><?php 
                                                    echo $values[0]->subtask_name;
                                                
                                                ?>
                                        </td> 
                                                                            
                                        <?php  $j=0;
                                        $total_hours = 0;
                                        foreach($days as $key=>$val){ 
                                            foreach ($values as $key1 => $val1) {
                                                if ( $j == $key1 ) 
                                                {
                                                    echo "<td style='text-align: center;'>";
                                                    
                                                    
                                                        echo $val1->tot_hr;
                                                    
                                                    echo "</td>";

                                                    $total_hours += $val1->tot_hr;
                                                }
                                            }
                                          $j++;
                                        } ?>
                                        <td style='text-align: center;'>
                                            <?php 
                                            
                                                    echo $total_hours;
                                               
                                            ?>
                                        </td>
                                        <?php $count++;?>
                                    </tr>
                                    <?php $tmp++; endforeach; ?>
                                <?php endforeach; ?>
                                
                                <!-- venkatesh code end -->
                            </table>
                            
                        </div>
                        <div class="form-actions text-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?php echo base_url('dashboard');?>">
                                        <button type="button" class="btn btn-default">Back</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                      <?php echo form_close(); ?>
                    </div>
        		
                </div>
                
                </div>

            </div>

        </div>
