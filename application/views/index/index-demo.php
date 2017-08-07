<!-- BEGIN CONTENT -->
<input type="hidden" id="pagination_url" value="<?php echo get_slug('report/student_item') ?>" />
<?php
$limit = 20;
if(isset($_GET['current_page'])) $current_page = $_GET['current_page'];
else $current_page = 1;

$filter = array();
if(isset($_GET['report_keyword'])&&!empty($_GET['report_keyword'])){
	$filter[] = '(s.name LIKE "%'.$_GET['report_keyword'].'%" OR s.student_code LIKE "%'.$_GET['report_keyword'].'%")';
}
if(isset($_GET['from_date'])&&!empty($_GET['from_date'])){
	$filter[] = 's.created_at >= "'.format_save_date($_GET['from_date']).' 00:00:00"';
}
if(isset($_GET['to_date'])&&!empty($_GET['to_date'])){
	$filter[] = 's.created_at <= "'.format_save_date($_GET['to_date']).' 23:59:59"';
}
if($this->session->userdata('branch')){
	$filter[] = 's.branch_id = "'.$this->session->userdata('branch').'"';
}

$expect_student = array();
$accept_student = array();

if (isset($_GET['f_type']) && !empty($_GET['f_type'])) {

	if($_GET['f_type'] == 1) { // tiem nang

		$student_1 = $this->db->select('s.student_id')
			->from($this->prefix .'student as s')
			->join($this->prefix .'student_class as sc', 's.student_id = sc.student_id')
			->where('s.deleted', 0)
			->where('s.status', 1)->get();

		foreach($student_1->result() as $v) {
			$expect_student[] = "'".$v->student_id."'";
		}

	} else if($_GET['f_type'] == 2) { // moi
		$student_2 = $this->db->select('object_id')
			->from($this->prefix .'action')
			->where('deleted', 0)
			->where('action', STUDENT_STATUS_0)
			->where('created_at <=', 'DATE_ADD(NOW(),INTERVAL 7 DAYS)')
			->get();

		foreach($student_2->result() as $v) {
			$accept_student[] = "'".$v->object_id."'";
		}

	} else if($_GET['f_type'] == 3) { // sap het han

		$student_3 = $this->db->select('s.student_id')
			->from($this->prefix .'student as s')
			->join($this->prefix .'student_class as sc', 's.student_id = sc.student_id')
			->where('s.deleted', 0)
			->where('sc.date_end <=', 'DATE_ADD(NOW(),INTERVAL 7 DAYS)')
			->get();

		foreach($student_3->result() as $v) {
			$accept_student[] = "'".$v->student_id."'";
		}

	} else if($_GET['f_type'] == 4) { // bao luu
		$student_4 = $this->db->select('object_id')
			->from($this->prefix .'action')
			->where('deleted', 0)
			->where('action', STUDENT_STATUS_1)
			->where('created_at <=', 'DATE_ADD(NOW(),INTERVAL 7 DAYS)')
			->get();

		foreach($student_4->result() as $v) {
			$accept_student[] = "'".$v->object_id."'";
		}
	} else if($_GET['f_type'] == 5) { // da nghi
		$student_5 = $this->db->select('object_id')
			->from($this->prefix .'action')
			->where('deleted', 0)
			->where('action', STUDENT_STATUS_4)
			->where('created_at <=', 'DATE_ADD(NOW(),INTERVAL 7 DAYS)')
			->get();

		foreach($student_5->result() as $v) {
			$accept_student[] = "'".$v->object_id."'";
		}
	}
	if($_GET['f_type'] != 1) { // da nghi
		if (count($accept_student) > 0) {
			$filter[] = 's.student_id  IN (' . implode(',', $accept_student) . ')';
		} else {
			$filter[] = 's.student_id IN ("")';
		}
	}

	if(count($expect_student) > 0) {
		$filter[] = 's.student_id NOT IN ('.implode(',', $expect_student).')';
	}
}

$filter[] = 's.deleted = 0';

if(!empty($filter)) $filter = 'WHERE '.implode(' AND ', $filter);
else $filter = '';

$select_from =
	'SELECT s.* FROM '.$this->prefix.'student s ';

$query_total = $select_from.$filter.' ORDER BY s.created_at DESC';

if(isset($_GET['f_type']) && $_GET['f_type'] == 4) {
	//print_r($query_total);die;
}
$query_page =  $query_total.' LIMIT '.($current_page-1)*$limit.','.$limit;

$result = $this->db->query($query_page)->result();
$total = $this->db->query($query_total)->num_rows();
$total_page = ($total%$limit==0)?($total/$limit):(floor($total/$limit)+1);


// DOANH THU 7 NGÀY GẦN NHẤT
$price_import = '(
	SELECT count(od.student_id) as total_price_import
	FROM '.$this->prefix.'student od
	WHERE od.student_id = o.student_id AND od.deleted = 0
	)';

