<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?= $title; ?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>
                                <li class="active">Projects</li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

         

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
							                    <tr>
							                      <th>S.No</th>
							                      <th>Project Name</th>
							<!--                       <th>Project Number</th> -->
							                      <th>Cost Center</th>
							                      <th>Cost Center Name</th>
							                      <th>Estimated Hours</th>
							                      <th>Actual Hours</th>
							                      <!--<th>Action</th>--> 
							                    </tr>
							                  </thead>
							                  <tbody>
							                    <?php if(!empty($total_projects))   {?>
							                    <?php $i=1; foreach($total_projects as $projects_data)   {
							                    	?>
							                    <tr>
							                      <td><?php echo $i;?></td>
							                      <td><a href="<?php echo base_url();?>project/project_details/<?php echo ($projects_data->id);  ?>"><?php echo $projects_data->project_name;   ?></a></td>
							                     <!--  <td><?php //echo $projects_data->project_id;   ?></td> -->
							                      <td><?php echo $projects_data->cost_center_code;   ?></td>
							                      <td><?php echo $projects_data->cost_center_name;   ?></td>
							                      <?php if(!empty($projects_data->estimated_hours))     {?>
							                      <td><?php echo $projects_data->estimated_hours;   ?> Hours</td>
							                      <?php } else { ?>
							                      <td>0 Hours</td>
							                      <?php } ?>
							                      <?php if(isset($projects_data->total_hours)) {?>
							                      <td><?php echo round($projects_data->total_hours,2);   ?> Hours</td>
							                      <?php } else { ?>
							                      <td>0 Hours</td>
							                      <?php } ?>
							                    </tr>
							                    <?php $i++;  } }?>
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
         				url: '<?php echo base_url('Project/Delete');?>',
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
                            var options_data = '<option>Select Option</option>';
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
        </script>						