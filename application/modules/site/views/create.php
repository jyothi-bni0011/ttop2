<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bar">
	<div class="page-title-breadcrumb">
		<div class=" pull-left">
			<div class="page-title">Create Site</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right">
			<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
			</li>
			<li class="active">Sites</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<?php if(!empty($message)) echo $message; ?>
		<div><?php echo $this->session->flashdata('message');?></div>
		<div class="card card-box">
			<div class="card-body" id="bar-parent">
				<?php $attributes = array('class' => 'form-horizontal', 'id' => 'create_site', 'method' => 'POST', 'autocomplete' => "off"); 
					echo form_open('site/create', $attributes);
				 ?>
				
					<div class="form-body">

						<div class="form-group row">
		                  <label class="control-label col-md-3">Region <span class="required"> * </span> </label>
		                  <div class="col-md-5">
		                    <?php 
								$options['']  = 'Select Region';
								foreach((array)$regions as $region){
									$options[$region->reg_id] = $region->region_name;
								}
								$css = array(
								        'id'       => 'region_id',
								        'class'    => 'form-control input-height',
								        
								);
								echo form_dropdown('region_id', $options, '', $css);
							?>

		                  </div>
		                  <span id="regionErr" style="color:#C00;" > </span> 
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
									'data-required' => "1",
									'value' => set_value('site_code')
								);
								echo form_input($data); ?>
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
									'value' => set_value('site_name'),
									'data-required' => "1"
								);
								echo form_input($data); ?>
							</div>
						</div>

						<div class="form-group row">
		                  <label class="control-label col-md-3">Site Owner</label>
		                  <div class="col-md-5">
		                  <?php 
							$data = array(
								'name' => 'site_owner',
								'placeholder' => 'Enter Site Owner',
								'class' => 'form-control input-height',
								'value' => set_value('site_name'),
								'data-required' => "1"
							);
							echo form_input($data); ?>
						</div>
		                  <span id="ownerErr" style="color:#C00;" > </span> 
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

									echo form_dropdown('cost_center', $options_ccn, '', $css);
								?>
		                  </div>
		              	</div>

          				<div class="form-group row">
		                  <label class="control-label col-md-3">Timezone <span class="required"> * </span> </label>
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

									echo form_dropdown('timezone', $options, '', $css);
								?>
		                  </div>
		              	</div>

		              	<div class="form-group row">
		                  <label class="control-label col-md-3">Work Hours Per Week <span class="required"> * </span></label>
		                  <div class="col-md-5">
		                    <input type="text" name="workhours_per_week" id="workhours_per_week" placeholder="Work Hours Per Week" class="form-control input-height" />
		                  </div>
						</div>
						
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<?php 
										$data = array(
										        'class'            => 'btn btn-danger',
										        'type'          => 'submit',
										        'content'       => 'Create'
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
		$( "#create_site" ).validate({
			rules: {
				region_id: {
		      		required: true
		    	},
		    	
		    	site_name: {
		      		required: true
		    	},
		    	timezone: {
		      		required: true
		    	},
		    	workhours_per_week: {
		    		number: true,required: true
		    	}
			}
			
		});

	});
</script>