<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="false" data-slide-speed="200">
			<li class="start <?php if(isset($page)&&strpos($page, 'setting-tool')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-gavel"></i>
				<span class="title">Công cụ</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'setting-tool')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='setting-tool-config') echo 'active' ?>">
						<a href="<?php echo get_slug('setting/setting_list') ?>"><i class="fa fa-caret-right"></i> Cấu hình hệ thống</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='setting-tool-email') echo 'active' ?>">
						<a href="<?php echo get_slug('email/email_list') ?>"><i class="fa fa-caret-right"></i> Email mẫu</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='setting-tool-sms') echo 'active' ?>">
						<a href="<?php echo get_slug('sms/sms_list') ?>"><i class="fa fa-caret-right"></i> SMS mẫu</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='setting-tool-send') echo 'active' ?>">
						<a href="<?php echo get_slug('send/send_list') ?>"><i class="fa fa-caret-right"></i> Gửi Mail & SMS</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'setting-user')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-users"></i>
				<span class="title">Người dùng</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'setting-user')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='setting-user-group') echo 'active' ?>">
						<a href="<?php echo get_slug('usergroup/user_group_list') ?>"><i class="fa fa-caret-right"></i> Nhóm người dùng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='setting-user-item') echo 'active' ?>">
						<a href="<?php echo get_slug('user/user_list') ?>"><i class="fa fa-caret-right"></i> Người dùng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='setting-user-permission') echo 'active' ?>">
						<a href="<?php echo get_slug('permission/permission_list') ?>"><i class="fa fa-caret-right"></i> Phân quyền</a>
					</li>
				</ul>
			</li>
			<li class="last">
				<a class="dashboard-stat dashboard-stat-light green" href="<?php echo get_slug('api/sale') ?>">
				<div class="visual">
					<i class="fa fa-cube"></i>
				</div>
				<div class="details">
					<div class="number">
						 Bán hàng
					</div>
					<div class="desc">
						 (Nhấn F7)
					</div>
				</div>
				</a>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->