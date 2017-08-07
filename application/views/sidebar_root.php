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
			
			<li class="<?php if(isset($page)&&strpos($page, 'root-branch')===0) echo 'active open' ?>">
				<a href="javascript:void(0)">
				<i class="fa fa-home"></i>
				<span class="title">Chi nhánh</span>
				<span class="selected"></span>
				<span class="arrow <?php if(isset($page)&&strpos($page, 'root-branch')===0) echo 'open' ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if(isset($page)&&$page=='root-branch-type') echo 'active' ?>">
						<a href="<?php echo get_slug('branchtype/branch_type_list') ?>"><i class="fa fa-caret-right"></i> Loại chi nhánh</a>
					</li>
					<li class="<?php if(isset($page)&&$page=='root-branch-root-item') echo 'active' ?>">
						<a href="<?php echo get_slug('branchroot/branch_root_list') ?>"><i class="fa fa-caret-right"></i> Chi nhánh</a>
					</li>
				</ul>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->
