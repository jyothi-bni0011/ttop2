<!-- start page content -->
            
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Upload Projects Bulk Data</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard');?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="<?php echo base_url('project');?>">Projects</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Create Projects</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                
                                <div class="card-body" id="bar-parent">
                                    <form action="<?php echo base_url('project/project/insertexcel'); ?>" method="post" id="form_sample_1" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
										
											
								<div class="form-group row">
                                                <label class="control-label col-md-3">Upload Data
                                                    <!--<span class="required"> * </span>-->
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="userfile" id="image123" data-required="1" class="form-control input-height" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required onchange="return checkfileformat();"> 
													
									
													<span id="filetypeerr" style="color:red;"></span>
													</div>
													<!--<?php //if($subadmindata->profile_pic != "")   {?>
													<img  class="thumbnail" src="<?php //echo base_url("uploads/profileimages/$subadmindata->profile_pic")?>" alt="greeting"  height="50" width="50">
													<?php //} ?>-->
                                            </div>
											
											
                                       <input type="hidden" name="region_name" value="<?php echo $regiondata->region_name;   ?>">
                                           
											
											<div class="form-actions">
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                    <a href="<?php echo base_url('project');?>"><button type="button" class="btn btn-default">Cancel</button></a>
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
        function validationForm()
		{
			var user_number= document.getElementById('user_number').value;
 			var username= document.getElementById('username').value;
			var email_id= document.getElementById('email_id').value;
			var cost_price= document.getElementById('cost_price').value;
			var site_id= document.getElementById('site_id').value;
			var cost_center= document.getElementById('cost_center').value;
			var cost_center_name= document.getElementById('cost_center_name').value;
			var start_date= document.getElementById('start_date').value;
			var end_date= document.getElementById('end_date').value;
			
 			var eReg  = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
           
		   document.getElementById('numberErr').innerHTML = "";
		   document.getElementById('nameErr').innerHTML = "";
		   document.getElementById('emailErr').innerHTML = "";
		   document.getElementById('costErr').innerHTML = "";
		   document.getElementById('siteErr').innerHTML = "";
		   document.getElementById('costcenterErr').innerHTML = "";
		   document.getElementById('costnameErr').innerHTML = "";
		   document.getElementById('startErr').innerHTML = "";
		   document.getElementById('endErr').innerHTML = "";
           
	
            
			
			
			if(user_number =="" || user_number == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('numberErr').innerHTML = "Please Enter Supervisor Number";
            document.getElementById('user_number').focus();	
			return false;
 			}
			
			
			if(username =="" || username == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('nameErr').innerHTML = "Please Enter Name";
            document.getElementById('username').focus();	
			return false;
 			}
			
			
           if(email_id =="" || email_id == null)
			{
 			//$('#emailphErr').css('padding', '10px 0 0 12px');
            document.getElementById('emailErr').innerHTML = "Please Enter Email ID";
            document.getElementById('email_id').focus();	
			return false;
			}
			else if(!(email_id =="" || email_id == null) && !(eReg.test(email_id))) {
            $('#emailErr').css('padding', '10px 0 0 12px');
            document.getElementById('emailErr').innerHTML = "Please Enter a Valid Email ID";
            document.getElementById('email_id').focus();
            return false;
            } 
			
			
			if(cost_hour =="" || cost_hour == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('costErr').innerHTML = "Please Enter Cost Per Hour";
            document.getElementById('cost_hour').focus();	
			return false;
 			}
			
			
 			if(site_id =="" || site_id == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('siteErr').innerHTML = "Please Select Site Name";
            document.getElementById('site_id').focus();	
			return false;
 			}
			
			if(cost_center =="" || cost_center == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('costcenterErr').innerHTML = "Please Enter Cost Center";
            document.getElementById('cost_center').focus();	
			return false;
 			}
			
			
			if(cost_center_name =="" || cost_center_name == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('costnameErr').innerHTML = "Please Enter Cost Center Name";
            document.getElementById('cost_center_name').focus();	
			return false;
 			}
			
			if(start_date =="" || start_date == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('startErr').innerHTML = "Please Select Start Date";
            document.getElementById('start_date').focus();	
			return false;
 			}
			
			if(end_date =="" || end_date == null)
			{	
 			//$('#nameErr').css('padding', '10px 0 0 12px');
            document.getElementById('endErr').innerHTML = "Please Select End Date";
            document.getElementById('end_date').focus();	
			return false;
 			}

		
        }
        
        function checkfileformat()
        {
        	var extension = $("#image123").val().split('.').pop().toLowerCase();
       	 	if ($.inArray(extension, ['csv','xlsx','xls']) == '-1') 
       		{
       			 	document.getElementById('filetypeerr').innerHTML = "Invalid File Format,Please select a valid file of type (.xlsx/.xls)";
       			    document.getElementById('image123').value='';
       			 	return false;
       		}
       	 	else
       	 	{
       	 		document.getElementById('filetypeerr').innerHTML='';
       	 		return true;
       	 	}
        }
		
		
	
</script> 