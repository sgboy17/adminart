<?php

class Emailm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    function sendEmailAutomatic($emails, $subject,$content, $from = null, $mailType = 'html'){
        /*
         * Send mail
         */
        /*$config = array(
                'protocol' => MAIL_PROTOCOL,
                'smtp_host' => MAIL_HOST,
                'smtp_port' => MAIL_PORT,
                'smtp_user' => MAIL_USER,
                'smtp_pass' => MAIL_PASS,
                'mailtype'  => 'html', 
                'charset'   => 'utf-8',
                'starttls'  => true,
                'newline'   => "\r\n"
        );
        $this->email->initialize($config);
        try {
            $this->email->clear();
            $this->email->to($emails);
            
            if($from == NULL)
            {
                $this->email->from(MAIL_FROM);
            }
            else
            {
                $this->email->from($from);
            }
            $this->email->subject($subject);
            $this->email->message($content);
            $this->email->send();
        }catch (Exception $e){
            //Do nothing
            echo $this->email->print_debugger();
            die;
        }*/
    } 

    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'email');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('email_id', $id)->get($this->prefix .'email')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('email_id', $id)->get($this->prefix .'email')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_email_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
            $this->db->where('status', $_GET['f_status']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'email');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->email_id,
        
                'name' => $row->name,
            
                'title' => $row->title,
            
                'content' => $row->content,
            
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
        
                $row['name'],
            
                $row['title'],
            
                get_readmore(strip_tags($row['content']), 40),
            
                $row['note'],
            
                $status,
            
                '<a href="#email_detail" data-toggle="modal" onclick="load_email_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_email('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_email() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'email', array('deleted'=>1),array('email_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_email_add() {
        $data = array(
            
            'name' => $this->input->post('name'),
            
            'title' => $this->input->post('title'),
            
            'content' => $this->input->post('content'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
            );
        $save = $this->db->insert($this->prefix.'email', $data);
    }
        
    
    
    function save_email_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'name' => $this->input->post('name'),
            
            'title' => $this->input->post('title'),
            
            'content' => $this->input->post('content'),
            
            'note' => $this->input->post('note'),
            
            'status' => $this->input->post('status'),
            
                );
            $save = $this->db->update($this->prefix.'email', $data, array('email_id'=>$id));
        }
    }
        
    
    
    function load_email_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên mẫu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="tên mẫu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tiêu đề email:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="title" placeholder="tiêu đề email" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nội dung email:</div>
                </div>
                <div class="col-md-8">
                    <div id="summernote"></div>
                	<textarea name="content" style="display:none;" placeholder="nội dung email" class="form-control"></textarea>
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
            <a class="btn btn-success" onclick="save_email_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_email_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('email_id', $id)->where('deleted', 0)->get($this->prefix.'email');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->email_id ?>" />
            <div class="modal-body">
                
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên mẫu:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên mẫu" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tiêu đề email:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="title" value="<?php echo $result->title ?>" placeholder="tiêu đề email" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nội dung email:</div>
                </div>
                <div class="col-md-8">
                    <div id="summernote"><?php echo $result->content ?></div>
                	<textarea name="content" style="display:none;" placeholder="nội dung email" class="form-control"><?php echo $result->content ?></textarea>
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
                <a class="btn btn-success" onclick="save_email_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
