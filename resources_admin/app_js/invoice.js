var load_paid_program_first_time = false;

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

Number.prototype.formatMoney = function(c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

// Handles price
var handlePrice = function() {
    var input = $('.modal-dialog input[type=text]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('total') != -1 ||
                $(input[i]).attr('name').indexOf('surcharge') != -1 ||
                $(input[i]).attr('name').indexOf('extra_price') != -1 ||
                $(input[i]).attr('name').indexOf('price') != -1 ||
                $(input[i]).attr('name').indexOf('discount') != -1) {
                var clone = $(input[i]).clone().removeAttr('name');
                $(input[i]).attr('type', 'hidden');
                $(clone).insertBefore($(input[i]));
                $(clone).focus(function() {
                    this.select();
                }).mouseup(function(e) {
                    e.preventDefault();
                });
            }
        }
    }

    var input = $('.modal-dialog input[type=hidden]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('total') != -1 ||
                $(input[i]).attr('name').indexOf('surcharge') != -1 ||
                $(input[i]).attr('name').indexOf('extra_price') != -1 ||
                $(input[i]).attr('name').indexOf('price') != -1 ||
                $(input[i]).attr('name').indexOf('discount') != -1) {
                $(input[i]).prev().keyup(function() {
                    var current_value = $(this).val();
                    $(this).next().val(current_value.replace(/,/g, ''));
                    $(this).next().trigger('change');
                });
                $(input[i]).prev().trigger('keyup');
                $(input[i]).change(function() {
                    var new_value = $(this).val();
                    $(this).prev().val(parseInt($(this).val()).formatMoney(0));
                });
                $(input[i]).trigger('change');
            }
        }
    }
};

function load_program_fee(element) {
    program_id = element.val();
    $('.b_' + element.attr('name')).remove();

    var form = element.parents('form');

    if (program_id === '' || $('#p-' + program_id).length > 0) {
        $('.i_discount').remove();
        $('.i_surcharge').remove();
        form.find('#table-invoice').parent().addClass('hide');
        return false;
    }

    var count = form.find('#table-invoice tbody').children('tr').length;
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'program/load_program_fee',
        async: false,
        data: {
            program_id: program_id,
            name: element.attr('name'),
            count: parseInt(count) + 1,
            object_id: form.find('#object_id').val()
        },
        error: function() {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function(resp) {

            //ßßif(resp != "1") {
                form.find('#table-invoice tbody').append(resp);
                $('.discount,.quantity, input[name=extra_discount], input[name=surcharge], select[name=event_id], select[name=deposit_invoice_id], select[name=free_hour], input[name=surcharge_special_hour]').change(function () {
                    calculate_price();
                });
                if (form.find('input[name=type]').val() == 'Học thử') {
                    var id = form.find('select[name=program_id] option:selected').val();
                    form.find('tr#p-' + id + ' input.quantity').val(0);
                }
                if (form.find('select[name=free_invoice_id]').length > 0) {
                    var selected = form.find('select[name=free_invoice_id] option:selected');
                    if (selected.val() != '') {
                        var products = new Array();
                        products = selected.attr('data-product').split('|');
                        for (p in products) {
                            form.find('tr#pp-' + products[p] + ' .quantity').val(0);
                        }
                    }
                }
                calculate_price();
                form.find("#table-invoice").parent().removeClass('hide');

        }
    });
    return false;
}

function load_free_invoice(element) {
    var form = element.parents('form');
    var selected = element.find('option:selected');
    form.find('select[name=program_id] option[value="' + selected.attr('data-program') + '"]').prop('selected', true);
    form.find('select[name=program_id]').trigger('change');
}

function load_paid_program(element) {
    load_paid_program_first_time = false;
    var form = element.parents('form');
    var selected = element.find('option:selected');
    form.find('select[name=program_id] option[value="' + selected.val() + '"]').prop('selected', true);
    form.find('select[name=program_id]').trigger('change');
}

