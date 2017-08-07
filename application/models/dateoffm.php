<?php

class Dateoffm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('date_off_id DESC')->where('deleted', 0)->get($this->prefix . 'date_off');
    }


    function get_item_by_id($id)
    {
        return $this->db->where('date_off_id', $id)->get($this->prefix . 'date_off')->row_array();
    }


    function get_date_off_list()
    {

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(`date` LIKE "%' . $_GET['f_search'] . '%")');
        }

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('date_off_id DESC')->get($this->prefix . 'date_off');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->date_off_id,

                'branch_id' => $row->branch_id,

                'date' => $row->date,

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
            $status = ($row['status'] == 1) ? '<span class="text-success">Active</span>': '<span class="text-danger">Inactive</span>';
            $cate = array(
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                $this->branchm->get_name($row['branch_id']),

                format_get_date($row['date']),

//                $row['note'],

                $status,

                // $row['created_at'],

                // $row['updated_at'],

                '<a style="margin-right: 5px;" href="#date_off_detail" data-toggle="modal" onclick="load_date_off_edit(\'' . $row['id'] . '\');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a><a href="javascript:;" onclick="delete_date_off(\'' . $row['id'] . '\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }


    function delete_date_off()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'date_off', array('deleted' => 1), array('date_off_id' => $id));
                }
            }
        }
    }


    function save_date_off_add()
    {
        $data = array(

            'date_off_id' => $this->uuid->v4(),

            'branch_id' => $this->input->post('branch_id'),

            'date' => format_save_date($this->input->post('date')),

            'note' => $this->input->post('note'),

            'status' => $this->input->post('status'),

            'created_at' => date('Y-m-d H:m:s'), //$this->input->post('created_at'),

            'updated_at' => date('Y-m-d H:m:s') //$this->input->post('updated_at'),

        );
        $save = $this->db->insert($this->prefix . 'date_off', $data);
    }


    function save_date_off_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'branch_id' => $this->input->post('branch_id'),

                'date' => format_save_date($this->input->post('date')),

                'note' => $this->input->post('note'),

                'status' => $this->input->post('status'),

//                'created_at' => $this->input->post('created_at'),

                'updated_at' => date('Y-m-d H:m:s'), //$this->input->post('updated_at'),

            );
            $save = $this->db->update($this->prefix . 'date_off', $data, array('date_off_id' => $id));
        }
    }


    function load_date_off_add()
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
                    <div class="m-t-sm">Ngày nghỉ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date" placeholder="Ngày nghỉ" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ghi chú:</div>
                </div>
                <div class="col-md-8">
                    <textarea name="note" placeholder="Ghi chú" class="form-control"></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tình trạng:</div>
                </div>
                <div class="col-md-8">
                    <!--<input type="text" name="status" placeholder="trạng thái" class="form-control"></input>-->
                    <select class="form-control" name="status">
                        <option value="">- Tình trạng -</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

            <!--<div class="form-group m-t-sm">
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
            <div class="clearfix"></div>-->

        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_date_off_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }


    function load_date_off_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('date_off_id', $id)->where('deleted', 0)->get($this->prefix . 'date_off');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:branch;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->date_off_id ?>"/>
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
                        <div class="m-t-sm">Ngày nghỉ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date" value="<?php echo format_get_date($result->date) ?>" placeholder="Ngày nghỉ"
                               class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ghi chú:</div>
                    </div>
                    <div class="col-md-8">
                        <textarea name="note" placeholder="Ghi chú"
                                  class="form-control"><?php echo $result->note ?></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tình trạng:</div>
                    </div>
                    <div class="col-md-8">
                        <!--<input type="text" name="status" value="<?php /*echo $result->status */?>" placeholder="trạng thái"
                               class="form-control"></input>-->
                        <select class="form-control" name="status">
                            <option value="">- Tình trạng -</option>
                            <option value="1" <?php if ($result->status == 1) echo 'selected=""'; ?>>Active</option>
                            <option value="2" <?php if ($result->status == 2) echo 'selected=""'; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!--<div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày tạo:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="created_at" value="<?php /*echo $result->created_at */?>"
                               placeholder="ngày tạo" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày sửa:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="updated_at" value="<?php /*echo $result->updated_at */?>"
                               placeholder="ngày sửa" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>-->

            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_date_off_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
            <?php
        }
    }


}
