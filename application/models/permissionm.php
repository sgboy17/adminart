<?php



class Permissionm extends My_Model {



    function __construct() {

        parent::__construct();

    }



    function check_permission($controller = 'index'){

        if(isset($_COOKIE['hot_login'])&&!empty($_COOKIE['hot_login'])){

            $user_login = $this->db->where('username', $_COOKIE['hot_login'])->where('deleted', 0)->get($this->prefix.'user')->row();

            if(!empty($user_login)){

                $this->session->set_userdata(array('user' => $user_login->user_id));

                $this->session->set_userdata(array('user_group' => $user_login->user_group_id));

                $this->session->set_userdata(array('employee' => $user_login->employee_id));

                $this->session->set_userdata(array('branch' => $user_login->branch_id));

            }

            $sub_domain = array_shift((explode(".",$_SERVER['HTTP_HOST'])));

            $is_subdomain = explode('.',$_SERVER['HTTP_HOST']);

            if(count($is_subdomain)==3) $root_url = 'http://'. str_replace($sub_domain.'.', '', $_SERVER['HTTP_HOST']);

            else $root_url = 'http://'. $_SERVER['HTTP_HOST'];

            setcookie('hot_login', '', 0, '/', '.'.str_replace('http://', '', $root_url));

            header('Location: '.base_url());

            die;

        }



        if($this->uri->segment(2) == 'execute'||$this->uri->segment(1) == get_slug('index/logout',false)) return true;

        $user = $this->session->userdata('user');

        $user_group = $this->session->userdata('user_group');

        $employee = $this->session->userdata('employee');

        $branch = $this->session->userdata('branch');



        if(isset($user)&&!empty($user)){

            if($controller=='api') return true;

            if($this->uri->segment(1) == get_slug('index/forgot',false) || 

               $this->uri->segment(1) == get_slug('index/login',false)) 

                redirect(get_slug('index',false));



            $result_item = $this->db->where('user_id', $user)->where('deleted', 0)->get($this->prefix.'permission')->row();

            if(empty($result_item)){

                $result_item = $this->db->where('user_group_id', $user_group)->where('deleted', 0)->get($this->prefix.'permission')->row(); 

            }



            if(!empty($result_item)){ 

                if(!empty($result_item->permission)) $permission = unserialize($result_item->permission);

                else $permission = array();

            }

            else{ 

                $permission = array();

            }



            $has_permission = $this->permissionm->check_permission_crud($permission);

            if(!$has_permission&&$this->uri->rsegments[1].'/'.$this->uri->rsegments[2]!='index/index'){ // Not permission

                redirect(get_slug('index',false));

            }



        }else{ // Not permission

            if($this->uri->segment(1) != '' && 

                $this->uri->segment(1) != get_slug('index',false) && 

                $this->uri->segment(1) != get_slug('index/forgot',false) && 

                $this->uri->segment(1) != get_slug('index/login',false)) 

                redirect(get_slug('index',false));

        }

    }



    function check_permission_crud($permission){

        if(empty($permission)) return true;

        $controller = $this->uri->rsegments[1];

        $action = $this->uri->rsegments[2];



        if(strpos($action, 'list')!==FALSE) $type = 'view';

        else if(strpos($action, 'add')!==FALSE) $type = 'add';

        else if(strpos($action, 'edit')!==FALSE) $type = 'edit';

        else if(strpos($action, 'delete')!==FALSE) $type = 'delete';

        else $type = 'view';



        if($type=='view'&&strpos($action, 'view')===FALSE){

            if(strpos($action,'get_mini_')!==FALSE) return true;

            return $this->permissionm->get_permission_crud($permission, $controller.'/'.str_replace(array('get_mini_','get_'), '', $action), $type);

        }else{

            if(strpos($action, 'view')!==FALSE) $type = 'view';

            foreach($permission as $key=>$row){

                $route = explode('/', $key);

                if(count($route)!=2) continue;

                if($route[0]==$controller&&strpos($key, 'list')!==FALSE){

                    return $row[$type];

                }

            }

        }

        return false;

    }

    

