<!-- start page content -->

<div class="page-bar">
    <div class="page-title-breadcrumb">
        <div class=" pull-left">
            <div class="page-title"><?= $page_title; ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url('dashboard'); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li><a class="parent-item" href="<?php echo base_url('users'); ?>">Users</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Create Users</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card card-box">

            <div class="card-body" id="bar-parent">
                <form action="<?php echo base_url(); ?>users/create/insertexcel" method="post" id="form_sample_1" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-body">


                        <div class="form-group row">
                            <label class="control-label col-md-3">Upload Data
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-5">
                                <input type="file" name="userfile" id="image123" data-required="1" class="form-control input-height" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required onchange="return checkfileformat();"> 

                                <span id="filetypeerr" style="color:red;"></span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Role
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-5">
                                <select class="form-control input-height" name="user_role" id="user_role">
                                    <option value="">Select User Role </option>
                                    <?php foreach ($roles as $role): ?>

                                        <option value="<?php echo $role->{ROLE_ID}; ?>"> <?php echo $role->{ROLE_NAME}; ?> </option>

                                    <?php endforeach; ?>
                                </select> 

                            </div>
                           
                        </div>

                         <div class="form-group row">
                          <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
                          <div class="col-md-5">
                            <?php 
                                $options['']  = 'Select Region';
                                foreach((array)$regions as $region){
                                    $options[$region->reg_id] = $region->region_name;
                                }
                                $css = array(
                                        'id'       => 'region_id',
                                        'class'    => 'form-control input-height',
                                        'onchange' => 'get_sites(this.value)',
                                        
                                );
                                echo form_dropdown('region_id', $options, '', $css);
                            ?>

                          </div>
                          
                        </div>

                        <div class="form-group row">
                          <label class="control-label col-md-3">Site  <span class="required"> * </span></label>
                          <div class="col-md-5">
                            <?php 
                                $options_site['']  = 'Select Site';

                                if (!empty($site_array)) {
                                    foreach ((array) $site_array as $site_val) {
                                        $options_site[$site_val->site_id] = $site_val->site_name;
                                    }
                                }
                                
                                $css = array(
                                        'id'       => 'site_id',
                                        'class'    => 'form-control input-height',
                                );
                                echo form_dropdown('site_id', $options_site, '', $css);
                            ?>

                          </div>
                          
                        </div>

                        <input type="hidden" name="region_name" value="<?php echo $regiondata->region_name; ?>">
                        <div class="form-actions">
                            <div class="row">
                                <div class="offset-md-3 col-md-9">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                    <a href="<?php echo base_url(); ?>users"><button type="button" class="btn btn-default">Cancel</button></a>
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

    $(document).ready(function(){
        
        $( "#form_sample_1" ).validate({
            rules: {
                user_role:{
                    required: true
                },
                region_id: {
                    required: true
                },
                site_id: {
                    required: true
                },
                
            }
            
        });
    });
    

    function checkfileformat()
    {
        var extension = $("#image123").val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xlsx', 'xls']) == '-1')
        {
            document.getElementById('filetypeerr').innerHTML = "Invalid File Format,Please select a valid file of type (.xlsx/.xls)";
            document.getElementById('image123').value = '';
            return false;
        } else
        {
            document.getElementById('filetypeerr').innerHTML = '';
            return true;
        }
    }

    function get_sites(id){ 
    if(id!=''){ 

        var dataString = 'region_id='+ id ;
        $.ajax
        ({

            type: "POST",
            url: "<?php echo base_url('users/getsite');?>",
            data: dataString,
            cache: false,
            dataType: "JSON",
            success: function(data)
            { 
                var len = data.site_opt.length;
                var options_data = '<option>Select Site</option>';
                for(var i=0; i<len; i++){
                    options_data += '<option value='+data.site_opt[i].site_id+'>'+data.site_opt[i].site_name+'</option>';
                }

                $('#site_id').html(options_data);           
               
            } 
        });
    }else{
        $('#site_id').html('<option>Select Site</option>');
       
    }
}



</script> 