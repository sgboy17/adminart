<?php

class Email extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('email');
    }

    /* API */ 
    function get_email_list(){
        $this->emailm->get_email_list();
    }
    function delete_email(){
        $this->emailm->delete_email();
    }
    function load_email_add(){
        $this->emailm->load_email_add();
    }
    function load_email_edit(){
        $this->emailm->load_email_edit();
    }
    function save_email_add(){
        $this->emailm->save_email_add();
    }
    function save_email_edit(){
        $this->emailm->save_email_edit();
    }

    /* Page */ 
    function email_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Email mẫu';
        
        $this->data['page'] = 'setting-tool-email';
        $this->data['content'] = $this->load->view('email/email_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
