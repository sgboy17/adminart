<?php

class Billincomem extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('code ASC')->where('deleted', 0)->get($this->prefix.'bill_income');
    }
        
    
    function get_items_by_order_id($order_id, $get_all = false, $method = 0){
        if(empty($order_id)) return false;
        if(!empty($method)) $this->db->where('method', $method);
        if(!$get_all) $this->db->where('deleted', 0);
        return $this->db->order_by('code ASC')->where('order_id', $order_id)->get($this->prefix .'bill_income');
    }
        
    
    function get_items_by_return_id($return_id, $get_all = false, $method = 0){
        if(empty($return_id)) return false;
        if(!empty($method)) $this->db->where('method', $method);
        if(!$get_all) $this->db->where('deleted', 0);
        return $this->db->order_by('code ASC')->where('return_id', $return_id)->get($this->prefix .'bill_income');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('bill_income_id', $id)->get($this->prefix .'bill_income')->row_array();
    }
        
    
    function get_item_by_order_id($order_id, $method = 0){
        if(empty($order_id)) return false;
        if(!empty($method)) $this->db->where('method', $method);
        return $this->db->where('order_id', $order_id)->get($this->prefix .'bill_income')->row_array();
    }
        
    
    function get_item_by_return_id($return_id, $method = 0){
        if(empty($return_id)) return false;
        if(!empty($method)) $this->db->where('method', $method);
        return $this->db->where('return_id', $return_id)->get($this->prefix .'bill_income')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('bill_income_id', $id)->get($this->prefix .'bill_income')->row_array();
        if(!empty($result)) return $result['code'];
        else return '';
    }
        

    
    function get_bill_income_list(){
        
        if(isset($_GET['f_type_search']) && $_GET['f_type_search']==0){ // Normal
            if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
                $this->db->where('(code LIKE "%'.$_GET['f_search'].'%")');
            }
            if (isset($_GET['f_range_date']) && !empty($_GET['f_range_date'])) {
                if($_GET['f_range_date']==1){ // Hôm nay
                    $from_date = date('Y-m-d 00:00:00');
                    $to_date = date('Y-m-d 23:59:59');
                }
                if($_GET['f_range_date']==2){ // Hôm qua
                    $from_date = date('Y-m-d 00:00:00', time()-3600*24);
                    $to_date = date('Y-m-d 23:59:59', time()-3600*24);
                }
                if($_GET['f_range_date']==3){ // Tháng này
                    $from_date = date('Y-m-01 00:00:00');
                    $to_date = date('Y-m-t 23:59:59');
                }
                if($_GET['f_range_date']==4){ // Tháng trước
                    $from_date = date('Y-m-01 00:00:00', time()-3600*24*date('t'));
                    $to_date = date('Y-m-t 23:59:59', time()-3600*24*date('t'));
                }
                if(isset($from_date)&&isset($to_date)){
                    $this->db->where('created_date >= "'.$from_date.'"');
                    $this->db->where('created_date <= "'.$to_date.'"');
                }
            }     
            if (isset($_GET['f_bill_type']) && !empty($_GET['f_bill_type'])) {
                if($_GET['f_bill_type']==1){ // Thu nội
                    $this->db->where('type', 6);
                }
                if($_GET['f_bill_type']==2){ // Thu ngoại
                    $this->db->where('type !=', 6);
                }
            }
            $this->db->where('branch_id', $this->session->userdata('branch'));
        }else{ // Advance
            if (isset($_GET['f_from_date']) && !empty($_GET['f_from_date'])) {
                $this->db->where('created_date >= "'.format_save_date($_GET['f_from_date']).' 00:00:00"');
            }
            if (isset($_GET['f_to_date']) && !empty($_GET['f_to_date'])) {
                $this->db->where('created_date <= "'.format_save_date($_GET['f_to_date']).' 23:59:59"');
            }

            if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
                $this->db->where('branch_id', $_GET['f_branch_id']);
            }
                    
            if (isset($_GET['f_employee_id']) && !empty($_GET['f_employee_id'])) {
                $this->db->where('employee_id', $_GET['f_employee_id']);
            }
                    
            if (isset($_GET['f_type']) && !empty($_GET['f_type'])) {
                $this->db->where('type', $_GET['f_type']);
            }
                    
            if (isset($_GET['f_customer_id']) && !empty($_GET['f_customer_id'])) {
                $this->db->where('customer_id', $_GET['f_customer_id']);
            }
        }
        
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('created_date DESC, bill_income_id DESC')->get($this->prefix.'bill_income');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        $total_income = 0;
        foreach($result_item->result() as $row){
            $total_income += $row->price;
            $list[] = array(
                
                'id' => $row->bill_income_id,
        
                'branch_id' => $row->branch_id,
            
                'code' => $row->code,
            
                'created_date' => $row->created_date,
            
                'employee_id' => $row->employee_id,
            
                'type' => $row->type,
            
                'method' => $row->method,
            
                'price' => $row->price,
            
                'commission_price' => $row->commission_price,
            
                'commission_percent' => $row->commission_percent,
            
                'customer_id' => $row->customer_id,
            
                'note' => $row->note,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $customer = $this->customerm->get_item_by_id($row['customer_id']);
            if(empty($customer)){
                $name = '-';
                $phone = '-';
                $address = '-';
            }else{
                $name = $customer['name'];
                if(!empty($customer['phone_2'])) $phone = $customer['phone_1'].' / '.$customer['phone_2'];
                else $phone = $customer['phone_1'];
                if(!empty($customer['address_1'])) $address = $customer['address_1'].', '.$this->districtm->get_name($customer['district_id']).', '.$this->citym->get_name($customer['city_id']);
                else if(!empty($customer['address_2'])) $address = $customer['address_2'].', '.$this->districtm->get_name($customer['district_id']).', '.$this->citym->get_name($customer['city_id']);
                else $address = $this->districtm->get_name($customer['district_id']).', '.$this->citym->get_name($customer['city_id']);
            }

            $total_price = $this->currencym->caculate_total_price($row['price'], $row['commission_price'], $row['commission_percent']);
            $total_commission = $this->currencym->caculate_total_commission($row['price'], $row['commission_price'], $row['commission_percent']);
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
        
                $row['code'],
            
                format_get_date($row['created_date']),

                $name,
            
                $row['note'],
               
            
                $this->currencym->format_currency($row['price']),
            
                '<a href="#bill_income_detail" data-toggle="modal" onclick="load_bill_income_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_bill_income('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        $data['aaData'][] = array('','','','','<b class="text-danger">Tổng cộng:</b>','<b class="text-danger">'.$this->currencym->format_currency($total_income).'</b>','');
        echo json_encode($data);
    } 
        
	
	
    function delete_bill_income() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'bill_income', array('deleted'=>1),array('bill_income_id'=>$id));  
                    // delete bill branch
                    $current_bill_branch = $this->billbranchm->get_item_by_bill_income_id($id);
                    if(!empty($current_bill_branch)){
                        $this->db->update($this->prefix.'bill_branch', array('deleted'=>1), array('bill_branch_id'=>$current_bill_branch['bill_branch_id']));        
                    }
                    // delete bill bank
                    $current_bill_bank = $this->billbankm->get_item_by_bill_income_id($id);
                    if(!empty($current_bill_bank)){
                        $this->db->update($this->prefix.'bill_bank', array('deleted'=>1), array('bill_bank_id'=>$current_bill_bank['bill_bank_id']));                        
                    }
                    
                }
           }
        }
    }
        
    
    
    function save_bill_income_add() {
        $created_date = format_save_date($this->input->post('created_date'));
        $from_bill = $this->input->post('from_bill');
        if(isset($from_bill)&&!empty($from_bill)){
            $_POST['branch_id'] = $this->session->userdata('branch');
            $_POST['code'] = $this->settingm->generate_code('pt', $this->session->userdata('branch'));
            // $_POST['price'] = $this->input->post('total_price')-$this->input->post('total_price')*$this->input->post('commission_percent')/100-$this->input->post('commission_price');
            $_POST['price'] = $this->input->post('total_price');
            $_POST['method'] = 1;
            $_POST['employee_id'] = 0;
            $_POST['type'] = 0;
            $_POST['commission_percent'] = 0;
        }
        $data = array(
            
            'branch_id' => $this->input->post('branch_id'),
            
            'code' => $this->input->post('code'),
            
            'created_date' => $created_date,
            
            'employee_id' => $this->input->post('employee_id'),
            
            'type' => $this->input->post('type'),
            
            'method' => $this->input->post('method'),
            
            'price' => $this->input->post('price'),
            
            'commission_price' => $this->input->post('commission_price'),
            
            'commission_percent' => $this->input->post('commission_percent'),
            
            'customer_id' => $this->input->post('customer_id'),
            
            'note' => $this->input->post('note'),
            
            );
        
        $order_id = $this->input->post('order_id');
        if(!empty($order_id)) $data['order_id'] = $order_id;
        $return_id = $this->input->post('return_id');
        if(!empty($return_id)) $data['return_id'] = $return_id;
        
        $save = $this->db->insert($this->prefix.'bill_income', $data);
        $id = $this->db->insert_id();

        if(isset($from_bill)&&!empty($from_bill)){
            $bill_branch_id = $this->billbranchm->create_bill_branch($_POST['branch_id'], $id, 0, $_POST['price']);
        }
        return $id;
    }
        
    
    
    function save_bill_income_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $created_date = format_save_date($this->input->post('created_date'));
            $from_bill = $this->input->post('from_bill');
            if(isset($from_bill)&&!empty($from_bill)){
                $current_bill_income = $this->billincomem->get_item_by_id($id);
                if(empty($current_bill_income)) return false;
                $_POST['branch_id'] = $current_bill_income['branch_id'];
                $_POST['price'] = $this->input->post('total_price')-$this->input->post('total_price')*$this->input->post('commission_percent')/100-$this->input->post('commission_price');
                $_POST['method'] = 1;
            }
            $data = array(
                
            'branch_id' => $this->input->post('branch_id'),
            
            'created_date' => $created_date,
            
            'employee_id' => $this->input->post('employee_id'),
            
            'type' => $this->input->post('type'),
            
            'method' => $this->input->post('method'),
            
            'price' => $this->input->post('price'),
            
            'commission_price' => $this->input->post('commission_price'),
            
            'commission_percent' => $this->input->post('commission_percent'),
            
            'customer_id' => $this->input->post('customer_id'),
            
            'note' => $this->input->post('note'),
            
                );
            $save = $this->db->update($this->prefix.'bill_income', $data, array('bill_income_id'=>$id));

            if(isset($from_bill)&&!empty($from_bill)){
                $bill_branch_id = $this->billbranchm->update_bill_branch($_POST['branch_id'], $id, 0, $_POST['price']);
            }
            return $id;
        }
    }
        
    
    
    function load_bill_income_add(){
        ?>  
        <input type="hidden" name="from_bill" id="from_bill" value="1" />
        <div class="modal-body">
            <h4>Thông tin phiếu thu</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã phiếu thu:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="code" readonly="" placeholder="Phát sinh tự động" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Ngày thu:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="created_date" value="<?php echo date('d/m/Y') ?>" placeholder="ngày thu" class="form-control datepicker"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Tổng thu:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="total_price" placeholder="tổng thu" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Khách hàng:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="customer_id">
                            <option value="">- khách hàng -</option>
                            <?php 
                                $customer_info = $this->customerm->get_items();
                                foreach($customer_info->result() as $row){?>
                                    <option value="<?php echo $row->customer_id ?>"><?php echo $row->name ?></option>
                                <?php } ?>
                            </select>
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
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_bill_income_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_bill_income_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('bill_income_id', $id)->where('deleted', 0)->get($this->prefix.'bill_income');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->bill_income_id ?>" />
            <input type="hidden" name="from_bill" id="from_bill" value="1" />
            <div class="modal-body">
                <h4>Thông tin phiếu thu</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Mã phiếu thu:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="code" value="<?php echo $result->code ?>" readonly="" placeholder="Phát sinh tự động" class="form-control"></input>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Ngày thu:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="created_date" value="<?php echo format_get_date($result->created_date) ?>" placeholder="ngày thu" class="form-control datepicker"></input>
                            </div>
                        </div>
                        <div class="clearfix">
                            
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Khách hàng:</div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="customer_id">
                                    <option value="">- khách hàng -</option>
                                    <?php 
                                    $customer_info = $this->customerm->get_items();
                                    foreach($customer_info->result() as $row){?>
                                    <option value="<?php echo $row->customer_id ?>" <?php if($result->customer_id==$row->customer_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                                
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Tổng thu:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="total_price" value="<?php $total_price = $this->currencym->caculate_total_price($result->price, $result->commission_price, $result->commission_percent); echo format_get_number($total_price); ?>" placeholder="tổng thu" class="form-control"></input>
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
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_bill_income_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
