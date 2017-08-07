function delete_store_transfer_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storetransfer/delete_store_transfer',
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

function delete_store_transfer(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storetransfer/delete_store_transfer',
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


function validate_store_transfer_form(){
    $("#store_transfer_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_transfer_group_id: {
                required: true,
            },
            
            product_id: {
                required: true,
            },
            
            quantity: {
                required: true,
            },
            
        },
        messages: {
            
            store_transfer_group_id: "Vui lòng điền phiếu chuyển kho!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng!",
            
        }
    });
}
        

function load_store_transfer_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storetransfer/load_store_transfer_add',
        beforeSend: function(xhr) {
            jQuery("#store_transfer_detail #store_transfer_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_transfer_detail #store_transfer_form").html(resp);
            validate_store_transfer_form();
        }
    });  
}

function load_store_transfer_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storetransfer/load_store_transfer_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_transfer_detail #store_transfer_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_transfer_detail #store_transfer_form").html(resp);
            validate_store_transfer_form();
        }
    });  
}

function save_store_transfer_add(element){
    if($("#store_transfer_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storetransfer/save_store_transfer_add',
           data:$('#store_transfer_form').serialize(),
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

function save_store_transfer_edit(element){
    if($("#store_transfer_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storetransfer/save_store_transfer_edit',
           data:$('#store_transfer_form').serialize(),
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
