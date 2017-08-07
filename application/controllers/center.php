<?php

class Center extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('center');
    }

    /* API */ 
    function get_center_list(){
        $this->centerm->get_center_list();
    }
    function delete_center(){
        $this->centerm->delete_center();
    }
    function load_center_add(){
        $this->centerm->load_center_add();
    }
    function load_center_edit(){
        $this->centerm->load_center_edit();
    }
    function save_center_add(){
        $this->centerm->save_center_add();
    }
    function save_center_edit(){
        $this->centerm->save_center_edit();
    }

    /* Page */ 
    function center_list() {
        $data['title'] = 'Trung tâm';
        
        $this->data['page'] = 'center_list';
        $this->data['content'] = $this->load->view('center/center_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
