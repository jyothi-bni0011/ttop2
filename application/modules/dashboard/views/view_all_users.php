<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?= $title; ?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>

                                <!--<li><a class="parent-item" href="<?php //echo base_url();?>/Sites/manage/1">HR Admin</a>&nbsp;<i class="fa fa-angle-right"></i>

                                </li> -->

                                <li class="active"><?= $title; ?></li>

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
                                                <th> S.NO </th>
                                                <th> Name </th> 
                                                <th> Email </th>
                                                <th> Status </th>
                                                
                                              </tr>
                                            </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($users as $user): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?php echo $i;?></td>
                                                    <td><a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($user->user_id).''.$get_values;  ?>"><?php echo $user->full_name; ?></a></td>
                                                    <td><?php echo $user->email_id;?></td>
                                                    <td><?php echo ($user->status == 1) ? 'Active' : 'Inactive';?></td>
                                         			
                                         		</tr>

                                         	<?php $i++; endforeach; ?>

                                         </tbody>
                                     </table>

                                 </div>

                             </div>

                         </div>

                     </div>

                 </div>

            

         <!-- end page container -->


