
<body class="form-page">

    <div class="container">
        <div class="row login-top"  >
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">


            </div>

            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12  ">
                <div class="header-logo" style="">
                    <img style="" id="login-img" src="<?php echo base_url("assets/images/casl.png"); ?>" alt="CASL Student">
                </div>
                <div class="login-form-div">

                    <?php if ($this->session->flashdata('admin_login_err')) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('admin_login_message'); ?>
                        </div>
                    <?php } ?>
                    <form id="login_form_admin" role="form" method="POST" action="<?php echo site_url("administrator/admin_login/admin_login") ?>" class="form-horizontal">
                        <fieldset>
                            <legend>
                                Administrative Control Panel
                            </legend>

                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input type="text" name="ad_user_name" id="user_name" class="form-control input-lg" placeholder="User Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="password" name="ad_password" id="password" class="form-control input-lg" placeholder="Password">
                                </div>
                            </div>
<!--                            <span class="button-checkbox">
                                <button type="button" class="btn" data-color="info">Remember Me</button>
                                <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
                                <a href="" class="btn btn-link pull-right">Forgot Password?</a>
                            </span>-->
                            <div class="form-group">
                                <!--<label class="col-md-4 control-label" for="captcha"></label>-->  
                                <div class="col-md-12">
                                    <div id="login_captcha_div">
                                        <a href="#" id="refresh_captcha_admin" title="Click to refresh image" tabindex="-1"><img id="img_captcha" src="<?php echo site_url('administrator/admin_login/generateCaptcha_admin') ?>" tabindex="-1" alt="Captcha image" height="46" width="132"></a>
                                    </div>
                                    <input id="captcha" name="captcha" class="form-control input-md" type="text" autocomplete="off" placeholder="Captcha">
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="submit" class="btn btn-lg btn-success btn-block" name="admin_save" value="Sign In">
                                </div>
                                <!--                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                                    <a href="<?php //echo site_url()   ?>" class="btn btn-lg btn-primary btn-block">Go Back</a>
                                                                </div>-->
                            </div>
                        </fieldset>
                    </form>

                </div>

            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">


            </div>


        </div>




    </div>
</body>
