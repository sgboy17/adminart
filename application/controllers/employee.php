<?php

class Employee extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->permissionm->check_permission('employee');
    }

    /* API */ 
    function get_employee_list(){
        $this->employeem->get_employee_list();
    }
    function delete_employee(){
        $this->employeem->delete_employee();
    }
    function load_employee_add(){
        $this->employeem->load_employee_add();
    }
    function load_employee_edit(){
        $this->employeem->load_employee_edit();
    }
    function save_employee_add(){
        $this->employeem->save_employee_add();
    }
    function save_employee_edit(){
        $this->employeem->save_employee_edit();
    }

    /* Page */ 
    function employee_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Nhân viên';

        if ($this->input->post('export_column') != '') {
            $this->filem->export_file('employee');
        }

        if ($this->input->post('export_location_column') != '') {
            $this->filem->export_file('location');
        }
        
        $this->data['page'] = 'catalog-object-user';
        $this->data['content'] = $this->load->view('employee/employee_list', $data, TRUE);
        $this->_do_admin_output();
    }
}

//------------------------------------
       
