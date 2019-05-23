<script>

    jQuery(document).ready(function ($) {
//        dropdown messages-menu open

//        jQuery('#messages').click(function () {
//            jQuery('.messages-menu').each(function () {
//                jQuery(this).toggleClass('open');
//            });
//        });
//        jQuery('#notifications').click(function () {
//            jQuery('.notifications-menu').each(function () {
//                jQuery(this).toggleClass('open');
//            });
//        });
//        jQuery('#task').click(function () {
//                    jQuery('.tasks-menu').each(function () {
//                        jQuery(this).toggleClass('open');
//                    });
//                });
//
//    
        jQuery('#reset_pass').click(function () {

            checkPasswordMatch();
        });
        function checkPasswordMatch() {
            var password = jQuery("#password_f").val();
            var confirmPassword = jQuery("#password_reenter").val();
            if (password == '' && confirmPassword == '') {
                jQuery("#CheckPasswordMatch").html("Password's cannot be empty!.");
            } else {
                if (password != confirmPassword) {
                    jQuery("#CheckPasswordMatch").html("Passwords do not match!");
                } else {
                    jQuery("#CheckPasswordMatch").html("Passwords match.");
                    var param = {};
                    param.password = password;
                    param.confirmPassword = confirmPassword;
                    jQuery.post(site_url + '/User_dashboard/reset_user_password', param, function (response) {
                        if (response.status == '1') {
                            jQuery("#password_f").val('');
                            jQuery("#password_reenter").val('');
                            jQuery("#CheckPasswordMatch").html("Password changed successfully!.");
                            setTimeout(function () {
                                jQuery('#myModal').modal('hide');
                            }, 2000);

                        }
                    }, 'json');
                }

            }
        }

        jQuery('#myModal').on('hidden.bs.modal', function (e) {
            jQuery("#password_f").val('');
            jQuery("#password_reenter").val('');
            jQuery("#CheckPasswordMatch").html('');
        });
    });

</script>
