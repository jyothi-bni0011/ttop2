
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- start page content -->
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url(); ?>dashboard">Home</a>&nbsp;<i class="fa fa-angle-right"></i> </li>
          <li class="active">Dashboard</li>
        </ol>
        <?php $week_no = $current_week; 
        $year = $current_year; 
        $year = !empty($year) ? $year : date('Y');
        $week_no = !empty($week_no) ? $week_no : date('W');
        ?>
        <div class=" pull-left">
          <div class="page-title" style="font-size: 18px;">Dashboard - Week 
          	<input type="number" max ="<?php echo date('W');?>" min="1" title="Please Enter Week" style="font-size: 18px; width: 10%; text-align: center;" value="<?php echo $week_no;?>" id="week_no">
            <input type="number" style="width: 10%;text-align: center;" title="Please Enter Year" max="<?php echo date('Y');?>" value="<?php echo $year;?>" id="year_no">
                <?php 
                $from = date("d M", strtotime("{$year}-W{$week_no}-1"));
                $to = date("d M", strtotime("{$year}-W{$week_no}-7"));   
                $from_date = $firstweekday;
                $to_date = $lastweekday;
                $get_values = "?from_date=".$from_date."&to_date=".$to_date;
                ?>
            <label id="week_date_range" style="font-size: 16px; letter-spacing: 1px;"><?php  echo $from." - ".$to;?></label>
            <form class="dashboard-submit" action="<?php echo base_url('dashboard'); ?>" method="get">
	            <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date;?>">
	            <input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date;?>">
	            <button class="btn red btn-outline btn-circle margin-0" onclick="submit_week();">Submit</button>
            </form>
            <span style="margin-left:2%;font-size: 13px;" id="alert_message_period_close">
            <?php 
            	if(!empty($close_flag)){
            		echo "Period Close Date  ".$close_flag['end'];
            	}
            ?>
        	</span>
            </div>
        </div>
      </div>
    </div>
    <!-- start widget -->
    <div class="state-overview">
      <div class="row">
      	<?php $count_box=0; foreach ($this->session->userdata('menu') as $menu1) : ?>

      	<!-- ----------------------------------------------------------------------------------------- -->
			<?php if ( $menu1->menu_link == 'timesheet/my_timesheet' ) : ?>
				<div class="col-md-12"> 
					<div class="card  card-box">
						<div class="card-head">
				            <header>My Projects</header>
				        </div>
				        <div class="card-body " id="chartjs_line_parent">
							<div class="row">
								<?php if ( ! empty($my_projects) ) : ?>
									<?php foreach ((array)$my_projects as $proj) : ?>							        
								        <div class="col-xl-4 col-12"> 
								        	<a href="<?php echo base_url();?>dashboard/project_timesheet/<?php echo ($proj->id.''.$get_values);  ?>">
										        <div class="info-box bg-white"> 
										        	<span class="info-box-icon-engg push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
										          	<div class="info-box-content" style="margin-top: 10px;"> 
										          		<span class="info-box-text"><?= $proj->project_name; ?></span> 
										          	</div>
										        </div>
									        </a>    
									    </div>
							    	<?php endforeach; ?>
							    <?php else : ?>
							    	<div style="color: black;">
							    		Project not found for this week.
							    	</div>
						    	<?php endif; ?>
				        	</div>
		        		</div>
		        	</div>
		    	</div>       
	    	<?php endif; ?>

	    	<!-- --------------------------------------------------------------------------------------- -->
	      	<?php if ( $menu1->menu_link == 'project' OR $menu1->menu_link == 'assign_project' ) : ?>
	      		<?php if ( $count_box == 0 ) : $count_box ++; ?>
			        <div class="col-xl-4 col-md-6 col-12"> 
			        	<a href="#projects">
				          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
				            <div class="info-box-content"> <span class="info-box-text">Projects</span> <span class="info-box-number"><?php echo count($total_projects);?></span> </div>
				            <!-- /.info-box-content --> 
				          </div>
			         	</a> 
			          <!-- /.info-box --> 
			        </div> <!-- end col -->
		        <?php endif; ?>        
	    	<?php endif; ?>
	    	<!-- ------------------------------------------------------------------------------------------- -->
			<?php if ( $menu1->menu_link == 'site' ) : ?>
		        <div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="#siteGrid">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-orange"><i class="material-icons">subtitles</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Sites</span> <span class="info-box-number"><?php echo count($total_sites);?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
		         	</a> 
		          <!-- /.info-box --> 
		        </div> <!-- end col -->        
	    	<?php endif; ?>
	    	<!-- ----------------------------------------------------------------------------------------- -->
	    	<?php if ( $menu1->menu_link == 'region' ) : ?>
		        <div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="#regionGrid">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">language</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Regions</span> <span class="info-box-number"><?php echo count($total_regions);?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
		         	</a> 
		          <!-- /.info-box --> 
		        </div> <!-- end col -->        
	    	<?php endif; ?>
	    	
	    	<!-- ------------------------------------------------------------------------------------ -->
	    	<?php if ( $menu1->menu_link == 'timesheet/others_timesheet' ) : ?>
		               
	    	<div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="<?php echo base_url('dashboard/users_list_timesheet/3').''.$get_values;?>">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-success"><i class="material-icons">list_alt</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Approved Timesheets</span> <span class="info-box-number"><?php echo (!empty( $status_counts[3] )) ? $status_counts[3] : 0;?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
		         	</a>
		          <!-- /.info-box --> 
		        </div> <!-- end col -->  
		        <div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="<?php echo base_url('dashboard/users_list_timesheet/4').''.$get_values;?>">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-danger"><i class="material-icons">list_alt</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Rejected Timesheets</span> <span class="info-box-number"><?php echo (!empty( $status_counts[4] )) ? $status_counts[4] : 0;?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
			        </a>
		          <!-- /.info-box --> 
		        </div> <!-- end col -->  
		        <div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="<?php echo base_url('dashboard/users_list_timesheet/2').''.$get_values;?>">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">list_alt</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Pending Timesheets</span> <span class="info-box-number"><?php echo (!empty( $status_counts[2] )) ? $status_counts[2] : 0;?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
			        </a>
		          <!-- /.info-box --> 
		        </div> <!-- end col -->  
		        <div class="col-xl-4 col-md-6 col-12"> 
		        	<a href="<?php echo base_url('dashboard/users_list_timesheet/1').''.$get_values;?>">
			          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">list_alt</i></span>
			            <div class="info-box-content"> <span class="info-box-text">Unsubmitted Timesheets</span> <span class="info-box-number"><?php echo (!empty( $status_counts[1] )) ? $status_counts[1] : 0;?></span> </div>
			            <!-- /.info-box-content --> 
			          </div>
			        </a>
		          <!-- /.info-box --> 
		        </div> <!-- end col -->  
	    	<?php endif; ?>
	    	<!-- ------------------------------------------------------------------------------------ -->

	    	<?php if ( $menu1->menu_link == 'users' ) : ?>
		        <?php if ( ! empty($users_details) ) : ?>    
		        	<?php if ( array_key_exists(3, $users_details) ) : ?>
					    <div class="col-xl-4 col-md-6 col-12"> 
			        		<a href="#supervisorsGrid">
						          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-danger"><i class="material-icons">group</i></span>
						            <div class="info-box-content"> <span class="info-box-text">Supervisors</span> <span class="info-box-number"><?php echo (!empty( $users_details[3] )) ? count($users_details[3]) : 0;?></span> </div>
						            <!-- /.info-box-content --> 
						          </div>
					          <!-- /.info-box --> 
				    		</a>
					    </div> <!-- end col -->
					<?php endif; ?>
					<?php if ( array_key_exists(4, $users_details) ) : ?>
					    <div class="col-xl-4 col-md-6 col-12"> 
			        		<a href="#engineerGrid">
						          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">group</i></span>
						            <div class="info-box-content"> <span class="info-box-text">Engineer</span> <span class="info-box-number"><?php echo (!empty( $users_details[4] )) ? count($users_details[4]) : 0;?></span> </div>
						            <!-- /.info-box-content --> 
						          </div>
					          <!-- /.info-box --> 
				    		</a>
					    </div> <!-- end col -->
				    <?php endif; ?>
				    <?php if ( array_key_exists(2, $users_details) ) : ?>
					    <div class="col-xl-4 col-md-6 col-12"> 
			        		<a href="#adminGrid">
						          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">group</i></span>
						            <div class="info-box-content"> <span class="info-box-text">Admin</span> <span class="info-box-number"><?php echo (!empty( $users_details[2] )) ? count($users_details[2]) : 0;?></span> </div>
						            <!-- /.info-box-content --> 
						          </div>
					          <!-- /.info-box --> 
				    		</a>
					    </div> <!-- end col -->
				    <?php endif; ?>
		    	<?php endif; ?>
	    	<?php endif; ?>

    	<?php endforeach; ?>
	    	
    	<!-- ------------------------------------------------------------------------------------------- -->
    	<!-- For Finance manager -->
    	<?php if ( $this->session->userdata('role_id') == 7 ) : ?>
	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="#finance_engineer_grid">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Engineers</span> <span class="info-box-number"><?php echo count($engineer_data);?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->

	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="<?php echo base_url('dashboard/status_vise_users/1/4').''.$get_values;?>">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Submitted Timesheets</span> <span class="info-box-number"><?php echo $engineer_submited;?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->

	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="<?php echo base_url('dashboard/status_vise_users/2/4').''.$get_values;?>">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Unsubmitted Timesheets</span> <span class="info-box-number"><?php echo $engineer_unsubmited;?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->

	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="#finance_super_grid">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">group</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Supervisors</span> <span class="info-box-number"><?php echo count($supervisor_data);?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->

	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="<?php echo base_url('dashboard/status_vise_users/1/3').''.$get_values;?>">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">group</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Submitted Timesheets</span> <span class="info-box-number"><?php echo $supervisor_submited;?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->

	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="<?php echo base_url('dashboard/status_vise_users/2/3').''.$get_values;?>">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-blue"><i class="material-icons">group</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Unsubmitted Timesheets</span> <span class="info-box-number"><?php echo $supervisor_unsubmited;?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->
    	<?php endif; ?>

    	<!-- -------------------------------------------------------------------------------------------- -->

		<!-- For Supervisor -->
    	<?php if ( $this->session->userdata('role_id') == 3 ) : ?>
	        <div class="col-xl-4 col-md-6 col-12"> 
	        	<a href="#finance_engineer_grid">
		          <div class="info-box bg-white"> <span class="info-box-icon push-bottom bg-warning"><i class="material-icons">subtitles</i></span>
		            <div class="info-box-content"> <span class="info-box-text">Engineers</span> <span class="info-box-number"><?php echo count($supervisors_engineers);?></span> </div>
		            <!-- /.info-box-content --> 
		          </div>
	         	</a> 
	          <!-- /.info-box --> 
	        </div> <!-- end col -->
    	<?php endif; ?>    	

    	<!-- -------------------------------------------------------------------------------------------- -->
      </div> <!-- end row -->
    </div>
    <!-- end widget -->
    
    <?php $count_graph = 0; foreach ($this->session->userdata('menu') as $menu1) : ?>

    	<?php if ( $menu1->menu_link == 'project' ) : ?>	
		    <!-- <div class="row">
		      <div class="col-md-12">
		        <div class="card  card-box">
		          <div class="card-head">
		            <header>Active Projects</header>
		          </div>
		          <div class="card-body " id="chartjs_line_parent">
		            <div class="row">
		              <canvas id="chartjs_line1"></canvas>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div> -->
		    <!-- <div class="row">
		      <div class="col-md-12">
		        <div class="card  card-box">
		          <div class="card-head">
		            <header>Active Supervisors</header>
		          </div>
		          <div class="card-body " id="chartjs_line_parent">
		            <div class="row">
		              <canvas id="chartjs_line2"></canvas>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div> -->
		    <div class="row">
		      <div class="col-md-12">
		        <div class="card card-box">
		          <div class="card-head">
		            <header>Active Projects</header>
		          </div>
		          <div class="card-body " id="chartjs_pie_parent">
		            <div class="row">
		              <canvas id="chartjs_pie" height="120"></canvas>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
    	<?php endif; ?>

    	<?php if ( $menu1->menu_link == 'project' OR $menu1->menu_link == 'assign_project' ) : ?>
    		<?php if ( $count_graph == 0 ) : $count_graph++; ?>
			    <div class="row">
			      <div class="col-md-12">
			        <div class="card card-box">
			          <div class="card-head">
			            <header>Estimated vs. Actual Hours</header>
			          </div>
			          <div class="card-body " id="chartjs_bar_parent">
			            <div class="row">
			              <canvas id="chartjs_bar1" ></canvas>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
			<?php endif; ?>    
		<?php endif; ?>

    	<?php if ( $menu1->menu_link == 'assign_project' ) : ?>
	    	<div class="row">
		      <div class="col-md-12">
		        <div class="card card-box">
		          <div class="card-head">
		            <header>Total Project Hours</header>
		          </div>
		          <div class="card-body " id="total_hrs_pie_parent">
		            <div class="row">
		              <canvas id="total_hrs_pie" height="120"></canvas>
		            </div>
		          </div>
		        </div>
		      </div>
	    	</div>
		<?php endif; ?>	    	
    <?php endforeach; ?>
    
    <?php $count_grid=0; foreach ($this->session->userdata('menu') as $menu1) : ?>
      	<?php if ( $menu1->menu_link == 'project' OR $menu1->menu_link == 'assign_project' ) : ?>
      		<?php if ( $count_grid == 0 ) : $count_grid ++; ?>
      		<div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="projects">
	        <div class="card card-box">
	          <div class="card-head">
	            <header>Projects</header>
	          </div>
	          <div class="card-body ">
	            <div class="table-wrap">
	              <div class="table-responsive">
	                <table class="table display product-overview mb-30" id="support_table">
	                  <thead>
	                    <tr>
	                      <th>S.No</th>
	                      <th>Project Name</th>
	<!--                       <th>Project Number</th> -->
	                      <th>Cost Center</th>
	                      <th>Cost Center Name</th>
	                      <th>Estimated Hours</th>
	                      <th>Actual Hours</th>
	                      <!--<th>Action</th>--> 
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <?php if(!empty($total_projects))   {?>
	                    <?php $i=1; foreach($total_projects as $projects_data)   {
	                    	if($i<=4)  {?>
	                    <tr>
	                      <td><?php echo $i;?></td>
	                      <td>
                                   <?php if($this->session->userdata('role_id') == 2){ 
                                                                        echo $projects_data->project_name;}else{
                                                                            ?>
                                                                        
                                  <a href="<?php echo base_url();?>project/search_project_details/<?php echo ($projects_data->id.''.$get_values);  ?>"><?php echo $projects_data->project_name;   ?></a></td>
<?php }?>	                     
<!--  <td><?php //echo $projects_data->project_id;   ?></td> -->
	                      <td><?php echo $projects_data->cost_center_code;   ?></td>
	                      <td><?php echo $projects_data->cost_center_name;   ?></td>
	                      <?php if(!empty($projects_data->estimated_hours))     {?>
	                      <td><?php echo $projects_data->estimated_hours;   ?></td>
	                      <?php } else { ?>
	                      <td>0 </td>
	                      <?php } ?>
	                      <?php if(isset($projects_data->total_hours)) {?>
	                      <td><?php echo round($projects_data->total_hours,2);   ?> </td>
	                      <?php } else { ?>
	                      <td>0 </td>
	                      <?php } ?>
	                    </tr>
	                    <?php $i++; } } }?>
	                  </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	          <div class="full-width text-center m-b-20">
	          		<?php if($this->session->userdata('role_id') == 2){ ?>

						<a href="<?php echo base_url('project/index').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
						
					<?php }else{ ?>

						<a href="<?php echo base_url('project/view_all_projects').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
					<?php } ?>
				</div>
	        </div>
	      </div>
	     </div>
	     <?php endif; ?>
      	<?php endif; ?>

      	<?php if ( $menu1->menu_link == 'site' ) : ?>
      		<div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="siteGrid">
	        <div class="card card-box">
	          <div class="card-head">
	            <header>Active Sites</header>
	          </div>
	          <div class="card-body ">
	            <div class="table-wrap">
	              <div class="table-responsive">
	                <table class="table display product-overview mb-30" id="support_table">
	                  	<thead>
				          <tr>
				            <th> S.NO </th>
				            <th> Site Code </th> 
				            <th> Site Name </th>
				            <th> Region </th>
				            <th> Site Owner Name </th>
				            <th> Cost Center Name </th>
				            
				          </tr>
				        </thead>
				        <tbody>
				          <?php $i=1; foreach($total_sites as $sites_data)   {
				          	if($i<=4) { ?>
				          <tr class="odd gradeX">
				            <td><?php echo $i;?></td>
				            <td><?php echo $sites_data->site_code; ?></td>
				            <td><?php echo $sites_data->site_name;?></td>
				            <td><?php echo $sites_data->region_name;?></td>
				            <td><?php echo $sites_data->site_owner;?></td>
				            <td><?php echo $sites_data->cost_center_name; ?></td>
				            
				          </tr>
				          <?php $i++; } } ?>
				        </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	          <div class="full-width text-center m-b-20">
					<a href="<?php echo base_url('site/view_all_sites').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
				</div>
	        </div>
	      </div>
	    </div>
      	<?php endif; ?>

      	<?php if ( $menu1->menu_link == 'region' ) : ?>
      	<div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="regionGrid">
	        <div class="card card-box">
	          <div class="card-head">
	            <header>Active Regions</header>
	          </div>
	          <div class="card-body ">
	            <div class="table-wrap">
	              <div class="table-responsive">
	                <table class="table display product-overview mb-30" id="support_table">
	                  	<thead>
				          <tr>
				            <th> S.NO </th>
				            <th> Region ID </th> 
				            <th> Region Name </th>
				            
				            
				          </tr>
				        </thead>
				        <tbody>
				          <?php $i=1; foreach($total_regions as $region_data)   {
				          	if($i<=4) { ?>
				          <tr class="odd gradeX">
				            <td><?php echo $i;?></td>
				            <td><?php echo $region_data->region_code; ?></td>
				            <td><?php echo $region_data->region_name;?></td>
				            
				            
				          </tr>
				          <?php $i++; } } ?>
				        </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	          <div class="full-width text-center m-b-20">
					<a href="<?php echo base_url('region/view_all_regions').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
				</div>
	        </div>
	      </div>
	      </div>	
      	<?php endif; ?>

      	<?php if ( $menu1->menu_link == 'users' ) : ?>
      		<?php if ( ! empty($users_details) ) : ?>  
      			<?php if ( array_key_exists(3, $users_details) ) : ?>
			      	<div class="row">
			      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="supervisorsGrid">
				        <div class="card card-box">
				          <div class="card-head">
				            <header>Supervisors</header>
				          </div>
				          <div class="card-body ">
				            <div class="table-wrap">
				              <div class="table-responsive">
				                <table class="table display product-overview mb-30" id="support_table">
				                  	<thead>
							          <tr>
							            <th> S.NO </th>
							            <th> Name </th> 
							            <th> Email </th>
							            <th> Status </th>
							            
							          </tr>
							        </thead>
							        <tbody>
							          <?php $i=1; if( ! empty( $users_details[3] ) ){ foreach($users_details[3] as $users)   {
							          	if($i<=4) { ?>
							          <tr class="odd gradeX">
							            <td><?php echo $i;?></td>
							            <td>
                                                                        <?php if($this->session->userdata('role_id') == 2){ 
                                                                        echo $users->full_name;}else{
                                                                            ?>
                                                                        
                                                                        <a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($users->user_id).''.$get_values;  ?>"><?php echo $users->full_name; ?></a>
                                                                        <?php } ?>
                                                                    </td>
							            <td><?php echo $users->email_id;?></td>
							            <td><?php echo ($users->status == 1) ? 'Active' : 'Inactive';?></td>
							            
							            
							          </tr>
							          <?php $i++; } } } ?>
							        </tbody>
				                </table>
				              </div>
				            </div>
				          </div>
				          <div class="full-width text-center m-b-20">
				          		<?php if($this->session->userdata('role_id') == 2){ ?>

			          				<a href="<?php echo base_url('users/index/3').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>

			          			<?php } else { ?>

									<a href="<?php echo base_url('dashboard/view_all_users_of_role/3').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
								<?php } ?>
							</div>
				        </div>
				      </div>
				    </div>
			    <?php endif; ?>

			    <?php if ( array_key_exists(4, $users_details) ) : ?>
			      	<div class="row">
			      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="engineerGrid">
				        <div class="card card-box">
				          <div class="card-head">
				            <header>Engineers</header>
				          </div>
				          <div class="card-body ">
				            <div class="table-wrap">
				              <div class="table-responsive">
				                <table class="table display product-overview mb-30" id="support_table">
				                  	<thead>
							          <tr>
							            <th> S.NO </th>
							            <th> Name </th> 
							            <th> Email </th>
							            <th> Status </th>
							            
							          </tr>
							        </thead>
							        <tbody>
							          <?php $i=1; if( ! empty( $users_details[4] ) ){ foreach($users_details[4] as $users)   {
							          	if($i<=4) { ?>
							          <tr class="odd gradeX">
							            <td><?php echo $i;?></td>
							            <td>
                                                                        <?php if($this->session->userdata('role_id') == 2){ 
                                                                        echo $users->full_name;}else{
                                                                            ?>
                                                                        
                                                                        <a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($users->user_id).''.$get_values;  ?>"><?php echo $users->full_name; ?></a></td>
                                                                        <?php } ?>
                                                                    <td><?php echo $users->email_id;?></td>
							            <td><?php echo ($users->status == 1) ? 'Active' : 'Inactive';?></td>
							            
							            
							          </tr>
							          <?php $i++; } } } ?>
							        </tbody>
				                </table>
				              </div>
				            </div>
				          </div>
				          <div class="full-width text-center m-b-20">

				          		<?php if($this->session->userdata('role_id') == 2){ ?>

			          				<a href="<?php echo base_url('users/index/4').''.$get_values; ?>" class="btn red btn-outline btn-circle margin-0">View All</a>

			          			<?php } else { ?>

									<a href="<?php echo base_url('dashboard/view_all_users_of_role/4').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>

								<?php }?>
								
								
							</div>
				        </div>
				      </div>
				    </div>
			    <?php endif; ?>

			    <?php if ( array_key_exists(2, $users_details) ) : ?>
			      	<div class="row">
			      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="adminGrid">
				        <div class="card card-box">
				          <div class="card-head">
				            <header>Active Admins</header>
				          </div>
				          <div class="card-body ">
				            <div class="table-wrap">
				              <div class="table-responsive">
				                <table class="table display product-overview mb-30" id="support_table">
				                  	<thead>
							          <tr>
							            <th> S.NO </th>
							            <th> Name </th> 
							            <th> Email </th>
							            <th> Status </th>
							            
							          </tr>
							        </thead>
							        <tbody>
							          <?php $i=1; if( ! empty( $users_details[2] ) ){ foreach($users_details[2] as $users)   {
							          	if($i<=4) { ?>
							          <tr class="odd gradeX">
							            <td><?php echo $i;?></td>
							            <td><?php echo $users->full_name; ?></td>
							            <td><?php echo $users->email_id;?></td>
							            <td><?php echo ($users->status == 1) ? 'Active' : 'Inactive';?></td>
							            
							            
							          </tr>
							          <?php $i++; } } } ?>
							        </tbody>
				                </table>
				              </div>
				            </div>
				          </div>
				          <div class="full-width text-center m-b-20">

				          	<?php if($this->session->userdata('role_id') == 1){ ?>

			          			<a href="<?php echo base_url('users/index/2').''.$get_values; ?>" class="btn red btn-outline btn-circle margin-0">View All</a>

			          		<?php } else { ?>

								<a href="<?php echo base_url('dashboard/view_all_users_of_role/2').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>

							<?php } ?>	
							</div>
				        </div>
				      </div>
				    </div>
			    <?php endif; ?>

	      <?php endif; ?>	
      	<?php endif; ?>
	<?php endforeach; ?> 
    
    <!-- For Finance manager -->
	<?php if ( $this->session->userdata('role_id') == 7 ) : ?>
        <div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="finance_engineer_grid">
		        <div class="card card-box">
		          <div class="card-head">
		            <header>Engineers</header>
		          </div>
		          <div class="card-body ">
		            <div class="table-wrap">
		              <div class="table-responsive">
		                <table class="table display product-overview mb-30" id="support_table">
		                  	<thead>
					          <tr>
					            <th> S.NO </th>
					            <th> Name </th> 
					            <th> Email </th>
					            <th> Status </th>
					            
					          </tr>
					        </thead>
					        <tbody>
					          <?php $i=1;  foreach($engineer_data as $users)   {
					          	if($i<=4) { ?>
					          <tr class="odd gradeX">
					            <td><?php echo $i;?></td>
					            <td><a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($users->user_id).''.$get_values;  ?>"><?php echo $users->full_name; ?></a></td>
					            <td><?php echo $users->email_id;?></td>
					            <td><?php echo ($users->status == 1) ? 'Active' : 'Inactive';?></td>
					            
					            
					          </tr>
					          <?php $i++; } } ?>
					        </tbody>
		                </table>
		              </div>
		            </div>
		          </div>
		          <div class="full-width text-center m-b-20">
		          		<?php if($this->session->userdata('role_id') == 2){ ?>

		          			<a href="<?php echo base_url('users/index/2')?>" class="btn red btn-outline btn-circle margin-0">View All</a>

		          		<?php } else { ?>
							<a href="<?php echo base_url('dashboard/view_all_users_of_role/4').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>

						<?php }?>

						
					</div>
		        </div>
	      	</div>
	    </div>

	    <div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="finance_super_grid">
		        <div class="card card-box">
		          <div class="card-head">
		            <header>Supervisors</header>
		          </div>
		          <div class="card-body ">
		            <div class="table-wrap">
		              <div class="table-responsive">
		                <table class="table display product-overview mb-30" id="support_table">
		                  	<thead>
					          <tr>
					            <th> S.NO </th>
					            <th> Name </th> 
					            <th> Email </th>
					            <th> Status </th>
					            
					          </tr>
					        </thead>
					        <tbody>
					          <?php $i=1;  foreach($supervisor_data as $users1)   {
					          	if($i<=4) { ?>
					          <tr class="odd gradeX">
					            <td><?php echo $i;?></td>
					            <td><a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($users1->user_id).''.$get_values;  ?>"><?php echo $users1->full_name; ?></a></td>
					            <td><?php echo $users1->email_id;?></td>
					            <td><?php echo ($users1->status == 1) ? 'Active' : 'Inactive';?></td>
					            
					            
					          </tr>
					          <?php $i++; } } ?>
					        </tbody>
		                </table>
		              </div>
		            </div>
		          </div>
		          <div class="full-width text-center m-b-20">
						<a href="<?php echo base_url('dashboard/view_all_users_of_role/3').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
						
					</div>
		        </div>
	      	</div>
	    </div>
	<?php endif; ?>

	<!-- For Finance manager -->
	<?php if ( $this->session->userdata('role_id') == 3 ) : ?>
        <div class="row">
      		<div class="col-lg-12 col-md-12 col-sm-12 col-12" id="finance_engineer_grid">
		        <div class="card card-box">
		          <div class="card-head">
		            <header>Engineers</header>
		          </div>
		          <div class="card-body ">
		            <div class="table-wrap">
		              <div class="table-responsive">
		                <table class="table display product-overview mb-30" id="support_table">
		                  	<thead>
					          <tr>
					            <th> S.NO </th>
					            <th> Name </th> 
					            <th> Email </th>
					            <th> Status </th>
					            
					          </tr>
					        </thead>
					        <tbody>
					          <?php $i=1;  foreach($supervisors_engineers as $users)   {
					          	if($i<=4) { ?>
					          <tr class="odd gradeX">
					            <td><?php echo $i;?></td>
					            <td><a href="<?php echo base_url();?>users/search_user_project_details/<?php echo ($users->user_id).''.$get_values;  ?>"><?php echo $users->full_name; ?></a></td>
					            <td><?php echo $users->email_id;?></td>
					            <td><?php echo ($users->status == 1) ? 'Active' : 'Inactive';?></td>
					            
					            
					          </tr>
					          <?php $i++; } } ?>
					        </tbody>
		                </table>
		              </div>
		            </div>
		          </div>
		          <div class="full-width text-center m-b-20">
						<a href="<?php echo base_url('dashboard/view_all_users_of_role/4').''.$get_values;?>" class="btn red btn-outline btn-circle margin-0">View All</a>
						
					</div>
		        </div>
	      	</div>
	    </div>
	<?php endif; ?>