$report_day = $this->db->query(
	'SELECT count(o.student_id) as profit, DATE(o.created_at) as profit_date, SUM('.$price_import.') as total_price_import
	 FROM '.$this->prefix.'student o
	 WHERE o.deleted = 0 AND o.created_at >= "'.date('Y-m-d 00:00:00', time()-365*24*3600).'" AND o.created_at <= "'.date('Y-m-d 23:59:59').'"
	 GROUP BY DATE(o.created_at)
	 ORDER BY DATE(o.created_at) DESC'
);
$total = 100;

// tiem nang
$expect_student = array();
$student_1 = $this->db->select('s.student_id')
	->from($this->prefix .'student as s')
	->join($this->prefix .'student_class as sc', 's.student_id = sc.student_id')
	->where('s.deleted', 0)
	->where('s.status', 1)->get();

foreach($student_1->result() as $v) {
	$expect_student[] = "'".$v->student_id."'";
}
$filter = array();
if(count($expect_student) > 0) {
	$filter[] = 's.student_id NOT IN (' . implode(',', $expect_student) . ')';
} else {
	$filter[] = 's.student_id NOT IN ("")';
}
$filter[] = 's.deleted = 0';

if(!empty($filter)) $filter = 'WHERE '.implode(' AND ', $filter);
else $filter = '';

$select_from =
	'SELECT s.* FROM '.$this->prefix.'student s ';

$query_total = $select_from.$filter.' ORDER BY s.created_at DESC';
$total_0 = $this->db->query($query_total)->num_rows();

$total = $this->db->query('SELECT s.* FROM '.$this->prefix.'student s WHERE s.branch_id = '.(isset($_GET["branch_id"])?$_GET["branch_id"]:"").' s.deleted = 0')->num_rows();

// moi
$total_1 = 0;
$student_2 = $this->db->select('object_id')
	->from($this->prefix .'action')
	->where('deleted', 0)
	->where('action', STUDENT_STATUS_0)
	->where('created_at <=', 'DATE_ADD(NOW(),INTERVAL 7 DAYS)')
	->group_by('object_id')
	->get();
foreach($student_2->result() as $v) {
	$total_1++;
}

$sub_total = $total_0 + $total_1;
if($total > 0) {
	$total_0 = round(($total_0 / $total) * 100);
	$total_1 = round(($total_1 / $total) * 100);
	$total_2 = round((($total - $sub_total) / $total) * 100);
}


?>

