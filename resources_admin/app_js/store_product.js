if($('#store_product_list').length){
	var store_product_list = $('#store_product_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"storeproduct/get_store_product_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                

            aoData.push( { "name": "f_search", "value": $('#search').val() } );
            
            aoData.push( { "name": "f_product_group_id", "value": $('#product_group_id').val() } );
                
            aoData.push( { "name": "f_store_id", "value": $('#store_id').val() } );
                
        
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
                $('.price').on('keyup', function(){
                    var product = $(this).attr('data');
                    var value = $(this).val();
                    $('.price_'+product).val(value);
                });
                $('.unit_id').on('change', function(){
                    var product = $(this).attr('data');
                    var value = $(this).val();
                    $('.unit_id_'+product).val(value);
                });

                handleUniform();
	        }
		});

              
     $("#search").on("keyup", function () {
        store_product_list.fnDraw(); 
    });
            
     $("#product_group_id").on("change", function () {
        store_product_list.fnDraw(); 
    });
                
     $("#store_id").on("change", function () {
        store_product_list.fnDraw(); 
    });
                
        
}

function store_product_save(){
    var quantity = '';
    var key = '';
    var id_textbox = $('.quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');
    }

    var unit_id = '';
    var id_textbox = $('.unit_id');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) unit_id += $(id_textbox[i]).val()+',';
        else unit_id += $(id_textbox[i]).val();
    }

    var price = '';
    var id_textbox = $('.price');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) price += $(id_textbox[i]).val()+',';
        else price += $(id_textbox[i]).val();
    }

     jQuery.ajax({
       type:'POST',
       url:base_url+'storeproduct/save_store_product_edit',
       data:{
        quantity: quantity,
        unit_id: unit_id,
        price: price,
        key: key,
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

if($('#store_product_report').length){
    var store_product_report = $('#store_product_report').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": base_url+"storeproduct/get_store_product_report",
            "bDeferRender": true,
            "bLengthChange": false,
            "bFilter": false,
            "bDestroy": true,
            "iDisplayLength": 20,
            "bSort": false,
             "fnServerParams": function ( aoData ) {
                

            aoData.push( { "name": "f_search", "value": $('#search').val() } );
            
            aoData.push( { "name": "f_product_group_id", "value": $('#product_group_id').val() } );
                
            aoData.push( { "name": "f_store_id", "value": $('#store_id').val() } );
                
            aoData.push( { "name": "f_stock_status", "value": $('#stock_status').val() } );
                
        
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
        store_product_report.fnDraw(); 
    });
            
     $("#product_group_id").on("change", function () {
        store_product_report.fnDraw(); 
    });
                
     $("#store_id").on("change", function () {
        store_product_report.fnDraw(); 
    });
                
     $("#stock_status").on("change", function () {
        store_product_report.fnDraw(); 
    });
                
        
}
