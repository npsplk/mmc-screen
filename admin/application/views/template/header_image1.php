
<?php
$login_user = $this->session->userdata('username');
?>
<div class="row">
<div class="col-md-8 col-xs-8">
    <div class="header-logo " id="internal">
        <img id="login-img" src="<?php echo base_url("assets/images/casl.png"); ?>" alt="CASL Student">
    </div>

</div>

<div class="pull-right"> 
    <div class="page-title">

        <h3 class="loged-name"><span class="pull-right"> <?php echo empty($login_user) ? "<em>User</em>" : 'Signed in as ' . $login_user ?> </span></h3>
    </div>  

</div>
</div>