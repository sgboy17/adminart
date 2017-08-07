<?php

class Programm extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_items()
    {
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix . 'program');
    }


    function get_item_by_id($id)
    {
        return $this->db->where('program_id', $id)->get($this->prefix . 'program')->row_array();
    }


    function get_name($id)
    {
        $result = $this->db->where('program_id', $id)->get($this->prefix . 'program')->row_array();
        if (!empty($result)) return $result['name'];
        else return '';
    }

    function get_total_time($id)

    {

        $result = $this->db->where('program_id', $id)->get($this->prefix . 'program')->row_array();

        if (!empty($result)) return $result['total_time'];

        else return '';

    }


    function get_program_list()
    {

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%' . $_GET['f_search'] . '%")');
        }

        if (isset($_GET['f_certificate']) && !empty($_GET['f_certificate'])) {
            $this->db->where('certificate', $_GET['f_certificate']);
        }

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }


        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix . 'program');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach ($result_item->result() as $row) {
            $list[] = array(
                'id' => $row->program_id,

                'branch_id' => $row->branch_id,

                'parent_id' => $row->parent_id,

                //'next_program_id' => $row->next_program_id,

                'name' => $row->name,

                'program_code' => $row->program_code,

                'total_time' => $row->total_time,

                'order' => $row->order,

                'score' => $row->score,

                // 'certificate' => $row->certificate,

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
            //$certificate = ($row['certificate'] == 1) ? '<span class="text-success">Có</span>': '<span class="text-danger">Không</span>';
            $cate = array(
        '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                $this->branchm->get_name($row['branch_id']),

//                $this->get_name($row['parent_id']),

//                $this->get_name($row['next_program_id']),

                $row['name'],

                $row['program_code'],

                $row['total_time'],

//                $row['order'],

//                $row['score'],

                //$certificate,

//                $row['note'],

                $status,

                // $row['updated_at'],

                '<a style="margin-right: 5px;" href="#program_detail" data-toggle="modal" onclick="load_program_edit(\'' . $row['id'] . '\');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a><a href="javascript:;" onclick="delete_program(\'' . $row['id'] . '\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }


    function delete_program()
    {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $this->db->update($this->prefix . 'program', array('deleted' => 1), array('program_id' => $id));
                }
            }
        }
    }


    function save_program_add()
    {
        $program_id = $this->uuid->v4();

        $data = array(

            'program_id' => $program_id,

            'branch_id' => $this->input->post('branch_id'),

            'parent_id' => $this->input->post('parent_id'),

            //'next_program_id' => $this->input->post('next_program_id'),

            'name' => $this->input->post('name'),

            'program_code' => $this->input->post('program_code'),

            'total_time' => $this->input->post('total_time'),

            'order' => $this->input->post('order'),

            // 'score' => $this->input->post('score'),

            // 'certificate' => $this->input->post('certificate'),

            'note' => $this->input->post('note'),

            'status' => $this->input->post('status'),

            'price' => $this->input->post('price'),

            'created_at' => date('Y-m-d H:m:s'),

            'updated_at' => date('Y-m-d H:m:s'),

        );

        $save = $this->db->insert($this->prefix . 'program', $data);

        if ($save) {
            $product_id = $this->input->post('product_id');
            $data = array();
            foreach ($product_id as $row) {
                if (!empty($row)) {
                    $data[] = array(
                        'program_id' => $program_id,
                        'product_id' => $row
                    );
                }
            }

            if (!empty($data)) {
                $save = $this->db->insert_batch($this->prefix . 'program_product', $data);
            }
        }

    }


    function save_program_edit()
    {
        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $data = array(

                'branch_id' => $this->input->post('branch_id'),

                'parent_id' => $this->input->post('parent_id'),

                //'next_program_id' => $this->input->post('next_program_id'),

                'name' => $this->input->post('name'),

                'program_code' => $this->input->post('program_code'),

                'total_time' => $this->input->post('total_time'),

                'order' => $this->input->post('order'),

                // 'score' => $this->input->post('score'),

                // 'certificate' => $this->input->post('certificate'),

                'note' => $this->input->post('note'),

                'price' => $this->input->post('price'),

                'status' => $this->input->post('status'),

                // 'created_at' => $this->input->post('created_at'),

                'updated_at' => date('Y-m-d H:m:s') //$this->input->post('updated_at'),

            );

            $save = $this->db->update($this->prefix . 'program', $data, array('program_id' => $id));

            if ($save) {
                $product_id = $this->input->post('product_id');
                $data = array();
                foreach ($product_id as $row) {
                    if (!empty($row)) {
                        $data[] = array(
                            'program_id' => $id,
                            'product_id' => $row
                        );
                    }
                }

                if (!empty($data)) {
                    $this->db->delete($this->prefix . 'program_product', array('program_id' => $id));

                    $save = $this->db->insert_batch($this->prefix . 'program_product', $data);
                }
            }
        }
    }


    function load_program_add()
    {
        ?>
        <div class="modal-body">
            <div class="col-md-12">
                <h4>Thông tin cơ bản</h4>

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
                        <div class="m-t-sm">Chương trình cha:</div>
                    </div>
                    <div class="col-md-8">
                        <!--<input type="text" name="parent_id" placeholder="chương trình cha" class="form-control"></input>-->
                        <select class="form-control" name="parent_id">
                            <option value="">- Chương trình cha -</option>

                            <?php
                            $list = $this->get_items();
                            foreach ($list->result() as $row) { ?>
                                <option value="<?php echo $row->program_id ?>"><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên chương trình:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" placeholder="Tên chương trình" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Mã chương trình:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="program_code" placeholder="Mã chương trình" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Thời gian học:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="total_time" placeholder="Thời gian học" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Thứ tự:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="order" placeholder="Thứ tự" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- <div class="form-group m-t-sm">
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
                        <div class="m-t-sm">Trạng thái:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="">- Trạng thái -</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="clearfix m-b"></div>

        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_program_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }


    function load_program_edit()
    {
        $id = $this->input->post('id');
        $result = $this->db->where('program_id', $id)->where('deleted', 0)->get($this->prefix . 'program');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->program_id ?>"/>
            <div class="modal-body">
                <div class="col-md-12">
                    <h4>Thông tin cơ bản</h4>

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
                            <div class="m-t-sm">Chương trình cha:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="parent_id">
                                <option value="">- Chương trình cha -</option>

                                <?php
                                $list = $this->get_items();
                                foreach ($list->result() as $row) { ?>
                                    <option value="<?php echo $row->program_id ?>" <?php if ($result->parent_id == $row->program_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Tên chương trình:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="name" value="<?php echo $result->name ?>"
                                   placeholder="Tên chương trình" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã chương trình:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="program_code" value="<?php echo $result->program_code ?>"
                                   placeholder="Mã chương trình" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Thời gian học:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="total_time" value="<?php echo $result->total_time ?>"
                                   placeholder="Thời gian học" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Thứ tự:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="order" value="<?php echo $result->order ?>" placeholder="Thứ tự"
                                   class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Trạng thái:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="status">
                                <option value="">- Trạng thái -</option>
                                <option value="1" <?php if ($result->status == 1) echo 'selected=""'; ?>>Active</option>
                                <option value="2" <?php if ($result->status == 2) echo 'selected=""'; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>

            </div>

            <div class="clearfix m-b"></div>

            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_program_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
            <?php
        }
    }

    function get_program_product_list()
    {
        if (!isset($_GET['f_program_id']) || empty($_GET['f_program_id'])) {
            $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = 0;
            $data['aaData'] = array();
            echo json_encode($data);
            return;
        }
        
        $this->db->where('program_id', $_GET['f_program_id']);
                     
        ////////////////////////////////////
        $result_item = $this->db->order_by('program_product_id DESC')->get($this->prefix.'program_product');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->program_product_id,
        
                'program_id' => $row->program_id,
            
                'product_id' => $row->product_id,
            
            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $product = $this->productm->get_item_by_id($row['product_id']);
            if(empty($product)) continue;
            $cate = array(
                
                '<a href="javascript:void(0)" onclick="$(this).parent().parent().remove();"><span class="label label-danger"><i class="fa fa-times tooltips" data-html="true" data-original-title="Xoá"></i></span></a><input type="hidden" name="product_id[]" value="' . $product['product_id'] . '">',

                $product['code'],
            
                $product['name'],
            
                '<span class="price" data-price="'.$product['price_export'].'">'.$this->currencym->format_currency($product['price_export'], true).'</span>', 
            );

            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

}
