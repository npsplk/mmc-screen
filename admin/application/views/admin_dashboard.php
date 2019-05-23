<!DOCTYPE html>
<html>
    <?php $this->load->view('template/administrator_sidebar'); ?> 
    <div class="main-container side_margine">            
        <div class="container">
            <body>
                <div class="header-logo" style="">
                    <?php $this->load->view('template/header_image'); ?>
                </div>
                <div class="container" style="">
                    <nav class="navbar navbar-basic">
                        <h2>Administrator's Dashboard</h2>
                    </nav>
                </div>
                <div class="container" style="">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">CA Sri Lanka Exam - Settings</h3>
                        </div>

                        <div class="panel-body admin_dash_board">
                            <div class="row">
                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;" >
                                        <a href="<?php echo site_url("administrator/cms") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-list fa-3x"></div>
                                                <div class="icon-label">Create</div>
                                            </button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Side bar
                                            </button>  
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/users") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-user-circle-o fa-3x"></div>
                                                <div class="icon-label">
                                                    User
                                                </div>
                                            </button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Management
                                            </button>  
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/user_permissions_c") ?>">

                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-user fa-3x"></div>
                                                <div class="icon-label">
                                                    User
                                                </div>
                                            </button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Permissions
                                            </button>
                                        </a>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/user_group") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-group fa-3x"></div>
                                                <div class="icon-label">
                                                    Group
                                                </div></button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Permissions
                                            </button>  
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <hr>

                            <div class="row">

                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/Cms_permission_c") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-unlock-alt fa-3x"></div>
                                                <div class="icon-label">
                                                    Add
                                                </div></button> 
                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Permissions
                                            </button>  
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/system_configuration") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-cogs fa-3x"></div>
                                                <div class="icon-label">
                                                    System 
                                                </div></button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Configuration
                                            </button>  
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-12 dash-widget">
                                    <div class="label-danger" style="padding: 5px; border-radius: 6px;">
                                        <a href="<?php echo site_url("administrator/data_base_backup_c") ?>">
                                            <button class="btn btn-danger btn-lg btn-block" role="button" style="padding: 2px;">
                                                <div class="fa fa-download fa-3x"></div>
                                                <div class="icon-label">
                                                    Database 
                                                </div></button> 

                                            <button class="btn btn-inverse btn-block" style="height: 40px;" >
                                                Backup
                                            </button>  
                                        </a>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>

            </body>
            </html>
        </div>
    </div>
</html>
