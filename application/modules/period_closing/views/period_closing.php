<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title">Period Closing</div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active">Period Closing</li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">
                                    <?php if(1==$this->session->userdata('role_id')){ ?>
                    				    <a href="<?php echo base_url('period_closing/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Period Close </button></a>
                                    <?php } ?>
                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                    								<th> Region Name</th>
                                                    <th> Period Name</th>
                    								<th> Start Date </th>
                                                    <th> End Date </th>
                                                    <th> Status </th>
                                                    <th> Updated Date </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($period_close as $pc): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                         			<td><?php echo $pc->region_name; ?></td>
                                                    <td><?php echo $pc->period_name; ?></td>
                                         			<td><?php echo $pc->from_date; ?></td>
                                                    <td><?php echo $pc->to_date; ?></td>
                                                    <td><?php echo ($pc->status == 1) ? '<span style="color:green;">Open</span>' : '<span style="color:red;">Closed</span>'; ?></td>
                                                    <td><?php echo !empty($pc->updated_on) ? date('Y-m-d', strtotime($pc->updated_on)) : ''; ?></td>
                                                    <td>
                                                        <?php if($pc->status == 1): 
                                                         if( 1 == $this->session->userdata('role_id') ) {   ?>
                                                        <a href="<?php echo base_url('period_closing/update/index/').$pc->period_id;?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Period Closing">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <?php } ?>
                                                        <button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php echo $pc->period_id; ?>" data-toggle="tooltip" title="Close Opened Period">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <?php else: ?>
                                                            <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $pc->period_id; ?>" data-toggle="tooltip" title="Open Closed Period">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        <?php endif; ?>
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


         <div class="modal fade" id="delete_period_closing" tabindex="-1" role="dialog">
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
                                    'class'            => 'btn btn-danger period_closing_id',
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
                        Are you sure you want to Open this Period?
                    </div>
                    <div class="modal-footer">
                        
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="act_region_submit" class="btn btn-danger change_status" data-val='1'>Open</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activation Modal End -->

        <div class="modal fade" id="deactivation_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to Close this Period?
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="site_submit" class="btn btn-danger change_status" data-val='2'>Close</button>
                    </div>
                </div>
            </div>
        </div> 

         <script type="text/javascript" >

         	$(document).ready(function(){


         		$('.del_period_closing').on('click', function(){
         			var id = $(this).attr('data-period_closing');
         			$('#delete_period_closing').modal('show');
                    $('.period_closing_id').attr('data-id', id);
         		});


         		$('.period_closing_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('period_closing/Delete');?>',
         				data: {cost_center_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('period_closing'); ?>";
         					}
         				},
         				error:function()
         				{
							//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
						}
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
                    url: '<?php echo base_url('period_closing/change_status');?>',
                    data: {
                                where : id,
                                table : 'period_closing',
                                value : value,
                                column : 'period_id'
                            },
                    success:function(data) { 
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('period_closing'); ?>";
                        }
                    },
                    error:function()
                    {
                        //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
                    }
                });
            });
            //////////// Change status End /////////////////


         		});


         </script>						