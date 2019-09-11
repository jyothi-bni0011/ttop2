<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?= $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
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
					
						<!-- <div class="form-group row">
                            <label class="col-md-1 control-label">Date
                                <span class="required">  </span>
                            </label>
                            <div class="input-group date form_date col-md-3" data-date="" data-date-format="yyyy-dd-mm" data-link-field="dtp_input1">
                                 <input class="form-control" size="16" type="text" id="start_date" >
                                 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" name="start_date"/>
                        </div> -->

					            <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20" style="width: 100%">
						            <thead>
							           <tr>
                          <th>Sr No</th>
                          <th> User </th>
								          <th width="25%"> Action </th>
								          <th> Description </th>
                          <th> Date & Time</th>
                                 
                         </tr>
                        </thead>
                        <tbody>
                     	    <?php $i=1; foreach($log_history as $log): ?>
                     		   <tr class="odd gradeX">
                            <td><?= $i++;?></td>
                     			  <td><?php echo $log->full_name; ?></td>
                     			  <td><?php echo $log->log_event; ?></td>
                            <td><?php echo $log->log_event_description; ?></td>
                            <td><?php echo $log->log_date; ?></td>
                                
                     		   </tr>
                     	    <?php endforeach; ?>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	
	$('#start_date').change(function(){
		
		var date = $('#dtp_input1').val();

		$.ajax({
        type: "POST",
        url: '<?php echo base_url('admin_masters/log_history/log_by_date');?>',
        data: { 
                date : date
              },
        success:function(data) {
          console.log(data);
          

            $('#tableExport').DataTable().destroy();
            
            $('#tableExport').html( data.result );

            $('#tableExport').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );

         
        },
        error:function()
        {
        }
      });

	});

</script>