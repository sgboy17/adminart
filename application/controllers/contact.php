<?php

class Contact extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('contact');
    }

    /* API */ 
    function get_contact_list(){
        $this->contactm->get_contact_list();
    }
    function delete_contact(){
        $this->contactm->delete_contact();
    }
    function load_contact_add(){
        $this->contactm->load_contact_add();
    }
    function load_contact_edit(){
        $this->contactm->load_contact_edit();
    }
    function save_contact_add(){
        $this->contactm->save_contact_add();
    }
    function save_contact_edit(){
        $this->contactm->save_contact_edit();
    }

    /* Page */ 
    function contact_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Liên hệ của KH/NCC';
        
        $this->data['page'] = 'catalog-object-contact';
        $this->data['content'] = $this->load->view('contact/contact_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
