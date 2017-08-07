if($('#send_list').length){
	var send_list = $('#send_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"send/get_send_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            aoData.push( { "name": "f_from_date", "value": $('#from_date').val() } );
                
            aoData.push( { "name": "f_to_date", "value": $('#to_date').val() } );
                
        
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

    
            
            
     $("#from_date").on("change", function () {
        send_list.fnDraw(); 
    });
                
     $("#to_date").on("change", function () {
        send_list.fnDraw(); 
    });
                
        
}

function validate_send_form(type){
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
    
    if(type==1){
        $("#send_form").validate({
            ignore: null,
            ignore: 'input[type="hidden"]',
            rules: {
                
                email_id: {
                    required: true,
                },
                
            },
            messages: {

                email_id: "Vui lòng điền mẫu email!",
                
            }
        });
    }else{
        $("#send_form").validate({
            ignore: null,
            ignore: 'input[type="hidden"]',
            rules: {
                
                sms_id: {
                    required: true,
                },
                
            },
            messages: {

                sms_id: "Vui lòng điền mẫu sms!",
                
            }
        });
    }
    handleUniform();
}
        

function load_send_add(type){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'send/load_send_add',
        data: {
            type: type,
        },
        beforeSend: function(xhr) {
            jQuery("#send_detail #send_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#send_detail #send_form").html(resp);
            validate_send_form(type);
        }
    });  
}

function save_send_add(element){
    if($("#send_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'send/save_send_add',
           data:$('#send_form').serialize(),
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
