<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
				</div>
			</div>
			<div class="page-footer">
				<div class="page-footer-inner"> Copyright @Leica Biosystems Nussloch GmbH - 2018. Powered by 
					<a href="https://www.bluenettech.com/" target="_blank" class="makerCss">Bluenet</a>
				</div>
				<div class="scroll-to-top">
					<i class="material-icons">eject</i>
				</div>
			</div> 
		</div>

		<!-- Notification triggert -->
		<script type="text/javascript">
			$(function () {
				var role_id = "<?php echo $this->session->userdata('role_id') ?>";
				var user_id = "<?php echo $this->session->userdata('user_id') ?>";
				$( document ).ready(function() {
				    // console.log( "ready!" );
					$.ajax({
						type: "POST",
						url: '<?php echo base_url("notification/current_notifications");?>',
						data: {
							role : role_id,
							user : user_id,
						},
						success:function(data) {
							// console.log(data);
							var htm='';
							var key1=0;
							if(data.success == "1") {
								$.each( data.notifications, function( key, value ) {
								  // console.log( key1 );
								  htm += '<li><a class="show_notifications" href="<?php echo base_url('notification');?>"><span class="time">'+value.created_date+' </span><span class="details"><span class="notification-icon circle deepPink-bgcolor"><i class="fa fa-check"></i> </span>'+ value.notification+' </span></a></li>';
								  key1 = key1+1;
								});
								// console.log( htm );
								if ( key1 ) 
								{
									$('.notify').html(key1);
								}
								else
								{
									$('.notify').html('');	
								}
									// $('#notify_count').html(key1);

								$('ul #notify_list').html(htm);
							}
						},
						error:function()
						{
						//$("#signupsuccess").html("Oops! Error.  Please try again later!!!");
						}
					});
				});
			})
		</script>
		<!-- Notification end -->
		<script src="<?php echo base_url('assets/plugins/jquery-blockui/jquery.blockui.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

	    <script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker-init.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/counterup/jquery.waypoints.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/counterup/jquery.counterup.min.js'); ?>"></script>
	    <!-- <script src="<?php //echo base_url('assets/plugins/chart-js/Chart.bundle.js'); ?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>

	    <script src="<?php echo base_url('assets/plugins/chart-js/utils.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/pages/chart/chartjs/chartjs-data.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/layout.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/buttons/1.5.1/js/dataTables.buttons.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/ajax/libs/jszip/3.1.3/jszip.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/ajax/libs/pdfmake/0.1.32/pdfmake.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/ajax/libs/pdfmake/0.1.32/vfs_fonts.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/buttons/1.5.1/js/buttons.html5.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/pages/table/table_data.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/material/material.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/select2/js/select2.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/pages/select2/select2-init.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
		<script src="<?php echo base_url("assets/js/tinymce-settings.js"); ?>"></script>
		<script src="<?php echo base_url("assets/js/jquery.growl.js"); ?>"></script>

		<script src="https://terrylinooo.github.io/jquery.disableAutoFill/assets/js/jquery.disableAutoFill.min.js"></script>
		
		<!-- <script src="<?php //echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script> -->

		<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'a2plcpnl0182'})
		</script>
		<script src='https://img1.wsimg.com/tcc/tcc_l.combined.1.0.6.min.js'></script>
	</body>
</html>