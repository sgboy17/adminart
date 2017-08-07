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
			<li class="start <?php if(isset($page)&&strpos($page, 'bill-action')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-refresh"></i>
				<span class="title">Nghiệp vụ</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'bill-action')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='bill-action-transfer') echo 'active' ?>">
						<a href="<?php echo get_slug('billtransfer/bill_transfer_action') ?>"><i class="fa fa-caret-right"></i> Tạo chuyển tiền</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='bill-action-income') echo 'active' ?>">
						<a href="<?php echo get_slug('billincome/bill_income_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu thu</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='bill-action-outcome') echo 'active' ?>">
						<a href="<?php echo get_slug('billoutcome/bill_outcome_action') ?>"><i class="fa fa-caret-right"></i> Tạo phiếu chi</a>
					</li>
				</ul>
			</li>
			<li class="<?php if(isset($page)&&strpos($page, 'bill-list')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-list"></i>
				<span class="title">Danh sách</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'bill-list')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='bill-list-stock') echo 'active' ?>">
						<a href="<?php echo get_slug('billbranch/bill_branch_list') ?>"><i class="fa fa-caret-right"></i> Quỹ tiền</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='bill-list-transfer') echo 'active' ?>">
						<a href="<?php echo get_slug('billtransfer/bill_transfer_list') ?>"><i class="fa fa-caret-right"></i> Sổ chuyển tiền</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='bill-list-income') echo 'active' ?>">
						<a href="<?php echo get_slug('billincome/bill_income_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu thu</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='bill-list-outcome') echo 'active' ?>">
						<a href="<?php echo get_slug('billoutcome/bill_outcome_list') ?>"><i class="fa fa-caret-right"></i> Sổ phiếu chi</a>
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