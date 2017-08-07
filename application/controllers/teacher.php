<?php

class Teacher extends My_Controller {

    function __construct() {
        parent::__construct();
        //$this->permissionm->check_permission('teacher');
    }

    /* API */ 
    function get_teacher_list(){
        $this->teacherm->get_teacher_list();
    }
    function delete_teacher(){
        $this->teacherm->delete_teacher();
    }
    function load_teacher_add(){
        $this->teacherm->load_teacher_add();
    }
    function load_teacher_edit(){
        $this->teacherm->load_teacher_edit();
    }
    function save_teacher_add(){
        $this->teacherm->save_teacher_add();
    }
    function save_teacher_edit(){
        $this->teacherm->save_teacher_edit();
    }

    /* Page */ 
    function teacher_list() {
        $data['title'] = 'Giáo viên';
        
        $this->data['page'] = 'education-teacher';
        $this->data['content'] = $this->load->view('teacher/teacher_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
