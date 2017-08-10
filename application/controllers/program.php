<?php

class Program extends My_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->permissionm->check_permission('program');
    }

    /* API */
    function get_program_list()
    {
        $this->programm->get_program_list();
    }

    function delete_program()
    {
        $this->programm->delete_program();
    }

    function load_program_add()
    {
        $this->programm->load_program_add();
    }

    function load_program_edit()
    {
        $this->programm->load_program_edit();
    }

    function save_program_add()
    {
        $this->programm->save_program_add();
    }

    function save_program_edit()
    {
        $this->programm->save_program_edit();
    }

    function get_program_product_list()
    {
        $this->programm->get_program_product_list();
    }
    function load_program_fee(){

        $this->programm->load_program_fee();

    }
    /* Page */
    function program_list()
    {
        $data['title'] = 'Chương trình';

        $this->data['page'] = 'education-program';
        $this->data['content'] = $this->load->view('program/program_list', $data, TRUE);
        $this->_do_admin_output();

    }
}

//------------------------------------
       
