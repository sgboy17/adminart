if($('#class_hour_list').length){
	var class_hour_list = $('#class_hour_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"classhour/get_class_hour_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_room_id", "value": $('#room_id').val() } );
                
            aoData.push( { "name": "f_class_id", "value": $('#class_id').val() } );
                
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

    
            
            
     $("#room_id").on("change", function () {
        class_hour_list.fnDraw(); 
    });
                
     $("#class_id").on("change", function () {
        class_hour_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        class_hour_list.fnDraw(); 
    });
                
        
}

function delete_class_hour(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'classhour/delete_class_hour',
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


function validate_class_hour_form(){
    $("#class_hour_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            room_id: {
                required: true,
            },
            
            class_id: {
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
            
            room_id: "Vui lòng điền phòng học!",
            
            class_id: "Vui lòng điền lớp học!",
            
            status: "Vui lòng điền trạng thái!",
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_class_hour_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'classhour/load_class_hour_add',
        beforeSend: function(xhr) {
            jQuery("#class_hour_detail #class_hour_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#class_hour_detail #class_hour_form").html(resp);
            validate_class_hour_form();
        }
    });  
}

function load_class_hour_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'classhour/load_class_hour_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#class_hour_detail #class_hour_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#class_hour_detail #class_hour_form").html(resp);
            validate_class_hour_form();
        }
    });  
}

function save_class_hour_add(element){
    if($("#class_hour_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'classhour/save_class_hour_add',
           data:$('#class_hour_form').serialize(),
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

function save_class_hour_edit(element){
    if($("#class_hour_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'classhour/save_class_hour_edit',
           data:$('#class_hour_form').serialize(),
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
