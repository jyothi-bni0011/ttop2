
<!-- start page content -->
            
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Create Request</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url();  ?>engineer/Timesheet/manage">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <!-- <li><a class="parent-item" href="<?php //echo base_url();?>engineer/Requests/manage">Requests</a>&nbsp;<i class="fa fa-angle-right"></i> -->
                                </li>
                                <li class="active">Create Request</li>
                            </ol>
                        </div>
                    </div>
					  <div><?php echo $this->session->flashdata('message');?></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                              
                                <div class="card-body" id="bar-parent">
                                    <form action="<?php echo base_url(); ?>timesheet_request/create_timesheet_request" method="post" id="form_sample_1" class="form-horizontal" onsubmit="return validationForm();this.js_enabled.value=1;return true;">
                                        <div class="form-body">
										
							
												<div class="form-group row">
                                                <label class="control-label col-md-3">Request
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select readonly class="form-control input-height samp" name="request" id="request">
                                                      <!--  <option value="">Select Request</option>
														 <option value="General">General</option>-->
                                                        <option value="Timesheet" selected="selected">Timesheet</option>
														
                                                        
                                                    </select>
                                                </div>
												
												<span id="requestErr" style="color:#C00;" > </span>
                                            </div>
											
											<?php
$currentWeekNumber = date('W');
//echo 'Week number:' . $currentWeekNumber;

?>
										
										<!--<div class="form-group row week" style="display:none">-->
                                        <div class="form-group row week">
                                                <label class="control-label col-md-3">Week Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select class="form-control input-height" name="week_number" id="week_number" onchange="checkRequest();">
                                                        <option value="">Select Week</option>
														  
														<?php foreach ($timesheets as $value) : ?>
														  <option value="<?= $value->timecard_id; ?>"><?= date("d F Y", strtotime($value->start_date)); ?> - <?= date("d F Y", strtotime($value->end_date)); ?> </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
												
												<span id="weekNoErr" style="color:#C00;" > </span>
                                            </div>
											<script type="text/javascript">
for(var i=0;i<document.getElementById('week_number').length;i++)
{
if(document.getElementById('week_number').options[i].value=="<?php echo $currentWeekNumber; ?>")
{
document.getElementById('week_number').options[i].selected=true
}
}     
</script>
										
										
										
										 <div class="form-group row">
												<label class="control-label col-md-3">Reason For Request
												<span class="required"> * </span>
												</label>
												<div class="col-md-5">
													<textarea name="reason" id="reason" class="form-control-textarea" placeholder="Reason For Request" rows="5"></textarea>
												</div>
												<span id="reasonErr" style="color:#C00;" > </span>
											</div>
		
											
											<div class="form-actions">
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit" class="btn btn-danger">Send</button>
                                                    <a href="<?php echo base_url('timesheet_request');?>"><button type="button" class="btn btn-default">Cancel</button></a>
                                                </div>
                                            	</div>
                                       		 </div>
										</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
            <!-- end page content -->
            <!-- start chat sidebar -->
        </div>
		
<script type="text/javascript" language="javascript">
        // function validationForm()
        // {
        //     var request= document.getElementById('request').value;
        //     var reason= document.getElementById('reason').value;
        //     var weekNo= document.getElementById('week_number').value;
            
       
        //    document.getElementById('requestErr').innerHTML = "";
        //    document.getElementById('reasonErr').innerHTML = "";
        //    document.getElementById('weekNoErr').innerHTML = "";
           
    
        //     if(request =="" || request == null)
        //     {   
        //     //$('#nameErr').css('padding', '10px 0 0 12px');
        //     document.getElementById('projectErr').innerHTML = "Please Select Request";
        //     document.getElementById('request').focus(); 
        //     return false;
        //     }
            
        //     if(weekNo =="" || weekNo == null)
        //     {
        //     document.getElementById('weekNoErr').innerHTML = "Please Select Week Number";
        //     document.getElementById('week_number').focus(); 
        //     return false;
        //     }
            
        //      if(reason =="" || reason == null)
        //     {   
        //     //$('#nameErr').css('padding', '10px 0 0 12px');
        //     document.getElementById('reasonErr').innerHTML = "Please Enter Reason";
        //     document.getElementById('reason').focus(); 
        //     return false;
        //     }
            
            
            

        
        // }


$(document).ready(function(){
    $( "#form_sample_1" ).validate({
            
            rules: {
                request: {
                    required: true
                },
                week_number: {
                    required: true
                },
                reason: {
                    required: true
                }
            }
            
        });
})        
        
    
</script> 

<script type="text/javascript">
    $(function () {
        $(".samp").change(function () {
            
            var selectedValue = $(this).val();
            //alert(selectedValue);
			if(selectedValue == "Timesheet")
			{
			$('.week').show();
			}
			else
			{
			$('.week').hide();
			}
			
			
		
        });
    });
</script>




		