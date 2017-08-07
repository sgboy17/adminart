<?php



class Employeem extends My_Model {



    function __construct() {

        parent::__construct();

    }



    

    function get_items(){

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $employee_plan = explode('|', EMPLOYEE_PLAN);

        $employee_limit = $employee_plan[$membership];

        if(!empty($employee_limit)){

            $this->db->limit($employee_limit,0);

        }



        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'employee');

    }

        



    

    function get_item_by_id($id){

        return $this->db->where('employee_id', $id)->get($this->prefix .'employee')->row_array();

    }

        



    

    function get_name($id){

        $result = $this->db->where('employee_id', $id)->get($this->prefix .'employee')->row_array();

        if(!empty($result)) return $result['name'];

        else return '';

    }

    function get_phone($id){

        $result = $this->db->where('employee_id', $id)->get($this->prefix .'employee')->row_array();

        if(!empty($result)) {
           if( !empty($result['phone_1']) )
            return $result['phone_1'];
           else return $result['phone_2'];
        }
        else return '';

    }


    function get_name_by_user($user_id){

        $user = $this->userm->get_item_by_id($user_id);

        $result = $this->db->where('employee_id', $user['employee_id'])->get($this->prefix .'employee')->row_array();

        if(!empty($result)) return $result['name'];

        else return '';

    }


    

    function get_employee_list(){

        

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {

            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');

        }

        

        if (isset($_GET['f_gender']) && !empty($_GET['f_gender'])) {

            $this->db->where('gender', $_GET['f_gender']);

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

                

        if (isset($_GET['f_status']) && !empty($_GET['f_status'])) {

            $this->db->where('status', $_GET['f_status']);

        }

                

        ////////////////////////////////////

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $employee_plan = explode('|', EMPLOYEE_PLAN);

        $employee_limit = $employee_plan[$membership];

        if(!empty($employee_limit)){

            $this->db->limit($employee_limit,0);

        }



        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'employee');

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                

                'id' => $row->employee_id,

        

                'code' => $row->code,

            

                'name' => $row->name,

            

                'birthday' => $row->birthday,

            

                'gender' => $row->gender,

            

                'note' => $row->note,

            

                'avatar' => $row->avatar,

            

                'address' => $row->address,

            

                'country_id' => $row->country_id,

            

                'city_id' => $row->city_id,

            

                'district_id' => $row->district_id,

            

                'phone_1' => $row->phone_1,

            

                'phone_2' => $row->phone_2,

            

                'email' => $row->email,

            

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

            if(!empty($row['address'])) $address = $row['address'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);

            else $address = $this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);

            $cate = array(

                

                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

            

                $row['name'],

            

                $phone,

            

                $row['email'],

            

                $status,

            

                '<a href="#employee_detail" data-toggle="modal" onclick="load_employee_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>

                  <a href="javascript:void(0)" onclick="delete_employee('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'

                );

            $data['aaData'][] = $cate;

        endforeach;

        echo json_encode($data);

    } 

        

	

	

    function delete_employee() {

        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $ids = explode(',', $id);

           foreach ($ids as $id){

                if(!empty($id)){

                    $this->db->update($this->prefix.'employee', array('deleted'=>1),array('employee_id'=>$id));                 

                }

           }

        }

    }

        

    

    

    function save_employee_add() {

        $exist_email = $this->db->where('email', $this->input->post('email'))->where('deleted', 0)->get($this->prefix.'employee');

        if($exist_email->num_rows()>0){

            echo json_encode(20);

            die;

        }

        $code = $this->input->post('code');

        if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));

        $birthday = format_save_date($this->input->post('birthday'));

        $data = array(

            

            'code' => $code,

            

            'name' => $this->input->post('name'),

            

            'birthday' => $birthday,

            

            'gender' => $this->input->post('gender'),

            

            'note' => $this->input->post('note'),

            

            'avatar' => $this->input->post('avatar'),

            

            'address' => $this->input->post('address'),

            

            'country_id' => $this->input->post('country_id'),

            

            'city_id' => $this->input->post('city_id'),

            

            'district_id' => $this->input->post('district_id'),

            

            'phone_1' => $this->input->post('phone_1'),

            

            'phone_2' => $this->input->post('phone_2'),

            

            'email' => $this->input->post('email'),

            

            'status' => $this->input->post('status'),

            

            );

        $save = $this->db->insert($this->prefix.'employee', $data);

    }

        

    

    

    function save_employee_edit() {

        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $exist_email = $this->db->where('employee_id !=',$id)->where('email', $this->input->post('email'))->where('deleted', 0)->get($this->prefix.'employee');

            if($exist_email->num_rows()>0){

                echo json_encode(20);

                die;

            }

            $code = $this->input->post('code');

            if(empty($code)) $code = $this->filem->getCode($this->input->post('name'));

            $birthday = format_save_date($this->input->post('birthday'));

            $data = array(

                

            'code' => $code,

            

            'name' => $this->input->post('name'),

            

            'birthday' => $birthday,

            

            'gender' => $this->input->post('gender'),

            

            'note' => $this->input->post('note'),

            

            'avatar' => $this->input->post('avatar'),

            

            'address' => $this->input->post('address'),

            

            'country_id' => $this->input->post('country_id'),

            

            'city_id' => $this->input->post('city_id'),

            

            'district_id' => $this->input->post('district_id'),

            

            'phone_1' => $this->input->post('phone_1'),

            

            'phone_2' => $this->input->post('phone_2'),

            

            'email' => $this->input->post('email'),

            

            'status' => $this->input->post('status'),

            

                );

            $save = $this->db->update($this->prefix.'employee', $data, array('employee_id'=>$id));

        }

    }

        

    

    

    function load_employee_add(){

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $employee_plan = explode('|', EMPLOYEE_PLAN);

        $employee_limit = $employee_plan[$membership];

        $count_employee = $this->db->where('deleted', 0)->get($this->prefix.'employee')->num_rows();

        if($count_employee > $employee_limit && !empty($employee_limit)){

            echo '<div class="modal-body" style="text-align: center;">

                    <h4>Thông báo</h4>

                    <p>Bạn đã đạt giới hạn của gói dịch vụ này. Bạn cần nâng cấp gói dịch vụ để thêm nhân viên!</p>

                  </div>';

            die;

        }



        ?>  

        <div class="modal-body">

            <div class="col-md-6">

                <h4>Thông tin cơ bản</h4>

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">Mã nhân viên:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="code" placeholder="mã nhân viên" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">Tên nhân viên:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="name" placeholder="tên nhân viên" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">Ngày sinh:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="birthday" placeholder="ngày sinh" class="form-control datepicker"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">Giới tính:</div>

                    </div>

                    <div class="col-md-8">

                        <div class="radio-list">

                            <label class="radio-inline">

                            <input type="radio" name="gender" value="1" checked=""> Nam </label>

                            <label class="radio-inline">

                            <input type="radio" name="gender" value="2"> Nữ </label>

                        </div>

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

                        <div class="m-t-sm">Địa chỉ:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="address" placeholder="địa chỉ" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

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

                        <div class="m-t-sm">Tỉnh/thành:</div>

                    </div>

                    <div class="col-md-8">

                        <select class="form-control" name="city_id">

                            <option value="">- tỉnh/thành -</option>

                            

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

                        <div class="m-t-sm">Quận/huyện:</div>

                    </div>

                    <div class="col-md-8">

                        <select class="form-control" name="district_id">

                            <option value="">- quận/huyện -</option>

                            

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

                        <div class="m-t-sm">SĐT 1:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="phone_1" placeholder="điện thoại 1" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">SĐT 2:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" name="phone_2" placeholder="điện thoại 2" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                    

                <div class="form-group m-t-sm">

                    <div class="col-md-4">

                        <div class="m-t-sm">Email:</div>

                    </div>

                    <div class="col-md-8">

                        <input type="text" id="email" name="email" placeholder="email" class="form-control"></input>

                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="modal-footer m-t">

                    <a class="btn btn-success" onclick="save_employee_add($(this))"><i class="fa fa-save"></i> lưu</a>

                    <a data-dismiss="modal" style="display:none;">Processing...</a>

                    <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>

                </div>

            </div>

        </div>

        <div class="clearfix m-b"></div>

        <?php

    }

        

    

    

    function load_employee_edit() {

        $id = $this->input->post('id');

        $result = $this->db->where('employee_id', $id)->where('deleted', 0)->get($this->prefix.'employee');

        if ($result->num_rows() == 0) {

            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';

        } else {

            $result = $result->row();

        ?>

            <input type="hidden" name="id" id="id" value="<?php echo $result->employee_id ?>" />

            <div class="modal-body">

                <div class="col-md-6">

                    <h4>Thông tin cơ bản</h4>

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">Mã nhân viên:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="code" value="<?php echo $result->code ?>" placeholder="mã nhân viên" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">Tên nhân viên:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="tên nhân viên" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">Ngày sinh:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="birthday" value="<?php echo format_get_date($result->birthday) ?>" placeholder="ngày sinh" class="form-control datepicker"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">Giới tính:</div>

                        </div>

                        <div class="col-md-8">

                            <div class="radio-list">

                                <label class="radio-inline">

                                <input type="radio" name="gender" value="1" <?php if($result->gender==1) echo 'checked=""'; ?>> Nam </label>

                                <label class="radio-inline">

                                <input type="radio" name="gender" value="2" <?php if($result->gender==2) echo 'checked=""'; ?>> Nữ </label>

                            </div>

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

                            <div class="m-t-sm">Địa chỉ:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="address" value="<?php echo $result->address ?>" placeholder="địa chỉ" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

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

                            <div class="m-t-sm">Tỉnh/thành:</div>

                        </div>

                        <div class="col-md-8">

                            <select class="form-control" name="city_id">

                                <option value="">- tỉnh/thành -</option>

                                    

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

                            <div class="m-t-sm">Quận/huyện:</div>

                        </div>

                        <div class="col-md-8">

                            <select class="form-control" name="district_id">

                                <option value="">- quận/huyện -</option>

                                    

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

                            <div class="m-t-sm">SĐT 1:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="phone_1" value="<?php echo $result->phone_1 ?>" placeholder="điện thoại 1" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">SĐT 2:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" name="phone_2" value="<?php echo $result->phone_2 ?>" placeholder="điện thoại 2" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                        

                    <div class="form-group m-t-sm">

                        <div class="col-md-4">

                            <div class="m-t-sm">Email:</div>

                        </div>

                        <div class="col-md-8">

                            <input type="text" id="email" name="email" value="<?php echo $result->email ?>" placeholder="email" class="form-control"></input>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                    <div class="modal-footer m-t">

                        <a class="btn btn-success" onclick="save_employee_edit($(this))"><i class="fa fa-save"></i> lưu</a>

                        <a data-dismiss="modal" style="display:none;">Processing...</a>

                        <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> huỷ</a>

                    </div>

                </div>

            </div>

            <div class="clearfix m-b"></div>

        <?php

        }

    }

        



}

