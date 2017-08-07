var handleiCheck = function() {
    if (!$().iCheck) {
        return;
    }

    $('.icheck').each(function() {
        var checkboxClass = $(this).attr('data-checkbox') ? $(this).attr('data-checkbox') : 'icheckbox_minimal-grey';
        var radioClass = $(this).attr('data-radio') ? $(this).attr('data-radio') : 'iradio_minimal-grey';

        if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
            $(this).iCheck({
                checkboxClass: checkboxClass,
                radioClass: radioClass,
                insert: '<div class="icheck_line-icon"></div>' + $(this).attr("data-label")
            });
        } else {
            $(this).iCheck({
                checkboxClass: checkboxClass,
                radioClass: radioClass
            });
        }
    });
};
// Handles custom location modal
var handleLocation = function() {
    if ($('form select[name=country_id]').length == 0) {
        return;
    }

    var city_id = $('form select[name=city_id]').clone().removeAttr('name').attr('id', 'city_id').hide();
    $(city_id).insertAfter('form select[name=city_id]');

    var district_id = $('form select[name=district_id]').clone().removeAttr('name').attr('id', 'district_id').hide();
    $(district_id).insertAfter('form select[name=district_id]');

    $('form select[name=country_id]').on('change', function() {
        var country_id = parseInt($(this).val());
        if ($(this).val() != "") $('form select[name=city_id]').html($('form select#city_id option[data="' + country_id + '"]').clone()).select2().trigger('change');
        else $('form select[name=city_id]').html('<option value="">- tỉnh/thành -</option>').select2().trigger('change');
    });

    $('form select[name=city_id]').on('change', function() {
        var city_id = parseInt($(this).val());
        if ($(this).val() != "") $('form select[name=district_id]').html($('form select#district_id option[data="' + city_id + '"]').clone()).select2();
        else $('form select[name=district_id]').html('<option value="">- quận/huyện -</option>').select2();
    });

    $('form select[name=country_id]').trigger('change');
};

// Handles custom location filter
var handleLocationFilter = function() {
    if ($('.modal-body > div select[name=country_id]').length == 0) {
        return;
    }

    var city_id = $('.modal-body > div select[name=city_id]').clone().removeAttr('name').attr('id', 'city_id').hide();
    $(city_id).insertAfter('.modal-body > div select[name=city_id]');

    var district_id = $('.modal-body > div select[name=district_id]').clone().removeAttr('name').attr('id', 'district_id').hide();
    $(district_id).insertAfter('.modal-body > div select[name=district_id]');

    $('.modal-body > div select[name=country_id]').on('change', function() {
        var country_id = parseInt($(this).val());
        if ($(this).val() != "") $('.modal-body > div select[name=city_id]').html($('.modal-body > div select#city_id option[data="' + country_id + '"]').clone()).select2().trigger('change');
        else $('.modal-body > div select[name=city_id]').html('<option value="">- tỉnh/thành -</option>').select2().trigger('change');
    });

    $('.modal-body > div select[name=city_id]').on('change', function() {
        var city_id = parseInt($(this).val());
        if ($(this).val() != "") $('.modal-body > div select[name=district_id]').html($('.modal-body > div select#district_id option[data="' + city_id + '"]').clone()).select2();
        else $('.modal-body > div select[name=district_id]').html('<option value="">- quận/huyện -</option>').select2();
    });

    $('.modal-body > div select[name=country_id]').trigger('change');
};

Number.prototype.formatMoney = function(c, d, t) {
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
    var input = $('.modal-dialog input[type=text]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('price') != -1 || $(input[i]).attr('name').indexOf('commission') != -1) {
                var clone = $(input[i]).clone().removeAttr('name');
                $(input[i]).attr('type', 'hidden');
                $(clone).insertBefore($(input[i]));
                $(clone).focus(function() {
                    this.select();
                }).mouseup(function(e) {
                    e.preventDefault();
                });
            }
        }
    }

    var input = $('.modal-dialog input[type=hidden]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('price') != -1 || $(input[i]).attr('name').indexOf('commission') != -1) {
                $(input[i]).prev().keyup(function() {
                    var current_value = $(this).val();
                    $(this).next().val(current_value.replace(/,/g, ''));
                    $(this).next().trigger('change');
                });
                $(input[i]).prev().trigger('keyup');
                $(input[i]).change(function() {
                    var new_value = $(this).val();
                    $(this).prev().val(parseInt($(this).val()).formatMoney(0));
                });
                $(input[i]).trigger('change');
            }
        }
    }
};


