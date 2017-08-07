<?php

class Settingm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('setting_id DESC')->where('deleted', 0)->get($this->prefix.'setting');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('setting_id', $id)->get($this->prefix .'setting')->row_array();
    }
    
    function generate_code($code, $branch_id){
        $setting_value = $this->settingm->get_setting_value('code', $code);
        if(!isset($setting_value['code_char'])) $code_char = strtoupper($code);
        else $code_char = $setting_value['code_char'];
        if(!isset($setting_value['code_number'])) $code_number = 1;
        else $code_number = $setting_value['code_number'];
        if(!isset($setting_value['code_is_number_first'])) $code_is_number_first = 1;
        else $code_is_number_first = $setting_value['code_is_number_first'];
        if(!isset($setting_value['code_is_branch_follow'])) $code_is_branch_follow = 1;
        else $code_is_branch_follow = $setting_value['code_is_branch_follow'];
        $branch = $this->branchm->get_item_by_id($branch_id);
        if(empty($branch)) $branch_code = 'MD';
        else if(empty($branch['code'])){ 
            $branch_name = explode(' ', $branch['name']);
            $first_char = '';
            foreach($branch_name as $row){
                if(isset($row[0])&&!empty($row[0])) $first_char .= strtoupper($row[0]);
            }
            if(!empty($first_char)) $branch_code = $first_char;
            else $branch_code = 'MD';
        }else{
            $branch_code = $branch['code'];
        }

        switch ($code) {
            case 'pck': // Phiếu chuyển kho
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('store_transfer_group_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'store_transfer_group')->row();
                }else{
                    $last_result = $this->db->order_by('store_transfer_group_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'store_transfer_group')->row();
                }
                break;
            case 'pnk': // Phiếu nhập kho
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('store_import_group_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'store_import_group')->row();
                }else{
                    $last_result = $this->db->order_by('store_import_group_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'store_import_group')->row();
                }
                break;
            case 'pxk': // Phiếu xuất kho
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('store_export_group_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'store_export_group')->row();
                }else{
                    $last_result = $this->db->order_by('store_export_group_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'store_export_group')->row();
                }
                break;
            case 'pbh': // Phiếu bán hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('order_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'order')->row();
                }else{
                    $last_result = $this->db->order_by('order_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'order')->row();
                }
                break;
            case 'mbpbh': // Mã bán phiếu bán hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('order_id DESC')->where('code_sale LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'order')->row();
                }else{
                    $last_result = $this->db->order_by('order_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'order')->row();
                }
                break;
            case 'mspbh': // Mã sửa phiếu bán hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('order_id DESC')->where('code_fix LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'order')->row();
                }else{
                    $last_result = $this->db->order_by('order_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'order')->row();
                }
                break;
            case 'pnth': // Phiếu nhập trả hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('return_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'return')->row();
                }else{
                    $last_result = $this->db->order_by('return_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'return')->row();
                }
                break;
            case 'mbpnth': // Mã bán phiếu nhập trả hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('return_id DESC')->where('code_sale LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'return')->row();
                }else{
                    $last_result = $this->db->order_by('return_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'return')->row();
                }
                break;
            case 'mspnth': // Mã sửa phiếu nhập trả hàng
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('return_id DESC')->where('code_fix LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'return')->row();
                }else{
                    $last_result = $this->db->order_by('return_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'return')->row();
                }
                break;
            case 'pct': // Phiếu chuyển tiền
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('bill_transfer_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'bill_transfer')->row();
                }else{
                    $last_result = $this->db->order_by('bill_transfer_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'bill_transfer')->row();
                }
                break;
            case 'pt': // Phiếu thu
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('bill_income_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'bill_income')->row();
                }else{
                    $last_result = $this->db->order_by('bill_income_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'bill_income')->row();
                }
                break;
            case 'pc': // Phiếu chi
                if($code_is_branch_follow){
                    $last_result = $this->db->order_by('bill_outcome_id DESC')->where('code LIKE "%-'.$branch_code.'-%"')->limit(1)->get($this->prefix.'bill_outcome')->row();
                }else{
                    $last_result = $this->db->order_by('bill_outcome_id DESC')->where('code NOT LIKE "%-%-%"')->limit(1)->get($this->prefix.'bill_outcome')->row();
                }
                break;
        }
        if(!empty($last_result)){ 
            $code = explode('-', $last_result->code);
            foreach($code as $row){
                if(((int)$row)!=0) $last_number = (int)$row+1;
            }
        }
        else $last_number = 1;
        if($code_is_number_first){
            if($code_is_branch_follow){
                $result_code = str_pad($last_number, $code_number, 0, STR_PAD_LEFT).'-'.$branch_code.'-'.$code_char;
            }else{
                $result_code = str_pad($last_number, $code_number, 0, STR_PAD_LEFT).'-'.$code_char;
            }
        }else{
            if($code_is_branch_follow){
                $result_code = $code_char.'-'.$branch_code.'-'.str_pad($last_number, $code_number, 0, STR_PAD_LEFT);
            }else{
                $result_code = $code_char.'-'.str_pad($last_number, $code_number, 0, STR_PAD_LEFT);
            }
        }
        return $result_code;
    }        

    function get_code(){
        $all_code = array(
            'pck'=>'Phiếu chuyển kho',
            'pnk'=>'Phiếu nhập kho',
            'pxk'=>'Phiếu xuất kho',
            'pbh'=>'Phiếu bán hàng',
            'mbpbh'=>'Mã bán phiếu bán hàng',
            'mspbh'=>'Mã sửa phiếu bán hàng',
            'pnth'=>'Phiếu nhập trả hàng',
            'mbpnth'=>'Mã bán phiếu nhập trả hàng',
            'mspnth'=>'Mã sửa phiếu nhập trả hàng',
            'mpb'=>'Mã phiếu bán',
            'mps'=>'Mã phiếu sửa',
            'pct'=>'Phiếu chuyển tiền',
            'pt'=>'Phiếu thu',
            'pc'=>'Phiếu chi',
            );
        return $all_code;
    }

    function get_setting_value($setting_group, $setting_key, $setting_value = array()){
        $result_item = $this->db->where('setting_group', $setting_group)->where('setting_key', $setting_key)->where('deleted', 0)->get($this->prefix.'setting')->row();
        if(!empty($result_item)){ 
            if(!empty($result_item->setting_value)){
                if(is_serialized($result_item->setting_value)) $setting_value = unserialize($result_item->setting_value);
                else $setting_value = $result_item->setting_value;
            }
        }
        return $setting_value;
    }

    function get_setting_list(){
        $data['aaData'] = array();
        $all_code = $this->settingm->get_code();
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($all_code);
        $i=-1;
        foreach ($all_code as $key=>$row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

            $setting_value = $this->settingm->get_setting_value('code', $key);
            if(!isset($setting_value['code_char'])) $code_char = strtoupper($key);
            else $code_char = $setting_value['code_char'];
            if(!isset($setting_value['code_number'])) $code_number = 1;
            else $code_number = $setting_value['code_number'];
            if(!isset($setting_value['code_is_number_first'])) $code_is_number_first = 1;
            else $code_is_number_first = $setting_value['code_is_number_first'];
            if(!isset($setting_value['code_is_branch_follow'])) $code_is_branch_follow = 1;
            else $code_is_branch_follow = $setting_value['code_is_branch_follow'];

            $cate = array(
                $row,

                '<input type="text" class="form-control code_char" data="'.$key.'" value="'.$code_char.'" />',
        
                '<input type="text" class="form-control code_number" value="'.$code_number.'" />',
            
                '<input type="checkbox" '.($code_is_number_first?'checked="checked"':'').' class="code_is_number_first" />',
            
                '<input type="checkbox" '.($code_is_branch_follow?'checked="checked"':'').' class="code_is_branch_follow" />',

                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
    
    function setting_save() {
        $setting_key = $this->input->post('setting_key');
        $code_char = $this->input->post('code_char');
        $code_number = $this->input->post('code_number');
        $code_is_number_first = $this->input->post('code_is_number_first');
        $code_is_branch_follow = $this->input->post('code_is_branch_follow');
        if($setting_key&&$code_char&&$code_number&&$code_is_number_first&&$code_is_branch_follow) {
            $setting_key = explode(',', $setting_key);
            $code_char = explode(',', $code_char);
            $code_number = explode(',', $code_number);
            $code_is_number_first = explode(',', $code_is_number_first);
            $code_is_branch_follow = explode(',', $code_is_branch_follow);
            foreach($setting_key as $key=>$row){
                $data = array(
                    'code_char' => $code_char[$key],
                    'code_number' => $code_number[$key],
                    'code_is_number_first' => $code_is_number_first[$key],
                    'code_is_branch_follow' => $code_is_branch_follow[$key],
                    );
                $exist_setting = $this->db->where('setting_group', 'code')->where('setting_key', $row)->where('deleted', 0)->get($this->prefix.'setting')->row();
                if(!empty($exist_setting)){
                    $this->db->update($this->prefix.'setting',
                        array(
                            'setting_group'=>'code',
                            'setting_key'=>$row,
                            'setting_value'=>serialize($data)
                            ),
                        array('setting_id'=>$exist_setting->setting_id));
                }else{
                    $this->db->insert($this->prefix.'setting',
                        array(
                            'setting_group'=>'code',
                            'setting_key'=>$row,
                            'setting_value'=>serialize($data)
                            ));
                }
            }
        }

        $exist_setting = $this->db->where('setting_group', 'general')->where('setting_key', 'vat')->where('deleted', 0)->get($this->prefix.'setting')->row();
        if(!empty($exist_setting)){
            $this->db->update($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'vat',
                    'setting_value'=>$this->input->post('general_vat')
                    ),
                array('setting_id'=>$exist_setting->setting_id));
        }else{
            $this->db->insert($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'vat',
                    'setting_value'=>$this->input->post('general_vat')
                    ));
        }

        $exist_setting = $this->db->where('setting_group', 'general')->where('setting_key', 'expired')->where('deleted', 0)->get($this->prefix.'setting')->row();
        if(!empty($exist_setting)){
            $this->db->update($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'expired',
                    'setting_value'=>$this->input->post('general_expired')
                    ),
                array('setting_id'=>$exist_setting->setting_id));
        }else{
            $this->db->insert($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'expired',
                    'setting_value'=>$this->input->post('general_expired')
                    ));
        }

        $exist_setting = $this->db->where('setting_group', 'general')->where('setting_key', 'product_avatar')->where('deleted', 0)->get($this->prefix.'setting')->row();
        if(!empty($exist_setting)){
            $this->db->update($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'product_avatar',
                    'setting_value'=>$this->input->post('general_product_avatar')
                    ),
                array('setting_id'=>$exist_setting->setting_id));
        }else{
            $this->db->insert($this->prefix.'setting',
                array(
                    'setting_group'=>'general',
                    'setting_key'=>'product_avatar',
                    'setting_value'=>$this->input->post('general_product_avatar')
                    ));
        }
    }
         

}
