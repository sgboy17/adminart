<?php

class Studentschedulem extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_items()
    {
        return $this->db->order_by('student_schedule_id DESC')
                        ->where('deleted', 0)
                        ->get($this->prefix . 'student_schedule');
    }

    function get_item_by_id($id)
    {
        return $this->db->where('student_schedule_id', $id)
                        ->get($this->prefix . 'student_schedule')
                        ->row_array();
    }

    function get_items_by_class_hour_id($id)
    {
        return $this->db->where('class_hour_id', $id)
                        ->where('deleted', 0)
                        ->get($this->prefix . 'student_schedule')
                        ->result();
    }

    function get_id($student_id, $class_hour_id, $date)
    {
        $row = $this->db->select('student_schedule_id')
                        ->where('student_id', $student_id)
                        ->where('class_hour_id', $class_hour_id)
                        ->where('branch_id', $this->session->userdata('branch'))
                        ->where('date', $date)
                        ->get($this->prefix . 'student_schedule')
                        ->row();

        if (!empty($row)) {
            return $row->student_schedule_id;
        } else {
            return '';
        }
    }

    function get_student_schedule_list()
    {

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }

        if (isset($_GET['f_student_id']) && !empty($_GET['f_student_id'])) {
            $this->db->where('student_id', $_GET['f_student_id']);
        }

        if (isset($_GET['f_class_hour_id']) && !empty($_GET['f_class_hour_id'])) {
            $this->db->where('class_hour_id', $_GET['f_class_hour_id']);
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('student_schedule_id DESC')->get($this->prefix . 'student_schedule');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->student_schedule_id,

                'branch_id' => $row->branch_id,

                'student_id' => $row->student_id,

                'class_hour_id' => $row->class_hour_id,

                'date' => $row->date,

                'status' => $row->status,

                'created_at' => $row->created_at,

                'updated_at' => $row->updated_at,

            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i = -1;
        foreach ($list as $row):
            $i++;
            if (!($i >= $_GET['iDisplayStart'] && $i < $_GET['iDisplayStart'] + $_GET['iDisplayLength'])) {
                continue;
            }

            $cate = array(

                $row['branch_id'],

                $row['student_id'],

                $row['class_hour_id'],

                $row['date'],

                $row['status'],

                $row['created_at'],

                $row['updated_at'],

                '<a href="#student_schedule_detail" data-toggle="modal" onclick="load_student_schedule_edit(' . $row['id'] . ');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_student_schedule(' . $row['id'] . ');"><span class="fa fa-times text-danger"></span></a>',
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

    function delete_student_schedule()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'student_schedule', array('deleted' => 1), array('student_schedule_id' => $id));
                }
            }
        }
    }

    function save_student_schedule_add()
    {
        $id = $this->uuid->v4();
        $data = array(

            'student_schedule_id' => $id,

            'branch_id' => $this->session->userdata('branch'),

            'student_id' => $this->input->post('student_id'),

            'class_hour_id' => $this->input->post('class_hour_id'),

            'hour' => $this->input->post('hour'),

            'date' => format_save_date($this->input->post('date')),

//            'status' => $this->input->post('status'),

            'created_at' => date("Y/m/d h:i:s"),

            'updated_at' => date("Y/m/d h:i:s"),

        );
        $save = $this->db->insert($this->prefix . 'student_schedule', $data);
        echo json_encode(array('id' => $id));
    }

    function save_student_schedule_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'branch_id' => $this->input->post('branch_id'),

                'student_id' => $this->input->post('student_id'),

                'class_hour_id' => $this->input->post('class_hour_id'),

                'hour' => $this->input->post('hour'),

                'date' => $this->input->post('date'),

                'status' => $this->input->post('status'),

                'updated_at' => date("Y/m/d h:i:s"),

            );

            if ($this->input->post('undelete')) {
                $data = array(

                    'deleted' => 0,

                    'updated_at' => date("Y/m/d h:i:s"),

                );
            }

            $save = $this->db->update($this->prefix . 'student_schedule', $data, array('student_schedule_id' => $id));
        }
    }

    function load_student_schedule_add()
    {
        ?>
        <div class="modal-body">

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="branch_id">
                        <option value="">- Trung tâm -</option>

                        <?php
                        $branch_list = $this->branchm->get_items();
                        foreach ($branch_list->result() as $row) { ?>
                            <option value="<?php echo $row->branch_id ?>"><?php echo $row->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Học viên:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="student_id">
                        <option value="">- Học viên -</option>

                        <?php
                        $student_list = $this->studentm->get_items();
                        foreach ($student_list->result() as $row) { ?>
                            <option value="<?php echo $row->student_id ?>"><?php echo $row->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giờ học:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="class_hour_id">
                        <option value="">- Giờ học -</option>

                        <?php
                        $class_hour_list = $this->classhourm->get_items();
                        foreach ($class_hour_list->result() as $row) { ?>
                            <option value="<?php echo $row->class_hour_id ?>"><?php echo $row->room_id ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày học:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date" placeholder="ngày học" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Trạng thái:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="status" placeholder="trạng thái" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày tạo:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="created_at" placeholder="ngày tạo" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày sửa:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="updated_at" placeholder="ngày sửa" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_student_schedule_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }

    function load_student_schedule_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('student_schedule_id', $id)->where('deleted', 0)->get($this->prefix . 'student_schedule');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:branch;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->student_schedule_id ?>"/>
            <div class="modal-body">

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Trung tâm:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="branch_id">
                            <option value="">- Trung tâm -</option>

                            <?php
                            $branch_list = $this->branchm->get_items();
                            foreach ($branch_list->result() as $row) {
                                ?>
                                <option
                                    value="<?php echo $row->branch_id ?>" <?php if ($result->branch_id == $row->branch_id) {
                                    echo 'selected=""';
                                }
                                ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Học viên:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="student_id">
                            <option value="">- Học viên -</option>

                            <?php
                            $student_list = $this->studentm->get_items();
                            foreach ($student_list->result() as $row) {
                                ?>
                                <option
                                    value="<?php echo $row->student_id ?>" <?php if ($result->student_id == $row->student_id) {
                                    echo 'selected=""';
                                }
                                ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Giờ học:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="class_hour_id">
                            <option value="">- Giờ học -</option>

                            <?php
                            $class_hour_list = $this->classhourm->get_items();
                            foreach ($class_hour_list->result() as $row) {
                                ?>
                                <option
                                    value="<?php echo $row->class_hour_id ?>" <?php if ($result->class_hour_id == $row->class_hour_id) {
                                    echo 'selected=""';
                                }
                                ?>><?php echo $row->room_id ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày học:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date" value="<?php echo $result->date ?>" placeholder="ngày học"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Trạng thái:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="status" value="<?php echo $result->status ?>" placeholder="trạng thái"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày tạo:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="created_at" value="<?php echo $result->created_at ?>"
                               placeholder="ngày tạo" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày sửa:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="updated_at" value="<?php echo $result->updated_at ?>"
                               placeholder="ngày sửa" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_student_schedule_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
            <?php
        }
    }

    function load_student_schedule()
    {
        $student_class_ids = explode('|', $this->input->post('student_class_id'));

        $events = array();
        $print_html = "";

        $schedule_data = excuteMultiClassInProgram($student_class_ids);

        if(isset($schedule_data['data']) &&
            isset($schedule_data['date_start']) &&
            isset($schedule_data['date_end'])
        ) {

            $temp_start_date = $schedule_data['date_start'];
            $temp_end_date = $schedule_data['date_end'];

            foreach($schedule_data['data'] as $value) {

                $text = "";
                $text .= $value['class_name'].' - ' .$value['program_name'].'<br/>';
                $text .= $value['room_name'] . '<br/>';
                $text .= $value['from_time'] . ' - ' . $value['to_time'] . "<br>";

                if($value['note'] !="") {
                    $text .= "Ghi chú: " . $value['note'] . '<br/>';
                }

                $events[$value['day']][] = array(
                    'text' => $text,
                    'href' => "javascript:void(0)' onclick='load_change_schedule(\"". $value['student_class_id'] . "\",\"" . $value['day'] . "\")",
                );

            }

            $student_name = "";

            $count = 1;
            usort($schedule_data['data'], function($a, $b) {
                return $a['day_int'] - $b['day_int'];
            });
            foreach($schedule_data['data'] as $print) {
                $print_html .= "<tr>
                            <td style='text-align:center'>".$count."</td>
                            <td style='text-align:center'>".$print['room_name']."</td>
                            <td style='text-align:center'>".$print['day']."</td>
                            <td style='text-align:center'>".$print['from_time']."</td>
                            <td style='text-align:center'>".$print['to_time']."</td>
                            <td style='text-align:center'>".$print['program_name']."</td>
                            <td style='text-align:center'>".$print['class_name']."</td>
                            </tr>";
                $count ++;
            }


            ?>
            <div class="modal-body">
                <p style="color:red;">* Vui lòng click vào ngày để sửa thời khoá biểu.</p>
                <a style="float:right;" href="javascript:printDiv('schedule_print');" class="label label-info"><span class=""> In thời khoá biểu</span></a>

                <div class="portlet light " id="schedule_print" style="display: none;">
                    <div class="portlet-title">
                        <h3 style="text-align:center;">Thời khoá biểu</h3>
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase"> Tên: <b><?php echo $student_name; ?></b></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="table-container table-responsive">
                                    <table class="table table-hover" id="student_list">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th style="text-align:center">STT</th>
                                                <th style="text-align:center">Phòng học</th>
                                                <th style="text-align:center">Ngày học</th>
                                                <th style="text-align:center">Từ giờ</th>
                                                <th style="text-align:center">Đến giờ</th>
                                                <th style="text-align:center">Chương trình học</th>
                                                <th style="text-align:center">Lớp học</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            echo $print_html;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $date = $temp_start_date;
                while (strtotime($date) <= strtotime($temp_end_date)) {
                    $getdate = getdate(strtotime($date));
                    echo '<h4>' . $getdate['mon'] . '/' . $getdate['year'] . '</h4>';
                    echo build_html_calendar($getdate['year'], $getdate['mon'], $events);
                    $date = $getdate['year'] . '-' . $getdate['mon'] . '-1';
                    $date = date("Y-m-d", strtotime("+1 month", strtotime($date)));
                }
                ?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
        <?php
        }
    }

    function load_change_schedule()
    {
        $student_class_id = $this->input->post('student_class_id');
        $date = $this->input->post('date');

        $student_class = $this->studentclassm->get_item_by_id($student_class_id);
        ?>
        <input type="hidden" name="class_id" value="<?php echo $student_class['class_id'] ?>">
        <input type="hidden" name="student_id" value="<?php echo $student_class['student_id'] ?>">
        <input type="hidden" name="student_class_id" value="<?php echo $student_class_id; ?>">
        <input type="hidden" value="<?php echo $this->invoicem->generate_code($this->session->userdata('branch')); ?>" name="invoice_code" class="form-control"></input>

        <div class="modal-body">

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày hiện tại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="from_date" readonly placeholder="Ngày hiện tại"
                           class="form-control" data-value="<?php echo $date ?>"
                           value="<?php echo format_get_date($date) ?>"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày chuyển đến:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="to_date" placeholder="Ngày chuyển đến" class="form-control to-datepicker"
                           value=""></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Lớp:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="class_id" onchange="check_special_hour('<?php echo $student_class_id; ?>',$(this).val(),false)">
                        <option value="">- lớp -</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="extra_container" class="form-group m-t-sm" style="display: none;">
                <div class="col-md-4">
                    <div class="m-t-sm">Phụ thu giờ vàng:</div>
                </div>
                <div class="col-md-8">
                    <b id="lbl_extra"></b>
                    <input type="hidden" name="extra_hour" id="extra_hour" value="">
                    <input type="hidden" name="extra_price" id="extra_price" value="">
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Lý do:</div>
                </div>
                <div class="col-md-8">
                    <textarea name="note" placeholder="lý do" class="form-control"></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>

        <div class="modal-footer">
            <a class="btn btn-info" id="btn_save_print" style="display:none;" onclick="save_change_schedule($(this),true)">Lưu và In</a>
            <a class="btn btn-success" onclick="save_change_schedule($(this),false)">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }

    function save_change_schedule()
    {
        $check = true;
        $changedate_data_from = $this->db->select('cs.*, r.name as room_name, ch.from_time, ch.to_time')
            ->from($this->prefix . 'change_schedule cs')
            ->join($this->prefix . 'class c', 'c.class_id = cs.class_id')
            ->join($this->prefix . 'class_hour ch', 'ch.class_id = c.class_id')
            ->join($this->prefix . 'room r', 'r.room_id = ch.room_id')
            ->where('cs.deleted', 0)
            ->where('ch.deleted', 0)
            ->where('c.deleted', 0)
            ->where('r.deleted', 0)
            ->where('cs.from_date', format_save_date($this->input->post('from_date')))
            ->or_where('cs.from_date', format_save_date($this->input->post('to_date')))
            ->where('cs.student_id', $this->input->post('student_id'))
            ->where('cs.student_class_id', $this->input->post('student_class_id'))
            ->order_by('from_date DESC')
            ->get();

        $changedate_data_to = $this->db->select('cs.*, r.name as room_name, ch.from_time, ch.to_time')
            ->from($this->prefix . 'change_schedule cs')
            ->join($this->prefix . 'class c', 'c.class_id = cs.class_id')
            ->join($this->prefix . 'class_hour ch', 'ch.class_id = c.class_id')
            ->join($this->prefix . 'room r', 'r.room_id = ch.room_id')
            ->where('cs.deleted', 0)
            ->where('ch.deleted', 0)
            ->where('c.deleted', 0)
            ->where('r.deleted', 0)
            ->where('cs.to_date', format_save_date($this->input->post('from_date')))
            ->or_where('cs.to_date', format_save_date($this->input->post('to_date')))
            ->where('cs.student_id', $this->input->post('student_id'))
            ->where('cs.student_class_id', $this->input->post('student_class_id'))
            ->order_by('from_date DESC')
            ->get();

        $from = format_save_date($this->input->post('from_date'));
        if($changedate_data_from->num_rows() > 0) {
            foreach($changedate_data_from->result() as $value) {
                $from = $value->to_date;
                $this->db->update($this->prefix . 'change_schedule', array('deleted' => 1), array('change_schedule_id' => $value->change_schedule_id));
            }
        }

        if ($changedate_data_to->num_rows() > 0) {
            foreach($changedate_data_to->result() as $value) {
                $from = $value->from_date;
                $this->db->update($this->prefix . 'change_schedule', array('deleted' => 1), array('change_schedule_id' => $value->change_schedule_id));
            }
        }

        if($check == true) {
            $data = array (
                'change_schedule_id' => $this->uuid->v4(),

                'branch_id' => $this->session->userdata('branch'),

                'student_id' => $this->input->post('student_id'),

                'class_id' => $this->input->post('class_id'),

                'student_class_id' => $this->input->post('student_class_id'),

                'from_date' => $from,

                'to_date' => format_save_date($this->input->post('to_date')),

                'note' => $this->input->post('note'),

                'created_at' => date("Y/m/d h:i:s"),

                'updated_at' => date("Y/m/d h:i:s"),

            );
            $this->db->insert($this->prefix . 'change_schedule', $data);

            /* tao invoice */
            $extra_price = $this->input->post('extra_price', 0);
            if($extra_price != 0) {
                $invoice_id = $this->uuid->v4();
                $invoice = array(
                    'invoice_id' => $invoice_id,
                    'invoice_code' => $this->input->post('invoice_code'),
                    'branch_id' => $this->session->userdata('branch'),
                    'student_id' => $this->input->post('student_id'),
                    'user_id' => $this->session->userdata('user'),
                    'event_id' => $this->input->post('event_id', null),
                    'sub_total' => $this->input->post('extra_price', 0),
                    'extra_discount' => $this->input->post('extra_discount', 0),
                    'discount' => $this->input->post('discount', 0),
                    'surcharge' => $this->input->post('surcharge', 0),
                    'total' => $this->input->post('extra_price', 0),
                    'type' => INVOICE_TYPE_3,
                    'note' => $this->input->post('note', null),
                    'other' => $this->input->post('other', null),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $this->db->insert($this->prefix . 'invoice', $invoice);
                echo $invoice_id;
            }
            /* tao invoice */
        }

    }

}
