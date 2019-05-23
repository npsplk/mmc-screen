<?php
$menu = $this->session->user_menu;
$active_dashboard = "";
if ($this->uri->segment(1) == "user_dashboard") {
    $active_dashboard = " active";
}
?>

<div class="nav-side-menu" id="sidebarmenu">
    <div class="brand">MMC</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">

            <li class="<?php echo $active_dashboard ?>">
                <a href="#">
                    <i class="fa fa-dashboard fa-lg"></i> Dashboard
                </a>
            </li>
			
            <li>
                <a href="<?php echo site_url('Bus_status') ?>"> <i class="fa fa-check-square-o" aria-hidden="true"></i> Status </a>
            </li>
			  <li>
                <a href="<?php echo site_url('Route') ?>"> <i class="fa fa-road" aria-hidden="true"></i> Route </a>
            </li>
			
			
             <li>
                <a href="<?php echo site_url('Shedule') ?>"> <i class="fa fa-calendar" aria-hidden="true"></i>
 Schedule </a>
            </li>
            
             <li>
                <a href="<?php echo site_url('Bus_bay_route') ?>"> <i class="fa fa-bus" aria-hidden="true"></i>
 Bay to Route </a>
            </li>
            
                                                                 
            <li>
                <a href="<?php echo site_url('login/user_logout') ?>"> <i class="fa fa-lock fa-lg"></i> Log out </a>
            </li>                                             

        </ul>
    </div>
</div>
