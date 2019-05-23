js = jQuery.noConflict();
var account_table;
js(document).ready(function () {
    js('body').tooltip({
        selector: 'button[data-toggle="tooltip"]'
    });
    account_table = js('#account_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Account_type/getJtableAccount",
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
    js('#account_table').on('error.dt', function (e, settings, techNote, message) {
        console.log('DataTables error: ', message);
    });
    js("#form_account_type").validate({
        rules: {
            account_type_code: {
                required: true,
                valide_code: true
            },
            account_type: {
                required: true,
                valid_name: true
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
    js('[data-toggle="tooltip"]').tooltip({
        "container": 'body'
    });
});

jQuery.validator.addMethod("valide_code", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\d\_]{1,20}$/.test(value);
}, "Please enter a valid Code");

jQuery.validator.addMethod("valid_name", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\ ]*$/.test(value);
}, "Please enter a valid Account Type");

js(document).on('click', '#btn_save', function (event) {
    var is_valid = js("#form_account_type").valid();
    if (is_valid) {
        saveAccount();
    }
});

js(document).on('click', '.btn-edit', function (event) {
    loadAccountById(js(this).val());
});

js(document).on('click', '#btn_cancel', function (event) {
    cancelEdit();
});

js(document).on('click', '.btn-del', function (event) {
    var account_type_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to delete this ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                deleteAccountById(account_type_id);
            });
});

js(document).on('click', '.btn-inactivate', function (event) {
    record_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to disable this data ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                recordInactivateById(record_id);
            });
});

js(document).on('click', '.btn-activate', function (event) {
    record_id = js(this).val();
    swal({
        title: "Are you sure?",
        text: "You want to enable this record ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        animation: "slide-from-top"
    },
            function () {
                recordActivateById(record_id);
            });
});
function recordActivateById(record_id) {

    var param = {};
    param.record_id = record_id;
    js.post('Account_type/activate_record', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
                showSuccessAlert("record enabled.");
                account_table.ajax.reload();
            } else {
                showFailedAlert("record enable failed.");
            }

        } else {
            showFailedAlert("Error, record enable failed.");
        }
    }, 'json');
}

function recordInactivateById(record_id) {

    var param = {};
    param.record_id = record_id;
    js.post('Account_type/inactivate_record', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
                showSuccessAlert("record disabled.");
                account_table.ajax.reload();
            } else {
                showFailedAlert("record disable failed.");
            }

        } else {
            showFailedAlert("Error, record disable failed.");
        }
    }, 'json');
}

function saveAccount() {
    showWaitAlert("Please wait");
    var formData = new FormData(form_account_type);
    js.ajax({
        method: 'POST',
        url: 'Account_type/saveAccount',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
    }).always(function (data) {
        console.log(data.status);
        if (data.status == '1') {
            showSuccessAlert("Account saved.");
            cancelEdit();
            account_table.ajax.reload();
        } else {
            showFailedAlert("Could not save data.")
        }

    });

}

function deleteAccountById(account_type_id) {

    var param = {};
    param.account_type_id = account_type_id;
    js.post('Account_type/deleteAccount', param, function (response) {
        if (response !== null) {
            if (response.status == "1") {
                showSuccessAlert("record deleted.");
                account_table.ajax.reload();
            } else {
                showFailedAlert("delete failed.");
            }

        } else {
            showFailedAlert("Error,  delete failed.");
        }
    }, 'json');
}

function loadAccountById(account_type_id) {

    cancelEdit();


    var param = {};
    param.account_type_id = account_type_id;

    //showWaitAlert("Please wait",1);
    js.post('account_type/getAccountById', param, function (response) {

        if (response !== null) {
            if (response.status == "1") {
                js("#btn_cancel").show();
                js("#account_type_id").val(response.data[0].account_type_id);
                js("#account_type").val(response.data[0].account_type);
                js("#account_type_code").val(response.data[0].account_type_code);
                js('#form_cont').collapse('show');
//                js("#society_id").val(response.data[0].society_id);
//                


            } else {
                showFailedAlert("Could not load data.");
            }

        } else {
            showFailedAlert("Could not load data.");
        }
    }, 'json');
}

function cancelEdit() {
    js("form .form-control").val('');

    js("#btn_cancel").hide();
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


function getJtableBtnHtml(full) {
    var html = '';
    html += '<div class="btn-group" role="group">';
    html += '<button type="button" class="btn btn-default btn-edit" value="' + full[0] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
    if (full[3] == 0) {
        html += '<button type="button" class="btn btn-warning btn-activate" value="' + full[0] + '" data-toggle="tooltip" title="Enable this data"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
    } else {
        html += '<button type="button" class="btn btn-success btn-inactivate" value="' + full[0] + '" data-toggle="tooltip" title="Disable this data"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
    }
    html += '<button type="button" class="btn btn-danger btn-del" value="' + full[0] + '" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
    html += '</div>';
    return html;
}