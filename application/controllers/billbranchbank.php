<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/28/2017
 * Time: 5:15 PM
 */
class Billbranchbank extends My_Controller
{
    /**
     * banktransfer constructor.
     */
    public function __construct()
    {

        parent:: __construct();

    }

    public function get_bill_branch_list()

    {
        $this->billbranchm->get_bill_group_branch_list();
    }

    public function get_bill_bank_list()

    {
        $this->billbankm->get_bill_group_bank_list();
    }

    function bill_branch_bank_list() {
        $data = array();
        $this->data['title'] = $data['title'] = 'Quỹ tiền mặt';

        $this->data['page'] = 'bill-list-branch-bank';
        $this->data['content'] = $this->load->view('billbranchbank/bill_branch_bank_list', $data, TRUE);
        $this->_do_admin_output();
    }


}