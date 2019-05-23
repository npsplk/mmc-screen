js = jQuery.noConflict();
var users_table;
js(document).ready(function () {
    users_table = js('#users_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Users/getJtableUsers",
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": -1,
                "data": "0",
                "orderable": false,
                "render": function (data, type, full, meta) {
                    return getJtableBtnHtml(full);
                }
            }
        ],
        "order": [[0, "desc"]]
    });
    //data table error handling
    js.fn.dataTable.ext.errMode = 'none';
    js('#users_table').on('error.dt', function (e, settings, techNote, message) {
//        console.log('DataTables error: ', message);
    });


    js("#form_user").validate({
        rules: {
            u_name: {
                minlength: 4,
                valide_uname: true,
                required: true,
            },
//            email: {
//                required: function (element) {
//                    return js("#id").val() <= 0;
//                }
//            },
            district_id: {
                valid_district: true,
            },
            password: {
                required: function (element) {
                    return js("#id").val() <= 0;
                },
                minlength: 5
            },
            password2: {
                required: function (element) {
                    return js("#id").val() <= 0;
                },
                minlength: 5,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            password2: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            u_name: {
                minlength: "User name should have at least 4 characters",
            }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            js(element).parents(".col-md-8").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            js(element).parents(".col-md-8").removeClass("has-error");
        }
    });

//    js("#society_list").chosen({
//        disable_search_threshold: 5,
//        width: "100%",
//    });
});

jQuery.validator.addMethod("valide_uname", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\d\_]{4,100}$/.test(value);
}, "User name can have only numbers,letters and _");

jQuery.validator.addMethod("valid_district", function (value, element) {
    is_valid = false;
    if (js("#group_id").val() == '6') {
        if (parseInt(js("#district_id").val()) == -1) {
            is_valid = true;
        }
    } else {
        if (parseInt(js("#district_id").val()) > 0) {
            is_valid = true;
        }
    }
    return is_valid;
}, "Please make a valid selection");

// --------------------- EVENT HANDLING --------------------

js(document).on('click', '#btn_save', function (event) {
    var is_valid = js("#form_user").valid();
    if (is_valid) {
        save();
    }
});

js(document).on('click', '.btn-edit', function (event) {
    loadUserById(js(this).val());
});

js(document).on('click', '#btn_cancel', function (event) {
//    cancelEdit();
reset_to_default();
});


js(document).on('change', '#group_id', function (event) {
    var access_level = js("#group_id option:selected").attr('access_level');
    if (access_level == 1) {
        //district/island
        js(".society-section").hide();
        js(".society-listsection").hide();
    } else if (access_level == 2) {
        //society
        js(".society-section").show();
        js(".society-listsection").hide();

    } else {
        //extension officer
        js(".society-section").hide();
        js(".society-listsection").show();
    }
    if (js("#group_id").val() == '6') {
        js("#district_id").val('-1')
    } else {
        js("#district_id").val('')
    }
});

js(document).on('click', '.btn-del', function (event) {
    var user_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to delete this user account ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                resp = deleteUserById(user_id);
            });
});

js(document).on('click', '.btn-inactivate', function (event) {
    user_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to deactivate this user account ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                resp = blockUserById(user_id);
            });
});

js(document).on('click', '.btn-activate', function (event) {
    user_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to activate this user account ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                resp = unblockUserById(user_id);
            });
});


function save() {
//    showWaitAlert("Please wait");
    var formData = new FormData(form_user);
    js.ajax({
        method: 'POST',
        url: 'users/save',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        responsive: true,
    }).always(function (data) {
//        console.log(data.msg);
        if (data.status == '1') {
            showSuccessAlert("User saved.");
            users_table.ajax.reload();
            cancelEdit();
        } else {
            showFailedAlert(data.msg)
        }

    });

}


function getJtableBtnHtml(full) {
    var html = '';
    html += '<div class="btn-group" role="group">';
// html += '<button type="button" class="btn btn-default btn-edit" value="' + full[0] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
    if (full[4] == 1) {
        html += '<button type="button" class="btn btn-warning btn-activate" value="' + full[0] + '" data-toggle="tooltip" title="Enable this data"><i class="fa fa-ban" aria-hidden="true"></i></button>';
    } else {
        html += '<button type="button" class="btn btn-warning btn-inactivate" value="' + full[0] + '" data-toggle="tooltip" title="Edit this data"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
    }
    html += '<button type="button" class="btn btn-danger btn-del" value="' + full[0] + '" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
    html += '<button type="button" class="btn btn-primary btn-view" value="' + full[1] + '" data-toggle="tooltip" title="view profile"><i class="fa fa-address-card" aria-hidden="true"></i></button>';
    if (full[2] == 'Admin') {
        html += '<button type="button" class="btn btn-danger btn-edit" value="' + full[0] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
    }
    html += '</div>';
    return html;
}

