<?php

class Settinggeneral extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('settinggeneral');
    }

    /* API */ 
    function get_setting_general_list(){
        $this->settinggeneralm->get_setting_general_list();
    }
    function delete_setting_general(){
        $this->settinggeneralm->delete_setting_general();
    }
    function load_setting_general_add(){
        $this->settinggeneralm->load_setting_general_add();
    }
    function load_setting_general_edit(){
        $this->settinggeneralm->load_setting_general_edit();
    }
    function save_setting_general_add(){
        $this->settinggeneralm->save_setting_general_add();
    }
    function save_setting_general_edit(){
        $this->settinggeneralm->save_setting_general_edit();
    }

    /* Page */ 
    function setting_general_list() {
        $data['title'] = 'Cài đặt';
        
        $this->data['page'] = 'setting_general_list';
        $this->data['content'] = $this->load->view('settinggeneral/setting_general_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
