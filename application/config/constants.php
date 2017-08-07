<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// Mail
define('MAIL_PROTOCOL', 'smtp');
define('MAIL_HOST', 'ssl://smtp-pulse.com');
define('MAIL_PORT', '465');
define('MAIL_USER', 'info@innotech-vn.com');
define('MAIL_PASS', 'WkYeC3K9Mat');
define('MAIL_FROM', 'sale@innotech-vn.com');

// SMS
define('SMS_API', '6A4F36A964313382CE096F587F146E');
define('SMS_KEY', '9628259907E5718B506E1B6DEA5C1F');

// Plan Membership
define('BRANCH_PLAN', '0|0|0|0');
define('PRODUCT_PLAN', '0|0|0|0');
define('CUSTOMER_PLAN', '0|0|0|0');
define('EMPLOYEE_PLAN', '0|0|0|0');

// class type
define('CLASS_TYPE_1', '1'); // lop
define('CLASS_TYPE_2', '2'); // nhom

// student status
define('STUDENT_STATUS_0', 'Đăng ký mới'); // áp dụng lần đầu
define('STUDENT_STATUS_1', 'Bảo lưu'); // áp dụng khi đang học
define('STUDENT_STATUS_2', 'Chuyển lớp'); // áp dụng khi đang học
define('STUDENT_STATUS_3', 'Lên lớp'); // áp dụng khi đang học
define('STUDENT_STATUS_4', 'Nghỉ học'); // áp dụng khi đang học
define('STUDENT_STATUS_5', 'Đăng ký học tiếp'); // áp dụng khi lên lớp hoặc nghỉ học
define('STUDENT_STATUS_6', 'Học tiếp'); // áp dụng sau bảo lưu
define('STUDENT_STATUS_7', 'Hoàn tác'); // xóa khi làm sai
define('STUDENT_STATUS_8', 'Chuyển trung tâm'); // chuyển trung tâm
define('STUDENT_STATUS_9', 'Chuyển tiền'); // chuyển tiền
define('STUDENT_STATUS_10', 'Học thử'); // học thử
define('STUDENT_STATUS_11', 'Đã đóng'); // đã đóng học phí
define('STUDENT_STATUS_12', 'Chuyển giờ'); // đã đóng học phí
define('STUDENT_STATUS_13', 'Gia hạn'); // đã đóng học phí
define('STUDENT_STATUS_14', 'Thêm buổi'); // thêm buổi


// invoice type
define('INVOICE_TYPE_0', 'Đăng ký mới');
define('INVOICE_TYPE_1', 'Đăng ký học tiếp');
define('INVOICE_TYPE_2', 'Học thử');
define('INVOICE_TYPE_3', 'Chuyển giờ vàng');
define('INVOICE_TYPE_4', 'Chuyển trung tâm');
define('INVOICE_TYPE_5', 'Lên lớp');
define('INVOICE_TYPE_6', 'Đặt cọc');
define('INVOICE_TYPE_7', 'Chuyển giờ');


// invoice detail type
define('INVOICE_DETAIL_TYPE_1', '1'); // Chương trình
define('INVOICE_DETAIL_TYPE_2', '2'); // Dụng cụ
define('INVOICE_DETAIL_TYPE_3', '3'); // Sự kiện
define('INVOICE_DETAIL_TYPE_4', '4'); // Đặt cọc
define('INVOICE_DETAIL_TYPE_5', '5'); // Học thử đóng 1 lần
define('INVOICE_DETAIL_TYPE_6', '6'); // Học thử đóng 2 lần
define('INVOICE_DETAIL_TYPE_7', '7'); // Tiền tích lũy
define('INVOICE_DETAIL_TYPE_8', '8'); // Tiền được chuyển
define('INVOICE_DETAIL_TYPE_9', '9'); // Giờ vàng


/* End of file constants.php */
/* Location: ./application/config/constants.php */