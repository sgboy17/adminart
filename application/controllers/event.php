<?php

class Event extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('event');
    }

    /* API */ 
    function get_event_list(){
        $this->eventm->get_event_list();
    }
    function delete_event(){
        $this->eventm->delete_event();
    }
    function load_event_add(){
        $this->eventm->load_event_add();
    }
    function load_event_edit(){
        $this->eventm->load_event_edit();
    }
    function save_event_add(){
        $this->eventm->save_event_add();
    }
    function save_event_edit(){
        $this->eventm->save_event_edit();
    }

    /* Page */ 
    function event_list() {
        $data['title'] = 'Sự kiện Marketing';
        
        $this->data['page'] = 'education-event';
        $this->data['content'] = $this->load->view('event/event_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
