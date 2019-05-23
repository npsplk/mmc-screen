<body class="form-page">
    <?php
    $this->load->view('template/sidebar');
    ?>
   
    <div class="main-container">          
        <div class="container">
            <div class="page-title">
                <h3><?php print_r($form_data);
                        
                           
           
                        ?></h3>
            </div>
            
            
            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#form_cont" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Add week_day
            </button>
            <div class="row">
                <div class="form-content-div collapse" id="form_cont">
                    <form class="form-horizontal"  id="week_day_form" name="week_day_form">
                        <input id="id" name="id" class="form-control input-md" type="hidden">
                        <div class="form-area">
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="day">Day</label>  
										<div class="col-md-8 validate-parent">
											<input id="day" name="day" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="created_date">Created Date</label>  
										<div class="col-md-8 validate-parent">
											<input id="created_date" name="created_date" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="last_updated">Last Updated</label>  
										<div class="col-md-8 validate-parent">
											<input id="last_updated" name="last_updated" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="updated_by">Updated By</label>  
										<div class="col-md-8 validate-parent">
											<input id="updated_by" name="updated_by" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
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
                                <th>Day</th>
                                <th>Created Date</th>
                                <th>Last Updated</th>
                                <th>Updated By</th>
                                <th>Status</th>
							
							 <th>Action</th>

							</tr> 
                        </thead> 
                        <tbody> 

                        </tbody> 
                    </table>

                </div>
            </div>

      
	
		