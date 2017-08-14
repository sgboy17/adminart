<?php $version = '1.2'; ?>
<?php $theme = "layout3"; ?>
<?php $current_user = $this->userm->get_user(); ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <title><?php echo $title; ?> - <?php echo strtoupper($_SERVER['HTTP_HOST']); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <script type="text/javascript">var base_url = '<?php echo base_url() ?>';
        var request_filter = ''; </script>
    <script type="text/javascript">var id_url = '<?php echo $id ?>'; </script>

    <link rel="shortcut icon" href="<?php echo base_url() ?>resources_admin/images/icon.png">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!--  <link
        href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css"
        rel="stylesheet" type="text/css"> -->
    <link
        href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
        rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global_new/plugins/bootstrap/css/bootstrap.min.css"
          rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css">
    <link
        href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
        rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-summernote/summernote.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources_admin/css/custom.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/morris/morris.css"
          rel="stylesheet" type="text/css">
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/pages/css/tasks.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->

    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/components-rounded.css"
          id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/global_new/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
     <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/layout.css" rel="stylesheet" type="text/css"/>
     <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/custom.css"
          rel="stylesheet" type="text/css"/>

    <!-- DuyNH -->
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/layout.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/themes/blue.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/custom.min.css"
          rel="stylesheet" type="text/css"/>
    <!--
<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>resources_admin/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/themes/light.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>resources_admin/metronic/assets/admin/<?php echo $theme; ?>/css/custom.css" rel="stylesheet" type="text/css"/>
-->
   <!--  <link href="<?php echo base_url() ?>resources_admin/css/custom.css?ver=<?php echo $version ?>" rel="stylesheet"
          type="text/css"/> -->
    <!-- END THEME STYLES -->
    <script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.min.js"
            type="text/javascript"></script>
    <script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery-migrate.min.js"
            type="text/javascript"></script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
 <body class="page-container-bg-solid">

