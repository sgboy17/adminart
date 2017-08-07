<?php

class Dateoff extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('dateoff');
    }

    /* API */ 
    function get_date_off_list(){
        $this->dateoffm->get_date_off_list();
    }
    function delete_date_off(){
        $this->dateoffm->delete_date_off();
    }
    function load_date_off_add(){
        $this->dateoffm->load_date_off_add();
    }
    function load_date_off_edit(){
        $this->dateoffm->load_date_off_edit();
    }
    function save_date_off_add(){
        $this->dateoffm->save_date_off_add();
    }
    function save_date_off_edit(){
        $this->dateoffm->save_date_off_edit();
    }

    /* Page */ 
    function date_off_list() {
        $data['title'] = 'Ngày nghỉ';
        
        $this->data['page'] = 'education-dateoff';
        $this->data['content'] = $this->load->view('dateoff/date_off_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
