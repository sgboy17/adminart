function delete_order_detail_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'orderdetail/delete_order_detail',
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

function delete_order_detail(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'orderdetail/delete_order_detail',
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


function validate_order_detail_form(){
    $("#order_detail_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            order_id: {
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
            
            unpaid: {
                required: true,
            },
            
            type: {
                required: true,
            },
            
        },
        messages: {
            
            order_id: "Vui lòng điền phiếu bán hàng!",
            
            product_id: "Vui lòng điền hàng hoá!",
            
            quantity: "Vui lòng điền số lượng!",
            
            price_export: "Vui lòng điền giá bán!",
            
            commission_price: "Vui lòng điền chiết khấu giá!",
            
            commission_percent: "Vui lòng điền chiết khấu phần trăm!",
            
            paid: "Vui lòng điền thanh toán trước!",
            
            unpaid: "Vui lòng điền thanh toán còn lại!",
            
            type: "Vui lòng điền loại!",
            
        }
    });
}
        

function load_order_detail_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderdetail/load_order_detail_add',
        beforeSend: function(xhr) {
            jQuery("#order_detail_detail #order_detail_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_detail_detail #order_detail_form").html(resp);
            validate_order_detail_form();
        }
    });  
}

function load_order_detail_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderdetail/load_order_detail_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#order_detail_detail #order_detail_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_detail_detail #order_detail_form").html(resp);
            validate_order_detail_form();
        }
    });  
}

function save_order_detail_add(element){
    if($("#order_detail_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderdetail/save_order_detail_add',
           data:$('#order_detail_form').serialize(),
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

function save_order_detail_edit(element){
    if($("#order_detail_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderdetail/save_order_detail_edit',
           data:$('#order_detail_form').serialize(),
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
