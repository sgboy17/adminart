<?php

class Sendm extends My_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get_items(){
        return $this->db->order_by('send_id DESC')->where('deleted', 0)->get($this->prefix.'send');
    }
        

    
    function get_item_by_id($id){
        return $this->db->where('send_id', $id)->get($this->prefix .'send')->row_array();
    }
        

    

    
    function get_send_list(){
        if (isset($_GET['f_from_date']) && !empty($_GET['f_from_date'])) {
            $this->db->where('created_date >= "'.format_save_date($_GET['f_from_date']).' 00:00:00"');
        }
        if (isset($_GET['f_to_date']) && !empty($_GET['f_to_date'])) {
            $this->db->where('created_date <= "'.format_save_date($_GET['f_to_date']).' 23:59:59"');
        }
                
        ////////////////////////////////////
        $result_item = $this->db->where('deleted', 0)->order_by('send_id DESC')->get($this->prefix.'send');
        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                
                'id' => $row->send_id,
        
                'object_id' => $row->object_id,
            
                'customer_id' => $row->customer_id,
            
                'email_id' => $row->email_id,
            
                'sms_id' => $row->sms_id,
            
                'created_date' => $row->created_date,
            
                );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            if(!empty($row['email_id'])){
                $send_object = $this->emailm->get_item_by_id($row['email_id']);
                if(empty($send_object)) continue;
                $send_title = $send_object['title'];
                $send_content = get_readmore(strip_tags($send_object['content']), 40);
                $send_note = $send_object['note'];
            }else if(!empty($row['sms_id'])){
                $send_object = $this->smsm->get_item_by_id($row['sms_id']);
                if(empty($send_object)) continue;
                $send_title = $send_object['name'];
                $send_content = $send_object['content'];
                $send_note = $send_object['note'];
            }else continue;

            if(!empty($row['customer_id'])){
                $sender = $this->customerm->get_name($row['customer_id']);
            }else if(!empty($row['object_id'])){
                $sender = array();
                $senders = $this->customerm->get_items_by_object_id($row['object_id']);
                foreach($senders->result() as $value){
                    $sender[] = $this->customerm->get_name($value->customer_id);
                }
                $sender = implode(', ', $sender);
            }else continue;
            $cate = array(
                
                format_get_date($row['created_date']),
        
                $sender,
            
                $send_title,
            
                $send_content,
            
                $send_note

                );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    } 
        
	
    function save_send_add() {
        $data['email_id'] = $this->input->post('email_id');
        $data['sms_id'] = $this->input->post('sms_id');
        $data['object_id'] = $this->input->post('object_id');
        $data['customer_id'] = $this->input->post('customer_id');

        if(!empty($data['email_id'])){
            $email = $this->emailm->get_item_by_id($data['email_id']);
            if(empty($email)) return;
            if(!empty($data['customer_id'])){
                $sender = $this->customerm->get_item_by_id($data['customer_id']);
                if(empty($sender)) return;
                // Send Email
                $this->emailm->sendEmailAutomatic($sender['email'], $email['title'], $email['content']); 
            }else if(!empty($data['object_id'])){
                $senders = $this->customerm->get_items_by_object_id($data['object_id']);
                foreach($senders->result() as $value){
                    // Send Email
                    $this->emailm->sendEmailAutomatic($value->email, $email['title'], $email['content']); 
                }
            }
        }
        else if(!empty($data['sms_id'])){
            $phones = array();
            $sms = $this->smsm->get_item_by_id($data['sms_id']);
            if(empty($sms)) return;
            if(!empty($data['customer_id'])){
                $sender = $this->customerm->get_item_by_id($data['customer_id']);
                if(empty($sender)) return;
                if(!empty($sender['phone_1'])) $phones[] = $sender['phone_1'];
                if(!empty($sender['phone_2'])) $phones[] = $sender['phone_2'];

            }else if(!empty($data['object_id'])){
                $senders = $this->customerm->get_items_by_object_id($data['object_id']);
                foreach($senders->result() as $value){
                    if(!empty($value->phone_1)) $phones[] = $value->phone_1;
                    if(!empty($value->phone_2)) $phones[] = $value->phone_2;
                }
            }
            if(!empty($phones)){
                // Send SMS
                $this->smsm->sendSmsAutomatic($phones, $sms['content']);
            }
        }else return;

        $data = array(
            
            'object_id' => $this->input->post('object_id'),
            
            'customer_id' => $this->input->post('customer_id'),
            
            'email_id' => $this->input->post('email_id'),
            
            'sms_id' => $this->input->post('sms_id'),
            
            'created_date' => date('Y-m-d H:i:s'),
            
            );
        $save = $this->db->insert($this->prefix.'send', $data);
    }
        
    
    function load_send_add(){
        $type = $this->input->post('type');
        ?>  
        <div class="modal-body">
            
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Nhóm đối tượng:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="object_id">
	                    <option value="">- nhóm đối tượng -</option>
	                    
                    <?php 
                    $object_list = $this->objectm->get_items();
                    foreach($object_list->result() as $row){ ?>
                    <option value="<?php echo $row->object_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            		
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Khách hàng:</div>
                </div>
                <div class="col-md-8">
                    <input class="form-control" id="customer_info" />
                    <input type="hidden" name="customer_id" value="" />
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if($type==1){ ?>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mẫu email:</div>
                </div>
                <div class="col-md-8">
	                <select class="form-control" name="email_id">
	                    <option value="">- mẫu email -</option>
	                    
                    <?php 
                    $email_list = $this->emailm->get_items();
                    foreach($email_list->result() as $row){ ?>
                    <?php if($row->active==2) continue; ?>
                    <option value="<?php echo $row->email_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
	                </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php } ?>
            <?php if($type==2){ ?>
            <div class="form-group m-t-sm">
                <div class="col-md-4">
                    <div class="m-t-sm">Mẫu sms:</div>
                </div>
                <div class="col-md-8">
                    <select class="form-control" name="sms_id">
                        <option value="">- mẫu sms -</option>
                        
                    <?php 
                    $sms_list = $this->smsm->get_items();
                    foreach($sms_list->result() as $row){ ?>
                    <?php if($row->active==2) continue; ?>
                    <option value="<?php echo $row->sms_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
                    </select>
                    <p class="text-info" style="margin-top: 5px;"><?php echo $this->smsm->GetBalance(); ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php } ?>
            		
            	
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" onclick="save_send_add($(this))"><i class="fa fa-send"></i> gửi</a>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out"></i> thoát</a>
        </div>
        <?php
    }
        

}
