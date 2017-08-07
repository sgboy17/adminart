//image
var image_upload = '';
function add_event_image_upload(){
	image_upload = {
	    uploader: false,
	    start_upload: function() {
	        image_upload.uploader = new plupload.Uploader({
	            runtimes: 'html5,flash,html4',
	            browse_button: 'image_upload',
	            max_file_size: '10mb',
	            url: base_url+'api/upload_img/',
	            flash_swf_url: '/resources_admin/plugins/plupload/plupload.flash.swf',
	            filters: [
	                {title: "Image files", extensions: "jpg,gif,png"}

	            ]
	        });

	        image_upload.uploader.bind('FilesAdded', function(up, files) {
	            jQuery("#image_upload").html("Uploading...").attr('disabled', 'disabled');
	            jQuery("#image_src").html('<img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" style="margin-top: 8px;" />');
	            if (image_upload.uploader.runtime === 'flash' || image_upload.uploader.runtime === 'html5') {
	                setTimeout('image_upload.uploader.start()', 100);
	            }

	        });
	        jQuery('input[type="file"]').change(function() {
	            image_upload.uploader.start();

	        });
	        image_upload.uploader.bind('UploadProgress', function(up, file) {


	        });

	        image_upload.uploader.bind('FileUploaded', function(up, file, response) {
	            jQuery("#image_upload").html("Select image").removeAttr('disabled');
	            jQuery("#image_src").html('<img src="'+base_url+'upload/thumb_' + response.response + '" />');
	            jQuery("#image").val(response.response);
	        });
	        image_upload.uploader.init();
	    }

	};
	image_upload.start_upload();
}

//file
var file_upload = '';
function add_event_file_upload(){
	file_upload = {
	    uploader: false,
	    start_upload: function() {
	        file_upload.uploader = new plupload.Uploader({
	            runtimes: 'html5,flash,html4',
	            browse_button: 'file_upload',
	            max_file_size: '2mb',
	            url: base_url+'api/upload_file/',
	            flash_swf_url: '/resources_admin/plugins/plupload/plupload.flash.swf',
	            filters: [
	                {title: "Import files", extensions: "pdf"}

	            ]
	        });

	        file_upload.uploader.bind('FilesAdded', function(up, files) {
	            if(files[0].size>2*1024*1024){
	                jQuery(".fileinput-filename").html('File size must be under 2MB!');
	            }
	            else{
	                jQuery("#file_upload").html("Uploading...").attr('disabled', 'disabled');
	                jQuery("#upload_btn").attr('disabled','disabled');
	                jQuery(".file_upload_progress").fadeIn();
	                jQuery(".fileinput-exists").removeClass('fileinput-exists');
	                jQuery(".fileinput-filename").html(files[0].name);
	                if (file_upload.uploader.runtime === 'flash' || file_upload.uploader.runtime === 'html5') {
	                    setTimeout('file_upload.uploader.start()', 100);
	                }
	                can_load = false;
	            }

	        });
	        jQuery('input[type="file"]').change(function() {
	            file_upload.uploader.start();
	        });
	        file_upload.uploader.bind('UploadProgress', function(up, file) {
	            if(file.percent>5) jQuery('.file_upload_progress > div').attr('aria-valuenow',file.percent).attr('style','width: '+file.percent+'%');
	        });

	        file_upload.uploader.bind('FileUploaded', function(up, file, response) {
                jQuery(".file_upload_progress").fadeOut();
                jQuery("#file_upload").html("Select file").removeAttr('disabled');
                setTimeout(function(){jQuery('.file_upload_progress > div').attr('aria-valuenow',0).attr('style','width: 0%')},500);
	            jQuery("#file").val(response.response);
	        });
	        file_upload.uploader.init();

	    }
	};
	file_upload.start_upload();
}

// Company
if($('#company_list').length){
	var company_list = $('#company_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_company_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
	            aoData.push( { "name": "f_search", "value": $('#search').val() } );
	            aoData.push( { "name": "f_user_id", "value": $('#user_id').val() } );
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
	        }
		});

	 $("#search").on("keyup", function () {
	    company_list.fnDraw(); 
	});
}

function validate_company_form(){
    $("#company_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            address: {
                required: true,
            },
            name: {
                required: true,
            },
            email: {
                email: true,
                required: true,
            },
        },
        messages: {
            address: "Please fill address!",
            name: "Please fill name!",
            email: {
                email: 'Email is not valid!',
                required: 'Please fill email!',
            },
        }
    });
    $("#brand_id").select2();
}

