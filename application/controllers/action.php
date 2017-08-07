<?php

class Action extends My_Controller {

    function __construct() {
        parent::__construct();
       $this->permissionm->check_permission('action');
    }

    /* API */
    function get_action_list(){
        $this->actionm->get_action_list();
    }
    function delete_action(){
        $this->actionm->delete_action();
    }
    function load_action_add(){
        $this->actionm->load_action_add();
    }
    function load_action_edit(){
        $this->actionm->load_action_edit();
    }
    function save_action_add(){
        $this->actionm->save_action_add();
    }
    function save_action_edit(){
        $this->actionm->save_action_edit();
    }
    function save_branch_change(){
        $this->actionm->save_branch_change();
    }
    function save_transfer_friend(){
        $this->actionm->save_transfer_friend();
    }

    /* Page */
    function action_list() {
        $data['title'] = 'Thao tác';

        $this->data['page'] = 'action_list';
        $this->data['content'] = $this->load->view('action/action_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------

