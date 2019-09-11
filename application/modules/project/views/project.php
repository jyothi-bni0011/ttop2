<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?php echo $title;?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>
                                <li class="active"><?php echo $title; ?></li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

                    				<a href="<?php echo base_url('project/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create New Project </button></a>

                                    <a href="<?php echo base_url('project/project/upload');?>">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Upload Bulk Data </button>
                                    </a>

                                    <br /><br />
                                    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'filter_projects', 'method' => 'POST', 'autocomplete' => "off"); 
                                        echo form_open('project', $attributes);
                                    ?>


                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                              <label class="control-label col-md-12 text-left">Project Type </label>
                                              <div class="col-md-12">
                                                    <?php 
                                                        $options['']  = 'Select Option';
                                                        $options['global']  = 'Global';
                                                        $options['region']  = 'Region';
                                                        $options['site']  = 'Site';
                                                        
                                                        $css = array(
                                                            'id'       => 'assign_to',
                                                            'class'    => 'form-control input-height'
                                                        );

                                                        echo form_dropdown('project_type', $options, $selected_type, $css);
                                                    ?>
                                              </div>
                                            </div>
                                        </div>
<!--                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label class="control-label col-md-12 text-left">Region </label>
                                                <div class="col-md-12">
                                                        <?php 
                                                            $options_reg['']  = 'Select Option';
                                                            foreach($regions as $region){
                                                                $options_reg[$region->reg_id]  = $region->region_name;
                                                            }
                                                            
                                                            $css = array(
                                                                    'id'       => 'region',
                                                                    'class'    => 'form-control input-height',
                                                                    'onchange' => 'get_sites(this.value)'
                                                            );

                                                            echo form_dropdown('region', $options_reg, $selected_region, $css);
                                                        ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group row">
                                              <label class="control-label col-md-12 text-left">Site </label>
                                              <div class="col-md-12">
                                                    <?php 
                                                        $option['']  = 'Select Option';
                                                        if(!empty($Allsites)){
                                                            foreach($Allsites as $site){
                                                                $option[$site->site_id]  = $site->site_name;
                                                            }
                                                        }
                                                        
                                                        $css = array(
                                                                'id'       => 'site',
                                                                'class'    => 'form-control input-height'
                                                        );

                                                        echo form_dropdown('site', $option, $selected_site, $css);
                                                    ?>
                                              </div>
                                            </div>
                                        </div>-->

                                        <div class="col-md-3">
                                             <div class="form-actions">
                                               
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
                                                    <th>S.No</th>
                                                    <th>SAP Number</th>
                    								<th> Project Name</th>
                                                    <th> Project Type</th>
                                                    <th> Region</th>
                                                    <?php if($come_from == 'project'){ ?>
                                                        <th> Site </th>
                                                    <?php }else {?>
                                                        <th> Supervisor </th>
                                                    <?php }?>
                                                    <th> Status</th>
                                                    <th class="noExport"> Action </th> 
                                                </tr>
                                            </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($projects as $project): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                                    <td><?php echo $project->{SAP_NO}; ?></td>
                                                    <td><?php echo $project->{PROJECT_NAME}; ?></td>
                                                    <td><?php echo ucwords($project->{PROJECT_TYPE}); ?></td>
                                                    <td><?php echo $project->{REG_NAME}; ?></td>
                                                    <?php if($come_from == 'project'){ ?>
                                                        <td><?php echo $project->{SITE_NAME}; ?></td>
                                                    <?php } else { ?>
                                                        <td><?php echo !empty($project->svname) ? $project->svname : 'N/A'; ?></td>
                                                    <?php } ?>
                                         			<td><?php echo ($project->pstatus == '1') ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>' ; ?></td>
                                                    <td>
                                                        <?php if($project->pstatus == 1): ?>
                                         				<a href="<?php echo base_url('project/update/index/').$project->{PROJECT_ID};?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Project">
                                         					<i class="fa fa-pencil"></i>
                                         				</a>
                                                        <button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php echo $project->{PROJECT_ID}; ?>" data-toggle="tooltip" title="Deactivate Project">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <?php else: ?>
                                                            <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $project->{PROJECT_ID}; ?>" data-toggle="tooltip" title="Activate Project">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                        <!-- <?php //if( $project->{PROJECT_ID} > 0 ) : ?>
                                     					<button class="btn btn-tbl-delete btn-circle del_project" data-project_id="<?php //echo $project->{PROJECT_ID}; ?>" >
                                     						<i class="fa fa-trash-o "></i>
                                     					</button>
                                                        <?php //endif; ?> -->
                                                    </td>
                                         		</tr>
                                         	<?php endforeach; ?>

                                         </tbody>
                                     </table>

                                 </div>

                             </div>

                         </div>

                     </div>

                 </div>

             

         <!-- end page container -->

         <div class="modal fade" id="delete_project" tabindex="-1" role="dialog">
         	<div class="modal-dialog modal-dialog-centered" role="document">
         		<div class="modal-content">
         			<div class="modal-body">
         				Are you sure you want to delete this record?
         			</div>
         			<div class="modal-footer">
                        <?php 
                            $data = array(
                                    'class'            => 'btn btn-secondary',
                                    'type'          => 'button',
                                    'content'       => 'Cancel',
                                    'data-dismiss' => 'modal'
                            );

                            echo form_button($data);

                            $data1 = array(
                                    'class'            => 'btn btn-danger project_id',
                                    'type'          => 'button',
                                    'content'       => 'Delete',
                                    'data-id'       => ""
                            );

                            echo form_button($data1);
                        ?>
         			</div>
         		</div>
         	</div>
         </div>

         <!-- Activation Modal -->
        <div class="modal fade" id="activation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to activate this record?
                    </div>
                    <div class="modal-footer">
                        
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="act_region_submit" class="btn btn-danger change_status" data-val='1'>Activate</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activation Modal End -->

        <div class="modal fade" id="deactivation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to deactivate this record?
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="site_submit" class="btn btn-danger change_status" data-val='2'>Deactivate</button>
                    </div>
                </div>
            </div>
        </div> 
         
        <script type="text/javascript" >

         	$(document).ready(function(){

         		$('.del_project').on('click', function(){
         			var id = $(this).attr('data-project_id');
         			$('#delete_project').modal('show');
                    $('.project_id').attr('data-id', id);
         		});


         		$('.project_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('project/Delete');?>',
         				data: {project_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('project'); ?>";
         					}
         				},
         				error:function()
         				{
							//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
						}
					});
         		});

            });

            function get_sites(reg_id){

                if(reg_id){
                    $('#site').html('<option>Select Option</option>');
                    var dataString = 'region_id='+ reg_id;
                    $.ajax
                    ({
                        type: "POST",
                        url: "<?php echo base_url('project/getsites');?>",
                        data: dataString,
                        cache: false,
                        dataType: "JSON",
                        success: function(data)
                        {
                            //alert(data.project.length);
                            var len = data.length;
                            var options_data = '<option value="">Select Option</option>';
                            for(var i=0; i<len; i++){
                                options_data += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                            }
                            
                            $('#site').html(options_data);
                        
                        } 
                    });
                }
            }

            ////////Deactive Record///////////////
            $('.deactive_record').on('click', function(){                    
                var id = $(this).attr('data-record_id');
                $('#deactivation_modal').modal('show');
                $('.change_status').attr('data-id', id);
            });

            /////// Activate Record //////////////
            $('.active_record').on('click', function(){                    
                var id = $(this).attr('data-record_id');
                $('#activation_modal').modal('show');
                $('.change_status').attr('data-id', id);
            });

            //////////Change Status///////////////////
            $('.change_status').on('click', function(){  
                var id = $(this).attr('data-id');
                var value = $(this).attr('data-val');
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('cost_center/change_status');?>',
                    data: {
                                where : id,
                                table : 'projects',
                                value : value,
                                column : 'id'
                            },
                    success:function(data) {
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('project'); ?>";
                        }
                    },
                    error:function()
                    {
                        //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
                    }
                });
            });
            //////////// Change status End /////////////////

            function hide_show_project_type(val){
                alert(val);
            }
        </script>						