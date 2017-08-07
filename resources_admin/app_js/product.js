if($('#product_list').length){
	var product_list = $('#product_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"product/get_product_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_type_search", "value": $('#type_search').val() } );
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            aoData.push( { "name": "f_product_group_id", "value": $('#product_group_id').val() } );

            aoData.push( { "name": "f_value_filter", "value": $('#value_filter').val() } );

            aoData.push( { "name": "f_type_filter", "value": $('#type_filter').val() } );
                
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
        $('#type_search').val('0');
        product_list.fnDraw(); 
    });
            
     $("#status").on("change", function () {
        $('#type_search').val('0');
        product_list.fnDraw(); 
    });
     
    handleImport();
}

function product_list_filter(){
    $('#type_search').val('1');
     product_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function delete_product_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'product/delete_product',
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

function delete_product(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'product/delete_product',
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


function validate_product_form(){
    handleUpload();
    handlePrice();
    $('.tooltips').tooltip();
    $('.tooltips').focus(function(){
        $( ".tooltip" ).remove();
    });
    $(".modal select#store_id").select2({
        placeholder: "Tất cả kho"
    });

    $("#product_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            product_group_id: {
                required: true,
            },
            
            unit_id: {
                required: true,
            },
            
            price_import: {
                required: true,
            },
            
            price_export: {
                required: true,
            },
            
            store_min: {
                required: true,
            },
            
            store_max: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            product_group_id: "Vui lòng điền nhóm hàng!",
            
            unit_id: "Vui lòng điền đơn vị tính!",
            
            price_import: "Vui lòng điền giá mua!",
            
            price_export: "Vui lòng điền giá bán!",
            
            store_min: "Vui lòng điền tồn tối thiểu!",
            
            store_max: "Vui lòng điền tồn tối đa!",
            
            status: "Vui lòng điền tình trạng!",
            
        }
    });
}
        

function load_product_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'product/load_product_add',
        beforeSend: function(xhr) {
            jQuery("#product_detail #product_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#product_detail #product_form").html(resp);
            validate_product_form();
        }
    });  
}

function load_product_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'product/load_product_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#product_detail #product_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#product_detail #product_form").html(resp);
            validate_product_form();
        }
    });  
}