<!-- end page container --> 

<script>

	$("#week_no").on('change keyup paste', function() {
	    var week = $('#week_no').val();
	    var year = $('#year_no').val();
	    var d = ((week - 1) * 7);
	    var from = new Date(year, 0, d);
	    var d1 = ((week - 1) * 7);
	    var to = new Date(year, 0, d1);
	    to.setDate(to.getDate() + 6);
	    // alert(from + " " +year+'-'+(to.getMonth()+1)+'-'+to.getDate());
	    var from_date = year+'-'+(from.getMonth()+1)+'-'+from.getDate();
	    var to_date = year+'-'+(to.getMonth()+1)+'-'+to.getDate();
	    var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
	    fromdate = from.getDate()+" "+months[from.getMonth()];
	    todate = to.getDate()+" "+months[to.getMonth()];
	    $('#week_date_range').html(fromdate+' - '+todate);
	    $('#from_date').val(from_date);
	    $('#to_date').val(to_date);
	    //alert(fromdate+' - '+todate);
	});

	$("#year_no").on('change keyup paste', function() { 
	    var week = $('#week_no').val();
	    var year = $('#year_no').val();
	    
	    $.ajax({
            type: "POST",
            url: '<?php echo base_url('dashboard/getStartAndEndDate');?>',
            cache: false,
            dataType: "JSON",
            data: { week:week, year:year                                           
                    },

            success:function(data) { 
            	$('#week_date_range').html(data.week_start+' - '+data.week_end);
			    $('#from_date').val(data.weekstart);
			    $('#to_date').val(data.weekend);
            },
            
        });
	});

