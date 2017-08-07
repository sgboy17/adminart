<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/20/2017
 * Time: 11:46 AM
 */
class test extends My_Controller
{


    /**
     * test constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->permissionm->check_permission('test');

    }

    public function  fly(){
        $this->load->view('test/demo');
    }

    public function index(){
        $this->load->view('test/demo');
    }

}