// Handles price branch bank
var handlePriceBranchBank = function() {
    var input = $('#bill_branch_list input[type=text], #bill_bank_list input[type=text]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('price') != -1 || $(input[i]).attr('name').indexOf('commission') != -1) {
                var clone = $(input[i]).clone().removeAttr('name').attr('class', 'form-control');
                $(input[i]).attr('type', 'hidden');
                $(clone).insertBefore($(input[i]));
                $(clone).focus(function() {
                    this.select();
                }).mouseup(function(e) {
                    e.preventDefault();
                });
            }
        }
    }

    var input = $('#bill_branch_list input[type=hidden], #bill_bank_list input[type=hidden]');
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('name') != undefined) {
            if ($(input[i]).attr('name').indexOf('price') != -1 || $(input[i]).attr('name').indexOf('commission') != -1) {
                $(input[i]).prev().keyup(function() {
                    var current_value = $(this).val();
                    $(this).next().val(current_value.replace(/,/g, ''));
                    $(this).next().trigger('change');
                });
                $(input[i]).prev().trigger('keyup');
                $(input[i]).change(function() {
                    var new_value = $(this).val();
                    $(this).prev().val(parseInt($(this).val()).formatMoney(0));
                });
                $(input[i]).trigger('change');
            }
        }
    }
};

var image_avatar = '';

function handleUpload() {
    //image avatar
    image_avatar = {
        uploader: false,
        start_upload: function() {
            image_avatar.uploader = new plupload.Uploader({
                runtimes: 'html5,flash,html4',
                browse_button: 'image_avatar',
                max_file_size: '3mb',
                url: base_url + 'api/upload_img/',
                flash_swf_url: '/resources_admin/js/plugins/plupload/plupload.flash.swf',
                filters: [{
                        title: "Chọn hình",
                        extensions: "jpg,gif,png"
                    }

                ]
            });

            image_avatar.uploader.bind('FilesAdded', function(up, files) {
                jQuery('.img_error').remove();
                if (files[0].size > 3 * 1024 * 1024) {
                    jQuery("#image_src").after('<p class="error img_error">Dung lượng file phải nhỏ hơn 3MB!</p>');
                } else {
                    jQuery("#image_avatar").html("Uploading...").attr('disabled', 'disabled');
                    jQuery("#image_src").html('<img src="' + base_url + 'resources_admin/images/loaders/circular/072.gif" style="margin: 50px auto;" />');
                    if (image_avatar.uploader.runtime === 'flash' || image_avatar.uploader.runtime === 'html5') {
                        setTimeout('image_avatar.uploader.start()', 100);
                    }
                }

            });
            jQuery('input[type="file"]').change(function() {
                image_avatar.uploader.start();

            });
            image_avatar.uploader.bind('UploadProgress', function(up, file) {


            });

            image_avatar.uploader.bind('FileUploaded', function(up, file, response) {
                jQuery("#image_avatar").html("Chọn hình").removeAttr('disabled');
                jQuery("#image_src").html('<img src="' + base_url + 'upload/' + response.response + '" />');
                jQuery("#avatar").val(response.response);
            });
            image_avatar.uploader.init();
        }

    };
    image_avatar.start_upload();
}


var file_upload = '';

