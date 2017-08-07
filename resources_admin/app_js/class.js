if ($('#class_list').length) {    var class_list = $('#class_list').dataTable({        "bProcessing": true,        "bServerSide": true,        "sPaginationType": "full_numbers",        "sAjaxSource": base_url + "classc/get_class_list",        "bDeferRender": true,        "bLengthChange": false,        "bFilter": false,        "bDestroy": true,        "iDisplayLength": 20,        "bSort": false,        "fnServerParams": function (aoData) {            aoData.push({"name": "f_search", "value": $('#search').val()});            aoData.push({"name": "f_center_id", "value": $('#center_id').val()});            aoData.push({"name": "f_program_id", "value": $('#program_id').val()});            aoData.push({"name": "f_teacher_id", "value": $('#teacher_id').val()});            aoData.push({"name": "f_status", "value": $('#status').val()});        },        "fnDrawCallback": function () {            $(this).find('tbody tr').removeClass('odd').removeClass('even');            $(this).next().attr('style', "display:none;");            if ($(this).next().next().find('span a').length <= 1) {                $(this).next().next().attr('style', "display:none;");            } else {                $(this).next().next().attr('style', "display:block;");            }            if ($('.check_all').length) {                $('.check_all').on('click', function () {                    if (!$('.check_all').prop('checked')) {                        $('.id:checked').trigger('click');                    } else {                        $('.id:not(.id:checked)').trigger('click');                    }                });            }            handleUniform();        }    });    $("#search").on("keyup", function () {        class_list.fnDraw();    });    $("#center_id").on("change", function () {        class_list.fnDraw();    });    $("#program_id").on("change", function () {        class_list.fnDraw();    });    $("#teacher_id").on("change", function () {        class_list.fnDraw();    });    $("#status").on("change", function () {        class_list.fnDraw();    });    handleImport();}function delete_class_multiple() {    if (confirm('Bạn có chắc muốn xoá những dữ liệu này?')) {        var id_checkbox = $('.id:checked');        var id = '';        for (var i = 0; i < id_checkbox.length; i++) {            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';            else id += $(id_checkbox[i]).val();        }        jQuery.ajax({            type: 'POST',            url: base_url + 'classc/delete_class',            data: {                id: id            },            beforeSend: function (xhr) {                $.blockUI({                    css: {                        border: 'none',                        padding: '15px',                        backgroundColor: '#000',                        '-webkit-border-radius': '10px',                        '-moz-border-radius': '10px',                        opacity: .5,                        color: '#fff'                    }                });            },            success: function (resp) {                if ($('.paginate_active').length) $('.paginate_active').trigger('click');                else document.location.href = document.location.href;                $.unblockUI();            }        });    }}function delete_class(id) {    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {        jQuery.ajax({            type: 'POST',            url: base_url + 'classc/delete_class',            data: {                id: id            },            beforeSend: function (xhr) {                $.blockUI({                    css: {                        border: 'none',                        padding: '15px',                        backgroundColor: '#000',                        '-webkit-border-radius': '10px',                        '-moz-border-radius': '10px',                        opacity: .5,                        color: '#fff'                    }                });            },            success: function (resp) {                if ($('.paginate_active').length) $('.paginate_active').trigger('click');                else document.location.href = document.location.href;                $.unblockUI();            }        });    }}function validate_class_form() {    $("#class_form").validate({        ignore: null,        ignore: 'input[type="hidden"]',        rules: {            teacher_id: {                required: true            },            class_code: {                required: true            },            status: {                required: true            }        },        messages: {            teacher_id: "Vui lòng điền giáo viên!",            class_code: "Vui lòng điền mã lớp!",            status: "Vui lòng điền trạng thái!",        }    });}function load_class_add() {    jQuery.ajax({        type: 'POST',        url: base_url + 'classc/load_class_add',        beforeSend: function (xhr) {            jQuery("#class_detail #class_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');        },        error: function () {            alert('Can\'t connect to server!');            window.location = document.URL;        },        success: function (resp) {            jQuery("#class_detail #class_form").html(resp);            module_load_class_hour_add();            validate_class_form();            $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});            $('.timepicker').timepicker({                autoclose: true,                minuteStep: 30            });            $(".flag-update-info").change(function () {                load_info();            });        }    });}function load_class_edit(id) {    jQuery.ajax({        type: 'POST',        url: base_url + 'classc/load_class_edit',        data: {            id: id,        },        beforeSend: function (xhr) {            jQuery("#class_detail #class_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');        },        error: function () {            alert('Can\'t connect to server!');            window.location = document.URL;        },        success: function (resp) {            jQuery("#class_detail #class_form").html(resp);            validate_class_form();            $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});            $('.timepicker').timepicker({                autoclose: true,                minuteStep: 30            });            $(".flag-update-info").change(function () {                load_info();            });        }    });}function load_info() {    /*jQuery.ajax({        type: 'POST',        url: base_url + 'classc/load_expired_date',        data: $('#class_form').find('input, select').not(':hidden').serializeArray(),        beforeSend: function (xhr) {            jQuery("#class_detail #class_form .expired-date").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');        },        error: function () {            alert('Can\'t connect to server!');            window.location = document.URL;        },        success: function (resp) {            //jQuery("#class_detail #class_form .expired-date").html(resp);            validate_class_form();            $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});        }    });*/}function save_class_add(element) {    if ($("#class_form").valid()) {        jQuery.ajax({            type: 'POST',            url: base_url + 'classc/save_class_add',            data: $('#class_form').find('input, select, textarea').not(':hidden').serialize(),            beforeSend: function (xhr) {                $.blockUI({                    css: {                        border: 'none',                        padding: '15px',                        backgroundColor: '#000',                        '-webkit-border-radius': '10px',                        '-moz-border-radius': '10px',                        opacity: .5,                        color: '#fff'                    }                });            },            success: function (resp) {                $('label.error').remove();                if (parseInt(resp) == 20) {                    $('<label for="class_code" generated="true" class="error">Mã lớp này đã được sử dụng!</label>').insertAfter($('#class_code'));                    $.unblockUI();                } else {                    if ($('.paginate_active').length) $('.paginate_active').trigger('click');                    else document.location.href = document.location.href;                    $.unblockUI();                    element.next().trigger('click');                }            }        });    }}function save_class_edit(element) {    if ($("#class_form").valid()) {        jQuery.ajax({            type: 'POST',            url: base_url + 'classc/save_class_edit',            data: $('#class_form').serialize(),            beforeSend: function (xhr) {                $.blockUI({                    css: {                        border: 'none',                        padding: '15px',                        backgroundColor: '#000',                        '-webkit-border-radius': '10px',                        '-moz-border-radius': '10px',                        opacity: .5,                        color: '#fff'                    }                });            },            success: function (resp) {                $('label.error').remove();                if (parseInt(resp) == 20) {                    $('<label for="class_code" generated="true" class="error">Mã lớp này đã được sử dụng!</label>').insertAfter($('#class_code'));                    $.unblockUI();                } else {                    if ($('.paginate_active').length) $('.paginate_active').trigger('click');                    else document.location.href = document.location.href;                    $.unblockUI();                    element.next().trigger('click');                }            }        });    }}function module_load_class_hour_add() {    var html = $('#class_hour_template').html();    $('<div class="row">' + html + '</div>').insertBefore('#class_hour_template');    $('.tooltips').tooltip();    $('.tooltips').focus(function () {        $(".tooltip").remove();    });    $('.timepicker').timepicker({        autoclose: true,        minuteStep: 30    });    $(".flag-update-info").change(function () {        load_info();    });    load_info();}function module_delete_class_hour(element) {    element.parent().parent().remove();    load_info();}$(".flag-update-info").change(function () {    load_info();});function load_class_attendance(id,student_class_id) {    jQuery.ajax({        type: 'POST',        url: base_url + 'classc/load_class_attendance',        data: {            id: id,            student_class_id:student_class_id        },        beforeSend: function (xhr) {            jQuery("#class_attendance #class_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');        },        error: function () {            alert('Can\'t connect to server!');            window.location = document.URL;        },        success: function (resp) {            jQuery("#class_attendance #class_form").html(resp);        }    });}function save_student_schedule(element, class_hour_id, student_id, date, hour) {    var data = {        class_hour_id: class_hour_id,        student_id: student_id,        date: date,        hour: hour    };    var url = '';    if (element.checked) {        url = base_url + 'studentschedule/save_student_schedule_add';        if (element.value != '') {            url = base_url + 'studentschedule/save_student_schedule_edit';            data = {                id: element.value,                undelete: true            }        }    } else {        url = base_url + 'studentschedule/delete_student_schedule';        data = {            id: element.value        }    }    jQuery.ajax({        type: 'POST',        url: url,        data: data,        dataType: 'json',        beforeSend: function (xhr) {            $.blockUI({                css: {                    border: 'none',                    padding: '15px',                    backgroundColor: '#000',                    '-webkit-border-radius': '10px',                    '-moz-border-radius': '10px',                    opacity: .5,                    color: '#fff'                }            });        },        success: function (resp) {            if (resp && resp.id) {                element.value = resp.id;            }            $.unblockUI();        }    });}