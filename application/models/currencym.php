<?php

class Currencym extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'currency');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('currency_id', $id)->get($this->prefix .'currency')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('currency_id', $id)->get($this->prefix .'currency')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_currency_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_position']) && !empty($_GET['f_position'])) {
            $this->db->where('position', $_GET['f_position']);
        }
                
        if (isset($_GET['f_is_base']) && !empty($_GET['f_is_base'])) {
            $this->db->where('is_base', $_GET['f_is_base']);
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'currency');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->currency_id,
        
                'code' => $row->code,
            
                'name' => $row->name,
            
                'value' => $row->value,
            
                'position' => $row->position,
            
                'is_base' => $row->is_base,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
        
                $row['code'],
            
                $row['name'],
            
                $row['value'],
            
                $row['position'],
            
                $row['is_base'],
            
                '<a href="#currency_detail" data-toggle="modal" onclick="load_currency_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_currency('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_currency() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'currency', array('deleted'=>1),array('currency_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_currency_add() {
        $data = array(
            
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
            'value' => $this->input->post('value'),
            
            'position' => $this->input->post('position'),
            
            'is_base' => $this->input->post('is_base'),
            
            );
        $save = $this->db->insert($this->prefix.'currency', $data);
    }
        
    
    
    function save_currency_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'code' => $this->input->post('code'),
            
            'name' => $this->input->post('name'),
            
            'value' => $this->input->post('value'),
            
            'position' => $this->input->post('position'),
            
            'is_base' => $this->input->post('is_base'),
            
                );
            $save = $this->db->update($this->prefix.'currency', $data, array('currency_id'=>$id));
        }
    }
        
    
    
    function load_currency_add(){
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mã tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="code" placeholder="mã tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" placeholder="tên tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá trị tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="value" placeholder="giá trị tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Vị trí biểu tượng:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="position">
	                    <option value="">- vị trí biểu tượng -</option>
	                    
            		<option value="1" >biểu tượng bên trái</option>
            
            		<option value="2" >biểu tượng bên phải</option>
            
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tiền tệ mặc định:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="is_base">
	                    <option value="">- tiền tệ mặc định -</option>
	                    
            		<option value="0" >không là chuẩn</option>
            
            		<option value="1" >lấy làm chuẩn</option>
            
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_currency_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_currency_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('currency_id', $id)->where('deleted', 0)->get($this->prefix.'currency');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->currency_id ?>" />
            <div class="modal-body">
                
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mã tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="code" value="<?php echo $result->code ?>" placeholder="mã tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Giá trị tiền tệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="value" value="<?php echo $result->value ?>" placeholder="giá trị tiền tệ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            	
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Vị trí biểu tượng:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="position">
	                    <option value="">- vị trí biểu tượng -</option>
	                    
            		<option value="1" <?php if($result->position==1) echo 'selected=""'; ?>>biểu tượng bên trái</option>
            
            		<option value="2" <?php if($result->position==2) echo 'selected=""'; ?>>biểu tượng bên phải</option>
            
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tiền tệ mặc định:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="is_base">
	                    <option value="">- tiền tệ mặc định -</option>
	                    
            		<option value="0" <?php if($result->is_base==0) echo 'selected=""'; ?>>không là chuẩn</option>
            
            		<option value="1" <?php if($result->is_base==1) echo 'selected=""'; ?>>lấy làm chuẩn</option>
            
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_currency_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        
    function format_currency($price, $html = false){
        $is_base = $this->db->where('is_base', 1)->where('deleted', 0)->get($this->prefix.'currency')->row();
        if(!empty($is_base)){
            $value = $price*$is_base->value;
            $value = rtrim(rtrim(number_format($value,2),'0'),'.');
            if($is_base->position==1) return $html?'<span class="currency_code">'.$is_base->code.'</span><span class="currency_value">'.$value.'</span>':$is_base->code.$value;
            else  return $html?'<span class="currency_value">'.$value.'</span><span class="currency_code">'.$is_base->code.'</span>':$value.$is_base->code;
        }else{
            return number_format($price,0);
        }
    }
        
    function caculate_total_price($final_price, $commission_price, $commission_percent, $tax_percent = 0){
        if($commission_percent==100) return $final_price;
        else return (($final_price)/(1+$tax_percent/100)+$commission_price)/(1-$commission_percent/100);
    }
        
    function caculate_total_commission($final_price, $commission_price, $commission_percent, $tax_percent = 0){
        if($commission_percent==100) return $final_price;
        else return (($final_price)/(1+$tax_percent/100)+$commission_price)/(1-$commission_percent/100)*$commission_percent/100+$commission_price;
    }
}
