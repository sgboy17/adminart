if($('#order_voucher_list').length){
	var order_voucher_list = $('#order_voucher_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"ordervoucher/get_order_voucher_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                
            aoData.push( { "name": "f_order_paid_id", "value": $('#order_paid_id').val() } );
                
        
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
                if($('.check_all').length){
                    $('.check_all').on('click', function(){
                        if(!$('.check_all').prop('checked')){
                            $('.id:checked').trigger('click');
                        }else{
                            $('.id:not(.id:checked)').trigger('click');
                        }
                    });
                }
                handleUniform();
	        }
		});

    
            
            
     $("#order_id").on("change", function () {
        order_voucher_list.fnDraw(); 
    });
                
     $("#order_paid_id").on("change", function () {
        order_voucher_list.fnDraw(); 
    });
                
        
}

function delete_order_voucher_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'ordervoucher/delete_order_voucher',
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

function delete_order_voucher(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'ordervoucher/delete_order_voucher',
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


function validate_order_voucher_form(){
    $("#order_voucher_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            order_id: {
                required: true,
            },
            
            order_paid_id: {
                required: true,
            },
            
            price: {
                required: true,
            },
            
            quantity: {
                required: true,
            },
            
        },
        messages: {
            
            order_id: "Vui lòng điền phiếu bán hàng!",
            
            order_paid_id: "Vui lòng điền lịch sử thanh toán!",
            
            price: "Vui lòng điền mệnh giá phiếu!",
            
            quantity: "Vui lòng điền số lượng phiếu!",
            
        }
    });
}
        

function load_order_voucher_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'ordervoucher/load_order_voucher_add',
        beforeSend: function(xhr) {
            jQuery("#order_voucher_detail #order_voucher_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_voucher_detail #order_voucher_form").html(resp);
            validate_order_voucher_form();
        }
    });  
}

function load_order_voucher_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'ordervoucher/load_order_voucher_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#order_voucher_detail #order_voucher_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_voucher_detail #order_voucher_form").html(resp);
            validate_order_voucher_form();
        }
    });  
}

function save_order_voucher_add(element){
    if($("#order_voucher_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'ordervoucher/save_order_voucher_add',
           data:$('#order_voucher_form').serialize(),
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

function save_order_voucher_edit(element){
    if($("#order_voucher_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'ordervoucher/save_order_voucher_edit',
           data:$('#order_voucher_form').serialize(),
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
