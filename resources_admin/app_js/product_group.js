if($('#product_group_list').length){
	var product_group_list = $('#product_group_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"productgroup/get_product_group_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            
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
        product_group_list.fnDraw(); 
    });
        
            
     $("#status").on("change", function () {
        product_group_list.fnDraw(); 
    });
                
        
}

function delete_product_group_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'productgroup/delete_product_group',
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

function delete_product_group(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'productgroup/delete_product_group',
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


function validate_product_group_form(){
    $("#product_group_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            status: "Vui lòng điền tình trạng!",
            
        }
    });
}
        

function load_product_group_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'productgroup/load_product_group_add',
        beforeSend: function(xhr) {
            jQuery("#product_group_detail #product_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#product_group_detail #product_group_form").html(resp);
            validate_product_group_form();
        }
    });  
}

function load_product_group_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'productgroup/load_product_group_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#product_group_detail #product_group_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#product_group_detail #product_group_form").html(resp);
            validate_product_group_form();
        }
    });  
}

function save_product_group_add(element){
    if($("#product_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'productgroup/save_product_group_add',
           data:$('#product_group_form').serialize(),
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

function save_product_group_edit(element){
    if($("#product_group_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'productgroup/save_product_group_edit',
           data:$('#product_group_form').serialize(),
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
