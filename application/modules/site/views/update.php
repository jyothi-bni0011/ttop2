<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title"><?php echo $title; ?></div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active"><?php echo $title; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php $attributes = array('class' => 'form-horizontal', 'id' => 'update_site', 'method' => 'POST', 'autocomplete' => "off"); 
				echo form_open('site/update', $attributes); ?>
					<div class="form-body">
						<input type="hidden" name="site_id" value="<?php echo $site_id; ?>">
						<div class="form-group row">
							<label class="control-label col-md-3">Region
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
									$options['']  = 'Select Region';
									foreach($regions as $region){
										$options[$region->reg_id] = $region->region_name;
									}
									$css = array(
									        'id'       => 'regions',
									        'class'    => 'form-control input-height',
									        'disabled' => true
									);
									echo form_dropdown('regions', $options, $site_reg_id, $css);
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Site Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'site_name',
									'placeholder' => 'Enter Site Name',
									'class' => 'form-control input-height',
									'readonly' => 'readonly',
									'value' => $site_name
								);
								echo form_input($data); ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Site Code
								
							</label>
							<div class="col-md-5">
								<?php 
								$data = array(
									'name' => 'site_code',
									'placeholder' => 'Enter Site Code',
									'class' => 'form-control input-height',
									'value' => $site_code
								); 

								echo form_input($data);
								?>
							</div>
						</div>
						<div class="form-group row">
		                  <label class="control-label col-md-3">Site Owner </label>
		                  <div class="col-md-5">
		                    <?php 
		                    	$data = array(
									'name' => 'site_owner',
									'placeholder' => 'Enter Site Owner Name',
									'class' => 'form-control input-height',
									'value' => $site_owner
								); 

								echo form_input($data);
		                    ?>
		                  </div>
		                </div>

		                <div class="form-group row" id="costcenterblock">
		                  <label class="control-label col-md-3">Cost Center Name </label>
		                  <div class="col-md-5">
		                    	<?php 
									$options_ccn['']  = 'Select Cost Center';
									foreach($cost_centers as $cost_center)  {
										$options_ccn[$cost_center->{CC_ID}]  = $cost_center->{CC_NAME};
									}
									
									$css = array(
									        'id'       => 'cost_center',
									        'class'    => 'form-control input-height',
									        
									);

									echo form_dropdown('cost_center', $options_ccn, $site_cc_id, $css);
								?>
		                  </div>
		              	</div>

						<div class="form-group row">
							<label class="control-label col-md-3">Timezone
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php  $timezone_identifiers = DateTimeZone::listIdentifiers();
									$options['']  = 'Select Timezone';
									foreach($timezone_identifiers as $tz){
										$options[$tz] = $tz;
									}
									$css = array(
									        'id'       => 'timezone',
									        'class'    => 'form-control input-height',
									);
									echo form_dropdown('timezone', $options, $site_timezone, $css);
								?>
							</div>
						</div> 

						<div class="form-group row">
		                  <label class="control-label col-md-3">Work Hours Per Week <span class="required"> * </span></label>
		                  <div class="col-md-5">
		                    <?php 
		                    	$data = array(
									'name' => 'workhours_per_week',
									'placeholder' => 'Enter Work Hours Per Week',
									'class' => 'form-control input-height',
									'value' => $site_hrs_week
								); 

								echo form_input($data);
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
		$( "#update_site" ).validate({
			rules: {
				regions: {
		      		required: true
		    	},
		    	site_name:{
		    		required: true
		    	},
		    	
		    	timezone:{
		    		required: true
		    	},
		    	workhours_per_week: {
		    		number: true,required: true
		    	}
			}
			
		});
	});
</script>