function handleImport() {
    // file upload
    file_upload = {
        uploader: false,
        start_upload: function() {
            file_upload.uploader = new plupload.Uploader({
                runtimes: 'html5,flash,html4',
                browse_button: 'file_upload',
                max_file_size: '30mb',
                url: base_url + 'api/upload_file/',
                flash_swf_url: '/resources_admin/js/plugins/plupload/plupload.flash.swf',
                filters: [{
                        title: "Import files",
                        extensions: "xls,xlsx,xml"
                    }

                ]
            });

            file_upload.uploader.bind('FilesAdded', function(up, files) {
                if (files[0].size > 30 * 1024 * 1024) {
                    jQuery(".fileinput-filename").html('Dung lượng file phải nhỏ hơn 30MB!');
                } else {
                    jQuery("#file_upload").html("Uploading...").attr('disabled', 'disabled');
                    jQuery("#upload_btn").attr('disabled', 'disabled');
                    jQuery(".file_upload_progress").fadeIn();
                    jQuery(".fileinput-exists").removeClass('fileinput-exists');
                    jQuery(".fileinput-filename").html(files[0].name);
                    if (file_upload.uploader.runtime === 'flash' || file_upload.uploader.runtime === 'html5') {
                        setTimeout('file_upload.uploader.start()', 100);
                    }
                }

            });
            jQuery('input[type="file"]').change(function() {
                file_upload.uploader.start();
            });
            file_upload.uploader.bind('UploadProgress', function(up, file) {
                if (file.percent > 5) jQuery('.file_upload_progress > div').attr('aria-valuenow', file.percent).attr('style', 'width: ' + file.percent + '%');
            });

            file_upload.uploader.bind('FileUploaded', function(up, file, response) {
                var file = response.response;
                jQuery('.file_upload_progress > div').html('Đang import file...');
                if ($('#file_table').length) file_table = $('#file_table').val();
                else file_table = '';
                $.ajax({
                    url: base_url + 'api/import_file?file=' + file + '&file_table=' + file_table,
                    type: 'get',
                    error: function(data) {
                        jQuery("#file_upload").html("Chọn file").removeAttr('disabled');
                        document.location.href = document.location.href;
                        $('#close_import').trigger('click');
                        jQuery(".file_upload_progress").fadeOut();
                        setTimeout(function() {
                            jQuery('.file_upload_progress > div').attr('aria-valuenow', 0).attr('style', 'width: 0%')
                        }, 500);
                    },
                    success: function(data) {
                        if (data != '') {
                            if (data == "1" || data.indexOf('error') > 0 || data.indexOf('Error') > 0) {
                                jQuery(".fileinput-filename").html('Có lỗi trong quá trình import, vui lòng thử lại!');
                                jQuery("#upload_btn").attr('disabled', 'disabled');
                                jQuery("#file_upload").html("Chọn file").removeAttr('disabled');
                                jQuery(".file_upload_progress").fadeOut();
                                setTimeout(function() {
                                    jQuery('.file_upload_progress > div').attr('aria-valuenow', 0).attr('style', 'width: 0%')
                                }, 500);
                            } else {
                                jQuery("#file_upload").html("Chọn file").removeAttr('disabled');
                                document.location.href = document.location.href;
                                $('#close_import').trigger('click');
                                jQuery(".file_upload_progress").fadeOut();
                                setTimeout(function() {
                                    jQuery('.file_upload_progress > div').attr('aria-valuenow', 0).attr('style', 'width: 0%')
                                }, 500);
                            }
                        } else {
                            jQuery(".fileinput-filename").html('Có lỗi trong quá trình import, vui lòng thử lại!');
                            jQuery(".file_upload_progress").fadeOut();
                            jQuery("#upload_btn").attr('disabled', 'disabled');
                            jQuery("#file_upload").html("Chọn file").removeAttr('disabled');
                            setTimeout(function() {
                                jQuery('.file_upload_progress > div').attr('aria-valuenow', 0).attr('style', 'width: 0%')
                            }, 500);
                        }
                    }
                });
            });
            file_upload.uploader.init();

        }
    };
    file_upload.start_upload();
}

if ($('#account_form').length) {
    $("#account_form").validate({
        ignore: null,
        ignore: 'input[type="hidden"]',
        rules: {
            password: {
                equalTo: '#re-password'
            },

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

        },
        messages: {

            password: "Mật khẩu nhập lại không trùng khớp!",

            email: {
                required: "Vui lòng điền email!",
                email: "Email không hợp lệ!",
            },

            birthday: "Vui lòng điền ngày sinh!",

            gender: "Vui lòng điền giới tính!",

            country_id: "Vui lòng điền quốc gia!",

            city_id: "Vui lòng điền tỉnh/thành!",

            district_id: "Vui lòng điền quận/huyện!",

        }
    });
    handleUpload();
    handleLocation();
    handleUniform();
}


var $mainContent, $current_page = 1;

function reload_ajax(href, target) {
    $mainContent = $("." + target + " .table-container");
    var filter = $('.report_filter');
    var filter_query = '';
    for (var i = 0; i < filter.length; i++) {
        filter_query += '&' + $(filter[i]).attr('name') + '=' + $(filter[i]).val();
    }
    loadContent(href + '?current_page=' + $current_page + filter_query, target);
}

function loadContent(href, target) {
    $.blockUI({
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });
    $mainContent.load(href + " #" + target + "_guts", function() {
        $.unblockUI();
        paginationHandle();
        if ($("." + target + " .table-container noscript").length) {
            eval($("." + target + " .table-container noscript").html());
        }
    });
}

function paginationHandle() {
    if ($('.prev_btn').length) {
        $('.prev_btn').on('click', function() {
            if ($current_page > 1 && !$(this).hasClass('disabled')) {
                $current_page--;
                reload_ajax($('#pagination_url').val(), $('#pagination_target').val());
            }
        });
    }

    if ($('.next_btn').length) {
        $('.next_btn').on('click', function() {
            if ($current_page < $('#pagination_total').val() && !$(this).hasClass('disabled')) {
                $current_page++;
                reload_ajax($('#pagination_url').val(), $('#pagination_target').val());
            }
        });
    }

    if ($('.num_btn').length) {
        $('.num_btn').on('click', function() {
            if (!$(this).hasClass('disabled')) {
                $current_page = $(this).text();
                reload_ajax($('#pagination_url').val(), $('#pagination_target').val());
            }
        });
    }

    if ($('.pagination.prev_next').length) {
        var page_item = $('.pagination.prev_next li');
        var width = 0;
        for (var i = 0; i < page_item.length; i++) {
            width += $(page_item[i]).find('a:visible').outerWidth();
        }
        $('.pagination.prev_next').attr('style', 'width:' + width + 'px;');
    }
}

function show_report() {
    reload_ajax($('#pagination_url').val(), $('#pagination_target').val());
}
if ($('.pagination').length) paginationHandle();