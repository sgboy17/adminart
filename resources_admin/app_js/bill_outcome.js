if ($('#bill_outcome_list').length) {
    var bill_outcome_list = $('#bill_outcome_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "billoutcome/get_bill_outcome_list",
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

            aoData.push({"name": "f_bill_type", "value": $('#bill_type').val()});

            aoData.push({"name": "f_branch_id", "value": $('#branch_id').val()});

            aoData.push({"name": "f_employee_id", "value": $('#employee_id').val()});

            aoData.push({"name": "f_type", "value": $('#type').val()});

            aoData.push({"name": "f_from_date", "value": $('#from_date').val()});

            aoData.push({"name": "f_to_date", "value": $('#to_date').val()});

            aoData.push({"name": "f_supplier_id", "value": $('#supplier_id').val()});


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
        bill_outcome_list.fnDraw();
    });


    $("#range_date").on("change", function () {
        bill_outcome_list.fnDraw();
    });

    $("#bill_type").on("change", function () {
        bill_outcome_list.fnDraw();
    });


}

function bill_outcome_list_filter() {
    $('#type_search').val('1');
    bill_outcome_list.fnDraw();
    $('.modal .close').trigger('click');
}

function delete_bill_outcome_multiple() {
    if (confirm('Bạn có chắc muốn xoá những dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billoutcome/delete_bill_outcome',
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

function delete_bill_outcome(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billoutcome/delete_bill_outcome',
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


function validate_bill_outcome_form() {
    handlePrice();
    $('.modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price]').on('change', function () {
        var total_price = $('.modal input[name=total_price]').val();
        var commission_percent = $('.modal input[name=commission_percent]').val();
        var commission_price = $('.modal input[name=commission_price]').val();
        var final_price = total_price - total_price * commission_percent / 100 - commission_price;
        $('.modal input[name=final_price]').val(parseInt(final_price)).trigger('change');
    });
    $('.modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price]').trigger('change');
    $('.modal #supplier_info').on('change', function () {
        var address = $(this).find('option:selected').attr('data-address');
        var phone = $(this).find('option:selected').attr('data-phone');
        $('.modal .supplier_info #address').val(address);
        $('.modal .supplier_info #phone').val(phone);
    });
    $('.modal #supplier_info').trigger('change');
    $("#bill_outcome_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            branch_id: {
                required: true,
            },

            employee_id: {
                required: true,
            },

            type: {
                required: true,
            },

            method: {
                required: true,
            },

            price: {
                required: true,
            },

            commission_price: {
                required: true,
            },

            commission_percent: {
                required: true,
            },

        },
        messages: {

            branch_id: "Vui lòng điền chi nhánh!",

            employee_id: "Vui lòng điền nhân viên!",

            type: "Vui lòng điền phương thức!",

            method: "Vui lòng điền hình thức thanh toán!",

            price: "Vui lòng điền tổng chi!",

            commission_price: "Vui lòng điền chiết khấu giá!",

            commission_percent: "Vui lòng điền chiết khấu phần trăm!",

        }
    });
    handleUniform();
}


function load_bill_outcome_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billoutcome/load_bill_outcome_add',
        beforeSend: function (xhr) {
            jQuery("#bill_outcome_detail #bill_outcome_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_outcome_detail #bill_outcome_form").html(resp);
            validate_bill_outcome_form();
        }
    });
}

function load_bill_outcome_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billoutcome/load_bill_outcome_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#bill_outcome_detail #bill_outcome_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_outcome_detail #bill_outcome_form").html(resp);
            validate_bill_outcome_form();
        }
    });
}

function save_bill_outcome_add(element) {
    if ($("#bill_outcome_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billoutcome/save_bill_outcome_add',
            data: $('#bill_outcome_form').serialize(),
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

function save_bill_outcome_edit(element) {
    if ($("#bill_outcome_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billoutcome/save_bill_outcome_edit',
            data: $('#bill_outcome_form').serialize(),
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
