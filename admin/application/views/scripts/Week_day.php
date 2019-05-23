<script>
    var masterdata_form_validator;
    var var_data_grid_table;
    jQuery(document).ready(function () {
        masterdata_form_validator = jQuery("#week_day_form").validate({
            rules: {
                week_day_id: {
                    required: true
                }, day: {
                    required: true
                }, created_date: {
                    required: true
                }, last_updated: {
                    required: true
                }, updated_by: {
                    required: true
                }, status: {
                    required: true
                }
                }

			
        });


        var_data_grid_table = jQuery('#data_grid_table').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                searchPlaceholder: "Day"
            },
            "ajax": {
                "url": site_url + "/week_day/getDatatableRecords",
                "type": "POST"
            },
            "columns": [
			{"data": "day"}, 
			{"data": "created_date"}, 
			{"data": "last_updated"}, 
			{"data": "updated_by"}, 
			{"data": "status"},
			{"data": "week_day_id"}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": "3",
                    "render": function (data, type, full, meta) {
                        return getTableActionBtnHtml(full);
                    }
                }
            ],
            "order": [[3, "desc"]]
        });

        //data table error handling
        jQuery.fn.dataTable.ext.errMode = 'none';
        jQuery('#data_grid_table').on('error.dt', function (e, settings, techNote, message) {
            console.log('DataTables error: ', message);
        });

    });
// --------------------- END OF DOCUMENT READY CODE ----------------------------

    jQuery(document).ajaxStart(function () {
        jQuery(".loading_animation_content").show();
    }).ajaxStop(function () {
        jQuery(".loading_animation_content").hide();
    });

    jQuery(document).on('click', '#btn_save', function (event) {
        var is_valid = jQuery("#week_day_form").valid();
        if (is_valid) {
            save_form();
        } else {
            swal("Failed!", "Invalid data found!", "warning");
        }
    });

    jQuery(document).on('click', '.btn-edit', function (event) {
        getRecordById(jQuery(this).val());
    });

    jQuery(document).on('click', '#btn_cancel', function (event) {
        resetMasterDataForm();
    });

    jQuery(document).on('click', '.btn-activate', function (event) {
        activateById(jQuery(this).val());
    });

    jQuery(document).on('click', '.btn-deactivate', function (event) {
        deactivateById(jQuery(this).val());
    });

// --------------------- END OF EVENT HANDLING CODE ----------------------------

    function save_form() {
        swal({
            title: "Are you sure?",
            text: "Record will be saved",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: true
        }, function () {
            var data_form = document.getElementById('week_day_form');
            var formData = new FormData(data_form);
            jQuery.ajax({
                method: 'POST',
                url: site_url + '/week_day/save',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
            }).done(function (data, textStatus, jQxhr) {
                if (data.status == '1') {
                    swal("Success!", "Record saved!", "success");
                    var_data_grid_table.ajax.reload();
                    resetMasterDataForm();
                } else {
                    swal("Failed!", "Record could not be saved!", "warning");
                }
            }).fail(function (jQxhr, textStatus, errorThrown) {
                swal("Error!", "Information may not be saved!", "error");
            });
        });
    }

    function getTableActionBtnHtml(full) {
        var html = '';
        html += '<div class="btn-group" role="group">';
        html += '<button type="button" class="btn btn-default btn-edit" value="' + full["week_day_id"] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        if (full["status"] == 1) {
            html += '<button type="button" class="btn btn-success btn-deactivate" value="' + full["week_day_id"] + '" data-toggle="tooltip" title="Record is active"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
        } else {
            html += '<button type="button" class="btn btn-warning btn-activate" value="' + full["week_day_id"] + '" data-toggle="tooltip" title="Record is inactive"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
        }
        html += '</div>';
        return html;
    }

    function getRecordById(id) {
        var param = {};
        param.id = id;
//        resetMasterDataForm();

        jQuery.post(site_url + '/week_day/getRecordById', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    var data = response.data
                    jQuery("#id").val(data.week_day_id);
                    jQuery("#day").val(data.day);
                    jQuery("#created_date").val(data.created_date);
                    jQuery("#last_updated").val(data.last_updated);
                    jQuery("#updated_by").val(data.updated_by);
                    jQuery("#status").val(data.status);
                    jQuery('#form_cont').collapse('show');
                    jQuery('#btn_cancel').show();
                } else {
                    showFailedAlert("Could not load data.");
                }
            } else {
                showFailedAlert("Could not load data.");
            }
        }, 'json');
    }

    function deactivateById(id) {
        var param = {};
        param.id = id;
        jQuery.post(site_url + '/week_day/hide', param, function (response) {
            if (response !== null) {
                if (response.status == "1") {
//                swal("Deleted!", "Deactivation Done.", "success");
                    var_data_grid_table.ajax.reload();
                } else {
                    swal("failed!", "Deactivation failed.", "error");
                }
            } else {
//            swal("Delete failed!", "Deactivation failed.", "error");
            }
        }, 'json');
    }

    function activateById(id) {
        var param = {};
        param.id = id;
        jQuery.post(site_url + '/week_day/show', param, function (response) {
            if (response !== null) {
                if (response.status == "1") {
//                swal("Deleted!", "Activated.", "success");
                    var_data_grid_table.ajax.reload();
                } else {
                    swal("failed!", "Activation failed.", "error");
                }
            } else {
//            swal("Delete failed!", "Activation failed.", "error");
            }
        }, 'json');
    }

    function resetMasterDataForm() {
        masterdata_form_validator.resetForm();
        week_day_form.reset();
        jQuery("#id").val('');
        jQuery('#btn_cancel').hide();
    }

    jQuery.validator.setDefaults({
        errorElement: "span",
        ignore: ":hidden:not(select.chosen-select)",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
//                error.insertAfter(element.parent("label"));
                error.appendTo(element.parents("validate-parent"));
            } else if (element.is("select.chosen-select")) {
                error.insertAfter(element.siblings(".chosen-container"));
            } else if (element.prop("type") === "radio") {
                error.appendTo(element.parents("div.validate-parent"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            jQuery(element).parents(".validate-parent").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            jQuery(element).parents(".validate-parent").removeClass("has-error");
        }
    });


    jQuery.validator.addMethod("valide_code", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s\d\_\-()]{1,100}$/.test(value);
    }, "Please enter a valid Code");



    jQuery.validator.addMethod("valid_name", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s\.\&\-()]{1,100}$/.test(value);
    }, "Please enter a valid name");

    jQuery.validator.addMethod("valid_date", function (value, element) {
        return this.optional(element) || /^\d{4}\-\d{2}\-\d{2}$/.test(value);
    }, "Please enter a valid date ex. 2017-03-27");


    jQuery.validator.addMethod("valide_email", function (value, element) {
        return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value);
    }, "Please enter a valid email address");

</script>
		