<?php

class Citym extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'city');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('city_id', $id)->get($this->prefix .'city')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('city_id', $id)->get($this->prefix .'city')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_city_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_country_id']) && !empty($_GET['f_country_id'])) {
            $this->db->where('country_id', $_GET['f_country_id']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'city');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->city_id,
        
                'country_id' => $row->country_id,
            
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
        
                $row['country_id'],
            
                $row['code'],
            
                $row['name'],
            
                '<a href="#city_detail" data-toggle="modal" onclick="load_city_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_city('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_city() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'city', array('deleted'=>1),array('city_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_city_add() {
        $data = array(
            
            'country_id' => $this->input->post('country_id'),
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
            );
        $save = $this->db->insert($this->prefix.'city', $data);
    }
        
    
    
    function save_city_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'country_id' => $this->input->post('country_id'),
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
                );
            $save = $this->db->update($this->prefix.'city', $data, array('city_id'=>$id));
        }
    }
        
    
    
    function load_city_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Quốc gia:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="country_id">
	                    <option value="">- quốc gia -</option>
	                    
                    <?php 
                    $country_list = $this->countrym->get_items();
                    foreach($country_list->result() as $row){ ?>
                    <option value="<?php echo $row->country_id ?>" ><?php echo $row->name ?></option>
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
            <a class="btn btn-success" onclick="save_city_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_city_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('city_id', $id)->where('deleted', 0)->get($this->prefix.'city');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->city_id ?>" />
            <div class="modal-body">
                
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Quốc gia:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="country_id">
	                    <option value="">- quốc gia -</option>
	                    	
                    <?php 
                    $country_list = $this->countrym->get_items();
                    foreach($country_list->result() as $row){ ?>
                    <option value="<?php echo $row->country_id ?>" <?php if($result->country_id==$row->country_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
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
                <a class="btn btn-success" onclick="save_city_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
