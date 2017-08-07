if($('#supplier_list').length){
	var supplier_list = $('#supplier_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"supplier/get_supplier_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_type_search", "value": $('#type_search').val() } );

            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            aoData.push( { "name": "f_object_id", "value": $('#object_id').val() } );
                
            aoData.push( { "name": "f_country_id", "value": $('#country_id').val() } );
                
            aoData.push( { "name": "f_city_id", "value": $('#city_id').val() } );
                
            aoData.push( { "name": "f_district_id", "value": $('#district_id').val() } );
                
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
        supplier_list.fnDraw(); 
    });
        
                
     $("#status").on("change", function () {
        supplier_list.fnDraw(); 
    });
           
    handleLocationFilter();     
     
    handleImport();
        
}

function supplier_list_filter(){
    $('#type_search').val('1');
     supplier_list.fnDraw(); 
     $('.modal .close').trigger('click');
}

function delete_supplier_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'supplier/delete_supplier',
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

function delete_supplier(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'supplier/delete_supplier',
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


function validate_supplier_form(){
    handleUpload();
    $("#supplier_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            object_id: {
                required: true,
            },
            
            country_id: {
                required: true,
            },
            
            city_id: {
                required: true,
            },
            
            district_id: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            object_id: "Vui lòng điền nhóm!",
            
            country_id: "Vui lòng điền quốc gia!",
            
            city_id: "Vui lòng điền thành phố!",
            
            district_id: "Vui lòng điền quận huyện!",
            
            status: "Vui lòng điền tình trạng!",
            
        }
    });
    handleLocation();
    handleUniform();
}
        

function load_supplier_list(product_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'supplier/get_mini_supplier_list',
        data:{
            product_id: product_id
        },
        beforeSend: function(xhr) {
            jQuery("#supplier_list_detail #supplier_list_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#supplier_list_detail #supplier_list_form").html(resp);
        }
    });  
}

function load_supplier_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'supplier/load_supplier_add',
        beforeSend: function(xhr) {
            jQuery("#supplier_detail #supplier_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#supplier_detail #supplier_form").html(resp);
            validate_supplier_form();
        }
    });  
}

function load_supplier_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'supplier/load_supplier_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#supplier_detail #supplier_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#supplier_detail #supplier_form").html(resp);
            validate_supplier_form();
        }
    });  
}

function save_supplier_add(element){
    if($("#supplier_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'supplier/save_supplier_add',
           data:$('#supplier_form').serialize(),
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

function save_supplier_edit(element){
    if($("#supplier_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'supplier/save_supplier_edit',
           data:$('#supplier_form').serialize(),
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

function module_load_contact_add(){
    var html = $('#contact_template').html();
    $('<div class="row">'+html+'</div>').insertBefore('#contact_template');
}

function module_delete_contact(element){
    element.parent().parent().remove();
}