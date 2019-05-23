<?php
$menu = $this->session->user_menu;
$active_dashboard = "";
if ($this->uri->segment(1) == "user_dashboard") {
    $active_dashboard = " active";
}
?>
    <div id="wrapper">
        <div class="overlay"><img id="login-img_display" src="<?php echo base_url("assets/images/casl.png"); ?>" alt="CASL Student"></div>
    
        <!-- Sidebar -->
        <!--<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">-->
            <div class="nav-side-menu navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper">
    <div class="brand">CA Sri Lanka - Exam</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">

            <li class="<?php echo $active_dashboard ?>">
                <a href="<?php echo site_url('user_dashboard') ?>">
                    <i class="fa fa-dashboard fa-lg"></i> Dashboard
                </a>
            </li>
            <?php
            if (!empty($menu)) {
                foreach ($menu as $main_item) {
                    if (!empty($main_item['sub_items'])) {
                        /// has sub menus
                        ?>
                        <li  class="panel">
                            <a href="#" data-toggle="collapse" data-target="#target-<?php echo $main_item['menu_id'] ?>"  data-parent="#menu-content"><i class="fa <?php echo $main_item['menu_icon'] ?> fa-lg"></i> <?php echo $main_item['menu_title'] ?> <span class="arrow"></span></a>
                            <ul class="sub-menu collapse" id="target-<?php echo $main_item['menu_id'] ?>">
                                <?php
                                foreach ($main_item['sub_items'] as $sub_item) {
                                    $active_menu = "";
                                    if ($this->uri->segment(1) == $sub_item['menu_path']) {
                                        $active_menu = " active";
                                    }
                                    ?>
                                    <li class="<?php echo $active_menu ?>"><a href="<?php echo site_url($sub_item['menu_path']) ?>"><?php echo $sub_item['menu_title'] ?></a></li>
                                <?php }// end sub items loop 
                                ?>
                            </ul>
                        </li>  

                        <?php
                    }// end sub item if
                    else { /// No sub menus 
                        if (strlen($main_item['menu_path']) > 1) {
                            $active_menu = "";
                            if ($this->uri->segment(1) == $main_item['menu_path']) {
                                $active_menu = " active";
                            }
                            ?>
                            <li class="<?php echo $active_menu ?>">
                                <a href="<?php echo site_url($main_item['menu_path']) ?>"> <i class="fa <?php echo $main_item['menu_icon'] ?> fa-lg"></i> <?php echo $main_item['menu_title'] ?> </a>
                            </li> 
                            <?php
                        }
                    }
                }// end main items loop
            }// end $menu if
            ?>                                                        
            <li>
                <a href="<?php echo site_url('login/user_logout') ?>"> <i class="fa fa-lock fa-lg"></i> Log out </a>
            </li>                                             

        </ul>
    </div>
</div>
        <!--</nav>-->
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
           
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

