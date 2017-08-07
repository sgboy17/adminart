<?php 
	/**
	* 
	*/
	class branch extends My_Controller
	{

	    function __construct()
		{
			parent::__construct();
			$this->permissionm->check_permission('branch');
		}

		function get_branch_list(){
			$this->branchm->get_branch_list();
		}

		function load_branch_edit(){
			$this->branchm->load_branch_edit();
		}

		function load_branch_add(){
			$this->branchm->load_branch_add();
		}

		function save_branch_edit(){
			$this->branchm->save_branch_edit();
		}

		function save_branch_add(){
			$this->branchm->save_branch_add();
		}

		function delete_branch(){
			$this->branchm->delete_branch();
		}


		function branch_list()
		{
			$data['title'] = 'Chi nhánh';
			$this->data['page'] = 'branch_list';
			$this->data['content'] = $this->load->view('branch/branch_list', $data, TRUE);
			$this->_do_admin_output();
		}
	}
?>