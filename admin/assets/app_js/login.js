
jQuery.noConflict();
jQuery(function () {
jQuery('#login_blur').removeClass('logindiv');

    jQuery('#loading').hide();
//    change_captcha();
    jQuery(document).on('click', '#refresh_captcha', function (event) {
        jQuery('#login-form').submit();
        event.preventDefault();
        return false;
    });
    
    jQuery(document).on('click', '#refresh_captcha_admin', function (event) {
        jQuery('#login_form_admin').submit();
        event.preventDefault();
        return false;
    });



    jQuery(document).on('click', '#btn_save', function (event) {
        jQuery('#preloader').removeClass('hidden');
        jQuery('#login_blur').addClass('logindiv');
    });


//    jQuery(document).ready(function ($) {
//
//// site preloader -- also uncomment the div in the header and the css style for #preloader
////        jQuery(window).load(function () {
//            jQuery('#preloader').fadeOut('slow', function () {
//                jQuery(this).remove();
//            });
////        });
//
//    });



});

