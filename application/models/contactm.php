<?php

class Contactm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'contact');
    }

    
    function get_items_by_customer_id($customer_id){
        return $this->db->order_by('name ASC')->where('customer_id', $customer_id)->where('deleted', 0)->get($this->prefix.'contact');
    }

    
    function get_items_by_supplier_id($supplier_id){
        return $this->db->order_by('name ASC')->where('supplier_id', $supplier_id)->where('deleted', 0)->get($this->prefix.'contact');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('contact_id', $id)->get($this->prefix .'contact')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('contact_id', $id)->get($this->prefix .'contact')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_contact_list(){
        
        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');
        }
        
        if (isset($_GET['f_customer_id']) && !empty($_GET['f_customer_id'])) {
            $this->db->where('customer_id', $_GET['f_customer_id']);
        }
                
        if (isset($_GET['f_supplier_id']) && !empty($_GET['f_supplier_id'])) {
            $this->db->where('supplier_id', $_GET['f_supplier_id']);
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
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'contact');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->contact_id,
        
                'customer_id' => $row->customer_id,
            
                'supplier_id' => $row->supplier_id,
            
                'name' => $row->name,
            
                'email' => $row->email,
            
                'phone_1' => $row->phone_1,
            
                'phone_2' => $row->phone_2,
            
                'fax' => $row->fax,
            
                'country_id' => $row->country_id,
            
                'city_id' => $row->city_id,
            
                'district_id' => $row->district_id,
            
                'address' => $row->address,
            
                'note' => $row->note,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            if(!empty($row['phone_2'])) $phone = $row['phone_1'].' / '.$row['phone_2'];
            else $phone = $row['phone_1'];
            if(!empty($row['address_1'])) $address = $row['address_1'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            else if(!empty($row['address_2'])) $address = $row['address_2'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            else $address = $this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
            $cate = array(
                
                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',
            
                $row['name'],
            
                $address,
            
                $phone,
            
                $row['email'],
            
                '<a href="#contact_detail" data-toggle="modal" onclick="load_contact_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_contact('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
	
    function delete_contact() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'contact', array('deleted'=>1),array('contact_id'=>$id));                 
                }
           }
        }
    }
        
    
    
    function save_contact_add() {
        $data = array(
            
            'customer_id' => $this->input->post('customer_id'),
            
            'supplier_id' => $this->input->post('supplier_id'),
            
            'name' => $this->input->post('name'),
            
            'email' => $this->input->post('email'),
            
            'phone_1' => $this->input->post('phone_1'),
            
            'phone_2' => $this->input->post('phone_2'),
            
            'fax' => $this->input->post('fax'),
            
            'country_id' => $this->input->post('country_id'),
            
            'city_id' => $this->input->post('city_id'),
            
            'district_id' => $this->input->post('district_id'),
            
            'address' => $this->input->post('address'),
            
            'note' => $this->input->post('note'),
            
            );
        $save = $this->db->insert($this->prefix.'contact', $data);
    }
        
    
    
    function save_contact_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
                
            'customer_id' => $this->input->post('customer_id'),
            
            'supplier_id' => $this->input->post('supplier_id'),
            
            'name' => $this->input->post('name'),
            
            'email' => $this->input->post('email'),
            
            'phone_1' => $this->input->post('phone_1'),
            
            'phone_2' => $this->input->post('phone_2'),
            
            'fax' => $this->input->post('fax'),
            
            'country_id' => $this->input->post('country_id'),
            
            'city_id' => $this->input->post('city_id'),
            
            'district_id' => $this->input->post('district_id'),
            
            'address' => $this->input->post('address'),
            
            'note' => $this->input->post('note'),
            
                );
            $save = $this->db->update($this->prefix.'contact', $data, array('contact_id'=>$id));
        }
    }
        
    
    
    function load_contact_add(){
        ?>  
        <div class="modal-body">
            <div class="col-md-6">
                <h4>Thông tin cơ bản</h4>
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên liên hệ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" placeholder="tên liên hệ" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Nhóm KH/NCC:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" id="object_type">
                            <option value="1">Khách hàng</option>
                            <option value="2">Nhà cung cấp</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="object_type object_type_1">
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">KH/NCC:</div>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" id="customer_info" />
                            <input type="hidden" name="customer_id" value="" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="object_type object_type_2">
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">KH/NCC:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="supplier_id">
                                <option value="">- nhà cung cấp -</option>
                                
                            <?php 
                            $supplier_list = $this->supplierm->get_items();
                            foreach($supplier_list->result() as $row){ ?>
                            <option value="<?php echo $row->supplier_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
            <div class="col-md-6">
                <h4>Thông tin liên lạc</h4>
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
                        <div class="m-t-sm">Địa chỉ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="address" placeholder="địa chỉ" class="form-control"></input>
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
                        <div class="m-t-sm">Điện thoại 1:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="phone_1" placeholder="điện thoại 1" class="form-control"></input>
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
                    
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Fax:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="fax" placeholder="fax" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                    
            </div>
        </div>
        <div class="clearfix m-b"></div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_contact_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_contact_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('contact_id', $id)->where('deleted', 0)->get($this->prefix.'contact');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->contact_id ?>" />
            <div class="modal-body">
                <div class="col-md-6">
                    <h4>Thông tin cơ bản</h4>   
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Tên liên hệ:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên liên hệ" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Nhóm KH/NCC:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="object_type">
                                <option value="1" <?php if($result->customer_id!=0) echo 'selected=""'; ?>>Khách hàng</option>
                                <option value="2" <?php if($result->supplier_id!=0) echo 'selected=""'; ?>>Nhà cung cấp</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="object_type object_type_1">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">KH/NCC:</div>
                            </div>
                            <div class="col-md-8">
                                <?php 
                                    $customer_info = $this->customerm->get_item_by_id($result->customer_id);
                                    $customer_value = array(); 
                                    if(!empty($customer_info)){
                                        if(!empty($customer_info['name'])) $customer_value[] = $customer_info['name'];
                                        if(!empty($customer_info['phone_1'])) $customer_value[] = $customer_info['phone_1'];
                                        $customer_name = implode(' - ', $customer_value);
                                        if(!empty($customer_info['phone_2'])) $phone = $customer_info['phone_1'].' / '.$customer_info['phone_2'];
                                        else $phone = $customer_info['phone_1'];
                                        if(!empty($customer_info['address_1'])) $address = $customer_info['address_1'].', '.$this->districtm->get_name($customer_info['district_id']).', '.$this->citym->get_name($customer_info['city_id']);
                                        else if(!empty($customer_info['address_2'])) $address = $customer_info['address_2'].', '.$this->districtm->get_name($customer_info['district_id']).', '.$this->citym->get_name($customer_info['city_id']);
                                        else $address = $this->districtm->get_name($customer_info['district_id']).', '.$this->citym->get_name($customer_info['city_id']);
                                        $object = $this->objectm->get_name($customer_info['object_id']);
                                        $score = $customer_info['score'];
                                    }else{
                                        $customer_name = '- Khách lẻ -';
                                        $phone = '';
                                        $address = '';
                                        $object = '';
                                        $score = '';
                                    }
                                    ?>
                                    <input class="form-control" id="customer_info" value="<?php echo $customer_name ?>" />
                                    <input type="hidden" name="customer_id" value="<?php echo $result->customer_id; ?>" data-object="<?php echo $object ?>" data-score="<?php echo $score ?>" data-address="<?php echo $address ?>" data-phone="<?php echo $phone ?>" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="object_type object_type_2">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">KH/NCC:</div>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="supplier_id">
                                    <option value="">- nhà cung cấp -</option>
                                        
                                <?php 
                                $supplier_list = $this->supplierm->get_items();
                                foreach($supplier_list->result() as $row){ ?>
                                <option value="<?php echo $row->supplier_id ?>" <?php if($result->supplier_id==$row->supplier_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                                <?php } ?>
                    
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                
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
                <div class="col-md-6">
                    <h4>Thông tin liên lạc</h4>
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
                            <div class="m-t-sm">Địa chỉ:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="address" value="<?php echo $result->address ?>" placeholder="địa chỉ" class="form-control"></input>
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
                        
                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Fax:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="fax" value="<?php echo $result->fax ?>" placeholder="fax" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix m-b"></div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_contact_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