<!-- Header BEGIN -->
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
             <!-- BEGIN HEADER -->
            <div class="page-header">
                 <!-- BEGIN HEADER TOP -->
                <div class="page-header-top">
                    <div class="container">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo">
                            <a href="<?php echo base_url() ?>">
                                <img src="<?php echo base_url() ?>resources_admin/images/logo.png" alt="logo" class="logo-default" style="width: 216px; margin-top:10px"/>
                            </a>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->

                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                                <li class="dropdown dropdown-user dropdown-dark">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <img alt="" class="img-circle" src="<?php echo base_url() ?><?php echo image('upload/' . $current_user['avatar'], 40, 40); ?>">
                                        <span class="username username-hide-mobile"><?php echo $current_user["name"]; ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default">
                                        <li>
                                            <a href="<?php echo get_slug('index/logout') ?>">
                                                <i class="icon-key"></i> Log Out </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END HEADER TOP -->
                <!-- BEGIN HEADER MENU -->
                <div class="page-header-menu">
                    <div class="container">
                        <!-- BEGIN MEGA MENU -->
                        <div class="hor-menu  ">
                            <ul class="nav navbar-nav">
                                <li class="menu-dropdown classic-menu-dropdown">
                                    <a href="#"> Cấu hình
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="dropdown-submenu ">
                                            <a href="javascript:;" class="nav-link nav-toggle ">
                                                <i class="icon-group"></i> Phân quyền
                                                <span class="arrow"></span>
                                            </a>

                                            <ul class="dropdown-menu ">
                                                <li class="<?php if($page == 'user_list') echo 'active' ?>">
                                                    <a href="<?php echo get_slug('user/user_list') ?>" class="nav-link ">
                                                        <i class="icon-group"></i> Người dùng </a>
                                                </li>
                                                <li class="<?php if($page == 'user_group_list') echo 'active' ?>">
                                                    <a href="<?php echo get_slug('usergroup/user_group_list') ?>" class="nav-link ">
                                                        <i class="icon-group"></i> Nhóm người dùng </a>
                                                </li>

                                                <li class="<?php if($page == 'setting-user-permission') echo 'active' ?>">
                                                    <a href="<?php echo get_slug('permission/permission_list') ?>" class="nav-link ">
                                                        <i class="icon-group"></i> Phân quyền </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="<?php if($page == 'branch_list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('branch/branch_list') ?>" class="nav-link nav-toggle ">
                                                <i class="icon-building"></i> Quản lý chi nhánh
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown">
                                    <a href="#"> Trung tâm
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="dropdown-submenu">
                                            <a href="#"> Báo cáo chi nhánh</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a> Doanh thu chi nhánh </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo ngày </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo tháng </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo giáo viên </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo sale </a>
                                                </li>
                                                <li>
                                                    <a> Thời khóa biểu theo phòng </a>
                                                </li>
                                                <li>
                                                    <a> Thời khóa biểu theo GV </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#"> Báo cáo thu chi</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a> Báo cáo thu </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo chi </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo luân chuyển tiền </a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#"> Báo cáo học viên</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a> Thống kê học viên </a>
                                                </li>
                                                <li>
                                                    <a> Thống kê học phí </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown">
                                    <a href="#"> Khóa học
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="dropdown-submenu">
                                            <a href="#"> Báo Cáo Thống Kê</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a> Báo cáo HV theo ngày </a>
                                                </li>
                                                <li>
                                                    <a href="http://localhost/project/wowart/Main/student/student_report_month" class="nav-link  "> Báo cáo HV theo tháng </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo tháng </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo giáo viên </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo sale </a>
                                                </li>
                                                <li>
                                                    <a> Báo cáo HV theo phòng </a>
                                                </li>
                                                <li>
                                                    <a> Thời khóa biểu theo GV </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="<?php if($page == 'room-list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('room/room_list') ?>" class="nav-link  "> Quản lý phòng học </a>
                                        </li>
                                        <li class="<?php if($page == 'class-list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('classc/class_list') ?>" class="nav-link  "> Quản lý lớp học </a>
                                        </li>
                                        <li class="<?php if($page == 'student-list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('student/student_list') ?>" class="nav-link  "> Quản lý học viên </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown ">
                                    <a href="javascript:;"> Thu chi
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="<?php if($page == 'bill-list-income') echo 'active' ?>">
                                            <a href="<?php echo get_slug('billincome/bill_income_list') ?>" class="nav-link  "> Sổ phiếu thu </a>
                                        </li>
                                        <li class="<?php if($page == 'bill-list-outcome') echo 'active' ?>">
                                            <a href="<?php echo get_slug('billoutcome/bill_outcome_list') ?>" class="nav-link  "> Sổ phiếu chi </a>
                                        </li>
                                        <li class="<?php if($page == 'bill-list-transfer') echo 'active' ?>">
                                            <a href="<?php echo get_slug('billtransfer/bill_transfer_list') ?>" class="nav-link  "> Sổ chuyển tiền </a>
                                        </li>
                                        <li class="<?php if($page == 'bill-list-branch-bank') echo 'active' ?>">
                                            <a href="<?php echo get_slug('billbranchbank/bill_branch_bank_list') ?>" class="nav-link  "> Quỹ tiền mặt/ ngân hàng </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown ">
                                    <a href="javascript:;"> Đào tạo
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="<?php if($page == 'education-program') echo 'active' ?>">
                                            <a href="<?php echo get_slug('program/program_list') ?>" class="nav-link  "> Chương trình học </a>
                                        </li>
                                        <li class="<?php if($page == 'education-teacher') echo 'active' ?>">
                                            <a href="<?php echo get_slug('teacher/teacher_list') ?>" class="nav-link  "> Giáo viên </a>
                                        </li>
                                        <li class="<?php if($page == 'education-dateoff') echo 'active' ?>">
                                            <a href="<?php echo get_slug('dateoff/date_off_list') ?>" class="nav-link  "> Ngày nghỉ </a>
                                        </li>
                                        <li class="<?php if($page == 'education-event') echo 'active' ?>">
                                            <a href="<?php echo get_slug('event/event_list') ?>" class="nav-link  "> Quản lý sự kiện / chiết khấu / khuyến mãi </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown ">
                                    <a href="javascript:;"> Học phí
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="<?php if($page == 'invoice_list' || $page == 'student_consult_list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('invoice/invoice_list') ?>" class="nav-link  ">  Quản lý phiếu thu </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-dropdown classic-menu-dropdown ">
                                    <a href="javascript:;"> CRM
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu pull-left">
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                            <a href="http://localhost/project/wowart/Main/student_list"> Học viên
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                        <li >
                                            <a href="http://localhost/project/wowart/Main/seller_list"> Phân công sale
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                        <li class="<?php if($page == 'seller_list' || $page == 'student_consult_list') echo 'active' ?>">
                                            <a href="<?php echo get_slug('seller/seller_list') ?>" class="nav-link  ">  Tác vụ nhân viên sale </a>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#"> Báo Cáo</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="http://localhost/project/wowart/SourceCode/student/student_report_month" class="nav-link  "> KPIs nhân viên sal </a>
                                                </li>
                                                <li>
                                                    <a href="http://localhost/project/wowart/SourceCode/student/student_report_month" class="nav-link  "> Học viên theo tác vụ sale </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                         <!-- END MEGA MENU -->
                    </div>
                </div>
                <!-- END HEADER MENU -->
            </div>
            <!-- END HEADER -->
        </div>
    </div>

    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                         <div class="container">
                            
                            <!-- BEGIN CONTAINER -->

                            <?php echo $content; ?>
                            <!-- END CONTAINER -->

                         </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->
        </div>
    </div>

    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->
            <!-- BEGIN PRE-FOOTER -->
            <!-- <div class="page-prefooter">
            </div> -->
            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container">  2015 &copy; KINGWORK.
                    
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
            <!-- END INNER FOOTER -->
            <!-- END FOOTER -->
        </div>
    </div>
