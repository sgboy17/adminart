if($('#store_check_group_list').length){
	var store_check_group_list = $('#store_check_group_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"storecheckgroup/get_store_check_group_list",
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
                
            aoData.push( { "name": "f_store_id", "value": $('#store_id').val() } );
                
            aoData.push( { "name": "f_product_group_id", "value": $('#product_group_id').val() } );
                
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
        store_check_group_list.fnDraw(); 
    });
                
     $("#range_date").on("change", function () {
        store_check_group_list.fnDraw(); 
    });
                
        
}

function store_check_group_list_filter(){
    $('#type_search').val('1');
     store_check_group_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function delete_store_check_group_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storecheckgroup/delete_store_check_group',
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

function delete_store_check_group(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storecheckgroup/delete_store_check_group',
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


function approve_store_check_group(id){
    if(confirm('Bạn có chắc muốn duyệt dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storecheckgroup/approve_store_check_group_edit',
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

function unapprove_store_check_group(id){
    if(confirm('Bạn có chắc muốn bỏ duyệt dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storecheckgroup/unapprove_store_check_group_edit',
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

function validate_store_check_group_form(){
    $("#store_check_group_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            employee_id: {
                required: true,
            },
            
            store_id: {
                required: true,
            },
            
            product_group_id: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            employee_id: "Vui lòng điền nhân viên!",
            
            store_id: "Vui lòng điền kho!",
            
            product_group_id: "Vui lòng điền nhóm hàng hoá!",
            
            status: "Vui lòng điền trạng thái!",
            
        }
    });
    if($('#store_check_list').length){
        var store_check_list = $('#store_check_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"storecheck/get_store_check_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 2000,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
                    
                
                if($('#id').length) aoData.push( { "name": "f_store_check_group_id", "value": $('#id').val() } );
                
                aoData.push( { "name": "f_store_id", "value": $('form select[name=store_id]').val() } );
                    
                aoData.push( { "name": "f_product_group_id", "value": $('form select[name=product_group_id]').val() } );
                    
            
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

        
                
                
         $("form select[name=store_id]").on("change", function () {
            store_check_list.fnDraw(); 
        });
                    
         $("form select[name=product_group_id]").on("change", function () {
            store_check_list.fnDraw(); 
        });
                    
            
    }
    handleUniform();
}
        

function load_store_check_group_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storecheckgroup/load_store_check_group_add',
        beforeSend: function(xhr) {
            jQuery("#store_check_group_detail #store_check_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_check_group_detail #store_check_group_form").html(resp);
            validate_store_check_group_form();
        }
    });  
}

function load_store_check_group_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storecheckgroup/load_store_check_group_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_check_group_detail #store_check_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_check_group_detail #store_check_group_form").html(resp);
            validate_store_check_group_form();
        }
    });  
}

function save_store_check_group_add(element){
    var quantity = '';
    var key = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');
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

    if($("#store_check_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storecheckgroup/save_store_check_group_add',
           data:$('#store_check_group_form').serialize(),
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
                jQuery("#store_check_group_detail #store_check_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
     }
}

function save_store_check_group_edit(element){
    var quantity = '';
    var key = '';
    var store_check_id = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');

        if(i!=id_textbox.length-1) store_check_id += $(id_textbox[i]).attr('data-check')+',';
        else store_check_id += $(id_textbox[i]).attr('data-check');
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
    $('#store_check_id').val(store_check_id);

    if($("#store_check_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storecheckgroup/save_store_check_group_edit',
           data:$('#store_check_group_form').serialize(),
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
                jQuery("#store_check_group_detail #store_check_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
    }
}
