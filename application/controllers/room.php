<?php



class Room extends My_Controller {



    function __construct() {

        parent::__construct();

        $this->permissionm->check_permission('room');

    }



    /* API */ 

    function get_room_list(){

        $this->roomm->get_room_list();

    }

    function delete_room(){

        $this->roomm->delete_room();

    }

    function load_room_add(){

        $this->roomm->load_room_add();

    }

    function load_room_edit(){

        $this->roomm->load_room_edit();

    }

    function save_room_add(){

        $this->roomm->save_room_add();

    }

    function save_room_edit(){

        $this->roomm->save_room_edit();

    }



    /* Page */ 

    function room_list() {

        $data['title'] = 'Phòng học';

        

        $this->data['page'] = 'room_list';

        $this->data['content'] = $this->load->view('room/room_list', $data, TRUE);

        $this->_do_admin_output();

    }

}



//------------------------------------

       

