if ($('#event_list').length) {
    var event_list = $('#event_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "event/get_event_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function (aoData) {


            aoData.push({"name": "f_search", "value": $('#search').val()});


            aoData.push({"name": "f_branch_id", "value": $('#branch_id').val()});


        },
        "fnDrawCallback": function () {
             $(this).find('tbody tr').removeClass('odd').removeClass('even');
                $(this).next().attr('style',"display:none;");
                if($(this).next().next().find('span a').length<=1){
                    $(this).next().next().attr('style',"display:none;");
                } else {
                    $(this).next().next().attr('style',"display:block;");
                }

                if($('.check_all').length){
                    $('.check_all').on('click', function(){
                        if(!$('.check_all').prop('checked')){
                            $('.id:checked').trigger('click');
                        }else{
                            $('.id:not(.id:checked)').trigger('click');
                        }
                    });
                }
                handleUniform();
        }
    });


    $("#search").on("keyup", function () {
        event_list.fnDraw();
    });


    $("#branch_id").on("change", function () {
        event_list.fnDraw();
    });


}



function delete_event_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'event/delete_event',
            data: {
                id: id
            },
            beforeSend: function(xhr) {
                $.blockUI({css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }});
            },
            success:function(resp){
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });
    }
}

function delete_event(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'event/delete_event',
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


function validate_event_form() {
    $("#event_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            branch_id: {
                required: true
            },

            name: {
                required: true
            },

            date_from: {
                required: true
            },

            date_end: {
                required: true
            },

            discount: {
                required: true
            }

            //created_at: {
            //    required: true,
            //},

            //updated_at: {
            //    required: true,
            //},

        },
        messages: {

            branch_id: "Vui lòng điền trung tâm!",

            name: "Vui lòng điền tên sự kiện!",

            date_from: "Vui lòng điền ngày bắt đầu!",

            date_end: "Vui lòng điền ngày kết thúc!",

            discount: "Vui lòng điền chiết khấu!"

            //created_at: "Vui lòng điền ngày tạo!",

            //updated_at: "Vui lòng điền ngày sửa!",

        }
    });
    reload_datepicker();
}


function load_event_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'event/load_event_add',
        beforeSend: function (xhr) {
            jQuery("#event_detail #event_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#event_detail #event_form").html(resp);
            validate_event_form();
        }
    });
}

function load_event_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'event/load_event_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#event_detail #event_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#event_detail #event_form").html(resp);
            validate_event_form();
        }
    });
}

function save_event_add(element) {
    if ($("#event_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'event/save_event_add',
            data: $('#event_form').serialize(),
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

function save_event_edit(element) {
    if ($("#event_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'event/save_event_edit',
            data: $('#event_form').serialize(),
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

function reload_datepicker() {
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});
    }
}