    function get_items(){

        return $this->db->order_by('permission_id DESC')->where('deleted', 0)->get($this->prefix.'permission');

    }

        



    

    function get_item_by_id($id){

        return $this->db->where('permission_id', $id)->get($this->prefix .'permission')->row_array();

    }

        



    function get_route(){

        $route_permission = array();

        require(dirname(dirname(__FILE__)).'/config/routes.php');

        foreach($route as $slug=>$control_action){

            if( $slug=='default_controller' || 

                $slug=='404_override' || 

                $slug=='login' || 

                $slug=='forgot' || 

                $slug=='logout') continue;

            $route_permission[] = array(

                'slug'=>$slug,

                'control_action'=>$control_action

                );

        }

        for($i=0;$i<count($route_permission)-1;$i++){

            for($j=$i+1;$j<count($route_permission);$j++){

                if($route_permission[$i]['slug']>$route_permission[$j]['slug']){

                    $tmp = $route_permission[$i];

                    $route_permission[$i] = $route_permission[$j];

                    $route_permission[$j] = $tmp;

                }

            }

        }

        return $route_permission;

    }



    function get_permission_crud($permission, $control_action, $type){

        if(empty($permission)) return 1;

        if(!isset($permission[$control_action])) return 0;

        if(!isset($permission[$control_action][$type])) return 0;

        else return $permission[$control_action][$type];

    }



    

    function get_permission_list(){

        

        if (isset($_GET['f_user_group_id']) && !empty($_GET['f_user_group_id'])) {

            $result_item = $this->db->where('user_group_id', $_GET['f_user_group_id'])->where('deleted', 0)->get($this->prefix.'permission')->row();

            if(empty($result_item)) $permission_id = 0;

            else $permission_id = $result_item->permission_id;

        }

                

        if (isset($_GET['f_user_id']) && !empty($_GET['f_user_id'])) {

            $result_item = $this->db->where('user_id', $_GET['f_user_id'])->where('deleted', 0)->get($this->prefix.'permission')->row();

            if(empty($result_item)){

                $permission_id = 0;

                $user = $this->db->where('user_id', $_GET['f_user_id'])->get($this->prefix.'user')->row();

                if(!empty($user)){

                   $result_item = $this->db->where('user_group_id', $user->user_group_id)->where('deleted', 0)->get($this->prefix.'permission')->row(); 

                }

            }else{

                $permission_id = $result_item->permission_id;

            }

        }

                

        ////////////////////////////////////

        if((isset($_GET['f_user_group_id']) && !empty($_GET['f_user_group_id']))||(isset($_GET['f_user_id']) && !empty($_GET['f_user_id']))){

            $data['aaData'] = array();

            $all_route = $this->permissionm->get_route();

            $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($all_route);

            if(!empty($result_item)){ 

                if(!empty($result_item->permission)) $permission = unserialize($result_item->permission);

                else $permission = array();

            }

            else{ 

                $permission_id = 0;

                $permission = array();

            }

            $i=-1;

            foreach ($all_route as $row):

                $is_show = true;



                $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;

                $check_view = $this->permissionm->get_permission_crud($permission, $row['control_action'], 'view');

                $check_add = $this->permissionm->get_permission_crud($permission, $row['control_action'], 'add');

                $check_edit = $this->permissionm->get_permission_crud($permission, $row['control_action'], 'edit');

                $check_delete = $this->permissionm->get_permission_crud($permission, $row['control_action'], 'delete');

                

                $view_is_disabled = $add_is_disabled = $edit_is_disabled = $delete_is_disabled = " ";

                if($row['slug'] == "branch_list") {

                    $add_is_disabled = "disabled ";

                    $delete_is_disabled = "disabled ";

                    $check_add = false;

                    $check_delete = false;

                }

                else if(in_array($row['slug'], array("branch_root_list","branch_type_list"))) {

                    $is_show = false;

                }



                if($is_show) {

                    $cate = array(

                        $row['slug'],



                        '<div class="checkbox-list"><label><input '.$view_is_disabled.($check_view?'checked="checked"':'').' type="checkbox" value="'.$row['control_action'].'|view|'.$permission_id.'" class="id_view" /></label></div>',



                        '<div class="checkbox-list"><label><input '.$add_is_disabled.($check_add?'checked="checked"':'').' type="checkbox" value="'.$row['control_action'].'|add|'.$permission_id.'" class="id_add" /></label></div>',



                        '<div class="checkbox-list"><label><input '.$edit_is_disabled.($check_edit?'checked="checked"':'').' type="checkbox" value="'.$row['control_action'].'|edit|'.$permission_id.'" class="id_edit" /></label></div>',



                        '<div class="checkbox-list"><label><input '.$delete_is_disabled.($check_delete?'checked="checked"':'').' type="checkbox" value="'.$row['control_action'].'|delete|'.$permission_id.'" class="id_delete" /></label></div>',



                        );

                    $data['aaData'][] = $cate;

                }

            endforeach;

        }else{

            $data['aaData'] = array();

            $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = 0;

        }

        

        echo json_encode($data);

    } 

        

	

