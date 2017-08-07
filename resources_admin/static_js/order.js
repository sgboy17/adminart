function validate_order_form(){
    $("#order_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            sum_price: {
                required: true,
            },
            
            total_price: {
                required: true,
            },
            
            total_paid: {
                required: true,
            },
            
            remain_paid: {
                required: true,
            },
            
            paid_return: {
                number: true,
            },
            
        },
        messages: {
            
            sum_price: "Vui lòng điền thành tiền!",

            total_price: "Vui lòng điền tổng cộng!",
            
            total_paid: "Vui lòng điền đã thanh toán!",
            
            remain_paid: "Vui lòng điền thanh toán còn lại!",
            
            paid_return: "Chưa đủ tiền!",
            
        }
    });

      var customer_id = $('.sale input[name=customer_id]').val();
      var customer_object = $('.sale input[name=customer_id]').attr('data-object');
      var customer_score = $('.sale input[name=customer_id]').attr('data-score');
      var customer_address = $('.sale input[name=customer_id]').attr('data-address');
      var customer_phone = $('.sale input[name=customer_id]').attr('data-phone');
      var customer_name = $('.sale #customer_info').val();
      var customer_data = {
        name:customer_name,
        id:customer_id,
        object:customer_object,
        score:customer_score,
        address:customer_address,
        phone:customer_phone,
    }
    $(".sale #customer_info").select2({
        placeholder: "- Tìm khách hàng -",
        ajax: {
          url: base_url+"customer/load_customer_list_view",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params, // search term
            };
          },
          results: function (data, params) {
            params.page = params.page || 1;
            return {
              results: data,
              pagination: {
                more: (params.page * 5) < data.total_count
              }
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 1,
        formatResult: function(repo){
            if (repo.loading) return repo.text;
            var markup = repo.name;
            return markup;
        },
        formatSelection: function(repo){
            $('.sale .customer_info #object').val(repo.object);
            $('.sale .customer_info #score').val(repo.score);
            $('.sale .customer_info #address').val(repo.address);
            $('.sale .customer_info #phone').val(repo.phone);
            $('.sale input[name=customer_id]').val(repo.id);
            return repo.name;
        }
      });
    $(".sale #customer_info").select2('data', customer_data);


    if($('#order_detail_list').length){
        var order_detail_list = $('#order_detail_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"orderdetail/get_order_detail_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 20,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
                    
                
                if($('#id').length) aoData.push( { "name": "f_order_id", "value": $('#id').val() } );
                 
            
                  },
                "fnDrawCallback":function(){
                    $(this).find('tbody tr').removeClass('odd').removeClass('even');
                    $(this).next().attr('style',"display:none;");
                    if($(this).next().next().find('span a').length<=1){
                        $(this).next().next().attr('style',"display:none;");
                    } else {
                        $(this).next().next().attr('style',"display:block;");
                    }
                    calculate_sale();
                    handleUniform();
                    $('.sh-commission').unbind('click').bind('click', function(){
                        if($(this).hasClass('showed')) $(this).removeClass('showed');
                        else $(this).addClass('showed');
                        if($(this).hasClass('showed')) var is_show = 1;
                        else var is_show = 0;
                        if(is_show){
                            $('table.template tr th:nth-child(8), #order_detail_list tr th:nth-child(8)').show();
                            $('table.template tr td:nth-child(8), #order_detail_list tr td:nth-child(8)').show();
                            $(this).html('<i class="fa fa-eye-slash"></i> Ẩn chiết khấu');
                        }else{
                            $('table.template tr th:nth-child(8), #order_detail_list tr th:nth-child(8)').hide();
                            $('table.template tr td:nth-child(8), #order_detail_list tr td:nth-child(8)').hide();
                            $(this).html('<i class="fa fa-eye"></i> Hiện chiết khấu');
                        }
                    });
                    $('.sh-vat').unbind('click').bind('click', function(){
                        if($(this).hasClass('showed')) $(this).removeClass('showed');
                        else $(this).addClass('showed');
                        if($(this).hasClass('showed')) var is_show = 1;
                        else var is_show = 0;
                        if(is_show){
                            $('table.template tr th:nth-child(9), #order_detail_list tr th:nth-child(9)').show();
                            $('table.template tr td:nth-child(9), #order_detail_list tr td:nth-child(9)').show();
                            $(this).html('<i class="fa fa-eye-slash"></i> Ẩn VAT');
                        }else{
                            $('table.template tr th:nth-child(9), #order_detail_list tr th:nth-child(9)').hide();
                            $('table.template tr td:nth-child(9), #order_detail_list tr td:nth-child(9)').hide();
                            $(this).html('<i class="fa fa-eye"></i> Hiện VAT');
                        }
                    });
                    $('.sh-advanced').unbind('click').bind('click', function(){
                        if($(this).hasClass('showed')) $(this).removeClass('showed');
                        else $(this).addClass('showed');
                        if($(this).hasClass('showed')) var is_show = 1;
                        else var is_show = 0;
                        if(is_show){
                            $('table.template tr th:nth-child(11), #order_detail_list tr th:nth-child(11)').show();
                            $('table.template tr td:nth-child(11), #order_detail_list tr td:nth-child(11)').show();
                            $('table.template tr th:nth-child(12), #order_detail_list tr th:nth-child(12)').show();
                            $('table.template tr td:nth-child(12), #order_detail_list tr td:nth-child(12)').show();
                            $('table.template tr th:nth-child(13), #order_detail_list tr th:nth-child(13)').show();
                            $('table.template tr td:nth-child(13), #order_detail_list tr td:nth-child(13)').show();
                            $(this).html('<i class="fa fa-eye-slash"></i> Ẩn nâng cao');
                        }else{
                            $('table.template tr th:nth-child(11), #order_detail_list tr th:nth-child(11)').hide();
                            $('table.template tr td:nth-child(11), #order_detail_list tr td:nth-child(11)').hide();
                            $('table.template tr th:nth-child(12), #order_detail_list tr th:nth-child(12)').hide();
                            $('table.template tr td:nth-child(12), #order_detail_list tr td:nth-child(12)').hide();
                            $('table.template tr th:nth-child(13), #order_detail_list tr th:nth-child(13)').hide();
                            $('table.template tr td:nth-child(13), #order_detail_list tr td:nth-child(13)').hide();
                            $(this).html('<i class="fa fa-eye"></i> Hiện nâng cao');
                        }
                    });
                    $('.sh-commission').trigger('click');
                    $('.sh-vat').trigger('click');
                    $('.sh-advanced').trigger('click');

                    $('#commission_percent').unbind('keyup').bind('keyup', function(){
                        $('#order_detail_list input[name=commission_percent]').val($(this).val());
                        calculate_sale();
                    });
                    $('#commission_price').unbind('keyup').bind('keyup', function(){
                        $('#order_detail_list input[name=commission_price]').val($(this).val());
                        calculate_sale();
                    });
                    $('#tax_percent').unbind('keyup').bind('keyup', function(){
                        $('#order_detail_list input[name=tax_percent]').val($(this).val());
                        calculate_sale();
                    });
                    $('#commission_percent, #commission_price, #tax_percent').unbind('focus').bind('focus', function(){
                        this.select();
                    }).mouseup(function (e) {e.preventDefault(); });;
                }
            });   
    }

    var barcode_enter = false;
    var timer;
    if($('#mini_product_list').length){
        mini_product_list = $('#mini_product_list').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sPaginationType": "full_numbers",
                "sAjaxSource": base_url+"product/get_mini_product_list",
                "bDeferRender": true,
                "bLengthChange": false,
                "bFilter": false,
                "bDestroy": true,
                "iDisplayLength": 3,
                "bSort": false,
                 "fnServerParams": function ( aoData ) {
            
                aoData.push( { "name": "f_product_group_id", "value": $('#mini_product_group_id').val() } );

                aoData.push( { "name": "f_value_filter", "value": $('#mini_value_filter').val() } );

                if($('#mini_value_filter').val()!='') {
                    aoData.push( { "name": "iDisplayLength", "value": 100 } );    
                }
            
                  },
                "fnDrawCallback":function(){
                    if(barcode_enter) {
                        barcode_enter = false;
                        $('#mini_product_list tbody > tr:first-child').find('a').trigger('click');
                        $("#mini_value_filter").val('');
                        setTimeout(function(){mini_product_list.fnDraw();},400);
                    }
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

                    if($("#mini_product_group_id").val()!=''&&has_add_group){
                        var oSettings = mini_product_list.fnSettings();
                        $("#mini_product_group_id").val('');
                        $('#mini_product_list a').trigger('click');
                        has_add_group = false;
                        oSettings._iDisplayLength = 3;
                        mini_product_list.fnDraw(); 
                        $('#add_group a').attr('class','btn btn-default').attr('style','cursor: default;');
                    }

                    handleUniform();
                }
            });

        $("#mini_value_filter").focus(function(){
            this.select();
        }).mouseup(function (e) {e.preventDefault(); });
        setInterval(function(){
            if ( $('input:focus, select:focus, textarea:focus').length == 0 ){
                $("#mini_value_filter").focus();
            }
        },1000);
                
         $("#mini_value_filter").on("keyup", function (e) {
            if(e.which==118){
                save_order(false);
            }else if(e.which==119){
                save_order(true);
            }else{
                clearInterval(timer);  //clear any interval on key up
                timer = setTimeout(function() { //then give it a second to see if the user is finished
                    if(e.keyCode==13) barcode_enter = true;
                    else barcode_enter = false;
                    mini_product_list.fnDraw(); 
                }, 100);
            }
        });
                
         $("#mini_product_group_id").on("change", function () {
            mini_product_list.fnDraw(); 
            if($(this).val()=='') $('#add_group a').attr('class','btn btn-default').attr('style','cursor: default;');
            else $('#add_group a').attr('class','btn btn-danger').attr('style','');
        });
    }
    handleUniform();
}

