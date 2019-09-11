<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title">Manage Regions</div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active">Regions</li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

                    				<a href="<?php echo base_url('region/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create New Region </button></a>

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                    								<th width="25%"> Region Code</th>
                                                    <th width="25%"> Region Name</th>
                                                    <th> Status </th>
                    								<th class="noExport"> Action </th> 
                                                </tr>
                                            </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($regions as $region): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                         			<td><?php echo $region->{REG_CODE}; ?></td>
                                                    <td><?php echo $region->{REG_NAME}; ?></td>
                                                    <?php if($region->{STATUS} == 1):?>
                                                        <td style="color: green;"> Active </td>
                                                    <?php else: ?>
                                                        <td style="color: red;"> Inactive </td>
                                                    <?php endif; ?>
                                         			<td>
                                                        <?php if($region->{STATUS} == 1):?>
                                             				<a href="<?php echo base_url('region/update/index/').$region->{REG_ID};?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Region">
                                             					<i class="fa fa-pencil"></i>
                                             				</a>
                                                            <!-- <button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php //echo $region->{REG_ID}; ?>" data-toggle="tooltip" title="Deactivate Region">
                                                                <i class="fa fa-times"></i>
                                                            </button> -->
                                                        <?php else: ?>
                                                            <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $region->{REG_ID}; ?>" data-toggle="tooltip" title="Activate Region">
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



         <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         	<div class="modal-dialog modal-dialog-centered" role="document">
         		<div class="modal-content">
         			<div class="modal-body">
         				Are you sure you want to deactivate this record?
         			</div>
         			<div class="modal-footer">
         				<form method="post">
         					<input type="hidden" name="site_id" id="site_id" value="">
         					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         					<button type="submit" id="site_submit" class="btn btn-danger">Deactivate</button>
         				</form>
         			</div>
         		</div>
         	</div>
         </div>	



         <div class="modal fade" id="act_exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

         	<div class="modal-dialog modal-dialog-centered" role="document">

         		<div class="modal-content">

         			<div class="modal-body">

         				Are you sure you want to activate this record?

         			</div>

         			<div class="modal-footer">

         				<form method="post">

         					<input type="hidden" name="act_site_id" id="act_site_id" value="">

         					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

         					<button type="submit" id="act_site_submit" class="btn btn-success">Activate</button>

         				</form>

         			</div>

         		</div>

         	</div>

         </div>

         <div class="modal fade" id="delete_region" tabindex="-1" role="dialog">
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
                                    'class'            => 'btn btn-danger region_id',
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


         		$('.del_region').on('click', function(){
         			var id = $(this).attr('data-region_id');
         			$('#delete_region').modal('show');
                    $('.region_id').attr('data-id', id);
         		});


         		$('.region_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('Region/Delete');?>',
         				data: {region_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('region'); ?>";
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
                    url: '<?php echo base_url('region/change_status');?>',
                    data: {
                                where : id,
                                table : 'region',
                                value : value,
                                column : 'reg_id'
                            },
                    success:function(data) {
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('region'); ?>";
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