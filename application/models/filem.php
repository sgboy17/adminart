<?php

class Filem extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getCell(&$worksheet, $row, $col, $default_val = '')
    {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
    }

    function getImage($url, $name)
    {
        if (!@getimagesize($url)) return '';

        $root_account = $this->session->userdata('root_account');
        $root = dirname(dirname(dirname(__FILE__))) . '/upload';
        if (!file_exists($root . '/' . $root_account)) {
            mkdir($root . '/' . $root_account, 0755, true);
        }

        $base_dir = dirname(dirname(dirname(__FILE__)));
        $image_data = file_get_contents($url);
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        if (strpos($ext, 'jpg')) $ext = 'jpg';
        else if (strpos($ext, 'jpeg')) $ext = 'jpeg';
        else if (strpos($ext, 'bmp')) $ext = 'bmp';
        else if (strpos($ext, 'png')) $ext = 'png';
        else if (strpos($ext, 'gif')) $ext = 'gif';
        else $ext = 'png';
        $path = $root_account . '/' . $name . '.' . $ext;
        $save = file_put_contents($base_dir . '/upload/' . $path, $image_data);
        return $path;
    }

    function getCode($name, $is_number = false)
    {
        if (!$is_number) {
            $name = explode(' ', str_replace(array('-', '  ', '>', '<', '/'), '', $name));
            $code = array();
            foreach ($name as $row) {
                if (!empty($row)) {
                    $code[] = strtoupper(loai_bo_dau_TV(mb_substr($row, 0, 1)));//.strtoupper(loai_bo_dau_TV(mb_substr($row,-1,1)));
                }
            }
            $code = implode('', $code);
        } else {
            $code = abs(crc32($name));
        }
        return $code;
    }

    function import_file($table)
    {
        $file = dirname(dirname(dirname(__FILE__))) . '/upload/' . $_GET['file'];
        require_once dirname(dirname(__FILE__)) . '/libraries/PHPExcel/Classes/PHPExcel.php';
        if (!empty($file)) {
            // Import Product
            if ($table == 'student_schedule') {
                $inputFileType = PHPExcel_IOFactory::identify($file);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $reader = $objReader->load($file);

                $data = $reader->getSheet(0);
                $isFirstRow = TRUE;
                $i = 0;
                $k = $data->getHighestRow();
                for ($i = 0; $i < $k; $i += 1) {
                    $j = 1;
                    if ($isFirstRow) {
                        $isFirstRow = FALSE;
                        continue;
                    }
                    $class_code = $this->getCell($data, $i, $j++);
                    $student_code = $this->getCell($data, $i, $j++);
                    $student_name = $this->getCell($data, $i, $j++);
                    $excelDate = $this->getCell($data, $i, $j++);
                    $status = $this->getCell($data, $i, $j++);

                    if (!is_float($excelDate)) {
                        $timestamp = strtotime($excelDate);//DateTime::createFromFormat("d/m/Y", $excelDate);
                        //$timestamp = $dtime->getTimestamp();
                    } else {
                        $timestamp = PHPExcel_Shared_Date::ExcelToPHP($excelDate);
                    }
                    $date = date('Y-m-d', $timestamp);
                    $getdate = getdate($timestamp);

                    $class_data =  $this->classm->get_item_by_class_code($class_code);
                    if (empty($class_data)) {
                        continue;
                    }
                    $class_hour = $this->classhourm->get_item_by_class_id_and_date($class_data['class_id'], $getdate['wday']);
                    $class_hour_id = !empty($class_hour) ? $class_hour->class_hour_id : null;
                    $student_id = $this->studentm->get_id_by_code($student_code);

                    $deleted = (strtolower($status) == 'yes') ? 0 : 1;
                    $branch_id = $this->session->userdata('branch');


                    $is_insert = false;
                    $student_schedule_id = $this->studentschedulem->get_id($student_id, $class_hour_id, $date);
                    if (empty($student_schedule_id)) {
                        $is_insert = true;
                        $student_schedule_id = $this->uuid->v4();
                    }

                    if (empty($branch_id) || empty($student_id) || empty($class_hour_id)) {
                        continue;
                    }

                    $student_class = $this->studentclassm->get_item_by_student_class($student_id, $class_data['class_id']);

                    if (empty($student_class)) {
                        continue;
                    }


                    if ($is_insert) {
                        $data_insert = array(
                            'student_schedule_id' => $student_schedule_id,
                            'branch_id' => $branch_id,
                            'student_id' => $student_id,
                            'class_hour_id' => $class_hour_id,
                            'date' => $date,
                            'hour' => $student_class['hour'],
                            // 'status' => 0,
                            'created_at' => date("Y/m/d h:i:s"),
                            'updated_at' => date("Y/m/d h:i:s"),
                            'deleted' => $deleted
                        );

                        $this->db->insert($this->prefix . 'student_schedule', $data_insert);
                    } else {
                        $data_update = array(
                            'branch_id' => $branch_id,
                            'student_id' => $student_id,
                            'class_hour_id' => $class_hour_id,
                            'date' => $date,
                            'hour' => $student_class['hour'],
                            // 'status' => 0,
                            'updated_at' => date("Y/m/d h:i:s"),
                            'deleted' => $deleted
                        );
                        $this->db->update($this->prefix . 'student_schedule', $data_update, array('student_schedule_id' => $student_schedule_id));
                    }

                }
            }
        }

        echo json_encode(10);
    }

}
