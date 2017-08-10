<?php

class Invoicem extends My_Model {

	function __construct() {
		parent::__construct();
	}

	function get_items() {
		return $this->db->order_by('invoice_id DESC')->where('deleted', 0)->get($this->prefix . 'invoice');
	}

	function get_item_by_id($id) {
		return $this->db->select('i.*, s.name as student_name, s.phone, s.email, s.student_code')
			->where('invoice_id', $id)
			->from($this->prefix . 'invoice i')
			->join($this->prefix . 'student s', 'i.student_id = s.student_id')
			->get()
			->row_array();
	}

    function get_item_by_student_id($id, $type) {
        return $this->db->select('*')
            ->where('student_id', $id)
            ->where('type', $type)
            ->get($this->prefix . 'invoice');
    }

    function get_current_by_student_id($id, $type, $limit = 1) {
        if (!empty($limit)) {
            $this->db->limit($limit);
        }
        return $this->db->select('*')
            ->where('student_id', $id)
            ->where('type', $type)
            ->where('deleted', 0)
            ->order_by('invoice_id DESC')
            ->get($this->prefix . 'invoice');
    }

	function load_print($id = null, $type = false) {
		if (empty($id)) {
			$id = $this->input->post('id');
		}
		$data = $this->get_item_by_id($id);

        if($data['type'] == INVOICE_TYPE_4) {
            $action_data = $this->actionm->get_branch_transfer_action($data['branch_id'], $data['student_id']);
            if (!empty($action_data)) {
                $data['current_branch_name'] = $this->branchm->get_name($action_data->from);
                $data['to_branch_name'] = $this->branchm->get_name($action_data->to);    
            }
        }

		$data['detail'] = $this->invoicedetailm->get_items_by_invoice($id);
        
        $data['branch'] = $this->branchm->get_item_by_id($data['branch_id']);

        if($type) {
           return $this->load->view('invoice/email', $data, true);
        } else {
            $this->load->view('invoice/print', $data);
        }

	}

	function generate_code($branch_id)
    {
        $branch = $this->branchm->get_item_by_id($branch_id);
        if (empty($branch)) $branch_code = 'MD';
        else if (empty($branch['code'])) {
            $branch_name = explode(' ', $branch['name']);
            $first_char = '';
            foreach ($branch_name as $row) {
                if (isset($row[0]) && !empty($row[0])) $first_char .= strtoupper($row[0]);
            }
            if (!empty($first_char)) $branch_code = $first_char;
            else $branch_code = 'MD';
        } else {
            $branch_code = $branch['code'];
        }

        $last_result = $this->db->order_by('created_at DESC')->where('invoice_code LIKE "%-' . $branch_code . '-%"')->limit(1)->get($this->prefix . 'invoice')->row();
        $last_number = 1;
        if (!empty($last_result)) {
            $code = explode('-', $last_result->invoice_code);
            foreach ($code as $row) {
                if (((int)$row) != 0) $last_number = (int)$row + 1;
            }
        };
        $result_code = 'IV-' . $branch_code . '-' . str_pad($last_number, 6, 0, STR_PAD_LEFT);
        return $result_code;
    }

