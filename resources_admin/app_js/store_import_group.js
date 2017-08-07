if($('#store_import_group_list').length){
	var store_import_group_list = $('#store_import_group_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"storeimportgroup/get_store_import_group_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
                       
            aoData.push( { "name": "f_type_search", "value": $('#type_search').val() } );
            
            aoData.push( { "name": "f_store_type", "value": $('#store_type').val() } );
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
            
            aoData.push( { "name": "f_range_date", "value": $('#range_date').val() } );
            
            aoData.push( { "name": "f_employee_id", "value": $('#employee_id').val() } );
                
            aoData.push( { "name": "f_supplier_id", "value": $('#supplier_id').val() } );
                
            aoData.push( { "name": "f_order_id", "value": $('#order_id').val() } );
                
            aoData.push( { "name": "f_from_date", "value": $('#from_date').val() } );
                
            aoData.push( { "name": "f_to_date", "value": $('#to_date').val() } );
                
            aoData.push( { "name": "f_type", "value": $('#type').val() } );
                
        
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
        store_import_group_list.fnDraw(); 
    });
                
     $("#store_type").on("change", function () {
        store_import_group_list.fnDraw(); 
    });
                
     $("#range_date").on("change", function () {
        store_import_group_list.fnDraw(); 
    });
                
        
}

function store_import_group_list_filter(){
    $('#type_search').val('1');
     store_import_group_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function delete_store_import_group_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'storeimportgroup/delete_store_import_group',
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

function delete_store_import_group(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'storeimportgroup/delete_store_import_group',
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


function validate_store_import_group_form(){
    $("#store_import_group_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            created_date: {
                required: true,
            },
            
        },
        messages: {
            
            created_date: "Vui lòng điền ngày nhập!",
            
        }
    });

    $('.modal #supplier_info').on('change', function(){
        var address = $(this).find('option:selected').attr('data-address');
        var phone = $(this).find('option:selected').attr('data-phone');
        $('.modal .supplier_info #address').val(address);
        $('.modal .supplier_info #phone').val(phone);
    });
    $('.modal #supplier_info').trigger('change');

    if($('#store_import_list').length){
        var store_import_list = $('#store_import_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"storeimport/get_store_import_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 20,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
                    
                
                if($('#id').length) aoData.push( { "name": "f_store_import_group_id", "value": $('#id').val() } );
                 
            
                  },
                "fnDrawCallback":function(){
                    $(this).find('tbody tr').removeClass('odd').removeClass('even');
                    $(this).next().attr('style',"display:none;");
                    if($(this).next().next().find('span a').length<=1){
                        $(this).next().next().attr('style',"display:none;");
                    } else {
                        $(this).next().next().attr('style',"display:block;");
                    }
                    calculate_price();
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
        

function load_store_import_group_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeimportgroup/load_store_import_group_add',
        beforeSend: function(xhr) {
            jQuery("#store_import_group_detail #store_import_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_import_group_detail #store_import_group_form").html(resp);
            validate_store_import_group_form();
        }
    });  
}

function load_store_import_group_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'storeimportgroup/load_store_import_group_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#store_import_group_detail #store_import_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#store_import_group_detail #store_import_group_form").html(resp);
            validate_store_import_group_form();
        }
    });  
}

function save_store_import_group_add(element){
    var quantity = '';
    var key = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');
    }

    var unit_id = '';
    var id_textbox = $('form select.unit_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unit_id += $(id_textbox[i]).val()+',';
        else unit_id += $(id_textbox[i]).val();
    }

    var vat = '';
    var id_textbox = $('form .tax_percent');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) vat += $(id_textbox[i]).val()+',';
        else vat += $(id_textbox[i]).val();
    }

    var store_id = '';
    var id_textbox = $('form select.store_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) store_id += $(id_textbox[i]).val()+',';
        else store_id += $(id_textbox[i]).val();
    }

    var price = '';
    var id_textbox = $('form .price');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) price += $(id_textbox[i]).attr('data-price')+',';
        else price += $(id_textbox[i]).attr('data-price');
    }

    var commission_price = [];
    var id_textbox = $('form .commission_price');
    for(var i=0; i<id_textbox.length; i++){
        commission_price[i] = $(id_textbox[i]).val();
    }

    var commission_percent = [];
    var id_textbox = $('form .commission_percent');
    for(var i=0; i<id_textbox.length; i++){
        commission_percent[i] = $(id_textbox[i]).val();
    }

    var commission = '';
    for(var i=0; i<commission_price.length; i++){
        if(i!=commission_price.length-1) commission += commission_price[i]+'|'+commission_percent[i]+',';
        else commission += commission_price[i]+'|'+commission_percent[i];
    }

    $('#key').val(key);
    $('#quantity').val(quantity);
    $('#unit_id').val(unit_id);
    $('#vat').val(vat);
    $('#store_id').val(store_id);
    $('#price').val(price);
    $('#commission').val(commission);

    if($("#store_import_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeimportgroup/save_store_import_group_add',
           data:$('#store_import_group_form').serialize(),
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
                jQuery("#store_import_group_detail #store_import_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
     }
}

function save_store_import_group_edit(element){
    var quantity = '';
    var key = '';
    var store_import_id = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');

        if(i!=id_textbox.length-1) store_import_id += $(id_textbox[i]).attr('data-import')+',';
        else store_import_id += $(id_textbox[i]).attr('data-import');
    }

    var unit_id = '';
    var id_textbox = $('form select.unit_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unit_id += $(id_textbox[i]).val()+',';
        else unit_id += $(id_textbox[i]).val();
    }

    var vat = '';
    var id_textbox = $('form .tax_percent');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) vat += $(id_textbox[i]).val()+',';
        else vat += $(id_textbox[i]).val();
    }

    var store_id = '';
    var id_textbox = $('form select.store_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) store_id += $(id_textbox[i]).val()+',';
        else store_id += $(id_textbox[i]).val();
    }

    var price = '';
    var id_textbox = $('form .price');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) price += $(id_textbox[i]).attr('data-price')+',';
        else price += $(id_textbox[i]).attr('data-price');
    }

    var commission_price = [];
    var id_textbox = $('form .commission_price');
    for(var i=0; i<id_textbox.length; i++){
        commission_price[i] = $(id_textbox[i]).val();
    }

    var commission_percent = [];
    var id_textbox = $('form .commission_percent');
    for(var i=0; i<id_textbox.length; i++){
        commission_percent[i] = $(id_textbox[i]).val();
    }

    var commission = '';
    for(var i=0; i<commission_price.length; i++){
        if(i!=commission_price.length-1) commission += commission_price[i]+'|'+commission_percent[i]+',';
        else commission += commission_price[i]+'|'+commission_percent[i];
    }

    $('#key').val(key);
    $('#quantity').val(quantity);
    $('#unit_id').val(unit_id);
    $('#vat').val(vat);
    $('#store_id').val(store_id);
    $('#price').val(price);
    $('#commission').val(commission);
    $('#store_import_id').val(store_import_id);


    if($("#store_import_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'storeimportgroup/save_store_import_group_edit',
           data:$('#store_import_group_form').serialize(),
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
                jQuery("#store_import_group_detail #store_import_group_form").html('');
                if($('.paginate_active').length) $('.paginate_active').trigger('click');
                else document.location.href = document.location.href ;
                $.unblockUI();
            }
        });   
    }
}
