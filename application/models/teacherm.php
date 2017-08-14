<?php

class Teacherm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix . 'teacher');
    }

    function get_active_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->where('status', 1)->get($this->prefix.'teacher');
    }


    function get_item_by_id($id)
    {
        return $this->db->where('teacher_id', $id)->get($this->prefix . 'teacher')->row_array();
    }


    function get_name($id)
    {
        $result = $this->db->where('teacher_id', $id)->get($this->prefix . 'teacher')->row_array();
        if (!empty($result)) return $result['name'];
        else return '';
    }


    function get_teacher_list()
    {

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%' . $_GET['f_search'] . '%")');
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('updated_at DESC')->get($this->prefix . 'teacher');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->teacher_id,

                'branch_id' => $row->branch_id,

                'name' => $row->name,

                'surname' => $row->surname,

                'sex' => $row->sex,

                'note' => $row->note,

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
            if ($row['status'] == 1) $status = '<span class="text-success">Active</span>';
            else $status = '<span class="text-danger">Inactive</span>';

            if ($row['sex'] == 1) $sex = '<i style="font-size: 20px;" class="fa fa-male fa-20 text-primary"></i>';
            else $sex = '<i style="font-size: 20px; color:red;" class="fa fa-female fa-20 text-primary"></i>';


            $cate = array(
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                 $this->branchm->get_name($row['branch_id']),

                $row['name'],

                $row['surname'],

                $sex,

                // $row['note'],

                $status,

                // $row['updated_at'],

                '<a style="margin-right: 5px;" href="#teacher_detail" data-toggle="modal" onclick="load_teacher_edit(\'' . $row['id'] . '\');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a><a href="javascript:;" onclick="delete_teacher(\'' . $row['id'] . '\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }


    function delete_teacher()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'teacher', array('deleted' => 1), array('teacher_id' => $id));
                }
            }
        }
    }


    function save_teacher_add()
    {
        $data = array(
            'teacher_id' => $this->uuid->v4(),

            'branch_id' => $this->input->post('branch_id'),

            'name' => $this->input->post('name'),

            'surname' => $this->input->post('surname'),

            'address' => $this->input->post('address'),

            'email' => $this->input->post('email'),

            'degree' => $this->input->post('degree'),

            'phone' => $this->input->post('phone'),

            'sex' => $this->input->post('sex'),

            'birthday' => format_save_date($this->input->post('birthday')),

            'school' => $this->input->post('school'),

            'note' => $this->input->post('note'),

            'status' => $this->input->post('status'),

            'created_at' => date("Y/m/d h:i:s"),

            'updated_at' => date("Y/m/d h:i:s"),
        );
        $save = $this->db->insert($this->prefix . 'teacher', $data);
    }


    function save_teacher_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                'branch_id' =>$this->input->post('branch_id'),
                'name' => $this->input->post('name'),

                'surname' => $this->input->post('surname'),

                'address' => $this->input->post('address'),

                'email' => $this->input->post('email'),

                'degree' => $this->input->post('degree'),

                'phone' => $this->input->post('phone'),

                'sex' => $this->input->post('sex'),

                'birthday' => format_save_date($this->input->post('birthday')),

                'school' => $this->input->post('school'),

                'note' => $this->input->post('note'),

                'status' => $this->input->post('status'),

                'updated_at' => date("Y/m/d h:i:s"),

            );
            $save = $this->db->update($this->prefix . 'teacher', $data, array('teacher_id' => $id));
        }
    }


    function load_teacher_add()
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
                    <div class="m-t-sm">Tên giáo viên:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="Tên giáo viên" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên hiển thị:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="surname" placeholder="Tên hiển thị" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Địa chỉ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="address" placeholder="Địa chỉ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Email:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="email" placeholder="Email" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Bằng cấp chuyên môn:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="degree" placeholder="Bằng cấp chuyên môn"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giới tính:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="sex">
                        <option value="">- Giới tính -</option>

                        <option value="1">Nam</option>

                        <option value="2">Nữ</option>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Số điện thoại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="phone" placeholder="Số điện thoại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày sinh:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="birthday" value="" placeholder="Ngày sinh" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Đơn vị công tác:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="school" placeholder="Đơn vị công tác" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

           <!--  <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ghi chú:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="note" placeholder="Ghi chú" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div> -->

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tình trạng:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="status">
                        <option value="">- Tình trạng -</option>

                        <option value="1">Active</option>

                        <option value="2">Inactive</option>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_teacher_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }


    function load_teacher_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('teacher_id', $id)->where('deleted', 0)->get($this->prefix . 'teacher');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->teacher_id ?>"/>
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
                        <div class="m-t-sm">Tên giáo viên:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="Tên giáo viên"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên hiển thị:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="surname" value="<?php echo $result->surname ?>"
                               placeholder="Tên hiển thị" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Địa chỉ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="address" value="<?php echo $result->address ?>" placeholder="Địa chỉ"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Email:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="email" value="<?php echo $result->email ?>" placeholder="Email"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Bằng cấp chuyên môn:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="degree" value="<?php echo $result->degree ?>" placeholder="Bằng cấp chuyên môn"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Số điện thoại:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="phone" value="<?php echo $result->phone ?>" placeholder="Số điện thoại"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Giới tính:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="sex">
                            <option value="">- Giới tính -</option>

                            <option value="1" <?php if ($result->sex == 1) echo 'selected=""'; ?>>Nam</option>

                            <option value="2" <?php if ($result->sex == 2) echo 'selected=""'; ?>>Nữ</option>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày sinh:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="birthday" value="<?php echo (format_get_date($result->birthday)) ?>"
                               placeholder="Ngày sinh" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Đơn vị công tác:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="school" value="<?php echo $result->school ?>" placeholder="Đơn vị công tác"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ghi chú:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="note" value="<?php echo $result->note ?>" placeholder="Ghi chú"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tình trạng:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="">- Tình trạng -</option>

                            <option value="1" <?php if ($result->status == 1) echo 'selected=""'; ?>>Active</option>

                            <option value="2" <?php if ($result->status == 2) echo 'selected=""'; ?>>Inactive</option>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_teacher_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
            <?php
        }
    }


}
