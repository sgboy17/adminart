<?php

class Roomm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    function get_items(){
        return $this->db->order_by('name ASC')->where('branch_id', $this->session->userdata('branch'))->where('deleted', 0)->get($this->prefix.'room');
    }

    function get_active_items(){
        return $this->db->order_by('name ASC')->where('branch_id', $this->session->userdata('branch'))->where('deleted', 0)->where('status', 1)->get($this->prefix.'room');
    }


    function get_item_by_id($id){
        return $this->db->where('room_id', $id)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix .'room')->row_array();
    }

    
    function get_name($id){
        $result = $this->db->where('room_id', $id)->where('branch_id', $this->session->userdata('branch'))->get($this->prefix .'room')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
    
    function get_room_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->where('branch_id', $this->session->userdata('branch'))->order_by('updated_at DESC')->get($this->prefix.'room');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->room_id,
            
                'name' => $row->name,
            
                'note' => $row->note,
            
                'status' => $row->status,
            
                'created_at' => $row->created_at,
            
                'updated_at' => $row->updated_at,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

            if($row['status']==1) $status = '<span class="text-success">Active</span>';
            else $status = '<span class="text-danger">Inactive</span>';

            $cate = array(

                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                $row['name'],
            
                $row['note'],

                $status,
            
                $row['created_at'],
            
                $row['updated_at'],


                '<a style="margin-right: 5px;" href="#room_detail" data-toggle="modal" onclick="load_room_edit(\''.$row['id'].'\');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a><a href="javascript:;" onclick="delete_room(\''.$row['id'].'\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

    function delete_room() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'room', array('deleted'=>1),array('room_id'=>$id, 'branch_id' => $this->session->userdata('branch')));                 
                }
           }
        }
    }

    
    function save_room_add() {
        $data = array(
            'room_id' => $this->uuid->v4(),

            'branch_id' => $this->session->userdata('branch'),
            
            'name' => $this->input->post('name'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => date("Y/m/d h:i:s"),
            
            'updated_at' => date("Y/m/d h:i:s"),
            
            );
        $save = $this->db->insert($this->prefix.'room', $data);
    }
        
    
    
    function save_room_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(

            'room_id' => $this->uuid->v4(),
            
            'name' => $this->input->post('name'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
            'updated_at' => date("Y/m/d h:i:s"),
            
            );
            $save = $this->db->update($this->prefix.'room', $data, array('room_id'=>$id, 'branch_id' => $this->session->userdata('branch')));
        }
    }
        
    function load_room_add(){
        ?>  
        <div class="modal-body">

            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên phòng:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="Tên phòng" class="form-control"></input>
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
                    <select class="form-control" name="status">
                        <option value="">- Tình trạng -</option>

                        <option value="1" >Active</option>

                        <option value="2" >Inactive</option>

                    </select>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_room_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
        <?php
    }
        
    
    
    function load_room_edit() {
        $id = $this->input->post('id');

        $result = $this->db->where('room_id', $id)->where('branch_id',$this->session->userdata('branch'))->where('deleted', 0)->get($this->prefix.'room');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->room_id ?>" />
            <div class="modal-body">
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên phòng:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="Tên phòng" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ghi chú:</div>
                </div>
                <div class="col-md-8">
                	<textarea name="note" placeholder="Ghi chú" class="form-control"><?php echo $result->note ?></textarea>
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

                            <option value="1" <?php if($result->status==1) echo 'selected=""'; ?>>Active</option>

                            <option value="2" <?php if($result->status==2) echo 'selected=""'; ?>>Inactive</option>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
            	
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_room_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
        <?php
        }
    }
        

}
