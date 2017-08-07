function delete_store_import_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storeimport/delete_store_import',
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

function delete_store_import(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storeimport/delete_store_import',
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


function validate_store_import_form(){
    $("#store_import_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_import_group_id: {
                required: true,
            },
            
            store_id: {
                required: true,
            },
            
            product_id: {
                required: true,
            },
            
            quantity: {
                required: true,
            },
            
            price_import: {
                required: true,
            },
            
            commission_price: {
                required: true,
            },
            
            commission_percent: {
                required: true,
            },
            
            tax_percent: {
                required: true,
            },
            
        },
        messages: {
            
            store_import_group_id: "Vui lòng điền phiếu nhập kho!",
            
            store_id: "Vui lòng điền kho!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng!",
            
            price_import: "Vui lòng điền giá!",
            
            commission_price: "Vui lòng điền chiết khấu giá!",
            
            commission_percent: "Vui lòng điền chiết khấu phần trăm!",
            
            tax_percent: "Vui lòng điền vat!",
            
        }
    });
}
        

function load_store_import_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeimport/load_store_import_add',
        beforeSend: function(xhr) {
            jQuery("#store_import_detail #store_import_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_import_detail #store_import_form").html(resp);
            validate_store_import_form();
        }
    });  
}

function load_store_import_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeimport/load_store_import_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_import_detail #store_import_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_import_detail #store_import_form").html(resp);
            validate_store_import_form();
        }
    });  
}

function save_store_import_add(element){
    if($("#store_import_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeimport/save_store_import_add',
           data:$('#store_import_form').serialize(),
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

function save_store_import_edit(element){
    if($("#store_import_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeimport/save_store_import_edit',
           data:$('#store_import_form').serialize(),
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