var mini_product_list, has_add_group = false;
function add_group(){
    if($("#mini_product_group_id").val()!=''){
        var oSettings = mini_product_list.fnSettings();
        oSettings._iDisplayLength = 20;
        has_add_group = true;
        mini_product_list.fnDraw(); 
    }
}

if($('#order_form').length){
    validate_order_form();
}

function save_order(has_print){
    var quantity = '';
    var key = '';
    var order_type = '';
    var id_textbox = $('form .quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val().replace(/,/g,'')+',';
        else quantity += $(id_textbox[i]).val().replace(/,/g,'');

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');

        if(i!=id_textbox.length-1) order_type += $(id_textbox[i]).attr('data-type')+',';
        else order_type += $(id_textbox[i]).attr('data-type');
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

    var paid = '';
    var id_textbox = $('form .paid');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) paid += $(id_textbox[i]).val().replace(/,/g,'')+',';
        else paid += $(id_textbox[i]).val().replace(/,/g,'');
    }

    var unpaid = '';
    var id_textbox = $('form .unpaid');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unpaid += $(id_textbox[i]).val().replace(/,/g,'')+',';
        else unpaid += $(id_textbox[i]).val().replace(/,/g,'');
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
        commission_price[i] = $(id_textbox[i]).val().replace(/,/g,'');
    }

    var commission_percent = [];
    var id_textbox = $('form .commission_percent');
    for(var i=0; i<id_textbox.length; i++){
        commission_percent[i] = $(id_textbox[i]).val().replace(/,/g,'');
    }

    var commission = '';
    for(var i=0; i<commission_price.length; i++){
        if(i!=commission_price.length-1) commission += commission_price[i]+'|'+commission_percent[i]+',';
        else commission += commission_price[i]+'|'+commission_percent[i];
    }

    var voucher_price = '';
    var id_textbox = $('form .voucher_price');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) voucher_price += $(id_textbox[i]).val().replace(/,/g,'')+',';
        else voucher_price += $(id_textbox[i]).val().replace(/,/g,'');
    }

    var voucher_quantity = '';
    var id_textbox = $('form .voucher_quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) voucher_quantity += $(id_textbox[i]).val().replace(/,/g,'')+',';
        else voucher_quantity += $(id_textbox[i]).val().replace(/,/g,'');
    }

    $('#key').val(key);
    $('#order_type').val(order_type);
    $('#quantity').val(quantity);
    $('#unit_id').val(unit_id);
    $('#vat').val(vat);
    $('#product_paid').val(paid);
    $('#product_unpaid').val(unpaid);
    $('#store_id').val(store_id);
    $('#product_price').val(price);
    $('#commission').val(commission);
    $('#order_voucher_price').val(voucher_price);
    $('#order_voucher_quantity').val(voucher_quantity);

    if($("#order_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'order/save_order_add',
           data:$('#order_form').serialize(),
           dataType: 'json',
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
                if(!has_print){
                    document.location.href = document.location.href ;
                    $.unblockUI();
                }else{
                    document.location.href = print_url+'?id='+resp.id ;
                    $.unblockUI();
                }
            }
        });   
     }
}