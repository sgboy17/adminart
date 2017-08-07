<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/17/2017
 * Time: 10:31 AM
 */
class sellerm extends  My_Model
{


    /**
     * sellerm constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    function get_items(){


    }

    function get_seller_list(){

        if (isset($_GET['f_user_group_id']) && !empty($_GET['f_user_group_id'])) {

            $this->db->where('(user_group_id LIKE "%'.$_GET['f_user_group_id'].'%")');

        }

        if (isset($_GET['f_branch_id']) && !empty($_GET['f_branch_id'])) {

            $this->db->where('branch_id', $_GET['f_branch_id']);

        }


        ////////////////////////////////////

        $result_item = $this->db->where('deleted', 0)->where('branch_id', $this->session->userdata('branch'))->order_by('updated_at DESC')->get($this->prefix.'room');



    }
}