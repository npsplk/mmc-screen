
<?php
$user_emp = $this->session->userdata('employee');
$login_user = $this->session->userdata('username');
?>
<div class="row border-bot">
<div class="col-md-8 col-xs-12">
    <div class="header-logo " id="internal">
        <!--<img id="login-img" src="<?php // echo base_url("assets/images/sllrdc_large.jpg"); ?>" alt="logo">-->
    </div>

</div>

<div class="col-md-4 col-xs-12"> 
    <div class="page-title">
        <?php 
        $display_user='';
        if (!empty($user_emp->name_short)) {
            $display_user=$user_emp->name_short;
        }else{
            $display_user=$login_user;
        }
        ?>
        <h3 class="loged-name"><span class="pull-right"> <?php echo $display_user?> </span></h3>
    </div>  

</div>
</div>