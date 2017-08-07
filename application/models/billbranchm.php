<?php

class Billbranchm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('bill_branch_id DESC')->where('deleted', 0)->get($this->prefix.'bill_branch');
    }
        
        
    function get_items_by_branch_id($branch_id){
        return $this->db->order_by('bill_branch_id DESC')->where('branch_id', $branch_id)->where('deleted', 0)->get($this->prefix .'bill_branch');
    }

    
    function get_item_by_id($id){
        return $this->db->where('bill_branch_id', $id)->get($this->prefix .'bill_branch')->row_array();
    }

    
    function get_item_by_bill_income_id($bill_income_id){
        return $this->db->where('bill_income_id', $bill_income_id)->get($this->prefix .'bill_branch')->row_array();
    }

    
    function get_item_by_bill_outcome_id($bill_outcome_id){
        return $this->db->where('bill_outcome_id', $bill_outcome_id)->get($this->prefix .'bill_branch')->row_array();
    }

    function get_total_bill_branch($branch_id){
        $bill_branch = $this->billbranchm->get_items_by_branch_id($branch_id);
        $total_bill_branch = 0;
        foreach($bill_branch->result() as $row){
            if(!empty($row->bill_income_id)) $total_bill_branch+= $row->price;
            if(!empty($row->bill_outcome_id)) $total_bill_branch-= $row->price;
        }
        return $total_bill_branch;
    }

    function create_bill_branch($branch_id, $bill_income_id, $bill_outcome_id, $price){
        $this->db->insert($this->prefix.'bill_branch',array(
            'branch_id'=>$branch_id,
            'price'=>$price,
            'bill_income_id'=>$bill_income_id,
            'bill_outcome_id'=>$bill_outcome_id,
            'created_date'=>date('Y-m-d H:i:s')
            ));
        return $this->db->insert_id();
    }

    function update_bill_branch($branch_id, $bill_income_id, $bill_outcome_id, $price){
        if(!empty($bill_income_id)){
            $current_bill_branch = $this->billbranchm->get_item_by_bill_income_id($bill_income_id);
        }else if(!empty($bill_outcome_id)){
            $current_bill_branch = $this->billbranchm->get_item_by_bill_outcome_id($bill_outcome_id);
        }else return false;
        if(empty($current_bill_branch)) return false;
        $this->db->update($this->prefix.'bill_branch',array(
            'branch_id'=>$branch_id,
            'price'=>$price,
            'bill_income_id'=>$bill_income_id,
            'bill_outcome_id'=>$bill_outcome_id,
            'created_date'=>date('Y-m-d H:i:s')
            ),array('bill_branch_id'=>$current_bill_branch['bill_branch_id']));
        return $current_bill_branch['bill_branch_id'];
    }
    
    function get_bill_branch_list(){
        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {
            $this->db->where('branch_id', $_GET['f_branch_id']);
        }
        $branchs = $this->branchm->get_items();
                
        ////////////////////////////////////
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $branchs->num_rows();
        $data['aaData'] = array();
        $i=-1;
        $total = 0;
        foreach ($branchs->result() as $branch):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $total_bill_branch = $this->billbranchm->get_total_bill_branch($branch->branch_id);
            $total += $total_bill_branch;
            $cate = array(
                $branch->name,
                '<input type="text" name="price" class="form-control price_branch" data="'.$branch->branch_id.'" value='.$total_bill_branch.' />',
                );
            $data['aaData'][] = $cate;
        endforeach;
        $data['aaData'][] = array(
            '<b>Tổng:</b>',
            '<b class="text-danger">'.$this->currencym->format_currency($total).'</b>',
            );
        echo json_encode($data);
    }

    function get_bill_group_branch_list(){
        $result_item = $this->db->select('branch_id, sum(price) as branch_price')
            ->from($this->prefix.'bill_bank')
            ->group_by('branch_id')
            ->get();
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        $total_branch_price = 0;
        foreach($result_item->result() as $row){
            $total_branch_price += $row->branch_price;
            $list[] = array(

                'id' => $row->branch_id,

                'price' => $row->branch_price,

            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $branch_name = $this->branchm->get_name($row['id']);
            $cate = array(

                $branch_name,

                $row['price'],

            );
            $data['aaData'][] = $cate;
        endforeach;
        $data['aaData'][] = array('<b class="text-danger">Tổng cộng:</b>','<b class="text-danger">'.$this->currencym->format_currency($total_branch_price).'</b>','');
        echo json_encode($data);

    }
        
	
    
    function bill_branch_save() {
        $branch = $this->input->post('key');
        $price_branch = $this->input->post('price_branch');
        if($branch) {
            $branch = explode(',', $branch);
            $price_branch = explode(',', $price_branch);
            foreach($branch as $key=>$row){
                $branch_id = $row;
                $price = $price_branch[$key];
                $total_bill_branch = $this->billbranchm->get_total_bill_branch($branch_id);
                if($price>$total_bill_branch){ // Income
                    $_POST['branch_id'] = $branch_id;
                    $_POST['code'] = $this->settingm->generate_code('pt', $branch_id);
                    $_POST['created_date'] = date('d/m/Y');
                    $_POST['employee_id'] = $this->session->userdata('employee');
                    $_POST['type'] = 2;
                    $_POST['method'] = 1;
                    $_POST['price'] = $price-$total_bill_branch;
                    $_POST['commission_price'] = 0;
                    $_POST['commission_percent'] = 0;
                    $_POST['customer_id'] = 0;
                    $_POST['note'] = 'Thu điều chỉnh quỹ đầu kỳ';
                    $bill_income_id = $this->billincomem->save_bill_income_add();
                    $bill_outcome_id = 0;
                }else if($price<$total_bill_branch){ // Outcome
                    $_POST['branch_id'] = $branch_id;
                    $_POST['code'] = $this->settingm->generate_code('pc', $branch_id);
                    $_POST['created_date'] = date('d/m/Y');
                    $_POST['employee_id'] = $this->session->userdata('employee');
                    $_POST['type'] = 2;
                    $_POST['method'] = 1;
                    $_POST['price'] = $total_bill_branch-$price;
                    $_POST['commission_price'] = 0;
                    $_POST['commission_percent'] = 0;
                    $_POST['supplier_id'] = 0;
                    $_POST['note'] = 'Chi điều chỉnh quỹ đầu kỳ';
                    $bill_outcome_id = $this->billoutcomem->save_bill_outcome_add();
                    $bill_income_id = 0;
                }
                if($price!=$total_bill_branch) $this->billbranchm->create_bill_branch($branch_id, $bill_income_id, $bill_outcome_id, $_POST['price']);
            }
        }
    }
        
    
    
}
