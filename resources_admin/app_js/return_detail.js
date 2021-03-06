function delete_return_detail_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'returndetail/delete_return_detail',
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

function delete_return_detail(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'returndetail/delete_return_detail',
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


function validate_return_detail_form(){
    $("#return_detail_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            order_detail_id: {
                required: true,
            },
            
            return_id: {
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
            
            paid: {
                required: true,
            },
            
        },
        messages: {
            
            order_detail_id: "Vui lòng điền chi tiết phiếu bán hàng!",
            
            return_id: "Vui lòng điền phiếu trả hàng!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng!",
            
            price_export: "Vui lòng điền giá bán!",
            
            commission_price: "Vui lòng điền chiết khấu giá!",
            
            commission_percent: "Vui lòng điền chiết khấu phần trăm!",
            
            paid: "Vui lòng điền đã thanh toán!",
            
        }
    });
}
        

function load_return_detail_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'returndetail/load_return_detail_add',
        beforeSend: function(xhr) {
            jQuery("#return_detail_detail #return_detail_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#return_detail_detail #return_detail_form").html(resp);
            validate_return_detail_form();
        }
    });  
}

function load_return_detail_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'returndetail/load_return_detail_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#return_detail_detail #return_detail_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#return_detail_detail #return_detail_form").html(resp);
            validate_return_detail_form();
        }
    });  
}

function save_return_detail_add(element){
    if($("#return_detail_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'returndetail/save_return_detail_add',
           data:$('#return_detail_form').serialize(),
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

function save_return_detail_edit(element){
    if($("#return_detail_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'returndetail/save_return_detail_edit',
           data:$('#return_detail_form').serialize(),
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
