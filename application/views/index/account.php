<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN PAGE CONTENT-->
		<!-- BEGIN PORTLET-->
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-bar-chart font-green-sharp"></i>
					<span class="caption-subject font-green-sharp bold uppercase">Tài khoản</span>
				</div>
			</div>
			<div class="portlet-body">
			<form action="" method="post" id="account_form">
				<?php $result = $this->userm->get_user(); ?>
                <?php if(isset($message)): ?>
                    <div class="alert alert-success">
						<button class="close" data-close="alert"></button>
			            <?php echo $message; ?>
			        </div>
           		<?php endif; ?>
			    <div class="row">
			        <div class="col-md-6">
						<div class="modal-body"><h4>Hình đại diện</h4></div>
						<div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Hình đại diện:</div>
			                </div>
			                <div class="col-md-9">
			                    <div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px;" id="image_src">
										<img src="<?php echo base_url() ?><?php echo image('upload/'.$result['avatar'],200,150); ?>" />
									</div>
									<div>
										<a href="javascript:void(0)" id="image_avatar" class="btn default fileinput-exists">Chọn hình</a>
										<input type="hidden" id="avatar" name="avatar" value="<?php echo $result['avatar']; ?>" />
									</div>
								</div>
			                </div>
			            </div>
			            <div class="clearfix"></div>
						<div class="modal-body"><h4>Thông tin cơ bản</h4></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Họ tên:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="text" name="name" value="<?php echo $result['name'] ?>" placeholder="tên nhân viên" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Ngày sinh:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="text" name="birthday" value="<?php echo format_get_date($result['birthday']) ?>" placeholder="ngày sinh" class="form-control datepicker"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Giới tính:</div>
			                </div>
			                <div class="col-md-9">
			                	<select class="form-control" name="gender">
				                    <option value="">- giới tính -</option>
				                    
				            		<option value="1" <?php if($result['gender']==1) echo 'selected=""'; ?>>Nam</option>
				            
				            		<option value="2" <?php if($result['gender']==2) echo 'selected=""'; ?>>Nữ</option>
			            
				                </select>
			                </div>
			            </div>
			            <div class="clearfix"></div>
					</div>
					<div class="col-md-6">
						<div class="modal-body"><h4>Đổi mật khẩu</h4></div>
						<div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Mật khẩu:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="password" name="password" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
						<div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Xác nhận MK:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="password" id="re-password" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
						<div class="modal-body"><h4>Thông tin liên lạc</h4></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Địa chỉ:</div>
			                </div>
			                <div class="col-md-9">
                    			<input type="text" name="address" value="<?php echo $result['address'] ?>" placeholder="địa chỉ" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Quốc gia:</div>
			                </div>
			                <div class="col-md-9">
			                    <select class="form-control" name="country_id">
				                    <option value="">- quốc gia -</option>
					                    	
				                    <?php 
				                    $country_list = $this->countrym->get_items();
				                    foreach($country_list->result() as $row){ ?>
				                    <option value="<?php echo $row->country_id ?>" <?php if($result['country_id']==$row->country_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
				                    <?php } ?>
			        
				                </select>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Tỉnh/Thành:</div>
			                </div>
			                <div class="col-md-9">
			                    <select class="form-control" name="city_id">
				                    <option value="">- tỉnh/thành -</option>
				                    	
				                    <?php 
				                    $city_list = $this->citym->get_items();
				                    foreach($city_list->result() as $row){ ?>
				                    <option value="<?php echo $row->city_id ?>" data="<?php echo $row->country_id ?>" <?php if($result['city_id']==$row->city_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
				                    <?php } ?>
			        
				                </select>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Quận/Huyện:</div>
			                </div>
			                <div class="col-md-9">
			                    <select class="form-control" name="district_id">
				                    <option value="">- quận/huyện -</option>
				                    	
				                    <?php 
				                    $district_list = $this->districtm->get_items();
				                    foreach($district_list->result() as $row){ ?>
				                    <option value="<?php echo $row->district_id ?>" data="<?php echo $row->city_id ?>" <?php if($result['district_id']==$row->district_id) echo 'selected=""'; ?>><?php echo $row->name ?></option>
				                    <?php } ?>
			        
				                </select>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">SĐT 1:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="text" name="phone_1" value="<?php echo $result['phone_1'] ?>" placeholder="điện thoại 1" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">SĐT 2:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="text" name="phone_2" value="<?php echo $result['phone_2'] ?>" placeholder="điện thoại 2" class="form-control"></input>
			                </div>
			            </div>
			            <div class="clearfix"></div>
			            <div class="form-group m-t-sm">
			                <div class="col-md-3">
			                    <div class="m-t-sm">Email:</div>
			                </div>
			                <div class="col-md-9">
			                    <input type="text" id="email" name="email" value="<?php echo $result['email'] ?>" placeholder="email" class="form-control"></input>
			                	<?php if(isset($error_email)){ ?>
								<label for="email" generated="true" class="error"><?php echo $error_email ?></label>
								<?php } ?>
			                </div>
			            </div>
			            <div class="clearfix"></div>
					</div>
			    </div>
			    <div class="clearfix m-b"></div>
				<div class="pull-right">
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> sửa</button>
					<a class="btn btn-default" href="<?php echo get_slug('index') ?>"><i class="fa fa-sign-out"></i> thoát</a>
				</div>
			    <div class="clearfix"></div>
			</form>
			</div>
		</div>
		<!-- END PORTLET-->
		<!-- END PAGE CONTENT-->
	</div>
</div>
<!-- END CONTENT -->