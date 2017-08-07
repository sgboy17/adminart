Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

// Handles price
var handlePrice = function() {
    var input = $('.sale input[type=text]');
    for(var i=0;i<input.length;i++){
        if($(input[i]).attr('name')!=undefined){
            if($(input[i]).attr('name').indexOf('price')!=-1
            	||$(input[i]).attr('name').indexOf('commission')!=-1
                ||$(input[i]).attr('name').indexOf('tax')!=-1
            	||$(input[i]).attr('name').indexOf('quantity')!=-1
            	||$(input[i]).attr('name').indexOf('paid')!=-1){
                var clone = $(input[i]).clone().removeAttr('name');
                $(input[i]).attr('type','hidden');
                $(clone).insertBefore($(input[i]));
                $(clone).focus(function(){
                    this.select();
                    $( ".tooltip" ).remove();
                }).mouseup(function (e) {e.preventDefault(); });
            }
        }
    }

    var input = $('.sale input[type=hidden]');
    for(var i=0;i<input.length;i++){
        if($(input[i]).attr('name')!=undefined&&!$(input[i]).hasClass('binded')){
            if($(input[i]).attr('name').indexOf('price')!=-1
            	||$(input[i]).attr('name').indexOf('commission')!=-1
                ||$(input[i]).attr('name').indexOf('tax')!=-1
            	||$(input[i]).attr('name').indexOf('quantity')!=-1
            	||$(input[i]).attr('name').indexOf('paid')!=-1){
            	$(input[i]).attr('class','binded');
                $(input[i]).prev().keyup(function(){
                    var current_value = $(this).val();
                    $(this).next().val(current_value.replace(/,/g,'')).trigger('change');
                });
                $(input[i]).change(function(){
                    var new_value = $(this).val();
                    $(this).prev().val(parseInt($(this).val()).formatMoney(0));
                });
                $(input[i]).trigger('change');

                $(input[i]).prev().focus(function(){
                    this.select();
                    $( ".tooltip" ).remove();
                }).mouseup(function (e) {e.preventDefault(); });
            }
        }
    }
};


var image_avatar = '';
function handleUpload(){
    //image avatar
    image_avatar = {
        uploader: false,
        start_upload: function() {
            image_avatar.uploader = new plupload.Uploader({
                runtimes: 'html5,flash,html4',
                browse_button: 'image_avatar',
                max_file_size: '10mb',
                url: base_url+'api/upload_img/',
                flash_swf_url: '/resources_admin/js/plugins/plupload/plupload.flash.swf',
                filters: [
                    {title: "Chọn hình", extensions: "jpg,gif,png"}

                ]
            });

            image_avatar.uploader.bind('FilesAdded', function(up, files) {
                jQuery("#image_avatar").html("Uploading...").attr('disabled', 'disabled');
                jQuery("#image_src").html('<img src="'+base_url+'resources_admin/images/loaders/circular/072.gif" style="margin: 50px auto;" />');
                if (image_avatar.uploader.runtime === 'flash' || image_avatar.uploader.runtime === 'html5') {
                    setTimeout('image_avatar.uploader.start()', 100);
                }

            });
            jQuery('input[type="file"]').change(function() {
                image_avatar.uploader.start();

            });
            image_avatar.uploader.bind('UploadProgress', function(up, file) {


            });

            image_avatar.uploader.bind('FileUploaded', function(up, file, response) {
                jQuery("#image_avatar").html("Chọn hình").removeAttr('disabled');
                jQuery("#image_src").html('<img src="'+base_url+'upload/' + response.response + '" />');
                jQuery("#avatar").val(response.response);
            });
            image_avatar.uploader.init();
        }

    };
    image_avatar.start_upload();
}


// Handles custom location modal
var handleLocation = function() {
    if ($('form select[name=country_id]').length==0) {
        return;
    }

    var city_id = $('form select[name=city_id]').clone().removeAttr('name').attr('id','city_id').hide();
    $(city_id).insertAfter('form select[name=city_id]');

    var district_id = $('form select[name=district_id]').clone().removeAttr('name').attr('id','district_id').hide();
    $(district_id).insertAfter('form select[name=district_id]');

    $('form select[name=country_id]').on('change',function(){
        var country_id = parseInt($(this).val());
        if($(this).val()!="") $('form select[name=city_id]').html($('form select#city_id option[data="'+country_id+'"]').clone()).select2().trigger('change');
        else $('form select[name=city_id]').html('<option value="">- tỉnh/thành -</option>').select2().trigger('change');
    });

    $('form select[name=city_id]').on('change',function(){
        var city_id = parseInt($(this).val());
        if($(this).val()!="") $('form select[name=district_id]').html($('form select#district_id option[data="'+city_id+'"]').clone()).select2();
        else $('form select[name=district_id]').html('<option value="">- quận/huyện -</option>').select2();
    });

    $('form select[name=country_id]').trigger('change');
};