<?php

class Districtm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'district');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('district_id', $id)->get($this->prefix .'district')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('district_id', $id)->get($this->prefix .'district')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_district_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_city_id']) && !empty($_GET['f_city_id'])) {
            $this->db->where('city_id', $_GET['f_city_id']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'district');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->district_id,
        
                'city_id' => $row->city_id,
            
                'code' => $row->code,
            
                'name' => $row->name,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
        
                $row['city_id'],
            
                $row['code'],
            
                $row['name'],
            
                '<a href="#district_detail" data-toggle="modal" onclick="load_district_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_district('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_district() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'district', array('deleted'=>1),array('district_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_district_add() {
        $data = array(
            
            'city_id' => $this->input->post('city_id'),
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
            );
        $save = $this->db->insert($this->prefix.'district', $data);
    }
        
    
    
    function save_district_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'city_id' => $this->input->post('city_id'),
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
                );
            $save = $this->db->update($this->prefix.'district', $data, array('district_id'=>$id));
        }
    }
        
    
    
    function load_district_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Thành phố:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="city_id">
	                    <option value="">- thành phố -</option>
	                    
                    <?php 
                    $city_list = $this->citym->get_items();
                    foreach($city_list->result() as $row){ ?>
                    <option value="<?php echo $row->city_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mã:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="code" placeholder="mã" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="tên" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_district_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_district_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('district_id', $id)->where('deleted', 0)->get($this->prefix.'district');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->district_id ?>" />
            <div class="modal-body">
                
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Thành phố:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="city_id">
	                    <option value="">- thành phố -</option>
	                    	
                    <?php 
                    $city_list = $this->citym->get_items();
                    foreach($city_list->result() as $row){ ?>
                    <option value="<?php echo $row->city_id ?>" <?php if($result->city_id==$row->city_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mã:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="code" value="<?php echo $result->code ?>" placeholder="mã" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_district_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