$(document).ready(function() {
	<?php foreach ($this->session->userdata('menu') as $menu1) : ?>
		<?php if( $menu1->menu_link == 'project' ) : ?>
			//Active Project Pie chart
			var randomScalingFactor = function() {
		        return Math.round(Math.random() * 100);
		    };

		    var config = {
		        type: 'pie',
			    data: {
			        datasets: [{
			            data: [
			        		<?php foreach($total_projects as $projects_data) : ?>
			        			<?php if(!empty($projects_data->total_hours)) : ?>
			        				"<?php echo $projects_data->total_hours; ?>",
			        			<?php endif; ?>
			        		<?php endforeach; ?>
			            ],
			            backgroundColor: [
			                window.chartColors.red,
			                window.chartColors.orange,
			                window.chartColors.yellow,
			                window.chartColors.green,
			                window.chartColors.blue,
							window.chartColors.red,
			                window.chartColors.orange,
			                window.chartColors.yellow,
			                window.chartColors.green,
			                window.chartColors.blue,
							window.chartColors.red,
			                window.chartColors.orange,
			                window.chartColors.yellow,
			                window.chartColors.green,
			                window.chartColors.blue,
			            ],
			            label: 'Dataset 1'
			        }],
			        labels: [
							<?php foreach($total_projects as $projects_data) : ?>
				    			<?php if(!empty($projects_data->total_hours)) : ?>
				    				"<?php echo $projects_data->project_name ?>",
				    			<?php endif; ?>
				    		<?php endforeach; ?>
				        ]
				    },
				    options: {
				        responsive: true
				    }
				};

		    var ctx = document.getElementById("chartjs_pie").getContext("2d");
		    window.myPie = new Chart(ctx, config);

		    //Active Project Pie chart end

		<?php endif; ?>

		<?php if( $menu1->menu_link == 'project' OR $menu1->menu_link == 'assign_project' ) : ?>
		    //Active vs. Estimated hours Bar chart
		    var color = Chart.helpers.color;
		     var barChartData = {
		         labels: [
		      		    <?php foreach($total_projects as $projects_data) : ?>
			    				"<?php echo $projects_data->project_name; ?>",
			    		<?php endforeach; ?>
		      		 ],
		         datasets: [{
		             label: 'Estimated Hours',
		             backgroundColor: color(window.chartColors.orange).alpha(0.5).rgbString(),
		             borderColor: window.chartColors.orange,
		             borderWidth: 1,
		             data: [
		                <?php foreach($total_projects as $projects_data) : ?>
		        				"<?php echo $projects_data->estimated_hours; ?>",
		        		<?php endforeach; ?>
		             ]
					 
		         }, {
		             label: 'Actual Hours',
		             backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
		             borderColor: window.chartColors.blue,
		             borderWidth: 1,
		             data: [
		                <?php foreach($total_projects as $projects_data) : ?>
		        			<?php if(!empty($projects_data->total_hours)) : ?>
		        				"<?php echo $projects_data->total_hours; ?>",
		        			<?php else :?>
		        				"0",
		        			<?php endif; ?>
		        		<?php endforeach; ?>
		             ]
		         } ]

		     };

		         var ctx = document.getElementById("chartjs_bar1").getContext("2d");
		         window.myBar = new Chart(ctx, {
		             type: 'bar',
		             data: barChartData,
		             options: {
		                 responsive: true,
		                 legend: {
		                     position: 'top',
		                 },
		                 title: {
		                     display: true,
		                     
		                 },
		                 scales: {
						    yAxes: [{
						      ticks: {
						        beginAtZero: true
						      }
						    }],
						    xAxes: [{
						      ticks: {
						        autoSkip: false
						      }
						    }]
						  }
		             }
		         });
		    //Active vs. Estimated hours Bar chart End
		<?php endif; ?>
	<?php if( $menu1->menu_link == 'assign_project' ) : ?>
		
	var config = {
        type: 'pie',
	    data: {
	        datasets: [{
	            data: [
	        		<?php foreach($total_project_hours as $projects_data) : ?>
	        			<?php if(!empty($projects_data->total_hours)) : ?>
	        				"<?php echo $projects_data->total_hours; ?>",
	        			<?php endif; ?>
	        		<?php endforeach; ?>
	            ],
	            backgroundColor: [
	                window.chartColors.red,
	                window.chartColors.orange,
	                window.chartColors.yellow,
	                window.chartColors.green,
	                window.chartColors.blue,
					window.chartColors.red,
	                window.chartColors.orange,
	                window.chartColors.yellow,
	                window.chartColors.green,
	                window.chartColors.blue,
					window.chartColors.red,
	                window.chartColors.orange,
	                window.chartColors.yellow,
	                window.chartColors.green,
	                window.chartColors.blue,
	            ],
	            label: 'Dataset 1'
	        }],
	        labels: [
					<?php foreach($total_project_hours as $projects_data) : ?>
		    			<?php if(!empty($projects_data->total_hours)) : ?>
		    				"<?php echo $projects_data->project_name ?>",
		    			<?php endif; ?>
		    		<?php endforeach; ?>
		        ]
		    },
		    options: {
		        responsive: true
		    }
		};

    var ctx = document.getElementById("total_hrs_pie").getContext("2d");
    window.myPie = new Chart(ctx, config);
    <?php endif; ?>
	<?php endforeach; ?>
}); 

</script> 
