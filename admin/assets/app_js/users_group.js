js = jQuery.noConflict();

js(document).ready(function () {

});

js(document).on('click', '#btn_save', function (event) {
    var group_id = js("#group_id").val();

    var perm_array = jQuery("input[type=checkbox]:checked").map(function () {
        return jQuery(this).val();
    }).get();

    if (group_id > 0) {
        swal({
            title: "Are you sure?",
            text: "You want to update the user permissions ?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            animation: "slide-from-top"
        },
                function () {
                    saveUserGroupPerms(perm_array);
                });

    } else {
        showFailedAlert("Could not save permissions. Make sure you have selected a user group & permissions");
    }
});

js(document).on('change', '#group_id', function (event) {
    getGroupPermissions();
});

js(document).on('change', "#chk_all", function (event) {
    if (js("#chk_all").prop("checked")) {
        js("input[name=chk_perm]").prop("checked", true);
    } else {
        js("input[name=chk_perm]").prop("checked", false);
    }
});


function saveUserGroupPerms(permsArray) {
    var param = {};
    param.group_id = js("#group_id").val();
    param.perms = permsArray;

    js.post('user_group/setUserGroups', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
                showSuccessAlert("user group permissions updated.");
            } else {
                showFailedAlert("permissions update failed.");
            }
        } else {
            showFailedAlert("Error, permissions update failed.");
        }
    }, 'json');
}

function selectAll() {

}


function getGroupPermissions() {
    js("input[name=chk_perm]").prop("checked", false);
    if (js("#group_id").val() > 0) {
        var param = {};
        param.group_id = js("#group_id").val();

        showWaitAlert("Loading group permissions. Please wait...");
        js.post('user_group/getUserGroupPermissions', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    js(".form-alertbox").hide();
                    js.each(response.data, function (index, obj) {
//                    console.log(perm_id);
                        js("input[name=chk_perm][value=" + obj.perm_id + "]").prop("checked", true);
                    });

                } else {
                    showFailedAlert("Could not load data.");
                }

            } else {
                showFailedAlert("Could not load data.");
            }
        }, 'json');
    }
}



function showWaitAlert(message, hide) {
    js(".form-alertbox").html(message);
    js(".form-alertbox").removeClass('alert-danger alert-success alert-info').addClass('alert-warning ');
    js(".form-alertbox").show();
    if (hide > 0) {
        setTimeout(function () {
            js(".form-alertbox").slideUp();
        }, 3000);
    }
}

function showSuccessAlert(message) {
//    close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    js(".form-alertbox").html(message);
    js(".form-alertbox").addClass("alert-dismissible");
    js(".form-alertbox").removeClass('alert-warning alert-danger alert-info').addClass('alert-success');
    js(".form-alertbox").show();
    setTimeout(function () {
        js(".form-alertbox").slideUp();
    }, 3000);
}

function showFailedAlert(message) {
//    close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    js(".form-alertbox").html(message);
    js(".form-alertbox").addClass("alert-dismissible");
    js(".form-alertbox").removeClass('alert-success alert-warning alert-info').addClass('alert-danger');
    js(".form-alertbox").show();
    setTimeout(function () {
        js(".form-alertbox").slideUp();
    }, 3000);
}

