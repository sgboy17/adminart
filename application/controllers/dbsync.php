<?php

class Dbsync extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

	function run() 
	{
		$cmd = 'php db_sync/db-sync.phar -h';
		exec($cmd, $output);
        echo "<pre>";
        print_r($output);
        echo "</pre>";
	}

	function server()
	{
		// server => local
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_branch --target.table itvsoft_branch.mk_branch -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_branch_fee --target.table itvsoft_branch.mk_branch_fee -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_city --target.table itvsoft_branch.mk_city -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_country --target.table itvsoft_branch.mk_country -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_district --target.table itvsoft_branch.mk_district -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_employee --target.table itvsoft_branch.mk_employee -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_permission --target.table itvsoft_branch.mk_permission -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_program --target.table itvsoft_branch.mk_program -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_program_product --target.table itvsoft_branch.mk_program_product -e -f db_sync/server_local.ini --delete';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_user --target.table itvsoft_branch.mk_user -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_user_group --target.table itvsoft_branch.mk_user_group -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_teacher --target.table itvsoft_branch.mk_teacher -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_date_off --target.table itvsoft_branch.mk_date_off -e -f db_sync/server_local.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_edu_server.mk_event --target.table itvsoft_branch.mk_event -e -f db_sync/server_local.ini';
		shell_exec($cmd);

		// local => server
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_action --target.table itvsoft_edu_server.mk_action -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_change_schedule --target.table itvsoft_edu_server.mk_change_schedule -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_class --target.table itvsoft_edu_server.mk_class -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_class_hour --target.table itvsoft_edu_server.mk_class_hour -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_invoice --target.table itvsoft_edu_server.mk_invoice -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_invoice_detail --target.table itvsoft_edu_server.mk_invoice_detail -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_room --target.table itvsoft_edu_server.mk_room -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_student --target.table itvsoft_edu_server.mk_student -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_student_class --target.table itvsoft_edu_server.mk_student_class -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_student_money --target.table itvsoft_edu_server.mk_student_money -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		$cmd ='php db_sync/db-sync.phar 104.238.149.8 104.238.149.8 itvsoft_branch.mk_student_schedule --target.table itvsoft_edu_server.mk_student_schedule -e -f db_sync/local_server.ini';
		shell_exec($cmd);
		
		echo json_encode(1);
	}

	function local()
	{
		
	}
}

//------------------------------------
       
