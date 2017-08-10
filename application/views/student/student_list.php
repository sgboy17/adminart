<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

    <div class="page-content">

        <!-- BEGIN PAGE CONTENT-->

        <!-- BEGIN PORTLET-->

        <div class="portlet light ">

            <div class="portlet-title">

                <div class="caption">

                    <i class="icon-bar-chart font-green-sharp"></i>

                    <span class="caption-subject font-green-sharp bold uppercase">Học viên</span>

                </div>


                    <div class="form-group pull-right m-r-sm">

                        <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">

                    </div>



                    <div class="form-group pull-right m-r-sm">

                        <select class="form-control" name="status" id="status">

                            <option value="">- Tình trạng -</option>

                            <option value="1" >Active</option>

                            <option value="2" >Inactive</option>

                        </select>

                    </div>



                    <div class="form-group pull-right m-r-sm">

                        <select class="form-control" name="type" id="type">

                            <option value="">- Loại -</option>



                            <option value="1" >Học viên tiềm năng</option>



                            <option value="2" >Học viên mới</option>



                            <option value="3" >Học viên sắp hết hạn</option>



                            <option value="4" >Học viên bảo lưu</option>



                            <option value="5" >Học viên đã nghỉ</option>



                        </select>

                    </div>







                    <a class="btn btn-success pull-right admin-btn m-r" onclick="load_student_add()" href="#student_detail" data-toggle="modal"><i class="fa fa-plus"></i> Thêm</a>



                    <a href="#student_branch_transfer" data-toggle="modal" class="btn btn-success pull-right admin-btn m-r label-default" onclick="load_student_branch_transfer();"><span>Chuyển trung tâm</span></a>

                    <a href="#all_student_branch" data-toggle="modal" class="btn btn-success pull-right admin-btn m-r label-default" onclick="load_all_student_branch();"><span>Danh sách học viên</span></a>



            </div>

            <div class="portlet-body">

                <div class="row">

                    <div class="col-sm-12 col-md-12">

                        <div class="table-container table-responsive">

                            <table class="table table-hover" id="student_list">

                                <thead>

                                <tr role="row" class="heading">



                                    <th width="10%">Mã học viên</th>



                                    <th width="20%">Thông tin học viên</th>



                                    <th width="10%">Trạng thái</th>



                                    <th width="30%">Thao tác lớp</th>



                                    <th width="5%"></th>

                                </tr>

                                </thead>

                                <tbody>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- END PORTLET-->

        <!-- END PAGE CONTENT-->

    </div>

</div>

<!-- END CONTENT -->



<div id="student_detail" class="modal fade">

    <div class="modal-dialog" style="width: auto;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Học viên</h3>

            </div>

            <form id="student_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="student_action" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Thao tác lớp</h3>

            </div>

            <form id="student_action_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="branch_change" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Chuyển trung tâm</h3>

            </div>

            <form id="branch_change_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="transfer_friend" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Chuyển giờ cho bạn</h3>

            </div>

            <form id="transfer_friend_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->







<div id="class_attendance" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Điểm danh</h3>

            </div>

            <form id="class_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="student_schedule" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Thời khóa biểu</h3>

            </div>

            <form id="student_schedule_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="student_history" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Lịch sử học</h3>

            </div>

            <form id="student_history_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="change_schedule" class="modal fade">

    <div class="modal-dialog" >

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Sửa Thời khóa biểu</h3>

            </div>

            <form id="change_schedule_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="invoice_action" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Thao tác</h3>

            </div>

            <form id="invoice_action_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="student_branch_transfer" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Danh sách học viên chuyển trung tâm</h3>

            </div>

            <form id="student_branch_transfer_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="all_student_branch" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Danh sách học viên các trung tâm</h3>
            </div>

            <form id="all_student_branch_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div id="note_detail" class="modal fade">

    <div class="modal-dialog" style="width: 50%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> NOTE</h3>
            </div>

            <form id="student_note_form">



            </form>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->




<iframe src="" style="display: none" id="myPrintView"></iframe>

