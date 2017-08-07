<?php

class Send extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('send');
    }

    /* API */ 
    function get_send_list(){
        $this->sendm->get_send_list();
    }
    function load_send_add(){
        $this->sendm->load_send_add();
    }
    function save_send_add(){
        $this->sendm->save_send_add();
    }

    /* Page */ 
    function send_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Gửi email & SMS';
        
        $this->data['page'] = 'setting-tool-send';
        $this->data['content'] = $this->load->view('send/send_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
