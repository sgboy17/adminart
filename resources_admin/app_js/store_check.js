function delete_store_check_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storecheck/delete_store_check',
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

function delete_store_check(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storecheck/delete_store_check',
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


function validate_store_check_form(){
    $("#store_check_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_check_group_id: {
                required: true,
            },
            
            product_id: {
                required: true,
            },
            
            quantity: {
                required: true,
            },
            
            quantity_record: {
                required: true,
            },
            
        },
        messages: {
            
            store_check_group_id: "Vui lòng điền phiếu kiểm kho!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng thực tế!",
            
            quantity_record: "Vui lòng điền số lượng sổ sách!",
            
        }
    });
}
        

function load_store_check_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storecheck/load_store_check_add',
        beforeSend: function(xhr) {
            jQuery("#store_check_detail #store_check_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_check_detail #store_check_form").html(resp);
            validate_store_check_form();
        }
    });  
}

function load_store_check_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storecheck/load_store_check_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_check_detail #store_check_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_check_detail #store_check_form").html(resp);
            validate_store_check_form();
        }
    });  
}

function save_store_check_add(element){
    if($("#store_check_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storecheck/save_store_check_add',
           data:$('#store_check_form').serialize(),
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

function save_store_check_edit(element){
    if($("#store_check_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storecheck/save_store_check_edit',
           data:$('#store_check_form').serialize(),
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
