<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/24/2017
 * Time: 4:03 PM
 */
class Studentconsult extends My_Controller
{


    /**
     * Studentconsult constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

//    function student_consult_list($seller_id)
//    {
//
//        $employee_name = $this->empoloyeem->get_name_by_user($seller_id);
//
//        $data['title'] = "Học viên của nhân viên sale " + $employee_name + " phụ trách";
//
//        $this->data['content'] = $this->load->view('studentconsult/student_consult_list', $data, TRUE);
//
//        $this->data['page'] = 'student_consult_list';
//
//    }
    function get_student_consult_list($seller='')
    {
        $this->studentconsultm->get_student_consult_list_by_seller($seller);
    }

    function load_student_consult_detail()
    {
        $this->studentconsultm->load_student_consult_detail();
    }


    function student_consult_list($seller='')
    {

        $employee_name = $this->employeem->get_name_by_user($seller);

        $data['title'] = "Học viên của nhân viên sale '" . $employee_name .  "' phụ trách";

        $this->data['content'] = $this->load->view('studentconsult/student_consult_list', $data, TRUE);

        $this->data['page'] = 'student_consult_list';

        $this->data['id'] = $seller;

        $this->_do_admin_output();

    }
}