function load_company_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_add',
        data:{
        	user_id: $('#user_id').val()
        },
        beforeSend: function(xhr) {
            jQuery("#company_detail #company_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_detail #company_form").html(resp);
            add_event_image_upload();
            validate_company_form();
        }
    });  
}

function load_company_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_edit',
        data: {
            id: id,
        	user_id: $('#user_id').val()
        },
        beforeSend: function(xhr) {
            jQuery("#company_detail #company_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_detail #company_form").html(resp);
            add_event_image_upload();
            validate_company_form();
        }
    });  
}

function save_company_add(element){
    if($("#company_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_add',
           data:$('#company_form').serialize(),
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
                if(parseInt(resp)==10||parseInt(resp)==11||parseInt(resp)==12){
                  if(parseInt(resp)==10){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	              }
                  if(parseInt(resp)==11){
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                  if(parseInt(resp)==12){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                }else{
                  if($('.paginate_active').length) $('.paginate_active').trigger('click');
                  else document.location.href = document.location.href ;
                  element.next().trigger('click');
                }
                $.unblockUI();
            }
        });   
     }
}

function save_company_edit(element){
    if($("#company_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_edit',
           data:$('#company_form').serialize(),
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
                if(parseInt(resp)==10||parseInt(resp)==11||parseInt(resp)==12){
                  if(parseInt(resp)==10){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	              }
                  if(parseInt(resp)==11){
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                  if(parseInt(resp)==12){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                }else{
	                if($('.paginate_active').length) $('.paginate_active').trigger('click');
	                else document.location.href = document.location.href ;
	                element.next().trigger('click');
	            }
              $.unblockUI();
            }
        });   
    }
}

function delete_company(id){
	if(confirm('Are you sure to delete this company?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_company',
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

// User
if($('#user_list').length){
	var user_list = $('#user_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_user_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    user_list.fnDraw(); 
	});
}

function change_is_active_user(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_active_user',
       data:{
           id: id,
           active: active,
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

function validate_user_form(){
    $("#user_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            username: {
                required: true,
            },
            address: {
                required: true,
            },
            name: {
                required: true,
            },
            email: {
                email: true,
                required: true,
            },
        },
        messages: {
            username: "Please fill username!",
            address: "Please fill address!",
            name: "Please fill name!",
            email: {
                email: 'Email is not valid!',
                required: 'Please fill email!',
            },
        }
    });
    $("#brand_id").select2();
}

function load_user_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_user_add',
        data:{
        	user_id: $('#user_id').val()
        },
        beforeSend: function(xhr) {
            jQuery("#user_detail #user_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#user_detail #user_form").html(resp);
            add_event_image_upload();
            validate_user_form();
        }
    });  
}

function load_user_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_user_edit',
        data: {
            id: id,
        	user_id: $('#user_id').val()
        },
        beforeSend: function(xhr) {
            jQuery("#user_detail #user_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#user_detail #user_form").html(resp);
            add_event_image_upload();
            validate_user_form();
        }
    });  
}

function save_user_add(element){
    if($("#user_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_user_add',
           data:$('#user_form').serialize(),
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
                if(parseInt(resp)==10||parseInt(resp)==11||parseInt(resp)==12){
                  if(parseInt(resp)==10){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	              }
                  if(parseInt(resp)==11){
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                  if(parseInt(resp)==12){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                }else{
                  if($('.paginate_active').length) $('.paginate_active').trigger('click');
                  else document.location.href = document.location.href ;
                  element.next().trigger('click');
                }
                $.unblockUI();
            }
        });   
     }
}

function save_user_edit(element){
    if($("#user_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_user_edit',
           data:$('#user_form').serialize(),
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
                if(parseInt(resp)==10||parseInt(resp)==11||parseInt(resp)==12){
                  if(parseInt(resp)==10){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	              }
                  if(parseInt(resp)==11){
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                  if(parseInt(resp)==12){
	                  $('<label for="username" generated="true" class="error">This username has been used!</label>').insertAfter($('#username'));
	                  $('<label for="email" generated="true" class="error">This email has been used!</label>').insertAfter($('#email'));
	              }
                }else{
	                if($('.paginate_active').length) $('.paginate_active').trigger('click');
	                else document.location.href = document.location.href ;
	                element.next().trigger('click');
	            }
              $.unblockUI();
            }
        });   
    }
}

function delete_user(id){
	if(confirm('Are you sure to delete this user?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_user',
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

// Enquiry
if($('#enquiry_list').length){
	var enquiry_list = $('#enquiry_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_enquiry_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    enquiry_list.fnDraw(); 
	});
}

function load_enquiry(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_enquiry',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#enquiry_detail #enquiry_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#enquiry_detail #enquiry_form").html(resp);
        }
    });  
}

