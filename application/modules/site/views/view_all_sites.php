<!-- start page content -->



		<div class="page-bar">

			<div class="page-title-breadcrumb">

				<div class=" pull-left">

					<div class="page-title"><?= $title; ?></div>

				</div>

				<ol class="breadcrumb page-breadcrumb pull-right">

					<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="<?php echo base_url( 'dashboard' ); ?>">Home</a>&nbsp;<i class="fa fa-angle-right"></i>

					</li>
                                <li class="active">Site</li>

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
                                                <th> Site Code </th> 
                                                <th> Site Name </th>
                                                <th> Region </th>
                                                <th> Site Owner Name </th>
                                                <th> Cost Center Name </th>
                                                
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php $i=1; foreach($total_sites as $sites_data)   { ?>
                                              <tr class="odd gradeX">
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $sites_data->site_code; ?></td>
                                                <td><?php echo $sites_data->site_name;?></td>
                                                <td><?php echo $sites_data->region_name;?></td>
                                                <td><?php echo $sites_data->site_owner;?></td>
                                                <td><?php echo $sites_data->cost_center_name; ?></td>
                                                
                                              </tr>
                                              <?php $i++; }  ?>
                                            </tbody>
                                     </table>

                                 </div>

                             </div>

                         </div>

                     </div>

                 </div>

             

         <!-- end page container -->