function calculate_price() {
    var form = $('#table-invoice').parents('form');

    form.find('.i_discount').remove();
    form.find('.i_surcharge').remove();

    if (form.find('select[name=paid_program_id]').length > 0) {
        var selected = form.find('select[name=paid_program_id] option:selected');
        if (!load_paid_program_first_time && selected.val() != '') {
            $('.b_program_id').each(function() {
                $(this).find('.quantity').val(0);
            });
            load_paid_program_first_time = true;
        }
    }

    var sub_total = 0,
        discount = 0,
        total = 0,
        p_total = 0,
        surcharge = 0;

    form.find('.quantity').each(function() {
        var quantity = parseInt($(this).val());
        var sub_discount = parseInt($(this).parents("tr").find('.discount').val());
        var unit_price = parseFloat($(this).closest('tr').find('.unit_price').val());
        var sub_total_discount = Math.round((quantity * unit_price * sub_discount)/100);
        var price = quantity * unit_price;
        var tr = $(this).closest('tr');
        tr.find('.price').val(price - sub_total_discount);
        tr.find('.text_price').text((price - sub_total_discount).format());

        p_total += price - sub_total_discount;

        if (tr.next().hasClass('b_sub_total')) {
            tr.next().find('td:last').text(p_total.format());
            p_total = 0;
        }
        sub_total += price;
        discount += sub_total_discount;
    });

    if(discount > 0) {
        $('#table-invoice #discount').text(discount.format());
    }

    /*form.find('.discount').each(function() {
        var discount = parseInt($(this).val());
        var quantity = parseInt($(this).parent().find(".quantity").val());
        var unit_price = parseFloat($(this).closest('tr').find('.unit_price').val());
        var price = Math.round((quantity * unit_price * discount)/100);
        var tr = $(this).closest('tr');
        tr.find('.price').val(price);
        tr.find('.text_price').text(price.format());

        p_total += price;

        if (tr.next().hasClass('b_sub_total')) {
            tr.next().find('td:last').text(p_total.format());
            p_total = 0;
        }
        sub_total += price;
    });*/

    // phu thu
    sub_total = add_surcharge(form, sub_total);

    // giam tru
    sub_total = add_discount(form, sub_total);

    $('#table-invoice input[name=sub_total]').val(sub_total);
    $('#table-invoice #sub_total').text(sub_total.format());

    if (form.find('input[name=extra_discount]').length > 0) {
        discount = discount + parseFloat(form.find('input[name=extra_discount]').val());
    } else {
        $('#table-invoice #discount').parents('tr').removeClass('hide').addClass('hide');
    }

    $('#table-invoice input[name=discount]').val(discount);
    $('#table-invoice #discount').text(discount.format());

    if (form.find('input[name=surcharge]').length > 0) {
        surcharge = parseFloat(form.find('input[name=surcharge]').val());
        $('#surcharge').text(surcharge.format());
    } else {
        $('#table-invoice #surcharge').parents('tr').removeClass('hide').addClass('hide');
    }

    total = sub_total - discount + surcharge;

    $('#table-invoice input[name=total]').val(total);
    $('#table-invoice #total').text(total.format());

}

function add_more_program(element) {
    var target = element.parents('.form-group');
    var clone = target.clone();
    var new_name = generateUID();
    clone.find('.col-md-4').html('');
    clone.find('select').attr('name', new_name);
    clone.find('button').attr('onclick', 'remove_program_select($(this))');
    clone.find('button span').removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
    $('#more-program-content').append(clone);
}

function add_more_class(element) {
    var target = element.parents('.form-group');
    var clone = target.clone();
    var new_name = generateUID();
    clone.find('.col-md-4').html('');
    clone.find('select').attr('name', 'class_id[' + new_name + ']');
    clone.find('button').attr('onclick', '$(this).parents(".form-group").remove(); calculate_price();');
    clone.find('button span').removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
    $('#more-class-content').append(clone);
}

function remove_program_select(element) {
    var target = element.parents('.form-group');
    $('.b_' + target.find('select').attr('name')).remove();
    target.remove();
    calculate_price();
}

function generateUID() {
    return ("0000" + (Math.random() * Math.pow(36, 4) << 0).toString(36)).slice(-4);
}

function load_surcharge(element) {
    var selected = element.find('option:selected');
    var target = $('input[name=surcharge_special_hour]').parent().parent();
    if (selected.attr('data-special') == 1) {
        target.removeClass('hide');
    } else {
        target.addClass('hide');
    }
    calculate_price();
    reload_datepicker_student_signup();
}

