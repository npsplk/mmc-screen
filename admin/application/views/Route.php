<body class="form-page">
    <?php
    $this->load->view('template/sidebar');
    ?>
    <div class="main-container">            
        <div class="container">
            <?php $this->load->view('template/header_image'); ?>
            <div class="page-title">
                <h3><?php echo $title ?></h3>
            </div>
            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#form_cont" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Route
            </button>
            <div class="row">
                <div class="form-content-div collapse" id="form_cont">
                    <form class="form-horizontal"  id="route_form" name="route_form">
                        <input id="id" name="id" class="form-control input-md" type="hidden">
                        <div class="form-area">
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                
                                <div class="form-group">
										<label class="col-md-4 control-label" for="route_type">Route Type</label>  
										<div class="col-md-8 validate-parent">
											 <?php
											echo form_dropdown('route_type" id="route_type" required class="form-control text-left"', $route_type, 0);
											?>
										</div>
									</div> 
                                    
                                     
									<div class="form-group">
										<label class="col-md-4 control-label" for="route">Route</label>  
										<div class="col-md-8 validate-parent">
											<input id="route" name="route" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="from_location">From Location</label>  
										<div class="col-md-8 validate-parent">
											<input id="from_location" name="from_location" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="to_location">To Location</label>  
										<div class="col-md-8 validate-parent">
											<input id="to_location" name="to_location" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="from_location_si">From Location Sinhala</label>  
										<div class="col-md-8 validate-parent">
											<input id="from_location_si" name="from_location_si" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="to_location_si">To Location Sinhala</label>  
										<div class="col-md-8 validate-parent">
											<input id="to_location_si" name="to_location_si" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="from_location_ta">From Location Tamil</label>  
										<div class="col-md-8 validate-parent">
											<input id="from_location_ta" name="from_location_ta" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="to_location_ta">To Location Tamil</label>  
										<div class="col-md-8 validate-parent">
											<input id="to_location_ta" name="to_location_ta" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<!--<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="created_date">Created Date</label>  
										<div class="col-md-8 validate-parent">
											<input id="created_date" name="created_date" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="last_updated">Last Updated</label>  
										<div class="col-md-8 validate-parent">
											<input id="last_updated" name="last_updated" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="updated_by">Updated By</label>  
										<div class="col-md-8 validate-parent">
											<input id="updated_by" name="updated_by" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="remark">Remark</label>  
										<div class="col-md-8 validate-parent">
											<input id="remark" name="remark" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>-->
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="status">Status</label>  
										<div class="col-md-8 validate-parent">
											<input id="status" name="status" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								<div class="button-group pull-right" role="group">      
                                    <button type="button" id="btn_cancel" name="btn_cancel" class="btn btn-warning" style="display: none;"><i class="fa fa-recycle" aria-hidden="true"></i> Cancel</button>
                                    <button type="button" id="btn_save" name="btn_save" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                </div>  
							</div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="loading_animation_div" style="display: none;" class="loading_animation_content">
                <img id="loading_animation_img" src="<?php echo base_url("assets/images/loading.gif"); ?>" style="max-height:50px;">
            </div>
            <div class="backDrop loading_animation_content" style="display: none;" ></div>
            <div class="alert form-alertbox" role="alert" style="display: none;">

            </div> 
            <hr/>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <table class="table table-hover" id="data_grid_table"> 
                        <thead> 
                            <tr>
                                <th>Route</th>
                                <th>Route Type</th>
                                <th>From Location</th>
                                <th>To Location</th>
                               
                                <th>Status</th>
							
							 <th>Action</th>

							</tr> 
                        </thead> 
                        <tbody> 

                        </tbody> 
                    </table>

                </div>
            </div>

        </div>
	</div>
		