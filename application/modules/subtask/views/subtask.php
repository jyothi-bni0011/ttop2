<!-- start page content -->

<style type="text/css">
   ul.sub_task_manage{ 
        padding: 0px;
        display: block;
    }
    ul.sub_task_manage li{
        padding: 0px 0px;
        list-style-type: none;
        height: 41px;
        line-height: 40px;
    }
    ul.action-buttons {
        display: block;
        width: 100px;
        padding: 0px;
    }
    ul.action-buttons li {
        display: inline-block;
    }
        
</style>

		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?php echo $title; ?></div>

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

                    				<a href="<?php echo base_url('subtask/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create New Subtask </button></a>

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>S.No</th>
                                                    <th>Region</th>
                    								<th> Site</th>
                                                    <th> Project</th>
                                                    <th> Sub Task</th>
                                                    <th> SAP Number</th>
                                                    <th> Estimated Hours</th>
                                                    <th> Status</th>
                                                    <th class="noExport"> Action </th> 
                                                </tr>
                                            </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($subtasksdata as $subtask): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                                    <td><?php echo $subtask->{REG_NAME}; ?></td>
                                                    <td><?php echo $subtask->{SITE_NAME}; ?></td>

                                                    <td><?php echo $subtask->{PROJECT_NAME}; ?></td>
                                                    <td><ul class="sub_task_manage">
                                                        <?php 
                                                        for($j=0;$j<count($subtask->subtasknames);$j++)
                                                        { ?>
                                                        
                                                            <li>
                                                            <?php echo $subtask->subtasknames[$j]."<br/>";?>
                                                            </li>
                                                        <?php } ?></ul>
                                                    </td>
                                                    <td><ul class="sub_task_manage">
                                                        <?php 
                                                        for($n=0;$n<count($subtask->sap_numbers);$n++)
                                                        { ?>
                                                        
                                                            <li>
                                                            <?php echo $subtask->sap_numbers[$n]."<br/>";?>
                                                            </li>
                                                        <?php } ?></ul>
                                                    </td>
                                                    <td><ul class="sub_task_manage">
                                                        <?php 
                                                        for($k=0;$k<count($subtask->estimatedhours);$k++)
                                                        { ?>
                                                        
                                                            <li>
                                                            <?php echo $subtask->estimatedhours[$k]."<br/>";?>
                                                            </li>
                                                        <?php } ?></ul>
                                                    </td>
                                         			<td><ul class="sub_task_manage">
                                                        <?php 
                                                        for($l=0;$l<count($subtask->subtaskstatus);$l++)
                                                        {
                                                            if($subtask->subtaskstatus[$l] == 1)     
                                                            {
                                                            ?>
                                                                <li>
                                                                <?php 
                                                                echo "<span style='color:green;'>Active</span>"."<br/>";?>
                                                                </li>
                                                            <?php } else { ?>
                                                                
                                                                <li>
                                                                <?php 
                                                                echo "<span style='color:red;'>In Active</span>"."<br/>";?>
                                                                </li>
                                                            <?php }
                                                        } ?></ul>        
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        for($m=0;$m<count($subtask->subtaskstatus);$m++)
                                                        {
                                                        if($subtask->subtaskstatus[$m] == 1)     
                                                        {?>
                                                            <ul class="action-buttons">
                                                               <li>
                                         				<a href="<?php echo base_url('subtask/update/index/').$subtask->subtasksIds[$m];?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Subtask">
                                         					<i class="fa fa-pencil"></i>
                                         				</a>
                                                        </li>
                                                            <li>
                                                                <button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php echo $subtask->subtasksIds[$m]; ?>" data-toggle="tooltip" title="Deactivate Subtask">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                        <!-- <?php //if( $subtask->subtasksIds[$m] > 0 ) : ?>
                                     					<button class="btn btn-tbl-delete btn-circle del_subtask" data-subtask_id="<?php //echo $subtask->subtasksIds[$m]; ?>" >
                                     						<i class="fa fa-trash-o "></i>
                                     					</button>
                                                        <?php //endif; ?> -->
                                                        </li>
                                                            </ul>
                                                        <?php } else{ ?>
                                                            <ul class="action-buttons">
                                                               <!-- <li>
                                                        <a href="<?php //echo base_url('subtask/update/index/').$subtask->subtasksIds[$m];?>" class="btn btn-success btn-tbl-edit btn-xs">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        </li> -->
                                                            <li>
                                                                 <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $subtask->subtasksIds[$m]; ?>" data-toggle="tooltip" title="Activate Subtask">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                        <!-- <?php //if( $subtask->subtasksIds[$m] > 0 ) : ?>
                                                        <button class="btn btn-tbl-delete btn-circle del_subtask" data-subtask_id="<?php //echo $subtask->subtasksIds[$m]; ?>" >
                                                            <i class="fa fa-trash-o "></i>
                                                        </button>
                                                        <?php //endif; ?> -->
                                                        </li>
                                                            </ul>

                                                        <?php }


                                                        
                                                            
                                                        }?> 



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

         <div class="modal fade" id="delete_subtask" tabindex="-1" role="dialog">
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
                                    'class'            => 'btn btn-danger subtask_id',
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

         		$('.del_subtask').on('click', function(){
         			var id = $(this).attr('data-subtask_id');
         			$('#delete_subtask').modal('show');
                    $('.subtask_id').attr('data-id', id);
         		});


         		$('.subtask_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('subtask/Delete');?>',
         				data: {subtask_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('subtask'); ?>";
         					}
         				},
         				error:function()
         				{
							//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
						}
					});
         		});

            });

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
                    url: '<?php echo base_url('subtask/change_status');?>',
                    data: {
                                where : id,
                                table : 'subtask',
                                value : value,
                                column : 'subtask_id'
                            },
                    success:function(data) {
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('subtask'); ?>";
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