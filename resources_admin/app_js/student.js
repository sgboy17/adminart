if ($('#student_list').length) {

    var student_list = $('#student_list').dataTable({

        "bProcessing": true,

        "bServerSide": true,

        "sPaginationType": "full_numbers",

        "sAjaxSource": base_url + "student/get_student_list",

        "bDeferRender": true,

        "bLengthChange": false,

        "bFilter": false,

        "bDestroy": true,

        "iDisplayLength": 20,

        "bSort": false,

        "fnServerParams": function(aoData) {





            aoData.push({

                "name": "f_search",

                "value": $('#search').val()

            });





            aoData.push({

                "name": "f_parent_type",

                "value": $('#parent_type').val()

            });



            aoData.push({

                "name": "f_status",

                "value": $('#status').val()

            });



            aoData.push({

                "name": "f_type",

                "value": $('#type').val()

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

        },

        "fnRowCallback": function(nRow, aData, iDisplayIndex) {

           if(iDisplayIndex%2 == 1) {

               $('td', nRow).parent().addClass('student-odd');

           }

        },

    });



    $("#search").on("keyup", function() {

        student_list.fnDraw();

    });





    $("#parent_type").on("change", function() {

        student_list.fnDraw();

    });



    $("#status").on("change", function() {

        student_list.fnDraw();

    });



    $("#type").on("change", function() {

        student_list.fnDraw();

    });







}


function get_all_student_list() {


    if ($('#all_student_list').length) {

        var all_student_list = $('#all_student_list').dataTable({

            "bProcessing": true,

            "bServerSide": true,

            "sPaginationType": "full_numbers",

            "sAjaxSource": base_url + "student/load_all_student_view",
            
            "bDeferRender": true,

            "bLengthChange": false,

            "bFilter": false,

            "bDestroy": true,

            "iDisplayLength": 20,

            "bSort": false,

            "fnServerParams": function(aoData) {



                aoData.push({

                    "name": "f_search",

                    "value": $('#all_search').val()

                });

                aoData.push({

                    "name": "f_branch_id",

                    "value": $('#all_branch_id').val()

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



        $("#all_search").on("keyup", function() {

            all_student_list.fnDraw();

        });



        $("#all_branch_id").on("change", function() {

            all_student_list.fnDraw();

        });

    }

}



function delete_branch_transfer(id) {

    if (confirm('Bạn có chắc muốn xoá yêu cầu này?')) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'action/delete_action',

            data: {

                id: id

            },

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

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;

                $.unblockUI();

            }

        });

    }

}



function delete_student(id) {

    if (confirm('Bạn có chắc muốn xoá dữ liệu này?')) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'student/delete_student',

            data: {

                id: id

            },

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

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;

                $.unblockUI();

            }

        });

    }

}





function validate_student_form() {

    $("#student_form").validate({

        ignore: null,

        ignore: 'input[type="hidden"]',

        rules: {



            created_at: {

                required: true,

            },



            updated_at: {

                required: true,

            },



            branch_id: {

                required: true,

            },



            status: {

                required: true,

            },


            name: {

                required: true,

            },



        },

        messages: {



            created_at: "Vui lòng điền ngày tạo!",



            updated_at: "Vui lòng điền ngày sửa!",



            branch_id: "Vui lòng điền trung tâm!",



            status: "Vui lòng chọn trạng thái!",


            name: "Vui lòng nhập tên!"

        }

    });



    reload_datepicker();

}





function load_student_add() {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_student_add',

        beforeSend: function(xhr) {

            jQuery("#student_detail #student_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_detail #student_form").html(resp);

            validate_student_form();

        }

    });

}



function load_student_edit(id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_student_edit',

        data: {

            id: id,

        },

        beforeSend: function(xhr) {

            jQuery("#student_detail #student_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_detail #student_form").html(resp);

            validate_student_form();

        }

    });

}



function save_student_add(element) {

    if ($("#student_form").valid()) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'student/save_student_add',

            data: $('#student_form').serialize(),

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

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;

                $.unblockUI();
                //
                element.next().trigger('click');

            }

        });

    }

}



function save_student_edit(element) {

    if ($("#student_form").valid()) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'student/save_student_edit',

            data: $('#student_form').serialize(),

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

        $('.datepicker').datepicker({

            format: 'dd/mm/yyyy',

            autoclose: true

        });

    }

}



function reload_datepicker_student_signup() {

    if ($('#student_signup').length) {

        var form = $('#student_action_form');

        var selected = [];

        var is_first = true;

        var current = new Date();



        form.find('.datepicker').datepicker('remove');



        form.find('select[name*=class_id]').each(function(index) {

            var date_id = $(this).find('option:selected').attr('data');

            selected.push(parseInt(date_id));

        });



        form.find('.datepicker').datepicker({

            format: 'dd/mm/yyyy',

            autoclose: true,

            beforeShowDay: function(date) {

                if ($.inArray(date.getDay(), selected) != -1) {

                    if (is_first && date >= current) {

                        is_first = false;

                        current = date;

                    }

                    return true;

                }

                else return false;

            }

        });



        form.find('.datepicker').datepicker('update', current);

    }

}



