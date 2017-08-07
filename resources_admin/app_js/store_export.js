function delete_store_export_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storeexport/delete_store_export',
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

function delete_store_export(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storeexport/delete_store_export',
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


function validate_store_export_form(){
    $("#store_export_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_export_group_id: {
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
            
            price_export: {
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
            
            store_export_group_id: "Vui lòng điền phiếu xuất kho!",
            
            store_id: "Vui lòng điền kho!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng!",
            
            price_export: "Vui lòng điền giá!",
            
            commission_price: "Vui lòng điền chiết khấu giá!",
            
            commission_percent: "Vui lòng điền chiết khấu phần trăm!",
            
            tax_percent: "Vui lòng điền vat!",
            
        }
    });
}
        

function load_store_export_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeexport/load_store_export_add',
        beforeSend: function(xhr) {
            jQuery("#store_export_detail #store_export_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_export_detail #store_export_form").html(resp);
            validate_store_export_form();
        }
    });  
}

function load_store_export_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeexport/load_store_export_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_export_detail #store_export_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_export_detail #store_export_form").html(resp);
            validate_store_export_form();
        }
    });  
}

function save_store_export_add(element){
    if($("#store_export_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeexport/save_store_export_add',
           data:$('#store_export_form').serialize(),
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

function save_store_export_edit(element){
    if($("#store_export_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeexport/save_store_export_edit',
           data:$('#store_export_form').serialize(),
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
