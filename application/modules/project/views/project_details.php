<!-- start page content -->

    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Details of <?php echo $project_details->project_name; ?> Project</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard');?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i> </li>
          <li class="active">Project Details</li>
        </ol>
      </div>
    </div>
    <div><?php echo $this->session->flashdata('message');?></div>
    <div class="row">
      <div class="col-md-12">
        <div class="card  card-box">
          <div class="card-body ">
            <form method="get" action="<?php echo base_url();?>project/search_project_details/<?= $project_details->id; ?>" class="form-horizontal row">
              <div class="form-group col-md-3">
                <div class="row">
                  <label class="col-md-12 text-left control-label">From Date </label>
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input readonly="readonly" class="form-control" size="16" type="text" name="from_date" id="form_date" placeholder="Select Date" value="<?php echo date("Y-m-d", strtotime($form_date));?>" required>
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                  <input type="hidden" id="dtp_input2" />
                  <span id="startErr" style="color:#C00;" > </span> <br/>
                </div>
              </div>
              <div class="form-group col-md-3">
                <div class="row">
                  <label class="col-md-12 control-labeltext-left">To Date </label>
                  <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="d M YY">
                    <input readonly="readonly" class="form-control" size="16" type="text" name="to_date" id="to_date" placeholder="Select Date" value="<?php echo date("Y-m-d", strtotime($to_date));?>" required>
                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
                  <input type="hidden" id="dtp_input2" value="" />
                  <span id="endErr" style="color:#C00;" > </span> <br/>
                </div>
              </div>
              <input type="hidden" name="project_name" id="project_name" value="<?php echo $project_details->project_name; ?>">
			         <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
              <div class="form-group col-md-3">
                <div class="row">
                  <label class="control-label col-md-12 text-left">Engineer / Supervisor Name </label>
                  <div class="col-md-12">
                    <select class="form-control input-height" name="username" id="username">
                      <option value="">Select Engineer / Supervisor</option>
                     <?php foreach($all_engineers as $project_data)  {?>
                      <?php if($user_id == $project_data->user_id) {?>
                      <option value="<?php echo $project_data->user_id;?>" selected="selected"><?php echo $project_data->username;?></option>
                      <?php }else {?>
                      <option value="<?php echo $project_data->user_id;?>"><?php echo $project_data->username;?></option>
                      <?php }} ?>
                    </select>
                  </div>
                  <span id="siteErr" style="color:#C00;" > </span> 
                </div>
              </div>
              <div class="form-actions">
                <div class="row">
                  <div class="offset-md-3 col-md-12" style="margin-top: 14px;">
                    <button type="submit" class="btn btn-danger" onclick="return validateForm();">Search</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-box">
                  <div class="card-head">
                    <header>Active Engineers / Supervisors</header>
                  </div>
                  <div class="col-md-12">
                    <div class="card-body " id="chartjs_pie_parent">
                      <div class="row">
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
                    <th> Employee ID </th>
                    <th> Engineer / Supervisor Name </th>
                    <!--<th> Project Name </th>-->
                    <th> Subtasks </th>
                    <th> Total Hours Worked </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($projectdata)) { ?>
                  <?php $i=1; foreach($projectdata as $project_data)   {?>
                  <tr class="odd gradeX">
                    <td><?php echo $i;?></td>
                    <td><?php echo $project_data->emp_id;?></td>
                    <td><?php echo $project_data->username;?></td>
                    <!--<td><?php //echo $project_data->project_name;?></td>-->
                    <td><?php 
                        foreach ($project_data->subtaskdata as $subtasks) {
                          if ( ! empty($subtasks) ) 
                          {
                            echo $subtasks->subtask_name .', ';
                          }
                        }
                        //echo $project_data->engineerdata->subtask_ids;
                    ?></td>
                    <td>
                      <?php foreach ($project_data->engineerdata as $subtasks1) 
                      {
                        if ( !empty($subtasks1->total_hours) ) 
                        {
                          echo $subtasks1->total_hours.' Hours'.'<br>';
                        }
                        else
                        {
                          echo "0 Hours".'<br>'; 
                        }
                      }

                      ?>
                    </td>
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
            <?php $tot_hr=0; if( ! empty($projectdata) ): ?>
      				<?php foreach($projectdata as $project_data) : ?>
              <?php if( !empty($project_data->engineerdata) ) : ?>
                <?php foreach($project_data->engineerdata as $subtask) : ?>
      				    <?php $tot_hr = $tot_hr + $subtask->total_hours; ?>
                <?php endforeach; ?>   
              <?php endif; ?>
              "<?php echo $subtask->total_hours; ?>",
              <?php endforeach; ?> 
            <?php endif; ?>
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
          <?php if( ! empty($projectdata) ): ?>
        		<?php foreach($projectdata as $project_data)   { ?>
               "<?php echo $project_data->username;?>",
        		<?php } ?>
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