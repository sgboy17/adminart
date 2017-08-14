<?php



class Branchm extends My_Model {



    function __construct() {

        parent::__construct();

    }



    

    function get_items(){

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $branch_plan = explode('|', BRANCH_PLAN);

        $branch_limit = $branch_plan[$membership];

        if(!empty($branch_limit)){

            $this->db->limit($branch_limit,0);

        }



        return $this->db->order_by('name ASC')->where('deleted', 0)->get($this->prefix.'branch');

    }



    

    function get_items_by_owner(){

        // Plan Membership

        $membership = $this->session->userdata('membership');

        $branch_plan = explode('|', BRANCH_PLAN);

        $branch_limit = $branch_plan[$membership];

        if(!empty($branch_limit)){

            $this->db->limit($branch_limit,0);

        }



        return $this->db->order_by('name ASC')->where('employee_id', $this->session->userdata('employee'))->where('deleted', 0)->get($this->prefix.'branch');

    }



    

    function get_item_by_id($id){

        return $this->db->where('branch_id', $id)->get($this->prefix .'branch')->row_array();

    }

        



    

    function get_name($id, $default = ''){

        $result = $this->db->where('branch_id', $id)->get($this->prefix .'branch')->row_array();

        if(!empty($result)) return $result['name'];

        else return $default;

    }



    function get_first_branch(){

        return $this->db->where('deleted', 0)->get($this->prefix.'branch')->row_array();

    }

        



    

    function get_branch_list(){

        

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {

            $this->db->where('(name LIKE "%'.$_GET['f_search'].'%")');

        }

        

        if (isset($_GET['f_store_id']) && !empty($_GET['f_store_id'])) {

            $this->db->where('store_id', $_GET['f_store_id']);

        }

                

        if (isset($_GET['f_branch_type_id']) && !empty($_GET['f_branch_type_id'])) {

            $this->db->where('branch_type_id', $_GET['f_branch_type_id']);

        }

                

        if (isset($_GET['f_employee_id']) && !empty($_GET['f_employee_id'])) {

            $this->db->where('employee_id', $_GET['f_employee_id']);

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

        $branch_plan = explode('|', BRANCH_PLAN);

        $branch_limit = $branch_plan[$membership];

        if(!empty($branch_limit)){

            $this->db->limit($branch_limit,0);

        }



        $result_item = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix.'branch');

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                

                'id' => $row->branch_id,

        

                'store_id' => $row->store_id,

            

                'code' => $row->code,

            

                'name' => $row->name,

            

                'branch_type_id' => $row->branch_type_id,

            

                'employee_id' => $row->employee_id,

            

                'note' => $row->note,

            

                'country_id' => $row->country_id,

            

                'city_id' => $row->city_id,

            

                'district_id' => $row->district_id,

            

                'address' => $row->address,

            

                'email' => $row->email,

            

                'phone' => $row->phone,

            

                'fax' => $row->fax,

            

                'website' => $row->website,

            

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

//            if(!empty($row['address'])) $address = $row['address'].', '.$this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);
//
//            else $address = $this->districtm->get_name($row['district_id']).', '.$this->citym->get_name($row['city_id']);

            $cate = array(

                

                '<div class="checkbox-list"><label><input type="checkbox" value="'.$row['id'].'" class="id" /></label></div>',



                $row['name'],

            

//                $address,
                $row['address'],



                $row['phone'],



                $status,

            

                '<a href="#branch_detail" data-toggle="modal" onclick="load_branch_edit('.$row['id'].');"><span class="label label-info">Sửa <i class="fa fa-edit"></i></span></a>
                <a href="javascript:;" onclick="delete_branch(\''.$row['id'].'\');"><span class="label label-danger">Xoá <i class="fa fa-times"></i></span></a>'

                );

            $data['aaData'][] = $cate;

        endforeach;

        echo json_encode($data);

    } 

        

	

	

    function delete_branch() {

        if ($this->input->post('id')) {

            $id = $this->input->post('id');

            $ids = explode(',', $id);

            $user_has_branch = array();

            foreach ($ids as $id){

                if(!empty($id)){

                    $this->db->update($this->prefix.'branch', array('deleted'=>1),array('branch_id'=>$id));

                    $user = $this->userm->get_items_by_branch_id($id);

                    foreach($user->result() as $row){

                        $user_has_branch[] = $row;

                    }

                }

            }

            $branch = $this->branchm->get_first_branch();

            if(empty($branch)) $branch_id = 0;

            else $branch_id = $branch['branch_id'];

            foreach($user_has_branch as $row){

                $this->db->update($this->prefix.'user', array('branch_id'=>$branch_id), array('user_id'=>$row->user_id));

                if($row->user_id==$this->session->userdata('user')&&$row->branch_id==$this->session->userdata('branch')){

                    $this->session->set_userdata(array('branch' => $branch_id));

                    echo 'BRANCH';

                }

            }

        }

    }

        

    

    

