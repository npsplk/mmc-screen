<script>
    js = jQuery.noConflict();
    js(document).ready(function ($) {
        getTreePermissions();

    });

    js('#user_combo').change(function () {
        js('tbody tr td input[type="checkbox"]').each(function () {
            js(this).prop('checked', false);
        });

    });

    js(document).on('click', '#btn_save', function (event) {
        var group_id = js("#group_id").val();
        var user_id = js("#user_combo").val();

        checked_nodes = js('#tree').treeview('getChecked', false);

        var checked_perm_arr = [];
        if (checked_nodes) {
            js.each(checked_nodes, function (index, perm_node) {
                if (!perm_node.state.disabled) {
                    checked_perm_arr.push(perm_node.permid);
                }
//                checked_perm_arr.push(perm_node.permid);
            });
        }
//        console.log(checked_perm_arr);
        if (group_id > 0 && checked_perm_arr.length > 0 && user_id > 0) {
            swal({
                title: "Are you sure?",
                text: "You want to update the user permissions ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },
                    function () {
                        saveUserPerms(checked_perm_arr);
                    });

        } else {
            showFailedAlert("Could not save permissions. Make sure you have selected a user group & permissions");
        }
    });



//    js(document).on('click', '.upermissions', function () {
//        var permision_id = js(this).val();
//        var groupid = js(this).data('group_id');
//        var userid = js('#user_combo').val();
//        var checked_values = check_uncheck_values(permision_id);
//        save_update_permissions(checked_values, permision_id, groupid, userid);
//    });

    js(document).on('change', '#group_id', function () {
        var groupid = js(this).val();
        getGroupPermissions();
        load_user_combo_to_group(groupid);
    });

    js(document).on('change', '#user_combo', function () {
        var user_id = js(this).val();
        get_permissions_to_user();
    });

    js(document).on('nodeChecked', '#tree', function (event, node) {
//    console.log(node);
        p = js('#tree').treeview(true).getParent(node);
        if (p) {
            js('#tree').treeview(true).checkNode(p.nodeId, {silent: true});
        }
    });

    js(document).on('nodeUnchecked', '#tree', function (event, node) {
//    console.log(node);
        js.each(node.nodes, function (index, child) {
            js('#tree').treeview(true).uncheckNode(child.nodeId, {silent: true});
        });

    });

    function load_user_combo_to_group(groupid, selected) {
        var param = {};
        param.goup_id = groupid;

        var select_data = '';
        js.post("<?php echo site_url("user_permissions/load_user_combo_to_group") ?>", param, function (response) {

//                alert(response.status);
            if (response.status == "1" && response.data != null) {
                select_data += '<option value=""> Select User </option>';
                js.each(response.data, function (index, row) {

                    if (response !== undefined || response !== null || response.length !== 0) {
                        if (parseInt(selected) === parseInt(row.id)) {
                            select_data += '<option value="' + row.id + '" selected>' + row.username + '</option>';
                        } else {
                            select_data += '<option value="' + row.id + '">' + row.username + '</option>';
                        }
                    } else {
                        select_data += '<option value="' + row.id + '">' + row.username + '</option>';
                    }
                });
            }
            js('#user_combo').html('').append(select_data);
        }, 'json');
    }

    function getGroupPermissions() {
        js('#tree').treeview(true).uncheckAll();
        js('#tree').treeview(true).enableAll();

        if (js("#group_id").val() > 0) {
            var param = {};
            param.group_id = js("#group_id").val();

            showWaitAlert("Loading group permissions. Please wait...");
            js.post('User_permissions/getUserGroupPermissions', param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {
                        js(".form-alertbox").hide();
                        unchecked_nodes = js('#tree').treeview('getUnchecked', false);
                        js.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = js.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                if (nodeobj.parentId) {
                                    js('#tree').treeview('disableNode', [nodeobj.nodeId, {silent: true}]);
                                } else {
                                    js('#tree').treeview('expandNode', [nodeobj.nodeId, {levels: 2, silent: true}]);
//                                    js('#tree').treeview('disableNode', [nodeobj.nodeId, {silent: true}]);
                                }
                                js('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        showFailedAlert("No permissions assigned.");
                    }

                } else {
                    showFailedAlert("Could not load data.");
                }
            }, 'json').fail(function () {
                showFailedAlert("Could not load data.");
            });
        }
    }

    function saveUserPerms(permsArray) {
        var param = {};
        param.user_id = js("#user_combo").val();
        param.perms = permsArray;

        js.post('User_permissions/saveUserPermissions', param, function (response) {

            if (response !== null) {
                if (response.status == "1") {
                    showSuccessAlert("user group permissions updated.");
                    window.location.reload(true);
                    
                } else {
                    showFailedAlert("permissions update failed.");
                }
            } else {
                showFailedAlert("Error, permissions update failed.");
            }
        }, 'json');
    }

    function get_permissions_to_user() {
        if (js("#user_combo").val() > 0) {
            var param = {};
            param.user_id = js("#user_combo").val();

            showWaitAlert("Loading group permissions. Please wait...");
            js.post('User_permissions/get_permissions_to_user', param, function (response) {

                if (response !== null) {
                    if (response.status == "1") {
                        js(".form-alertbox").hide();
                        unchecked_nodes = js('#tree').treeview('getUnchecked', false);
                        js.each(unchecked_nodes, function (index, nodeobj) {
                            node_perm_id = nodeobj.id;
                            a = js.inArray(node_perm_id, response.data);
                            if (a > -1) {
                                js('#tree').treeview('checkNode', [nodeobj.nodeId, {silent: true}]);
                            }
                        });

                    } else {
                        showFailedAlert("No permissions assigned.");
                    }

                } else {
                    showFailedAlert("Could not load data.");
                }
            }, 'json').fail(function () {
                showFailedAlert("Could not load data.");
            });
        }
    }

    function getTreePermissions() {
        var param = {};
        showWaitAlert("Loading permissions. Please wait...");
        js.post('user_group/getPermissionsTree', param, function (response) {

            if (response !== null) {
                js('#tree').treeview(
                        {
                            data: response,
//                        multiSelect: true,
                            selectable: false,
                            highlightSelected: false,
                            expandIcon: "fa fa-plus-square-o",
                            collapseIcon: "fa fa-minus-square-o",
                            emptyIcon: "fa fa-minus-square-o",
                            checkedIcon: "fa fa-check-square-o",
                            uncheckedIcon: "fa fa-square-o",
                            showCheckbox: true
                        }
                );
                js(".form-alertbox").hide();
            } else {
                showFailedAlert("Could not load data.");
            }
        }, 'json');
    }


    function save_update_permissions(checked_values, permision_id, groupid, userid) {
        js.post("<?php echo site_url("administrator/user_permissions_c/save_update_permissions") ?>", {checked_values: checked_values, permision_id: permision_id, groupid: groupid, userid: userid}, function (response) {
            if (response == 1) {
                showSuccessAlert("Permissions successfully added");
                get_permissions_to_user(groupid, userid);
            } else {
                showFailedAlert("permissions update failed.");
            }

        }, "json");
    }


    function check_uncheck_values(permid) {
        var perms = {};
        perms.save = 0;
        perms.edit = 0;
        perms.delete = 0;
        js('#user_permission_table > tbody  > tr[data-rowid="' + permid + '"]').each(function () {

            if (js(this).find('input[name="save_check"]').prop("checked")) {
                perms.save = 1;
            } else {
                perms.save = 0;
            }
            if (js(this).find('input[name="edit_check"]').prop("checked")) {
                perms.edit = 1;
            } else {
                perms.edit = 0;
            }

            if (js(this).find('input[name="delete_check"]').prop("checked")) {
                perms.delete = 1;
            } else {
                perms.delete = 0;
            }

        });
        return perms;
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





</script>

