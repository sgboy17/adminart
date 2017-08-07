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
			<li class="start <?php if(isset($page)&&strpos($page, 'report-store')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-home"></i>
				<span class="title">Kho</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'report-store')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='report-store-stock') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_stock') ?>"><i class="fa fa-caret-right"></i> Tồn kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-iestock') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_iestock') ?>"><i class="fa fa-caret-right"></i> Nhập xuất tồn</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-check') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_check') ?>"><i class="fa fa-caret-right"></i> Kiểm kho</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-import') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_import') ?>"><i class="fa fa-caret-right"></i> Chi tiết nhập hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-import-list') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_import_list') ?>"><i class="fa fa-caret-right"></i> Tổng hợp nhập hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-export') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_export') ?>"><i class="fa fa-caret-right"></i> Chi tiết xuất hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-store-export-list') echo 'active' ?>">
						<a href="<?php echo get_slug('report/store_export_list') ?>"><i class="fa fa-caret-right"></i> Tổng hợp xuất hàng</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'report-sale')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-user"></i>
				<span class="title">Bán hàng</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'report-sale')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='report-sale-item') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_item') ?>"><i class="fa fa-caret-right"></i> Chi tiết bán hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-item-list') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_item_list') ?>"><i class="fa fa-caret-right"></i> Tổng hợp bán hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-return') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_return') ?>"><i class="fa fa-caret-right"></i> Chi tiết nhập trả</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-return-list') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_return_list') ?>"><i class="fa fa-caret-right"></i> Tổng hợp nhập trả</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-income-branch') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_income_branch') ?>"><i class="fa fa-caret-right"></i> Doanh thu chi nhánh</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-income-user') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_income_user') ?>"><i class="fa fa-caret-right"></i> Doanh thu nhân viên</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='report-sale-income') echo 'active' ?>">
						<a href="<?php echo get_slug('report/sale_income') ?>"><i class="fa fa-caret-right"></i> Doanh thu chi tiết</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'report-summary')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-list"></i>
				<span class="title">Tổng hợp</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'report-summary')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='report-summary-result') echo 'active' ?>">
						<a href="<?php echo get_slug('report/summary_result') ?>"><i class="fa fa-caret-right"></i> Kết quả kinh doanh</a>
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