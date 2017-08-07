if($('#teacher_list').length){
	var teacher_list = $('#teacher_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"teacher/get_teacher_list",
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
                handleUniform();
	        }
		});

    
            
     $("#search").on("keyup", function () {
        teacher_list.fnDraw(); 
    });
        
            
     $("#status").on("change", function () {
        teacher_list.fnDraw(); 
    });
                
        
}

function delete_teacher_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'teacher/delete_teacher',
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

function delete_teacher(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'teacher/delete_teacher',
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


function validate_teacher_form(){
    $("#teacher_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            },
            
            sex: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            name: "Vui lòng điền tên giáo viên!",
            sex: "Vui lòng chọn giới tính!",
            status: "Vui lòng điền trạng thái!",
        }
    });
}
        

function load_teacher_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'teacher/load_teacher_add',
        beforeSend: function(xhr) {
            jQuery("#teacher_detail #teacher_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#teacher_detail #teacher_form").html(resp);
            validate_teacher_form();
            $('.datepicker').datepicker({format:'dd/mm/yyyy',autoclose:true});
        }
    });  
}

function load_teacher_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'teacher/load_teacher_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#teacher_detail #teacher_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#teacher_detail #teacher_form").html(resp);
            validate_teacher_form();
            $('.datepicker').datepicker({format:'dd/mm/yyyy',autoclose:true});
        }
    });  
}

function save_teacher_add(element){
    if($("#teacher_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'teacher/save_teacher_add',
           data:$('#teacher_form').serialize(),
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

function save_teacher_edit(element){
    if($("#teacher_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'teacher/save_teacher_edit',
           data:$('#teacher_form').serialize(),
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
