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

                                    <a href="<?php echo base_url('timesheet_request/create_timesheet_request');?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i>  Create Request </button></a>

                    				<div class="table-scrollable">
                    				    <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
                                            <thead>
                                              <tr>
                                                <th> S.NO </th>
                                                <th> Request </th>
                                                <th> Reason </th>
                                                <th> Timesheet Request Dates </th>
                                                <th> Status </th>
                                                <th> Request Date </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i=1; foreach($allrequests as $notification_data)   {?>
                                              <tr class="odd gradeX">
                                                <td><?php echo $i;?></td>
                                                <td><?php echo "Timesheet";?> </td>
                                                <td><?php echo $notification_data->notification;?></td>
                                                <td>From Date : <?php echo $notification_data->from_date;?><br>To Date : <?php echo $notification_data->to_date;?></td>
                                                <td>
                                                    <?php 

                                                        switch ($notification_data->status) {
                                                            case 2:
                                                                echo 'Approved';
                                                                break;
                                                            case 3:
                                                                echo 'Rejected';
                                                                break;
                                                            default:
                                                                echo 'Pending';
                                                        }

                                                    ?>
                                                </td>
                                                <td><?php echo date("d F Y", strtotime($notification_data->created_on));?></td>
                                              


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


        				