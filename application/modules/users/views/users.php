<!-- start page content -->
    <style type="text/css">
        td{
            display: table-cell !important;
        }
        ul, ol{
            margin: 0;
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

                    				<a href="<?php echo base_url('users/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create New User </button></a>
                                                <a href="<?php echo base_url('users/create/upload'); ?>">
                                                    <button type="button" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Upload Bulk Data </button>
                                                </a>

                                    <?php if($come_from == 'user'){ ?>
                                    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'filter_users', 'method' => 'POST', 'autocomplete' => "off"); 
                                        echo form_open('users', $attributes);
                                    ?>
                                    <br /> 

                                    
                                    <div class="form-group row">
                                      <label class="control-label col-md-3">Search For </label>

                                      <div class="col-md-5">
                                        <?php 
                                            $options_role['']  = 'Select Option';
                                            foreach($roles as $role){
                                                $options_role[$role->{ROLE_ID}]  = $role->{ROLE_NAME};
                                            }
                                            
                                            $css = array(
                                                    'id'       => 'role_id',
                                                    'class'    => 'form-control input-height'
                                            );

                                            echo form_dropdown('search_role', $options_role, $selected_role, $css);
                                        ?>
                                        
                                      </div>
                                       <div class="col-md-2">
                                            <?php 
                                                    $data = array(
                                                            'class'            => 'btn btn-danger',
                                                            'type'          => 'submit',
                                                            'content'       => 'Search'
                                                    );

                                                    echo form_button($data);                                             
                                                ?>
                                       </div>
                                      
                                    </div>

                                 
                                    <?php 
                                        echo form_close();
                                    ?>
                                    <?php }?>
                                    <!--come_from = dashboard (comming from dashboard)
                                    come_from = user (users page)  -->
                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                                                    <th>Emp ID</th>
                                                    <?php if($come_from == 'user'){ ?>
                                                        <th style="width: 30%;"> Role  </th>
                                                    <?php } ?>
                                                    <th> Username </th>
                                                    <th> Email ID    </th>
                                                    <?php if($come_from == 'dashboard'){ ?>
                                                        <th> Region </th>
                                                    <?php } else { ?>
                    								    <th> Site  </th>
                                                    <?php } ?>
                                                    <th> Status </th>
                                                    <th> Log History </th>
                                                    <th> Action  </th> 
                                             </tr>
                                         </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($users as $user): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++; ?></td>
                                                    <td><?php echo $user->{EMPLOYEE_ID}; ?></td>
                                                    <?php if($come_from == 'user'){ ?>
                                                    <td style="width: 25%;">
                                                        <?php $arr = explode(",", $user->roles);
                                                        echo "<ul class='ul_class'>";
                                                            foreach($arr as $rname){
                                                                echo "<li style='height:auto;'>".$rname."</li>";
                                                            }
                                                        echo "</ul>";
                                                        ?>
                                                    </td>
                                                    <?php } ?>
                                                    <td><?php echo $user->{USERNAME}; ?></td>
                                                    <td><?php echo $user->{USER_EMAIL}; ?></td>
                                                    <?php if($come_from == 'dashboard'){ ?>
                                                        <td> <?php 
                                                        $arr_reg = explode(",", $user->regions);
                                                        echo "<ul class='ul_class'>";
                                                            foreach($arr_reg as $rname){
                                                                echo "<li>".$rname."</li>";
                                                            }
                                                        echo "</ul>";
                                                        ?> </td>
                                                    <?php }else{ ?>
                                                        <td>
                                                        <?php 
                                                        $arr = explode(",", $user->sites);
                                                        echo "<ul class='ul_class'>";
                                                            foreach($arr as $sname){
                                                                echo "<li>".$sname."</li>";
                                                            }
                                                        echo "</ul>";
                                                        ?>
                                                    </td>
                                                    <?php } ?>

                                         			<td><?php if($user->{STATUS} == 1){ 
                                                            echo "<span style='color:green'>Active</span>";
                                                        }else{
                                                            echo "<span style='color:red'>InActive</span>";
                                                        }?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url('admin_masters/log_history/index/').$user->{USER_ID};?>" data-toggle="tooltip" title="View Log History">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        
                                                    </td>
                                         			<td style="display: flex !important;">
                                                        <?php if($user->{STATUS} == 1): ?>
                                         				<a href="<?php echo base_url('users/update/index/').$user->{USER_ID};?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit User">
                                         					<i class="fa fa-pencil"></i>
                                         				</a>
                                     					<!-- <button class="btn btn-tbl-delete btn-circle del_user" data-user_id="<?php //echo $user->{USER_ID}; ?>" >
                                     						<i class="fa fa-trash-o "></i>
                                     					</button> -->
                                                        <button class="btn btn-danger btn-tbl-delete btn-circle deactive_record" data-record_id="<?php echo $user->{USER_ID}; ?>" data-toggle="tooltip" title="Deactivate User">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <?php if(!empty($assign_permissions) && $user->pr_supervisor_id == 0){
                                                            $rolearr = explode(",", $user->user_roles);
                                                            foreach ($rolearr as $value) {
                                                                if(in_array($value, $assign_permissions)){
                                                                    $data1 = array(
                                                                    'class'            => 'btn btn-warning btn-tbl-delete btn-circle',
                                                                    'type'          => 'button',
                                                                    'content'       => 'Assign',
                                                                    'data-toggle'   => 'modal',
                                                                    'data-target'   => '#assign_exampleModalCenter',
                                                                    'onclick'       => "assign_supervisor(".$user->user_id.")"
                                                                    );

                                                                    echo form_button($data1);
                                                                    break;
                                                                }
                                                            } 
                                                        } else if($user->pr_supervisor_id == $this->session->userdata('user_id')) { 
                                                            $data1 = array(
                                                                    'class'            => 'btn btn-tbl-delete btn-circle',
                                                                    'type'          => 'button',
                                                                    'content'       => 'UnAssign',
                                                                    'data-toggle'   => 'modal',
                                                                    'data-target'   => '#unassign_exampleModalCenter',
                                                                    'onclick'       => "unassign_supervisor(".$user->user_id.")",

                                                            );

                                                            echo form_button($data1);
                                                        } ?>
                                                        <?php else: ?>
                                                            <button class="btn btn-success btn-tbl-delete btn-circle active_record" data-record_id="<?php echo $user->{USER_ID}; ?>" data-toggle="tooltip" title="Activate User">
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

         <div class="modal fade" id="delete_user" tabindex="-1" role="dialog">
         	<div class="modal-dialog modal-dialog-centered" role="document">
         		<div class="modal-content">
         			<div class="modal-body">
         				Are you sure you want to delete this record?
         			</div>
         			<div class="modal-footer">
         				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         				<button type="button" class="btn btn-danger user_id" data-id="">Delete</button>
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

        <div class="modal fade" id="assign_exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body"> Are you sure you want to assign this user? </div>
              <div class="modal-footer">
                <form method="post">
                  <input type="hidden" name="assign_user_id" id="assign_user_id" value="">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" id="assign_user_submit" class="btn btn-success">Assign</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="unassign_exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body"> Are you sure you want to unassign this user? </div>
              <div class="modal-footer">
                <form method="post">
                  <input type="hidden" name="unassign_user_id" id="unassign_user_id" value="">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" id="unassign_user_submit" class="btn btn-danger">Unassign</button>
                </form>
              </div>
            </div>
          </div>
        </div>

         <script>

            function assign_supervisor(id){  
                $("#assign_user_id").val(id); 
            }

            function unassign_supervisor(id){ 
                $("#unassign_user_id").val(id);   
            }

            $("#assign_user_submit").click(function(e){
                e.preventDefault();
                var user_id= $("#assign_user_id").val();
                var search_for = $("#role_id").val();
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('users/assign_supervisor');?>',
                    data: {user_id:user_id, 'action':'assigned', search_for:search_for},
                    success:function(data)
                    {
                        window.location.href = "<?php echo base_url('users'); ?>";
                    },
                    error:function()
                    {
                    
                    }
                });
            });

            $("#unassign_user_submit").click(function(e){
                e.preventDefault();
                var user_id= $("#unassign_user_id").val();
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('users/assign_supervisor');?>',
                    data: {user_id:user_id, 'action':'unassigned'},
                    success:function(data)
                    {
                        window.location.href = "<?php echo base_url('users'); ?>";
                        $.redirect('<?php echo base_url('users'); ?>', {'selected_role': 'value1'});
                    },
                    error:function()
                    {
                    
                    }
                });
            
            });

         </script>



         <script type="text/javascript" >

         	$(document).ready(function(){
         		$('.del_user').on('click', function(){	
         			var id = $(this).attr('data-user_id');
         			$('#delete_user').modal('show');
         			$('.user_id').attr('data-id', id);
         		});


         		$('.user_id').on('click', function(){         			
         			var id = $(this).attr('data-id');     			
         			$.ajax({
         				type: "POST",
         				url: '<?php echo base_url('users/delete');?>',
         				data: {user_id:id},
         				success:function(data) {
         					console.log(data);
         					if(data.success == "1") {
         						window.location.href = "<?php echo base_url('users'); ?>";
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
                    url: '<?php echo base_url('users/change_status');?>',
                    data: {
                                where : id,
                                table : 'users',
                                value : value,
                                column : 'user_id'
                            },
                    success:function(data) {
                        console.log(data);
                        if(data.success == "1") {
                            window.location.href = "<?php echo base_url('users'); ?>";
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