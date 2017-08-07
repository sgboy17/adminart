if($('#permission_list').length){
	var permission_list = $('#permission_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"permission/get_permission_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
                
            
            
            aoData.push( { "name": "f_user_group_id", "value": $('.tree-demo a.active').attr('data-user-group-id') } );
                
            aoData.push( { "name": "f_user_id", "value": $('.tree-demo a.active').attr('data-user-id') } );
                
        
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
                if($('.check_all_view').length){
                    $('.check_all_view').on('click', function(){
                        if(!$('.check_all_view').prop('checked')){
                            $('.id_view:checked').trigger('click');
                        }else{
                            $('.id_view:not(.id_view:checked)').trigger('click');
                        }
                    });
                }
                if($('.check_all_add').length){
                    $('.check_all_add').on('click', function(){
                        if(!$('.check_all_add').prop('checked')){
                            $('.id_add:checked').trigger('click');
                        }else{
                            $('.id_add:not(.id_add:checked)').trigger('click');
                        }
                    });
                }
                if($('.check_all_edit').length){
                    $('.check_all_edit').on('click', function(){
                        if(!$('.check_all_edit').prop('checked')){
                            $('.id_edit:checked').trigger('click');
                        }else{
                            $('.id_edit:not(.id_edit:checked)').trigger('click');
                        }
                    });
                }
                if($('.check_all_delete').length){
                    $('.check_all_delete').on('click', function(){
                        if(!$('.check_all_delete').prop('checked')){
                            $('.id_delete:checked').trigger('click');
                        }else{
                            $('.id_delete:not(.id_delete:checked)').trigger('click');
                        }
                    });
                }
                handleUniform();
	        }
		});

    
    $('.tree-demo a').on('click', function(){
        $('.tree-demo a').removeClass('active');
        $(this).addClass('active');
        permission_list.fnDraw();
    });        
        
}

function permission_save(){
    var permission_view = '';
    var id_checkbox = $('.id_view');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) permission_view += $(id_checkbox[i]).val()+'-1,';
            else permission_view += $(id_checkbox[i]).val()+'-1';
        }else{
            if(i!=id_checkbox.length-1) permission_view += $(id_checkbox[i]).val()+'-0,';
            else permission_view += $(id_checkbox[i]).val()+'-0';
        }
    }
    var permission_add = '';
    var id_checkbox = $('.id_add');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) permission_add += $(id_checkbox[i]).val()+'-1,';
            else permission_add += $(id_checkbox[i]).val()+'-1';
        }else{
            if(i!=id_checkbox.length-1) permission_add += $(id_checkbox[i]).val()+'-0,';
            else permission_add += $(id_checkbox[i]).val()+'-0';
        }
    }
    var permission_edit = '';
    var id_checkbox = $('.id_edit');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) permission_edit += $(id_checkbox[i]).val()+'-1,';
            else permission_edit += $(id_checkbox[i]).val()+'-1';
        }else{
            if(i!=id_checkbox.length-1) permission_edit += $(id_checkbox[i]).val()+'-0,';
            else permission_edit += $(id_checkbox[i]).val()+'-0';
        }
    }
    var permission_delete = '';
    var id_checkbox = $('.id_delete');
    for(var i=0; i<id_checkbox.length; i++){
        if($(id_checkbox[i]).prop('checked')){
            if(i!=id_checkbox.length-1) permission_delete += $(id_checkbox[i]).val()+'-1,';
            else permission_delete += $(id_checkbox[i]).val()+'-1';
        }else{
            if(i!=id_checkbox.length-1) permission_delete += $(id_checkbox[i]).val()+'-0,';
            else permission_delete += $(id_checkbox[i]).val()+'-0';
        }
    }
    
     jQuery.ajax({
       type:'POST',
       url:base_url+'permission/save_permission_edit',
       data:{
        permission_view: permission_view,
        permission_add: permission_add,
        permission_edit: permission_edit,
        permission_delete: permission_delete,
        user_group_id: $('.tree-demo a.active').attr('data-user-group-id'),
        user_id: $('.tree-demo a.active').attr('data-user-id')
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
