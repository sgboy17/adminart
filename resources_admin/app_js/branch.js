if($('#branch_list').length){

	var branch_list = $('#branch_list').dataTable({

		    "bProcessing": true,

		    "bServerSide": true,

		    "sPaginationType": "full_numbers",

		    "sAjaxSource": base_url+"branch/get_branch_list",

		    "bDeferRender": true,

		    "bLengthChange": false,

		    "bFilter": false,

		    "bDestroy": true,

	    	"iDisplayLength": 20,

		    "bSort": false,

	         "fnServerParams": function ( aoData ) {

                    

            aoData.push( { "name": "f_search", "value": $('#search').val() } );

        

            aoData.push( { "name": "f_store_id", "value": $('#store_id').val() } );

                

            aoData.push( { "name": "f_branch_type_id", "value": $('#branch_type_id').val() } );

                

            aoData.push( { "name": "f_employee_id", "value": $('#employee_id').val() } );

                

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

                handleUniform();

	        }

		});



    

            

     $("#search").on("keyup", function () {

        branch_list.fnDraw(); 

    });

        

            

     $("#store_id").on("change", function () {

        branch_list.fnDraw(); 

    });

                

     $("#branch_type_id").on("change", function () {

        branch_list.fnDraw(); 

    });

                

     $("#employee_id").on("change", function () {

        branch_list.fnDraw(); 

    });

     

     $("#status").on("change", function () {

        branch_list.fnDraw(); 

    });

                

        

}





function validate_branch_form(){
    $("#branch_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            },
            branch_type_id: {
                required: true,
            },
            employee_id: {
                required: true,
            },
            special_hour: {
                number: true,
            },
            fee_change_branch: {
                number: true,
            },
            fee_change_hour: {
                number: true,
            },
            country_id: {
                required: true,
            },
            city_id: {
                required: true,
            },
            district_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            name: "Vui lòng điền tên chi nhánh!",
            branch_type_id: "Vui lòng điền loại chi nhánh!",
            employee_id: "Vui lòng điền nhân viên!",
            country_id: "Vui lòng điền quốc gia!",
            city_id: "Vui lòng điền thành phố!",
            district_id: "Vui lòng điền quận huyện!",
            status: "Vui lòng điền tình trạng!",
        }
    });
    handleLocation();
    handleUniform();
}

function load_branch_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'branch/load_branch_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#branch_detail #branch_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#branch_detail #branch_form").html(resp);
            validate_branch_form();
        }
    });  
}

function save_branch_edit(element){
    if($("#branch_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'branch/save_branch_edit',
           data:$('#branch_form').serialize(),
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


function load_branch_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'branch/load_branch_add',
        beforeSend: function(xhr) {
            jQuery("#branch_detail #branch_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#branch_detail #branch_form").html(resp);
            validate_user_form();
        }
    });  
}

function save_branch_add(element){
    if($("#branch_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'branch/save_branch_add',
           data:$('#branch_form').serialize(),
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

function delete_branch(id){

    if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){

        jQuery.ajax({

            type: 'POST',

            url: base_url+'branch/delete_branch',

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

function delete_branch_multiple(){

    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){

        var id_checkbox = $('.id:checked');

        var id = '';

        for(var i=0; i<id_checkbox.length; i++){

            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';

            else id += $(id_checkbox[i]).val();

        }

        jQuery.ajax({

            type: 'POST',

            url: base_url+'branch/delete_branch',

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



