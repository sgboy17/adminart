if($('#currency_list').length){
	var currency_list = $('#currency_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"currency/get_currency_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            
            aoData.push( { "name": "f_position", "value": $('#position').val() } );
                
            aoData.push( { "name": "f_is_base", "value": $('#is_base').val() } );
                
        
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
        currency_list.fnDraw(); 
    });
        
            
     $("#position").on("change", function () {
        currency_list.fnDraw(); 
    });
                
     $("#is_base").on("change", function () {
        currency_list.fnDraw(); 
    });
                
        
}

function delete_currency_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'currency/delete_currency',
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

function delete_currency(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'currency/delete_currency',
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


function validate_currency_form(){
    $("#currency_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            value: {
                required: true,
            },
            
            position: {
                required: true,
            },
            
            is_base: {
                required: true,
            },
            
        },
        messages: {
            
            value: "Vui lòng điền giá trị tiền tệ!",
            
            position: "Vui lòng điền vị trí biểu tượng!",
            
            is_base: "Vui lòng điền tiền tệ mặc định!",
            
        }
    });
}
        

function load_currency_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'currency/load_currency_add',
        beforeSend: function(xhr) {
            jQuery("#currency_detail #currency_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#currency_detail #currency_form").html(resp);
            validate_currency_form();
        }
    });  
}

function load_currency_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'currency/load_currency_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#currency_detail #currency_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#currency_detail #currency_form").html(resp);
            validate_currency_form();
        }
    });  
}

function save_currency_add(element){
    if($("#currency_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'currency/save_currency_add',
           data:$('#currency_form').serialize(),
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

function save_currency_edit(element){
    if($("#currency_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'currency/save_currency_edit',
           data:$('#currency_form').serialize(),
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