function cancelEdit() {
    js("form .form-control").val('');
    js(".society-section").hide();
//    js("#btn_cancel").hide();
    js("#group_id").attr("disabled", false);
}

function reset_to_default() {
   js("#u_name").val('');
                    js("#password").val('');
                    js("#password2").val('');
                    js("#user_groupss").removeClass('hidden');
                    js("#btn_save").removeClass('hidden');
                    js("#btn_update").addClass('hidden');
                    js("#btn_cancel").addClass('hidden');
                    document.getElementById("u_name").disabled = false;

                    js('#form_cont').collapse('hide');
}

function loadUserById(uid) {
    var param = {};
    param.uid = uid;
    cancelEdit();
    //showWaitAlert("Please wait",1);
    js.post('users/getUserById', param, function (response) {

        if (response !== null) {
            if (response.status == "1") {
                var data = response.data
                js("#btn_cancel").show();
                js("#u_name").val(response.data.username);
                document.getElementById("u_name").disabled = true;
                js("#btn_save").addClass('hidden');
                js("#user_groupss").addClass('hidden');
                js("#btn_update").removeClass('hidden');
                js("#id").val(response.data.id);
                js('#form_cont').collapse('show');
            } else {
                showFailedAlert("Could not load data.");
            }
        } else {
            showFailedAlert("Could not load data.");
        }
    }, 'json');
}

function deleteUserById(uid) {
    var param = {};
    param.uid = uid;
    js.post('users/removeUserById', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
//                swal("Deleted!", "User account deleted.", "success");
                showSuccessAlert("User account deleted.");
            } else {
                showFailedAlert("User account delete failed.");
//                swal("Delete failed!", "User account delete failed.", "error");
            }
            users_table.ajax.reload();

        } else {
            showFailedAlert("Error, User account delete failed.");
//            swal("Delete failed!", "User account delete failed.", "error");
        }
        cancelEdit();
    }, 'json');
}

function blockUserById(uid) {
    var param = {};
    param.uid = uid;
    cancelEdit();
    js.post('users/blockUserById', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
//                swal("Deleted!", "User account deleted.", "success");
                showSuccessAlert("User account deactivated.");
                users_table.ajax.reload();
            } else {
                showFailedAlert("Action failed.");
//                swal("Delete failed!", "User account delete failed.", "error");
            }

        } else {
            showFailedAlert("Error, User account deactivation failed.");
//            swal("Delete failed!", "User account delete failed.", "error");
        }
    }, 'json');
}

function unblockUserById(uid) {
    var param = {};
    param.uid = uid;
    cancelEdit();
    js.post('users/unblockUserById', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
                showSuccessAlert("User account activated.");
                users_table.ajax.reload();
            } else {
                showFailedAlert("Action failed.");
            }

        } else {
            showFailedAlert("Error, User account activation failed.");
//            swal("Delete failed!", "User account delete failed.", "error");
        }
    }, 'json');
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


js(document).on('click', '.btn-view', function (event) {
    var pathview = js('#view_prof').val();
    var prof = js(this).val();
    submitDataByPost(pathview, 'username', prof);
});
js(document).on('click', '#btn_update', function (event) {
    var update_id = js('#id').val();
    var pass = js('#password').val();
    var pass2 = js('#password2').val();
//    alert(pass);
    if (update_id == '' || pass == '' || pass2 == '') {
        showFailedAlert("Fill all the fields");
    } else {
        update_user(update_id, pass, pass2);
    }

});

function submitDataByPost(submitPage, submitDataName, submitDataValue) {
    js('<form action="' + submitPage + '" target="_blank" method="POST"/>')
            .append(js('<input type="hidden" name="' + submitDataName + '" value ="' + submitDataValue + '">'))
            .appendTo(js(document.body))
            .submit();
}

function update_user(update_id, pass, pass2) {
//    alert(pass);
    var param = {};
    param.update_id = update_id;
    param.pass = pass;
//    cancelEdit();
    //showWaitAlert("Please wait",1);
    if (pass == pass2) {
        js.post('users/update_user_by_id', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    showSuccessAlert("updated successfully.");
//                    var data = response.data
                    js("#u_name").val('');
                    js("#password").val('');
                    js("#password2").val('');
                    js("#user_groupss").removeClass('hidden');
                    js("#btn_save").removeClass('hidden');
                    js("#btn_update").addClass('hidden');
                    js("#btn_cancel").addClass('hidden');
                    document.getElementById("u_name").disabled = false;

                    js('#form_cont').collapse('hide');
                } else {
                    showFailedAlert("Could not Update data.");
                }
            } else {
                showFailedAlert("Could not Update data.");
            }
        }, 'json');
    } else {
        showFailedAlert("Password does not match.");
    }

}