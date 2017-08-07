if ($('#date_off_list').length) {
    var date_off_list = $('#date_off_list').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": base_url + "dateoff/get_date_off_list",
        "bDeferRender": true,
        "bLengthChange": false,
        "bFilter": false,
        "bDestroy": true,
        "iDisplayLength": 20,
        "bSort": false,
        "fnServerParams": function (aoData) {

            aoData.push( { "name": "f_search", "value": $('#search').val() } );

            aoData.push({"name": "f_branch_id", "value": $('#branch_id').val()});

            aoData.push({"name": "f_status", "value": $('#status').val()});


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
        date_off_list.fnDraw(); 
    });

    $("#branch_id").on("change", function () {
        date_off_list.fnDraw();
    });

    $("#status").on("change", function () {
        date_off_list.fnDraw();
    });


}

function delete_date_off_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'dateoff/delete_date_off',
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

function delete_date_off(id) {
    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'dateoff/delete_date_off',
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


function validate_date_off_form() {
    $("#date_off_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {

            branch_id: {
                required: true
            },

            date: {
                required: true
            },

            status: {
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

            date: "Vui lòng điền ngày nghỉ!",

            status: "Vui lòng điền tình trạng!",

            //created_at: "Vui lòng điền ngày tạo!",

            //updated_at: "Vui lòng điền ngày sửa!"

        }
    });
    reload_datepicker();
}


function load_date_off_add() {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'dateoff/load_date_off_add',
        beforeSend: function (xhr) {
            jQuery("#date_off_detail #date_off_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#date_off_detail #date_off_form").html(resp);
            validate_date_off_form();
        }
    });
}

function load_date_off_edit(id) {
    jQuery.ajax({
        type: 'POST',
        url: base_url + 'dateoff/load_date_off_edit',
        data: {
            id: id,
        },
        beforeSend: function (xhr) {
            jQuery("#date_off_detail #date_off_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function () {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function (resp) {
            jQuery("#date_off_detail #date_off_form").html(resp);
            validate_date_off_form();
        }
    });
}

function save_date_off_add(element) {
    if ($("#date_off_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'dateoff/save_date_off_add',
            data: $('#date_off_form').serialize(),
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

function save_date_off_edit(element) {
    if ($("#date_off_form").valid()) {
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'dateoff/save_date_off_edit',
            data: $('#date_off_form').serialize(),
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
