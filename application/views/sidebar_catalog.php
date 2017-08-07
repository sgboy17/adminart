
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
			<li class="start <?php if(isset($page)&&strpos($page, 'catalog-product')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-inbox"></i>
				<span class="title">Hàng hoá</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'catalog-product')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='catalog-product-unit') echo 'active' ?>">
						<a href="<?php echo get_slug('unit/unit_list') ?>"><i class="fa fa-caret-right"></i> Đơn vị tính</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-product-group') echo 'active' ?>">
						<a href="<?php echo get_slug('productgroup/product_group_list') ?>"><i class="fa fa-caret-right"></i> Nhóm hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-product-item') echo 'active' ?>">
						<a href="<?php echo get_slug('product/product_list') ?>"><i class="fa fa-caret-right"></i> Hàng hoá</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-product-barcode') echo 'active' ?>">
						<a href="<?php echo get_slug('barcode/barcode_list') ?>"><i class="fa fa-caret-right"></i> Barcode</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'catalog-object')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-user"></i>
				<span class="title">Đối tượng</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'catalog-object')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='catalog-object-user') echo 'active' ?>">
						<a href="<?php echo get_slug('employee/employee_list') ?>"><i class="fa fa-caret-right"></i> Nhân viên</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-object-group') echo 'active' ?>">
						<a href="<?php echo get_slug('object/object_list') ?>"><i class="fa fa-caret-right"></i> Nhóm đối tượng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-object-customer') echo 'active' ?>">
						<a href="<?php echo get_slug('customer/customer_list') ?>"><i class="fa fa-caret-right"></i> Khách hàng</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-object-supplier') echo 'active' ?>">
						<a href="<?php echo get_slug('supplier/supplier_list') ?>"><i class="fa fa-caret-right"></i> Nhà cung cấp</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-object-contact') echo 'active' ?>">
						<a href="<?php echo get_slug('contact/contact_list') ?>"><i class="fa fa-caret-right"></i> Liên hệ</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'catalog-branch')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-home"></i>
				<span class="title">Chi nhánh - Kho</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'catalog-branch')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='catalog-branch-item') echo 'active' ?>">
						<a href="<?php echo get_slug('branch/branch_list') ?>"><i class="fa fa-caret-right"></i> Chi nhánh</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-branch-store') echo 'active' ?>">
						<a href="<?php echo get_slug('store/store_list') ?>"><i class="fa fa-caret-right"></i> Kho</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'catalog-other')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-gear"></i>
				<span class="title">Danh mục khác</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'catalog-other')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='catalog-other-work') echo 'active' ?>">
						<a href="<?php echo get_slug('work/work_list') ?>"><i class="fa fa-caret-right"></i> Ca làm việc</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='catalog-other-bank') echo 'active' ?>">
						<a href="<?php echo get_slug('bank/bank_list') ?>"><i class="fa fa-caret-right"></i> Ngân hàng</a>
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