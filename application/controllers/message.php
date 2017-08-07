<?php

class Message extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('message');
    }

    /* API */ 
    function get_message_list(){
        $this->messagem->get_message_list();
    }
    function delete_message(){
        $this->messagem->delete_message();
    }
    function load_message_add(){
        $this->messagem->load_message_add();
    }
    function load_message_edit(){
        $this->messagem->load_message_edit();
    }
    function save_message_add(){
        $this->messagem->save_message_add();
    }
    function save_message_edit(){
        $this->messagem->save_message_edit();
    }

    /* Page */ 
    function message_list() {
        $data['title'] = 'Thông báo';
        
        $this->data['page'] = 'message_list';
        $this->data['content'] = $this->load->view('message/message_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
