if($('#room_list').length){	var room_list = $('#room_list').dataTable({		    "bProcessing": true,		    "bServerSide": true,		    "sPaginationType": "full_numbers",		    "sAjaxSource": base_url+"room/get_room_list",		    "bDeferRender": true,		    "bLengthChange": false,		    "bFilter": false,		    "bDestroy": true,	    	"iDisplayLength": 20,		    "bSort": false,	         "fnServerParams": function ( aoData ) {            aoData.push( { "name": "f_search", "value": $('#search').val() } );            aoData.push( { "name": "f_status", "value": $('#status').val() } );        	          },	        "fnDrawCallback":function(){	            $(this).find('tbody tr').removeClass('odd').removeClass('even');	            $(this).next().attr('style',"display:none;");	            if($(this).next().next().find('span a').length<=1){	                $(this).next().next().attr('style',"display:none;");	            } else {	                $(this).next().next().attr('style',"display:block;");	            }                if($('.check_all').length){                    $('.check_all').on('click', function(){                        if(!$('.check_all').prop('checked')){                            $('.id:checked').trigger('click');                        }else{                            $('.id:not(.id:checked)').trigger('click');                        }                    });                }                handleUniform();	        }		});                     $("#search").on("keyup", function () {        room_list.fnDraw();    });     $("#center_id").on("change", function () {        room_list.fnDraw();    });     $("#status").on("change", function () {        room_list.fnDraw();    });                        }function delete_room_multiple(){    if(confirm('Bạn có chắc muốn xoá những dữ liệu này?')){        var id_checkbox = $('.id:checked');        var id = '';        for(var i=0; i<id_checkbox.length; i++){            if(i!=id_checkbox.length-1) id += $(id_checkbox[i]).val()+',';            else id += $(id_checkbox[i]).val();        }        jQuery.ajax({            type: 'POST',            url: base_url+'room/delete_room',            data: {                id: id            },            beforeSend: function(xhr) {                $.blockUI({css: {                    border: 'none',                    padding: '15px',                    backgroundColor: '#000',                    '-webkit-border-radius': '10px',                    '-moz-border-radius': '10px',                    opacity: .5,                    color: '#fff'                }});            },            success:function(resp){                if($('.paginate_active').length) $('.paginate_active').trigger('click');                else document.location.href = document.location.href ;                $.unblockUI();            }        });    }}function delete_room(id){	if(confirm('Bạn có chắc muốn xoá dữ liệu này?')){	    jQuery.ajax({	        type: 'POST',	        url: base_url+'room/delete_room',	        data: {	            id: id	        },	        beforeSend: function(xhr) {	                $.blockUI({css: {	                    border: 'none',	                    padding: '15px',	                    backgroundColor: '#000',	                    '-webkit-border-radius': '10px',	                    '-moz-border-radius': '10px',	                    opacity: .5,	                    color: '#fff'	                }});	        },	        success:function(resp){	           if($('.paginate_active').length) $('.paginate_active').trigger('click');	           else document.location.href = document.location.href ;	           $.unblockUI();	        }	    });  	}}function validate_room_form(){    $("#room_form").validate({        ignore: null,        ignore: 'input[type="hidden"]',        rules: {            name: {                required: true,            },            status: {                required: true,            },        },        messages: {            name: "Vui lòng điền tên phòng!",            status: "Vui lòng điền trạng thái!",        }    });}        function load_room_add(){    jQuery.ajax({        type: 'POST',        url: base_url+'room/load_room_add',        beforeSend: function(xhr) {            jQuery("#room_detail #room_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');              },        error:function(){            alert('Can\'t connect to server!');            window.location = document.URL;        },        success:function(resp){            jQuery("#room_detail #room_form").html(resp);            validate_room_form();        }    });  }function load_room_edit(id){    jQuery.ajax({        type: 'POST',        url: base_url+'room/load_room_edit',        data: {            id: id,        },        beforeSend: function(xhr) {            jQuery("#room_detail #room_form").html('<div align="center" style="margin: 10px;"><img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" /></div>');        },        error:function(){            alert('Can\'t connect to server!');            window.location = document.URL;        },        success:function(resp){            jQuery("#room_detail #room_form").html(resp);            validate_room_form();        }    });  }function save_room_add(element){    if($("#room_form").valid()){         jQuery.ajax({           type:'POST',           url:base_url+'room/save_room_add',           data:$('#room_form').serialize(),           beforeSend: function(xhr) {                $.blockUI({css: {                    border: 'none',                    padding: '15px',                    backgroundColor: '#000',                    '-webkit-border-radius': '10px',                    '-moz-border-radius': '10px',                    opacity: .5,                    color: '#fff'                }});            },            success:function(resp){                if($('.paginate_active').length) $('.paginate_active').trigger('click');                else document.location.href = document.location.href ;                $.unblockUI();                element.next().trigger('click');            }        });        }}function save_room_edit(element){    if($("#room_form").valid()){         jQuery.ajax({           type:'POST',           url:base_url+'room/save_room_edit',           data:$('#room_form').serialize(),           beforeSend: function(xhr) {                $.blockUI({css: {                    border: 'none',                    padding: '15px',                    backgroundColor: '#000',                    '-webkit-border-radius': '10px',                    '-moz-border-radius': '10px',                    opacity: .5,                    color: '#fff'                }});            },            success:function(resp){                if($('.paginate_active').length) $('.paginate_active').trigger('click');                else document.location.href = document.location.href ;                $.unblockUI();                element.next().trigger('click');            }        });       }}