    function save_branch_add() {

        $data = array(

            

            'store_id' => $this->input->post('store_id'),

            

            'code' => $this->input->post('code'),

            

            'name' => $this->input->post('name'),

            

            'branch_type_id' => $this->input->post('branch_type_id'),

            

            'employee_id' => $this->input->post('employee_id'),

            

            'note' => $this->input->post('note'),

            

            'country_id' => $this->input->post('country_id'),

            

            'city_id' => $this->input->post('city_id'),

            

            'district_id' => $this->input->post('district_id'),

            

            'address' => $this->input->post('address'),

            

            'email' => $this->input->post('email'),

            

            'phone' => $this->input->post('phone'),

            

            'fax' => $this->input->post('fax'),

            

            'website' => $this->input->post('website'),

            

            'status' => $this->input->post('status'),


            'special_hour' => $this->input->post('special_hour'),


            'fee_change_branch' => $this->input->post('fee_change_branch'),


            'fee_change_hour' => $this->input->post('fee_change_hour')
            

            );

        $save = $this->db->insert($this->prefix.'branch', $data);



        $branch_id = $this->db->insert_id();

        $user = $this->userm->get_items_by_branch_id(0);

        foreach($user->result() as $row){

            $this->db->update($this->prefix.'user', array('branch_id'=>$branch_id), array('user_id'=>$row->user_id));

            if($row->user_id==$this->session->userdata('user')){

                $this->session->set_userdata(array('branch' => $branch_id));

                echo 'BRANCH';

            }

        }

    }


    function load_branch_add(){
        ?>
        <div class="modal-body">
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên chi nhánh:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="name" value="" placeholder="Tên chi nhánh" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
             <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Phụ thu giờ vàng:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="special_hour" value="" placeholder="Phụ thu giờ vàng" class="form-control allownumericwithdecimal"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Phụ thu chuyển trung tâm:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="fee_change_branch" value="" placeholder="Phụ thu chuyển trung tâm" class="form-control allownumericwithdecimal"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Phụ thu chuyển giờ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="fee_change_hour" value="" placeholder="Phụ thu chuyển giờ" class="form-control allownumericwithdecimal"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Địa chỉ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="address" value="" placeholder="Địa chỉ" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Điện thoại:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="phone" value="" placeholder="Điện thoại:" class="form-control"></input>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Tên người liên hệ:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="employee_id">
                        <option value="">- nhân viên -</option>
                        <?php
                        $employee_list = $this->employeem->get_items();
                        foreach($employee_list->result() as $row){
                            ?>
                            <option value="<?php echo $row->employee_id ?>" ><?php echo $row->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">ĐT người liên hệ:</div>
                </div>
                <div class="col-md-8">
                    <input type="text" name="employee_phone"  placeholder="ĐT người liên hệ:" class="form-control" disabled></input>
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
        </div>
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_branch_add($(this))"><i class="fa fa-save"></i> lưu</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <script>
            $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {
                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            })
        </script>
        <?php
    }

    function save_branch_edit() {

        if ($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array(
            'name' => $this->input->post('name'),
            'special_hour' => $this->input->post('special_hour'),
            'fee_change_branch' => $this->input->post('fee_change_branch'),
            'fee_change_hour' => $this->input->post('fee_change_hour'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'employee_id' => $this->input->post('employee_id'),
//            'employee_name' => $this->input->post('employee_name'),
//            'employee_phone' => $this->input->post('employee_phone'),
            'status' => $this->input->post('status'),
            );

            $save = $this->db->update($this->prefix.'branch', $data, array('branch_id'=>$id));

        }

    }

    function load_branch_edit() {
        $id = $this->input->post('id');
        $result = $this->db->where('branch_id', $id)->where('deleted', 0)->get($this->prefix.'branch');
        if ($result->num_rows() == 0) {
            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';
        } else {
            $result = $result->row();
            $employee_name = $this->employeem->get_name($result->employee_id);
            $employee_phone = $this->employeem->get_phone($result->employee_id);
        ?>
            <input type="hidden" name="id" id="id" value="<?php echo $result->branch_id ?>" />
            <div class="modal-body">
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên chi nhánh:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="name" value="<?php echo $result->name ?>" placeholder="Tên chi nhánh" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                 <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Phụ thu giờ vàng:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="special_hour" value="<?php echo $result->special_hour ?>" placeholder="Phụ thu giờ vàng" class="form-control allownumericwithdecimal"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Phụ thu chuyển trung tâm:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="fee_change_branch" value="<?php echo $result->fee_change_branch ?>" placeholder="Phụ thu chuyển trung tâm" class="form-control allownumericwithdecimal"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Phụ thu chuyển giờ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="fee_change_hour" value="<?php echo $result->fee_change_hour ?>" placeholder="Phụ thu chuyển giờ" class="form-control allownumericwithdecimal"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Địa chỉ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="address" value="<?php echo $result->address ?>" placeholder="Địa chỉ" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Điện thoại:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="phone" value="<?php echo $result->phone ?>" placeholder="Điện thoại:" class="form-control" ></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên người liên hệ:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="employee_id">
                            <option value="">- nhân viên -</option>
                            <?php
                            $employee_list = $this->employeem->get_items();
                            foreach($employee_list->result() as $row){
                                ?>
                                <option value="<?php echo $row->employee_id ?>" <?php if($result->employee_id==$row->employee_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">ĐT người liên hệ:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="employee_phone" value="<?php echo $employee_phone ?>" placeholder="ĐT người liên hệ:" class="form-control" disabled></input>
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
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>

            <div class="modal-footer">
                <a class="btn btn-success" onclick="save_branch_edit($(this))">Lưu</a>
                <a data-dismiss="modal" style="display:none;">Processing...</a>
                <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
            </div>
            <script>
                $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {
                    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                })
            </script>
        <?php
        }
    }
}?>