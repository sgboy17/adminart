function module_load_product_unit_add(){
    var html = $('#product_unit_template').html();
    $('<div class="row">'+html+'</div>').insertBefore('#product_unit_template');
    handlePrice();
}

function module_delete_product_unit(element){
    element.parent().parent().remove();
}

function add_mini_product(product_id, element){
    var template_layout = $('.template').clone();
    template_layout.find('.binded').removeClass('binded');
    template_layout.find('.binded_cs').removeClass('binded_cs');
    if($('#order_form').length){ // Order Detail
        var html = '<tr>'+template_layout.html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var product_unit = element.attr('data-product-unit');
        var total_price = element.attr('data-price-export');
        var row = $(html).clone();

        if(product_unit==''){
            row.find('#template_unit select').show().val(unit).attr('disabled', 'disabled');
        }else{
            product_unit_id = product_unit.split(',');
            for(var i=0;i<product_unit_id.length;i++){
                var product_unit_data = product_unit_id[i].split('|');
                row.find('#template_unit select option[value='+product_unit_data[0]+']').attr('data-price', product_unit_data[1]).addClass('p_u');
            }
            row.find('#template_unit select').val(unit);
            row.find('#template_unit select option:selected').attr('data-price', total_price).addClass('p_u');
            row.find('#template_unit select option:not(.p_u)').remove();
            row.find('#template_unit select option.p_u').removeClass('p_u');
            row.find('#template_unit select').show();
        }

        if(store==''){
            row.find('#template_store select').show();
        }else{
            store_id = store.split(',');
            for(var i=0;i<store_id.length;i++){
                row.find('#template_store select option[value='+store_id[i]+']').addClass('keep');
            }
            row.find('#template_store select option:not(.keep)').remove();
            row.find('#template_store select option.keep').removeClass('keep');
            row.find('#template_store select').show();
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
        if(exist_row.length&&0){
            exist_row.val(parseInt(exist_row.val())+1);
            exist_row.parent().parent().find('input[name=paid]').val(total_price*(parseInt(exist_row.val())));
        }else{
            if($('.product-list tbody tr td').length>1){
                $('.product-list tbody').prepend(row);
            }else{
                $('.product-list tbody').html(row);
            }
        }
        calculate_sale();
        handleUniform();
        $('#mini_value_filter').val('').trigger('keyup');
    }

    if($('#return_form').length){ // Return Detail
        var html = '<tr>'+template_layout.html()+'</tr>';
        var code = element.attr('data-code');
        var name = element.attr('data-name');
        var unit = element.attr('data-unit');
        var store = element.attr('data-store');
        var total_price = element.attr('data-price-export');
        var row = $(html).clone();
        row.find('#template_unit select').show().val(unit).select2();
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
        var exist_row = $('.product-list tbody .quantity[data='+product_id+']');
        if(exist_row.length&&0){
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

// Order Detail
function calculate_sale(){
    $('.sale input[name=quantity]:not(.binded_cs), .sale input[name=total_price]:not(.binded_cs), .sale input[name=commission_percent]:not(.binded_cs), .sale input[name=commission_price]:not(.binded_cs), .sale input[name=tax_percent]:not(.binded_cs)').on('change', function(){
        $(this).removeClass('binded_cs').addClass('binded_cs');
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
        parent.find('input[name=paid]').val(parseInt(final_price*quantity));
        // Show 
        parent.find('input[name=paid]').prev().val(parseInt(final_price*quantity).formatMoney(0));

        // sum_price
        var price = parent.parent().find('input[name=total_price]');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt(parseInt($(price[i]).val())*parseInt($(quantity[i]).val()));
        }
        $('.sale input[name=sum_price]').val(total_price).trigger('change');

        // total_price
        var price = parent.parent().find('span.price');
        var quantity = parent.parent().find('input[name=quantity]');
        var paid = parent.parent().find('input[name=paid]');
        var unpaid = parent.parent().find('input[name=unpaid]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            var multi_price = parseInt(parseInt($(price[i]).attr('data-price'))*parseInt($(quantity[i]).val()));
            total_price+= multi_price;
            $(unpaid[i]).val(multi_price-$(paid[i]).val());
            // Show 
            $(unpaid[i]).prev().val(parseInt(multi_price-$(paid[i]).val()).formatMoney(0));
        }
        $('.sale input[name=paid_cash], .sale input[name=total_price_total]').val(total_price).trigger('change');  

        var check = check_diff_commission_percent_order();
        if(check>=0) $('#commission_percent').val(check);
        else $('#commission_percent').val('Tùy chỉnh');
        var check = check_diff_commission_price_order();
        if(check>=0) $('#commission_price').val(check);
        else $('#commission_price').val('Tùy chỉnh');
        var check = check_diff_tax_percent_order();
        if(check>=0) $('#tax_percent').val(check);
        else $('#tax_percent').val('Tùy chỉnh');

        var paid = $('.sale .product-list input[name=paid]');
        var total_paid = 0;
        for(var i=0;i<paid.length;i++){
            total_paid+= parseInt($(paid[i]).val());
        }
        $('.sale input[name=total_paid]').val(total_paid).trigger('change');
        var remain_paid = $('.calculate_sale input[name=total_price_total]').val()-total_paid;
        if(remain_paid<0) $('.sale input[name=remain_paid]').val('0').trigger('change').attr('data', remain_paid);
        else $('.sale input[name=remain_paid]').val(remain_paid).trigger('change').attr('data', remain_paid);
        calculate_paid_return();
    });

    $('.sale input[name=paid]:not(.binded_cs)').on('change', function(){
        $(this).removeClass('binded_cs').addClass('binded_cs');
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
        // Show 
        parent.find('input[name=unpaid]').prev().val(parseInt(parseInt(final_price*quantity)-parent.find('input[name=paid]').val()).formatMoney(0));

        var paid = $('.sale .product-list input[name=paid]');
        var total_paid = 0;
        for(var i=0;i<paid.length;i++){
            total_paid+= parseInt($(paid[i]).val());
        }
        $('.sale input[name=total_paid]').val(total_paid).trigger('change');
        var remain_paid = $('.calculate_sale input[name=total_price_total]').val()-total_paid;
        if(remain_paid<0) $('.sale input[name=remain_paid]').val('0').trigger('change').attr('data', remain_paid);
        else $('.sale input[name=remain_paid]').val(remain_paid).trigger('change').attr('data', remain_paid);
        calculate_paid_return();
    });

    $('.sale .product-list select.unit_id').unbind('change').on('change', function(){
        var parent = $(this).parent().parent();
        var date_price = $(this).find('option[value='+$(this).val()+']').attr('data-price');
        parent.find('input[name=total_price]').val(date_price).trigger('change');
        // Show 
        parent.find('input[name=total_price]').prev().val(parseInt(date_price).formatMoney(0));
    });

    $('.calculate_sale input[name=paid_cash]:not(.binded_cs), .calculate_sale input[name=paid_card]:not(.binded_cs)').on('change', function(){
        $(this).removeClass('binded_cs').addClass('binded_cs');
        calculate_paid_return();
    });
    
    $('.sale input[name=quantity], .sale input[name=total_price], .sale input[name=commission_percent], .sale input[name=commission_price], .sale input[name=tax_percent]').trigger('change');

    $('.calculate_sale input[name=paid_cash], .calculate_sale input[name=paid_card]').trigger('change');

    calculate_voucher();
}

function calculate_voucher(){
    $('.calculate_sale select[name=voucher_price]:not(.binded_cs)').on('change', function(){
        $(this).removeClass('binded_cs').addClass('binded_cs');
        calculate_paid_return();
    });
    $('.calculate_sale input[name=voucher_quantity]:not(.binded_cs)').on('change', function(){
        $(this).removeClass('binded_cs').addClass('binded_cs');
        calculate_paid_return();
    });

    calculate_paid_return();
    handlePrice();
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
    $('.calculate_sale input[name=paid_get]').val(paid_get).trigger('change');
    var paid_return = total_voucher_price+paid_get-$('.calculate_sale input[name=total_paid]').val();
    var remain_paid = parseInt($('.sale input[name=remain_paid]').attr('data'));
    if(remain_paid<0) paid_return = paid_return - remain_paid;
    if(paid_return<0) $('.calculate_sale input[name=paid_return]').prev().val('Chưa đủ tiền!');
    else $('.calculate_sale input[name=paid_return]').val(paid_return).trigger('change');
}

// Return Detail
function calculate_sale_return(){
    $('.sale .product-list input[name=quantity], .sale .product-list input[name=total_price], .sale .product-list input[name=commission_percent], .sale .product-list input[name=commission_price], .sale input[name=tax_percent]').unbind('keyup').on('keyup', function(){
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
        $('.sale .calculate_sale input[name=sum_price]').val(total_price);

        // total_price
        var price = parent.parent().find('span.price');
        var quantity = parent.parent().find('input[name=quantity]');
        var total_price = 0;
        for(var i=0;i<price.length;i++){
            total_price+= parseInt($(price[i]).attr('data-price'))*parseInt($(quantity[i]).val());
        }
        $('.sale .calculate_sale input[name=total_price]').val(total_price);

        var check = check_diff_commission_percent_return();
        if(check>=0) $('#commission_percent').val(check);
        else $('#commission_percent').val('Tùy chỉnh');
        var check = check_diff_commission_price_return();
        if(check>=0) $('#commission_price').val(check);
        else $('#commission_price').val('Tùy chỉnh');
        var check = check_diff_tax_percent_return();
        if(check>=0) $('#tax_percent').val(check);
        else $('#tax_percent').val('Tùy chỉnh');
        
        $('.sale .product-list input[name=paid]').trigger('keyup');
    });
    $('.sale .product-list input[name=quantity], .sale .product-list input[name=total_price], .sale .product-list input[name=commission_percent], .sale .product-list input[name=commission_price], .sale input[name=tax_percent]').trigger('keyup');

    $('.sale .product-list input[name=paid]').unbind('keyup').on('keyup', function(){
        var paid = $('.sale .product-list input[name=paid]');
        var total_return = 0;
        for(var i=0;i<paid.length;i++){
            total_return+= parseInt($(paid[i]).val());
        }
        $('.sale .calculate_sale input[name=total_return]').val(total_return);
    });
    $('.sale .product-list input[name=paid]').trigger('keyup');
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