<?php

class Centerfeem extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'center_fee');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('center_fee_id', $id)->get($this->prefix .'center_fee')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('center_fee_id', $id)->get($this->prefix .'center_fee')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_center_fee_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_center_id']) && !empty($_GET['f_center_id'])) {
            $this->db->where('center_id', $_GET['f_center_id']);
        }
                
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'center_fee');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->center_fee_id,
                
                'center_id' => $row->center_id,
            
                'name' => $row->name,
            
                'price' => $row->price,
            
                'type' => $row->type,
            
                'unit' => $row->unit,
            
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
                
                $row['center_id'],
            
                $row['name'],
            
                $row['price'],
            
                $row['type'],
            
                $row['unit'],
            
                $row['status'],
            
                $row['created_at'],
            
                $row['updated_at'],
            
                '<a href="#center_fee_detail" data-toggle="modal" onclick="load_center_fee_edit('.$row['id'].');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_center_fee('.$row['id'].');"><span class="fa fa-times text-danger"></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_center_fee() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'center_fee', array('deleted'=>1),array('center_fee_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_center_fee_add() {
        $data = array(
            
            'center_id' => $this->input->post('center_id'),
            
            'name' => $this->input->post('name'),
            
            'price' => $this->input->post('price'),
            
            'type' => $this->input->post('type'),
            
            'unit' => $this->input->post('unit'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
            );
        $save = $this->db->insert($this->prefix.'center_fee', $data);
    }
        
    
    
    function save_center_fee_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'center_id' => $this->input->post('center_id'),
            
            'name' => $this->input->post('name'),
            
            'price' => $this->input->post('price'),
            
            'type' => $this->input->post('type'),
            
            'unit' => $this->input->post('unit'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
                );
            $save = $this->db->update($this->prefix.'center_fee', $data, array('center_fee_id'=>$id));
        }
    }
        
    
    
    function load_center_fee_add(){
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
                    foreach($center_list->result() as $row){ ?>
                    <option value="<?php echo $row->center_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Chi phí:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="chi phí" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="price" placeholder="giá" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Loại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="type" placeholder="loại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">đơn vị:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="unit" placeholder="đơn vị" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_center_fee_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }
        
    
    
    function load_center_fee_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('center_fee_id', $id)->where('deleted', 0)->get($this->prefix.'center_fee');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->center_fee_id ?>" />
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
                    foreach($center_list->result() as $row){ ?>
                    <option value="<?php echo $row->center_id ?>" <?php if($result->center_id==$row->center_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Chi phí:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="chi phí" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="price" value="<?php echo $result->price ?>" placeholder="giá" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Loại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="type" value="<?php echo $result->type ?>" placeholder="loại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">đơn vị:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="unit" value="<?php echo $result->unit ?>" placeholder="đơn vị" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Trạng thái:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="status" value="<?php echo $result->status ?>" placeholder="trạng thái" class="form-control"></input>
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
                <a class="btn btn-success" onclick="save_center_fee_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
        <?php
        }
    }
        

}
