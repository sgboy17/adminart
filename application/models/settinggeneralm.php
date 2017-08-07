<?php

class Settinggeneralm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('setting_general_id DESC')->where('deleted', 0)->get($this->prefix.'setting_general');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('setting_general_id', $id)->get($this->prefix .'setting_general')->row_array();
    }
        

    

    
    function get_setting_general_list(){
        
        if (isset($_GET['f_center_id']) && !empty($_GET['f_center_id'])) {
            $this->db->where('center_id', $_GET['f_center_id']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('setting_general_id DESC')->get($this->prefix.'setting_general');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->setting_general_id,
                
                'center_id' => $row->center_id,
            
                'type' => $row->type,
            
                'value' => $row->value,
            
                'text' => $row->text,
            
                'default' => $row->default,
            
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
            
                $row['type'],
            
                $row['value'],
            
                $row['text'],
            
                $row['default'],
            
                $row['created_at'],
            
                $row['updated_at'],
            
                '<a href="#setting_general_detail" data-toggle="modal" onclick="load_setting_general_edit('.$row['id'].');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_setting_general('.$row['id'].');"><span class="fa fa-times text-danger"></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_setting_general() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'setting_general', array('deleted'=>1),array('setting_general_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_setting_general_add() {
        $data = array(
            
            'center_id' => $this->input->post('center_id'),
            
            'type' => $this->input->post('type'),
            
            'value' => $this->input->post('value'),
            
            'text' => $this->input->post('text'),
            
            'default' => $this->input->post('default'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
            );
        $save = $this->db->insert($this->prefix.'setting_general', $data);
    }
        
    
    
    function save_setting_general_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'center_id' => $this->input->post('center_id'),
            
            'type' => $this->input->post('type'),
            
            'value' => $this->input->post('value'),
            
            'text' => $this->input->post('text'),
            
            'default' => $this->input->post('default'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
                );
            $save = $this->db->update($this->prefix.'setting_general', $data, array('setting_general_id'=>$id));
        }
    }
        
    
    
    function load_setting_general_add(){
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
                    <div class="m-t-sm">Loại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="type" placeholder="loại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá trị:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="value" placeholder="giá trị" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Text:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="text" placeholder="text" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mặc định:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="default" placeholder="mặc định" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_setting_general_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }
        
    
    
    function load_setting_general_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('setting_general_id', $id)->where('deleted', 0)->get($this->prefix.'setting_general');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->setting_general_id ?>" />
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
                    <div class="m-t-sm">Loại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="type" value="<?php echo $result->type ?>" placeholder="loại" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá trị:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="value" value="<?php echo $result->value ?>" placeholder="giá trị" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Text:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="text" value="<?php echo $result->text ?>" placeholder="text" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mặc định:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="default" value="<?php echo $result->default ?>" placeholder="mặc định" class="form-control"></input>
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
                <a class="btn btn-success" onclick="save_setting_general_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
        <?php
        }
    }
        

}
