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
                <i class="fa fa-list-alt" aria-hidden="true"></i> Add Divisions
            </button>
            <div class="row">
                <div class="form-content-div collapse" id="form_cont">
                    <form class="form-horizontal" method="POST" id="masterdata_form" name="masterdata_form">
                        <input id="id" name="id" class="form-control input-md" type="hidden">
                        <div class="form-area">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"> 

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="division_name">Division Name<span class="required-field"> *</span></label>  
                                    <div class="col-md-8 validate-parent">
                                        <input id="division_name" name="division_name" class="form-control input-md" type="text" required="" maxlength="120">
                                    </div>
                                </div>



                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">                                
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="division_code">Division Code</label>  
                                    <div class="col-md-8 validate-parent">
                                        <input id="division_code" name="division_code" class="form-control input-md" type="text" maxlength="100">
                                    </div>
                                </div>                              

                                <!-- Button (Double) -->
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
            <?php
//  print_r($u_groups);
            ?>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <table class="table table-hover" id="masterdata_table"> 
                        <thead> 
                            <tr> 
                                <th>Division Name</th> 
                                <th>Division Code</th> 
                                <th>Last Updated On</th> 
                                <th>Actions</th> 
                            </tr> 
                        </thead> 
                        <tbody> 

                        </tbody> 
                    </table>

                </div>
            </div>

        </div>
        <!--    </div>
        
        </body>-->

