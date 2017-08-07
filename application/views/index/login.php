<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!-->

<html lang="en">

<!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

<meta charset="utf-8"/>

<title>Đăng nhập - MASTERKID</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta content="width=device-width, initial-scale=1.0" name="viewport"/>

<meta http-equiv="Content-type" content="text/html; charset=utf-8">

<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>

<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME STYLES -->

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url() ?>resources_admin/css/custom.css" rel="stylesheet" type="text/css"/>

<!-- END THEME STYLES -->

</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

<!-- BEGIN LOGO -->

<div class="logo">

	<a>

	<img src="<?php echo base_url() ?>resources_admin/images/logo-login.png" height="100" alt=""/>

	</a>

</div>

<!-- END LOGO -->

<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

<div class="menu-toggler sidebar-toggler">

</div>

<!-- END SIDEBAR TOGGLER BUTTON -->

<!-- BEGIN LOGIN -->

<div class="content">

	<!-- BEGIN LOGIN FORM -->

	<form class="login-form" action="<?php echo get_slug('index/login') ?>" method="post">

		<h3 class="form-title" style="text-align: center;">Đăng nhập tài khoản</h3>

		<div class="alert alert-danger display-hide">

			<button class="close" data-close="alert"></button>

			<span>Vui lòng nhập tên đăng nhập và mật khẩu.</span>

		</div>

        <?php if(isset($info)){ ?>

          <div class="alert alert-success">

			<button class="close" data-close="alert"></button>

            Mật khẩu mới đã gửi đến email của bạn!

          </div>

        <?php } ?>



		<div class="form-group">

			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

			<label class="control-label visible-ie8 visible-ie9">Tên đăng nhập</label>

			<div class="input-icon">

				<i class="fa fa-user"></i>

				<?php 

      			if(!isset($username)){

      				$first_account = $this->db->where('user_id', 1)->get($this->prefix.'user')->row();

      				if(!empty($first_account)){

      					$username = $first_account->username;

      				}

      			}

				?>

				<input class="form-control placeholder-no-fix" type="text" value="<?php if(isset($username)) echo $username ?>" autocomplete="off" placeholder="Tên đăng nhập" name="username"/>

			</div>

		</div>

		<div class="form-group">

			<label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>

			<div class="input-icon">

				<i class="fa fa-lock"></i>

				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Mật khẩu" name="password"/>

			</div>

			<?php if(isset($message)){ ?>

			<span id="password-error" class="help-block text-danger"><?php echo $message ?></span>

            <?php } ?>

		</div>

		<div class="forget-password" style="text-align: center;">

			<p>

				Nhấn vào <a href="javascript:void(0)" id="forget-password">đây </a> nếu bạn quên mật khẩu.

			</p>

		</div>

		<div class="form-actions">

			<button type="submit" class="btn red btn-block">

			Đăng nhập <i class="m-icon-swapright m-icon-white"></i>

			</button>

		</div>

	</form>

	<!-- END LOGIN FORM -->

	<!-- BEGIN FORGOT PASSWORD FORM -->

	<form class="forget-form" action="<?php echo get_slug('index/forgot') ?>" method="post">

		<h3 style="text-align: center;">Quên mật khẩu ?</h3>

		<p style="text-align: center;">

			Nhập email của bạn để khôi phục mật khẩu.

		</p>

		<div class="form-group">

			<div class="input-icon">

				<i class="fa fa-envelope"></i>

				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>

			</div>

		</div>

		<div class="form-actions">

			<button type="button" id="back-btn" class="btn">

			<i class="m-icon-swapleft"></i> Hủy </button>

			<button type="submit" class="btn red pull-right">

			Gửi <i class="m-icon-swapright m-icon-white"></i>

			</button>

		</div>

	</form>

	<!-- END FORGOT PASSWORD FORM -->

</div>

<!-- END LOGIN -->

<!-- BEGIN COPYRIGHT -->

<div class="copyright">

	 2015 &copy; MASTERKID.

</div>

<!-- END COPYRIGHT -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->

<!--[if lt IE 9]>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/respond.min.js"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/excanvas.min.js"></script> 

<![endif]-->

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/select2/select2.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>resources_admin/metronic/assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

<script>

jQuery(document).ready(function() {     

  Metronic.init(); // init metronic core components

	Layout.init(); // init current layout

  Login.init();

  Demo.init();

       // init background slide images

       $.backstretch([

        "<?php echo base_url() ?>resources_admin/images/bg.jpg"

        ], {

          fade: 1000,

          duration: 8000

    }

    );



});

</script>

<!-- END JAVASCRIPTS -->

</html>



