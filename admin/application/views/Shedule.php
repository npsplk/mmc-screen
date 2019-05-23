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
                        <i class="fa fa-list-alt" aria-hidden="true"></i> Add shedule
                    </button>
                    <div class="row">
                        <div class="form-content-div collapse" id="form_cont">
                            <form class="form-horizontal" id="shedule_form" name="shedule_form">
                                <input id="id" name="id" class="form-control input-md" type="hidden">
                                <div class="form-area">
                                
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="week_day_id">Week Day<span class="required-field"> *</span></label>
                                        <div class="col-md-8 validate-parent">
                                            <?php
											echo form_dropdown('week_day_id" id="week_day_id" required class="form-control text-left"', $week_day_id, 0);
											?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="route_id">Route Name<span class="required-field"> *</span></label>
                                        <div class="col-md-8 validate-parent">
                                            <?php
											echo form_dropdown('route_id" id="route_id" required class="form-control text-left"', $route_id, 0);
											?>
                                        </div>
                                    </div>
                                       <div class="form-group">
                                        <label class="col-md-4 control-label" for="bus_number">Bus Number</label>
                                        <div class="col-md-8 validate-parent">
                                            <input id="bus_number" name="bus_number" class="form-control input-md" type="text" maxlength="100">
                                        </div>
                                    </div>
                                       <div class="form-group">
                                        <label class="col-md-4 control-label" for="departure_time">Departure Time</label>
                                        <div class="col-md-8 validate-parent">
                                            <input id="departure_time" name="departure_time" class="form-control input-md" type="text" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                   <div class="form-group">
                                        <label class="col-md-4 control-label" for="status_id">Status</label>
                                        <div class="col-md-8 validate-parent">
                                            <?php
											echo form_dropdown('status_id" id="status_id" required class="form-control text-left"', $status_id, 0);
											?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="remarks">Remarks</label>
                                        <div class="col-md-8 validate-parent">
                                            <input id="remarks" name="remarks" class="form-control input-md" type="text" maxlength="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="status">Enable</label>
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
                <img id="loading_animation_img" src="<?php echo base_url(" assets/images/loading.gif "); ?>" style="max-height:50px;">
            </div>
            <div class="backDrop loading_animation_content" style="display: none;"></div>
            <div class="alert form-alertbox" role="alert" style="display: none;">

            </div>
            <hr/>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                
                   <div class="col-md-3 validate-parent">
                 
                  <?php
							echo form_dropdown('type" id="type"  class="form-control text-left"', $type, 0);
							?>
                </div>
                
                <div class="col-md-2 validate-parent">
                 <?php
                            echo form_dropdown('week_number" id="week_number"  class="form-control text-left"', $week_day_id, 0);
                            ?>
                </div>
                 <div class="col-md-4 validate-parent">
                  <?php
							echo form_dropdown('route_filter" id="route_filter"  class="form-control text-left"', $route_id, 0);
							?>
                </div>
                 <div class="col-md-3 validate-parent">
                 
                  <?php
							echo form_dropdown('status_filter" id="status_filter"  class="form-control text-left"', $status_id, 0);
							?>
                </div>
                
             
                 <div class="col-md-12 " style="margin-top:10px">
                <table class="table table-hover" id="data_grid_table">
                        <thead>
                            <tr>
                                <th>Week Day</th>
                               
                                 <th>Destination </th>
                                  <th>Route</th>
                                <th>Bus Number</th>                               
                                <th>Departure Time</th>
                                <th> Type</th>
                                <th>Remarks</th>
                                <th>Status</th>
                               <!-- <th>Enable</th>-->

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
  </div>  