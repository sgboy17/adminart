if($('#bill_bank_list').length){
	var bill_bank_list = $('#bill_bank_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"billbank/get_bill_bank_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_branch_id", "value": $('.bill_bank #branch_id').val() } );
                
            aoData.push( { "name": "f_bank_id", "value": $('.bill_bank #bank_id').val() } );
                
        
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
                handlePriceBranchBank();
	        }
		});

    
            
            
     $(".bill_bank #branch_id").on("change", function () {
        bill_bank_list.fnDraw(); 
    });
                
     $(".bill_bank #bank_id").on("change", function () {
        bill_bank_list.fnDraw(); 
    });  
        
}

function bill_bank_save(){
    var price_bank = '';
    var key = '';
    var id_textbox = $('.price_bank');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) price_bank += $(id_textbox[i]).val()+',';
        else price_bank += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) key += $(id_textbox[i]).attr('data')+',';
        else key += $(id_textbox[i]).attr('data');
    }
    
     jQuery.ajax({
       type:'POST',
       url:base_url+'billbank/save_bill_bank_edit',
       data:{
        price_bank: price_bank,
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
