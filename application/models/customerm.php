<?php

class Customerm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        // Plan Membership
        $membership = $this->session->userdata('membership');
        $customer_plan = explode('|', CUSTOMER_PLAN);
        $customer_limit = $customer_plan[$membership];
        if(!empty($customer_limit)){
            $this->db->limit($customer_limit,0);
        }

        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'customer');
    }
        
    
    function get_items_by_object_id($object_id){
        return $this->db->order_by('name ASC')->where('object_id', $object_id)->where('deleted', 0)->get($this->prefix.'customer');
    }

    
    function get_item_by_id($id){
        return $this->db->where('customer_id', $id)->get($this->prefix .'customer')->row_array();
    }

    
    function get_item_by_phone($phone){
        return $this->db->where('(phone_1 = "'.$phone.'" OR phone_2 = "'.$phone.'")')->get($this->prefix .'customer')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('customer_id', $id)->get($this->prefix .'customer')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
    
    function get_phone($id){
        $result = $this->db->where('customer_id', $id)->get($this->prefix .'customer')->row_array();
        if(!empty($result)) return $result['phone_1'];
        else return '';
    }
        
    function get_customer_list_view(){
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $this->db->where('(code LIKE "%'.$_GET['q'].'%" OR name LIKE "%'.$_GET['q'].'%" OR phone_1 LIKE "%'.$_GET['q'].'%" OR phone_2 LIKE "%'.$_GET['q'].'%")');
        }
        // Plan Membership
        $membership = $this->session->userdata('membership');
        $customer_plan = explode('|', CUSTOMER_PLAN);
        $customer_limit = $customer_plan[$membership];
        if(!empty($customer_limit)){
            $this->db->limit($customer_limit,0);
        }

        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'customer');
        $i=-1;
        if(isset($_GET['page']) && !empty($_GET['page'])) $page = $_GET['page'];
        else $page = 1;
        $limit = 5;
        $list = array();
        foreach($result_item->result() as $row){
            $i++; if(!($i>=($page-1)*$limit&&$i<$page*$limit)) continue;

            if(!empty($row->phone_2)) $phone = $row->phone_1.' / '.$row->phone_2;
            else $phone = $row->phone_1;   
            if(!empty($row->address_1)) $address = $row->address_1.', '.$this->districtm->get_name($row->district_id).', '.$this->citym->get_name($row->city_id);
            else if(!empty($row->address_2)) $address = $row->address_2.', '.$this->districtm->get_name($row->district_id).', '.$this->citym->get_name($row->city_id);
            else $address = $this->districtm->get_name($row->district_id).', '.$this->citym->get_name($row->city_id);
            $object = $this->objectm->get_name($row->object_id);    
            $customer_value = array(); 
            if(!empty($row->name)) $customer_value[] = $row->name;
            if(!empty($row->phone_1)) $customer_value[] = $row->phone_1;
            $name = implode(' - ', $customer_value);                
            $list[] = array(
                
                'id' => $row->customer_id,
            
                'name' => $name,
            
                'score' => $row->score,
            
                'object' => $object,
            
                'address' => $address,
            
                'phone' => $phone
                );
        }
        if(empty($list)){
            $list[] = array(
                'id' => 0,
                'name' => '- Khách lẻ -',
                'score' => '',
                'object' => '',
                'address' => '',
                'phone' => ''
                );
        }
        echo json_encode($list);
    }
    
    function get_customer_list(){
        if(isset($_GET['f_type_search']) && $_GET['f_type_search']==0){ // Normal
            if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
                $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
            }
                
            if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {
                $this->db->where('status', $_GET['f_status']);
            }
        }else{ // Advance
            if (isset($_GET['f_object_id']) && !empty($_GET['f_object_id'])) {
                $this->db->where('object_id', $_GET['f_object_id']);
            }
                    
            if (isset($_GET['f_country_id']) && !empty($_GET['f_country_id'])) {
                $this->db->where('country_id', $_GET['f_country_id']);
            }
                    
            if (isset($_GET['f_city_id']) && !empty($_GET['f_city_id'])) {
                $this->db->where('city_id', $_GET['f_city_id']);
            }
                    
            if (isset($_GET['f_district_id']) && !empty($_GET['f_district_id'])) {
                $this->db->where('district_id', $_GET['f_district_id']);
            }
            if (isset($_GET['f_type_filter']) && !empty($_GET['f_type_filter'])) {
                if($_GET['f_type_filter']==1){ // Code
                    if (isset($_GET['f_value_filter']) && !empty($_GET['f_value_filter'])) {
                        $this->db->where('(code LIKE "%'.$_GET['f_value_filter'].'%")');
                    }
                }else{ // Name
                    if (isset($_GET['f_value_filter']) && !empty($_GET['f_value_filter'])) {
                        $this->db->where('(name LIKE "%'.$_GET['f_value_filter'].'%")');
                    }
                }
            }else{ // All
                if (isset($_GET['f_value_filter']) && !empty($_GET['f_value_filter'])) {
                    $this->db->where('(name LIKE "%'.$_GET['f_value_filter'].'%" OR code LIKE "%'.$_GET['f_value_filter'].'%")');
                }
            }
        }
                
        ////////////////////////////////////
        // Plan Membership
        $membership = $this->session->userdata('membership');
        $customer_plan = explode('|', CUSTOMER_PLAN);
        $customer_limit = $customer_plan[$membership];
        if(!empty($customer_limit)){
            $this->db->limit($customer_limit,0);
        }

        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'customer');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->customer_id,
        
                'code' => $row->code,
            
                'name' => $row->name,
            
                'score' => $row->score,
            
                'object_id' => $row->object_id,
            
                'note' => $row->note,
            
                'country_id' => $row->country_id,
            
                'city_id' => $row->city_id,
            
                'district_id' => $row->district_id,
            
                'tax_code' => $row->tax_code,
            
                'avatar' => $row->avatar,
            
                'fax' => $row->fax,
            
                'email' => $row->email,
            
                'website' => $row->website,
            
                'address_1' => $row->address_1,
            
                'address_2' => $row->address_2,
            
                'phone_1' => $row->phone_1,
            
                'phone_2' => $row->phone_2,
            
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
            if(!empty($row['phone_2'])) $phone = $row['phone_1'].' / '.$row['phone_2'];
            else $phone = $row['phone_1'];
            if(!empty($row['address_1'])) $address = $row['address_1'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            else if(!empty($row['address_2'])) $address = $row['address_2'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            else $address = $this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            $object = $this->objectm->get_name($row['object_id']);
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
        
                $row['code'],
            
                $row['name'],

                $phone,
            
                $object,
            
                $status,
            
                '<a href="#customer_detail" data-toggle="modal" onclick="load_customer_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_customer('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_customer() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'customer', array('deleted'=>1),array('customer_id'=>$id));                 
                }
           }
        }
    }
        
    function save_contact($customer_id){
        $exist_contact = $this->contactm->get_items_by_customer_id($customer_id);
        $exist_contact_id = array();
        $post_contact_id = array();
        $delete_contact_id = array();
        foreach($exist_contact->result() as $row){
            if(!in_array($row->contact_id, $exist_contact_id)) $exist_contact_id[] = $row->contact_id;
        }
        $contact_id = $this->input->post('contact_id');
        $name = $this->input->post('contact_name');
        $email = $this->input->post('contact_email');
        $phone_1 = $this->input->post('contact_phone_1');
        $fax = $this->input->post('contact_fax');
        $address = $this->input->post('contact_address');
        $note = $this->input->post('contact_note');
        if(!empty($contact_id)){
            foreach($contact_id as $key=>$row){
                if(empty($name[$key])) continue;
                $_POST['customer_id'] = $customer_id;
                $_POST['supplier_id'] = '';
                $_POST['name'] = $name[$key];
                $_POST['email'] = $email[$key];
                $_POST['phone_1'] = $phone_1[$key];
                $_POST['phone_2'] = '';
                $_POST['fax'] = $fax[$key];
                $_POST['country_id'] = $this->input->post('country_id');
                $_POST['city_id'] = $this->input->post('city_id');
                $_POST['district_id'] = $this->input->post('district_id');
                $_POST['address'] = $address[$key];
                $_POST['note'] = $note[$key];
                if($row==0){ // insert contact
                    $this->contactm->save_contact_add();
                }else{ // update contact
                    if(!in_array($row, $post_contact_id)) $post_contact_id[] = $row;
                    $_POST['id'] = $row;
                    $this->contactm->save_contact_edit();
                }
            }
        }
        foreach($exist_contact_id as $row){
            if(!in_array($row, $post_contact_id)) $delete_contact_id[] = $row;
        }
        $delete_contact_id = implode(',', $delete_contact_id);
        if(!empty($delete_contact_id)){
            $_POST['id'] = $delete_contact_id;
            $this->contactm->delete_contact();
        }
    }
    
    function save_customer_add() {
        $code = $this->input->post('code');
        if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));
        $data = array(
            
            'code' => $code,
            
            'name' => $this->input->post('name'),
            
            'score' => $this->input->post('score'),
            
            'object_id' => $this->input->post('object_id'),
            
            'note' => $this->input->post('note'),
            
            'country_id' => $this->input->post('country_id'),
            
            'city_id' => $this->input->post('city_id'),
            
            'district_id' => $this->input->post('district_id'),
            
            'tax_code' => $this->input->post('tax_code'),
            
            'avatar' => $this->input->post('avatar'),
            
            'fax' => $this->input->post('fax'),
            
            'email' => $this->input->post('email'),
            
            'website' => $this->input->post('website'),
            
            'address_1' => $this->input->post('address_1'),
            
            'address_2' => $this->input->post('address_2'),
            
            'phone_1' => $this->input->post('phone_1'),
            
            'phone_2' => $this->input->post('phone_2'),
            
            'status' => $this->input->post('status'),
            
            );
        
        if($this->input->post('quick_customer')){
            $exist_phone = $this->customerm->get_item_by_phone($this->input->post('phone_1'));
            if(empty($exist_phone)||empty($this->input->post('phone_1'))){
                $save = $this->db->insert($this->prefix.'customer', $data);
                $customer_id = $this->db->insert_id();
                echo json_encode(array('name'=>$this->input->post('name').' - '.$this->input->post('phone_1'), 'id'=>$customer_id));
            }else{
                $save = $this->db->update($this->prefix.'customer', $data, array('customer_id'=>$exist_phone['customer_id']));
                $customer_id = $exist_phone['customer_id'];
                echo json_encode(array('name'=>$this->input->post('name').' - '.$this->input->post('phone_1'), 'id'=>$customer_id));
            }
        }else{
            $save = $this->db->insert($this->prefix.'customer', $data);
            $customer_id = $this->db->insert_id();
            $this->customerm->save_contact($customer_id);
        }

    }
        
    
    
    function save_customer_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $code = $this->input->post('code');
            if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));
            $data = array(
                
            'code' => $code,
            
            'name' => $this->input->post('name'),
            
            'score' => $this->input->post('score'),
            
            'object_id' => $this->input->post('object_id'),
            
            'note' => $this->input->post('note'),
            
            'country_id' => $this->input->post('country_id'),
            
            'city_id' => $this->input->post('city_id'),
            
            'district_id' => $this->input->post('district_id'),
            
            'tax_code' => $this->input->post('tax_code'),
            
            'avatar' => $this->input->post('avatar'),
            
            'fax' => $this->input->post('fax'),
            
            'email' => $this->input->post('email'),
            
            'website' => $this->input->post('website'),
            
            'address_1' => $this->input->post('address_1'),
            
            'address_2' => $this->input->post('address_2'),
            
            'phone_1' => $this->input->post('phone_1'),
            
            'phone_2' => $this->input->post('phone_2'),
            
            'status' => $this->input->post('status'),
            
                );
            $save = $this->db->update($this->prefix.'customer', $data, array('customer_id'=>$id));

            $customer_id = $id;
            $this->customerm->save_contact($customer_id);
        }
    }
        
    
    
    function load_customer_add(){
        // Plan Membership
        $membership = $this->session->userdata('membership');
        $customer_plan = explode('|', CUSTOMER_PLAN);
        $customer_limit = $customer_plan[$membership];
        $count_customer = $this->db->where('deleted', 0)->get($this->prefix.'customer')->num_rows();
        if($count_customer > $customer_limit && !empty($customer_limit)){
            echo '<div class="modal-body" style="text-align: center;">
                    <h4>Thông báo</h4>
                    <p>Bạn đã đạt giới hạn của gói dịch vụ này. Bạn cần nâng cấp gói dịch vụ để thêm khách hàng!</p>
                  </div>';
            die;
        }
        ?>  
        <div class="modal-body">
            <div class="col-md-6">
                <h4>Thông tin cơ bản</h4>
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
                        <input type="text" name="name" placeholder="tên" class="form-control yellow-highlight"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Điểm tích luỹ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="score" placeholder="điểm tích luỹ" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                        
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Nhóm:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control yellow-highlight" name="object_id">
                            <option value="">- nhóm -</option>
                            
                        <?php 
                        $object_list = $this->objectm->get_items();
                        foreach($object_list->result() as $row){ ?>
                        <?php if($row->type==2) continue; ?>
                        <option value="<?php echo $row->object_id ?>" ><?php echo $row->name ?></option>
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
                <div class="addition_info">
                    <h4>Thông tin khác</h4>
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
                            <div class="m-t-sm">Thành phố:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="city_id">
                                <option value="">- thành phố -</option>
                                
                            <?php 
                            $city_list = $this->citym->get_items();
                            foreach($city_list->result() as $row){ ?>
                            <option value="<?php echo $row->city_id ?>" data="<?php echo $row->country_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Quận huyện:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="district_id">
                                <option value="">- quận huyện -</option>
                                
                            <?php 
                            $district_list = $this->districtm->get_items();
                            foreach($district_list->result() as $row){ ?>
                            <option value="<?php echo $row->district_id ?>" data="<?php echo $row->city_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã số thuế:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tax_code" placeholder="mã số thuế" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h4>Hình đại diện</h4>
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Hình đại diện:</div>
                        </div>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px;" id="image_src">
                                    <img src="<?php echo base_url() ?><?php echo image('',200,150); ?>" />
                                </div>
                                <div>
                                    <a href="javascript:void(0)" id="image_avatar" class="btn default fileinput-exists">Chọn hình</a>
                                    <input type="hidden" id="avatar" name="avatar" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Thông tin liên lạc</h4>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Fax:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="fax" placeholder="fax" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Email:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="email" placeholder="email" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Website:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="website" placeholder="website" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Địa chỉ 1:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="address_1" placeholder="địa chỉ 1" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Địa chỉ 2:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="address_2" placeholder="địa chỉ 2" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Điện thoại 1:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="phone_1" placeholder="điện thoại 1" class="form-control yellow-highlight"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Điện thoại 2:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="phone_2" placeholder="điện thoại 2" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="addition_info">
                    <h4>Liên hệ của KH / NCC này <a class="label label-info pull-right" onclick="module_load_contact_add();">thêm</a></h4>
                    <div id="contact_template" style="display: none;">
                        <input type="hidden" name="contact_id[]" value="0" />
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_name[]" placeholder="Tên liên hệ"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_email[]" placeholder="Email"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_phone_1[]" placeholder="Số điện thoại"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_fax[]" placeholder="Fax"></input>
                        </div>
                        <div class="col-md-12 m-t-sm">
                            <input type="text" class="form-control" name="contact_address[]" placeholder="Địa chỉ"></input>
                        </div>
                        <div class="col-md-10 m-t-sm">
                            <textarea class="form-control" name="contact_note[]" placeholder="Ghi chú"></textarea>
                        </div>
                        <div class="col-md-2 m-t-sm">
                            <a class="label label-danger" onclick="module_delete_contact($(this));">xoá</a>
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                    </div>
                </div>
            </div>	
        </div>
        <div class="clearfix m-b"></div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_customer_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_customer_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('customer_id', $id)->where('deleted', 0)->get($this->prefix.'customer');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->customer_id ?>" />
            <div class="modal-body">
                <div class="col-md-6">
                    <h4>Thông tin cơ bản</h4>
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
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Điểm tích luỹ:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="score" value="<?php echo $result->score ?>" placeholder="điểm tích luỹ" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Nhóm:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="object_id">
                                <option value="">- nhóm -</option>
                                    
                            <?php 
                            $object_list = $this->objectm->get_items();
                            foreach($object_list->result() as $row){ ?>
                            <?php if($row->type==2) continue; ?>
                            <option value="<?php echo $row->object_id ?>" <?php if($result->object_id==$row->object_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
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
                    <h4>Thông tin khác</h4>
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
                            <div class="m-t-sm">Thành phố:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="city_id">
                                <option value="">- thành phố -</option>
                                    
                            <?php 
                            $city_list = $this->citym->get_items();
                            foreach($city_list->result() as $row){ ?>
                            <option value="<?php echo $row->city_id ?>" data="<?php echo $row->country_id ?>" <?php if($result->city_id==$row->city_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Quận huyện:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="district_id">
                                <option value="">- quận huyện -</option>
                                    
                            <?php 
                            $district_list = $this->districtm->get_items();
                            foreach($district_list->result() as $row){ ?>
                            <option value="<?php echo $row->district_id ?>" data="<?php echo $row->city_id ?>" <?php if($result->district_id==$row->district_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã số thuế:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tax_code" value="<?php echo $result->tax_code ?>" placeholder="mã số thuế" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h4>Hình đại diện</h4>
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Hình đại diện:</div>
                        </div>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px;" id="image_src">
                                    <img src="<?php echo base_url() ?><?php echo image('upload/'.$result->avatar,200,150); ?>" />
                                </div>
                                <div>
                                    <a href="javascript:void(0)" id="image_avatar" class="btn default fileinput-exists">Chọn hình</a>
                                    <input type="hidden" id="avatar" name="avatar" value="<?php echo $result->avatar; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-6">
                    <h4>Thông tin liên lạc</h4>
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Fax:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="fax" value="<?php echo $result->fax ?>" placeholder="fax" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Email:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="email" value="<?php echo $result->email ?>" placeholder="email" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Website:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="website" value="<?php echo $result->website ?>" placeholder="website" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Địa chỉ 1:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="address_1" value="<?php echo $result->address_1 ?>" placeholder="địa chỉ 1" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Địa chỉ 2:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="address_2" value="<?php echo $result->address_2 ?>" placeholder="địa chỉ 2" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Điện thoại 1:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="phone_1" value="<?php echo $result->phone_1 ?>" placeholder="điện thoại 1" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Điện thoại 2:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="phone_2" value="<?php echo $result->phone_2 ?>" placeholder="điện thoại 2" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h4>Liên hệ của KH / NCC này <a class="label label-info pull-right" onclick="module_load_contact_add();">thêm</a></h4>
                    <?php 
                    $contact = $this->contactm->get_items_by_customer_id($result->customer_id); 
                    foreach($contact->result() as $row){
                    ?>
                    <div class="row">
                        <input type="hidden" name="contact_id[]" value="<?php echo $row->contact_id ?>" />
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_name[]" value="<?php echo $row->name ?>" placeholder="Tên liên hệ"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_email[]" value="<?php echo $row->email ?>" placeholder="Email"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_phone_1[]" value="<?php echo $row->phone_1 ?>" placeholder="Số điện thoại"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_fax[]" value="<?php echo $row->fax ?>" placeholder="Fax"></input>
                        </div>
                        <div class="col-md-12 m-t-sm">
                            <input type="text" class="form-control" name="contact_address[]" value="<?php echo $row->address ?>" placeholder="Địa chỉ"></input>
                        </div>
                        <div class="col-md-10 m-t-sm">
                            <textarea class="form-control" name="contact_note[]" placeholder="Ghi chú"><?php echo $row->note ?></textarea>
                        </div>
                        <div class="col-md-2 m-t-sm">
                            <a class="label label-danger" onclick="module_delete_contact($(this));">xoá</a>
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                    </div>
                    <?php } ?>
                    <div id="contact_template" style="display: none;">
                        <input type="hidden" name="contact_id[]" value="0" />
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_name[]" placeholder="Tên liên hệ"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_email[]" placeholder="Email"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_phone_1[]" placeholder="Số điện thoại"></input>
                        </div>
                        <div class="col-md-6 m-t-sm">
                            <input type="text" class="form-control" name="contact_fax[]" placeholder="Fax"></input>
                        </div>
                        <div class="col-md-12 m-t-sm">
                            <input type="text" class="form-control" name="contact_address[]" placeholder="Địa chỉ"></input>
                        </div>
                        <div class="col-md-10 m-t-sm">
                            <textarea class="form-control" name="contact_note[]" placeholder="Ghi chú"></textarea>
                        </div>
                        <div class="col-md-2 m-t-sm">
                            <a class="label label-danger" onclick="module_delete_contact($(this));">xoá</a>
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                    </div>
            	</div>
            </div>
            <div class="clearfix m-b"></div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_customer_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
