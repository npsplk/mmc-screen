<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SLLRDC | Dashboard</title>

<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style>
    .backsecond {
        margin-top: 80px;
        background-color:#121212;
        border-radius: 12px;
        box-shadow: 0px 0px 1px 1px rgba(204, 204, 204, 0.30);
    }

    .btn-style{
        color: white !important;
        background-color: #800080 !important;
        border: 1px solid #800080 !important;
        border-radius: 4px;
        padding: 4px 10px;
        margin-top: 30px;
        margin-left: 5px;
        margin-bottom: 30px;
    }

    .textlb {
        margin-top: 15px;
    }

    .form-control-signup {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #fff;
        background-color: black;
        background-image: none;
        border: 1px solid #454545;
        border-radius: 4px;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }

    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: white;
        text-decoration: none;
        cursor: pointer;
    }
    a.reset_pass {
        display: block;
        text-align: right;
    }

</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php
    $current_emp = $this->session->employee->emp_id;
//    print_r($current_emp);
//    exit;
    // if ($current_emp) {
    ?>
    <?php
//    $logindefend = $this->aauth->login_defend();
    $this->load->view('template/sidebar');
    $login_user = $this->session->userdata('username');
//    if ($logindefend) {
//    }
    ?>

    <div class="main-container">            

        <a type="" class="reset_pass" data-toggle="modal" data-target="#myModal"><i class="fa fa-lock" aria-hidden="true">&nbsp;&nbsp;</i>Password Reset</a>
        <div class="wrapper">

            <header class="main-header">
                
            </header>

            <div class="content-wrapper">
               
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">


                                    <h4><?php //echo $users_count ?> </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <?php
                                $user_add = check_permissions('employee_add');
                                ?>



<!--<a href="#" class="small-box-footer"><i class="fa "></i></a>-->
                                <?php
                                if ($user_add) {
                                    ?>
                                    <a href="<?php echo base_url('/index.php/users'); ?>" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="small-box-footer"><i class="fa "></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4><?php //echo $employee_count ?>  </h4>

                                    <p></p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                                <?php
                                $emp_list = check_permissions('employee_list_page');
                                ?>
                                <?php
                                if ($emp_list) {
                                    ?>
                                    <a href="<?php //echo base_url('/index.php/Hr_employee_list'); ?>" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="small-box-footer"><i class="fa "></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h4><?php //echo $wetland ?> </h4>


                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-folder"></i>
                                </div>
                                <?php
                                $clearence = check_permissions('clearance_application_list');
                                ?>
                                <?php if ($clearence) {
                                    ?>
                                    <a href="<?php //echo base_url('/index.php/Wtlnd_clearance_application_list'); ?>" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="small-box-footer"><i class="fa "></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h4><?php //echo $security ?> </h4>


                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-folder"></i>
                                </div>
                                <?php
                                $comp = check_permissions('unauthorized_complain_view_list');
                                ?>
                                <?php
                                if ($comp) {
                                    ?>
                                    <a href="<?php //echo base_url('/index.php/sec_unauthorized_complain_list'); ?>" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="small-box-footer"><i class="fa "></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        

                          
                    </div>
                    <!-- /.row (main row) -->

                </section>
                <!-- /.content -->
            </div>

            
            <div class="control-sidebar-bg" style="margin-top: 150px;"></div>
           
            </body>


            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <div class="col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 backsecond" style="    margin-left: 150px;">
                        <div class="backcolor">
                            <span class="close" data-dismiss="modal">×</span>
                            <div class="row text-center">
                                <h2 style="color: white;">Reset password</h2>
                                <p style="color: white;">Enter your new password and verify to reset.</p>
                            </div>

                            <form name="password_reset_from">

                                <div class="col-md-12 col-sm-12 textlb">
                                    <input type="password" class="form-control-signup" id="password_f" placeholder="Password">  
                                </div>
                                <div class="col-md-12 col-sm-12 textlb">
                                    <input type="password" class="form-control-signup" id="password_reenter" placeholder="Re-enter password">  
                                </div>
                                <h3 style="color: #ffffff; margin-left: 100px;" id="CheckPasswordMatch"></h3>
                                <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                                    <button type="button" id="reset_pass" class="btn-style form-control">Reset</button>
                                </div>

                            </form>



                        </div>
                    </div>

                </div>
            </div>
            
