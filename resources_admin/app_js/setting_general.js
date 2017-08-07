if($('#setting_general_list').length){
	var setting_general_list = $('#setting_general_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"settinggeneral/get_setting_general_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_center_id", "value": $('#center_id').val() } );
                
        
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
        setting_general_list.fnDraw(); 
    });
                
        
}

function delete_setting_general(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'settinggeneral/delete_setting_general',
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


function validate_setting_general_form(){
    $("#setting_general_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            center_id: {
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
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_setting_general_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'settinggeneral/load_setting_general_add',
        beforeSend: function(xhr) {
            jQuery("#setting_general_detail #setting_general_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#setting_general_detail #setting_general_form").html(resp);
            validate_setting_general_form();
        }
    });  
}

function load_setting_general_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'settinggeneral/load_setting_general_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#setting_general_detail #setting_general_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#setting_general_detail #setting_general_form").html(resp);
            validate_setting_general_form();
        }
    });  
}

function save_setting_general_add(element){
    if($("#setting_general_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'settinggeneral/save_setting_general_add',
           data:$('#setting_general_form').serialize(),
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

function save_setting_general_edit(element){
    if($("#setting_general_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'settinggeneral/save_setting_general_edit',
           data:$('#setting_general_form').serialize(),
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
