<script>

  jQuery(document).on('change', '#week_number', function (event) {
       shedule_datatable();
    });
	
	 jQuery(document).on('change', '#route_filter', function (event) {
       shedule_datatable();
    });
	
	 jQuery(document).on('change', '#status_filter', function (event) {
       shedule_datatable();
    });

 jQuery(document).on('change', '#type', function (event) {
       shedule_datatable();
    });


    var masterdata_form_validator;
    var var_data_grid_table;
    jQuery(document).ready(function () {
		
		shedule_datatable();
		
        masterdata_form_validator = jQuery("#shedule_form").validate({
            rules: {
                shedule_id: {
                    required: true
                }, week_day_id: {
                    required: true
                }, route_id: {
                    required: true
                }, departure_time: {
                    required: true
                }
                }

			
        });


    });
// --------------------- END OF DOCUMENT READY CODE ----------------------------



function shedule_datatable() {
	
        var_data_grid_table = jQuery('#data_grid_table').DataTable({
			
            "processing": true,
            "serverSide": true,
			"bDestroy": true,
            "language": {
                searchPlaceholder: ""
            },
            "ajax": {
                "url": site_url + "/shedule/getDatatableRecords",
               "type": "POST",
                "data": function (d) {
                    return jQuery.extend({}, d, {
                       "week_day": jQuery("#week_number").val(),
					    "route_filter": jQuery("#route_filter").val(),
						"type": jQuery("#type").val(),
						"status_filter": jQuery("#status_filter").val()
                    });
                }
                
            },
            "columns": [
			{"data": "day"}, 
			{"data": "to_location"}, 
			{"data": "route"}, 
			{"data": "bus_number"}, 
			{"data": "departure_time"},
			{"data": "route_type_name"}, 
			{"data": "remarks"}, 
			{"data": "status_name"}, 
			
			{"data": "shedule_id"}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    
                    "render": function (data, type, full, meta) {
                        return getTableActionBtnHtml(full);
                    }
                }
            ],
            "order": [[0, "DESC"]],
			"lengthMenu": [[10, 25, 50, 99999999], [10, 25, 50, "All"]],
        });

  
}



    jQuery(document).ajaxStart(function () {
        jQuery(".loading_animation_content").show();
    }).ajaxStop(function () {
        jQuery(".loading_animation_content").hide();
    });

    jQuery(document).on('click', '#btn_save', function (event) {
        var is_valid = jQuery("#shedule_form").valid();
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
            var data_form = document.getElementById('shedule_form');
            var formData = new FormData(data_form);
            jQuery.ajax({
                method: 'POST',
                url: site_url + '/shedule/save',
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
        html += '<button type="button" class="btn btn-default btn-edit" value="' + full["shedule_id"] + '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        if (full["status"] == 1) {
            html += '<button type="button" class="btn btn-success btn-deactivate" value="' + full["shedule_id"] + '" data-toggle="tooltip" title="Record is active"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
        } else {
            html += '<button type="button" class="btn btn-warning btn-activate" value="' + full["shedule_id"] + '" data-toggle="tooltip" title="Record is inactive"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>';
        }
        html += '</div>';
        return html;
    }

    function getRecordById(id) {
        var param = {};
        param.id = id;
//        resetMasterDataForm();

        jQuery.post(site_url + '/shedule/getRecordById', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    var data = response.data
                    jQuery("#id").val(data.shedule_id);
                    jQuery("#week_day_id").val(data.week_day_id);
                    jQuery("#route_id").val(data.route_id);
                    jQuery("#bus_number").val(data.bus_number);
                    jQuery("#departure_time").val(data.departure_time);
                    jQuery("#arrival_time").val(data.arrival_time);
                    jQuery("#remarks").val(data.remarks);
                    jQuery("#status_id").val(data.status_id);
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
        jQuery.post(site_url + '/shedule/hide', param, function (response) {
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
        jQuery.post(site_url + '/shedule/show', param, function (response) {
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
        shedule_form.reset();
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
		