<?php



class Userm extends My_Model {



    function __construct() {

        parent::__construct();

    }



    function login($name, $pass) {

        $data['success'] = FALSE;

        $user = $this->db->where('username', $name)->where('deleted', 0)->get($this->prefix . 'user');



        if ($user->num_rows() > 0) {

            $user = $user->row();

            if($user->status==2){

                $data['success'] = FALSE;

                $data['message'] = 'Tài khoản của bạn đang tạm khóa!';

                return false;

            }

            if ($this->bcrypt->verify($pass, $user->password)) {

                $data['success'] = TRUE;

                $this->session->set_userdata(array('user' => $user->user_id));

                $this->session->set_userdata(array('user_group' => $user->user_group_id));

                $this->session->set_userdata(array('employee' => $user->employee_id));

                $this->session->set_userdata(array('branch' => $user->branch_id));

                $this->session->set_userdata(array('root_account' => $user->username));

            } else {

                $data['success'] = FALSE;

                $data['message'] = 'Sai tên đăng nhập hoặc mật khẩu!';

            }

        } else {

            $data['success'] = FALSE;

            $data['message'] = 'Sai tên đăng nhập hoặc mật khẩu!';

        }

        return $data;

    }



    function forgot($email) {

        if(!empty($email)){

            $employee = $this->db->where('email', $email)->where('deleted', 0)->get($this->prefix . 'employee');



            if ($employee->num_rows() > 0) {

                $employee = $employee->row();

                $password = substr(md5(time()), 0, 6);

                $this->db->update($this->prefix . 'user',array('password'=>$this->bcrypt->hash($password)),array('employee_id'=>$employee->employee_id));

                $mail = $this->load->view('mail/forgot', array('password'=>$password), true);

                $this->emailm->sendEmailAutomatic($email, 'Mật khẩu mới - MASTERKID', $mail);

            }

        }

    }


    function logout() {

        $this->session->unset_userdata(array('user' => ''));

        $this->session->unset_userdata(array('user_group' => ''));

        $this->session->unset_userdata(array('employee' => ''));

        $this->session->unset_userdata(array('branch' => ''));

        $sub_domain = array_shift((explode(".",$_SERVER['HTTP_HOST'])));

        $is_subdomain = explode('.',$_SERVER['HTTP_HOST']);

        if(count($is_subdomain)==3) $root_url = 'http://'. str_replace($sub_domain.'.', '', $_SERVER['HTTP_HOST']);

        else $root_url = 'http://'. $_SERVER['HTTP_HOST'];

        setcookie('username_login', '', 0, '/', '.'.str_replace('http://', '', $root_url));

    }



    function get_user(){

        $employee = $this->db->where('employee_id', $this->session->userdata('employee'))->get($this->prefix . 'employee')->row();

        if(empty($employee)){

            return array(

                'name' => '',

                'birthday' => '',

                'gender' => '',

                'note' => '',

                'avatar' => '',

                'address' => '',

                'country_id' => '',

                'city_id' => '',

                'district_id' => '',

                'phone_1' => '',

                'phone_2' => '',

                'email' => '',

                );

        }else{

            return array(

                'name' => $employee->name,

                'birthday' => $employee->birthday,

                'gender' => $employee->gender,

                'note' => $employee->note,

                'avatar' => $employee->avatar,

                'address' => $employee->address,

                'country_id' => $employee->country_id,

                'city_id' => $employee->city_id,

                'district_id' => $employee->district_id,

                'phone_1' => $employee->phone_1,

                'phone_2' => $employee->phone_2,

                'email' => $employee->email,

                );

        }

    }



    function save_user($data) {

        $user_id = $this->session->userdata('user');

        $employee_id = $this->session->userdata('employee');

        if (!empty($user_id)) {

            if(!empty($data['password'])){

                $save = $this->db->update($this->prefix .'user', array('password'=>$this->bcrypt->hash($data['password'])), array('user_id' => $user_id));

            }

        }

        if (!empty($employee_id)) {

            $data = array(

                'name' => $data['name'],

                

                'birthday' => format_save_date($data['birthday']),

                

                'gender' => $data['gender'],

                

                'avatar' => $data['avatar'],

                

                'address' => $data['address'],

                

                'country_id' => $data['country_id'],

                

                'city_id' => $data['city_id'],

                

                'district_id' => $data['district_id'],

                

                'phone_1' => $data['phone_1'],

                

                'phone_2' => $data['phone_2'],

                

                'email' => $data['email'],

                );

           $save = $this->db->update($this->prefix .'employee', $data, array('employee_id' => $employee_id));

        }





        if($save):

            $this->session->set_flashdata('message','Cập nhật thành công!');

            redirect(get_slug('index/account',false));

        else:

            $this->session->set_flashdata('message',"Cập nhật không thành công! Vui lòng thử lại!");

            redirect(get_slug('index/account',false));

        endif;

    }



