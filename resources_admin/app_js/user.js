if($('#user_list').length) {
    var user_list = $('#user_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "user/get_user_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function (aoData) {


            aoData.push({"name": "f_search", "value": $('#search').val()});


            aoData.push({"name": "f_user_group_id", "value": $('#user_group_id').val()});

            aoData.push({"name": "f_employee_id", "value": $('#employee_id').val()});

            aoData.push({"name": "f_branch_id", "value": $('#branch_id').val()});

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
        user_list.fnDraw();
    });


    $("#user_group_id").on("change", function () {
        user_list.fnDraw();
    });

    $("#employee_id").on("change", function () {
        user_list.fnDraw();
    });

    $("#branch_id").on("change", function () {
        user_list.fnDraw();
    });

    $("#status").on("change", function () {
        user_list.fnDraw();
    });


}

function delete_user_multiple() {
    if (confirm('Bạn có chắc muốn xoá những dữ liệu này?')) {
        var id_checkbox = $('.id:checked');
        var id = '';
        for (var i = 0; i < id_checkbox.length; i++) {
            if (i != id_checkbox.length - 1) id += $(id_checkbox[i]).val() + ',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'user/delete_user',
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

function delete_user(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'user/delete_user',
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


function validate_user_form() {
    handleUniform();
    $("#user_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            user_group_id: {
                required: true,
            },

            employee_id: {
                required: true,
            },

            status: {
                required: true,
            },

        },
        messages: {

            user_group_id: "Vui lòng điền nhóm người dùng!",

            employee_id: "Vui lòng điền nhân viên!",

            status: "Vui lòng điền tình trạng!",

        }
    });
}


function load_user_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'user/load_user_add',
        beforeSend: function (xhr) {
            jQuery("#user_detail #user_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#user_detail #user_form").html(resp);
            validate_user_form();
        }
    });
}

function load_user_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'user/load_user_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#user_detail #user_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#user_detail #user_form").html(resp);
            validate_user_form();
        }
    });
}

function save_user_add(element) {
    if ($("#user_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'user/save_user_add',
            data: $('#user_form').serialize(),
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
                $('label.error').remove();
                if (parseInt(resp) == 30) {
                    $('<label for="username" generated="true" class="error">Tên đăng nhập này đã được sử dụng!</label>').insertAfter($('#username'));
                    $.unblockUI();
                } else {
                    if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                    else document.location.href = document.location.href;
                    $.unblockUI();
                    element.next().trigger('click');
                }
            }
        });
    }
}

function save_user_edit(element) {
    if ($("#user_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'user/save_user_edit',
            data: $('#user_form').serialize(),
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
                $('label.error').remove();
                if (parseInt(resp) == 30) {
                    $('<label for="username" generated="true" class="error">Tên đăng nhập này đã được sử dụng!</label>').insertAfter($('#username'));
                    $.unblockUI();
                } else {
                    if ($('.paginate_active').length) $('.paginate_active').trigger('click');
                    else document.location.href = document.location.href;
                    $.unblockUI();
                    element.next().trigger('click');
                }
            }
        });
    }
}
