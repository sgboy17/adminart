<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/17/2017
 * Time: 10:14 AM
 */
class Seller extends My_Controller
{

    /**
     * Seller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->permissionm->check_permission('permission');

    }

    /* API */

    function get_seller_list(){

//        $this->sellerm->get_seller_list();
        $this->userm->get_seller_list();

    }

    function load_seller_add(){

        $this->sellerm->load_seller_add();

    }

    function load_seller_edit(){

        $this->sellerm->load_seller_edit();

    }

    function save_seller_add(){

        $this->sellerm->save_seller_add();

    }

    function save_seller_edit(){

        $this->sellerm->save_seller_edit();

    }

    /* Page */

    function seller_list() {

        $data['title'] = 'Nhân viên sale';

        $this->data['page'] = 'seller_list';  //<<<???

        $this->data['content'] = $this->load->view('seller/seller_list', $data, TRUE);

        $this->_do_admin_output();

    }


    function fly(){
        $this->load->view('test/demo');
    }



}