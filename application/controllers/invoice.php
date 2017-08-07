<?php

class Invoice extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('invoice');
    }

    /* API */
    function get_invoice_list(){
        $this->invoicem->get_invoice_list();
    }
    function delete_invoice(){
        $this->invoicem->delete_invoice();
    }
    function load_invoice_add(){
        $this->invoicem->load_invoice_add();
    }
    function load_invoice_edit(){
        $this->invoicem->load_invoice_edit();
    }
    function save_invoice_add(){
        $this->invoicem->save_invoice_add();
    }
    function save_invoice_edit(){
        $this->invoicem->save_invoice_edit();
    }
    function load_print($id = null){
        $this->invoicem->load_print($id);
    }
    function load_invoice_action(){
        $this->invoicem->load_invoice_action();
    }

    /* Page */
    function invoice_list() {
        $data['title'] = 'Phiếu đăng ký học';

        $this->data['page'] = 'invoice_list';
        $this->data['content'] = $this->load->view('invoice/invoice_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------

