<?php

class Backup extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('mysqlautobackup');
    }

    function index()
    {
    	$this->mysqlautobackup->index();
    }

    function dump()
    {
        $this->mysqlautobackup->index(true);
    }

}

//------------------------------------
       
