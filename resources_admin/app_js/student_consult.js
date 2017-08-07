if($('#student_consult_list').length){

    var student_consult_list = $('#student_consult_list').dataTable({

        "bProcessing": true,

        "bServerSide": true,

        "sPaginationType": "full_numbers",

        "sAjaxSource": base_url+"studentconsult/get_student_consult_list/" + id_url,

        "bDeferRender": true,

        "bLengthChange": false,

        "bFilter": false,

        "bDestroy": true,

        "iDisplayLength": 20,

        "bSort": false,

        "fnServerParams": function ( aoData ) {



            aoData.push( { "name": "f_search", "value": $('#search').val() } );



            aoData.push( { "name": "f_status", "value": $('#status').val() } );



        },

        "fnDrawCallback":function(){

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

            // handleUniform();



        }

    });







    $("#search").on("keyup", function () {

        student_consult_list.fnDraw();

    });





    $("#center_id").on("change", function () {

        student_consult_list.fnDraw();

    });



    $("#status").on("change", function () {

        student_consult_list.fnDraw();

    });


    function load_student_consult_detail(id) {

        jQuery.ajax({

            type: 'POST',

            url: base_url + 'studentconsult/load_student_consult_detail',

            data: {

                id: id

            },

            beforeSend: function (xhr) {

                jQuery("#student_consult_detail #student_consult_form").html('<div align="center" style="margin: 10px;"><img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" /></div>');

            },

            error: function () {

                alert('Can\'t connect to server!');

                window.location = document.URL;

            },

            success: function (resp) {

                jQuery("#student_consult_detail #student_consult_form").html(resp);

                validate_class_form();

                $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});

                $('.timepicker').timepicker({

                    autoclose: true,

                    minuteStep: 30

                });

                $(".flag-update-info").change(function () {

                    load_info();

                });

            }

        });

    }




}