    function get_items(){

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $employee_plan = explode('|', EMPLOYEE_PLAN);

        $employee_limit = $employee_plan[$membership];

        if(!empty($employee_limit)){

            $this->db->limit($employee_limit,0);

        }



        return $this->db->order_by('username ASC')->where('deleted', 0)->get($this->prefix.'user');

    }

    function get_items_by_user_group_id($user_group_id){

        return $this->db->order_by('username ASC')->where('user_group_id', $user_group_id)->where('deleted', 0)->get($this->prefix.'user');

    }



    function get_items_by_branch_id($branch_id){

        return $this->db->where('branch_id', $branch_id)->where('deleted', 0)->get($this->prefix.'user');

    }

    

    function get_item_by_id($id){

        return $this->db->where('user_id', $id)->get($this->prefix .'user')->row_array();

    }


    function get_name($id){

        $result = $this->db->where('user_id', $id)->get($this->prefix .'user')->row_array();

        if(!empty($result)) return $result['username'];

        else return '';

    }

    function get_seller_list(){

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {

            $this->db->where('(username LIKE "%'.$_GET['f_search'].'%")');

        }

        ////////////////////////////////////

        $result_item = $this->db->select('u.*')
            ->from($this->prefix . 'employee e')

            ->join($this->prefix . 'user u', 'e.employee_id = u.employee_id')

            ->join($this->prefix . 'user_group g', 'u.user_group_id = g.user_group_id')

            ->where('g.code', 'S')

            ->get();

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                'id' => $row->user_id,

                'username' => $row->username,

                'password' => $row->password,

                'user_group_id' => $row->user_group_id,

//                'employee_name' => $row->employee_name,

                'employee_id' => $row->employee_id,

                'branch_id' => $row->branch_id,

                'note' => $row->note,

                'status' => $row->status,

            );

        }

        ////////////////////////////////////

        $data['aaData'] = array();

        $i=-1;

        foreach ($list as $row):

            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

            $user_group = $this->usergroupm->get_name($row['user_group_id']);

            $employee_name = $this->employeem->get_name($row['employee_id']);

            $branch_name = $this->branchm->get_name($row['branch_id']);

            $student_count = $this->studentm->count_item_by_user($row['id']);

            if($row['status']==1) $status = '<span class="text-success">Active</span>';

            else $status = '<span class="text-danger">Inactive</span>';

            $cate = array(

                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

                $row['username'],

                $user_group,

                $employee_name,

                $branch_name,

                $student_count,

                '<a href="student_consult_list/'.$row['id'].'"><span class="label label-info">Xem <i class="fa fa-eye"></i></span></a>'

            );

            $data['aaData'][] = $cate;

        endforeach;

        echo json_encode($data);

    }

        
    function get_user_list(){

        $this->db->where('user_id !=', 1);

        

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {

            $this->db->where('(username LIKE "%'.$_GET['f_search'].'%")');

        }

        

        if (isset($_GET['f_user_group_id']) && !empty($_GET['f_user_group_id'])) {

            $this->db->where('user_group_id', $_GET['f_user_group_id']);

        }

                

        if (isset($_GET['f_employee_id']) && !empty($_GET['f_employee_id'])) {

            $this->db->where('employee_id', $_GET['f_employee_id']);

        }

                

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {

            $this->db->where('branch_id', $_GET['f_branch_id']);

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

        

        $result_item = $this->db->where('deleted', 0)->order_by('username ASC')->get($this->prefix.'user');

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                

                'id' => $row->user_id,

        

                'username' => $row->username,

            

                'password' => $row->password,

            

                'user_group_id' => $row->user_group_id,

//                'employee_name' => $row->name,

                'employee_id' => $row->employee_id,

            

                'branch_id' => $row->branch_id,

            

                'note' => $row->note,

            

                'status' => $row->status,

            

                );

        }

        ////////////////////////////////////

        $data['aaData'] = array();

        $i=-1;

        foreach ($list as $row):

             $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

            $user_group = $this->usergroupm->get_name($row['user_group_id']);

            $employee_name = $this->employeem->get_name($row['employee_id']);

            $branch_name = $this->branchm->get_name($row['branch_id']);

             if($row['status']==1) $status = '<span class="text-success">Active</span>';

             else $status = '<span class="text-danger">Inactive</span>';

            $cate = array(

                

                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',

        

                $row['username'],

            

                 $user_group,

                 $employee_name,
            
                 //$row['employee_id'],
//                 $row['employee_name'],

                 $branch_name,
            

                 $row['note'],

            

                 $status,

            

                '<a href="#user_detail" data-toggle="modal" onclick="load_user_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>

                  <a href="javascript:void(0)" onclick="delete_user('.$row['id'].');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'

                );

            $data['aaData'][] = $cate;

        endforeach;

        echo json_encode($data);

    } 


    function delete_user() {

        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $ids = explode(',', $id);

           foreach ($ids as $id){

                if(!empty($id)){

                    $this->db->update($this->prefix.'user', array('deleted'=>1),array('user_id'=>$id));                 

                }

           }

        }

    }

    function save_user_add() {

        $exist_username = $this->db->where('username', $this->input->post('username'))->where('deleted', 0)->get($this->prefix.'user');

        if($exist_username->num_rows()>0){

            echo json_encode(30);
            die;
        }

        $data = array(

            

            'username' => $this->input->post('username'),

            

            'user_group_id' => $this->input->post('user_group_id'),

//            'employee_name' => $this->input->post('employee_name'),
            

            'employee_id' => $this->input->post('employee_id'),

            

            'branch_id' => $this->input->post('branch_id'),

            

            'note' => $this->input->post('note'),

            

            'status' => $this->input->post('status'),

            

            );

        $password = $this->input->post('password');

        if(!empty($password)){

            $data['password'] = $this->bcrypt->hash($this->input->post('password'));

        }

        $save = $this->db->insert($this->prefix.'user', $data);

    }

    function save_user_edit() {

        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $exist_username = $this->db->where('user_id !=',$id)->where('username', $this->input->post('username'))->where('deleted', 0)->get($this->prefix.'user');

            if($exist_username->num_rows()>0){

                echo json_encode(30);
                die;
            }

            $data = array(

                

            'username' => $this->input->post('username'),

            

            'user_group_id' => $this->input->post('user_group_id'),

            
//            'employee_name' => $this->input->post('employee_name'),

            'employee_id' => $this->input->post('employee_id'),

            

            'branch_id' => $this->input->post('branch_id'),

            

            'note' => $this->input->post('note'),

            

            'status' => $this->input->post('status'),

            

                );

            $password = $this->input->post('password');

            if(!empty($password)){

                $data['password'] = $this->bcrypt->hash($this->input->post('password'));

            }

            $save = $this->db->update($this->prefix.'user', $data, array('user_id'=>$id));

        }

    }

    function check_exist_employee_to_user($employee_id, $except_employee_id = 0){

        $user = $this->db->where('employee_id', $employee_id)->where('employee_id !=', $except_employee_id)->where('deleted', 0)->get($this->prefix.'user')->row();

        if(empty($user)) return false;

        else return true;

    }


    function load_user_edit() {
        $id = $this->input->post('id');

        $result = $this->db->where('user_id', $id)->where('deleted', 0)->get($this->prefix.'user');

        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            $employee_name = $this->employeem->get_name($result->employee_id);
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->user_id ?>" />
            <div class="modal-body">
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên đăng nhập:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="username" value="<?php echo $result->username ?>" placeholder="Tên đăng nhập" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mật khẩu:</div>
                </div>
                <div class="col-md-8">
                    <input type="password" name="password" value="" placeholder="mật khẩu" class="form-control"></input>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nhóm người dùng:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="user_group_id">
                        <option value="">- nhóm người dùng -</option>
                        <?php 
                            $user_group_list = $this->usergroupm->get_items();
                            foreach($user_group_list->result() as $row){ ?>
                            <option value="<?php echo $row->user_group_id ?>" <?php if($result->user_group_id==$row->user_group_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
<!--            <div class="form-group m-t-sm">-->
<!--                <div class="col-md-4">-->
<!--                    <div class="m-t-sm">Tên nhân viên:</div>-->
<!--                </div>-->
<!--                <div class="col-md-8">-->
<!--                    <input type="text" name="employee_name" value="--><?php //echo $employee_name ?><!--" placeholder="Tên nhân viên" class="form-control"></input>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                <div class="m-t-sm">Nhân viên:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="employee_id">
                        <option value="">- nhân viên -</option>
                        <?php 
                         $employee_list = $this->employeem->get_items();
                        foreach($employee_list->result() as $row){ 
                            $exist_employee_to_user = $this->userm->check_exist_employee_to_user($row->employee_id, $result->employee_id);

                            if($exist_employee_to_user) continue;
                        ?>
                        <option value="<?php echo $row->employee_id ?>" <?php if($result->employee_id==$row->employee_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
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
                    <textarea name="note" placeholder="Ghi chú" class="form-control"><?php echo $result->note ?></textarea>
                </div>
            </div>
            <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tình trạng:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <option value="">- Tình trạng -</option>
                            <option value="1" <?php if($result->status==1) echo 'selected=""'; ?>>Active</option>
                            <option value="2" <?php if($result->status==2) echo 'selected=""'; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                    <?php $branch_list = $this->branchm->get_items();
                    if($branch_list->num_rows()>0){ ?>
                    <h4>Chi nhánh của người dùng này</h4>
                    <div class="table-container table-responsive m-t">
                        <table class="table table-striped table-bordered table-hover" id="datatable_history">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="25%">Mặc định</th>
                                <th>
                                    Mã chi nhánh
                                </th>
                                <th >
                                    Tên chi nhánh
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($branch_list->result() as $row){ ?>
                                <tr role="row" class="odd">
                                    <td><label><input type="radio" name="branch_id" value="<?php echo $row->branch_id ?>" <?php if($result->branch_id==$row->branch_id) echo 'checked=""'; ?> /> - chọn</label></td>
                                    <td><?php echo $row->code ?></td>
                                    <td><?php echo $row->name ?></td>
                                </tr>
                                <?php } ?>
                        </table>
                    </div>
                    <?php } ?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_user_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
        <?php
        }
    }

    function load_user_add() {
        ?>  
        <div class="modal-body">
        <div class="form-group m-t-sm">
            <div class="col-md-4">
                <div class="m-t-sm">Tên đăng nhập:</div>
            </div>
            <div class="col-md-8">
                <input type="text" name="username" value="" placeholder="Tên đăng nhập" class="form-control"></input>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group m-t-sm">
            <div class="col-md-4">
                <div class="m-t-sm">Mật khẩu:</div>
            </div>
            <div class="col-md-8">
                <input type="password" name="password" value="" placeholder="mật khẩu" class="form-control"></input>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="form-group m-t-sm">
            <div class="col-md-4">
                <div class="m-t-sm">Nhóm người dùng:</div>
            </div>
            <div class="col-md-8">
                <select class="form-control" name="user_group_id">
                    <option value="">- nhóm người dùng -</option>
                    <?php 
                        $user_group_list = $this->usergroupm->get_items();
                        foreach($user_group_list->result() as $row){ ?>
                        <option value="<?php echo $row->user_group_id ?>"><?php echo $row->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
<!--        <div class="clearfix"></div>-->
<!--        <div class="form-group m-t-sm">-->
<!--            <div class="col-md-4">-->
<!--                <div class="m-t-sm">Tên nhân viên:</div>-->
<!--            </div>-->
<!--            <div class="col-md-8">-->
<!--                <input type="text" name="employee_name" value="" placeholder="Tên nhân viên" class="form-control"></input>-->
<!--            </div>-->
<!--        </div>-->
        <div class="clearfix"></div>
        <div class="form-group m-t-sm">
            <div class="col-md-4">
            <div class="m-t-sm">Nhân viên:</div>
            </div>
            <div class="col-md-8">
                <select class="form-control" name="employee_id">
                    <option value="">- nhân viên -</option>
                    <?php
                     $employee_list = $this->employeem->get_items();
                    foreach($employee_list->result() as $row){
                    ?>
                    <option value="<?php echo $row->employee_id ?>"><?php echo $row->name ?></option>
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
                <textarea name="note" placeholder="Ghi chú" class="form-control"></textarea>
            </div>
        </div>
        <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tình trạng:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="status">
                        <option value="">- Tình trạng -</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
                <?php $branch_list = $this->branchm->get_items();
                if($branch_list->num_rows()>0){ ?>
                <h4>Chi nhánh của người dùng này</h4>
                <div class="table-container table-responsive m-t">
                    <table class="table table-striped table-bordered table-hover" id="datatable_history">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="25%">Mặc định</th>
                            <th>
                                Mã chi nhánh
                            </th>
                            <th >
                                Tên chi nhánh
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($branch_list->result() as $row){ ?>
                            <tr role="row" class="odd">
                                <td><label><input type="radio" name="branch_id" value="<?php echo $row->branch_id ?>"/> - chọn</label></td>
                                <td><?php echo $row->code ?></td>
                                <td><?php echo $row->name ?></td>
                            </tr>
                            <?php } ?>
                    </table>
                </div>
                <?php } ?>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_user_add($(this))">Lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>
    <?php
    }
}?>