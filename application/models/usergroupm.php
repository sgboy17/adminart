<?php

class Usergroupm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'user_group');
    }
    

    
    function get_item_by_id($id){
        return $this->db->where('user_group_id', $id)->get($this->prefix .'user_group')->row_array();
    }
    

    
    function get_name($id){
        $result = $this->db->where('user_group_id', $id)->get($this->prefix .'user_group')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
    

    
    function get_user_group_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
        
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'user_group');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->user_group_id,
                
                'code' => $row->code,
                
                'name' => $row->name,
                
                'note' => $row->note,
                
                'status' => $row->status,
                
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
            
            $row['code'],
            
            $row['name'],
            
            $row['note'],
            
            $status,
            
            '<a href="#user_group_detail" data-toggle="modal" onclick="load_user_group_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
            <a href="javascript:void(0)" onclick="delete_user_group('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
            );
        $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
    
    
    
    function delete_user_group() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
            foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'user_group', array('deleted'=>1),array('user_group_id'=>$id));                 
                }
            }
        }
    }
    
    
    
    function save_user_group_add() {
        $data = array(
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),

            'deleted' => 0  ,
            
            );
        $save = $this->db->insert($this->prefix.'user_group', $data);
    }
    
    
    
    function save_user_group_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
                'code' => $this->input->post('code'),
                
                'name' => $this->input->post('name'),
                
                'note' => $this->input->post('note'),
                
                'status' => $this->input->post('status'),
                
                );
            $save = $this->db->update($this->prefix.'user_group', $data, array('user_group_id'=>$id));
        }
    }
    
    
    
    function load_user_group_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mã nhóm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="code" placeholder="mã nhóm" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên nhóm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="tên nhóm" class="form-control"></input>
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
                    <div class="m-t-sm">Tình trạng:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="status">
                        <option value="">- tình trạng -</option>
                        
                        <option value="1" >Active</option>
                        
                        <option value="2" >Inactive</option>
                        
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_user_group_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
    
    
    
    function load_user_group_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('user_group_id', $id)->where('deleted', 0)->get($this->prefix.'user_group');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->user_group_id ?>" />
            <div class="modal-body">
                
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Mã nhóm:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="code" value="<?php echo $result->code ?>" placeholder="mã nhóm" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên nhóm:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên nhóm" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ghi chú:</div>
                    </div>
                    <div class="col-md-8">
                        <textarea name="note" placeholder="ghi chú" class="form-control"><?php echo $result->note ?></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tình trạng:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="">- tình trạng -</option>
                            
                            <option value="1" <?php if($result->status==1) echo 'selected=""'; ?>>Active</option>
                            
                            <option value="2" <?php if($result->status==2) echo 'selected=""'; ?>>Inactive</option>
                            
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_user_group_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
            <?php
        }
    }
    

}
