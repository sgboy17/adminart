<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

    <div class="page-content" >

        <!-- BEGIN PAGE CONTENT-->

        <!-- BEGIN PORTLET-->

        <div class="portlet light ">

            <div class="portlet-title">

                <div class="caption">

                    <i class="icon-bar-chart font-green-sharp"></i>

                    <span class="caption-subject font-green-sharp bold uppercase">Lớp</span>

                </div>

                    <div class="form-group pull-right m-r-sm">

                        <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">

                    </div>



                    <div class="form-group pull-right m-r-sm">

                        <select class="form-control" name="status" id="status">

                            <option value="">- Trạng thái -</option>

                            <option value="1" >Active</option>

                            <option value="2" >Inactive</option>

                        </select>

                    </div>





                    <div class="form-group pull-right m-r-sm">

                        <select class="form-control" name="teacher_id" id="teacher_id">

                            <option value="">- Giáo viên -</option>



                            <?php

                            $teacher_list = $this->teacherm->get_items();

                            foreach($teacher_list->result() as $row){ ?>

                                <option value="<?php echo $row->teacher_id ?>" ><?php echo $row->name ?></option>

                            <?php } ?>



                        </select>

                    </div>



                    <a class="btn btn-success pull-right admin-btn m-r" onclick="load_class_add()" href="#class_detail" data-toggle="modal"><i class="fa fa-plus"></i> Thêm</a>

                    <a class="btn btn-danger pull-right admin-btn" href="javascript:void(0)" onclick="delete_class_multiple();"><i class="fa fa-times"></i> Xoá</a>

                    <a class="btn btn-primary pull-right admin-btn" href="#import-data" data-toggle="modal"><i class="fa fa-upload"></i> Import Điểm danh</a>

                    <a class="btn btn-info pull-right admin-btn" href="<?php echo base_url() ?>upload/diem_danh.xlsx"><i class="fa fa-download"></i> Template Import</a>

            </div>

            <div class="portlet-body">

                <div class="row">

                    <div class="col-sm-12 col-md-12">

                        <div class="table-container table-responsive">

                            <table class="table table-hover" id="class_list">

                                <thead>

                                <tr role="row" class="heading">



                                    <th width="50"><div class="checkbox-list"><label><input type="checkbox" class="check_all" /></label></div></th>



                                    <th>Mã lớp</th>



                                    <th>Giáo viên</th>



                                    <th>Tình trạng</th>



                                    <th>Ngày sửa</th>



                                    <th width="150"></th>

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



<div id="class_detail" class="modal fade">

    <div class="modal-dialog" style="width: 95%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-edit"></i> Lớp (nhóm)</h3>

            </div>

            <form id="class_form">



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



<div id="import-data" class="modal modal-styled fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="modal-title"><i class="fa fa-upload"></i> Import dữ liệu</h3>

            </div>

            <div class="modal-body">

                <div class="col-md-12">

                    <label>Import: <a></a></label>

                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">

                        <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>

                        <span class="input-group-addon btn btn-default btn-file">

                        <input type="hidden" id="file_table" value="student_schedule" />

                            <span class="fileinput-new" id="file_upload">Chọn file</span>

                        </span>

                    </div>

                    <div class="progress file_upload_progress" style="display:none;">

                      <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%"></div>

                    </div>

                </div>

                <div class="clearfix"></div>

                <br/>

                <p style="color:red;font-style:italic;text-align:center;">Lưu ý: khi bạn import dữ liệu, tất cả dữ liệu cũ sẽ mất và thay thế bằng dữ liệu mới!</p>

            </div>

            <div class="modal-footer">

                <a class="btn btn-default" data-dismiss="modal" id="close_import">đóng</a>

            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->