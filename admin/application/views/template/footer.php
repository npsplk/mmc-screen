<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.12.4.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-1.11.4/jquery-ui.min.js"); ?>"></script>
<!--<script type="text/javascript" src="<?php //echo base_url("assets/js/jquery.cookie.js");           ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
<?php
if (!empty($scripts) && is_array($scripts)) {
    foreach ($scripts as $script) {
        ?>                
        <script type="text/javascript" src="<?php echo base_url($script); ?>"></script>
        <?php
    }
}
if (!empty($scriptview) && is_array($scriptview)) {
    foreach ($scriptview as $script_name) {
        $this->load->view('scripts/' . $script_name);
    }
}
?>
<script>

    jq = jQuery.noConflict();
    jq(document).ready(function () {
        jq('ul#menu-content > li.panel > ul> li.active').parent('ul.sub-menu').collapse('show');
    });
jq(document).ready(function () {
  var trigger = jq('.hamburger'),
      overlay = jq('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  jq('[data-toggle="offcanvas"]').click(function () {
        jq('#wrapper').toggleClass('toggled');
  });  
});
</script>
<?php if (empty($remove_footer)) { ?>
    <footer class="footer container clear-top">
        <p class="text-center">
            Copyright © <?php echo date("Y"); ?> MMC. All Rights Reserved.
            Designed and Developed by <a href="http://proconsinfotech.com" target="_blank"> Procons Infotech</a>
        </p>
    </footer>        
<?php } ?>
</div>
</body>
</html>
