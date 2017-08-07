<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class My_Model extends CI_Model {
    var $table = '';
    var $id = '';
    var $prefix = '';
    function __construct() {
        parent::__construct();
        $this->prefix = $this->db->dbprefix.'_';
    }
}