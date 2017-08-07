if($('#message_list').length){
	var message_list = $('#message_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"message/get_message_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_center_id", "value": $('#center_id').val() } );
                
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
	        }
		});

    
            
            
     $("#center_id").on("change", function () {
        message_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        message_list.fnDraw(); 
    });
                
        
}

function delete_message(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'message/delete_message',
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


function validate_message_form(){
    $("#message_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            center_id: {
                required: true,
            },
            
            user_id: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
            created_at: {
                required: true,
            },
            
            updated_at: {
                required: true,
            },
            
        },
        messages: {
            
            center_id: "Vui lòng điền trung tâm!",
            
            user_id: "Vui lòng điền người tạo!",
            
            status: "Vui lòng điền trạng thái!",
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_message_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'message/load_message_add',
        beforeSend: function(xhr) {
            jQuery("#message_detail #message_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#message_detail #message_form").html(resp);
            validate_message_form();
        }
    });  
}

function load_message_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'message/load_message_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#message_detail #message_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#message_detail #message_form").html(resp);
            validate_message_form();
        }
    });  
}

function save_message_add(element){
    if($("#message_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'message/save_message_add',
           data:$('#message_form').serialize(),
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

function save_message_edit(element){
    if($("#message_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'message/save_message_edit',
           data:$('#message_form').serialize(),
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
