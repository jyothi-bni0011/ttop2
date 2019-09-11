<!-- start page content -->

		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?php echo $title;?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active"><?php echo $title;?></li>

                            </ol>

                        </div>

                    </div>

                    <div><?php echo $this->session->flashdata('message');?></div>

                    <div class="row">

                    	<div class="col-md-12">

                    		<div class="card  card-box">

                    			<div class="card-body ">

                    				<a href="<?php echo base_url('assign_project/create');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Assign Project </button></a>

                                    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'filter_assign_projects', 'method' => 'POST', 'autocomplete' => "off"); 
//                                        echo form_open('assign_project', $attributes);
                                    ?>
                                    <br />

                                    <?php if(!empty($assign_permission)){  ?>
<!--                                    <div class="form-group row"> 
                                      <label class="control-label col-md-3">Assign Project To </label>
                                      <div class="col-md-5">
                                            <?php 
                                                $options['']  = 'Select Option';
                                                
                                                foreach($assign_permission as $role){
                                                    $options[$role->role_id] = $role->role_name;
                                                }
                                                
                                                
                                                $css = array(
                                                        'id'       => 'assign_to',
                                                        'class'    => 'form-control input-height'
                                                        
                                                );

                                                echo form_dropdown('assign_to', $options, $selected_role, $css);
                                            ?>
                                      </div>
                                    </div>


                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="offset-md-3 col-md-9">
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
                                    </div>-->

                                    <?php 
//                                        echo form_close();
                                    } ?>

                    				<div class="table-scrollable">
                    					<table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                    						<thead>
                    							<tr>
                                                    <th>Sr No</th>
                    								<th> Region</th>
                                                    <th> Site</th>
                                                    <th> Project</th>
                                                    <th> Project Type</th>
                                                    <th>Engineer / Supervisor</th>
                                                    <th>Role</th>
                                                    <th> Status</th>
                    								<th class="noExport"> Action </th> 
                                                </tr>
                                            </thead>
                                         <tbody>
                                         	<?php  $sr_no=1;foreach($assigned_projects as $rec): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $sr_no++;?></td>
                                         			<td><?= $rec->region_name;?></td>
                                                    <td><?= $rec->site_name;?></td>
                                                    <td><?= $rec->project_name;?></td>
                                                    <td><?= ucwords($rec->project_type);?></td>
                                                    <!--<td><?= $rec->project_type;?></td>-->
                                                    <td><?php $i=0;
                                                        $arr = explode(",", $rec->username);
                                                        echo "<ul class='ul_class'>";
                                                            foreach($arr as $uname){ $i++;
                                                                echo "<li>".$uname."</li>";
                                                            }
                                                        echo "</ul>";
                                                        ?>
                                                    </td>
                                                    <td><?php 
                                                        $rolearr = explode(",", $rec->roles);
                                                        echo "<ul class='ul_class'>";
                                                            //foreach($rolearr as $role){
                                                            $j=0;
                                                            foreach($arr as $id){   
                                                                echo "<li>".$rolearr[$j]."</li>";
                                                                $j++;
                                                            }
                                                        echo "</ul>";
                                                        ?></td>
                                                    <td><?php 
                                                        $status_arr = explode(",", $rec->status);
                                                        echo "<ul class='ul_class'>";
                                                            //foreach($status_arr as $statusrow){
                                                            $k=0;
                                                            foreach($arr as $id){ 
                                                                if($status_arr[$k] == 0) $status = 'Pending';
                                                                else if($status_arr[$k] == 1) $status = 'Approved';
                                                                else if($status_arr[$k] == 2) $status = 'Approved';
                                                                else if($status_arr[$k] == 3) $status = 'Rejected';
                                                                
                                                                echo "<li>".$status."</li>";
                                                                $k++;
                                                            }
                                                        echo "</ul>";
                                                        ?></td>
                                                    <td>
                                                        <?php $arr_ids = explode(",", $rec->ids);
                                                        foreach($arr_ids as $id){
                                                        
                                                        ?>
                                                            <ul class="action-buttons">
                                                                <li>
                                                                    <a href="<?php echo base_url('assign_project/update/index/').$id;?>" class="btn btn-success btn-tbl-edit btn-xs" data-toggle="tooltip" title="Edit Assigned Project">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                               
                                                                <button class="btn btn-tbl-delete btn-circle del_assign_project" data-assign_project_id="<?php echo $id; ?>" data-toggle="tooltip" title="Delete Assigned Project">
                                                                    <i class="fa fa-trash-o "></i>
                                                                </button>
                                                                
                                                                </li>
                                                        </ul>

                                                        <?php } ?> 

                                                    </td>
                                         			
                                         		</tr>
                                         	<?php  endforeach; $sr_no=1;?>

                                         </tbody>
                                     </table>

                                 </div>

                             </div>

                         </div>

                     </div>

                 </div>

             

         <!-- end page container -->


         <div class="modal fade" id="delete_assign_project" tabindex="-1" role="dialog">
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
                                    'class'            => 'btn btn-danger assign_project_id',
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

         <script type="text/javascript" >

         	$(document).ready(function(){


         		$('.del_assign_project').on('click', function(){
         			var id = $(this).attr('data-assign_project_id');
         			$('#delete_assign_project').modal('show');
                    $('.assign_project_id').attr('data-id', id);
         		});


         		$('.assign_project_id').on('click', function(){
         			
         			var id = $(this).attr('data-id');
                    //$('#delete_assign_project').modal('show');
         			$.ajax({
         				type: "POST",
                        //Async: false,
         				url: '<?php echo base_url('assign_project/Delete');?>',
         				data: {assign_project_id:id},

         				success:function(data) {
         					// console.log(data);
         					if(data.success == "1") {
                                window.location.href = "<?php echo base_url('assign_project'); ?>";
                                
         					}
         				},
         				error:function()
         				{
							//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
						}
					});
         		});      		

         	});

         </script>						