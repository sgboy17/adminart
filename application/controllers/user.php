<?php 
	/**
	* 
	*/
	class user extends My_Controller
	{
		
		function __construct() 
		{
			parent::__construct();
			$this->permissionm->check_permission('room');
		}

		function get_user_list(){
			$this->userm->get_user_list();
		}

		function load_user_edit(){
			$this->userm->load_user_edit();
		}

		function load_user_add(){
			$this->userm->load_user_add();
		}

		function save_user_edit(){
			$this->userm->save_user_edit();
		}

		function save_user_add(){
			$this->userm->save_user_add();
		}

		function delete_user(){
			$this->userm->delete_user();
		}


		function user_list()
		{
			$data['title'] = 'Người dùng';
			$this->data['page'] = 'user_list';
			$this->data['content'] = $this->load->view('user/user_list', $data, TRUE);
			$this->_do_admin_output();
		}
	}
?>