function save_product_add(element){
    if($("#product_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'product/save_product_add',
           data:$('#product_form').serialize(),
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

function save_product_edit(element){
    if($("#product_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'product/save_product_edit',
           data:$('#product_form').serialize(),
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

function module_load_product_unit_add(){
    var html = $('#product_unit_template').html();
    $('<div class="row">'+html+'</div>').insertBefore('#product_unit_template');
    handlePrice();
    $('.tooltips').tooltip();
    $('.tooltips').focus(function(){
        $( ".tooltip" ).remove();
    });
}

function module_delete_product_unit(element){
    element.parent().parent().remove();
}

function add_mini_product(product_id, element){
    if($('#store_transfer_list').length){ // Store Transfer
        var html = '<tr>'+$('.template tr').html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).attr('disabled','disabled');
        if(store!=''){
            alert('Mặt hàng này không có đồng bộ trong tất cả các kho để chuyển!');
            return; 
        }
        row.find('#template_code').html(code);
        row.find('#template_name').html(name);
        row.find('.quantity').attr('data', product_id);
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length){
            exist_row.val(parseInt(exist_row.val())+1);
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').append(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
    }

    if($('#store_import_list').length){ // Store Import
        var html = '<tr>'+$('.template tr').html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var total_price = element.attr('data-price-import');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).attr('disabled','disabled');
        if(store==''){
            row.find('#template_store select').show().select2();
        }else{
            store_id = store.split(',');
            for(var i=0;i<store_id.length;i++){
                row.find('#template_store select option[value='+store_id[i]+']').addClass('keep');
            }
            row.find('#template_store select option:not(.keep)').remove();
            row.find('#template_store select option.keep').removeClass('keep');
            row.find('#template_store select').show().select2();
        }
        row.find('#template_code').html(code);
        row.find('#template_name').html(name);
        row.find('#template_price input').val(total_price);
        row.find('.quantity').attr('data', product_id);
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length){
            exist_row.val(parseInt(exist_row.val())+1);
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').append(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
        calculate_price();
        handleUniform();
    }

    if($('#store_export_list').length){ // Store Export
        var html = '<tr>'+$('.template tr').html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var total_price = element.attr('data-price-export');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).attr('disabled','disabled');
        if(store==''){
            row.find('#template_store select').show().select2();
        }else{
            store_id = store.split(',');
            for(var i=0;i<store_id.length;i++){
                row.find('#template_store select option[value='+store_id[i]+']').addClass('keep');
            }
            row.find('#template_store select option:not(.keep)').remove();
            row.find('#template_store select option.keep').removeClass('keep');
            row.find('#template_store select').show().select2();
        }
        row.find('#template_code').html(code);
        row.find('#template_name').html(name);
        row.find('#template_price input').val(total_price);
        row.find('.quantity').attr('data', product_id);
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length){
            exist_row.val(parseInt(exist_row.val())+1);
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').append(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
        calculate_price();
        handleUniform();
    }

    if($('#order_detail_list').length){ // Order Detail
        var html = '<tr>'+$('.template tr').html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var total_price = element.attr('data-price-export');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).attr('disabled', 'disabled').select2();
        if(store==''){
            row.find('#template_store select').show().select2();
        }else{
            store_id = store.split(',');
            for(var i=0;i<store_id.length;i++){
                row.find('#template_store select option[value='+store_id[i]+']').addClass('keep');
            }
            row.find('#template_store select option:not(.keep)').remove();
            row.find('#template_store select option.keep').removeClass('keep');
            row.find('#template_store select').show().select2();
        }
        row.find('#template_code').html(code);
        row.find('#template_name').html(name);
        row.find('#template_price input').val(total_price);
        row.find('input[name=paid]').val(total_price);
        row.find('.quantity').attr('data', product_id);
        if(!isNaN($('#commission_percent').val())) row.find('input[name=commission_percent]').val(parseInt($('#commission_percent').val()));
        if(!isNaN($('#commission_price').val())) row.find('input[name=commission_price]').val(parseInt($('#commission_price').val()));
        if(!isNaN($('#tax_percent').val())) row.find('input[name=tax_percent]').val(parseInt($('#tax_percent').val()));
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length){
            exist_row.val(parseInt(exist_row.val())+1);
            exist_row.parent().parent().find('input[name=paid]').val(total_price*(parseInt(exist_row.val())));
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').append(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
        calculate_sale();
        handleUniform();
    }

    if($('#return_detail_list').length){ // Return Detail
        var html = '<tr>'+$('.template tr').html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var total_price = element.attr('data-price-export');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).attr('disabled', 'disabled').select2();
        if(store==''){
            row.find('#template_store select').show().select2();
        }else{
            store_id = store.split(',');
            for(var i=0;i<store_id.length;i++){
                row.find('#template_store select option[value='+store_id[i]+']').addClass('keep');
            }
            row.find('#template_store select option:not(.keep)').remove();
            row.find('#template_store select option.keep').removeClass('keep');
            row.find('#template_store select').show().select2();
        }
        row.find('#template_code').html(code);
        row.find('#template_name').html(name);
        row.find('#template_price input').val(total_price);
        row.find('input[name=paid]').val(total_price);
        row.find('.quantity').attr('data', product_id);
        if(!isNaN($('#commission_percent').val())) row.find('input[name=commission_percent]').val(parseInt($('#commission_percent').val()));
        if(!isNaN($('#commission_price').val())) row.find('input[name=commission_price]').val(parseInt($('#commission_price').val()));
        if(!isNaN($('#tax_percent').val())) row.find('input[name=tax_percent]').val(parseInt($('#tax_percent').val()));
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length){
            exist_row.val(parseInt(exist_row.val())+1);
            exist_row.parent().parent().find('input[name=paid]').val(total_price*(parseInt(exist_row.val())));
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').append(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
        calculate_sale_return();
        handleUniform();
    }
}


Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

// Import + Export
function calculate_price(){
    $('.modal input[name=quantity], .modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price], .modal input[name=tax_percent]').unbind('keyup').on('keyup', function(){
        if($(this).attr('name')=='commission_percent'||$(this).attr('name')=='commission_price'){
            var parent = $(this).parent().parent().parent();
        }else{
            var parent = $(this).parent().parent();
        }
        var total_price = parent.find('input[name=total_price]').val();
        var commission_percent = parent.find('input[name=commission_percent]').val();
        var commission_price = parent.find('input[name=commission_price]').val();
        var quantity = parent.find('input[name=quantity]').val();
        if(parent.find('input[name=tax_percent]').length){
            var tax_percent = parent.find('input[name=tax_percent]').val(); 
       }else{
            var tax_percent = 0;
       }
        
        var final_price = (total_price - total_price*commission_percent/100 - commission_price)*(1+parseInt(tax_percent)/100);
        parent.find('span.price').attr('data-price', parseInt(final_price));
        parent.find('span.price .currency_value').html((final_price*quantity).format());

        var price = parent.parent().find('span.price');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).attr('data-price'))*parseInt($(quantity[i]).val());
        }
        $('.modal .total-price').val(total_price);
    });
    $('.modal input[name=quantity], .modal input[name=total_price], .modal input[name=commission_percent], .modal input[name=commission_price], .modal input[name=tax_percent').trigger('keyup');
}

