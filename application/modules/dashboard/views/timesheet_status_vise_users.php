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
                                                    <th>Sr No</th>
                                                    <th>Employee ID</th>
                    								<th> Employee Name </th>
                    								<!-- <th> First Name  </th>
                                                    <th> Last Name   </th> -->
                                                    <th> Email ID    </th> 
                                                    
                                                     
                                             </tr>
                                         </thead>
                                         <tbody>
                                         	<?php $i=1; foreach($users as $user): ?>

                                         		<tr class="odd gradeX">
                                                    <td><?= $i++; ?></td>
                                                    <td><?php echo $user->{EMPLOYEE_ID}; ?></td>
                                                    <td><?php echo $user->full_name; ?></td>
                                         			<!-- <td><?php //echo $user->{USER_FIRST_NAME}; ?></td>
                                         			<td><?php //echo $user->{USER_LAST_NAME}; ?></td> -->
                                                    <td><?php echo $user->email_id; ?></td> 
                                         			
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


