<?php

class Centerfee extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('centerfee');
    }

    /* API */ 
    function get_center_fee_list(){
        $this->centerfeem->get_center_fee_list();
    }
    function delete_center_fee(){
        $this->centerfeem->delete_center_fee();
    }
    function load_center_fee_add(){
        $this->centerfeem->load_center_fee_add();
    }
    function load_center_fee_edit(){
        $this->centerfeem->load_center_fee_edit();
    }
    function save_center_fee_add(){
        $this->centerfeem->save_center_fee_add();
    }
    function save_center_fee_edit(){
        $this->centerfeem->save_center_fee_edit();
    }

    /* Page */ 
    function center_fee_list() {
        $data['title'] = 'Chi phí';
        
        $this->data['page'] = 'center_fee_list';
        $this->data['content'] = $this->load->view('centerfee/center_fee_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
