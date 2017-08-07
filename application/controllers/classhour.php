<?php

class Classhour extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('classhour');
    }

    /* API */ 
    function get_class_hour_list(){
        $this->classhourm->get_class_hour_list();
    }
    function delete_class_hour(){
        $this->classhourm->delete_class_hour();
    }
    function load_class_hour_add(){
        $this->classhourm->load_class_hour_add();
    }
    function load_class_hour_edit(){
        $this->classhourm->load_class_hour_edit();
    }
    function save_class_hour_add(){
        $this->classhourm->save_class_hour_add();
    }
    function save_class_hour_edit(){
        $this->classhourm->save_class_hour_edit();
    }

    /* Page */ 
    function class_hour_list() {
        $data['title'] = 'Giờ học';
        
        $this->data['page'] = 'class_hour_list';
        $this->data['content'] = $this->load->view('classhour/class_hour_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