function add_discount(form, sub_total) {
    var is_discount = false;
    var count = parseInt(form.find('#table-invoice tbody').children('tr').length) + 1;
    var html = '<tr class="i_discount"><td colspan="5"><strong>Giảm trừ</strong></td></tr>';
    var selected_program = form.find('select[name=program_id] option:selected');
    form.find('input[name=balance_money]').val(0);

    if (form.find('select[name=event_id]').length > 0) {
        var selected = form.find('select[name=event_id] option:selected');
        if (selected.val() != '') {
            var discount = parseFloat(selected.attr('data-discount')),
                discount_percent = parseInt(selected.attr('data-discount-percent'));
            // uu tien su dung so tien so voi %
            if (discount == 0 && discount_percent > 0) {
                discount = discount_percent / 100 * sub_total;
            }

            if (discount > 0) {
                html += load_html_discount(count, discount, selected, selected.text(), 3);
                is_discount = true;
                sub_total -= discount;
                count++;
            }
        }
    }

    if (form.find('select[name=deposit_invoice_id]').length > 0) {
        var selected = form.find('select[name=deposit_invoice_id] option:selected');
        if (selected.val() != '') {
            var discount = parseFloat(selected.attr('data-discount'));
            html += load_html_discount(count, discount, selected, 'Đặt cọc', 4);
            is_discount = true;
            sub_total -= discount;
            count++;
        }
    }

    if (form.find('select[name=free_hour]').length > 0) {
        var selected = form.find('select[name=free_hour] option:selected');
        if (selected.val() != '') {
            var total_time = selected_program.attr('data-totaltime');
            var hour = form.find('select[name=hour] option:selected').val();
            var free_hour = parseInt(selected.val()) * parseInt(hour);
            var discount = parseFloat(selected_program.attr('data-price')) / total_time * free_hour;
            html += load_html_discount(count, discount, selected, selected.val() + ' buổi học miễn phí', 5);
            is_discount = true;
            sub_total -= discount;
            count++;
        }
    }

    if (form.find('select[name=free_invoice_id]').length > 0) {
        var selected = form.find('select[name=free_invoice_id] option:selected');
        if (selected.val() != '') {
            var total_time = selected_program.attr('data-totaltime');
            var hour = form.find('select[name=hour] option:selected').val();
            var free_hour = parseInt(selected.attr('data-freehour')) * parseInt(hour);
            var discount = parseFloat(selected_program.attr('data-price')) / total_time * free_hour;
            html += load_html_discount(count, discount, selected, selected.attr('data-freehour') + ' buổi học miễn phí', 6);
            is_discount = true;
            sub_total -= discount;
            count++;
        }
    }

    if (form.find('input[name=student_money]').length > 0) {
        var selected = form.find('input[name=student_money]');
        if (selected.val() != '') {
            var discount = parseFloat(selected.attr('data-discount'));
            html += load_html_discount(count, discount, selected, 'Tiền tích lũy', 7);
            is_discount = true;
            sub_total -= discount;
            count++;

            if (sub_total < 0) {
                form.find('input[name=balance_money]').val(sub_total * -1);
                sub_total = 0;
            }
        }
    }

    if (sub_total != 0 && form.find('input[name="transfer_money[' + selected_program.val() + ']"]').length > 0) {
        var selected = form.find('input[name="transfer_money[' + selected_program.val() + ']"]');
        if (selected.val() != '') {
            var discount = parseFloat(selected.val());
            html += load_html_discount(count, discount, selected, 'Tiền được chuyển', 8);
            is_discount = true;
            sub_total -= discount;
            count++;

            if (sub_total < 0) {
                form.find('input[name=balance_money]').val(sub_total * -1);
                sub_total = 0;
            }
        }
    }

    if (is_discount) {
        form.find('#table-invoice tbody').append(html);
    }

    return sub_total;
}

function add_surcharge(form, sub_total) {
    var is_show = false;
    var count = parseInt(form.find('#table-invoice tbody').children('tr').length) + 1;
    var html = '<tr class="i_surcharge"><td colspan="4"><strong>Phụ thu</strong></td></tr>';
    var sum = 0;
    var selected = form.find('input[name=surcharge_special_hour]');

    if (!selected.parent().parent().hasClass('hide')) {
        if (parseInt(selected.val()) > 0) {
            var sum = parseFloat(form.find('input[name=special_hour]').val()) * parseInt(selected.val());
            sub_total += sum;
            html += load_html_surcharge(count, sum, 'Giờ vàng', 9);
            is_show = true;
        }
    }

    if (is_show) {
        form.find('#table-invoice tbody').append(html);
    }

    return sub_total;
}

function load_html_discount(count, discount, selected, text, type) {
    return '<tr class="i_discount"><td>' + text + '</td>'
        + '<td class="text-right">' + discount.format() + '</td>'
        + '<td>'
            + '<input name="invoice[' + count + '][quantity]" class="form-control quantity valid" value="1" readonly="" type="text">'
            + '<input name="invoice[' + count + '][object_id]" value="' + selected.val() + '" type="hidden">'
            + '<input name="invoice[' + count + '][name]" value="' + text + '" type="hidden">'
            + '<input name="invoice[' + count + '][unit_price]" class="unit_price" value="' + discount + '" type="hidden">'
            + '<input name="invoice[' + count + '][total]" class="price" value="' + discount + '" type="hidden">'
            + '<input name="invoice[' + count + '][type]" value="' + type + '" type="hidden">'
        + '</td>'
        + '<td></td>'
        + '<td class="text-right text_price">' + discount.format() + '</td></tr>';
}

