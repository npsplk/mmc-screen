<body class="login-body">
    <div class="js"><!--this is supposed to be on the HTML element but codepen won't let me do it-->
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title">
                        <h1> Transport Schedule Management System</h1>
                        </div>
                        </div>
                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12" > 
                        <div id="login_blur" class="logindiv" >
                        
                            <div  class="login-img-div">
                                <img id="login-img" src="<?php echo base_url("assets/images/logo.jpg"); ?>" alt="CASL Student">

                            </div>
                            <?php if ($this->session->flashdata('login_err')) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert">×</a>
                                    <strong>Error!</strong> <?php echo $this->session->flashdata('login_message'); ?>
                                </div>
                            <?php } ?>

                        </div>

                        <div id="preloader" class="load-bar hidden">
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div> <br>
                            <div><strong> Please wait while we verify your account  .  .  .  .  .  .  . </strong></div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                            <div class="login-form-div" >
                                <form class="form-horizontal" id="login-form" method="POST" action="<?php echo site_url("login/user_login") ?>">
                                    <fieldset>

                                        <legend>
                                            Admin Login
                                        </legend>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <!--<label class="col-md-4 control-label" for="u_name"></label>-->  
                                            <div class="col-md-12">
                                                <input id="u_name" name="u_name" class="form-control input-md" maxlength="100" type="text" placeholder="User Name">
                                            </div>
                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <!--<label class="col-md-4 control-label" for="password"></label>-->  
                                            <div class="col-md-12">
                                                <input id="password" name="password" class="form-control input-md" type="password" placeholder="Password">
                                            </div>
                                        </div>           
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="captcha"></label>  
                                            <div class="col-md-12">
                                                <div id="login_captcha_div">
                                                    <a href="#" id="refresh_captcha" title="Click to refresh image" tabindex="-1"><img id="img_captcha" src="<?php echo site_url('login/generateCaptcha') ?>" tabindex="-1" alt="Captcha image" height="46" width="132"></a>
                                                </div>
                                                <input id="captcha" name="captcha" class="form-control input-md" type="text" autocomplete="off" placeholder="Captcha">
                                            </div>
                                        </div>           

                                        <!-- Button (Double) -->
                                        <div class="form-group">                
                                            <div class="col-md-12 butttonLG">
                                                <button type="submit" id="btn_save" name="btn_save" class="btn btn-success">Login</button>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                                <span id="path" data-value="<?php echo site_url() ?>"></span>
                            </div> 
                    </div>

                </div>

            </div>      
        </body>
