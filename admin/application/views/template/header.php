<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url("assets/favicon.ico"); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/js/jquery-ui-1.11.4/jquery-ui.min.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome-4.7.0/css/font-awesome.min.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/template.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/responsive.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css"); ?>" />
        <?php
        if (!empty($styles) && is_array($styles)) {
            foreach ($styles as $style) {
                ?>                
                <link rel="stylesheet" href="<?php echo base_url($style); ?>" />
                <?php
            }
        }
        ?>

        <meta charset="UTF-8">

        <title><?php echo $title ?></title>

        <script>
            /**
             * Site URL  http://domain/../index.php
             * append this to relative urls to avoid errors
             * @type String
             */
            var site_url = "<?php echo site_url(); ?>";
            var base_url = "<?php echo base_url(); ?>";
        </script>
    </head> 

