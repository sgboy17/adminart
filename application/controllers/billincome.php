<?php

class Billincome extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('billincome');
    }

    /* API */ 
    function get_bill_income_list(){
        $this->billincomem->get_bill_income_list();
    }
    function delete_bill_income(){
        $this->billincomem->delete_bill_income();
    }
    function load_bill_income_add(){
        $this->billincomem->load_bill_income_add();
    }
    function load_bill_income_edit(){
        $this->billincomem->load_bill_income_edit();
    }
    function save_bill_income_add(){
        $this->billincomem->save_bill_income_add();
    }
    function save_bill_income_edit(){
        $this->billincomem->save_bill_income_edit();
    }

    /* Page */ 
    function bill_income_list() {
    $data = array();
    $this->data['title'] = $data['title'] = 'Phiếu thu';

    $this->data['page'] = 'bill-list-income';
    $this->data['content'] = $this->load->view('billincome/bill_income_list', $data, TRUE);
    $this->_do_admin_output();
}

    function bill_income_action() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phiếu thu';
        $data['is_action'] = 1;
        
        $this->data['page'] = 'bill-action-income';
        $this->data['content'] = $this->load->view('billincome/bill_income_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
