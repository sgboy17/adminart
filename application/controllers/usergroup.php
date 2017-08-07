<?php 
	/**
	* 
	*/
	class usergroup extends My_Controller
	{
		
		function __construct() 
		{
			parent::__construct();
			$this->permissionm->check_permission('room');
		}

		function get_user_group_list(){
			$this->usergroupm->get_user_group_list();
		}

		function load_user_group_edit(){
			$this->usergroupm->load_user_group_edit();
		}

		function load_user_group_add(){
			$this->usergroupm->load_user_group_add();
		}

		function save_user_group_edit(){
			$this->usergroupm->save_user_group_edit();
		}

		function save_user_group_add(){
			$this->usergroupm->save_user_group_add();
		}

		function delete_user_group(){
			$this->usergroupm->delete_user_group();
		}


		function user_group_list()
		{
			$data['title'] = 'Nhóm người dùng';
			$this->data['page'] = 'user_group_list';
			$this->data['content'] = $this->load->view('user_group/user_group_list', $data, TRUE);
			$this->_do_admin_output();
		}
	}
?>