<?php

class Classhourm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('class_hour_id DESC')->where('deleted', 0)->get($this->prefix . 'class_hour');
    }

    function get_items_by_class_id($id)
    {
        return $this->db->where('class_id', $id)->where('deleted', 0)->get($this->prefix . 'class_hour');
    }

    function get_hour_and_room_name_by_class_id($class_id) {
        return $this->db->select('ch.*, r.name as room_name')
        ->from($this->prefix . 'class_hour ch')
        ->join($this->prefix . 'room r', 'r.room_id = ch.room_id')
        ->where('class_id', $class_id)
        ->where('ch.deleted', 0)
        ->get();
    }
    function get_item_by_id($id)
    {
        return $this->db->where('class_hour_id', $id)->get($this->prefix . 'class_hour')->row_array();
    }

    function get_item_by_class_id($id)
    {
        return $this->db->where('class_id', $id)->get($this->prefix . 'class_hour')->row_array();
    }

    function get_item_by_class_id_and_date($id,$date_id)
    {
        return $this->db->where('class_id', $id)
            ->where('date_id', $date_id)
            ->where('deleted', 0)
            ->get($this->prefix . 'class_hour')->row();
    }

    function get_id_by_code($code = '', $date_id)
    {
        $row = $this->db
            ->select('ch.class_hour_id, ch.class_id')
            ->from($this->prefix . 'class_hour ch')
            ->where('c.branch_id', $this->session->userdata('branch'))
            ->where('c.class_code', $code)
            ->where('ch.date_id', $date_id)
            ->where('ch.deleted', 0)
            ->get()
            ->row();

        return $row;
    }

    function get_class_hour_list()
    {

        if (isset($_GET['f_room_id']) && !empty($_GET['f_room_id'])) {
            $this->db->where('room_id', $_GET['f_room_id']);
        }

        if (isset($_GET['f_class_id']) && !empty($_GET['f_class_id'])) {
            $this->db->where('class_id', $_GET['f_class_id']);
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('class_hour_id DESC')->get($this->prefix . 'class_hour');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->class_hour_id,

                'room_id' => $row->room_id,

                'class_id' => $row->class_id,

                'from_time' => $row->from_time,

                'to_time' => $row->to_time,

                'date_id' => $row->date_id,

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
            if (!($i >= $_GET['iDisplayStart'] && $i < $_GET['iDisplayStart'] + $_GET['iDisplayLength'])) continue;
            $cate = array(

                $row['room_id'],

                $row['class_id'],

                $row['from_time'],

                $row['to_time'],

                $row['date_id'],

                $row['status'],

                $row['created_at'],

                $row['updated_at'],

                '<a href="#class_hour_detail" data-toggle="modal" onclick="load_class_hour_edit(' . $row['id'] . ');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_class_hour(' . $row['id'] . ');"><span class="fa fa-times text-danger"></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }


    function delete_class_hour()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'class_hour', array('deleted' => 1), array('class_hour_id' => $id));
                }
            }
        }
    }


    function save_class_hour_add()
    {
        $data = array(

            'room_id' => $this->input->post('room_id'),

            'class_id' => $this->input->post('class_id'),

            'from_time' => $this->input->post('from_time'),

            'to_time' => $this->input->post('to_time'),

            'date_id' => $this->input->post('date_id'),

            'status' => $this->input->post('status'),

            'created_at' => $this->input->post('created_at'),

            'updated_at' => $this->input->post('updated_at'),

        );
        $save = $this->db->insert($this->prefix . 'class_hour', $data);
    }


    function save_class_hour_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'room_id' => $this->input->post('room_id'),

                'class_id' => $this->input->post('class_id'),

                'from_time' => $this->input->post('from_time'),

                'to_time' => $this->input->post('to_time'),

                'date_id' => $this->input->post('date_id'),

                'status' => $this->input->post('status'),

                'created_at' => $this->input->post('created_at'),

                'updated_at' => $this->input->post('updated_at'),

            );
            $save = $this->db->update($this->prefix . 'class_hour', $data, array('class_hour_id' => $id));
        }
    }


    function load_class_hour_add()
    {
        ?>
        <div class="modal-body">

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Phòng học:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="room_id">
                        <option value="">- Phòng học -</option>

                        <?php
                        $room_list = $this->roomm->get_items();
                        foreach ($room_list->result() as $row) { ?>
                            <option value="<?php echo $row->room_id ?>"><?php echo $row->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Lớp học:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="class_id">
                        <option value="">- Lớp học -</option>

                        <?php
                        $class_list = $this->classm->get_items();
                        foreach ($class_list->result() as $row) { ?>
                            <option value="<?php echo $row->class_id ?>"><?php echo $row->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Thời gian từ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="from_time" placeholder="thời gian từ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Thời gian đến:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="to_time" placeholder="thời gian đến" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_id" placeholder="ngày" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_class_hour_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }


    function load_class_hour_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('class_hour_id', $id)->where('deleted', 0)->get($this->prefix . 'class_hour');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->class_hour_id ?>"/>
            <div class="modal-body">

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Phòng học:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="room_id">
                            <option value="">- Phòng học -</option>

                            <?php
                            $room_list = $this->roomm->get_items();
                            foreach ($room_list->result() as $row) { ?>
                                <option
                                    value="<?php echo $row->room_id ?>" <?php if ($result->room_id == $row->room_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Lớp học:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="class_id">
                            <option value="">- Lớp học -</option>

                            <?php
                            $class_list = $this->classm->get_items();
                            foreach ($class_list->result() as $row) { ?>
                                <option
                                    value="<?php echo $row->class_id ?>" <?php if ($result->class_id == $row->class_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Thời gian từ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="from_time" value="<?php echo $result->from_time ?>"
                               placeholder="thời gian từ" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Thời gian đến:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="to_time" value="<?php echo $result->to_time ?>"
                               placeholder="thời gian đến" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date_id" value="<?php echo $result->date_id ?>" placeholder="ngày"
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
                <a class="btn btn-success" onclick="save_class_hour_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
            <?php
        }
    }


}
