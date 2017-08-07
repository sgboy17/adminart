if($('#employee_list').length){
	var employee_list = $('#employee_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"employee/get_employee_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
        
            
            aoData.push( { "name": "f_gender", "value": $('#gender').val() } );
                
            aoData.push( { "name": "f_country_id", "value": $('#country_id').val() } );
                
            aoData.push( { "name": "f_city_id", "value": $('#city_id').val() } );
                
            aoData.push( { "name": "f_district_id", "value": $('#district_id').val() } );
                
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
        employee_list.fnDraw(); 
    });
        
            
     $("#gender").on("change", function () {
        employee_list.fnDraw(); 
    });
                
     $("#country_id").on("change", function () {
        employee_list.fnDraw(); 
    });
                
     $("#city_id").on("change", function () {
        employee_list.fnDraw(); 
    });
                
     $("#district_id").on("change", function () {
        employee_list.fnDraw(); 
    });
                
     $("#status").on("change", function () {
        employee_list.fnDraw(); 
    });
     
    handleImport();
                
        
}

function delete_employee_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'employee/delete_employee',
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

function delete_employee(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'employee/delete_employee',
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


function validate_employee_form(){
    handleUpload();
    $("#employee_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            email: {
                required: true,
                email: true,
            },
            
            birthday: {
                required: true,
            },
            
            gender: {
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
            
            email: {
                required: "Vui lòng điền email!",
                email: "Email không hợp lệ!",
            },
            
            birthday: "Vui lòng điền ngày sinh!",
            
            gender: "Vui lòng điền giới tính!",
            
            country_id: "Vui lòng điền quốc gia!",
            
            city_id: "Vui lòng điền tỉnh/thành!",
            
            district_id: "Vui lòng điền quận/huyện!",
            
            status: "Vui lòng điền tình trạng!",
            
        }
    });
    handleLocation();
    handleUniform();
}
        

function load_employee_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'employee/load_employee_add',
        beforeSend: function(xhr) {
            jQuery("#employee_detail #employee_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#employee_detail #employee_form").html(resp);
            validate_employee_form();
        }
    });  
}

function load_employee_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'employee/load_employee_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#employee_detail #employee_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#employee_detail #employee_form").html(resp);
            validate_employee_form();
        }
    });  
}

function save_employee_add(element){
    if($("#employee_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'employee/save_employee_add',
           data:$('#employee_form').serialize(),
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
                $('label.error').remove();
                if(parseInt(resp)==20){
                  $('<label for="email" generated="true" class="error">Email này đã được sử dụng!</label>').insertAfter($('#email'));
                    $.unblockUI();
                }else{
                    if($('.paginate_active').length) $('.paginate_active').trigger('click');
                    else document.location.href = document.location.href ;
                    $.unblockUI();
                    element.next().trigger('click');
                }
            }
        });   
     }
}

function save_employee_edit(element){
    if($("#employee_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'employee/save_employee_edit',
           data:$('#employee_form').serialize(),
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
                $('label.error').remove();
                if(parseInt(resp)==20){
                  $('<label for="email" generated="true" class="error">Email này đã được sử dụng!</label>').insertAfter($('#email'));
                    $.unblockUI();
                }else{
                    if($('.paginate_active').length) $('.paginate_active').trigger('click');
                    else document.location.href = document.location.href ;
                    $.unblockUI();
                    element.next().trigger('click');
                }
            }
        });   
    }
}
