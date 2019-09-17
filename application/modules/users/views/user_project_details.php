
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Details of <?php echo $userdata->username;  ?></div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard');?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                               
                                <li class="active">User Details</li>
                            </ol>
                        </div>
                    </div>
					<div><?php echo $this->session->flashdata('message');?></div>
                    <div class="row">
					
										
											
                        <div class="col-md-12">
                            <div class="card  card-box">
                                <div class="card-body ">
								<form method="get" action="<?php echo base_url();?>users/search_user_project_details/<?= $userdata->user_id ?>">
								<div class="form-group row">
                                            <label class="col-md-3 control-label">From Date
											
											</label>
                                            <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input class="form-control" size="16" type="text" name="from_date" id="form_date" placeholder="Select Date" value="<?php echo date("Y-m-d", strtotime($form_date));?>" readonly required>
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input2" value="" />
											<span id="startErr" style="color:#C00;" > </span>
                                            <br/>
                                        </div>
										
										<div class="form-group row">
                                            <label class="col-md-3 control-label">To Date
											
											</label>
                                            <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="d M YY">
                                                <input class="form-control" size="16" type="text" name="to_date" id="to_date" placeholder="Select Date" value="<?php echo date("Y-m-d", strtotime($to_date));?>" readonly required>
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input2" value="" />
											<span id="endErr" style="color:#C00;" > </span>
                                            <br/>
                                        </div>
										
										<!-- <input type="hidden" name="user_id" id="username" value="<?php //echo $userdata->user_id;?>"> -->
										
										<div class="form-group row">
                                                <label class="control-label col-md-3">Project Name
                                                   
                                                </label>
                                                <div class="col-md-5">
                                                    <select class="form-control input-height" name="project_id" id="project_name">
                                                        <option value="">Select Project</option>
														<?php foreach($project_list as $project_data)   {
															if($project_id == $project_data->project_id) {
															?>
                                                        <option value="<?php echo $project_data->project_id;?>" selected><?php echo $project_data->project_name;?></option>
														<?php }else {?>
															    <option value="<?php echo $project_data->project_id;?>"><?php echo $project_data->project_name;?></option>
														<?php }} ?>
                                                        
                                                    </select>
                                                </div>
												
												<span id="siteErr" style="color:#C00;" > </span>
                                            </div>
											
											
											
											
											
											
											
											
										
										<div class="form-actions">
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit" class="btn btn-danger" onclick="return validateForm();">Search</button>
                                                    
                                                </div>
                                            	</div>
                                       		 </div>
								</form>
								
                                <div class="row">
                        <div class="col-md-12">
                            <div class="card  card-box">
                                 <div class="card-head">
							   <header>Active Projects</header>
							   </div>
                                <div class="card-body" id="chartjs_pie_parent">
                                    <div class="row">
                                    <div class="col-md-12">
                                        <canvas id="chartjs_pie"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
								
                                   <div class="table-scrollable">
                                    <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                                        <thead>
                                            <tr>
											     <th> S.NO </th>
												 
<!--                                                 <th> Project Number </th> -->
												 <th> Project Name </th>
												 <!--<th> Engineer Name </th>-->
												 <th> Subtasks </th>
												 <th> Cost Center </th>
                                                 <th> Cost Center Name </th>
												 <th> Total Hours Worked </th>

                                            </tr>
                                        </thead>
                                        <tbody>
										
										
										<?php
										if(!empty($engineerdata)) { ?>
										<?php $i=1; foreach($engineerdata as $engineer_data)   {?>
											<tr class="odd gradeX">
												<td><?php echo $i;?></td>
												
												<!-- <td><?php //if(!empty($engineer_data->project_id)) echo $engineer_data->project_id; else echo 'NA';?></td> -->
												<td><?php echo $engineer_data->project_name;?></td>
												<!--<td><?php //echo $engineer_data->username;?></td>-->
												<td>

                                                    <?php foreach ($engineer_data->subtaskdata as $value) 
                                                    {
                                                        if(!empty($value->subtask_name)) {
                                                        echo $value->subtask_name.', ';
                                                    } }?>                                    
                                                </td>
												<td><?php echo $engineer_data->cost_center_code;?></td>
												<td><?php echo $engineer_data->cost_center_name;?></td>
												
									<?php if(!empty($engineer_data->projectdata->total_hours)) { ?>
								  <td><?php echo round($engineer_data->projectdata->total_hours,2);?> </td>
												<?php } else { ?>
												 <td>0 </td>
												
												
												<?php } ?>
												
											</tr>
				
				
				
										<?php $i++; } }?>
										</tbody>
                                    </table>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
       
        <!-- end page container -->
		
		
	
						
						
						
						
<script>

function getproductid(id){

	
	$("#subtask_id").val(id);
	
}
</script>

<script type="text/javascript" language="javascript">
 
		$(document).ready(function(){
		$("#subtask_submit").click(function(e){
		e.preventDefault();
		var subtask_id= $("#subtask_id").val();
		
			
		 
		$.ajax({
		type: "POST",
		url: '<?php echo base_url();?>pmanager/Subtasks/delete',
		data: {subtask_id:subtask_id},
		success:function(data)
		{
		if(data == "1")
		{
		
		     window.location.href = "<?php echo base_url(); ?>pmanager/Subtasks/manage";
			 
		}
		else {
		
		   
		}
		},
		error:function()
		{
		//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
		}
		});
		
		});
		});
	
	
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	
    var config = {
        type: 'pie',
    data: {
        datasets: [{
            data: [
				<?php foreach($engineerdata as $engineer_data) { ?>
                <?php echo (int)$engineer_data->projectdata->total_hours;   ?>,
                <?php } ?>
            ],
            backgroundColor: [
                window.chartColors.red,
                window.chartColors.orange,
                window.chartColors.yellow,
                window.chartColors.green,
                window.chartColors.blue,
				window.chartColors.pink,
                window.chartColors.Purple,
                window.chartColors.yellow,
                window.chartColors.green,
                window.chartColors.blue,
				window.chartColors.red,
                window.chartColors.orange,
                window.chartColors.yellow,
                window.chartColors.green,
                window.chartColors.blue,
            ],
            label: 'Dataset 1'
        }],
        labels: [
            <?php if( ! empty($engineerdata) ): ?>
        		<?php foreach($engineerdata as $engineer_data)   { ?>
                   "<?php echo $engineer_data->project_name;?>",
        		<?php }?>
            <?php endif; ?>
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
};
    var ctx = document.getElementById("chartjs_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
	
	});

	function validateForm(){
      
      var start_date= $("#form_date").val();
      var end_date= $("#to_date").val();
      
      if(start_date == '' || end_date == '') 
      {
        $("#endErr").html("From date Or End date should not be blank.");
        return false;
      }
      else{
        $("#endErr").html("");
      }
      
      if(start_date != '' && end_date != '') 
      {
         if(Date.parse(end_date) < Date.parse(start_date)){
          $("#endErr").html("End date should be greater than Start date.");
          return false;
          } else {
          $("#endErr").html("");
          }
      }
      
    }
</script>						