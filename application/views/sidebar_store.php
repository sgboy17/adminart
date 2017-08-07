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
			<li class="start <?php if(isset($page)&&strpos($page, 'store-action')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-refresh"></i>
				<span class="title">Nghiệp vụ</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'store-action')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='store-action-check') echo 'active' ?>">
						<a href="<?php echo get_slug('storecheckgroup/store_check_group_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu kiểm kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-action-transfer') echo 'active' ?>">
						<a href="<?php echo get_slug('storetransfergroup/store_transfer_group_action') ?>"><i class="fa fa-caret-right"></i> Tạo chuyển kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-action-import') echo 'active' ?>">
						<a href="<?php echo get_slug('storeimportgroup/store_import_group_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu nhập kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-action-export') echo 'active' ?>">
						<a href="<?php echo get_slug('storeexportgroup/store_export_group_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu xuất kho</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'store-list')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-list"></i>
				<span class="title">Danh sách</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'store-list')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='store-list-stock') echo 'active' ?>">
						<a href="<?php echo get_slug('storeproduct/store_product_list') ?>"><i class="fa fa-caret-right"></i> Tồn đầu kỳ</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-report') echo 'active' ?>">
						<a href="<?php echo get_slug('storeproduct/store_product_report') ?>"><i class="fa fa-caret-right"></i> Thống kê hàng tồn</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-product-expired') echo 'active' ?>">
						<a href="<?php echo get_slug('productexpired/product_expired_list') ?>"><i class="fa fa-caret-right"></i> Thống kê hết hạn</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-check') echo 'active' ?>">
						<a href="<?php echo get_slug('storecheckgroup/store_check_group_list') ?>"><i class="fa fa-caret-right"></i> Sổ kiểm kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-transfer') echo 'active' ?>">
						<a href="<?php echo get_slug('storetransfergroup/store_transfer_group_list') ?>"><i class="fa fa-caret-right"></i> Sổ chuyển kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-import') echo 'active' ?>">
						<a href="<?php echo get_slug('storeimportgroup/store_import_group_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu nhập kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='store-list-export') echo 'active' ?>">
						<a href="<?php echo get_slug('storeexportgroup/store_export_group_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu xuất kho</a>
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