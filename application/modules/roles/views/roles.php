<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?php echo $title; ?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active"><?php echo $title; ?></li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

                    				<a href="<?php echo base_url('roles/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create New Role </button></a>

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                    								<th width="25%"> Role </th>
                    								<th> Role Description  </th>
                                                 
                                                 <th class="noExport"> Action </th> 
                                             </tr>
                                         </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($roles as $role): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++;?></td>
                                         			<td><?php echo $role->{ROLE_NAME}; ?></td>
                                         			<td><?php echo $role->{ROLE_DESCRIPTION}; ?></td>
                                         			<td>
                                                        <?php if( $role->{STATUS} == 1 ) : ?>
                                             				<a href="<?php echo base_url('roles/update/index/').$role->{ROLE_ID};?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Role">
                                             					<i class="fa fa-pencil"></i>
                                             				</a>
                                                            
                                                            <a href="<?php echo base_url('admin_masters/module_permission/update_module_permissions/').$role->{ROLE_ID};?>" class="btn btn-warning btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Permissions">
                                                                <i class="fa fa-key"></i>
                                                            </a>
                                                            <?php if( $role->{ROLE_ID} > 7 ) : ?>
                                                            <!--<button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php echo $role->{ROLE_ID}; ?>" data-toggle="tooltip" title="Deactivate Role">
                                                                <i class="fa fa-times"></i>
                                                            </button>-->
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $role->{ROLE_ID}; ?>" data-toggle="tooltip" title="Activate Role">
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

         <div class="modal fade" id="delete_role" tabindex="-1" role="dialog">
         	<div class="modal-dialog modal-dialog-centered" role="document">
         		<div class="modal-content">
         			<div class="modal-body">
         				Are you sure you want to delete this record?
         			</div>
         			<div class="modal-footer">
         				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         				<button type="button" class="btn btn-danger role_id" data-id="">Delete</button>
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
         		$('.del_role').on('click', function(){
         			var id = $(this).attr('data-role_id');
         			$('#delete_role').modal('show');
         			$('.role_id').attr('data-id', id);
         		});


         		$('.role_id').on('click', function(){
         			var id = $(this).attr('data-id');
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('roles/delete');?>',
         				data: {role_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('roles'); ?>";
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
                    url: '<?php echo base_url('roles/change_status');?>',
                    data: {
                                where : id,
                                table : 'role',
                                value : value,
                                column : 'role_id'
                            },
                    success:function(data) {
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('roles'); ?>";
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