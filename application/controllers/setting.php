<?php

class Setting extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('setting');
    }

    /* API */ 
    function get_setting_list(){
        $this->settingm->get_setting_list();
    }
    function save_setting_edit(){
        $this->settingm->setting_save();
    }

    /* Page */ 
    function setting_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Cấu hình hệ thống';
        
        $this->data['page'] = 'setting-tool-config';
        $this->data['content'] = $this->load->view('setting/setting_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
