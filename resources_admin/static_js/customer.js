
function validate_customer_form(){
    $('select[name=status]').val(1);
    handleUpload();
    $("#customer_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            
            object_id: {
                required: true,
            },
            
            status: {
                required: true,
            },
            
        },
        messages: {
            
            object_id: "Vui lòng điền nhóm!",

            status: "Vui lòng điền tình trạng!",
            
        }
    });
    handleLocation();
    handleUniform();
}
        

function load_customer_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'customer/load_customer_add',
        beforeSend: function(xhr) {
            jQuery("#customer_detail #customer_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#customer_detail #customer_form").html(resp).prepend('<input type="hidden" name="quick_customer" value="1" />');
            validate_customer_form();
        }
    });  
}

function save_customer_add(element){
    if($("#customer_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'customer/save_customer_add',
           data:$('#customer_form').serialize(),
           dataType: 'json',
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
                $(".sale #customer_info").select2('data', {name:resp.name, id:resp.id});
                element.next().trigger('click');
            }
        });   
     }
}