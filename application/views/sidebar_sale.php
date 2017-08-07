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
			<li class="start <?php if(isset($page)&&strpos($page, 'sale-action')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-refresh"></i>
				<span class="title">Nghiệp vụ</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'sale-action')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='sale-action-item') echo 'active' ?>">
						<a href="<?php echo get_slug('order/order_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu bán hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='sale-action-return') echo 'active' ?>">
						<a href="<?php echo get_slug('orderreturn/return_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu nhập trả</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'sale-list')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-list"></i>
				<span class="title">Danh sách</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'sale-list')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='sale-list-item') echo 'active' ?>">
						<a href="<?php echo get_slug('order/order_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu bán hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='sale-list-return') echo 'active' ?>">
						<a href="<?php echo get_slug('orderreturn/return_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu nhập trả hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='sale-list-deposit') echo 'active' ?>">
						<a href="<?php echo get_slug('orderfix/order_deposit_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu công nợ</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='sale-list-fix') echo 'active' ?>">
						<a href="<?php echo get_slug('orderfix/order_fix_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu sửa đồ</a>
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