// Order Detail
function calculate_sale(){
    $('.modal .product-list input[name=quantity], .modal .product-list input[name=total_price], .modal .product-list input[name=commission_percent], .modal .product-list input[name=commission_price], .modal .product-list input[name=tax_percent]').unbind('keyup').on('keyup', function(){
        if($(this).attr('name')=='commission_percent'||$(this).attr('name')=='commission_price'){
            var parent = $(this).parent().parent().parent();
        }else{
            var parent = $(this).parent().parent();
        }
        var total_price = parent.find('input[name=total_price]').val();
        var commission_percent = parent.find('input[name=commission_percent]').val();
        var commission_price = parent.find('input[name=commission_price]').val();
        var quantity = parent.find('input[name=quantity]').val();
        var paid = parent.find('input[name=paid]').val();
        var unpaid = parent.find('input[name=unpaid]').val();
        if(parent.find('input[name=tax_percent]').length){
            var tax_percent = parent.find('input[name=tax_percent]').val(); 
        }else{
            var tax_percent = 0;
        }
        
        var final_price = (total_price - total_price*commission_percent/100 - commission_price)*(1+parseInt(tax_percent)/100);
        parent.find('span.price').attr('data-price', parseInt(final_price));
        parent.find('span.price .currency_value').html((final_price*quantity).format());
        if($('#id').length==0) parent.find('input[name=paid]').val(parseInt(final_price*quantity));

        // sum_price
        var price = parent.parent().find('input[name=total_price]');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).val())*parseInt($(quantity[i]).val());
        }
        $('.modal input[name=sum_price]').val(total_price);

        // total_price
        var price = parent.parent().find('span.price');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).attr('data-price'))*parseInt($(quantity[i]).val());
        }
        $('.modal input[name=paid_cash], .modal input[name=total_price_total]').val(total_price).trigger('change');  

        var check = check_diff_commission_percent_order();
        if(check>=0) $('#commission_percent').val(check);
        else $('#commission_percent').val('Tùy chỉnh');
        var check = check_diff_commission_price_order();
        if(check>=0) $('#commission_price').val(check);
        else $('#commission_price').val('Tùy chỉnh');
        var check = check_diff_tax_percent_order();
        if(check>=0) $('#tax_percent').val(check);
        else $('#tax_percent').val('Tùy chỉnh');

        $('.modal .product-list input[name=paid]').trigger('keyup');
    });
    $('.modal .product-list input[name=quantity], .modal .product-list input[name=total_price], .modal .product-list input[name=commission_percent], .modal .product-list input[name=commission_price], .modal .product-list input[name=tax_percent]').trigger('keyup');

    $('.modal .product-list input[name=paid]').unbind('keyup').on('keyup', function(){
        var parent = $(this).parent().parent();
        var total_price = parent.find('input[name=total_price]').val();
        var commission_percent = parent.find('input[name=commission_percent]').val();
        var commission_price = parent.find('input[name=commission_price]').val();
        var quantity = parent.find('input[name=quantity]').val();
        var paid = parent.find('input[name=paid]').val();
        var unpaid = parent.find('input[name=unpaid]').val();
        if(parent.find('input[name=tax_percent]').length){
            var tax_percent = parent.find('input[name=tax_percent]').val(); 
        }else{
            var tax_percent = 0;
        }

        var final_price = (total_price - total_price*commission_percent/100 - commission_price)*(1+parseInt(tax_percent)/100);
        parent.find('input[name=unpaid]').val(parseInt(final_price*quantity)-parent.find('input[name=paid]').val());

        var paid = $('.modal .product-list input[name=paid]');
        var total_paid = 0;
        for(var i=0;i<paid.length;i++){
            total_paid+= parseInt($(paid[i]).val());
        }
        $('.modal input[name=total_paid]').val(total_paid);
        var remain_paid = $('.calculate_sale input[name=total_price_total]').val()-total_paid;
        if(remain_paid<0) $('.modal input[name=remain_paid]').val('0').attr('data', remain_paid);
        else $('.modal input[name=remain_paid]').val(remain_paid).attr('data', remain_paid);
        $('.calculate_sale input[name=paid_cash], .calculate_sale input[name=paid_card]').trigger('keyup');
    });
    $('.modal .product-list input[name=paid]').trigger('keyup');

    $('.calculate_sale input[name=paid_cash], .calculate_sale input[name=paid_card]').unbind('keyup').on('keyup', function(){
        calculate_paid_return();
    });
    $('.calculate_sale input[name=paid_cash], .calculate_sale input[name=paid_card]').trigger('keyup');
    calculate_voucher();

}

