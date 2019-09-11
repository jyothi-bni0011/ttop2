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

                    				<div class="table-scrollable">
                    				    <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                                            <thead>
                                              <tr>
                                                <th> S.NO </th>
                                                <th> Name </th>
                                                <th> Notification </th>
                                                <th> Date </th>
                                                <?php // if($this->session->userdata('role_id') != 4){ ?>
                                                    <th> Timesheet Request Dates </th>
                                                    <th> Status </th>
                                                <?php // } ?>

                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php //echo "<pre>"; print_r($notificationdata); exit;
                                              $i=1; foreach($notificationdata as $notification_data)   {?>
                                              <tr class="odd gradeX">
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $notification_data->from_name;?> </td>
                                                <td><?php echo $notification_data->notification;?></td>
                                                <td><?php echo date("d F Y", strtotime($notification_data->created_on));?></td>
                                                
                                                <?php // if($this->session->userdata('role_id') != 4){ ?>

                                                <td><?php 
                                                if(in_array($notification_data->request, array('timesheet', 'timesheet_edit', 'timesheet_response', 'timesheet_edit_response'))){
                                                    echo $notification_data->from_date."<br />".$notification_data->to_date ;    
                                                }
                                                
                                                ?></td>
                                                <td>

                                                    <?php if(in_array($notification_data->request, array('timesheet', 'Assign_project', 'timesheet_edit')) && ($notification_data->status == 0 || $notification_data->status == 1)){ ?>
                                                      <div class="row"> 
                                                    <button title="Approve" class="btn btn-success btn-tbl-delete btn-circle approve_record" data-request="<?php echo $notification_data->request; ?>" data-record_id="<?php echo $notification_data->notification_id; ?>">

                                                                    <i class="fa fa-check"></i>
                                                            </button>

                                                            <button title="Reject" class="btn btn-danger btn-tbl-delete btn-circle reject_record" data-request="<?php echo $notification_data->request; ?>" data-record_id="<?php echo $notification_data->notification_id; ?>">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                      </div>

                                                    <?php } else if($notification_data->status == 2){
                                                        echo "Approved";
                                                    } else if($notification_data->status == 3){
                                                        echo "Rejected";
                                                    } else{
                                                        if (strpos($notification_data->notification, 'Approved') !== false) {
                                                            echo 'Approved';
                                                        }
                                                        elseif ( strpos($notification_data->notification, 'Rejected') !== false )
                                                        {
                                                            echo 'Rejected';   
                                                        }
                                                        else
                                                        {

                                                            echo "N/A";
                                                        }
                                                    }?>
                                                    
                                                </td>
                                                <?php // } ?>


                                              </tr>
                                              <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are you sure you want to Approve this record?
                                </div>
                                <div class="modal-footer">
                                    
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="act_region_submit" class="btn btn-danger change_status" data-val='2'>Approve</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Activation Modal End -->

                    <div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    Are you sure you want to Reject this record?
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" id="site_submit" class="btn btn-danger change_status" data-val='3'>Reject</button>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <script type="text/javascript">
                        
                        $('.approve_record').on('click', function(){                    
                            var id = $(this).attr('data-record_id');
                            var request = $(this).attr('data-request');
                            $('#approve_modal').modal('show');
                            $('.change_status').attr('data-id', id);
                            $('.change_status').attr('data-req', request);
                        });

                        /////// Activate Record //////////////
                        $('.reject_record').on('click', function(){                    
                            var id = $(this).attr('data-record_id');
                            var request = $(this).attr('data-request');
                            $('#reject_modal').modal('show');
                            $('.change_status').attr('data-id', id);
                            $('.change_status').attr('data-req', request);
                        });

                        $('.change_status').on('click', function(){  

                            var id = $(this).attr('data-id');
                            var request = $(this).attr('data-req');
                            var value = $(this).attr('data-val');
                            
                            $.ajax({
                                type: "POST",
                                url: '<?php echo base_url('notification/change_status');?>',
                                data: {
                                            where : id,
                                            table : 'notification',
                                            value : value,
                                            column : 'notification_id',
                                            request : request
                                        },
                                success:function(data) {
                                    console.log(data);
                                    if(data.success == "1") {
                                        window.location.href = "<?php echo base_url('notification'); ?>";
                                    }
                                },
                                error:function()
                                {
                                    //$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
                                }
                            });
                        });

                    </script>

             

         <!-- end page container -->


        				