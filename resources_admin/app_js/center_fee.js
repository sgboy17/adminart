if($('#center_fee_list').length){
	var center_fee_list = $('#center_fee_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"centerfee/get_center_fee_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            
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

    
            
     $("#search").on("keyup", function () {
        center_fee_list.fnDraw(); 
    });
        
            
     $("#center_id").on("change", function () {
        center_fee_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        center_fee_list.fnDraw(); 
    });
                
        
}

function delete_center_fee(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'centerfee/delete_center_fee',
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


function validate_center_fee_form(){
    $("#center_fee_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            center_id: {
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
            
            status: "Vui lòng điền trạng thái!",
            
            created_at: "Vui lòng điền ngày tạo!",
            
            updated_at: "Vui lòng điền ngày sửa!",
            
        }
    });
}
        

function load_center_fee_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'centerfee/load_center_fee_add',
        beforeSend: function(xhr) {
            jQuery("#center_fee_detail #center_fee_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#center_fee_detail #center_fee_form").html(resp);
            validate_center_fee_form();
        }
    });  
}

function load_center_fee_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'centerfee/load_center_fee_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#center_fee_detail #center_fee_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#center_fee_detail #center_fee_form").html(resp);
            validate_center_fee_form();
        }
    });  
}

function save_center_fee_add(element){
    if($("#center_fee_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'centerfee/save_center_fee_add',
           data:$('#center_fee_form').serialize(),
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

function save_center_fee_edit(element){
    if($("#center_fee_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'centerfee/save_center_fee_edit',
           data:$('#center_fee_form').serialize(),
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
