<?php



class Index extends My_Controller {



    function __construct() {

        parent::__construct();

        $this->permissionm->check_permission('index');

    }





    /* Login */

    function login() {

        $data = array();

        if ($this->input->post('username') != '') {

        

            $data = $this->userm->login($this->input->post('username'), $this->input->post('password'));

        

            if ($data['success'] == TRUE) {



                if (isset($_GET['return'])) {

                    redirect(str_replace('.html', '', $_GET['return']));

                }



                redirect(get_slug('student/student_list',false));

            }



            $data['username'] = $this->input->post('username');

            $data['password'] = $this->input->post('password');

        }

        $this->load->view('index/login', $data);

    }



    /* Forgot Password */

    function forgot() {

        $data = array();

        if ($this->input->post('email') != '') {

            $data = $this->userm->forgot($this->input->post('email'));

            $data['info'] = TRUE;

        }

        $this->load->view('index/login', $data);

    }



    /* Logout */

    function logout() {

        $this->userm->logout();

        redirect(get_slug('index/login',false));

    }



    /* Dashboard */

    function index() {

        

        $user = $this->session->userdata('user');

        if(empty($user)) redirect(get_slug('index/login',false));



        $data = array();

        $this->data['title'] = $data['title'] = 'Dashboard';

        $this->data['page'] = 'index';

        

        $this->data['content'] = $this->load->view('index/index', $data, TRUE);

        $this->_do_admin_output();

    }



    /* Account */

    function account() {

        $data['title'] = 'Tài khoản của tôi';

        

        if($this->input->post('email')):

            $exist_email = $this->db->where('email', $this->input->post('email'))->where('employee_id !=', $this->session->userdata('employee'))->where('deleted', 0)->get($this->prefix.'employee');

            if($exist_email->num_rows()>0){

                $data['error_email'] = 'Email này đã được sử dụng!';

            } else {

                $save = $this->userm->save_user($this->input->post(NULL, TRUE));

            }

        endif;

        if($this->session->flashdata('message')):

            $data['message'] = $this->session->flashdata('message');

        endif;



        $this->data['page'] = 'account';

        $this->data['content'] = $this->load->view('index/account', $data, TRUE);

        $this->_do_admin_output();

    }



}



//------------------------------------

       

