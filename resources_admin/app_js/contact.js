if($('#contact_list').length){
	var contact_list = $('#contact_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"contact/get_contact_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            aoData.push( { "name": "f_search", "value": $('#search').val() } );
                   
        
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
        contact_list.fnDraw(); 
    });
        
                
        
}

function delete_contact_multiple(){
    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){
        var id_checkbox = $('.id:checked');
        var id = '';
        for(var i=0; i<id_checkbox.length; i++){
            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';
            else id += $(id_checkbox[i]).val();
        }
        jQuery.ajax({
            type: 'POST',
            url: base_url+'contact/delete_contact',
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

function delete_contact(id){
	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'contact/delete_contact',
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


function validate_contact_form(){
    var customer_id = $('.modal input[name=customer_id]').val();
      var customer_object = $('.modal input[name=customer_id]').attr('data-object');
      var customer_score = $('.modal input[name=customer_id]').attr('data-score');
      var customer_address = $('.modal input[name=customer_id]').attr('data-address');
      var customer_phone = $('.modal input[name=customer_id]').attr('data-phone');
      var customer_name = $('.modal #customer_info').val();
      var customer_data = {
        name:customer_name,
        id:customer_id,
        object:customer_object,
        score:customer_score,
        address:customer_address,
        phone:customer_phone,
    }
    $(".modal #customer_info").select2({
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
            $('.modal .customer_info #object').val(repo.object);
            $('.modal .customer_info #score').val(repo.score);
            $('.modal .customer_info #address').val(repo.address);
            $('.modal .customer_info #phone').val(repo.phone);
            $('.modal input[name=customer_id]').val(repo.id);
            return repo.name;
        }
      });
    $(".modal #customer_info").select2('data', customer_data);

    $('#object_type').on("change", function(){
        var value = $(this).val();
        $('.object_type').hide();
        $('.object_type select').select2('val','');
        $('.object_type_'+value).show();
        var form = $('#contact_form').get(0);
        $.removeData(form,'validator');
        if(value==1){ // customer
            $("#contact_form").validate({
                ignore: null,
                ignore: 'input[type="hidden"]',
                rules: {
                    
                    customer_id: {
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
                    
                },
                messages: {
                    
                    customer_id: "Vui lòng điền khách hàng!",
                    
                    country_id: "Vui lòng điền quốc gia!",
                    
                    city_id: "Vui lòng điền thành phố!",
                    
                    district_id: "Vui lòng điền quận huyện!",
                    
                }
            });
        }else{ // supplier
            $("#contact_form").validate({
                ignore: null,
                ignore: 'input[type="hidden"]',
                rules: {
                    
                    supplier_id: {
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
                    
                },
                messages: {
                    
                    supplier_id: "Vui lòng điền nhà cung cấp!",
                    
                    country_id: "Vui lòng điền quốc gia!",
                    
                    city_id: "Vui lòng điền thành phố!",
                    
                    district_id: "Vui lòng điền quận huyện!",
                    
                }
            });
        }
    });
    $('#object_type').trigger('change');
    handleLocation();
    handleUniform();
}
        

function load_contact_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'contact/load_contact_add',
        beforeSend: function(xhr) {
            jQuery("#contact_detail #contact_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#contact_detail #contact_form").html(resp);
            validate_contact_form();
        }
    });  
}

function load_contact_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'contact/load_contact_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#contact_detail #contact_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#contact_detail #contact_form").html(resp);
            validate_contact_form();
        }
    });  
}

function save_contact_add(element){
    if($("#contact_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'contact/save_contact_add',
           data:$('#contact_form').serialize(),
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

function save_contact_edit(element){
    if($("#contact_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'contact/save_contact_edit',
           data:$('#contact_form').serialize(),
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
