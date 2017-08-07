if($('#order_fix_list').length){
	var order_fix_list = $('#order_fix_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"orderfix/get_order_fix_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                

            aoData.push( { "name": "f_type_search", "value": $('#type_search').val() } );
                        
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            aoData.push( { "name": "f_range_date", "value": $('#range_date').val() } );        
            
            aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                
            aoData.push( { "name": "f_order_detail_id", "value": $('#order_detail_id').val() } );
                
            aoData.push( { "name": "f_store_id", "value": $('#store_id').val() } );
                    
            aoData.push( { "name": "f_from_date", "value": $('#from_date').val() } );
                
            aoData.push( { "name": "f_to_date", "value": $('#to_date').val() } );
                
            aoData.push( { "name": "f_is_paid", "value": $('#is_paid').val() } );
                
            aoData.push( { "name": "f_is_delivery", "value": $('#is_delivery').val() } );
                
            aoData.push( { "name": "f_order_fix_type", "value": $('#order_fix_type').val() } );

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

    
            
     $("#search").on("keyup", function () {
        order_fix_list.fnDraw(); 
    });
        
            
     $("#is_paid").on("change", function () {
        order_fix_list.fnDraw(); 
    });
                
     $("#is_delivery").on("change", function () {
        order_fix_list.fnDraw(); 
    });
                
     $("#range_date").on("change", function () {
        order_fix_list.fnDraw(); 
    });
                
        
}

function order_fix_list_filter(){
    $('#type_search').val('1');
     order_fix_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function change_order_status_multiple(){
    if(confirm('Xác nhận đã giao cho những phiếu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'orderfix/change_order_status_edit',
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

function change_order_status(id){
	if(confirm('Xác nhận đã giao cho phiếu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'orderfix/change_order_status_edit',
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
      

function change_order_remain_paid_multiple(){
    if(confirm('Xác nhận đã thanh toán cho những phiếu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'orderfix/change_order_remain_paid_edit',
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

function change_order_remain_paid(id){
    if(confirm('Xác nhận đã thanh toán cho phiếu này?')){
        jQuery.ajax({
            type: 'POST',
            url: base_url+'orderfix/change_order_remain_paid_edit',
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
      
function load_order_fix_view(id, element){
    jQuery.ajax({
        type: 'POST',
        data: {
            id: id,
        },
        url: base_url+'orderfix/load_order_fix_view',
        beforeSend: function(xhr) {
            jQuery("#order_fix_detail #order_fix_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_fix_detail #order_fix_form").html(resp);
            validate_order_fix_form();
            $('.current_fix').removeClass('current_fix');
            element.addClass('current_fix');
        }
    });  
}  


function validate_order_fix_form(){
    $("#order_fix_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_id: {
                required: true,
            },
            
        },
        messages: {

            store_id: "Vui lòng điền kho hàng!",
            
        }
    });
    handleUniform();
}

function load_order_fix_add(element){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderfix/load_order_fix_add',
        beforeSend: function(xhr) {
            jQuery("#order_fix_detail #order_fix_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_fix_detail #order_fix_form").html(resp);
            validate_order_fix_form();
            $('.current_fix').removeClass('current_fix');
            element.addClass('current_fix');
        }
    });  
}

function load_order_fix_edit(id, element){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderfix/load_order_fix_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#order_fix_detail #order_fix_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_fix_detail #order_fix_form").html(resp);
            validate_order_fix_form();
            $('.current_fix').removeClass('current_fix');
            element.addClass('current_fix');
        }
    });  
}

function save_order_fix_add(element){
    if($("#order_fix_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderfix/save_order_fix_add',
           data:$('#order_fix_form').serialize(),
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
                $.unblockUI();
                $('.current_fix').parent().parent().find('.quantity').attr('data-type', resp);
                $('.current_fix').parent().html('<a href="#order_fix_detail" onclick="load_order_fix_edit('+resp+', $(this));" data-toggle="modal"><span class="label label-info tooltips" data-html="true" data-original-title="Xem sửa đồ"><i class="fa fa-eye"></i></span></a>');
                element.next().trigger('click');
            }
        });   
     }
}

function save_order_fix_edit(element){
    if($("#order_fix_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderfix/save_order_fix_edit',
           data:$('#order_fix_form').serialize(),
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
                $.unblockUI();
                $('.current_fix').parent().parent().find('.quantity').attr('data-type', resp);
                $('.current_fix').parent().html('<a href="#order_fix_detail" onclick="load_order_fix_edit('+resp+', $(this));" data-toggle="modal"><span class="label label-info tooltips" data-html="true" data-original-title="Xem sửa đồ"><i class="fa fa-eye"></i></span></a>');
                element.next().trigger('click');
            }
        });   
    }
}
