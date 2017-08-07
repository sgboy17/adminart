<?php

class Messagem extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('message_id DESC')->where('deleted', 0)->get($this->prefix.'message');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('message_id', $id)->get($this->prefix .'message')->row_array();
    }
        

    

    
    function get_message_list(){
        
        if (isset($_GET['f_center_id']) && !empty($_GET['f_center_id'])) {
            $this->db->where('center_id', $_GET['f_center_id']);
        }
                
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('message_id DESC')->get($this->prefix.'message');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->message_id,
                
                'center_id' => $row->center_id,
            
                'title' => $row->title,
            
                'content' => $row->content,
            
                'date_start' => $row->date_start,
            
                'date_end' => $row->date_end,
            
                'user_id' => $row->user_id,
            
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
            
                $row['title'],
            
                $row['content'],
            
                $row['date_start'],
            
                $row['date_end'],
            
                $row['user_id'],
            
                $row['status'],
            
                $row['created_at'],
            
                $row['updated_at'],
            
                '<a href="#message_detail" data-toggle="modal" onclick="load_message_edit('.$row['id'].');"><span class="fa fa-edit"></span></a><a href="javascript:;" onclick="delete_message('.$row['id'].');"><span class="fa fa-times text-danger"></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_message() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'message', array('deleted'=>1),array('message_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_message_add() {
        $data = array(
            
            'center_id' => $this->input->post('center_id'),
            
            'title' => $this->input->post('title'),
            
            'content' => $this->input->post('content'),
            
            'date_start' => $this->input->post('date_start'),
            
            'date_end' => $this->input->post('date_end'),
            
            'user_id' => $this->input->post('user_id'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
            );
        $save = $this->db->insert($this->prefix.'message', $data);
    }
        
    
    
    function save_message_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'center_id' => $this->input->post('center_id'),
            
            'title' => $this->input->post('title'),
            
            'content' => $this->input->post('content'),
            
            'date_start' => $this->input->post('date_start'),
            
            'date_end' => $this->input->post('date_end'),
            
            'user_id' => $this->input->post('user_id'),
            
            'status' => $this->input->post('status'),
            
            'created_at' => $this->input->post('created_at'),
            
            'updated_at' => $this->input->post('updated_at'),
            
                );
            $save = $this->db->update($this->prefix.'message', $data, array('message_id'=>$id));
        }
    }
        
    
    
    function load_message_add(){
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
                    <div class="m-t-sm">Tiêu đề:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="title" placeholder="tiêu đề" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nội dung:</div>
                </div>
                <div class="col-md-8">
                	<textarea name="content" placeholder="nội dung" class="form-control"></textarea>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày bắt đầu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_start" placeholder="ngày bắt đầu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày kết thúc:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_end" placeholder="ngày kết thúc" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Người tạo:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="user_id" placeholder="người tạo" class="form-control"></input>
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
            <a class="btn btn-success" onclick="save_message_add($(this))">lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">huỷ</a>
        </div>
        <?php
    }
        
    
    
    function load_message_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('message_id', $id)->where('deleted', 0)->get($this->prefix.'message');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->message_id ?>" />
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
                    <div class="m-t-sm">Tiêu đề:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="title" value="<?php echo $result->title ?>" placeholder="tiêu đề" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nội dung:</div>
                </div>
                <div class="col-md-8">
                	<textarea name="content" placeholder="nội dung" class="form-control"><?php echo $result->content ?></textarea>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày bắt đầu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_start" value="<?php echo $result->date_start ?>" placeholder="ngày bắt đầu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Ngày kết thúc:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="date_end" value="<?php echo $result->date_end ?>" placeholder="ngày kết thúc" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Người tạo:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="user_id" value="<?php echo $result->user_id ?>" placeholder="người tạo" class="form-control"></input>
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
                <a class="btn btn-success" onclick="save_message_edit($(this))">lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">huỷ</a>
            </div>
        <?php
        }
    }
        

}
