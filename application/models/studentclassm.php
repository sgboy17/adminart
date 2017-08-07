<?php

class Studentclassm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_items()
    {
        return $this->db->order_by('student_class_id DESC')->where('deleted', 0)->where('status', 1)->get($this->prefix . 'student_class');
    }

    function get_items_by_student_program_id($student_id, $program_id)
    {
        return $this->db->order_by('student_class_id DESC')->where('student_id', $student_id)->where('program_id', $program_id)->where('status', 1)->where('deleted', 0)->get($this->prefix . 'student_class');
    }

    function get_item_by_id($id)
    {
        return $this->db->where('student_class_id', $id)->get($this->prefix . 'student_class')->row_array();
    }

    function get_item_by_student_class($student_id, $class_id)
    {
        return $this->db->where('student_id', $student_id)
                ->where('class_id', $class_id)
                ->where('branch_id', $this->session->userdata('branch'))
                ->where('deleted', 0)
                ->where('status', 1)
                ->get($this->prefix . 'student_class')
                ->row_array();
    }

    function get_items_by_student_id($id)
    {
        return $this->db->where('student_id', $id)->where('deleted', 0)->where('status', 1)->get($this->prefix . 'student_class');
    }

    function get_earliest_start_date($class_id, $student_class_id = null)
    {

        if($student_class_id != null && $student_class_id != "") {

            $student_class_data = $this->db->where('student_class_id', $student_class_id)->where('date_start is NOT NULL', NULL, FALSE)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix . 'student_class')->row_array();
            if(isset($student_class_data["date_start"])) {
                return $student_class_data["date_start"];
            } else {
                return null;
            }

        } else {

            $student_class_data = $this->db->order_by('date_start', "ASC")->where('class_id', $class_id)->where('date_start is NOT NULL', NULL, FALSE)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix . 'student_class')->row_array();
            if(isset($student_class_data["date_start"])) {
                return $student_class_data["date_start"];
            } else {
                return null;
            }

        }

    }

    function updateStudentClass($student_class_id,$data) {
        $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $student_class_id));
    }

    function get_lastest_end_date($class_id, $student_class_id = null)
    {

        if($student_class_id != null && $student_class_id != "") {

            $student_class_data = $this->db->where('student_class_id', $student_class_id)->where('date_end is NOT NULL', NULL, FALSE)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix . 'student_class')->row_array();

            if(isset($student_class_data["date_end"])) {
                return $student_class_data["date_end"];
            } else {
                return null;
            }

        } else {

            $student_class_data = $this->db->order_by('date_end', "DESC")->where('class_id', $class_id)->where('date_end is NOT NULL', NULL, FALSE)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix . 'student_class')->row_array();
            if(isset($student_class_data["date_end"])) {
                return $student_class_data["date_end"];
            } else {
                return null;
            }

        }

    }


    function get_item_by_student_id($student_id)
    {
        $sql = 'SELECT sc.*, c.class_code FROM ' . $this->prefix . 'student_class as sc INNER JOIN ' . $this->prefix . 'class as c ON c.class_id = sc.class_id WHERE sc.deleted = 0 AND sc.status = 1 AND sc.student_id = ? order by created_at DESC';
        return $this->db->query($sql, array($student_id));
        /*return $this->db->select('sc.*, c.name as class_name')
                        ->from($this->prefix .'student_class as sc')
                        ->join($this->prefix .'class as c', 'c.class_id = sc.class_id')
                        ->where('sc.deleted', 0)
                        ->where('student_id', $student_id);*/
    }


    function get_items_by_student_id_for_list($student_id)
    {
        $sql = 'SELECT sc.*, sc.status as status, c.class_code FROM ' . $this->prefix . 'student_class as sc INNER JOIN ' . $this->prefix . 'class as c ON c.class_id = sc.class_id WHERE sc.deleted = 0 AND (sc.status = 1 OR sc.status = 5 OR sc.status = 2) AND sc.student_id = ? group by sc.student_class_id  order by sc.created_at DESC';
        return $this->db->query($sql, array($student_id));
        /*return $this->db->select('sc.*, c.name as class_name')
                        ->from($this->prefix .'student_class as sc')
                        ->join($this->prefix .'class as c', 'c.class_id = sc.class_id')
                        ->where('sc.deleted', 0)
                        ->where('student_id', $student_id);*/
    }

    function get_student_class_list()
    {

        if (isset($_GET['f_center_id']) && !empty($_GET['f_center_id'])) {
            $this->db->where('center_id', $_GET['f_center_id']);
        }

        if (isset($_GET['f_class_id']) && !empty($_GET['f_class_id'])) {
            $this->db->where('class_id', $_GET['f_class_id']);
        }

        if (isset($_GET['f_student_id']) && !empty($_GET['f_student_id'])) {
            $this->db->where('student_id', $_GET['f_student_id']);
        }

        if (isset($_GET['f_program_id']) && !empty($_GET['f_program_id'])) {
            $this->db->where('program_id', $_GET['f_program_id']);
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('student_class_id DESC')->get($this->prefix . 'student_class');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->student_class_id,

                'center_id' => $row->center_id,

                'class_id' => $row->class_id,

                'student_id' => $row->student_id,

                'program_id' => $row->program_id,

                'date_start' => $row->date_start,

                'date_end' => $row->date_end,

                'hour' => $row->hour,

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

                $row['center_id'],

                $row['class_id'],

                $row['student_id'],

                $row['program_id'],

                $row['date_start'],

                $row['date_end'],

                $row['hour'],

                $row['status'],

                $row['created_at'],

                $row['updated_at'],

                '<a href="#student_class_detail" data-toggle="modal" onclick="load_student_class_edit(' . $row['id'] . ');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_student_class(' . $row['id'] . ');"><span class="fa fa-times text-danger"></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }


    function delete_student_class()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'student_class', array('deleted' => 1), array('student_class_id' => $id));
                }
            }
        }
    }


    function save_student_class_add()
    {
        $data = array(

            'center_id' => $this->input->post('center_id'),

            'class_id' => $this->input->post('class_id'),

            'student_id' => $this->input->post('student_id'),

            'program_id' => $this->input->post('program_id'),

            'date_start' => $this->input->post('date_start'),

            'date_end' => $this->input->post('date_end'),

            'hour' => $this->input->post('hour'),

            'status' => $this->input->post('status'),

            'created_at' => $this->input->post('created_at'),

            'updated_at' => $this->input->post('updated_at'),

        );
        $save = $this->db->insert($this->prefix . 'student_class', $data);
    }


    function save_student_class_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'center_id' => $this->input->post('center_id'),

                'class_id' => $this->input->post('class_id'),

                'student_id' => $this->input->post('student_id'),

                'program_id' => $this->input->post('program_id'),

                'date_start' => $this->input->post('date_start'),

                'date_end' => $this->input->post('date_end'),

                'hour' => $this->input->post('hour'),

                'status' => $this->input->post('status'),

                'created_at' => $this->input->post('created_at'),

                'updated_at' => $this->input->post('updated_at'),

            );
            $save = $this->db->update($this->prefix . 'student_class', $data, array('student_class_id' => $id));
        }
    }


    function load_student_class_add()
    {
        ?>
        <div class="modal-body">

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="center_id">
                        <option value="">- Trung tâm -</option>

                        <?php
                        $center_list = $this->centerm->get_items();
                        foreach ($center_list->result() as $row) { ?>
                            <option value="<?php echo $row->center_id ?>"><?php echo $row->name ?></option>
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
                    <div class="m-t-sm">Chương trình:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="program_id">
                        <option value="">- Chương trình -</option>

                        <?php
                        $program_list = $this->programm->get_items();
                        foreach ($program_list->result() as $row) { ?>
                            <option value="<?php echo $row->program_id ?>"><?php echo $row->name ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày bắt đầu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_start" placeholder="ngày bắt đầu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày kết thúc:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_end" placeholder="ngày kết thúc" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giờ đã học:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="hour" placeholder="giờ đã học" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_student_class_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }


    function load_student_class_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('student_class_id', $id)->where('deleted', 0)->get($this->prefix . 'student_class');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->student_class_id ?>"/>
            <div class="modal-body">

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Trung tâm:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="center_id">
                            <option value="">- Trung tâm -</option>

                            <?php
                            $center_list = $this->centerm->get_items();
                            foreach ($center_list->result() as $row) { ?>
                                <option
                                    value="<?php echo $row->center_id ?>" <?php if ($result->center_id == $row->center_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
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
                        <div class="m-t-sm">Học viên:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="student_id">
                            <option value="">- Học viên -</option>

                            <?php
                            $student_list = $this->studentm->get_items();
                            foreach ($student_list->result() as $row) { ?>
                                <option
                                    value="<?php echo $row->student_id ?>" <?php if ($result->student_id == $row->student_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Chương trình:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="program_id">
                            <option value="">- Chương trình -</option>

                            <?php
                            $program_list = $this->programm->get_items();
                            foreach ($program_list->result() as $row) { ?>
                                <option
                                    value="<?php echo $row->program_id ?>" <?php if ($result->program_id == $row->program_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày bắt đầu:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date_start" value="<?php echo $result->date_start ?>"
                               placeholder="ngày bắt đầu" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày kết thúc:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date_end" value="<?php echo $result->date_end ?>"
                               placeholder="ngày kết thúc" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Giờ đã học:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="hour" value="<?php echo $result->hour ?>" placeholder="giờ đã học"
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
                <a class="btn btn-success" onclick="save_student_class_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
            <?php
        }
    }


}