function change_is_show(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_show',
       data:{
           id: id,
           active: active,
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

function delete_enquiry(id){
	if(confirm('Are you sure to delete this enquiry?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_enquiry',
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

// Service Root
if($('#service_root_list').length){
	var service_root_list = $('#service_root_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_service_root_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    service_root_list.fnDraw(); 
	});
}

function validate_service_root_form(){
    $("#service_root_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill service category!"
        }
    });
}

function load_service_root_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_service_root_add',
        beforeSend: function(xhr) {
            jQuery("#service_root_detail #service_root_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#service_root_detail #service_root_form").html(resp);
            validate_service_root_form();
        }
    });  
}

function load_service_root_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_service_root_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#service_root_detail #service_root_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#service_root_detail #service_root_form").html(resp);
            validate_service_root_form();
        }
    });  
}

function save_service_root_add(element){
    if($("#service_root_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_service_root_add',
           data:$('#service_root_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_service_root_edit(element){
    if($("#service_root_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_service_root_edit',
           data:$('#service_root_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_service_root(id){
	if(confirm('Are you sure to delete this service category?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_service_root',
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

// Service
if($('#service_list').length){
	var service_list = $('#service_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_service_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    service_list.fnDraw(); 
	});
}

function validate_service_form(){
    $("#service_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill service!"
        }
    });
}

function load_service_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_service_add',
        beforeSend: function(xhr) {
            jQuery("#service_detail #service_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#service_detail #service_form").html(resp);
            validate_service_form();
        }
    });  
}

function load_service_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_service_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#service_detail #service_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#service_detail #service_form").html(resp);
            validate_service_form();
        }
    });  
}

function save_service_add(element){
    if($("#service_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_service_add',
           data:$('#service_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_service_edit(element){
    if($("#service_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_service_edit',
           data:$('#service_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_service(id){
	if(confirm('Are you sure to delete this service?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_service',
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

// Brand Root
if($('#brand_root_list').length){
	var brand_root_list = $('#brand_root_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_brand_root_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    brand_root_list.fnDraw(); 
	});
}

function validate_brand_root_form(){
    $("#brand_root_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill brand category!"
        }
    });
}

function load_brand_root_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_brand_root_add',
        beforeSend: function(xhr) {
            jQuery("#brand_root_detail #brand_root_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#brand_root_detail #brand_root_form").html(resp);
            validate_brand_root_form();
        }
    });  
}

function load_brand_root_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_brand_root_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#brand_root_detail #brand_root_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#brand_root_detail #brand_root_form").html(resp);
            validate_brand_root_form();
        }
    });  
}

function save_brand_root_add(element){
    if($("#brand_root_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_brand_root_add',
           data:$('#brand_root_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_brand_root_edit(element){
    if($("#brand_root_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_brand_root_edit',
           data:$('#brand_root_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_brand_root(id){
	if(confirm('Are you sure to delete this brand category?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_brand_root',
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

// Brand
if($('#brand_list').length){
	var brand_list = $('#brand_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_brand_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    brand_list.fnDraw(); 
	});
}

function validate_brand_form(){
    $("#brand_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill brand!"
        }
    });
}

function load_brand_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_brand_add',
        beforeSend: function(xhr) {
            jQuery("#brand_detail #brand_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#brand_detail #brand_form").html(resp);
            validate_brand_form();
        }
    });  
}

function load_brand_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_brand_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#brand_detail #brand_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#brand_detail #brand_form").html(resp);
            validate_brand_form();
        }
    });  
}

function save_brand_add(element){
    if($("#brand_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_brand_add',
           data:$('#brand_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_brand_edit(element){
    if($("#brand_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_brand_edit',
           data:$('#brand_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_brand(id){
	if(confirm('Are you sure to delete this brand?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_brand',
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

// Cat New
if($('#cat_new_list').length){
	var cat_new_list = $('#cat_new_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_cat_new_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    cat_new_list.fnDraw(); 
	});
}

function validate_cat_new_form(){
    $("#cat_new_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill news category!"
        }
    });
}

function load_cat_new_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_cat_new_add',
        beforeSend: function(xhr) {
            jQuery("#cat_new_detail #cat_new_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#cat_new_detail #cat_new_form").html(resp);
            validate_cat_new_form();
        }
    });  
}

function load_cat_new_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_cat_new_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#cat_new_detail #cat_new_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#cat_new_detail #cat_new_form").html(resp);
            validate_cat_new_form();
        }
    });  
}

