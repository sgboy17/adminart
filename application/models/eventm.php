<?php

class Eventm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix . 'event');
    }


    function get_item_by_id($id)
    {
        return $this->db->where('event_id', $id)->get($this->prefix . 'event')->row_array();
    }


    function get_name($id)
    {
        $result = $this->db->where('event_id', $id)->get($this->prefix . 'event')->row_array();
        if (!empty($result)) return $result['name'];
        else return '';
    }


    function get_event_list()
    {

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%' . $_GET['f_search'] . '%")');
        }

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }

        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix . 'event');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->event_id,

                'branch_id' => $row->branch_id,

                'name' => $row->name,

                'date_from' => $row->date_from,

                'date_end' => $row->date_end,

                'discount' => $row->discount,

                'discount_percent' => $row->discount_percent,

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
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                $this->branchm->get_name($row['branch_id']),

                $row['name'],

                format_get_date($row['date_from']),

                format_get_date($row['date_end']),

                $row['discount'] == "0"? $row['discount_percent']."%":$this->currencym->format_currency($row['discount']),
                
                // $row['created_at'],

                // $row['updated_at'],

                '<a style="margin-right: 5px;" href="#event_detail" data-toggle="modal" onclick="load_event_edit(\'' . $row['id'] . '\');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a><a href="javascript:;" onclick="delete_event(\'' . $row['id'] . '\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

    function delete_event()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'event', array('deleted' => 1), array('event_id' => $id));
                }
            }
        }
    }


    function save_event_add()
    {
        $data = array(

            'event_id' => $this->uuid->v4(),

            'branch_id' => $this->input->post('branch_id'),

            'name' => $this->input->post('name'),

            'date_from' => format_save_date($this->input->post('date_from')),

            'date_end' => format_save_date($this->input->post('date_end')),

            'discount' => $this->input->post('discount'),

            'discount_percent' => $this->input->post('discount_percent'),

            'created_at' => date('Y-m-d H:m:s'), //$this->input->post('created_at'),

            'updated_at' => date('Y-m-d H:m:s') //$this->input->post('updated_at'),

        );
        $save = $this->db->insert($this->prefix . 'event', $data);
    }


    function save_event_edit()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

                'branch_id' => $this->input->post('branch_id'),

                'name' => $this->input->post('name'),

                'date_from' => format_save_date($this->input->post('date_from')),

                'date_end' => format_save_date($this->input->post('date_end')),

                'discount' => $this->input->post('discount'),
                'discount_percent' => $this->input->post('discount_percent'),
//                'created_at' => $this->input->post('created_at'),

                'updated_at' => date('Y-m-d H:m:s') //$this->input->post('updated_at'),

            );
            $save = $this->db->update($this->prefix . 'event', $data, array('event_id' => $id));
        }
    }


    function load_event_add()
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
                    <div class="m-t-sm">Tên sự kiện:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="Tên sự kiện" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày bắt đầu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_from" placeholder="Ngày bắt đầu"
                           class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày kết thúc:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_end" placeholder="Ngày kết thúc"
                           class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Chiết khấu($):</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="discount" placeholder="Chiết khấu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Chiết khấu(%):</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="discount_percent" placeholder="Chiết khấu" class="form-control"></input>
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
            <p style="color: red;margin-left: 10px;"> * Chiết khấu $ sẽ được ưu tiên khi nhập cả 2 trường chiết khấu</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_event_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }


    function load_event_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('event_id', $id)->where('deleted', 0)->get($this->prefix . 'event');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:branch;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->event_id ?>"/>
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
                        <div class="m-t-sm">Tên sự kiện:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="Tên sự kiện"
                               class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày bắt đầu:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date_from" value="<?php echo format_get_date($result->date_from) ?>"
                               placeholder="Ngày bắt đầu" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ngày kết thúc:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="date_end" value="<?php echo format_get_date($result->date_end) ?>"
                               placeholder="Ngày kết thúc" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Chiết khấu($):</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="discount" value="<?php echo $result->discount ?>"
                               placeholder="Chiết khấu" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Chiết khấu(%):</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="discount_percent" value="<?php echo $result->discount_percent ?>" placeholder="Chiết khấu" class="form-control"></input>
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
                <br>
                <p style="color: red;margin-left: 10px;"> * Chiết khấu $ sẽ được ưu tiên khi nhập cả 2 trường chiết khấu</p>

            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_event_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
            <?php
        }
    }


}