function validate_student_action_form() {

    $("#student_action_form").validate({

        ignore: null,

        ignore: 'input[type="hidden"]',

        rules: {



            branch_id: {

                required: true

            },



            date_start: {

                required: true

            },



            date_end: {

                required: true

            },



        },

        messages: {



            branch_id: "Vui lòng điền trung tâm!",

            date_start: "Vui lòng chọn ngày!",

            date_end: "Vui lòng chọn ngày!",



        }

    });

    reload_datepicker_student_signup();

}



function load_student_action(id, branch_id, action, student_class_id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student_action',

        data: {

            id: id,

            branch_id: branch_id,

            action: action,

            student_class_id: student_class_id

        },

        beforeSend: function(xhr) {

            jQuery("#student_action #student_action_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_action .modal-dialog").attr('style', '');



            if (action == 'Đăng ký mới' || action == 'Đăng ký học tiếp') {

                jQuery("#student_action .modal-dialog").attr('style', 'width: 95%;');

            }



            jQuery("#student_action #student_action_form").html(resp);



            if (action == 'Lên lớp') {

                $('#btn_save_print').show();

            }



            validate_student_action_form();



            handlePrice();

        }

    });

}



function save_student_action(element, is_print) {

    if ($("#student_action_form").valid()) {

        if (is_print) {

            $('#student_action_form').append('<input type="hidden" name="print_invoice" value="1"/>');

        };

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'action/save_action_add',

            data: $('#student_action_form').serialize(),

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



                $.unblockUI();

                element.next().trigger('click');



                if(resp.action == "Gia hạn") {

                    alert("Bạn đã gia hạn buổi cho chương trình thành công!");

                }

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;





            }

        });

    }

}



function load_student_schedule(student_class_id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'studentschedule/load_student_schedule',

        data: {

            student_class_id: student_class_id

        },

        beforeSend: function(xhr) {

            jQuery("#student_schedule #student_schedule_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_schedule #student_schedule_form").html(resp);



        }

    });

}



function load_student_history(student_id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_student_history',

        data: {

            student_id: student_id

        },

        beforeSend: function(xhr) {

            jQuery("#student_history #student_history_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            //window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_history #student_history_form").html(resp);

        }

    });

}



function load_student_branch_transfer() {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_student_branch_transfer',

        beforeSend: function(xhr) {

            jQuery("#student_branch_transfer #student_branch_transfer_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            //window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#student_branch_transfer #student_branch_transfer_form").html(resp);

        }

    });

}



function load_all_student_branch() {

    jQuery.ajax({

        type: 'POST',
        async: false,
        url: base_url + 'student/load_all_student_branch',

        beforeSend: function(xhr) {

            jQuery("#all_student_branch #all_student_branch_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            //window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#all_student_branch #all_student_branch_form").html(resp);

            get_all_student_list();

        }

    });

}



function load_transfer_friend(student_id, branch_id, program_id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_transfer_friend',

        data: {

            student_id: student_id,

            branch_id: branch_id,

            program_id: program_id

        },

        beforeSend: function(xhr) {

            jQuery("#transfer_friend #transfer_friend_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            //window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#transfer_friend #transfer_friend_form").html(resp);

        }

    });

}



function load_branch_change(student_id) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/load_branch_change',

        data: {

            student_id: student_id

        },

        beforeSend: function(xhr) {

            jQuery("#student_history #student_history_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            //window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#branch_change #branch_change_form").html(resp);

        }

    });

}





function check_special_hour(from, to, change_class) {

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'student/check_special_hour',

        data: {

            from: from,

            to: to,

            change_class: change_class,

        },

        beforeSend: function(xhr) {

            $.blockUI({

                css: {

                    border: 'none',

                    padding: '15px',

                    backgroundColor: '#000',

                    '-webkit-border-radius': '10px',

                    '-moz-border-radius': '10px',

                    opacity: .5,

                    color: '#fff',

                }

            });

        },

        success: function(resp) {

            var parsed = JSON.parse(resp);

            if (parsed.hour > 0) {

                $('#extra_container').show();

                $('#btn_save_print').show();



                $('#btn_container').html('<a class="btn btn-info" onclick="save_student_action($(this), true)">Lưu và In</a>');

                $('#lbl_extra').html(parsed.show_money);

                $('#extra_hour').val(parsed.hour);

                $('#extra_price').val(parsed.money);



            } else {

                $('#extra_container').hide();

                $('#btn_save_print').hide();

                $('#btn_container').html("");

                $('#lbl_extra').html("");

                $('#extra_hour').val("");

                $('#extra_price').val("");

            }

            $.unblockUI();

        }

    });

}