function save_cat_new_add(element){
    if($("#cat_new_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_cat_new_add',
           data:$('#cat_new_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_cat_new_edit(element){
    if($("#cat_new_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_cat_new_edit',
           data:$('#cat_new_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_cat_new(id){
	if(confirm('Are you sure to delete this news category?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_cat_new',
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

// New
if($('#new_list').length){
	var new_list = $('#new_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_new_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    new_list.fnDraw(); 
	});
}

function change_is_hot(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_hot',
       data:{
           id: id,
           active: active,
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

function validate_new_form(){
    $("#new_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill news!"
        }
    });
    $('#content').wysihtml5();
}

function load_new_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_new_add',
        beforeSend: function(xhr) {
            jQuery("#new_detail #new_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#new_detail #new_form").html(resp);
            add_event_image_upload();
            validate_new_form();
        }
    });  
}

function load_new_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_new_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#new_detail #new_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#new_detail #new_form").html(resp);
            add_event_image_upload();
            validate_new_form();
        }
    });  
}

function save_new_add(element){
    if($("#new_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_new_add',
           data:$('#new_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_new_edit(element){
    if($("#new_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_new_edit',
           data:$('#new_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_new(id){
	if(confirm('Are you sure to delete this news?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_new',
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

// Video
if($('#video_list').length){
	var video_list = $('#video_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_video_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    video_list.fnDraw(); 
	});
}

function validate_video_form(){
    $("#video_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill video!"
        }
    });
}

function load_video_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_video_add',
        beforeSend: function(xhr) {
            jQuery("#video_detail #video_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#video_detail #video_form").html(resp);
            validate_video_form();
        }
    });  
}

function load_video_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_video_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#video_detail #video_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#video_detail #video_form").html(resp);
            validate_video_form();
        }
    });  
}

