if ($('#action_list').length) {
    var action_list = $('#action_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "action/get_action_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function (aoData) {


            aoData.push({"name": "f_center_id", "value": $('#center_id').val()});


        },
        "fnDrawCallback": function () {
            $(this).find('tbody tr').removeClass('odd').removeClass('even');
            $(this).next().attr('style', "display:none;");
            if ($(this).next().next().find('span a').length <= 1) {
                $(this).next().next().attr('style', "display:none;");
            } else {
                $(this).next().next().attr('style', "display:block;");
            }
        }
    });


    $("#center_id").on("change", function () {
        action_list.fnDraw();
    });


}

function delete_action(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'action/delete_action',
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


function validate_action_form() {
    $("#action_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            center_id: {
                required: true,
            },

            object_id: {
                required: true,
            },

            action: {
                required: true,
            },

            created_at: {
                required: true,
            },

        },
        messages: {

            center_id: "Vui lòng điền trung tâm!",

            object_id: "Vui lòng điền object!",

            action: "Vui lòng điền thao tác!",

            created_at: "Vui lòng điền tạo ngày!",

        }
    });
}


function load_action_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'action/load_action_add',
        beforeSend: function (xhr) {
            jQuery("#action_detail #action_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#action_detail #action_form").html(resp);
            validate_action_form();
        }
    });
}

function load_action_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'action/load_action_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#action_detail #action_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#action_detail #action_form").html(resp);
            validate_action_form();
        }
    });
}

function save_action_add(element) {
    if ($("#action_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'action/save_action_add',
            data: $('#action_form').serialize(),
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

function save_action_edit(element) {
    if ($("#action_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'action/save_action_edit',
            data: $('#action_form').serialize(),
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