function load_change_schedule(student_class_id, date) {

    $("#student_schedule").modal('hide');

    jQuery.ajax({

        type: 'POST',

        url: base_url + 'studentschedule/load_change_schedule',

        data: {

            student_class_id: student_class_id,

            date: date

        },

        beforeSend: function(xhr) {

            $("#change_schedule").modal('show');

            jQuery("#change_schedule #change_schedule_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

        },

        error: function() {

            alert('Can\'t connect to server!');

            window.location = document.URL;

        },

        success: function(resp) {

            jQuery("#change_schedule #change_schedule_form").html(resp);



            var min = new Date($('input[name=from_date]').attr('data-value'));

            $('.to-datepicker').datepicker({

                autoclose: true,

                format: 'dd/mm/yyyy',

                //startDate: min

            }).on('changeDate', function(event) {

                event.preventDefault();

                jQuery.ajax({

                    type: 'POST',

                    url: base_url + 'classc/load_class_by_date',

                    data: {

                        date: $('.to-datepicker').val(),

                        class_id: $('#change_schedule #change_schedule_form input[name=class_id]').val()

                    },

                    success: function(resp) {

                        jQuery("#change_schedule #change_schedule_form select[name=class_id]").html(resp);

                    }

                });

            });



            $("#change_schedule_form").validate({

                ignore: null,

                ignore: 'input[type="hidden"]',

                rules: {

                    date_from: {

                        required: true

                    },

                    date_to: {

                        required: true

                    },

                    class_id: {

                        required: true

                    }

                },

                messages: {

                    date_from: "Vui lòng chọn ngày!",

                    date_to: "Vui lòng chọn ngày!",

                    class_id: "Vui lòng chọn lớp!"

                }

            });

        }

    });

}



function save_change_schedule(element, is_print) {

    if ($("#change_schedule_form").valid()) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'studentschedule/save_change_schedule',

            data: $('#change_schedule_form').serialize(),

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

                    print_invoice(resp);

                }

                $.unblockUI();

                element.next().trigger('click');

            }

        });

    }

}



function save_student_branch_transfer(element, id, type) {

    if (confirm('Bạn có chắc muốn thực hiện thao tác này?')) {

        if ($("#student_branch_transfer_form").valid()) {

            jQuery.ajax({

                type: 'POST',

                url: base_url + 'student/save_student_branch_transfer',

                data: {

                    id: id,

                    type: type

                },

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

                    $.unblockUI();

                    element.parent().parent().remove();

                }

            });

        }

    }

}



function save_transfer_friend(element) {

    if ($("#transfer_friend_form").valid()) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'action/save_transfer_friend',

            data: $('#transfer_friend_form').serialize(),

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



                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;



                $.unblockUI();

                element.next().trigger('click');

            }

        });

    }

}



function save_branch_change(element) {

    if ($("#branch_change_form").valid()) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'action/save_branch_change',

            data: $('#branch_change_form').serialize(),

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

                //load_invoice_action(resp.student_id,resp.branch_id,resp.action);

                //$('#invoice_action').modal();

                //load_invoice_action('dfd6ad1b-7f2e-4ab3-9a10-b5cb698d8c85',4, 'Chuyển trung tâm')

                $.unblockUI();

                element.next().trigger('click');

            }

        });

    }

}





function printDiv(divID) {



    $("#student_schedule").hide();

    $(".modal-backdrop").hide();



    //Get the HTML of div

    var divElements = document.getElementById(divID).innerHTML;

    //Get the HTML of whole page

    var oldPage = document.body.innerHTML;



    //Reset the page's HTML with div's HTML only

    document.body.innerHTML =

        "<html><head><title></title></head><body>" +

        divElements + "</body>";

    //Print Page

    window.print();

    window.close();

    document.location.href = document.location.href;





}


function add_note(id) {

    jQuery.ajax({
        type: 'POST',
        url: base_url + 'student/load_student_add_note',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#note_detail #student_note_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function() {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function(resp) {
            jQuery("#note_detail #student_note_form").html(resp);
            //validate_student_form();
            handleUpload();
        }
    });
}

function save_student_add_note(element){
    if($("#student_note_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'student/save_student_add_note',
           data:$('#student_note_form').serialize(),
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
                element.next().trigger('click');
            }
        });   
    }
}

function view_note(id) {

    jQuery.ajax({
        type: 'POST',
        async: false,
        url: base_url + 'student/load_student_view_note',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#note_detail #student_note_form").html('<div align="branch" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error: function() {
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success: function(resp) {
            jQuery("#note_detail #student_note_form").html(resp);
            //validate_student_form();
            //handleUpload();
            get_student_note_list(id);

        }
    });
}

function get_student_note_list (id) {
    
   
    if ($('#student_note_list').length) {
        var student_note_list = $('#student_note_list').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": base_url + "student/load_student_note_list",
            "bDeferRender": true,
            "bLengthChange": false,
            "bFilter": false,
            "bDestroy": true,
            "iDisplayLength": 4,
            "bSort": false,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "id",
                    "value": id
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
    }
}


/*function save_print_invoice(element) {

    if ($("#student_action_form").valid()) {

        $('#student_action_form').append('<input type="hidden" name="print_invoice" value="1"/>');

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'action/save_action_add',

            data: $('#student_action_form').serialize(),

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

                if ($('.paginate_active').length) $('.paginate_active').trigger('click');

                else document.location.href = document.location.href;

                $.unblockUI();



                print_invoice(resp.id);



                element.next().next().trigger('click');

            }

        });

    }

}*/