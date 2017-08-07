<?php

class Customer extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('customer');
    }

    /* API */ 
    function load_customer_list_view(){
        $this->customerm->get_customer_list_view();
    }
    function get_customer_list(){
        $this->customerm->get_customer_list();
    }
    function delete_customer(){
        $this->customerm->delete_customer();
    }
    function load_customer_add(){
        $this->customerm->load_customer_add();
    }
    function load_customer_edit(){
        $this->customerm->load_customer_edit();
    }
    function save_customer_add(){
        $this->customerm->save_customer_add();
    }
    function save_customer_edit(){
        $this->customerm->save_customer_edit();
    }

    /* Page */ 
    function customer_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Khách hàng';

        if ($this->input->post('export_column') != '') {
            $this->filem->export_file('customer');
        }

        if ($this->input->post('export_location_column') != '') {
            $this->filem->export_file('location');
        }
        
        $this->data['page'] = 'catalog-object-customer';
        $this->data['content'] = $this->load->view('customer/customer_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
