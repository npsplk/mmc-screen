<body class="form-page">
    <?php $this->load->view('template/administrator_sidebar'); ?> 
    <div class="main-container side_margine">            
        <div class="container">
            <?php $this->load->view('template/header_image'); ?>

            <h3 style="float: right;" class="text-center">System Configuration</h3>
            <hr>
            <div class="col-xs-12">

            </div>


            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading"><h4><strong>System Configuration</strong></h4></div>

                        <!-- List group -->
                        <ul class="list-group">

                            <li class="list-group-item">
                                Dual Authentication
                                <div class="material-switch pull-right">
                                    <input id="dual_authentication" name="config_switch" type="checkbox"/>
                                    <label for="dual_authentication" class="label-danger"></label>
                                </div>
                            </li>
                            <li class="list-group-item disabled">
                                not assign
                                <div class="material-switch pull-right">
                                    <input id="someSwitchOptionInfo" name="config_switch" type="checkbox"/>
                                    <label for="someSwitchOptionInfo" class="label-info"></label>
                                </div>
                            </li>
                            <li class="list-group-item disabled">
                                not assign
                                <div class="material-switch pull-right">
                                    <input id="someSwitchOptionWarning" name="config_switch" type="checkbox"/>
                                    <label for="someSwitchOptionWarning" class="label-warning"></label>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="alert form-alertbox" role="alert" style="display: none;">

                    </div>
                </div>
            </div>


        </div>

</body>