function calculate_voucher(){
    $('.calculate_sale select[name=voucher_price]').unbind('change').on('change', function(){
        calculate_paid_return();
    });
    $('.calculate_sale input[name=voucher_quantity]').unbind('keyup').on('keyup', function(){
        calculate_paid_return();
    });
    calculate_paid_return();
}

function calculate_paid_return(){
    var paid_card = $('.calculate_sale input[name=paid_card]').val();
    var paid_cash = $('.calculate_sale input[name=paid_cash]').val();
    var voucher_price = $('.calculate_sale select[name=voucher_price]');
    var total_voucher_price = 0;
    for(var i=0;i<voucher_price.length;i++){
        total_voucher_price+= parseInt($(voucher_price[i]).val())*$(voucher_price[i]).parent().find('input').val();
    }
    var paid_get = parseInt(paid_card)+parseInt(paid_cash);
    $('.calculate_sale input[name=paid_get]').val(paid_get);
    var paid_return = total_voucher_price+paid_get-$('.calculate_sale input[name=total_paid]').val();
    var remain_paid = parseInt($('.modal input[name=remain_paid]').attr('data'));
    if(remain_paid<0) paid_return = paid_return - remain_paid;
    if(paid_return<0) $('.calculate_sale input[name=paid_return]').val('Chưa đủ tiền!');
    else $('.calculate_sale input[name=paid_return]').val(paid_return);
}

