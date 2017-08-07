<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="<?php echo base_url() ?>resources_admin/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>resources_admin/css/dashboard.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>resources_admin/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url() ?>resources_admin/js/plugins/xeditable/bootstrap-editable.css">
  <link href="<?php echo base_url() ?>resources_admin/js/plugins/checkbox/checkbox.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>resources_admin/js/plugins/select2/select2.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>resources_admin/js/plugins/upload/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>resources_admin/js/plugins/datepicker/datepicker.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>resources_admin/css/custom.css" rel="stylesheet">
 
</head>
<body style="background: #e6e6e6;font: 400 14px/1.6 'Open Sans', Verdana, Helvetica, sans-serif;color: #333;">
    <div class="container-fluid intro">
      <div class="container">
          <div class="row">
            <div class="account-wrapper" style="padding: 30px 0;position: relative;width: 90%;padding: 15px 0;margin: 0 auto;text-align: center;">

              <div class="account-body" style="position: relative;padding: 35px 30px 10px;margin-bottom: 1em;background-color: #fff;border: 1px solid #ddd;border-top-right-radius: 4px;border-top-left-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;-webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.125);-moz-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.125);box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.125);">

                <img src="<?php echo base_url() ?>resources_admin/images/logo-web.png">

                <h3 class="account-body-title" style="margin-bottom: 10px;line-height: 1.5em;">Mật khẩu mới của bạn: <?php echo $password ?></h3>

                <h5 class="account-body-subtitle" style="color: #777;line-height: 1.5em;">Sử dụng mật khẩu này cho lần đăng nhập tiếp theo!</h5>
                
                <a style="color: #428bca;text-decoration: none;margin-bottom: 20px;display: block;" href="<?php echo get_slug('index/login') ?>"><i class="fa fa-angle-double-left"></i> &nbsp;Đăng nhập ngay</a>
                
              </div> <!-- /.account-body -->

            </div> <!-- /.account-wrapper -->
        </div>
      </div>
    </div>
</body>
</html>
