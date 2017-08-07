<?php

class Permission extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('permission');
    }

    /* API */ 
    function get_permission_list(){
        $this->permissionm->get_permission_list();
    }
    function save_permission_edit(){
        $this->permissionm->permission_save();
    }

    /* Page */ 
    function permission_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phân quyền';
        
        $this->data['page'] = 'setting-user-permission';
        $this->data['content'] = $this->load->view('permission/permission_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
