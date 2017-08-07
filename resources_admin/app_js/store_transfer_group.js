if($('#store_transfer_group_list').length){
	var store_transfer_group_list = $('#store_transfer_group_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"storetransfergroup/get_store_transfer_group_list",
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
            
            aoData.push( { "name": "f_employee_id", "value": $('#employee_id').val() } );
                
            aoData.push( { "name": "f_store_id_import", "value": $('#store_id_import').val() } );
                
            aoData.push( { "name": "f_store_id_export", "value": $('#store_id_export').val() } );
                
            aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                    
            aoData.push( { "name": "f_from_date", "value": $('#from_date').val() } );
                
            aoData.push( { "name": "f_to_date", "value": $('#to_date').val() } );
                
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
        store_transfer_group_list.fnDraw(); 
    });
                
     $("#range_date").on("change", function () {
        store_transfer_group_list.fnDraw(); 
    });
                
        
}

function store_transfer_group_list_filter(){
    $('#type_search').val('1');
     store_transfer_group_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function delete_store_transfer_group_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storetransfergroup/delete_store_transfer_group',
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


function delete_store_transfer_group(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storetransfergroup/delete_store_transfer_group',
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

function approve_store_transfer_group(id){
    if(confirm('Bạn có chắc muốn duyệt dữ liệu này?')){
        var id_transferbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_transferbox.length; i++){
            if(i!=id_transferbox.length-1) id += $(id_transferbox[i]).val()+',';
            else id += $(id_transferbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storetransfergroup/approve_store_transfer_group_edit',
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

function unapprove_store_transfer_group(id){
    if(confirm('Bạn có chắc muốn bỏ duyệt dữ liệu này?')){
        var id_transferbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_transferbox.length; i++){
            if(i!=id_transferbox.length-1) id += $(id_transferbox[i]).val()+',';
            else id += $(id_transferbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storetransfergroup/unapprove_store_transfer_group_edit',
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


function validate_store_transfer_group_form(){
    $("#store_transfer_group_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            employee_id: {
                required: true,
            },
            
            store_id_import: {
                required: true,
            },
            
            store_id_export: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            employee_id: "Vui lòng điền nhân viên!",
            
            store_id_import: "Vui lòng điền kho nhập!",
            
            store_id_export: "Vui lòng điền kho xuất!",
            
            status: "Vui lòng điền trạng thái!",
            
        }
    });

    if($('#store_transfer_list').length){
        var store_transfer_list = $('#store_transfer_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"storetransfer/get_store_transfer_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 20,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
                    
                
                if($('#id').length) aoData.push( { "name": "f_store_transfer_group_id", "value": $('#id').val() } );
                else aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                 
            
                  },
                "fnDrawCallback":function(){
                    $(this).find('tbody tr').removeClass('odd').removeClass('even');
                    $(this).next().attr('style',"display:none;");
                    if($(this).next().next().find('span a').length<=1){
                        $(this).next().next().attr('style',"display:none;");
                    } else {
                        $(this).next().next().attr('style',"display:block;");
                    }
                    handleUniform();
                }
            });   
    }
    if($('#mini_product_list').length){
        var mini_product_list = $('#mini_product_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"product/get_mini_product_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 5,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
            
                aoData.push( { "name": "f_product_group_id", "value": $('#mini_product_group_id').val() } );

                aoData.push( { "name": "f_value_filter", "value": $('#mini_value_filter').val() } );

                aoData.push( { "name": "f_product_type", "value": 0 } );
                    
            
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

        
                
         $("#mini_value_filter").on("keyup", function () {
            mini_product_list.fnDraw(); 
        });
                
         $("#mini_product_group_id").on("change", function () {
            mini_product_list.fnDraw(); 
        });
    }
    handleUniform();
}

function load_store_transfer_group_fix(order_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storetransfergroup/load_store_transfer_group_add',
        data: {
            order_id: order_id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html(resp);
            validate_store_transfer_group_form();
        }
    });  
}
        

function load_store_transfer_group_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storetransfergroup/load_store_transfer_group_add',
        beforeSend: function(xhr) {
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html(resp);
            validate_store_transfer_group_form();
        }
    });  
}

function load_store_transfer_group_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storetransfergroup/load_store_transfer_group_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_transfer_group_detail #store_transfer_group_form").html(resp);
            validate_store_transfer_group_form();
        }
    });  
}

function save_store_transfer_group_add(element){
    var quantity = '';
    var key = '';
    var id_textbox = $('form .quantity');
    var order_fix_id = '';
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');

        if(i!=id_textbox.length-1) order_fix_id += $(id_textbox[i]).attr('data-fix')+',';
        else order_fix_id += $(id_textbox[i]).attr('data-fix');
    }

    var note = '';
    var id_textbox = $('form .note');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) note += $(id_textbox[i]).val()+',';
        else note += $(id_textbox[i]).val();
    }

    var unit_id = '';
    var id_textbox = $('form select.unit_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unit_id += $(id_textbox[i]).val()+',';
        else unit_id += $(id_textbox[i]).val();
    }

    $('#key').val(key);
    $('#quantity').val(quantity);
    $('#product_note').val(note);
    $('#unit_id').val(unit_id);
    $('#order_fix_id').val(order_fix_id);

    if($("#store_transfer_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storetransfergroup/save_store_transfer_group_add',
           data:$('#store_transfer_group_form').serialize(),
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
                element.next().trigger('click');
                jQuery("#store_transfer_group_detail #store_transfer_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
     }
}

function save_store_transfer_group_edit(element){
    var quantity = '';
    var key = '';
    var store_transfer_id = '';
    var store_import_id = '';
    var store_export_id = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');

        if(i!=id_textbox.length-1) store_transfer_id += $(id_textbox[i]).attr('data-transfer')+',';
        else store_transfer_id += $(id_textbox[i]).attr('data-transfer');

        if(i!=id_textbox.length-1) store_import_id += $(id_textbox[i]).attr('data-import')+',';
        else store_import_id += $(id_textbox[i]).attr('data-import');

        if(i!=id_textbox.length-1) store_export_id += $(id_textbox[i]).attr('data-export')+',';
        else store_export_id += $(id_textbox[i]).attr('data-export');
    }

    var note = '';
    var id_textbox = $('form .note');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) note += $(id_textbox[i]).val()+',';
        else note += $(id_textbox[i]).val();
    }

    var unit_id = '';
    var id_textbox = $('form select.unit_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unit_id += $(id_textbox[i]).val()+',';
        else unit_id += $(id_textbox[i]).val();
    }

    $('#key').val(key);
    $('#quantity').val(quantity);
    $('#product_note').val(note);
    $('#unit_id').val(unit_id);
    $('#store_transfer_id').val(store_transfer_id);
    $('#store_import_id').val(store_import_id);
    $('#store_export_id').val(store_export_id);


    if($("#store_transfer_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storetransfergroup/save_store_transfer_group_edit',
           data:$('#store_transfer_group_form').serialize(),
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
                element.next().trigger('click');
                jQuery("#store_transfer_group_detail #store_transfer_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
    }
}