<div class="page-content-wrapper">
	<div class="page-content">

		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">google.load("visualization", "1", {packages:["corechart", "line"]});</script>
		<div class="col-md-12">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Tình hình học viên mới trong tháng</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<img src="http://edu-local.itvsoft.asia/resources_admin/images/1.jpg" alt="Logo">
						</div>
					</div>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
		<div class="clearfix"></div>

		<div class="col-md-6">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Học viên theo nhóm</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<img src="http://edu-local.itvsoft.asia/resources_admin/images/2.jpg" alt="Logo">
						</div>
					</div>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
		<div class="col-md-6">
			<!-- BEGIN PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Học viên mới 7 ngày gần nhất</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<img src="http://edu-local.itvsoft.asia/resources_admin/images/3.jpg" alt="Logo">
						</div>
					</div>
				</div>
			</div>
			<!-- END PORTLET-->
		</div>
		<div class="clearfix"></div>

		<!-- END CONTENT -->
		<style type="text/css">
			.portlet > .portlet-title{
				margin-bottom: 0;
			}
			.portlet > .portlet-body{
				padding-top: 0;
			}
		</style>
		<script type="text/javascript">
			$(window).resize(function(){
				drawChart();
				drawChart1();
				drawChart2();
				drawChart3();
			});
		</script>


		<!-- BEGIN PAGE CONTENT-->
		<!-- BEGIN PORTLET-->
		<div class="portlet light report_list">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp"></i>
					<span class="caption-subject font-green-sharp bold uppercase">Thống kê học viên</span>
				</div>
				<div class="tools">
					<div class="pull-right">
						<input type="text" class="form-control report_filter" name="report_keyword" placeholder="Tìm kiếm">
					</div>
					<div class="form-group pull-right m-r-sm">
						<select class="form-control report_filter" name="f_type" id="f_type">
							<option value="">- Loại -</option>

							<option value="1" >Học viên tiềm năng</option>

							<option value="2" >Học viên mới</option>

							<option value="3" >Học viên sắp hết hạn</option>

							<option value="4" >Học viên bảo lưu</option>

							<option value="5" >Học viên đã nghỉ</option>

						</select>
					</div>
					<a class="btn btn-print btn-primary pull-right admin-btn m-r" href="javascript:void(0)" onclick="print_report();"><i class="fa fa-print"></i> in báo cáo</a>
					<a class="btn btn-success pull-right admin-btn m-r" href="javascript:void(0)" onclick="show_report();"><i class="fa fa-refresh"></i> xem báo cáo</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group m-t-sm">
									<div class="col-md-4">
										<div class="m-t-sm">Từ ngày:</div>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control datepicker report_filter" name="from_date"></input>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-4">
								<div class="form-group m-t-sm">
									<div class="col-md-4">
										<div class="m-t-sm">Đến ngày:</div>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control datepicker report_filter" name="to_date"></input>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

							<div class="col-md-4">
								<div class="form-group m-t-sm">
									<div class="col-md-4">
										<div class="m-t-sm">Trung tâm:</div>
									</div>
									<div class="col-md-8">
										<select class="form-control report_filter" name="branch_id">
											<option value="">- Tất cả -</option>
											<?php
											$product_list = $this->branchm->get_items();
											foreach($product_list->result() as $row){ ?>
												<option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

						</div>

						<div class="table-container table-responsive m-t">

							<div id="report_list_guts">
								<table class="table table-hover">
									<thead>
									<tr role="row" class="heading">
										<th>
											Ngày tạo
										</th>
										<th>
											Trung tâm
										</th>
										<th>
											Mã học viên
										</th>
										<th>
											Tên học viên
										</th>
										<th>
											Thông tin học viên
										</th>
										<th>
											Trạng thái
										</th>
									</tr>
									</thead>
									<tbody>
									<?php foreach($result as $key=>$row){

										if ($row->status == 1) $status = '<span class="text-success">Active</span>';
										else $status = '<span class="text-danger">Inactive</span>';

										$money = 0;
										$money_data = $this->db->where('student_id', $row->student_id)->where('deleted',0)->get($this->prefix . 'student_money');

										foreach($money_data->result() as $value) {
											$money += $value->money;
										}

										$text = "<strong style='font-size: 12px;'>Ngày sinh:</strong> " . format_get_date($row->birthday) . "<br/>";
										$text .= "<strong style='font-size: 12px;'>Tên phụ huynh:</strong> " . $row->parent_name . "<br/>";
										$text .= "<strong style='font-size: 12px;'>Địa chỉ:</strong> " . $row->address . "<br/>";
										$text .= "<strong style='font-size: 12px;'>Email:</strong> " . $row->email . "<br/>";
										$text .= "<strong style='font-size: 12px;'>Điện thoại:</strong> " . $row->phone. "<br/>";
										$text .= "<strong style='font-size: 12px;'>Số tiền tích luỹ:</strong> " . number_format($money)."đ";

										?>

										<tr role="row" class="<?php echo $key%2==0?'odd':'even' ?>">
											<td><?php echo format_get_date($row->created_at) ?></td>
											<td><?php echo $this->branchm->get_name($row->branch_id); ?></td>
											<td><?php echo $row->student_code ?></td>
											<td><?php echo $row->name ?></td>
											<td><?php echo $text ?></td>
											<td><?php echo $status ?></td>
										</tr>
									<?php } ?>
									<?php if(empty($result)){ ?>
										<tr><td colspan="7" style="text-align:center;">Không tìm thấy kết quả</td></tr>
									<?php } ?>
									</tbody>
								</table>

								<input type="hidden" id="pagination_target" value="report_list" />
								<input type="hidden" id="pagination_total" value="<?php echo $total_page; ?>" />
								<?php if($total>$limit){ ?>
									<ul class="pagination prev_next">
										<li>
											<a href="javascript:void(0)" class="prev_btn <?php if($current_page==1) echo 'disabled' ?>">
												<i class="fa fa-angle-left"></i>
											</a>
										</li>
										<?php $page_prev = ($current_page-1)+($current_page==1?1:0)-($current_page==$total_page?1:0);
										if($page_prev>=1){ ?>
											<li>
												<a href="javascript:void(0)" class="num_btn <?php if($current_page==1) echo 'disabled' ?>">
													<?php echo ($current_page-1)+($current_page==1?1:0)-($current_page==$total_page?1:0) ?>
												</a>
											</li>
										<?php } ?>
										<li>
											<a href="javascript:void(0)" class="num_btn <?php if($current_page!=1&&$current_page!=$total_page) echo 'disabled' ?>">
												<?php echo $current_page+($current_page==1?1:0)-($current_page==$total_page?1:0) ?>
											</a>
										</li>
										<?php $page_next = ($current_page+1)+($current_page==1?1:0)-($current_page==$total_page?1:0);
										if($page_next<=$total_page){ ?>
											<li>
												<a href="javascript:void(0)" class="num_btn <?php if($current_page==$total_page) echo 'disabled' ?>">
													<?php echo $current_page+1+($current_page==1?1:0)-($current_page==$total_page?1:0) ?>
												</a>
											</li>
										<?php } ?>
										<li>
											<a href="javascript:void(0)" class="next_btn <?php if($current_page==$total_page) echo 'disabled' ?>">
												<i class="fa fa-angle-right"></i>
											</a>
										</li>
									</ul>
									<div class="clearfix"></div>
								<?php } ?>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PORTLET-->
		<!-- END PAGE CONTENT-->
	</div>
</div>