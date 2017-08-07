<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Phân quyền</span>
                </div>
                <a class="btn btn-success pull-right admin-btn" onclick="permission_save()"><i class="fa fa-save"></i> lưu</a>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="tree-demo">
                            <ul>
                                <?php 
                                $user_group = $this->usergroupm->get_items(); 
                                foreach($user_group->result() as $row){
                                ?>
                                <li>
                                    <a class="btn btn-info" data-user-group-id="<?php echo $row->user_group_id; ?>" data-user-id="0"><i class="fa fa-users"></i> <?php echo $row->name; ?> <i class="fa fa-edit"></i></a>
                                    <ul>
                                        <?php 
                                        $user = $this->userm->get_items_by_user_group_id($row->user_group_id); 
                                        foreach($user->result() as $value){
                                        ?>
                                        <li>
                                            <a href="javascript:void(0)" class="label label-warning" data-user-group-id="0" data-user-id="<?php echo $value->user_id; ?>"><i class="fa fa-user"></i> <?php echo $value->username; ?>  <i class="fa fa-edit"></i></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="permission_list">
                                <thead>
                                <tr role="row" class="heading">
                                    <th width="25%">
                                        Tên quyền
                                    </th>
                                    <th width="15%">
                                        <input type="checkbox" class="check_all_view" /> Xem 
                                    </th>
                                    <th width="15%">
                                        <input type="checkbox" class="check_all_add" /> Thêm mới 
                                    </th>
                                    <th width="15%">
                                        <input type="checkbox" class="check_all_edit" /> Hiệu chỉnh 
                                    </th>
                                    <th width="15%">
                                        <input type="checkbox" class="check_all_delete" /> Xoá 
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
