<?php

class Supplierm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'supplier');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('supplier_id', $id)->get($this->prefix .'supplier')->row_array();
    }
        

    
    function get_name($id){
        $result = $this->db->where('supplier_id', $id)->get($this->prefix .'supplier')->row_array();
        if(!empty($result)) return $result['name'];
        else return '';
    }
        

    
    function get_supplier_list(){
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
        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'supplier');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->supplier_id,
        
                'code' => $row->code,
            
                'name' => $row->name,
            
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
            
                '<a href="#supplier_detail" data-toggle="modal" onclick="load_supplier_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                  <a href="javascript:void(0)" onclick="delete_supplier('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'
                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 


    function get_mini_supplier_list(){
        $product_id = $this->input->post('product_id');
        if(empty($product_id)){
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        }else{
            $store_import_group = $this->db->query('
                SELECT DISTINCT (supplier_id) FROM '.$this->prefix.'store_import_group as sig 
                JOIN '.$this->prefix.'store_import si ON (si.store_import_group_id = sig.store_import_group_id) 
                WHERE si.product_id = "'.$product_id.'"
                '); ?>
            <div class="modal-body">
                <div class="table-container table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr role="row" class="heading">
    
                            <th width="50">Mã</th>

                            <th>Tên</th>

                            <th>Điện thoại</th>

                            <th>Nhóm</th>

                            <th width="50"></th>

                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no_item = true;
                            foreach($store_import_group->result() as $row){
                                if($row->supplier_id==0) continue;
                                $no_item = false;
                                $supplier = $this->supplierm->get_item_by_id($row->supplier_id);
                                if(!empty($supplier['phone_2'])) $phone = $supplier['phone_1'].' / '.$supplier['phone_2'];
                                else $phone = $supplier['phone_1'];
                                $object = $this->objectm->get_name($supplier['object_id']);
                            ?>
                            <tr>
                                <td><?php echo $supplier['code'] ?></td>
                                <td><?php echo $supplier['name'] ?></td>
                                <td><?php echo $phone ?></td>
                                <td><?php echo $object ?></td>
                                <td><?php echo '<a href="#supplier_detail" data-toggle="modal" onclick="load_supplier_edit('.$supplier['supplier_id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>' ?></td>
                            </tr>
                            <?php } ?>

                            <?php if($no_item){ ?>
                            <tr><td colspan="5" style="text-align: center;">Không có nhà cung cấp nào!</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php 
        }
    } 
        
	
	
    function delete_supplier() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $ids = explode(',', $id);
           foreach ($ids as $id){
                if(!empty($id)){
                    $this->db->update($this->prefix.'supplier', array('deleted'=>1),array('supplier_id'=>$id));                 
                }
           }
        }
    }
        
    function save_contact($supplier_id){
        $exist_contact = $this->contactm->get_items_by_supplier_id($supplier_id);
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
                $_POST['supplier_id'] = $supplier_id;
                $_POST['customer_id'] = '';
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
    
    function save_supplier_add() {
        $code = $this->input->post('code');
        if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));
        $data = array(
            
            'code' => $code,
            
            'name' => $this->input->post('name'),
            
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
        $save = $this->db->insert($this->prefix.'supplier', $data);

        $supplier_id = $this->db->insert_id();
        $this->supplierm->save_contact($supplier_id);
    }
        
    
    
    function save_supplier_edit() {
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $code = $this->input->post('code');
            if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));
            $data = array(
                
            'code' => $code,
            
            'name' => $this->input->post('name'),
            
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
            $save = $this->db->update($this->prefix.'supplier', $data, array('supplier_id'=>$id));
            
            $supplier_id = $id;
            $this->supplierm->save_contact($supplier_id);
        }
    }
        
    
    
    function load_supplier_add(){
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
                        <input type="text" name="name" placeholder="tên" class="form-control"></input>
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
                        <?php if($row->type==1) continue; ?>
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
        <div class="clearfix m-b"></div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_supplier_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        
    
    
    function load_supplier_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('supplier_id', $id)->where('deleted', 0)->get($this->prefix.'supplier');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->supplier_id ?>" />
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
                            <div class="m-t-sm">Nhóm:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="object_id">
                                <option value="">- nhóm -</option>
                                    
                            <?php 
                            $object_list = $this->objectm->get_items();
                            foreach($object_list->result() as $row){ ?>
                            <?php if($row->type==1) continue; ?>
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
                    $contact = $this->contactm->get_items_by_supplier_id($result->supplier_id); 
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
            <div class="clearfix m-b"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_supplier_edit($(this))"><i class="fa fa-save"></i> lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>
            </div>
        <?php
        }
    }
        

}
