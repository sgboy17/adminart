if($('#student_class_list').length){
	var student_class_list = $('#student_class_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"studentclass/get_student_class_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_center_id", "value": $('#center_id').val() } );
                
            aoData.push( { "name": "f_class_id", "value": $('#class_id').val() } );
                
            aoData.push( { "name": "f_student_id", "value": $('#student_id').val() } );
                
            aoData.push( { "name": "f_program_id", "value": $('#program_id').val() } );
                
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
        student_class_list.fnDraw(); 
    });
                
     $("#class_id").on("change", function () {
        student_class_list.fnDraw(); 
    });
                
     $("#student_id").on("change", function () {
        student_class_list.fnDraw(); 
    });
                
     $("#program_id").on("change", function () {
        student_class_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        student_class_list.fnDraw(); 
    });
                
        
}

function delete_student_class(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'studentclass/delete_student_class',
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


function validate_student_class_form(){
    $("#student_class_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            center_id: {
                required: true,
            },
            
            class_id: {
                required: true,
            },
            
            student_id: {
                required: true,
            },
            
            program_id: {
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
            
            class_id: "Vui lòng điền lớp học!",
            
            student_id: "Vui lòng điền học viên!",
            
            program_id: "Vui lòng điền chương trình!",
            
            status: "Vui lòng điền trạng thái!",
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_student_class_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'studentclass/load_student_class_add',
        beforeSend: function(xhr) {
            jQuery("#student_class_detail #student_class_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#student_class_detail #student_class_form").html(resp);
            validate_student_class_form();
        }
    });  
}

function load_student_class_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'studentclass/load_student_class_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#student_class_detail #student_class_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#student_class_detail #student_class_form").html(resp);
            validate_student_class_form();
        }
    });  
}

function save_student_class_add(element){
    if($("#student_class_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'studentclass/save_student_class_add',
           data:$('#student_class_form').serialize(),
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

function save_student_class_edit(element){
    if($("#student_class_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'studentclass/save_student_class_edit',
           data:$('#student_class_form').serialize(),
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
