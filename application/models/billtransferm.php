<?php

class Billtransferm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('code ASC')->where('deleted', 0)->get($this->prefix.'bill_transfer');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('bill_transfer_id', $id)->get($this->prefix .'bill_transfer')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('bill_transfer_id', $id)->get($this->prefix .'bill_transfer')->row_array();
        if(!empty($result)) return $result['code'];
        else return '';
    }
        

    
    function get_bill_transfer_list(){
        
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
        }else{ // Advance
            if (isset($_GET['f_from_date']) && !empty($_GET['f_from_date'])) {
                $this->db->where('created_date >= "'.format_save_date($_GET['f_from_date']).' 00:00:00"');
            }
            if (isset($_GET['f_to_date']) && !empty($_GET['f_to_date'])) {
                $this->db->where('created_date <= "'.format_save_date($_GET['f_to_date']).' 23:59:59"');
            }

            if (isset($_GET['f_branch_id_income']) && !empty($_GET['f_branch_id_income'])) {
                $this->db->where('branch_id_income', $_GET['f_branch_id_income']);
            }
                    
            if (isset($_GET['f_branch_id_outcome']) && !empty($_GET['f_branch_id_outcome'])) {
                $this->db->where('branch_id_outcome', $_GET['f_branch_id_outcome']);
            }
                    
            if (isset($_GET['f_employee_id']) && !empty($_GET['f_employee_id'])) {
                $this->db->where('employee_id', $_GET['f_employee_id']);
            }
                    
            if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
                $this->db->where('status', $_GET['f_status']);
            }
        }
        
       
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('created_date DESC, bill_transfer_id DESC')->get($this->prefix.'bill_transfer');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->bill_transfer_id,
        
                'code' => $row->code,
            
                'branch_id_income' => $row->branch_id_income,
            
                'branch_id_outcome' => $row->branch_id_outcome,
            
                'created_date' => $row->created_date,
            
                'price' => $row->price,
            
                'employee_id' => $row->employee_id,
            
                'note' => $row->note,
            
                'status' => $row->status,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            if($row['status']==-1) $status = '<span class="text-danger">Không duyệt</span>';
            else if($row['status']==0) $status = '<span class="text-warning">Chờ duyệt</span>';
            else $status = '<span class="text-success">Đã duyệt</span>';
            $branch_income = $this->branchm->get_name($row['branch_id_income']);
            $branch_outcome = $this->branchm->get_name($row['branch_id_outcome']);
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
        
                $row['code'],
            
                format_get_date($row['created_date']),
            
                $branch_income,
            
                $branch_outcome,
            
                $this->currencym->format_currency($row['price']),
            
                $status,
            
                '<a href="#bill_transfer_detail" data-toggle="modal" onclick="load_bill_transfer_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_bill_transfer('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

    function change_status_bill_transfer($bill_transfer_id, $status){
        $current_bill_transfer = $this->billtransferm->get_item_by_id($bill_transfer_id);
        if(empty($current_bill_transfer)) return false;
        // Income
        $this->db->update($this->prefix.'bill_income', array('deleted'=>!$status), array('bill_income_id'=>$current_bill_transfer['bill_income_id']));
        $current_bill_branch = $this->billbranchm->get_item_by_bill_income_id($current_bill_transfer['bill_income_id']);
        if(empty($current_bill_branch)) return false;
        $this->db->update($this->prefix.'bill_branch', array('deleted'=>!$status), array('bill_branch_id'=>$current_bill_branch['bill_branch_id']));

        // Outcome
        $this->db->update($this->prefix.'bill_outcome', array('deleted'=>!$status), array('bill_outcome_id'=>$current_bill_transfer['bill_outcome_id']));
        $current_bill_branch = $this->billbranchm->get_item_by_bill_outcome_id($current_bill_transfer['bill_outcome_id']);
        if(empty($current_bill_branch)) return false;
        $this->db->update($this->prefix.'bill_branch', array('deleted'=>!$status), array('bill_branch_id'=>$current_bill_branch['bill_branch_id']));
    }    
	
    function delete_bill_transfer() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'bill_transfer', array('deleted'=>1),array('bill_transfer_id'=>$id)); 
                    $this->billtransferm->change_status_bill_transfer($id, 0);
                }
           }
        }
    }
        
           
    function approve_bill_transfer() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'bill_transfer', array('status'=>1),array('bill_transfer_id'=>$id)); 
                    $this->billtransferm->change_status_bill_transfer($id, 1);
                }
           }
        }
    }   
    
    function unapprove_bill_transfer() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'bill_transfer', array('status'=>-1),array('bill_transfer_id'=>$id)); 
                    $this->billtransferm->change_status_bill_transfer($id, 0);
                }
           }
        }
    }
    
    function save_bill_transfer_add() {
        $created_date = $this->input->post('created_date');
        $price = $this->input->post('price');
        //$employee_id = $this->input->post('employee_id');
        $employee_id = '0';
        $data = array(
            'code' => $this->settingm->generate_code('pct', $this->session->userdata('branch')),
            'branch_id_income' => $this->input->post('branch_id_income'),
            'branch_id_outcome' => $this->input->post('branch_id_outcome'),
            'created_date' => format_save_date($created_date),
            'price' => $price,
            'employee_id' => $employee_id,
            'note' => $this->input->post('note'),
            'status' => 0,
            );

        // Income
        $_POST['branch_id'] = $this->input->post('branch_id_income');
        $_POST['code'] = $this->settingm->generate_code('pt', $this->input->post('branch_id_income'));
        $_POST['created_date'] = $created_date;
        $_POST['employee_id'] = $employee_id;
        $_POST['type'] = 6;
        $_POST['method'] = 1;
        $_POST['price'] = $price;
        $_POST['commission_price'] = 0;
        $_POST['commission_percent'] = 0;
        $_POST['customer_id'] = 0;
        $_POST['note'] = 'Thu chuyển tiền nội bộ';
        $data['bill_income_id'] = $this->billincomem->save_bill_income_add();

        $bill_branch_id = $this->billbranchm->create_bill_branch($_POST['branch_id'], $data['bill_income_id'], 0, $_POST['price']);

        // Outcome
        $_POST['branch_id'] = $this->input->post('branch_id_outcome');
        $_POST['code'] = $this->settingm->generate_code('pc', $this->input->post('branch_id_outcome'));
        $_POST['created_date'] = $created_date;
        $_POST['employee_id'] = $employee_id;
        $_POST['type'] = 6;
        $_POST['method'] = 1;
        $_POST['price'] = $price;
        $_POST['commission_price'] = 0;
        $_POST['commission_percent'] = 0;
        $_POST['supplier_id'] = 0;
        $_POST['note'] = 'Chi chuyển tiền nội bộ';
        $data['bill_outcome_id'] = $this->billoutcomem->save_bill_outcome_add();
        $bill_branch_id = $this->billbranchm->create_bill_branch($_POST['branch_id'], 0, $data['bill_outcome_id'], $_POST['price']);

        $save = $this->db->insert($this->prefix.'bill_transfer', $data);
        $bill_transfer_id = $this->db->insert_id();
        $this->billtransferm->change_status_bill_transfer($bill_transfer_id, 0);

        return $bill_transfer_id;
    }
        
    
    
    function save_bill_transfer_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $created_date = $this->input->post('created_date');
            $price = $this->input->post('price');
            $employee_id = $this->input->post('employee_id');
            $data = array(
                'branch_id_income' => $this->input->post('branch_id_income'),
                'branch_id_outcome' => $this->input->post('branch_id_outcome'),
                'created_date' => format_save_date($created_date),
                'price' => $price,
                'employee_id' => $employee_id,
                'note' => $this->input->post('note'),
                'status' => 0,
                );
            $current_bill_transfer = $this->billtransferm->get_item_by_id($id);
            if(empty($current_bill_transfer)) return false;

            // Income
            $_POST['id'] = $current_bill_transfer['bill_income_id'];
            $_POST['branch_id'] = $this->input->post('branch_id_income');
            $_POST['created_date'] = $created_date;
            $_POST['employee_id'] = $employee_id;
            $_POST['type'] = 6;
            $_POST['method'] = 1;
            $_POST['price'] = $price;
            $_POST['commission_price'] = 0;
            $_POST['commission_percent'] = 0;
            $_POST['customer_id'] = 0;
            $_POST['note'] = 'Thu chuyển tiền nội bộ';
            $data['bill_income_id'] = $this->billincomem->save_bill_income_edit();
            $bill_branch_id = $this->billbranchm->update_bill_branch($_POST['branch_id'], $data['bill_income_id'], 0, $_POST['price']);

            // Outcome
            $_POST['id'] = $current_bill_transfer['bill_outcome_id'];
            $_POST['branch_id'] = $this->input->post('branch_id_outcome');
            $_POST['created_date'] = $created_date;
            $_POST['employee_id'] = $employee_id;
            $_POST['type'] = 6;
            $_POST['method'] = 1;
            $_POST['price'] = $price;
            $_POST['commission_price'] = 0;
            $_POST['commission_percent'] = 0;
            $_POST['supplier_id'] = 0;
            $_POST['note'] = 'Chi chuyển tiền nội bộ';
            $data['bill_outcome_id'] = $this->billoutcomem->save_bill_outcome_edit();
            $bill_branch_id = $this->billbranchm->update_bill_branch($_POST['branch_id'], 0, $data['bill_outcome_id'], $_POST['price']);

            $save = $this->db->update($this->prefix.'bill_transfer', $data, array('bill_transfer_id'=>$id));
            $bill_transfer_id = $id;
            $this->billtransferm->change_status_bill_transfer($bill_transfer_id, 0);
            return $bill_transfer_id;
        }
    }
        
    
    
    function load_bill_transfer_add(){
        ?>  
        <div class="modal-body">
            <h4>Thông tin phiếu chuyển tiền</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã phiếu:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="code" readonly="" placeholder="Phát sinh tự động" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Ngày chuyển:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="created_date" placeholder="ngày chuyển" value="<?php echo date('d/m/Y') ?>" class="form-control datepicker"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Chi nhánh chi:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="branch_id_outcome">
                                <option value="">- chi nhánh chi -</option>
                                
                            <?php 
                            $branch_list = $this->branchm->get_items_by_owner();
                            foreach($branch_list->result() as $row){ ?>
                            <option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Chi nhánh thu:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="branch_id_income">
                                <option value="">- chi nhánh thu -</option>
                                
                            <?php 
                            $branch_list = $this->branchm->get_items();
                            foreach($branch_list->result() as $row){ ?>
                            <option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Số tiền chuyển:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="price" placeholder="số tiền chuyển" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_bill_transfer_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_bill_transfer_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('bill_transfer_id', $id)->where('deleted', 0)->get($this->prefix.'bill_transfer');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->bill_transfer_id ?>" />
            <div class="modal-body">
                <h4>Thông tin phiếu chuyển tiền</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Mã phiếu:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="code" value="<?php echo $result->code ?>" readonly="" placeholder="Phát sinh tự động" class="form-control"></input>
                            </div>
                        </div>

                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Ngày chuyển:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="created_date" value="<?php echo format_get_date($result->created_date) ?>" placeholder="ngày chuyển" class="form-control datepicker"></input>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="clearfix"></div>
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Chi nhánh chi:</div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="branch_id_outcome">
                                    <option value="">- chi nhánh chi -</option>
                                        
                                <?php 
                                $branch_list = $this->branchm->get_items_by_owner();
                                foreach($branch_list->result() as $row){ ?>
                                <option value="<?php echo $row->branch_id ?>" <?php if($result->branch_id_outcome==$row->branch_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                                <?php } ?>
                    
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                                
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Chi nhánh thu:</div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="branch_id_income">
                                    <option value="">- chi nhánh thu -</option>
                                        
                                <?php 
                                $branch_list = $this->branchm->get_items();
                                foreach($branch_list->result() as $row){ ?>
                                <option value="<?php echo $row->branch_id ?>" <?php if($result->branch_id_income==$row->branch_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                                <?php } ?>
                    
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                            
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Số tiền chuyển:</div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="price" value="<?php echo format_get_number($result->price) ?>" placeholder="số tiền chuyển" class="form-control"></input>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_bill_transfer_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
