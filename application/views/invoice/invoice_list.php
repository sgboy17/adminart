<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Phiếu thu</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Từ ngày:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control datepicker" name="from_date" id="from_date"></input>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Đến ngày:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"></input>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Học viên:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="student_id" id="student_id">
                                            <option value="">- Học viên -</option>

                                            <?php
                                            $student_list = $this->studentm->get_items();
                                            foreach($student_list->result() as $row){ ?>
                                                <option value="<?php echo $row->student_id ?>" ><?php echo $row->name ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Mã phiếu thu:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="search" placeholder="Mã phiếu thu">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-md-4" style="display:none;">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Lớp:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="class_id" id="class_id">
                                            <option value="">- Tất cả -</option>
                                            <?php
                                            $object_list = $this->classm->get_items();
                                            foreach($object_list->result() as $row){
                                                ?>
                                                <option value="<?php echo $row->class_id ?>" ><?php echo $row->class_code ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group m-t-sm">
                                    <div class="col-md-4">
                                        <div class="m-t-sm">Event:</div>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="event_id" id="event_id">
                                            <option value="">- Tất cả -</option>
                                            <?php
                                            $customer_list = $this->eventm->get_items();
                                            foreach($customer_list->result() as $row){ ?>
                                                <option value="<?php echo $row->event_id ?>" ><?php echo $row->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>

                        <div class="table-container table-responsive m-t">
                            <table class="table table-hover" id="invoice_list">
                                <thead>
                                <tr role="row" class="heading">

                                    <th>Mã phiếu thu</th>

                                    <th>Học viên</th>

                                    <th>Nội dung</th>
            
                                    <th>Tổng tiền</th>
                    
                                    <th>Ngày tạo</th>
                    
                                    <th></th>

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

<iframe src="" style="display: none" id="myPrintView"></iframe>