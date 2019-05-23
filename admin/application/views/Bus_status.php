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
                <i class="fa fa-list-alt" aria-hidden="true"></i> Add bus_status
            </button>
            <div class="row">
                <div class="form-content-div collapse" id="form_cont">
                    <form class="form-horizontal"  id="bus_status_form" name="bus_status_form">
                        <input id="id" name="id" class="form-control input-md" type="hidden">
                        <div class="form-area">
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="status_name">Status Name</label>  
										<div class="col-md-8 validate-parent">
											<input id="status_name" name="status_name" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="status_name_si">Status Name in Sinhala</label>  
										<div class="col-md-8 validate-parent">
											<input id="status_name_si" name="status_name_si" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
								<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="status_name_ta">Status Name in Tamil</label>  
										<div class="col-md-8 validate-parent">
											<input id="status_name_ta" name="status_name_ta" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
									<div class="form-group">
										<label class="col-md-4 control-label" for="status">Active</label>  
										<div class="col-md-8 validate-parent">
											<input id="status" name="status" class="form-control input-md" type="text" maxlength="100">
										</div>
									</div> 
								</div>
							<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">	
								<div class="button-group pull-right" role="group">      
                                    <button type="button" id="btn_cancel" name="btn_cancel" class="btn btn-warning" style="display: none;"><i class="fa fa-recycle" aria-hidden="true"></i> Cancel</button>
                                    <button type="button" id="btn_save" name="btn_save" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                </div>  
							</div>
							
                            <div class="clearfix"></div>
                        
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
                                <th>Status Name</th>
                                <th>Status Name in Sinhala</th>
                                <th>Status Name in Tamil</th>
                               <!-- <th>Active</th>-->
							
							 <th>Action</th>

							</tr> 
                        </thead> 
                        <tbody> 

                        </tbody> 
                    </table>

                </div>
            </div>

       
</div>
		