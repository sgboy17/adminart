if($('#student_schedule_list').length){
	var student_schedule_list = $('#student_schedule_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"studentschedule/get_student_schedule_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_center_id", "value": $('#center_id').val() } );
                
            aoData.push( { "name": "f_student_id", "value": $('#student_id').val() } );
                
            aoData.push( { "name": "f_class_hour_id", "value": $('#class_hour_id').val() } );
                
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
        student_schedule_list.fnDraw(); 
    });
                
     $("#student_id").on("change", function () {
        student_schedule_list.fnDraw(); 
    });
                
     $("#class_hour_id").on("change", function () {
        student_schedule_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        student_schedule_list.fnDraw(); 
    });
                
        
}

function delete_student_schedule(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'studentschedule/delete_student_schedule',
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


function validate_student_schedule_form(){
    $("#student_schedule_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            center_id: {
                required: true,
            },
            
            student_id: {
                required: true,
            },
            
            class_hour_id: {
                required: true,
            },
            
            date: {
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
            
            student_id: "Vui lòng điền học viên!",
            
            class_hour_id: "Vui lòng điền giờ học!",
            
            date: "Vui lòng điền ngày học!",
            
            status: "Vui lòng điền trạng thái!",
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_student_schedule_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'studentschedule/load_student_schedule_add',
        beforeSend: function(xhr) {
            jQuery("#student_schedule_detail #student_schedule_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#student_schedule_detail #student_schedule_form").html(resp);
            validate_student_schedule_form();
        }
    });  
}

function load_student_schedule_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'studentschedule/load_student_schedule_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#student_schedule_detail #student_schedule_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#student_schedule_detail #student_schedule_form").html(resp);
            validate_student_schedule_form();
        }
    });  
}

function save_student_schedule_add(element){
    if($("#student_schedule_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'studentschedule/save_student_schedule_add',
           data:$('#student_schedule_form').serialize(),
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

function save_student_schedule_edit(element){
    if($("#student_schedule_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'studentschedule/save_student_schedule_edit',
           data:$('#student_schedule_form').serialize(),
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
