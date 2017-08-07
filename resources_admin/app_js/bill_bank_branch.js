if($('#bill_group_branch_list').length){

    var bill_group_branch_list = $('#bill_group_branch_list').dataTable({

        "bProcessing": true,

        "bServerSide": true,

        "sPaginationType": "full_numbers",

        "sAjaxSource": base_url+"billbranchbank/get_bill_branch_list",

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

        bill_group_branch_list.fnDraw();

    });





    $("#center_id").on("change", function () {

        bill_group_branch_list.fnDraw();

    });



    $("#status").on("change", function () {

        bill_group_branch_list.fnDraw();

    });





}

if($('#bill_group_bank_list').length){

    var bill_group_bank_list = $('#bill_group_bank_list').dataTable({

        "bProcessing": true,

        "bServerSide": true,

        "sPaginationType": "full_numbers",

        "sAjaxSource": base_url+"billbranchbank/get_bill_bank_list",

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

        bill_group_bank_list.fnDraw();

    });





    $("#center_id").on("change", function () {

        bill_group_bank_list.fnDraw();

    });



    $("#status").on("change", function () {

        bill_group_bank_list.fnDraw();

    });





}
