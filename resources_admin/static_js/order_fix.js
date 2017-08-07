function validate_order_fix_form(){
    $("#order_fix_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            store_id: {
                required: true,
            },
            
        },
        messages: {

            store_id: "Vui lòng điền kho hàng!",
            
        }
    });
    handleUniform();
}

function load_order_fix_add(element){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderfix/load_order_fix_add',
        beforeSend: function(xhr) {
            jQuery("#order_fix_detail #order_fix_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_fix_detail #order_fix_form").html(resp);
            validate_order_fix_form();
            $('.current_fix').removeClass('current_fix');
            element.addClass('current_fix');
        }
    });  
}

function load_order_fix_edit(id, element){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'orderfix/load_order_fix_edit',
        data: {
            id: id,
        },
        beforeSend: function(xhr) {
            jQuery("#order_fix_detail #order_fix_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#order_fix_detail #order_fix_form").html(resp);
            validate_order_fix_form();
            $('.current_fix').removeClass('current_fix');
            element.addClass('current_fix');
        }
    });  
}

function save_order_fix_add(element){
    if($("#order_fix_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderfix/save_order_fix_add',
           data:$('#order_fix_form').serialize(),
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
                $.unblockUI();
                $('.current_fix').parent().parent().find('.quantity').attr('data-type', resp);
                $('.current_fix').parent().html('<a href="#order_fix_detail" onclick="load_order_fix_edit('+resp+', $(this));" data-toggle="modal"><span class="label label-info tooltips" data-html="true" data-original-title="Xem sửa đồ"><i class="fa fa-eye"></i></span></a>');
                element.next().trigger('click');
            }
        });   
     }
}

function save_order_fix_edit(element){
    if($("#order_fix_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'orderfix/save_order_fix_edit',
           data:$('#order_fix_form').serialize(),
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
                $.unblockUI();
                $('.current_fix').parent().parent().find('.quantity').attr('data-type', resp);
                $('.current_fix').parent().html('<a href="#order_fix_detail" onclick="load_order_fix_edit('+resp+', $(this));" data-toggle="modal"><span class="label label-info tooltips" data-html="true" data-original-title="Xem sửa đồ"><i class="fa fa-eye"></i></span></a>');
                element.next().trigger('click');
            }
        });   
    }
}
