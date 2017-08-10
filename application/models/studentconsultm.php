<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/24/2017
 * Time: 11:19 AM
 */
class Studentconsultm extends  My_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_items_by_student($studentId){

    }

    function get_last_call_item_from_student($studentId){


        $query = $this->db->select('*')
            ->from($this->prefix . 'student_consult')

            ->where('student_id', $studentId)

            ->where('channel', 0) // Call

            ->order_by('created_at', 'desc')

            ->limit(1)

            ->get();

        if($query->num_rows() > 0){
           return $query->row();
        }

        return null;

    }

    function get_last_meet_item_from_student($studentId){
        $query = $this->db->select('*')
            ->from($this->prefix . 'student_consult')

            ->where('student_id', $studentId)

            ->where('channel', 1) // meet

            ->order_by('created_at', 'desc')

            ->limit(1)

            ->get();

        if($query->num_rows() > 0){
            return $query->row();
        }

        return null;

    }

    function get_last_response_item_from_student($studentId){
        $query = $this->db->select('*')
            ->from($this->prefix . 'student_consult')

            ->where('student_id', $studentId)

            ->where('channel', 2) // response

            ->order_by('created_at', 'desc')

            ->limit(1)

            ->get();

        if($query->num_rows() > 0){
            return $query->row();
        }

        return null;

    }

    function get_student_list_by_seller($sellerId){

        $result_item = $this->db->select('*')
            ->from($this->prefix . 'student')

            ->where("user_id", $sellerId)

            ->get();

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                'id' => $row->student_id,

                'name' => $row->name,

                'code' => $row->student_code,

                'birthday' => $row->birthday

            );

        }


    }

    function get_student_consult_list_by_seller($sellerId){

        $result_item = $this->db->select('*')
            ->from($this->prefix . 'student')

            ->where("user_id", $sellerId)

            ->get();

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();

        $list = array();

        foreach($result_item->result() as $row){

            $list[] = array(

                'id' => $row->student_id,

                'name' => $row->name,

                'code' => $row->student_code,

                'birthday' => $row->birthday,

                'status'  => $row->status

            );

        }

        ////////////////////////////////////

        $data['aaData'] = array();

        $i=-1;

        foreach ($list as $row):

            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

            $student_info_brief = $row['code'] . " " . $row['name'] . " Ngày sinh: "  . $row['birthday'];

            $last_call = $this->get_last_call_item_from_student($row['id'] );

            $last_meet = $this->get_last_meet_item_from_student($row['id']);

            $last_response = $this->get_last_response_item_from_student($row['id']);


            if($row['status']==1) $status = '<span class="text-success">Active</span>';

            else $status = '<span class="text-danger">Inactive</span>';

            $cate = array(

                $student_info_brief,

                $last_call == null? '' : $last_call->content,

                $last_call == null? '' : $last_call->result,

                $last_meet == null? '' : $last_meet->content,

                $last_meet == null? '' : $last_meet->result,

                $last_response == null? '' :  $last_response->content,

                '<a style="margin-right: 5px;" href="#student_consult_detail" data-toggle="modal" onclick="load_student_consult_detail(\'' . $row['id'] . '\');"><span class="label label-info">Xem <i class="fa fa-eye"></span></a>'

            );

            $data['aaData'][] = $cate;

        endforeach;

        echo json_encode($data);

    }


    function load_student_consult_detail()

    {

        $id = $this->input->post('id');

        //get student information
        $student = $this->studentm->get_item_by_id($id);



        if (!isset($student)) {

            echo '<p style="text-align:center;margin-top:10px;">No data found!</p>';

        } else {

            //get last call/ meet/ response
            $last_call = $this->get_last_call_item_from_student($id);

            $last_meet = $this->get_last_meet_item_from_student($id);

            $last_response = $this->get_last_response_item_from_student($id);


?>




            <input type="hidden" name="id" id="id" value="<?php echo $student['student_id'] ?>"/>



            <div class="modal-body">
                <div class="portlet box">

                    <div class="portlet-body">
                        <div class="rơw">
                            <div class="col-sm-4 col-md-4">
                                <div class="portlet box">
                                    <div class="portlet-title ">
                                        <div class="caption">
                                            <span class="caption-subject font-grey-cascade"> Phụ huynh / điện thoại </span>
                                        </div>
                                    </div>

                                    <div class="portlet-body">
                                        <?php echo $student['parent_name']  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="portlet box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-grey-cascade"> Tên học viên </span>
                                        </div>
                                    </div>

                                    <div class="portlet-body">
                                        <?php echo $student['name']  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="portlet box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-grey-cascade"> Ngày sinh </span>
                                        </div>
                                    </div>

                                    <div class="portlet-body">
                                        <?php echo $student['birthday']  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject font-red-sunglo bold uppercase">Báo cáo cuộc gọi</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-5" style="text-align: right">Ngày báo cáo: </label>
                                                        <label class="col-md-7"><?php echo $last_call->created_at ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5" style="text-align: right">Họ tên người gặp: </label>
                                                        <label class="col-md-7"><?php echo $last_call->people_name ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5" style="text-align: right">SĐT người gặp: </label>
                                                        <label class="col-md-7"><?php echo $last_call->people_phone ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5" style="text-align: right">Nội dung trao đổi: </label>
                                                        <label class="col-md-7"><?php echo $last_call->content ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5" style="text-align: right">Kết quả: </label>
                                                        <label class="col-md-7"><?php echo $last_call->result ?></label>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- END FORM-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject font-red-sunglo bold uppercase">Báo cáo lần gặp</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Ngày báo cáo: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->created_at ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Họ tên người gặp: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->people_name ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">SĐT người gặp: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->people_phone ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Nội dung trao đổi: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->content ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Kết quả: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->result ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject font-red-sunglo bold uppercase">Khách hàng trả lời</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Ngày báo cáo: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->created_at ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Kết quả: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->content ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-5" style="text-align: right">Lý do: </label>
                                                    <label class="col-md-7"><?php echo $last_meet->result ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                    </div>

                </div>

                <div class="clearfix"></div>




            </div>


            <div class="modal-footer">

                <button type="button" class="btn btn-default pull-right" style="margin-left: 5px" data-dismiss="modal">Hủy</button>

                <a data-dismiss="modal" style="display:none;">Processing...</a>

                <a href="#student_history" data-toggle="modal" type="button" class="btn btn-info pull-right" style="margin-left: 5px" onclick="load_student_history('<?php echo $id ?>');">Xem lịch sử học</>

                <a href="#student_detail" data-toggle="modal" type="button" class="btn green-meadow pull-right" onclick="load_student_edit('<?php echo $id ?>');">Xem thông tin chi tiết</>

            </div>


            <?php

        }

    }



}

