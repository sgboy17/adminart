<?php 

  $user = $this->session->userdata('user');

  $user_group = $this->session->userdata('user_group');

  $employee = $this->session->userdata('employee');

  $branch = $this->session->userdata('branch');

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

  $controller = $this->uri->rsegments[1];

  $action = $this->uri->rsegments[2];

  if(TOKEN_ROOT ===1 && in_array($action, array("branch_type_list","branch_root_list"))) {

    $add = $edit = $delete = 1;

  } else {

    $add = $this->permissionm->get_permission_crud($permission, $controller.'/'.$action, 'add');

    $edit = $this->permissionm->get_permission_crud($permission, $controller.'/'.$action, 'edit');

    $delete = $this->permissionm->get_permission_crud($permission, $controller.'/'.$action, 'delete');

  }

  ?>

  <script type="text/javascript">

  function set_permission_btn(){

    var btn = $('button.btn, a.btn, span.label');

    for(var i=0;i<btn.length;i++){

      <?php if($add==0){ ?>

      if($(btn[i]).text().toLowerCase().indexOf('thêm')!=-1) $(btn[i]).remove();

      <?php } ?>

      <?php if($edit==0){ ?>

      if($(btn[i]).text().toLowerCase().indexOf('sửa')!=-1) $(btn[i]).remove();

      <?php } ?>

      <?php if($delete==0){ ?>

      if($(btn[i]).text().toLowerCase().indexOf('xoá')!=-1) $(btn[i]).remove();

      <?php } ?>

    }



    <?php 

    $all_route = $this->permissionm->get_route();

    foreach($all_route as $row){

      $view = $this->permissionm->get_permission_crud($permission, $row['control_action'], 'view');



      if(TOKEN_ROOT != 1) {

      if($view==0){ ?>

        $('.navbar-nav a[href="<?php echo get_slug($row['control_action']) ?>"], .dropdown-user a[href="<?php echo get_slug($row['control_action']) ?>"]').parent().remove();

    <?php } }

    }

    ?>

    var sub_menu = $('.sub-menu');

    for(var i=0;i<sub_menu.length;i++){

     if($.trim($(sub_menu[i]).text()).length==0) $(sub_menu[i]).parent().remove();

    }

  }

  set_permission_btn();

  // Handles custom checkboxes & radios using jQuery Uniform plugin

  var handleUniform = function() {

      if (!$().uniform) {

          return;

      }

      var test = $("input[type=checkbox]:not(.toggle, .make-switch, .icheck), input[type=radio]:not(.toggle, .star, .make-switch, .icheck)");

      if (test.size() > 0) {

          test.each(function() {

              if ($(this).parents(".checker").size() === 0) {

                  $(this).show();

                  $(this).uniform();

              }

          });

      }

      if($('form select:not([style*="display: none"]), .modal-body > div select:not([style*="display: none"])').not('.not-uniform').length) $('form select:not([style*="display: none"]), .modal-body > div select:not([style*="display: none"])').not('.not-uniform').select2();

      if($('form input.datepicker').length) $('form input.datepicker').datepicker({format:'dd/mm/yyyy',autoclose:true});

      if($('form input.timepicker').length) $('form input.timepicker').timepicker({minuteStep: 30,autoclose:true});

      $('.tooltips').tooltip();

      set_permission_btn();

  };

  // Handles custom checkboxes & radios using jQuery iCheck plugin

  </script>