	function load_invoice_action() {
		$student_id = $this->input->post('student_id');
        $action = $this->input->post('action');
        ?>
        	<input type="hidden" name="type" value="<?php echo $action; ?>">
        	<input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

        <?php
            // -------------------------------   Đặt cọc   -------------------------------
            if ($action == INVOICE_TYPE_6) :
        ?>
            <div class="modal-body">
                <h4><?php echo $action ?></h4>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Mã phiếu thu:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly="readonly"
                               value="<?php echo $this->generate_code($this->session->userdata('branch')); ?>"
                               name="invoice_code" class="form-control"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Trung tâm:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="branch_id" readonly="readonly">
                            <?php
                            $center_list = $this->branchm->get_items();
                            foreach ($center_list->result() as $row) {
                                if ($row->branch_id != $this->session->userdata('branch')) continue;
                                ?>
                                <option
                                    value="<?php echo $row->branch_id ?>" <?php if ($row->branch_id == $this->session->userdata('branch')) echo 'selected="selected"' ?>><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Chương trình học:</div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" name="program_id" onchange="load_program_fee($(this));">
                            <option value="">-- chọn chương trình học --</option>
                            <?php /*
                            $program_list = $this->programm->get_items();
                            foreach ($program_list->result() as $row) :
                            ?>
                            <?php if ($row->branch_id != $this->session->userdata('branch')) continue; ?>
                                <option value="<?php echo $row->program_id ?>"><?php echo $row->name ?></option>
                            <?php endforeach; */ ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-default" aria-label="Justify" onclick="add_more_program($(this));">
                            <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div> -->

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Số tiền:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="total" placeholder="số tiền"
                               class="form-control"
                               value="0"></input>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Ghi chú:</div>
                    </div>
                    <div class="col-md-8">
                    <textarea name="note" placeholder="ghi chú"
                              class="form-control"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php endif; ?>


        <?php
        // -------------------------------   Chuyển trung tâm  -------------------------------
        if ($action == INVOICE_TYPE_4) :
            $id = $this->input->post('student_id');
            $student_name = $this->studentm->get_name($id);
            $branch_name = $this->branchm->get_name($this->session->userdata('branch'));

            $branch_data = $this->branchm->get_item_by_id($this->session->userdata('branch'));
            $show_branch_change = 0;
            $student_class = $this->studentclassm->get_items_by_student_id($id);
            if($student_class->num_rows() == 0) {
                $show_branch_change  = 1;
            }
            ?>

            <div class="modal-body">
                <h4><?php echo $action ?></h4>
                <?php if($show_branch_change == 1) :?>
                <input type="hidden" name="branch_id" value="<?php echo $this->session->userdata('branch') ?>">
                <input type="hidden" name="object_id" value="<?php echo $id; ?>">
                <input type="hidden" name="action" value="<?php echo STUDENT_STATUS_8; ?>">
                <input type="hidden" value="<?php echo $this->generate_code($this->session->userdata('branch')); ?>" name="invoice_code" class="form-control"></input>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tên học viên:</div>
                    </div>
                    <div class="col-md-8">
                        <b><?php echo $student_name; ?></b>
                    </div>
                </div>
                <div class="clearfix"></div>


                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Trung tâm hiện tại:</div>
                    </div>
                    <div class="col-md-8">
                        <b><?php echo $branch_name; ?></b>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Đến trung tâm:</div>
                    </div>
                    <div class="col-md-8">
                        <select class="form-control" name="to_branch_id" readonly="readonly">
                            <?php
                            $center_list = $this->branchm->get_items();
                            foreach ($center_list->result() as $row) {
                                ?>
                                <?php if ($row->branch_id == $this->session->userdata('branch')) continue; ?>
                                <option
                                    value="<?php echo $row->branch_id ?>"><?php echo $row->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Tiền phụ thu:</div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="total" placeholder="số tiền" class="form-control" value="<?php echo isset($branch_data['fee_change_branch'])?$branch_data['fee_change_branch']:0; ?>"></input>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-4">
                        <div class="m-t-sm">Lý do:</div>
                    </div>
                    <div class="col-md-8">
                    <textarea name="note" placeholder="lý do"
                              class="form-control"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            <?php else: ?>
                <p>* Học viên phải đang không theo học lớp nào.</p>
            <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
            // -------------------------------   Học thử  -------------------------------
            if ($action == INVOICE_TYPE_2) :
        ?>
            <input type="hidden" name="action" id="action" value="<?php echo STUDENT_STATUS_10 ?>"/>
            <input type="hidden" name="object_id" value="<?php echo $student_id; ?>">

            <div class="modal-body">
                <div class="col-md-6">
                    <h4 id="student_signup"><?php echo $action ?></h4>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Mã phiếu thu:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" readonly="readonly"
                                   value="<?php echo $this->generate_code($this->session->userdata('branch')); ?>"
                                   name="invoice_code" class="form-control"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Trung tâm:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="branch_id" readonly="readonly">
                                <?php
                                $center_list = $this->branchm->get_items();
                                foreach ($center_list->result() as $row) {
                                    if ($row->branch_id != $this->session->userdata('branch')) continue;
                                    ?>
                                    <option
                                        value="<?php echo $row->branch_id ?>" <?php if ($row->branch_id == $this->session->userdata('branch')) echo 'selected="selected"' ?>><?php echo $row->name ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Chương trình học:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="program_id" onchange="load_program_fee($(this));">
                                <option value="">-- chọn chương trình học --</option>
                                <?php
                                $sql = "SELECT *
                                        FROM " . $this->prefix . "program
                                        WHERE status = 1
                                            AND deleted = 0
                                            AND program_id NOT IN (SELECT program_id
                                                                    FROM " . $this->prefix . "student_class
                                                                    WHERE student_id = ? AND `status` = 1 AND deleted = 0);";
                                $program_list = $this->db->query($sql, array($student_id));
                                foreach ($program_list->result() as $row) {
                                    if ($row->branch_id != $this->session->userdata('branch')) continue;
                                ?>
                                    <option value="<?php echo $row->program_id ?>"><?php echo $row->name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- <div class="col-md-2">
                            <button type="button" class="btn btn-default" aria-label="Justify" onclick="add_more_program($(this));">
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                            </button>
                        </div> -->
                    </div>

                    <!-- <div id="more-program-content"></div> -->

                    <div class="clearfix"></div>

                    <!-- <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Sự kiện:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="event_id" onclick="calculate_price();">
                                <option value="" data-discount="0">-- chọn sự kiện --</option>
                                <?php /*
                                $event_list = $this->eventm->get_active_event();
                                foreach ($event_list->result() as $row) {
                                    ?>
                                    <?php if ($row->branch_id != $this->session->userdata('branch')) continue; ?>
                                    <option data-discount="<?php echo $row->discount ?>"
                                        value="<?php echo $row->event_id ?>"><?php echo $row->name ?></option>
                                <?php } */ ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div> -->

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Lớp:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="class_id">
                                <?php
                                $sql = "SELECT * FROM mk_class
                                        WHERE status = 1
                                            AND deleted = 0
                                            AND class_id NOT IN (SELECT class_id
                                                                FROM `mk_student_class`
                                                                WHERE student_id = ? AND `status` = 1 AND deleted = 0);";
                                $class_list = $this->db->query($sql, array($student_id));
                                foreach ($class_list->result() as $row) {
                                    if ($row->branch_id != $this->session->userdata('branch')) continue;
                                    $class_hour = $this->classhourm->get_item_by_class_id($row->class_id);
                                    if (empty($class_hour)) continue;
                                    ?>
                                    <option data="<?php echo $class_hour['date_id'] ?>"
                                            value="<?php echo $row->class_id ?>"><?php echo !empty($row->name) ? $row->name : $row->class_code ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Ngày bắt đầu học:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="date_start" placeholder="ngày bắt đầu học"
                                   class="form-control datepicker"
                                   value=""></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Số giờ học 1 buổi:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="hour">
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Số buổi học thử:</div>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="other">
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Ghi chú:</div>
                        </div>
                        <div class="col-md-8">
                        <textarea name="note" placeholder="ghi chú"
                                  class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <h4>Phiếu Thu</h4>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Chiết khấu trực tiếp:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="extra_discount" placeholder="chiết khấu trực tiếp"
                                   class="form-control"
                                   value="0"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group m-t-sm">
                        <div class="col-md-4">
                            <div class="m-t-sm">Phụ thu trực tiếp:</div>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="surcharge" placeholder="phụ thu trực tiếp"
                                   class="form-control"
                                   value="0"></input>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="table-container table-responsive m-t hide">
                        <table class="table table-striped table-bordered table-hover" id="table-invoice">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="15%" class="text-center">
                                        Chi phí
                                    </th>
                                    <th width="8%" class="text-center">
                                        Giá
                                    </th>
                                    <th width="5%" class="text-center">
                                        SL
                                    </th>
                                    <th width="5%" class="text-center">
                                        %
                                    </th>
                                    <th width="5%" class="text-center">
                                        Thành tiền
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        <strong>Tổng tiền </strong>
                                    </th>
                                    <th>
                                        <strong id="sub_total">0</strong>
                                        <input type="hidden" name="sub_total" value="0">
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <strong>Chiết khấu </strong>
                                    </th>
                                    <th>
                                        <strong id="discount">0</strong>
                                        <input type="hidden" name="discount" value="0">
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <strong>Phụ Thu </strong>
                                    </th>
                                    <th>
                                        <strong id="surcharge">0</strong>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <strong>Thanh toán </strong>
                                    </th>
                                    <th>
                                        <strong id="total">0</strong>
                                        <input type="hidden" name="total" value="0">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="clearfix m-b"></div>
        <?php endif; ?>

		<div class="modal-footer">

            <?php if($action == INVOICE_TYPE_4): ?>
                <?php if($show_branch_change  == 1): ?>
                    <a class="btn btn-info" onclick="save_invoice_action($(this), true)">Lưu và In</a>
                    <!-- <a class="btn btn-success" onclick="save_invoice_action($(this), false)">Lưu</a> -->
                <?php endif; ?>
            <?php else: ?>
                <a class="btn btn-info" onclick="save_invoice_action($(this), true)">Lưu và In</a>
                <!-- <a class="btn btn-success" onclick="save_invoice_action($(this), false)">Lưu</a> -->
            <?php endif; ?>
            <a data-dismiss="modal" style="display:none;">Processing...</a>
            <a class="btn btn-default" data-dismiss="modal">Huỷ</a>
        </div>

        <?php
	}

	function save_invoice_add() {
		$invoice_id = $this->uuid->v4();

        $student_id = $this->input->post('object_id')
            ? $this->input->post('object_id')
            : $this->input->post('student_id');

        // hoc thu
        if ($this->input->post('type') == INVOICE_TYPE_2) {
            $class_id = $this->input->post('class_id');
            if (empty($class_id)) return false;
            $program = $this->programm->get_item_by_id($this->input->post('program_id'));
            if (empty($program)) return false;
            $_POST['invoice_id'] = $invoice_id;
            $this->actionm->save_action_register($program, $class_id);
        }

        // chuyen trung tam
        if ($this->input->post('type') == INVOICE_TYPE_4) {

            $this->db->update(
                $this->prefix . 'action',
                array(
                    'deleted' => 1
                ),
                array(
                    'action' => $this->input->post('action'),
                    'branch_id' => $this->input->post('branch_id'),
                    'object_id' => $this->input->post('student_id'),
                    'from' => $this->input->post('branch_id')
                )
            );

            $data = array(

                'action_id' => $this->uuid->v4(),

                'branch_id' => $this->input->post('branch_id'),

                'object_id' => $this->input->post('object_id'),

                'action' => $this->input->post('action'),

                'from' => $this->input->post('branch_id'),

                'to' => $this->input->post('to_branch_id'),

                'note' => $this->input->post('note'),

                'created_at' => date('Y-m-d H:i:s'),

            );

            $this->db->insert($this->prefix . 'action', $data);

        }

        if ($this->input->post('type') == INVOICE_TYPE_6 || $this->input->post('type') == INVOICE_TYPE_4) {
            $sub_total = $this->input->post('total', 0);
        } else {
            $sub_total = $this->input->post('sub_total', 0);
        }

        $invoice = array(
            'invoice_id' => $invoice_id,
            'invoice_code' => $this->input->post('invoice_code'),
            'branch_id' => $this->input->post('branch_id'),
            'student_id' => $student_id,
            'user_id' => $this->session->userdata('user'),
            'event_id' => $this->input->post('event_id', null),
            'sub_total' => $sub_total,
            'extra_discount' => $this->input->post('extra_discount', 0),
            'discount' => $this->input->post('discount', 0),
            'surcharge' => $this->input->post('surcharge', 0),
            'total' => $this->input->post('total', 0),
            'type' => $this->input->post('type'),
            'note' => $this->input->post('note', null),
            'other' => $this->input->post('other', null),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $save = $this->db->insert($this->prefix . 'invoice', $invoice);

        if ($save) {
            /* Invoice Detail */
            $data = array();
            $action = array();
            $invoices = $this->input->post('invoice');
            if (!empty($invoices)) {
	            $order = 1;

	            foreach ($invoices as $row) {
	                if ($row['type'] == INVOICE_DETAIL_TYPE_2 && $row['quantity'] == 0) continue;

                    $invoice_detail_id = $this->uuid->v4();

	                $data[] = array(
	                    'invoice_detail_id' => $invoice_detail_id,
	                    'invoice_id' => $invoice_id,
	                    'object_id' => $row['object_id'],
	                    'name' => $row['name'],
	                    'quantity' => $row['quantity'],
                        'discount' => isset($row['discount'])?$row['discount']:0,
	                    'unit_price' => $row['unit_price'],
	                    'total' => $row['total'],
	                    'type' => $row['type'],
	                    'order' => $order
	                );

	                $order++;

                    // dong hoc phi nhieu chuong trinh 1 luc
                    if (($invoice['type'] == INVOICE_TYPE_0 || $invoice['type'] == INVOICE_TYPE_1) &&
                            $row['type'] == INVOICE_DETAIL_TYPE_1) {

                        if ($row['object_id'] == $this->input->post('program_id')) continue;

                        $action[] = array(
                            'action_id' => $this->uuid->v4(),
                            'branch_id' => $this->input->post('branch_id'),
                            'object_id' => $student_id,
                            'action' => STUDENT_STATUS_11,
                            'from' => $row['object_id'],
                            'to' => $invoice_id,
                            'note' => '',
                            'created_at' => date('Y-m-d H:i:s')
                        );
                    }
	            }
            }

            if (!empty($data)) {
                $this->db->insert_batch($this->prefix . 'invoice_detail', $data);
            }

            if (!empty($action)) {
                $this->db->insert_batch($this->prefix . 'action', $action);
            }

        }

        // da su dung phieu hoc thu
        if ($this->input->post('free_invoice_id') && $this->input->post('free_invoice_id') != '') {
            $free_invoice_id = $this->input->post('free_invoice_id');
            // xoa lop hoc thu
            $sql = 'UPDATE ' . $this->prefix . 'student_class
                    SET deleted = 1
                    WHERE student_class_id = (SELECT `from` FROM ' . $this->prefix . 'action WHERE `to` = ? AND action = ?)';
            $this->db->query($sql, array($free_invoice_id, STUDENT_STATUS_10));
            // xoa action
            $this->db->update($this->prefix . 'action', array('deleted' => 1), array(
                'to' => $free_invoice_id,
                'action' => STUDENT_STATUS_10
            ));
            // danh dau phieu da duoc su dung
            $this->db->update($this->prefix . 'invoice', array('is_used' => 1), array(
                'invoice_id' => $free_invoice_id
            ));
        }

        // da su dung tien dat coc
        if ($this->input->post('deposit_invoice_id') && $this->input->post('deposit_invoice_id') != '') {
            $this->db->update($this->prefix . 'invoice', array('is_used' => 1), array(
                'invoice_id' => $this->input->post('deposit_invoice_id')
            ));
        }

        // da su dung tien tich luy
        if ($this->input->post('student_money') && $this->input->post('student_money') != '') {
            $this->db->update($this->prefix . 'student_money', array('deleted' => 1), array(
                'student_id' => $student_id
            ));
        }

        // da su dung tien duoc chuyen tu nguoi khac
        if ($this->input->post('transfer_money')!= "") {
            foreach ($this->input->post('transfer_money') as $key => $value) {
                $sql = "UPDATE mk_action a INNER JOIN mk_student_money sc on a.`from` = sc.`student_money_id`
                        SET a.`deleted` = 1,
                            sc.`deleted` = 1
                        WHERE a.`branch_id` = ?
                            AND a.`action` = ?
                            AND a.`to` = ?
                            AND sc.`program_id` = ?";
                $this->db->query($sql, array($this->input->post('branch_id'), STUDENT_STATUS_9, $student_id, $key));
            }
        }

        // tao tien tich luy moi neu con du
        if ($this->input->post('balance_money') && $this->input->post('balance_money') != '0') {
            $data = array(
                'student_money_id' => $this->uuid->v4(),
                'branch_id' => $this->input->post('branch_id'),
                'student_id' => $student_id,
                'action' => STUDENT_STATUS_10,
                'hour' => 0,
                'money' => $this->input->post('balance_money'),
                'program_id' => $this->input->post('program_id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $save = $this->db->insert($this->prefix . 'student_money', $data);
        }

        sendEmailToCEO($this->input->post('branch_id'),"new-invoice",array('invoice_id'=>$invoice_id));

        if ($this->input->post('print_invoice')) {
            echo json_encode(array(
                'id' => $invoice_id
            ));
        }
	}

    function get_invoice_list(){

        if (isset($_GET['f_search']) && !empty($_GET['f_search'])) {
            /*$this->db->where($this->prefix .'student.name like', "%".$_GET['f_search']."%");
            $this->db->or_where($this->prefix .'student.parent_name like', "%".$_GET['f_search']."%");
            $this->db->or_where($this->prefix .'class.class_code like', "%".$_GET['f_search']."%");
            $this->db->or_where($this->prefix .'program.name like', "%".$_GET['f_search']."%");*/
            $this->db->where($this->prefix .'invoice.invoice_code like', "%".$_GET['f_search']."%");
            //$this->db->or_where($this->prefix .'invoice.type like', "%".$_GET['f_search']."%");
            //$this->db->or_where($this->prefix .'invoice.total like', "%".$_GET['f_search']."%");
        }

        if (isset($_GET['f_student_id']) && !empty($_GET['f_student_id'])) {
            $this->db->where($this->prefix .'invoice.student_id', $_GET['f_student_id']);
        }

        if (isset($_GET['f_class_id']) && !empty($_GET['f_class_id'])) {
             $this->db->where($this->prefix .'student_class.class_id', $_GET['f_class_id']);
        }

        if (isset($_GET['f_event_id']) && !empty($_GET['f_event_id'])) {
             $this->db->where($this->prefix .'invoice.event_id', $_GET['f_event_id']);
        }

        if (isset($_GET['f_from_date']) && !empty($_GET['f_from_date'])) {
            $this->db->where($this->prefix .'invoice.created_at >=', format_save_date($_GET['f_from_date']) .' 00:00:00');
        }

        if (isset($_GET['f_to_date']) && !empty($_GET['f_to_date'])) {
            $this->db->where($this->prefix .'invoice.created_at <=', format_save_date($_GET['f_to_date']) .' 23:59:59');
        }

        ////////////////////////////////////
        $result_item = $this->db->from($this->prefix .'invoice')
//            ->join($this->prefix .'student_class', $this->prefix .'invoice.student_class_id = '.$this->prefix .'student_class.student_class_id','left')
//            ->join($this->prefix .'class', $this->prefix .'class.class_id = '.$this->prefix .'student_class.class_id','left')
//            ->join($this->prefix .'program', $this->prefix .'program.program_id = '.$this->prefix .'student_class.program_id','left')
//            ->join($this->prefix .'student', $this->prefix .'student.student_id = '.$this->prefix .'invoice.student_id','left')
            ->where($this->prefix .'invoice.branch_id', $this->session->userdata('branch'))
            ->where($this->prefix .'invoice.user_id', $this->session->userdata('user'))
            ->where($this->prefix .'invoice.deleted', 0)
            ->order_by($this->prefix .'invoice.created_at DESC')
            ->get();

        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $result_item->num_rows();
        $list = array();
        foreach($result_item->result() as $row){
            $list[] = array(
                'id' => $row->invoice_id,

                'invoice_code' => $row->invoice_code,

                'branch_id' => $row->branch_id,

                'student_id' => $row->student_id,

                // 'student_class_id' => $row->student_class_id,

                'event_id' => $row->event_id,

                'type' => $row->type,

                'sub_total' => $row->sub_total,

                'discount' => $row->discount,

                'friend_id' => $row->friend_id,

                'total' => $row->total,

                'note' => $row->note,

                'user_id' => $row->user_id,

                'created_at' => $row->created_at,

                'updated_at' => $row->updated_at,

            );
        }
        ////////////////////////////////////
        $data['aaData'] = array();
        $i=-1;
        foreach ($list as $row):
            $i++; if(!($i>=$_GET['iDisplayStart']&&$i<$_GET['iDisplayStart']+$_GET['iDisplayLength'])) continue;
            $cate = array(

                $row['invoice_code'],

                $this->studentm->get_name($row['student_id']),

                $row['type'],

                number_format($row['total'], 0),

                format_get_date($row['created_at']),

                '<a href="javascript:void(-1)" onclick="print_invoice(\'' . $row['id'] . '\')"><span class="fa fa-print"></span></a>'

            );
            $data['aaData'][] = $cate;
        endforeach;
        echo json_encode($data);
    }

}
