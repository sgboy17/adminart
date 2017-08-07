<?php

class Invoicedetailm extends My_Model {

	function __construct() {
		parent::__construct();
	}

	function get_items_by_invoice($invoice_id) {
		return $this->db
            ->order_by('order ASC')
            ->where('deleted', 0)
            ->where('invoice_id', $invoice_id)
            ->get($this->prefix . 'invoice_detail')
			->result_array();
	}

}
