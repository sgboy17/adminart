<?php
class My_Controller extends CI_Controller {
    var $data = array();
    var $is_pjax = FALSE;
    var $prefix = '';
    var $enviroment = ENVIRONMENT;
    function __construct() {
        parent::__construct();
        if ($this->input->get_request_header('X-pjax', TRUE) !== FALSE) $this->is_pjax = TRUE;
        $this->prefix = $this->db->dbprefix.'_';
    }
    
    function _do_admin_output(){
            if($this->is_pjax){
                    echo $this->data['content'];
            }
            else {
                $this->load->view('page_full',$this->data);
            }
    }
    
    function _do_static_output(){
            if($this->is_pjax){
                    echo $this->data['content'];
            }
            else {
                $this->load->view('page_full_static',$this->data);
            }
    }
        
}

