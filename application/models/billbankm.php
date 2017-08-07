<?php

/**
 * Created by PhpStorm.
 * User: NghiaPV
 * Date: 7/31/2017
 * Time: 1:08 PM
 */
class billbankm extends My_Model
{

    /**
     * billbankm constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    function get_bill_group_bank_list(){
        $result_item = $this->db->select('branch_id, bank_id, sum(price) as bank_price')
            ->from($this->prefix.'bill_bank')
            ->group_by('branch_id, bank_id')
            ->get();
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        $total_bank_price = 0;
        foreach($result_item->result() as $row){
            $total_bank_price += $row->bank_price;
            $list[] = array(

                'branch_id' => $row->branch_id,

                'bank_id' => $row->bank_id,

                'price' => $row->bank_price,

            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $branch_name = $this->branchm->get_name($row['branch_id']);
            $bank = $this->db->where('bank_id', $row['bank_id'])->get($this->prefix .'bank')->row_array();
            $cate = array(

                $branch_name,

                $bank['name'],

                $row['price'],

            );
            $data['aaData'][] = $cate;
        endforeach;
        $data['aaData'][] = array('','<b class="text-danger">Tổng cộng:</b>','<b class="text-danger">'.$this->currencym->format_currency($total_bank_price).'</b>');
        echo json_encode($data);

    }
}