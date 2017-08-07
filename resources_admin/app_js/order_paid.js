if($('#order_paid_list').length){
	var order_paid_list = $('#order_paid_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"orderpaid/get_order_paid_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                
            aoData.push( { "name": "f_bank_id", "value": $('#bank_id').val() } );
                
        
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
        order_paid_list.fnDraw(); 
    });
                
     $("#bank_id").on("change", function () {
        order_paid_list.fnDraw(); 
    });
                
        
}

function delete_order_paid_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'orderpaid/delete_order_paid',
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

function delete_order_paid(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'orderpaid/delete_order_paid',
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


function validate_order_paid_form(){
    $("#order_paid_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            order_id: {
                required: true,
            },
            
            bank_id: {
                required: true,
            },
            
            paid_card: {
                required: true,
            },
            
            paid_cash: {
                required: true,
            },
            
            paid_return: {
                required: true,
            },
            
        },
        messages: {
            
            order_id: "Vui lòng điền phiếu bán hàng!",
            
            bank_id: "Vui lòng điền ngân hàng thanh toán!",
            
            paid_card: "Vui lòng điền tiền thẻ!",
            
            paid_cash: "Vui lòng điền tiền mặt!",
            
            paid_return: "Vui lòng điền tiền trả lại!",
            
        }
    });
}
        

function load_order_paid_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderpaid/load_order_paid_add',
        beforeSend: function(xhr) {
            jQuery("#order_paid_detail #order_paid_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_paid_detail #order_paid_form").html(resp);
            validate_order_paid_form();
        }
    });  
}

function load_order_paid_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderpaid/load_order_paid_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#order_paid_detail #order_paid_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_paid_detail #order_paid_form").html(resp);
            validate_order_paid_form();
        }
    });  
}

function save_order_paid_add(element){
    if($("#order_paid_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderpaid/save_order_paid_add',
           data:$('#order_paid_form').serialize(),
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

function save_order_paid_edit(element){
    if($("#order_paid_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderpaid/save_order_paid_edit',
           data:$('#order_paid_form').serialize(),
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