// Return Detail
function calculate_sale_return(){
    $('.modal .product-list input[name=quantity], .modal .product-list input[name=total_price], .modal .product-list input[name=commission_percent], .modal .product-list input[name=commission_price], .modal input[name=tax_percent]').unbind('keyup').on('keyup', function(){
        if($(this).attr('name')=='commission_percent'||$(this).attr('name')=='commission_price'){
            var parent = $(this).parent().parent().parent();
        }else{
            var parent = $(this).parent().parent();
        }
        var total_price = parent.find('input[name=total_price]').val();
        var commission_percent = parent.find('input[name=commission_percent]').val();
        var commission_price = parent.find('input[name=commission_price]').val();
        var quantity = parent.find('input[name=quantity]').val();
        var paid = parent.find('input[name=paid]').val();
        if(parent.find('input[name=tax_percent]').length){
            var tax_percent = parent.find('input[name=tax_percent]').val(); 
        }else{
            var tax_percent = 0;
        }
        
        var final_price = (total_price - total_price*commission_percent/100 - commission_price)*(1+parseInt(tax_percent)/100);
        parent.find('span.price').attr('data-price', parseInt(final_price));
        parent.find('span.price .currency_value').html((final_price*quantity).format());
        if($('#id').length==0&&$('#key').parent().find('select[name=order_id]').val()=='') parent.find('input[name=paid]').val(parseInt(final_price*quantity));
        
        // sum_price
        var price = parent.parent().find('input[name=total_price]');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).val())*parseInt($(quantity[i]).val());
        }
        $('.modal .calculate_sale input[name=sum_price]').val(total_price);

        // total_price
        var price = parent.parent().find('span.price');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).attr('data-price'))*parseInt($(quantity[i]).val());
        }
        $('.modal .calculate_sale input[name=total_price]').val(total_price);

        var check = check_diff_commission_percent_return();
        if(check>=0) $('#commission_percent').val(check);
        else $('#commission_percent').val('Tùy chỉnh');
        var check = check_diff_commission_price_return();
        if(check>=0) $('#commission_price').val(check);
        else $('#commission_price').val('Tùy chỉnh');
        var check = check_diff_tax_percent_return();
        if(check>=0) $('#tax_percent').val(check);
        else $('#tax_percent').val('Tùy chỉnh');

        $('.modal .product-list input[name=paid]').trigger('keyup');
    });
    $('.modal .product-list input[name=quantity], .modal .product-list input[name=total_price], .modal .product-list input[name=commission_percent], .modal .product-list input[name=commission_price], .modal input[name=tax_percent]').trigger('keyup');

    $('.modal .product-list input[name=paid]').unbind('keyup').on('keyup', function(){
        var paid = $('.modal .product-list input[name=paid]');
        var total_return = 0;
        for(var i=0;i<paid.length;i++){
            total_return+= parseInt($(paid[i]).val());
        }
        $('.modal .calculate_sale input[name=total_return]').val(total_return);
    });
    $('.modal .product-list input[name=paid]').trigger('keyup');
}


function check_diff_commission_percent_return(){
    var commission_percent = $('#return_detail_list input[name=commission_percent]');
    if(commission_percent.length==0) return $('#commission_percent').val();
    for(var i=0;i<commission_percent.length-1;i++){
        if($(commission_percent[i]).val()!=$(commission_percent[i+1]).val()) return -1;
    }
    return $(commission_percent[0]).val();
}

function check_diff_commission_price_return(){
    var commission_price = $('#return_detail_list input[name=commission_price]');
    if(commission_price.length==0) return $('#commission_price').val();
    for(var i=0;i<commission_price.length-1;i++){
        if($(commission_price[i]).val()!=$(commission_price[i+1]).val()) return -1;
    }
    return $(commission_price[0]).val();
}

function check_diff_tax_percent_return(){
    var tax_percent = $('#return_detail_list input[name=tax_percent]');
    if(tax_percent.length==0) return $('#tax_percent').val();
    for(var i=0;i<tax_percent.length-1;i++){
        if($(tax_percent[i]).val()!=$(tax_percent[i+1]).val()) return -1;
    }
    return $(tax_percent[0]).val();
}

function check_diff_commission_percent_order(){
    var commission_percent = $('#order_detail_list input[name=commission_percent]');
    if(commission_percent.length==0) return $('#commission_percent').val();
    for(var i=0;i<commission_percent.length-1;i++){
        if($(commission_percent[i]).val()!=$(commission_percent[i+1]).val()) return -1;
    }
    return $(commission_percent[0]).val();
}

function check_diff_commission_price_order(){
    var commission_price = $('#order_detail_list input[name=commission_price]');
    if(commission_price.length==0) return $('#commission_price').val();
    for(var i=0;i<commission_price.length-1;i++){
        if($(commission_price[i]).val()!=$(commission_price[i+1]).val()) return -1;
    }
    return $(commission_price[0]).val();
}

function check_diff_tax_percent_order(){
    var tax_percent = $('#order_detail_list input[name=tax_percent]');
    if(tax_percent.length==0) return $('#tax_percent').val();
    for(var i=0;i<tax_percent.length-1;i++){
        if($(tax_percent[i]).val()!=$(tax_percent[i+1]).val()) return -1;
    }
    return $(tax_percent[0]).val();
}