function load_html_surcharge(count, price, text, type) {
    return '<tr class="i_surcharge"><td>' + text + '</td>'
        + '<td class="text-right">' + price.format() + '</td>'
        + '<td>'
            + '<input name="invoice[' + count + '][quantity]" class="form-control quantity valid" value="1" readonly="" type="text">'
            + '<input name="invoice[' + count + '][object_id]" value="" type="hidden">'
            + '<input name="invoice[' + count + '][name]" value="' + text + '" type="hidden">'
            + '<input name="invoice[' + count + '][unit_price]" class="unit_price" value="' + price + '" type="hidden">'
            + '<input name="invoice[' + count + '][total]" class="price" value="' + price + '" type="hidden">'
            + '<input name="invoice[' + count + '][type]" value="' + type + '" type="hidden">'
        + '</td>'
        + '<td></td>'
        + '<td class="text-right text_price">' + price.format() + '</td></tr>';
}

function load_invoice_action(student_id, branch_id, action) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'invoice/load_invoice_action',
        data: {
            student_id: student_id,
            branch_id: branch_id,
            action: action
        },
        beforeSend: function(xhr) {
            jQuery("#invoice_action form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function() {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function(resp) {
            jQuery("#invoice_action form").html(resp);
            handlePrice();
            reload_datepicker_invoice();
            $('#invoice_action').find('select[name=class_id]').on("change", function() {
                reload_datepicker_invoice();
            });
        }
    });
}

function save_invoice_action(element, is_print) {
    if ($("#invoice_action_form").valid()) {
        if (is_print) {
            $('#invoice_action_form').append('<input type="hidden" name="print_invoice" value="1"/>');
        };
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'invoice/save_invoice_add',
            data: $('#invoice_action_form').serialize(),
            dataType: 'json',
            beforeSend: function(xhr) {
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
            success: function(resp) {
                if (is_print) {
                    print_invoice(resp.id);
                }

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href;
                $.unblockUI();
                element.next().trigger('click');
            }
        });
    }
}

function print_invoice(id) {
    var _this = this,
        iframe_id = 'myPrintView',
        $iframe = $('#' + iframe_id);

    $iframe.attr('src', base_url + 'invoice/load_print/' + id);

    $iframe.load(function() {
        _this.callPrint(iframe_id);
    });
}

// initiates print once content has been loaded into iframe
function callPrint(iframe_id) {
    var element = document.getElementById(iframe_id);

    element.focus();

    element.contentWindow.print();
}

if ($('#invoice_list').length) {
    var invoice_list = $('#invoice_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "invoice/get_invoice_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function(aoData) {

            aoData.push({
                "name": "f_student_id",
                "value": $('#student_id').val()
            });

            aoData.push({
                "name": "f_class_id",
                "value": $('#class_id').val()
            });

            aoData.push({
                "name": "f_event_id",
                "value": $('#event_id').val()
            });

            aoData.push({
                "name": "f_from_date",
                "value": $('#from_date').val()
            });

            aoData.push({
                "name": "f_to_date",
                "value": $('#to_date').val()
            });

            aoData.push({
                "name": "f_search",
                "value": $('#search').val()
            });

        },
        "fnDrawCallback": function() {
            $(this).find('tbody tr').removeClass('odd').removeClass('even');
            $(this).next().attr('style', "display:none;");
            if ($(this).next().next().find('span a').length <= 1) {
                $(this).next().next().attr('style', "display:none;");
            } else {
                $(this).next().next().attr('style', "display:block;");
            }
        }
    });

    $("#search").on("keyup", function() {
        invoice_list.fnDraw();
    });

    $("#student_id").on("change", function() {
        invoice_list.fnDraw();
    });

    $("#class_id").on("change", function() {
        invoice_list.fnDraw();
    });

    $("#event_id").on("change", function() {
        invoice_list.fnDraw();
    });

    $("#from_date").on("change", function() {
        invoice_list.fnDraw();
    });

    $("#to_date").on("change", function() {
        invoice_list.fnDraw();
    });

}

function reload_datepicker_invoice() {
    if ($('#student_signup').length) {
        var form = $('#invoice_action_form');
        var is_first = true;
        var current = new Date();

        form.find('.datepicker').datepicker('remove');

        form.find('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            beforeShowDay: function(date) {
                var date_id = $('select[name=class_id]').find(":selected").attr('data');
                if (date_id == date.getDay()) {
                    if (is_first && date >= current) {
                        is_first = false;
                        current = date;
                    }
                    return true;
                }
                else return false;
            }
        });

        form.find('.datepicker').datepicker('setDate', current);
    }
}