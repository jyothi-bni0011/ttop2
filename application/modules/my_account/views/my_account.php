<!-- start page content -->
           
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">My Account</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url();?>dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">My Account</li>
                            </ol>
                        </div>
                    </div>
					<div><?php echo $this->session->flashdata('message');?></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card card-box">
                                
                                <div class="card-body" id="bar-parent">
                                    <form action="<?php echo base_url(); ?>my_account" method="post" id="form_sample_1" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                        <div class="form-group row">
                                                <label class="control-label col-md-3">First Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" name="admin_fname" id="admin_fname" data-required="1" placeholder="Enter First Name" class="form-control input-height" value="<?php echo $admindata->first_name;  ?>"/> </div>
													<span id="oldErr" style="color:#C00;" > </span>
                                            </div>
											
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">Last Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" name="admin_lname" id="admin_lname" data-required="1" placeholder="Enter Last Name" class="form-control input-height" value="<?php echo $admindata->last_name;  ?>" /> </div>
													<span id="newErr" style="color:#C00;" > </span>
                                            </div>
											
											
											 <div class="form-group row">
                                                <label class="control-label col-md-3">User Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" name="username" id="username" data-required="1" placeholder="Enter User Name" class="form-control input-height" value="<?php echo $admindata->username;  ?>" readonly> </div>
													<span id="confirmErr" style="color:#C00;" > </span>
                                            </div>
											
											
											 <div class="form-group row">
                                                <label class="control-label col-md-3">Email Id
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" name="email_id" id="email_id" data-required="1" placeholder="Enter Email Id" class="form-control input-height" value="<?php echo $admindata->email_id;  ?>" readonly> </div>
													<span id="confirmErr" style="color:#C00;" > </span>
                                            </div>
											
											 <div class="form-group row">
                                                <label class="control-label col-md-3">Profile Pic
                                                    <!--<span class="required"> * </span>-->
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="image" id="image123" data-required="1" class="form-control input-height custom-file-input" accept="image/*"/><label class="custom-file-label" for="customFile" id="file_name" style="    margin-left: 14px; margin-right: 14px;"><?php  if( !empty($admindata->profile_pic) ): echo $admindata->profile_pic; else: ?>Choose file<?php endif; ?></label> 
													<label id="extension_error" style="color: red; display: none;">Invalide file extension.</label>
													<input type="hidden" value="<?php echo $admindata->profile_pic; ?>" name="hdn_inner_banner"/>
													
													</div>
													<?php //if($admindata->profile_pic != "")   {?>
													<!--<img  class="thumbnail" src="<?php //echo base_url("uploads/profileimages/$admindata->profile_pic")?>" alt="greeting"  height="50" width="50">-->
													<?php //} ?>
                                            </div>

										
											<div class="form-actions">
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit" class="btn btn-danger">Update</button>
                                                    <button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Cancel</button>
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
		
		
<script type="text/javascript">
    $(document).ready(function(){
        $( "#form_sample_1" ).validate({
            rules: {
                admin_fname: {
                    required: true
                },
                admin_lname: {
                    required: true  
                },

            }
            
        });
    });
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('#file_name').html(fileName);

        var ext = $('#image123').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $('#extension_error').show();
            // alert(ext);
        }
        else
        {
            // alert();
            $('#extension_error').hide();   
        }

    });

    $('#form_sample_1').submit(function(e){
        if ( $('#extension_error').is(':visible') ) 
        {
            e.preventDefault();
        }
    });
</script>