if($('#setting_list').length){
	var setting_list = $('#setting_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"setting/get_setting_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
        
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
        
}


function setting_save(){
    var setting_key = '';
    var code_char = '';
    var id_textbox = $('.code_char');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) code_char += $(id_textbox[i]).val()+',';
        else code_char += $(id_textbox[i]).val();

        if(i!=id_textbox.length-1) setting_key += $(id_textbox[i]).attr('data')+',';
        else setting_key += $(id_textbox[i]).attr('data');
    }

    var code_number = '';
    var id_textbox = $('.code_number');
    for(var i=0; i<id_textbox.length; i++){
        if(i!=id_textbox.length-1) code_number += $(id_textbox[i]).val()+',';
        else code_number += $(id_textbox[i]).val();
    }

    var code_is_number_first = '';
    var id_checkbox = $('.code_is_number_first');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) code_is_number_first += '1,';
            else code_is_number_first += '1';
        }else{
            if(i!=id_checkbox.length-1) code_is_number_first += '0,';
            else code_is_number_first += '0';
        }
    }

    var code_is_branch_follow = '';
    var id_checkbox = $('.code_is_branch_follow');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) code_is_branch_follow += '1,';
            else code_is_branch_follow += '1';
        }else{
            if(i!=id_checkbox.length-1) code_is_branch_follow += '0,';
            else code_is_branch_follow += '0';
        }
    }

    var general_vat = $('#general_vat').val();
    var general_expired = $('#general_expired').val();
    var general_product_avatar = $('#general_product_avatar').val();
    
     jQuery.ajax({
       type:'POST',
       url:base_url+'setting/save_setting_edit',
       data:{
        setting_key: setting_key,
        code_char: code_char,
        code_number: code_number,
        code_is_number_first: code_is_number_first,
        code_is_branch_follow: code_is_branch_follow,
        general_vat: general_vat,
        general_expired: general_expired,
        general_product_avatar: general_product_avatar
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
