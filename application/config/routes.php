<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	http://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There area two reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router what URI segments to use if those provided

| in the URL cannot be matched to a valid route.

|

*/



$route['default_controller'] = "index";

$route['404_override']       = '';

$route['login']              = 'index/login';

$route['account']            = 'index/account';

$route['forgot']             = 'index/forgot';

$route['logout']             = 'index/logout';



/* Route for local */

$route['action_list']             = 'action/action_list';

$route['action_transfer']         = 'action/save_transfer_friend';

$route['class_list']              = 'classc/class_list';

$route['load_class_by_date']      = 'classc/load_class_by_date';

$route['class_attendance']        = 'classc/load_class_attendance';

$route['class_hour_list']         = 'classhour/class_hour_list';

$route['date_off_list']           = 'dateoff/date_off_list';

$route['event_list']              = 'event/event_list';

$route['invoice_list']            = 'invoice/invoice_list';

$route['invoice_action']          = 'invoice/load_invoice_action';

$route['invoice_print']           = 'invoice/load_print';

$route['message_list']            = 'message/message_list';

$route['program_list']            = 'program/program_list';

$route['program_fee']             = 'program/load_program_fee';

$route['room_list']               = 'room/room_list';

$route['setting_general_list']    = 'settinggeneral/setting_general_list';

$route['student_list']            = 'student/student_list';

$route['student_action']          = 'student/load_student_action';

$route['student_history']         = 'student/load_student_history';

$route['student_transfer']        = 'student/load_transfer_friend';

$route['student_branch_change']   = 'student/load_branch_change';

$route['student_branch_transfer'] = 'student/load_student_branch_transfer';

$route['student_branch']          = 'student/load_all_student_branch';

$route['student_all']             = 'student/load_all_student';

$route['student_special_hour']    = 'student/check_special_hour';

$route['student_class_list']      = 'studentclass/student_class_list';

$route['student_schedule_list']   = 'studentschedule/student_schedule_list';

$route['student_schedule']        = 'studentschedule/load_student_schedule';

$route['change_schedule']         = 'studentschedule/load_change_schedule';

$route['change_schedule_save']    = 'studentschedule/save_change_schedule';

$route['teacher_list']            = 'teacher/teacher_list';

$route['branch_list']            = 'branch/branch_list';

$route['bill_income_list']            = 'billincome/bill_income_list';

$route['bill_outcome_list']            = 'billoutcome/bill_outcome_list';

$route['bill_transfer_list']            = 'billtransfer/bill_transfer_list';

$route['seller_list']            = 'seller/seller_list';

$route['student_consult_list/(:any)']            = 'studentconsult/student_consult_list/$1';

$route['bill_branch_bank_list']            = 'billbranchbank/bill_branch_bank_list';

$route['test']            = 'test';

/* Route for local */



/* End of file routes.php */

/* Location: ./application/config/routes.php */