<?php

class Actionm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('action_id DESC')->where('deleted', 0)->get($this->prefix . 'action');
    }

    function get_reverse_action($action, $object_id, $from)
    {
        return $this->db->where('action', $action)->where('object_id', $object_id)->where('deleted', 0)->where('from', $from)->order_by('created_at DESC')->limit(1, 0)->get($this->prefix . 'action')->row();
    }

    function get_cont_action($action, $object_id, $to)
    {
        return $this->db->where('action', $action)->where('object_id', $object_id)->where('deleted', 0)->where('to', $to)->order_by('created_at DESC')->limit(1, 0)->get($this->prefix . 'action')->row();
    }

    function get_branch_transfer_action($branch_id, $student_id)
    {
        return $this->db->where('action', STUDENT_STATUS_8)->where('branch_id', $branch_id)->where('deleted', 0)->where('object_id', $student_id)->order_by('created_at DESC')->limit(1, 0)->get($this->prefix . 'action')->row();
    }

    function get_extra_days_action($branch_id, $student_id,$program_id)
    {
        $data = $this->db->where('action', STUDENT_STATUS_13)->where('branch_id', $branch_id)->where('deleted', 0)->where('object_id', $student_id)->where('from', $program_id)->order_by('created_at DESC')->get($this->prefix . 'action');
        $total = 0;
        foreach($data->result() as $v) {
            $total += $v->to;
        }
        return $total;
    }

    function get_transfer_money($action, $object_id, $program_id)
    {
        return $this->db->select('sum(sc.money) as total_money')
            ->from($this->prefix . 'action a')
            ->join($this->prefix . 'student_money sc', 'a.from = sc.student_money_id')
            ->where('a.to', $object_id)
            ->where('a.action', $action)
            ->where('sc.program_id', $program_id)
            ->where('a.deleted', 0)
            ->where('sc.deleted', 0)
            ->get()
            ->row_array();
    }

    function get_transfer_friend_action($action, $object_id, $program_id)
    {
        return $this->db->select('a.*')
            ->from($this->prefix . 'action a')
            ->join($this->prefix . 'student_money sc', 'a.from = sc.student_money_id')
            ->where('a.object_id', $object_id)
            ->where('a.action', $action)
            ->where('sc.program_id', $program_id)
            ->where('a.deleted', 0)
            ->where('sc.deleted', 0)
            ->get()
            ->row_array();

    }

    function get_item_by_id($id)
    {
        return $this->db->where('action_id', $id)->get($this->prefix . 'action')->row_array();
    }


    function get_action_list()
    {

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('action_id DESC')->get($this->prefix . 'action');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->action_id,

                'branch_id' => $row->branch_id,

                'object_id' => $row->object_id,

                'action' => $row->action,

                'from' => $row->from,

                'to' => $row->to,

                'note' => $row->note,

                'created_at' => $row->created_at,

            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i = -1;
        foreach ($list as $row):
            $i++;
            if (!($i >= $_GET['iDisplayStart'] && $i < $_GET['iDisplayStart'] + $_GET['iDisplayLength'])) continue;
            $cate = array(

                $row['branch_id'],

                $row['object_id'],

                $row['action'],

                $row['from'],

                $row['to'],

                $row['note'],

                $row['created_at'],

                '<a href="#action_detail" data-toggle="modal" onclick="load_action_edit(' . $row['id'] . ');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_action(' . $row['id'] . ');"><span class="fa fa-times text-danger"></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

    function delete_action()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'action', array('deleted' => 1), array('action_id' => $id));
                }
            }
        }
    }

    function save_action_register($program, $class_id) {

        $class = $this->classm->get_item_by_id($class_id);
        $class_hour = $this->classhourm->get_item_by_class_id($class['class_id']);
        if (empty($class_hour)) return false;

        $date_start = $this->input->post('date_start') ? $this->input->post('date_start') : date("d/m/Y");
        $weekday = date('N', strtotime(format_save_date($date_start)));
        $list_date = array($weekday);
        $total_hour = $program['total_time'];
        $list_date_off = array();
        $from_time = array($weekday => $class_hour['from_time']);
        $to_time = array($weekday => $class_hour['to_time']);
        $dateoff = $this->dateoffm->get_items();
        foreach ($dateoff->result() as $row) {
            $list_date_off[] = $row->date;
        }
        $date_total_time = array($weekday => $this->input->post('hour') ? $this->input->post('hour') : 2);

        if ($this->input->post('other')) {
            $total_hour = (int) $this->input->post('other') * (int) $this->input->post('hour');
        }

        $data_to = array(
            'list_date' => $list_date,
            'date_start' => $date_start,
            'total_hour' => $total_hour,
            'list_date_off' => $list_date_off,
            'date_total_time' => $date_total_time,
            'from_time' => $from_time,
            'to_time' => $to_time,
            'study_hour' => $this->input->post('hour') ? $this->input->post('hour') : 2
        );

        $expire_date = excuteExpireDate($data_to);
        $from_date = date('Y-m-d', strtotime(format_save_date($date_start)));
        $to_date = $expire_date['date'];
        $student_class_id = $this->uuid->v4();

        if ($this->input->post('action') == STUDENT_STATUS_5) {
            $from = $this->input->post('student_class_id');
            $to = $student_class_id;
            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            $student_multi_class = $this->studentclassm->get_items_by_student_program_id($student_class['student_id'], $student_class['program_id']);
            foreach ($student_multi_class->result() as $row) {
                $this->db->update($this->prefix . 'student_class', array('status' => 2), array('student_class_id' => $row->student_class_id));
                if ($row->student_class_id == $this->input->post('student_class_id')) continue;
            }

            $data_multi = array(
                'action_id' => $this->uuid->v4(),

                'branch_id' => $this->input->post('branch_id'),

                'object_id' => $this->input->post('object_id'),

                'action' => $this->input->post('action'),

                'from' => $this->input->post('student_class_id'),

                'to' => $to,

                'note' => $this->input->post('note'),

                'created_at' => date('Y-m-d H:i:s')

            );
            $save = $this->db->insert($this->prefix . 'action', $data_multi);

        } else {
            $data = array(
                'action_id' => $this->uuid->v4(),

                'branch_id' => $this->input->post('branch_id'),

                'object_id' => $this->input->post('object_id'),

                'action' => $this->input->post('action'),

                'from' => $student_class_id,

                'to' => '',

                'note' => $this->input->post('note') ? $this->input->post('note') : "",

                'created_at' => date('Y-m-d H:i:s')

            );

            // hoc thu
            if ($this->input->post('action') == STUDENT_STATUS_10) {
                $data['to'] = $this->input->post('invoice_id');
                $data['note'] = $total_hour;
            }

            $save = $this->db->insert($this->prefix . 'action', $data);
        }

        $data = array(

            'student_class_id' => $student_class_id,

            'branch_id' => $this->input->post('branch_id'),

            'class_id' => $class_id,

            'student_id' => $this->input->post('object_id'),

            'program_id' => $this->input->post('program_id'),

            'date_start' => $from_date,

            'date_end' => $to_date,

            'hour' => $this->input->post('hour') ? $this->input->post('hour') : 2 ,

            'status' => 1,

            'created_at' => date('Y-m-d H:i:s'),

            'updated_at' => date('Y-m-d H:i:s'),
        );

        $save = $this->db->insert($this->prefix . 'student_class', $data);
    }

    function save_action_add()
    {
        $invoice_id = 0;
        if ($this->input->post('action') == STUDENT_STATUS_0 || $this->input->post('action') == STUDENT_STATUS_5) { // Đăng ký mới || Đăng ký học tiếp

            $class_ids = $this->input->post('class_id');
            if (empty($class_ids)) return false;
            $program = $this->programm->get_item_by_id($this->input->post('program_id'));
            if (empty($program)) return false;

            foreach ($class_ids as $class_id) {
                $this->save_action_register($program, $class_id);
            }

            if ($this->input->post('paid_program_id')) { // dang ky chuong trinh da duoc dong hoc phi
                $data = array(
                    'deleted' => 1
                );

                $save = $this->db->update($this->prefix . 'action', $data, array(
                    'object_id' => $this->input->post('object_id'),
                    'branch_id' => $this->input->post('branch_id'),
                    'from' => $this->input->post('paid_program_id'),
                    'action' => STUDENT_STATUS_11
                ));
            }

            /* -- update schedule -- */
            $multi_student_class_data = $this->studentclassm->get_items_by_student_program_id($this->input->post('object_id'),$program['program_id']);
            if (empty($multi_student_class_data)) return false;

            // cap nhat gio cho tung lop
            $multi_student_class_id = array();
            foreach($multi_student_class_data->result() as $v) {
                $multi_student_class_id[] = $v->student_class_id;
            }

            // update start, end date
            updateScheduleClass($multi_student_class_id);

        } else if ($this->input->post('action') == STUDENT_STATUS_14) { // them buoi

                $class_id = $this->input->post('class_id');
                if (empty($class_id)) return false;

                $program = $this->programm->get_item_by_id($this->input->post('program_id'));
                if (empty($program)) return false;

                $this->save_action_register($program, $class_id);

                /*if ($this->input->post('paid_program_id')) { // dang ky chuong trinh da duoc dong hoc phi
                    $data = array(
                        'deleted' => 1
                    );

                    $save = $this->db->update($this->prefix . 'action', $data, array(
                        'object_id' => $this->input->post('object_id'),
                        'branch_id' => $this->input->post('branch_id'),
                        'from' => $this->input->post('paid_program_id'),
                        'action' => STUDENT_STATUS_11
                    ));
                }*/

                /* -- update schedule -- */
                $multi_student_class_data = $this->studentclassm->get_items_by_student_program_id($this->input->post('object_id'),$this->input->post('program_id'));
                if (empty($multi_student_class_data)) return false;

                // cap nhat gio cho tung lop
                $multi_student_class_id = array();
                foreach($multi_student_class_data->result() as $v) {
                    $multi_student_class_id[] = $v->student_class_id;
                }
                // update start, end date
                updateScheduleClass($multi_student_class_id);

            } else if ($this->input->post('action') == STUDENT_STATUS_1) { // Bảo lưu
            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            if (empty($student_class)) return false;
            $program = $this->programm->get_item_by_id($student_class['program_id']);
            if (empty($program)) return false;
            $class_hour = $this->classhourm->get_item_by_class_id($student_class['class_id']);
            if (empty($class_hour)) return false;

            $date_start = date('d/m/Y', strtotime(format_save_date($this->input->post('date_end')) . " +1 days"));
            $weekday = $class_hour['date_id'];//date('N', strtotime(($date_start)));
            $list_date = array($weekday);
            $total_hour = $program['total_time'];
            $list_date_off = array();
            $from_time = array($weekday => $class_hour['from_time']);
            $to_time = array($weekday => $class_hour['to_time']);
            $dateoff = $this->dateoffm->get_items();
            foreach ($dateoff->result() as $row) {
                $list_date_off[] = $row->date;
            }
            $date_total_time = array($weekday => $student_class['hour']);

            /*-- START tinh thoi gian --*/
            $data_to = array(
                'list_date' => $list_date,
                'date_start' => date('d/m/Y'),
                'date_end' => date('d/m/Y', strtotime($student_class['date_end'])),
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data_temp = excuteSchedule($data_to);

            if ($schedule_data_temp != null) {
                $total_hour = count($schedule_data_temp) * $student_class['hour'];
            }
            /*-- END tinh thoi gian --*/

            $data_to = array(
                'list_date' => $list_date,
                'date_start' => $date_start,
                'total_hour' => $total_hour,
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data = excuteExpireDate($data_to, false);

            $from_date = isset($schedule_data[0]['date'])?$schedule_data[0]['date']:"";
            $to_date = end($schedule_data);
            $to_date = $to_date['date'];

            $addition_day = strtotime(format_save_date($this->input->post('date_end'))) - strtotime(date('Y-m-d'));
            $data = array(

                'class_id' => $this->input->post('class_id'),

                'date_start' => $from_date,

                'date_end' => $to_date,

                'status' => 1, // bao luu

                'schedule' => json_encode($schedule_data),

                'updated_at' => date('Y-m-d H:i:s'),

            );
            $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $this->input->post('student_class_id')));

            $from = $this->input->post('student_class_id');
            $to = date('Y-m-d', strtotime(format_save_date($this->input->post('date_end'))));
        } else if ($this->input->post('action') == STUDENT_STATUS_2) { // Chuyển lớp
            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            if (empty($student_class)) return false;
            $class = $this->classm->get_item_by_id($this->input->post('class_id_to'));
            if (empty($class)) return false;
            $program = $this->programm->get_item_by_id($student_class['program_id']);
            if (empty($program)) return false;
            $class_hour = $this->classhourm->get_item_by_class_id($class['class_id']);
            if (empty($class_hour)) return false;

            $data = array(
                'status' => 3, // chuyen lop
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $this->input->post('student_class_id')));

            $date_start = date('d/m/Y');//date('d/m/Y', strtotime(($student_class['date_start'])));
            $weekday = $class_hour['date_id'];//date('N', strtotime(($date_start)));
            $list_date = array($weekday);
            $total_hour = $program['total_time'];
            $list_date_off = array();
            $from_time = array($weekday => $class_hour['from_time']);
            $to_time = array($weekday => $class_hour['to_time']);
            $dateoff = $this->dateoffm->get_items();
            foreach ($dateoff->result() as $row) {
                $list_date_off[] = $row->date;
            }
            $date_total_time = array($weekday => $student_class['hour']);

            /*-- START tinh thoi gian --*/
            $data_to = array(
                'list_date' => $list_date,
                'date_start' => date('d/m/Y'),
                'date_end' => date('d/m/Y', strtotime(($student_class['date_end']))),
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data_temp = excuteSchedule($data_to);
            if ($schedule_data_temp != null) {
                $total_hour = count($schedule_data_temp) * $student_class['hour'];
            }
            /*-- END tinh thoi gian --*/

            $data_to = array(
                'list_date' => $list_date,
                'date_start' => $date_start,
                'total_hour' => $total_hour,
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data = excuteExpireDate($data_to, false);
            $from_date = $schedule_data[0]['date'];
            $to_date = end($schedule_data);
            $to_date = $to_date['date'];

            $student_class_id = $this->uuid->v4();

            $from = $this->input->post('student_class_id');
            $to = $student_class_id;

            $data = array(

                'student_class_id' => $student_class_id,

                'branch_id' => $this->input->post('branch_id'),

                'class_id' => $this->input->post('class_id_to'),

                'student_id' => $this->input->post('object_id'),

                'program_id' => $student_class['program_id'],

                'date_start' => $from_date,

                'date_end' => $to_date,

                'hour' => $student_class['hour'],

                'status' => 1,

                'schedule' => json_encode($schedule_data),

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s'),

            );
            $save = $this->db->insert($this->prefix . 'student_class', $data);

            /* tao invoice */
            $extra_price = $this->input->post('extra_price', 0);
            if ($extra_price != 0)
            {
                $invoice_id = $this->uuid->v4();
                $invoice = array(
                    'invoice_id' => $invoice_id,
                    'invoice_code' => $this->input->post('invoice_code'),
                    'branch_id' => $this->input->post('branch_id'),
                    'student_id' => $this->input->post('object_id'),
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
                /* tao invoice */
            }

        } else if ($this->input->post('action') == STUDENT_STATUS_3) { // Lên lớp
            $from = $this->input->post('student_class_id');

            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            $student_multi_class = $this->studentclassm->get_items_by_student_program_id($student_class['student_id'], $student_class['program_id']);

            if ($this->input->post('up') && $this->input->post('up') == 1) {

                $to = date('Y-m-d', strtotime(format_save_date($this->input->post('date_end'))));

                foreach ($student_multi_class->result() as $row) {
                    if ($row->student_class_id == $this->input->post('student_class_id')) continue;

                    $data_multi = array(
                        'action_id' => $this->uuid->v4(),

                        'branch_id' => $this->input->post('branch_id'),

                        'object_id' => $this->input->post('object_id'),

                        'action' => $this->input->post('action'),

                        'from' => $row->student_class_id,

                        'to' => $to,

                        'note' => $this->input->post('note'),

                        'created_at' => date('Y-m-d H:i:s')

                    );
                    $save = $this->db->insert($this->prefix . 'action', $data_multi);

                    $data = array(
                        'status' => 4, // len lop
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $row->student_class_id));
                }

                $extra_hour = $this->input->post('extra_hour', 0);

                if($extra_hour > 0) {
                    $student_class_id_list = array();
                    foreach ($student_multi_class->result() as $row) {
                        $student_class_id_list[] = $row->student_class_id;
                        $start_date[$row->student_class_id] = "";
                        $end_date[$row->student_class_id] = "";
                    }

                    $schedule_data = excuteNextSchedule($student_class_id_list,$extra_hour);

                    foreach($schedule_data['data'] as $k => $v) {
                        // check start date
                        if (strtotime($start_date[$v['student_class_id']]) > strtotime($v['day'])) {
                            $start_date[$v['student_class_id']] = $v['day'];
                        }

                        if (strtotime($end_date[$v['student_class_id']]) < strtotime($v['day'])) {
                            $end_date[$v['student_class_id']] = $v['day'];
                        }
                    }

                    // update db
                    foreach($student_class_id_list as $value) {
                        if(isset($start_date[$value]) && $start_date[$value] != "" && isset($end_date[$value]) && $end_date[$value] !="") {
                            $this->db->update($this->prefix . 'student_class', array("date_start"=>$start_date[$value],"date_end"=>$end_date[$value],"updated_at"=>date('Y-m-d H:i:s')), array('student_class_id' => $value));
                        }
                    }

                    /* tao invoice */
                    $extra_price = $this->input->post('extra_price', 0);
                    if ($extra_price != 0) {
                        $invoice_id = $this->uuid->v4();
                        $invoice = array(
                            'invoice_id' => $invoice_id,
                            'invoice_code' => $this->input->post('invoice_code'),
                            'branch_id' => $this->session->userdata('branch'),
                            'student_id' => $student_class['student_id'],
                            'user_id' => $this->session->userdata('user'),
                            'event_id' => $this->input->post('event_id', null),
                            'sub_total' => $extra_price,
                            'extra_discount' => $this->input->post('extra_discount', 0),
                            'discount' => $this->input->post('discount', 0),
                            'surcharge' => $this->input->post('surcharge', 0),
                            'total' => $extra_price,
                            'type' => INVOICE_TYPE_5,
                            'note' => $this->input->post('note', null),
                            'other' => $this->input->post('other', null),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert($this->prefix . 'invoice', $invoice);
                    }
                    /* tao invoice */
                }
            }
        } else if ($this->input->post('action') == STUDENT_STATUS_4) { // Nghỉ học
            $from = date('Y-m-d', strtotime(format_save_date($this->input->post('date_start'))));
            $to = $this->input->post('student_class_id');
            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            $student_multi_class = $this->studentclassm->get_items_by_student_program_id($student_class['student_id'], $student_class['program_id']);
            foreach ($student_multi_class->result() as $row) {
                if ($row->student_class_id == $this->input->post('student_class_id')) continue;
                $data_multi = array(
                    'action_id' => $this->uuid->v4(),

                    'branch_id' => $this->input->post('branch_id'),

                    'object_id' => $this->input->post('object_id'),

                    'action' => $this->input->post('action'),

                    'from' => $from,

                    'to' => $row->student_class_id,

                    'note' => $this->input->post('note'),

                    'created_at' => date('Y-m-d H:i:s')

                );
                $save = $this->db->insert($this->prefix . 'action', $data_multi);

                // update student class
                $data = array(
                    'status' => 5, // nghi hoc
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $row->student_class_id));
            }

            $data = array(
                'status' => 5, // nghi hoc
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $this->input->post('student_class_id')));

            if ($this->input->post('hour') > 0 && $this->input->post('money') > 0) {
                $data = array(
                    'student_money_id' => $this->uuid->v4(),
                    'branch_id' => $this->input->post('branch_id'),
                    'student_id' => $this->input->post('object_id'),
                    'action' => $this->input->post('action'),
                    'program_id' => $student_class['program_id'],
                    'hour' => $this->input->post('hour'),
                    'money' => $this->input->post('money'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert($this->prefix . 'student_money', $data);
            }
        } else if ($this->input->post('action') == STUDENT_STATUS_6) { // Học tiếp
            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            if (empty($student_class)) return false;

            /* $past_action = $this->db->where('(`from` = "'.$this->input->post('student_class_id').'" OR `to` = "'.$this->input->post('student_class_id').'")')
                                     ->where('(`action` = "'.STUDENT_STATUS_1.'")')
                                     ->order_by('created_at DESC')
                                     ->limit(1,0)
                                     ->get($this->prefix.'action')->row();
             if(empty($past_action)) return false;*/

            $program = $this->programm->get_item_by_id($student_class['program_id']);
            if (empty($program)) return false;
            $class_hour = $this->classhourm->get_item_by_class_id($student_class['class_id']);
            if (empty($class_hour)) return false;

            $date_start = date('d/m/Y', strtotime(format_save_date($this->input->post('date_start'))));
            $weekday = $class_hour['date_id'];//date('N', strtotime(($date_start)));
            $list_date = array($weekday);
            $total_hour = $program['total_time'];
            $list_date_off = array();
            $from_time = array($weekday => $class_hour['from_time']);
            $to_time = array($weekday => $class_hour['to_time']);
            $dateoff = $this->dateoffm->get_items();
            foreach ($dateoff->result() as $row) {
                $list_date_off[] = $row->date;
            }
            $date_total_time = array($weekday => $student_class['hour']);

            /*-- START tinh thoi gian --*/
            $data_to = array(
                'list_date' => $list_date,
                'date_start' => date('d/m/Y'),
                'date_end' => date('d/m/Y', strtotime(($student_class['date_end']))),
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data_temp = excuteSchedule($data_to);
            if ($schedule_data_temp != null) {
                $total_hour = count($schedule_data_temp) * $student_class['hour'];
            }
            /*-- END tinh thoi gian --*/

            $data_to = array(
                'list_date' => $list_date,
                'date_start' => $date_start,
                'date_start' => $date_start,
                'total_hour' => $total_hour,
                'list_date_off' => $list_date_off,
                'date_total_time' => $date_total_time,
                'from_time' => $from_time,
                'to_time' => $to_time,
            );
            $schedule_data = excuteExpireDate($data_to, false);
            $from_date = $schedule_data[0]['date'];
            $to_date = end($schedule_data);
            $to_date = $to_date['date'];

            //$addition_day = strtotime(format_save_date($this->input->post('date_start'))) - strtotime(date('Y-m-d',strtotime($past_action->created_at)));
            $data = array(

                'class_id' => $this->input->post('class_id'),

                'date_start' => $from_date,

                'date_end' => $to_date,

                'status' => 1, // hoc

                'schedule' => json_encode($schedule_data),

                'updated_at' => date('Y-m-d H:i:s'),

            );
            $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $this->input->post('student_class_id')));

            $from = date('Y-m-d', strtotime(format_save_date($this->input->post('date_start'))));
            $to = $this->input->post('student_class_id');

        } else if ($this->input->post('action') == STUDENT_STATUS_12) { // chuyển giờ

            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            if (empty($student_class)) return false;

            $multi_student_class_data = $this->studentclassm->get_items_by_student_program_id($student_class['student_id'],$student_class['program_id']);
            if (empty($multi_student_class_data)) return false;

            // cap nhat gio cho tung lop
            foreach($multi_student_class_data->result() as $v) {
                $multi_student_class_id[] = $v->student_class_id;
                $data = array(
                    'hour' => $this->input->post('to_hour'),
                    'updated_at' => date('Y-m-d H:i:s'),

                );
                $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $v->student_class_id));
            }

            // update start, end date
            updateScheduleClass($multi_student_class_id);

            /* tao invoice */
            $extra_price = $this->input->post('extra_price', 0);
            if ($extra_price != 0)
            {
                $invoice_id = $this->uuid->v4();
                $invoice = array(
                    'invoice_id' => $invoice_id,
                    'invoice_code' => $this->input->post('invoice_code'),
                    'branch_id' => $this->input->post('branch_id'),
                    'student_id' =>  $this->input->post('object_id'),
                    'user_id' => $this->session->userdata('user'),
                    'event_id' => $this->input->post('event_id', null),
                    'sub_total' => $this->input->post('extra_price', 0),
                    'extra_discount' => $this->input->post('extra_discount', 0),
                    'discount' => $this->input->post('discount', 0),
                    'surcharge' => $this->input->post('surcharge', 0),
                    'total' => $this->input->post('extra_price', 0),
                    'type' => INVOICE_TYPE_7,
                    'note' => $this->input->post('note', null),
                    'other' => $this->input->post('other', null),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $this->db->insert($this->prefix . 'invoice', $invoice);

                $from = $this->input->post('from_hour');
                $to = $this->input->post('to_hour');

                /* tao invoice */
            }

            /*$from = $this->input->post('student_class_id');
            $to = '';
            $this->db->update($this->prefix . 'student_class', array('deleted' => 1), array('student_class_id' => $this->input->post('student_class_id')));*/

        } else if ($this->input->post('action') == STUDENT_STATUS_13) { // gia hạn

            $student_class = $this->studentclassm->get_item_by_id($this->input->post('student_class_id'));
            if (empty($student_class)) return false;

            $multi_student_class_data = $this->studentclassm->get_items_by_student_program_id($student_class['student_id'],$student_class['program_id']);
            if (empty($multi_student_class_data)) return false;

            $extra_days = $this->input->post('extra_days');

            // get list student class id
            foreach($multi_student_class_data->result() as $v) {
                $multi_student_class_id[] = $v->student_class_id;
            }
            $schedule_data = excuteMultiClassInProgram($multi_student_class_id,$extra_days);

            // cap nhat ngay bat dau va ket thuc cua tung lop
            if(isset($schedule_data['data'])) {
                foreach ($multi_student_class_data->result() as $v) {
                    $date_start[$v->student_class_id] = "";
                    $date_end[$v->student_class_id] = "";
                    foreach($schedule_data['data'] as $v1) {
                        if($v->student_class_id == $v1['student_class_id']) {
                            if($date_start[$v->student_class_id] =="" || $date_start[$v->student_class_id] > $v1['day_int']) {
                                $date_start[$v->student_class_id] = $v1['day_int'];
                            }

                            if($date_end[$v->student_class_id] =="" || $date_end[$v->student_class_id] < $v1['day_int']) {
                                $date_end[$v->student_class_id] = $v1['day_int'];
                            }
                        }
                    }
                }

                foreach ($multi_student_class_data->result() as $v) {
                    $data = array(
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    if(isset($date_start[$v->student_class_id]) && $date_start[$v->student_class_id] != "") {
                        $data['date_start'] = date("Y-m-d",$date_start[$v->student_class_id]);
                    }

                    if(isset($date_end[$v->student_class_id]) && $date_end[$v->student_class_id] != "") {
                        $data['date_end'] = date("Y-m-d",$date_end[$v->student_class_id]);
                    }


                    $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $v->student_class_id));
                }
            }

            $from = $student_class['program_id'];
            $to = $extra_days;

        } else if ($this->input->post('action') == STUDENT_STATUS_7) { // Xóa
            $from = $this->input->post('student_class_id');
            $to = '';
            $this->db->update($this->prefix . 'student_class', array('deleted' => 1), array('student_class_id' => $this->input->post('student_class_id')));
        }

        if(isset($from) && $from != "" && isset($to) && $to != "") {
            $data = array(
                'action_id' => $this->uuid->v4(),

                'branch_id' => $this->input->post('branch_id'),

                'object_id' => $this->input->post('object_id'),

                'action' => $this->input->post('action'),

                'from' => $from,

                'to' => $to,

                'note' => $this->input->post('note'),

                'created_at' => date('Y-m-d H:i:s')

            );
            $save = $this->db->insert($this->prefix . 'action', $data);

        }

        if (($this->input->post('action') == STUDENT_STATUS_0 || $this->input->post('action') == STUDENT_STATUS_5) &&
            $this->input->post('invoice')) {    
            /* Invoice */
            $this->invoicem->save_invoice_add();
        } else if (($this->input->post('action') == STUDENT_STATUS_2) && isset($extra_price) && $extra_price != 0) {
            echo json_encode(array(
                'id' => $invoice_id,
                'action' => $this->input->post('action')
            ));
        } else if ($this->input->post('action') == STUDENT_STATUS_3 || $this->input->post('action') == STUDENT_STATUS_12) {
            echo json_encode(array(
                'id' => $invoice_id,
                'action' => $this->input->post('action')
            ));
        } else if ($this->input->post('action') == STUDENT_STATUS_13) {
            echo json_encode(array(
                'action' => STUDENT_STATUS_13
            ));
        } else {
            echo json_encode(array(
                'action' => $this->input->post('action')
            ));
        }
    }


    function save_action_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'branch_id' => $this->input->post('branch_id'),

                'object_id' => $this->input->post('object_id'),

                'action' => $this->input->post('action'),

                'from' => $this->input->post('from'),

                'to' => $this->input->post('to'),

                'note' => $this->input->post('note'),

                'created_at' => $this->input->post('created_at'),

            );
            $save = $this->db->update($this->prefix . 'action', $data, array('action_id' => $id));
        }
    }


    function save_branch_change()
    {
        $data = array(

            'action_id' => $this->uuid->v4(),

            'branch_id' => $this->input->post('branch_id'),

            'object_id' => $this->input->post('object_id'),

            'action' => $this->input->post('action'),

            'from' => $this->input->post('branch_id'),

            'to' => $this->input->post('to_branch_id'),

            'note' => $this->input->post('note'),

            'created_at' => date('Y-m-d H:i:s'),

        );
        $this->db->insert($this->prefix . 'action', $data);

    }

    function save_transfer_friend()
    {

        $this->db->update($this->prefix . 'action', array('deleted' => 1), array('action' => $this->input->post('action'), 'branch_id' => $this->input->post('branch_id'), 'object_id' => $this->input->post('student_id'), 'from' => $this->input->post('student_money_id')));

        $data = array(

            'action_id' => $this->uuid->v4(),

            'branch_id' => $this->input->post('branch_id'),

            'object_id' => $this->input->post('student_id'),

            'action' => $this->input->post('action'),

            'from' => $this->input->post('student_money_id'),

            'to' => $this->input->post('to_student_id'),

            'note' => $this->input->post('note'),

            'created_at' => date('Y-m-d H:i:s'),

        );
        $this->db->insert($this->prefix . 'action', $data);
    }


    function load_action_add()
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
                    <div class="m-t-sm">Object:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="object_id" placeholder="object" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Thao tác:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="action" placeholder="thao tác" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Từ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="from" placeholder="từ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">đến:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="to" placeholder="đến" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ghi chú:</div>
                </div>
                <div class="col-md-8">
                    <textarea name="note" placeholder="ghi chú" class="form-control"></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tạo ngày:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="created_at" placeholder="tạo ngày" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_action_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }


    function load_action_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('action_id', $id)->where('deleted', 0)->get($this->prefix . 'action');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:branch;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->action_id ?>"/>
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
                                <option
                                    value="<?php echo $row->branch_id ?>" <?php if ($result->branch_id == $row->branch_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Object:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="object_id" value="<?php echo $result->object_id ?>"
                               placeholder="object" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Thao tác:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="action" value="<?php echo $result->action ?>" placeholder="thao tác"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Từ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="from" value="<?php echo $result->from ?>" placeholder="từ"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">đến:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="to" value="<?php echo $result->to ?>" placeholder="đến"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ghi chú:</div>
                    </div>
                    <div class="col-md-8">
                        <textarea name="note" placeholder="ghi chú"
                                  class="form-control"><?php echo $result->note ?></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tạo ngày:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="created_at" value="<?php echo $result->created_at ?>"
                               placeholder="tạo ngày" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_action_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
            <?php
        }
    }


}
