<?php

class Api extends My_Controller
{

    var $is_login = false;

    function __construct()
    {
        parent::__construct();
        $this->permissionm->check_permission('api');
    }

    function execute()
    {
        if (isset($_GET['execute'])) {
            if (!isset($_GET['username']) || !isset($_GET['password'])) {
                echo json_encode(array('result' => 'Not Auth!'));
                die;
            } else {
                $data = $this->userm->login($_GET['username'], $_GET['password']);
                if (!$data['success']) {
                    echo json_encode(array('result' => 'Not Auth!'));
                    die;
                }
            }

            if ($_GET['execute'] == 'income_by_week') { // Doanh thu 7 ngày gần nhất
                $price_import = '(
                    SELECT SUM(od.quantity*od.price_export/(1+od.tax_percent/100)-od.quantity*od.price_import) as total_price_import 
                    FROM ' . $this->prefix . 'order_detail od
                    WHERE od.order_id = o.order_id AND od.deleted = 0
                    )';

                $report_day = $this->db->query(
                    'SELECT SUM(o.total_price) as profit, DATE(o.created_date) as profit_date, SUM(' . $price_import . ') as total_price_import
                     FROM ' . $this->prefix . 'order o
                     WHERE o.deleted = 0 AND o.created_date >= "' . date('Y-m-d 00:00:00', time() - 365 * 24 * 3600) . '" AND o.created_date <= "' . date('Y-m-d 23:59:59') . '"
                     GROUP BY DATE(o.created_date)
                     ORDER BY DATE(o.created_date) DESC'
                );
                $result_report_day = $report_day->result();
                if ($report_day->num_rows() >= 7) $limit = $report_day->num_rows() - 7; else $limit = 0;
                $data = array();
                for ($i = $report_day->num_rows() - 1 - $limit; $i >= 0; $i--) {
                    $row = $result_report_day[$i];
                    $data[] = array(
                        'date' => format_get_date($row->profit_date, 'd/m'),
                        'income' => $row->profit,
                        'profit' => $row->total_price_import
                    );
                }
                echo json_encode(array('result' => $data));
            }

            if ($_GET['execute'] == 'view_store_product') { // Thống kê hàng tồn
                $stores = $this->storem->get_items_by_branch_id($this->session->userdata('branch'));
                $products = $this->productm->get_items(0);
                ////////////////////////////////////
                $product_store_arr = array();
                foreach ($products->result() as $product):
                    foreach ($stores->result() as $store) {
                        $store_id = $product->store_id;
                        if (empty($store_id)) {
                            $product_store_arr[] = array('product' => $product, 'store' => $store);
                        } else {
                            $store_id = format_cell($store_id, ',');
                            $store_id = explode(',', $store_id);
                            if (in_array($store->store_id, $store_id)) $product_store_arr[] = array('product' => $product, 'store' => $store);
                        }
                    }
                endforeach;
                $data = array();
                $unit = $this->unitm->get_items();
                foreach ($product_store_arr as $row):
                    $product = $row['product'];
                    $store = $row['store'];
                    $total_store_product = $this->storeproductm->get_total_store_product($store->store_id, $product->product_id);
                    $cate = array(
                        'product_code' => $product->code,
                        'product_name' => $product->name,
                        'store_name' => $store->name,
                        'product_store_min' => $product->store_min,
                        'product_store_max' => $product->store_max,
                        'total_store_product' => $total_store_product
                    );
                    $data[] = $cate;
                endforeach;
                echo json_encode(array('result' => $data));
            }

            if ($_GET['execute'] == 'income_by_product_group') { // Doanh thu theo nhóm hàng
                $report_product_group = $this->db->query(
                    'SELECT SUM(od.paid+od.unpaid) as total_paid, pg.name as product_group_name
                     FROM ' . $this->prefix . 'product_group pg
                     JOIN ' . $this->prefix . 'product p ON (p.product_group_id = pg.product_group_id)
                     JOIN ' . $this->prefix . 'order_detail od ON (od.product_id = p.product_id)
                     WHERE od.deleted = 0 AND p.deleted = 0 AND pg.deleted = 0
                     GROUP BY pg.product_group_id 
                     ORDER BY total_paid DESC'
                );
                $data = array();
                foreach ($report_product_group->result() as $row) {
                    $data[] = array(
                        'product_group_name' => $row->product_group_name,
                        'income' => $row->total_paid
                    );
                }
                echo json_encode(array('result' => $data));
            }

            if ($_GET['execute'] == 'income_by_year') { // Hoạt động kinh doanh
                $price_import = '(
                    SELECT SUM(od.quantity*od.price_export/(1+od.tax_percent/100)-od.quantity*od.price_import) as total_price_import 
                    FROM ' . $this->prefix . 'order_detail od
                    WHERE od.order_id = o.order_id AND od.deleted = 0
                    )';

                $report_day = $this->db->query(
                    'SELECT SUM(o.total_price) as profit, DATE(o.created_date) as profit_date, SUM(' . $price_import . ') as total_price_import
                     FROM ' . $this->prefix . 'order o
                     WHERE o.deleted = 0 AND o.created_date >= "' . date('Y-m-d 00:00:00', time() - 365 * 24 * 3600) . '" AND o.created_date <= "' . date('Y-m-d 23:59:59') . '"
                     GROUP BY DATE(o.created_date)
                     ORDER BY DATE(o.created_date) DESC'
                );
                $result_report_day = $report_day->result();
                if ($report_day->num_rows() >= 365) $limit = $report_day->num_rows() - 365; else $limit = 0;
                $data = array();
                for ($i = $report_day->num_rows() - 1 - $limit; $i >= 0; $i--) {
                    $row = $result_report_day[$i];
                    $data[] = array(
                        'date' => format_get_date($row->profit_date, 'd/m'),
                        'income' => $row->profit,
                        'profit' => $row->total_price_import
                    );
                }
                echo json_encode(array('result' => $data));
            }
        }
        if (isset($_POST['execute'])) {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                echo json_encode(array('result' => 'Not Auth!'));
                die;
            } else {
                $data = $this->userm->login($_POST['username'], $_POST['password']);
                if (!$data['success']) {
                    echo json_encode(array('result' => 'Not Auth!'));
                    die;
                }
            }

            if ($_POST['execute'] == 'view_customer') { // Tìm kiếm khách hàng
                if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
                    $this->db->where('(code LIKE "%' . $_POST['keyword'] . '%" OR name LIKE "%' . $_POST['keyword'] . '%" OR phone_1 LIKE "%' . $_POST['keyword'] . '%" OR phone_2 LIKE "%' . $_POST['keyword'] . '%")');
                    $data = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix . 'customer')->result_array();
                    echo json_encode(array('result' => $data));
                } else {
                    echo json_encode(array('result' => 'Not found!'));
                }
            }

            if ($_POST['execute'] == 'add_customer') { // Bổ sung thông tin khách hàng
                if (!isset($_POST['name']) || !isset($_POST['phone_1'])) {
                    echo json_encode(array('result' => 'Wrong parameter!'));
                    die;
                }
                $code = $this->filem->getCode($this->input->post('name'));
                $data = array(

                    'code' => $code,

                    'name' => $this->input->post('name'),

                    'phone_1' => $this->input->post('phone_1'),

                    'status' => 1,

                );
                $exist_phone = $this->customerm->get_item_by_phone($this->input->post('phone_1'));
                if (empty($exist_phone)) {
                    $save = $this->db->insert($this->prefix . 'customer', $data);
                    $customer_id = $this->db->insert_id();
                    echo json_encode(array('name' => $this->input->post('name') . ' - ' . $this->input->post('phone_1'), 'id' => $customer_id));
                } else {
                    $save = $this->db->update($this->prefix . 'customer', $data, array('customer_id' => $exist_phone['customer_id']));
                    $customer_id = $exist_phone['customer_id'];
                    echo json_encode(array('name' => $this->input->post('name') . ' - ' . $this->input->post('phone_1'), 'id' => $customer_id));
                }
            }

            if ($_POST['execute'] == 'view_product') { // Tìm kiếm thông tin món hàng
                if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
                    $this->db->where('(name LIKE "%' . $_POST['keyword'] . '%" OR code LIKE "%' . $_POST['keyword'] . '%")');
                    $data = $this->db->where('deleted', 0)->order_by('name ASC')->get($this->prefix . 'product')->result_array();
                    echo json_encode(array('result' => $data));
                } else {
                    echo json_encode(array('result' => 'Not found!'));
                }
            }

            if ($_POST['execute'] == 'add_order') { // Xác nhận mua hàng
                /*
                -- CART --
                key:4,5 (ID record của các record sản phẩm cách nhau bằng dấu ,)
                store_quantity:5,5 (số lượng của mỗi sản phẩm tương ứng cách nhau bằng dấu ,)
                product_price:4000000,7000000 (giá đơn vị của mỗi sản phẩm tương ứng cách nhau bằng dấu ,)
                
                -- BILL --
                paid_get:60000000 (tiền khách hàng đưa)
                
                -- CUSTOMER --
                customer_id:3 (ID của record khách hàng)
                */
                if (!isset($_POST['key']) ||
                    !isset($_POST['store_quantity']) ||
                    !isset($_POST['product_price']) ||
                    !isset($_POST['paid_get']) ||
                    !isset($_POST['customer_id'])
                ) {
                    echo json_encode(array('result' => 'Wrong parameter!'));
                    die;
                }

                $branch = $this->branchm->get_item_by_id($this->session->userdata('branch'));
                if (!empty($branch)) $store_default = $branch['store_id'];
                else $store_default = 0;

                $product_id = explode(',', $_POST['key']);
                $product_price = explode(',', $_POST['product_price']);
                $store_quantity = explode(',', $_POST['store_quantity']);
                $order_type = $unit_id = $commission = $vat = $product_unpaid = $store_id = $product_paid = array();

                $_POST['total_price_total'] = 0;
                foreach ($product_id as $key => $id) {
                    $product_detail = $this->productm->get_item_by_id($id);
                    $price = $product_price[$key];
                    $quantity = $store_quantity[$key];
                    $product_paid[] = $price * $quantity;
                    $order_type[] = 0;
                    $commission[] = '0|0';
                    $vat[] = 0;
                    $product_unpaid[] = 0;
                    $store_id[] = $store_default;
                    $unit_id[] = $product_detail['unit_id'];
                    $_POST['total_price_total'] += $price * $quantity;
                }
                $_POST['order_type'] = implode(',', $order_type);
                $_POST['unit_id'] = implode(',', $unit_id);
                $_POST['commission'] = implode(',', $commission);
                $_POST['vat'] = implode(',', $vat);
                $_POST['product_unpaid'] = implode(',', $product_unpaid);
                $_POST['store_id'] = implode(',', $store_id);
                $_POST['product_paid'] = implode(',', $product_paid);

                $_POST['note'] = $_POST['code_fix'] = $_POST['code_sale'] = $_POST['code'] = '';
                $_POST['mini_value_filter'] = $_POST['mini_product_group_id'] = '';
                $_POST['remain_paid'] = $_POST['bank_id'] = $_POST['paid_card'] = 0;
                $_POST['order_voucher_price'] = '0,0';
                $_POST['order_voucher_quantity'] = '1,1';
                $_POST['created_date'] = date('d/m/Y');
                $_POST['total_paid'] = $_POST['total_price_total'];
                $_POST['sum_price'] = $_POST['total_price_total'];
                $_POST['paid_cash'] = $_POST['paid_get'];
                $_POST['paid_return'] = $_POST['paid_get'] - $_POST['total_price_total'];

                $this->orderm->save_order_add();
            }
        }
        die;
    }

    function import_file()
    {
        if (isset($_GET['file_table']) && !empty($_GET['file_table'])) {
            $this->filem->import_file($_GET['file_table']);
        }
    }

    function upload_file()
    {
        if ($_FILES['file']['size'] > 30 * 1024 * 1024) return;
        $root_account = $this->session->userdata('root_account');
        $root = dirname(dirname(dirname(__FILE__))) . '/upload';
        if (!file_exists($root . '/' . $root_account)) {
            mkdir($root . '/' . $root_account, 0755, true);
        }

        if (($_FILES["file"]["type"] == "text/xml") || ($_FILES["file"]["type"] == "application/vnd.ms-excel") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
            $file = pathinfo($_FILES["file"]["name"]);
            $name = 'Attachment_' . date('d-m-Y-h-i-s');
            $file = $root_account . '/' . $name . '.' . $file['extension'];
            move_uploaded_file($_FILES["file"]['tmp_name'], "./upload/" . $file);
            echo $file;
        }
    }

    function upload_img()
    {
        if ($_FILES['file']['size'] > 3 * 1024 * 1024) return;
        $root_account = $this->session->userdata('root_account');
        $root = dirname(dirname(dirname(__FILE__))) . '/upload';
        if (!file_exists($root . '/' . $root_account)) {
            mkdir($root . '/' . $root_account, 0755, true);
        }

        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/png"))) {
            $name = 'Image_' . date('d-m-Y-h-i-s');
            $file = pathinfo($_FILES["file"]["name"]);
            $file = $root_account . '/' . $name . '.' . $file['extension'];
            move_uploaded_file($_FILES["file"]['tmp_name'], "./upload/" . $file);

            echo $file;
        }
    }

    /* Test Send Mail */
    function test_sendmail()
    {
        $this->emailm->sendEmailAutomatic('hieu.huynhtrong90@gmail.com', 'Test Send Mail', 'Content Test Send Mail');
    }


    function generation_code()
    {
        $product_group = $this->productgroupm->get_items();
        foreach ($product_group->result() as $row) {
            $code = $this->filem->getCode($row->name);
            $this->db->update($this->prefix . 'product_group', array('code' => $code), array('product_group_id' => $row->product_group_id));
        }
        $product = $this->productm->get_items();
        foreach ($product->result() as $row) {
            $code = $this->productgroupm->get_code($row->product_group_id) . $this->filem->getCode($row->name, true);
            $this->db->update($this->prefix . 'product', array('code' => $code), array('product_id' => $row->product_id));
        }
    }

    function barcode()
    {
        if (!isset($_GET['product_code'])) die;
        if (empty($_GET['product_code'])) die;
        $product_code = $_GET['product_code'];
        $product_code = loai_bo_dau_TV($product_code);
        $product_code = strtoupper($product_code);
        require_once(dirname(dirname(__FILE__)) . '/libraries/barcodegen/class/BCGFontFile.php');
        require_once(dirname(dirname(__FILE__)) . '/libraries/barcodegen/class/BCGColor.php');
        require_once(dirname(dirname(__FILE__)) . '/libraries/barcodegen/class/BCGDrawing.php');
        require_once(dirname(dirname(__FILE__)) . '/libraries/barcodegen/class/BCGcode128.barcode.php');
        $colorFont = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);
        $font = new BCGFontFile(dirname(dirname(__FILE__)) . '/libraries/barcodegen/font/Arial.ttf', 18);
        $code = new BCGcode128(); // Or another class name from the manual
        $code->setScale(2); // Resolution
        $code->setThickness(30); // Thickness
        $code->setForegroundColor($colorFont); // Color of bars
        $code->setBackgroundColor($colorBack); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($product_code); // Text
        $drawing = new BCGDrawing('', $colorBack);
        $drawing->setBarcode($code);
        $drawing->draw();
        header('Content-Type: image/png');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }

    function barcode_print()
    {
        $data = array();
        $this->load->view('barcode/barcode_print', $data);
    }

    function sale()
    {
        $data = array();
        $this->data['title'] = 'Bán hàng';

        $this->data['content'] = $this->load->view('order/sale_screen', $data, TRUE);
        $this->_do_static_output();
    }

    function sale_print()
    {
        $data = array();
        $this->load->view('order/sale_print', $data);
    }

}

//------------------------------------
       
