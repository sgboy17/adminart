<?php

class Centerm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'center');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('center_id', $id)->get($this->prefix .'center')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('center_id', $id)->get($this->prefix .'center')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_center_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'center');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->center_id,
                
                'name' => $row->name,
            
                'address' => $row->address,
            
                'phone' => $row->phone,
            
                'email' => $row->email,
            
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
            $cate = array(
                
                $row['name'],
            
                $row['address'],
            
                $row['phone'],
            
                $row['email'],
            
                $row['note'],
            
                $row['status'],
            
                $row['created_at'],
            
                $row['updated_at'],
            
                '<a href="#center_detail" data-toggle="modal" onclick="load_center_edit('.$row['id'].');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_center('.$row['id'].');"><span class="fa fa-times text-danger"></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_center() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'center', array('deleted'=>1),array('center_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_center_add() {
        $data = array(
            
            'name' => $this->input->post('name'),
            
            'address' => $this->input->post('address'),
            
            'phone' => $this->input->post('phone'),
            
            'email' => $this->input->post('email'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
            );
        $save = $this->db->insert($this->prefix.'center', $data);
    }
        
    
    
    function save_center_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'name' => $this->input->post('name'),
            
            'address' => $this->input->post('address'),
            
            'phone' => $this->input->post('phone'),
            
            'email' => $this->input->post('email'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
                );
            $save = $this->db->update($this->prefix.'center', $data, array('center_id'=>$id));
        }
    }
        
    
    
    function load_center_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="tên trung tâm" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">địa chỉ trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="address" placeholder="địa chỉ trung tâm" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Số điện thoại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="phone" placeholder="số điện thoại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Email:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="email" placeholder="email" class="form-control"></input>
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
                    <input type="text" name="status" placeholder="tình trạng" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_center_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }
        
    
    
    function load_center_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('center_id', $id)->where('deleted', 0)->get($this->prefix.'center');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->center_id ?>" />
            <div class="modal-body">
                
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên trung tâm" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">địa chỉ trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="address" value="<?php echo $result->address ?>" placeholder="địa chỉ trung tâm" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Số điện thoại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="phone" value="<?php echo $result->phone ?>" placeholder="số điện thoại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Email:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="email" value="<?php echo $result->email ?>" placeholder="email" class="form-control"></input>
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
                    <input type="text" name="status" value="<?php echo $result->status ?>" placeholder="tình trạng" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày tạo:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="created_at" value="<?php echo $result->created_at ?>" placeholder="ngày tạo" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày sửa:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="updated_at" value="<?php echo $result->updated_at ?>" placeholder="ngày sửa" class="form-control datepicker"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_center_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
        <?php
        }
    }
        

}