</div>

<!-- Header END -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
  <script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/respond.min.js"></script>
  <script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/excanvas.min.js"></script>
  <![endif]-->
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script
    src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
    type="text/javascript"></script>
<script
    src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
    type="text/javascript"></script>
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/jquery.cokie.min.js"
        type="text/javascript"></script>
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script
    src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
    type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script
    src="<?php echo base_url() ?>resources_admin/metronic/assets/global/plugins/bootstrap-summernote/summernote.min.js"
    type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<script src="<?php echo base_url() ?>resources_admin/js/plugins/select2/select2.js"></script>
<script src="<?php echo base_url() ?>resources_admin/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources_admin/js/plugins/plupload/plupload.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/js/plugins/plupload/plupload.html4.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/js/plugins/plupload/plupload.html5.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/js/plugins/plupload/plupload.flash.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/js/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript"
        src="<?php echo base_url() ?>resources_admin/js/plugins/validate/jquery.validate.min.js"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/global/scripts/metronic.js"
        type="text/javascript"></script>
<script src="<?php echo base_url() ?>resources_admin/metronic/assets/admin/layout5/scripts/layout.js"
        type="text/javascript"></script>


<!-- END PAGE LEVEL SCRIPTS -->


<?php if (isset($page) && strpos($page, 'root') === 0) { ?>
    <?php define("TOKEN_ROOT", 1) ?>
    <?php include 'permission.php'; ?>
    <script type="text/javascript"
            src="<?php echo base_url() ?>resources_admin/app_js/branch_root.js?ver=<?php echo $version ?>"></script>
    <script type="text/javascript"
            src="<?php echo base_url() ?>resources_admin/app_js/branch_type.js?ver=<?php echo $version ?>"></script>
<?php } else { ?>
<?php define("TOKEN_ROOT", 0) ?>
<?php include 'permission.php'; ?>
    <script type="text/javascript"
            src="<?php echo base_url() ?>resources_admin/js/custom.js?ver=<?php echo $version ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/class.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/room.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/teacher.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/action.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/student.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/permission.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/invoice.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/user_list.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/user_group.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/branch.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/date_off.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/event.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/bill_income.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/bill_outcome.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/bill_transfer.js"></script>
    <script type="text/javascript"
            src="<?php echo base_url() ?>resources_admin/app_js/program.js?ver=<?php echo $version ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/seller.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/student_consult.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>resources_admin/app_js/bill_bank_branch.js"></script>
<?php }
?>


<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        if ($('.datepicker').length) {
            $('.datepicker').datepicker({format: 'dd/mm/yyyy', autoclose: true});
        }
        if ($('.timepicker').length) {
            $('.timepicker-no-seconds').timepicker({
                autoclose: true,
                minuteStep: 30
            });
        }
        if ($('.summernote').size() > 0) {
            $('.summernote').summernote({height: 150});
        }
        $('.db-sync').on('click', function () {
            jQuery.ajax({
                type: 'GET',
                url: base_url + 'dbsync/server',
                dataType: 'json',
                beforeSend: function (xhr) {
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
                },
                success: function (resp) {
                    if (resp == 1) {
                        $.unblockUI();
                    }
                }
            });
        });

       
    });

</script>
<!-- END JAVASCRIPTS -->
</body>
</html>