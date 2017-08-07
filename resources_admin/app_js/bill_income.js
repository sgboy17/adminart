if ($('#bill_income_list').length) {
    var bill_income_list = $('#bill_income_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "billincome/get_bill_income_list",
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

            aoData.push({"name": "f_customer_id", "value": $('#customer_id').val()});


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
        bill_income_list.fnDraw();
    });


    $("#range_date").on("change", function () {
        bill_income_list.fnDraw();
    });

    $("#bill_type").on("change", function () {
        bill_income_list.fnDraw();
    });

}

function bill_income_list_filter() {
    $('#type_search').val('1');
    bill_income_list.fnDraw();
    $('.modal .close').trigger('click');
}

function delete_bill_income_multiple() {
    if (confirm('Bạn có chắc muốn xoá những dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billincome/delete_bill_income',
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

function delete_bill_income(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billincome/delete_bill_income',
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


function validate_bill_income_form() {
    //handlePrice();
    // $('.modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price]').on('change', function () {
    //     var total_price = $('.modal input[name=total_price]').val();
    //     //var commission_percent = $('.modal input[name=commission_percent]').val();
    //     //var commission_price = $('.modal input[name=commission_price]').val();
    //     //var final_price = total_price - total_price * commission_percent / 100 - commission_price;
    //     //$('.modal input[name=final_price]').val(parseInt(final_price)).trigger('change');
    // });
    // //$('.modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price]').trigger('change');
    // $('.modal input[name=total_price').trigger('change');

    // var customer_id = $('.modal input[name=customer_id]').val();
    // var customer_object = $('.modal input[name=customer_id]').attr('data-object');
    // var customer_score = $('.modal input[name=customer_id]').attr('data-score');
    // var customer_address = $('.modal input[name=customer_id]').attr('data-address');
    // var customer_phone = $('.modal input[name=customer_id]').attr('data-phone');
    //var customer_name = $('.modal #customer_info').val();
    // var customer_data = {
    //     name: customer_name,
    //     id: customer_id,
    //     object: customer_object,
    //     score: customer_score,
    //     address: customer_address,
    //     phone: customer_phone,
    // }
    // $(".modal #customer_info").select2({
    //     placeholder: "- Tìm khách hàng -",
    //     ajax: {
    //         url: base_url + "customer/load_customer_list_view",
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 q: params, // search term
    //             };
    //         },
    //         results: function (data, params) {
    //             params.page = params.page || 1;
    //             return {
    //                 results: data,
    //                 pagination: {
    //                     more: (params.page * 5) < data.total_count
    //                 }
    //             };
    //         },
    //         cache: true
    //     },
    //     escapeMarkup: function (markup) {
    //         return markup;
    //     },
    //     minimumInputLength: 1,
    //     formatResult: function (repo) {
    //         if (repo.loading) return repo.text;
    //         var markup = repo.name;
    //         return markup;
    //     },
    //     formatSelection: function (repo) {
    //         $('.modal .customer_info #object').val(repo.object);
    //         $('.modal .customer_info #score').val(repo.score);
    //         $('.modal .customer_info #address').val(repo.address);
    //         $('.modal .customer_info #phone').val(repo.phone);
    //         $('.modal input[name=customer_id]').val(repo.id);
    //         return repo.name;
    //     }
    // });
    // $(".modal #customer_info").select2('data', customer_data);

    $("#bill_income_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            branch_id: {
                required: true,
            },

            // employee_id: {
            //     required: true,
            // },

            type: {
                required: true,
            },

            // method: {
            //     required: true,
            // },

            total_price: {
                required: true,
            },

            // commission_price: {
            //     required: true,
            // },

            // commission_percent: {
            //     required: true,
            // },

        },
        messages: {

            branch_id: "Vui lòng điền chi nhánh!",

            //employee_id: "Vui lòng điền nhân viên!",

            type: "Vui lòng điền phương thức!",

            //method: "Vui lòng điền hình thức thanh toán!",

            total_price: "Vui lòng điền tổng thu!",

            //commission_price: "Vui lòng điền chiết khấu giá!",

            //commission_percent: "Vui lòng điền chiết khấu phần trăm!",

        }
    });
    handleUniform();
}


function load_bill_income_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billincome/load_bill_income_add',
        beforeSend: function (xhr) {
            jQuery("#bill_income_detail #bill_income_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_income_detail #bill_income_form").html(resp);
            validate_bill_income_form();
        }
    });
}

function load_bill_income_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'billincome/load_bill_income_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#bill_income_detail #bill_income_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#bill_income_detail #bill_income_form").html(resp);
            validate_bill_income_form();
        }
    });
}

function save_bill_income_add(element) {
    if ($("#bill_income_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billincome/save_bill_income_add',
            data: $('#bill_income_form').serialize(),
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

function save_bill_income_edit(element) {
    if ($("#bill_income_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'billincome/save_bill_income_edit',
            data: $('#bill_income_form').serialize(),
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