function save_video_add(element){
    if($("#video_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_video_add',
           data:$('#video_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_video_edit(element){
    if($("#video_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_video_edit',
           data:$('#video_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_video(id){
	if(confirm('Are you sure to delete this video?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_video',
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

// Country
if($('#country_list').length){
	var country_list = $('#country_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_country_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    country_list.fnDraw(); 
	});
}

function validate_country_form(){
    $("#country_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill country!"
        }
    });
}

function load_country_add(){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_country_add',
        beforeSend: function(xhr) {
            jQuery("#country_detail #country_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#country_detail #country_form").html(resp);
            validate_country_form();
        }
    });  
}

function load_country_edit(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_country_edit',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#country_detail #country_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#country_detail #country_form").html(resp);
            validate_country_form();
        }
    });  
}

function save_country_add(element){
    if($("#country_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_country_add',
           data:$('#country_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_country_edit(element){
    if($("#country_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_country_edit',
           data:$('#country_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_country(id){
	if(confirm('Are you sure to delete this country?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_country',
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

// Submit Product
if($('#submit_product_list').length){
	var submit_product_list = $('#submit_product_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_submit_product_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    submit_product_list.fnDraw(); 
	});
}

function change_is_feature(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_feature',
       data:{
           id: id,
           active: active,
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

// Submit Happening
if($('#submit_happening_list').length){
	var submit_happening_list = $('#submit_happening_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_submit_happening_list",
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
	        }
		});

	 $("#search").on("keyup", function () {
	    submit_happening_list.fnDraw(); 
	});
}

function change_is_active(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_active',
       data:{
           id: id,
           active: active,
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

// Company Product
if($('#company_product_list').length){
	var company_product_list = $('#company_product_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_company_product_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
	            aoData.push( { "name": "f_search", "value": $('#search').val() } );
	            aoData.push( { "name": "company_id", "value": $('#company_id').val() } );
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
	        }
		});

	 $("#search").on("keyup", function () {
	    company_product_list.fnDraw(); 
	});
}

function change_is_stock(active, id){
    jQuery.ajax({
       type:'POST',
       url:base_url+'admin/admin_change_is_stock',
       data:{
           id: id,
           active: active,
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

function validate_company_product_form(){
    $("#company_product_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill product!"
        }
    });
    $('#launch_date').datepicker (); 
    $('#description').wysihtml5();
}

function load_company_product_add(company_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_product_add',
        data: {
            company_id: company_id
        },
        beforeSend: function(xhr) {
            jQuery("#company_product_detail #company_product_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_product_detail #company_product_form").html(resp);
            add_event_image_upload();
            validate_company_product_form();
        }
    });  
}

function load_company_product_edit(id,company_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_product_edit',
        data: {
            company_id: company_id,
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#company_product_detail #company_product_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_product_detail #company_product_form").html(resp);
            add_event_image_upload();
            validate_company_product_form();
        }
    });  
}

function save_company_product_add(element){
    if($("#company_product_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_product_add',
           data:$('#company_product_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_company_product_edit(element){
    if($("#company_product_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_product_edit',
           data:$('#company_product_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_company_product(id){
	if(confirm('Are you sure to delete this product?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_company_product',
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

// Company Enquiry
if($('#company_enquiry_list').length){
	var company_enquiry_list = $('#company_enquiry_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_company_enquiry_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
	            aoData.push( { "name": "f_search", "value": $('#search').val() } );
	            aoData.push( { "name": "company_id", "value": $('#company_id').val() } );
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
	        }
		});

	 $("#search").on("keyup", function () {
	    company_enquiry_list.fnDraw(); 
	});
}

function load_company_enquiry(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_enquiry',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#company_enquiry_detail #company_enquiry_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_enquiry_detail #company_enquiry_form").html(resp);
        }
    });  
}

function delete_company_enquiry(id){
	if(confirm('Are you sure to delete this enquiry?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_company_enquiry',
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

// Company PDF
if($('#company_pdf_list').length){
	var company_pdf_list = $('#company_pdf_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_company_pdf_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
	            aoData.push( { "name": "f_search", "value": $('#search').val() } );
	            aoData.push( { "name": "company_id", "value": $('#company_id').val() } );
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
	        }
		});

	 $("#search").on("keyup", function () {
	    company_pdf_list.fnDraw(); 
	});
}

function validate_company_pdf_form(){
    $("#company_pdf_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            name: {
                required: true,
            }
        },
        messages: {
            name: "Please fill document name!"
        }
    });
}

function load_company_pdf_add(company_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_pdf_add',
        data: {
            company_id: company_id
        },
        beforeSend: function(xhr) {
            jQuery("#company_pdf_detail #company_pdf_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_pdf_detail #company_pdf_form").html(resp);
            add_event_file_upload();
            validate_company_pdf_form();
        }
    });  
}

function load_company_pdf_edit(id,company_id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_pdf_edit',
        data: {
            company_id: company_id,
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#company_pdf_detail #company_pdf_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_pdf_detail #company_pdf_form").html(resp);
            add_event_file_upload();
            validate_company_pdf_form();
        }
    });  
}

function save_company_pdf_add(element){
    if($("#company_pdf_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_pdf_add',
           data:$('#company_pdf_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
     }
}

function save_company_pdf_edit(element){
    if($("#company_pdf_form").valid()){
         jQuery.ajax({
           type:'POST',
           url:base_url+'admin/admin_save_company_pdf_edit',
           data:$('#company_pdf_form').serialize(),
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
	            element.next().trigger('click');
                $.unblockUI();
            }
        });   
    }
}

function delete_company_pdf(id){
	if(confirm('Are you sure to delete this document?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_company_pdf',
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

// Company Order
if($('#company_order_list').length){
	var company_order_list = $('#company_order_list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sPaginationType": "full_numbers",
		    "sAjaxSource": base_url+"admin/admin_get_company_order_list",
		    "bDeferRender": true,
		    "bLengthChange": false,
		    "bFilter": false,
		    "bDestroy": true,
	    	"iDisplayLength": 20,
		    "bSort": false,
	         "fnServerParams": function ( aoData ) {
	            aoData.push( { "name": "f_search", "value": $('#search').val() } );
	            aoData.push( { "name": "company_id", "value": $('#company_id').val() } );
	          },
	        "fnDrawCallback":function(){
	            $(this).find('tbody tr').removeClass('odd').removeClass('even');
	            $(this).next().attr('style',"display:none;");
	            if($(this).next().next().find('span a').length<=1){
	                $(this).next().next().attr('style',"display:none;");
	            } else {
	                $(this).next().next().attr('style',"display:block;");
	            }
	        }
		});

	 $("#search").on("keyup", function () {
	    company_order_list.fnDraw(); 
	});
}

function load_company_order(id){
    jQuery.ajax({
        type: 'POST',
        url: base_url+'admin/admin_load_company_order',
        data: {
            id: id
        },
        beforeSend: function(xhr) {
            jQuery("#company_order_detail #company_order_form").html('<div align="center"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');      
        },
        error:function(){
            alert('Can\'t connect to server!');
            window.location = document.URL;
        },
        success:function(resp){
            jQuery("#company_order_detail #company_order_form").html(resp);
        }
    });  
}

function delete_company_order(id){
	if(confirm('Are you sure to delete this order?')){
	    jQuery.ajax({
	        type: 'POST',
	        url: base_url+'admin/admin_delete_company_order',
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