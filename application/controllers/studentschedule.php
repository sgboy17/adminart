<?php

class Studentschedule extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('studentschedule');
    }

    /* API */
    function get_student_schedule_list(){
        $this->studentschedulem->get_student_schedule_list();
    }
    function delete_student_schedule(){
        $this->studentschedulem->delete_student_schedule();
    }
    function load_student_schedule_add(){
        $this->studentschedulem->load_student_schedule_add();
    }
    function load_student_schedule_edit(){
        $this->studentschedulem->load_student_schedule_edit();
    }
    function save_student_schedule_add(){
        $this->studentschedulem->save_student_schedule_add();
    }
    function save_student_schedule_edit(){
        $this->studentschedulem->save_student_schedule_edit();
    }
    function load_student_schedule(){
        $this->studentschedulem->load_student_schedule();
    }
    function load_change_schedule(){
        $this->studentschedulem->load_change_schedule();
    }
    function save_change_schedule(){
        $this->studentschedulem->save_change_schedule();
    }



    /* Page */
    function student_schedule_list() {
        $data['title'] = 'Thời khoá biểu';

        $this->data['page'] = 'student_schedule_list';
        $this->data['content'] = $this->load->view('studentschedule/student_schedule_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------

