<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?php echo $title;?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?php echo $title;?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php $attributes = array('class' => 'form-horizontal', 'id' => 'update_period_closing', 'method' => 'POST', 'autocomplete' => "off"); 
					$hidden = array('region_id'=>$userdata->region_id);
					echo form_open('period_closing/update', $attributes, $hidden); ?>
					<div class="form-body">
						<input type="hidden" name="period_id" value="<?php echo $period_closing->period_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-3">Region
								<span class="required"> * </span>
							</label>
							 <div class="col-md-5">
			                  		<?php 
										$data = array(
											'name' => 'region_name',
											'placeholder' => 'Enter Region Name',
											'class' => 'form-control input-height',
											'value' => $userdata->region_name,
											'data-required' => "1",
											'readonly' => 'readonly'
										);
										echo form_input($data); 
									?>
	                    	  </div>

		              	</div>
						</div>
						<!--<div class="form-group row">
							<label class="control-label col-md-3">Site Name
								<span class="required"> * </span>
							</label>
							
							<div class="col-md-5">
								<?php 
									$options_st['']  = 'Select Site';
									foreach($sites as $site){
										$options_st[$site->site_id]  = $site->site_name;
									}
									$css = array(
									        'id'       => 'site_name',
									        'class'    => 'form-control input-height',
									);

									echo form_dropdown('site_name', $options_st, $period_closing->site_id, $css);
								?>
                    	  	</div>	
		                  	
						</div>-->
						<div class="form-group row">
							<label class="control-label col-md-3">Period Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'period_name',
									'placeholder' => 'Enter Period Name',
									'class' => 'form-control input-height',
									'value' => $period_closing->period_name,
									'data-required' => "1"
								);
								echo form_input($data); 
								?>

							</div>
						</div>

						<div class="form-group row">
		                  <label class="col-md-3 control-label">Start Date
		                  <span class="required"> * </span></label>
		                  <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'start_date',
								'id' =>	'start_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'value' => $period_closing->from_date,
								'readonly' => 1
							);
							echo form_input($data); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" value="" />
		                </div>

		                <div class="form-group row">
		                  <label class="col-md-3 control-label">End Date
		                  <span class="required"> * </span></label>
		                  <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">

		                    <?php 
							$data = array(
								'name' => 'end_date',
								'id' =>	'end_date',
								'placeholder' => 'Select Date',
								'class' => 'form-control',
								'size' => 16,
								'value' => $period_closing->to_date,
								'readonly' => 1
							);
							echo form_input($data); ?>

		                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span> </div>
		                  <input type="hidden" id="dtp_input2" value="" />
		                </div>
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger',
										        'type'          => 'submit',
										        'content'       => 'Update'
										);

										echo form_button($data);

										$data1 = array(
										        'class'            => 'btn btn-default',
										        'type'          => 'button',
										        'content'       => 'Cancel',
										        'onclick'		=> "javascript:window.history.go(-1);"
										);

										echo form_button($data1);
									?>
								</div>
							</div>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#update_period_closing" ).validate({
			rules: {
				period_name: {
		    		required: true
		    	},
		    	start_date: {
		    		required: true
		    	},
		    	end_date: {
		    		required: true
		    	}
			}
			
		});
	});

	$('#start_date').change(function(){
		$('.form_date_end').datetimepicker('remove');
		$('.form_date_end').datetimepicker({
		    weekStart: 1,
		    todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0,
			startDate : new Date( $(this).val() )
		});
	});
</script>