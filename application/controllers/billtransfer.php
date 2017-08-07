<?php

class Billtransfer extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('billtransfer');
    }

    /* API */ 
    function get_bill_transfer_list(){
        $this->billtransferm->get_bill_transfer_list();
    }
    function delete_bill_transfer(){
        $this->billtransferm->delete_bill_transfer();
    }
    function load_bill_transfer_add(){
        $this->billtransferm->load_bill_transfer_add();
    }
    function load_bill_transfer_edit(){
        $this->billtransferm->load_bill_transfer_edit();
    }
    function save_bill_transfer_add(){
        $this->billtransferm->save_bill_transfer_add();
    }
    function save_bill_transfer_edit(){
        $this->billtransferm->save_bill_transfer_edit();
    }
    function approve_bill_transfer_edit(){
        $this->billtransferm->approve_bill_transfer();
    }
    function unapprove_bill_transfer_edit(){
        $this->billtransferm->unapprove_bill_transfer();
    }

    /* Page */ 
    function bill_transfer_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phiếu chuyển tiền';
        
        $this->data['page'] = 'bill-list-transfer';
        $this->data['content'] = $this->load->view('billtransfer/bill_transfer_list', $data, TRUE);
        $this->_do_admin_output();
    }

    function bill_transfer_action() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Phiếu chuyển tiền';
        $data['is_action'] = 1;
        
        $this->data['page'] = 'bill-action-transfer';
        $this->data['content'] = $this->load->view('billtransfer/bill_transfer_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
