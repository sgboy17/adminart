<?php

class Studentclass extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('studentclass');
    }

    /* API */ 
    function get_student_class_list(){
        $this->studentclassm->get_student_class_list();
    }
    function delete_student_class(){
        $this->studentclassm->delete_student_class();
    }
    function load_student_class_add(){
        $this->studentclassm->load_student_class_add();
    }
    function load_student_class_edit(){
        $this->studentclassm->load_student_class_edit();
    }
    function save_student_class_add(){
        $this->studentclassm->save_student_class_add();
    }
    function save_student_class_edit(){
        $this->studentclassm->save_student_class_edit();
    }

    /* Page */ 
    function student_class_list() {
        $data['title'] = 'Học viên trong lớp';
        
        $this->data['page'] = 'student_class_list';
        $this->data['content'] = $this->load->view('studentclass/student_class_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
