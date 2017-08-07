if($('#barcode_list').length){
	var barcode_list = $('#barcode_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"barcode/get_barcode_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            
            aoData.push( { "name": "f_product_group_id", "value": $('#product_group_id').val() } );
            
            aoData.push( { "name": "f_template", "value": $('#template').val() } );
                
        
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
        barcode_list.fnDraw(); 
    });
        
            
     $("#product_group_id").on("change", function () {
        barcode_list.fnDraw(); 
    });
        
            
     $("#template").on("change", function () {
        barcode_list.fnDraw(); 
    });
                
        
}

function barcode_save(){
    var quantity = '';
    var key = '';
    var id_textbox = $('.quantity');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) quantity += $(id_textbox[i]).val()+',';
        else quantity += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');
    }

     jQuery.ajax({
       type:'POST',
       url:base_url+'barcode/save_barcode_edit',
       data:{
        quantity: quantity,
        key: key,
        template: $('#template').val(),
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

function barcode_print(){
    var template = $('#template').val();
    var product_group_id = $('#product_group_id').val();
    var search = $('#search').val();
    document.location.href = barcode_print_url+'?template='+template+'&product_group_id='+product_group_id+'&search='+search;
}

function barcode_print_all(){
    var template = $('#template').val();
    document.location.href = barcode_print_url+'?template='+template;
}