<?php

class Billoutcome extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('billoutcome');
    }

    /* API */ 
    function get_bill_outcome_list(){
        $this->billoutcomem->get_bill_outcome_list();
    }
    function delete_bill_outcome(){
        $this->billoutcomem->delete_bill_outcome();
    }
    function load_bill_outcome_add(){
        $this->billoutcomem->load_bill_outcome_add();
    }
    function load_bill_outcome_edit(){
        $this->billoutcomem->load_bill_outcome_edit();
    }
    function save_bill_outcome_add(){
        $this->billoutcomem->save_bill_outcome_add();
    }
    function save_bill_outcome_edit(){
        $this->billoutcomem->save_bill_outcome_edit();
    }

    /* Page */ 
    function bill_outcome_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phiếu chi';
        
        $this->data['page'] = 'bill-list-outcome';
        $this->data['content'] = $this->load->view('billoutcome/bill_outcome_list', $data, TRUE);
        $this->_do_admin_output();
    }

    function bill_outcome_action() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phiếu chi';
        $data['is_action'] = 1;
        
        $this->data['page'] = 'bill-action-outcome';
        $this->data['content'] = $this->load->view('billoutcome/bill_outcome_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
