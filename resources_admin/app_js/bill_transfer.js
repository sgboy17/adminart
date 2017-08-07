if ($('#bill_transfer_list').length) {
    var bill_transfer_list = $('#bill_transfer_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "billtransfer/get_bill_transfer_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function (aoData) {


            aoData.push({"name": "f_type_search", "value": $('#type_search').val()});

            aoData.push({"name": "f_search", "value": $('#search').val()});

            aoData.push({"name": "f_range_date", "value": $('#range_date').val()});

            aoData.push({"name": "f_branch_id_income", "value": $('#branch_id_income').val()});

            aoData.push({"name": "f_branch_id_outcome", "value": $('#branch_id_outcome').val()});

            aoData.push({"name": "f_employee_id", "value": $('#employee_id').val()});

            aoData.push({"name": "f_from_date", "value": $('#from_date').val()});

            aoData.push({"name": "f_to_date", "value": $('#to_date').val()});

            aoData.push({"name": "f_status", "value": $('#status').val()});


        },
        "fnDrawCallback": function () {
            $(this).find('tbody tr').removeClass('odd').removeClass('even');
            $(this).next().attr('style', "display:none;");
            if ($(this).next().next().find('span a').length <= 1) {
                $(this).next().next().attr('style', "display:none;");
            } else {
                $(this).next().next().attr('style', "display:block;");
            }
            if ($('.check_all').length) {
                $('.check_all').on('click', function () {
                    if (!$('.check_all').prop('checked')) {
                        $('.id:checked').trigger('click');
                    } else {
                        $('.id:not(.id:checked)').trigger('click');
                    }
                });
            }
            handleUniform();
        }
    });


    $("#search").on("keyup", function () {
        bill_transfer_list.fnDraw();
    });

    $("#range_date").on("change", function () {
        bill_transfer_list.fnDraw();
    });


}

function bill_transfer_list_filter() {
    $('#type_search').val('1');
    bill_transfer_list.fnDraw();
    $('.modal .close').trigger('click');
}

function delete_bill_transfer_multiple() {
    if (confirm('Bạn có chắc muốn xoá những dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/delete_bill_transfer',
            data: {
                id: id
            },
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
            }
        });
    }
}

function delete_bill_transfer(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/delete_bill_transfer',
            data: {
                id: id
            },
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
            }
        });
    }
}


function approve_bill_transfer(id) {
    if (confirm('Bạn có chắc muốn duyệt dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/approve_bill_transfer_edit',
            data: {
                id: id
            },
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
            }
        });
    }
}

function unapprove_bill_transfer(id) {
    if (confirm('Bạn có chắc muốn bỏ duyệt dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/unapprove_bill_transfer_edit',
            data: {
                id: id
            },
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
            }
        });
    }
}

function validate_bill_transfer_form() {
    handlePrice();
    $("#bill_transfer_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            branch_id_income: {
                required: true,
            },

            branch_id_outcome: {
                required: true,
            },

            employee_id: {
                required: true,
            },

            price: {
                required: true,
            },

        },
        messages: {

            branch_id_income: "Vui lòng điền chi nhánh thu!",

            branch_id_outcome: "Vui lòng điền chi nhánh chi!",

            employee_id: "Vui lòng điền nhân viên!",

            price: "Vui lòng điền số tiền",

        }
    });
    handleUniform();
}


function load_bill_transfer_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billtransfer/load_bill_transfer_add',
        beforeSend: function (xhr) {
            jQuery("#bill_transfer_detail #bill_transfer_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_transfer_detail #bill_transfer_form").html(resp);
            validate_bill_transfer_form();
        }
    });
}

function load_bill_transfer_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billtransfer/load_bill_transfer_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#bill_transfer_detail #bill_transfer_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_transfer_detail #bill_transfer_form").html(resp);
            validate_bill_transfer_form();
        }
    });
}

function save_bill_transfer_add(element) {
    if ($("#bill_transfer_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/save_bill_transfer_add',
            data: $('#bill_transfer_form').serialize(),
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
                element.next().trigger('click');
            }
        });
    }
}

function save_bill_transfer_edit(element) {
    if ($("#bill_transfer_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billtransfer/save_bill_transfer_edit',
            data: $('#bill_transfer_form').serialize(),
            beforeSend: function (xhr) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });
            },
            success: function (resp) {
                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
                element.next().trigger('click');
            }
        });
    }
}