    function permission_save() {

        $permission_view = $this->input->post('permission_view');

        $permission_add = $this->input->post('permission_add');

        $permission_edit = $this->input->post('permission_edit');

        $permission_delete = $this->input->post('permission_delete');

        $user_group_id = $this->input->post('user_group_id');

        $user_id = $this->input->post('user_id');

        if($permission_view&&$permission_add&&$permission_edit&&$permission_delete) {

            $permission_view = explode(',', $permission_view);

            $permission_add = explode(',', $permission_add);

            $permission_edit = explode(',', $permission_edit);

            $permission_delete = explode(',', $permission_delete);

            $data = array();

            $permission_id = 0;

            foreach($permission_view as $key=>$row){

                $view = explode('-', $row);

                $add = explode('-', $permission_add[$key]);

                $edit = explode('-', $permission_edit[$key]);

                $delete = explode('-', $permission_delete[$key]);

                if(count($view)!=2) return false;

                $value = explode('|', $view[0]);

                if(count($value)!=3) return false;

                $permission_id = $value[2];

                $data[$value[0]] = array(

                    'view' => $view[1],

                    'add' => $add[1],

                    'edit' => $edit[1],

                    'delete' => $delete[1],

                    );

            }

            $result_item = $this->db->where('permission_id', $permission_id)->get($this->prefix.'permission')->row();

            if(empty($result_item)){

                if(!empty($user_group_id)){

                    $all_route = $this->permissionm->get_route();

                    foreach($all_route as $row){

                        if(!isset($data[$row['control_action']])){

                            $data[$row['control_action']] = array(

                                'view' => 1,

                                'add' => 1,

                                'edit' => 1,

                                'delete' => 1,

                                );

                        }

                    }

                }

                if(!empty($user_id)){

                    $user = $this->db->where('user_id', $user_id)->get($this->prefix.'user')->row();

                    if(!empty($user)){

                       $permission_user_group = $this->db->where('user_group_id', $user->user_group_id)->where('deleted', 0)->get($this->prefix.'permission')->row(); 

                        if(!empty($permission_user_group)){ 

                            if(!empty($permission_user_group->permission)) $permission = unserialize($permission_user_group->permission);

                            else $permission = array();

                            foreach($permission as $key=>$row){

                                if(!isset($data[$key])) $data[$key] = $row;

                            }

                        }

                    }

                }

                $this->db->insert($this->prefix.'permission',

                    array(

                        'user_group_id'=>$user_group_id,

                        'user_id'=>$user_id,

                        'permission'=>serialize($data)

                        ));

            }else{

                if(!empty($result_item->permission)) $permission = unserialize($result_item->permission);

                else $permission = array();

                foreach($permission as $key=>$row){

                    if(!isset($data[$key])) $data[$key] = $row;

                }

                $this->db->update($this->prefix.'permission',

                    array(

                        'user_group_id'=>$user_group_id,

                        'user_id'=>$user_id,

                        'permission'=>serialize($data)

                        ),

                    array('permission_id'=>$permission_id));

            }

        }

    }

        

    

    



}

