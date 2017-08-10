<?php



class Student extends My_Controller {



    function __construct() {

        parent::__construct();

        $this->permissionm->check_permission('student');

    }

    /* API */

    function get_student_list(){

        $this->studentm->get_student_list();

    }

    function delete_student(){

        $this->studentm->delete_student();

    }

    function load_student_add(){

        $this->studentm->load_student_add();

    }

    function load_student_edit(){

        $this->studentm->load_student_edit();

    }

    function save_student_add(){

        $this->studentm->save_student_add();

    }

    function save_student_edit(){

        $this->studentm->save_student_edit();

    }

    function load_student_add_note(){

        $this->studentm->load_student_add_note();

    }

    function save_student_add_note()
    {
        $this->studentm->save_student_add_note();
    }

    function load_student_view_note(){
        $this->studentm->load_student_view_note();
    }

    function load_student_note_list(){
        $this->studentm->load_student_note_list();
    }
    /* Page */

    function student_list() {
        $data['title'] = 'Học viên';
        $this->data['page'] = 'student_list';
        $this->data['content'] = $this->load->view('student/student_list', $data, TRUE);
        $this->_do_admin_output();
    }

    function load_student_action() {

        $this->studentm->load_student_action();

    }

    function load_student_history(){

        $this->studentm->load_student_history();

    }

    function load_branch_change(){

        $this->studentm->load_branch_change();

    }

    function load_transfer_friend() {

        $this->studentm->load_transfer_friend();

    }

    function load_student_branch_transfer() {

        $this->studentm->load_student_branch_transfer();

    }

    function save_student_branch_transfer() {

        $this->studentm->save_student_branch_transfer();

    }

    function load_all_student_branch() {

        $this->studentm->load_all_student_branch();

    }

    function load_all_student_view() {

        $this->studentm->get_all_student_list();

    }

    function check_special_hour() {

        $this->studentm->check_special_hour();

    }

    

   

}



//------------------------------------



