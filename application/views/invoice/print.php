<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Phiếu thu</title>
    <style>
        @media print {
            body,
            div[size="A5"] {
                margin: 0;
                box-shadow: 0;
            }
        }

        body {
            background: rgb(204, 204, 204);
            font-family: "Times New Roman", Georgia, Serif;
        }
    </style>
</head>

<body>
<?php
    $str[1] =  "Liên 1: Lưu";
    $str[2] =  "Liên 2: Giao cho PH";
    $str[3] =  "Liên 3: Lưu BPKT";
?>
<?php for($k = 1; $k < 4; $k++) : ?>
<div size="A5"
     style="background: url('<?php echo base_url() ?>resources_admin/images/bg_print.jpg'); width:452px; height:670px; display: block; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);">
    <div class="header" style="margin-bottom: 0px; padding-top: 15px; padding-left: 15px;">
        <div class="logo" style="float:left;">
            <img width="90" src="<?php echo base_url() ?>resources_admin/images/logo.png" alt="Logo">
        </div>
        <div class="information" style="float: left; line-height: 13px; margin-left: 17px; width: 330px;">
            <h3 style="font-size: 10px; text-transform: uppercase; margin: 0px;"><?php echo $branch['name'] ?></h3>

            <p style="font-size: 10px; margin: 0px;">ĐC: <b><?php echo $branch['address'] ?></b></p>

            <p style="font-size: 10px; margin: 0px;">ĐT: <b><?php echo $branch['phone'] ?></b></p>
        </div>
    </div>
    <div style="clear:both;"></div>
    <div class="content" style="padding-top: 10px;">
        <div class="content_header" style="position: relative; padding-right:20px">
            <h1 style="text-align: center; font-size: 26px ;margin: 0;">PHIẾU THU</h1>

            <p style="margin-right: 20px; margin: 0; text-align: right; right: 20px; top: 9px; font-size: 10px; position: absolute; font-style: italic;"
               class="number">Số PT: <?php echo $invoice_code ?></p>

            <p style="margin-right: 20px; margin: 0; text-align: right; right: 20px; top: 24px; font-size: 10px; position: absolute; font-style: italic;"
               class="number"><?php echo isset($str[$k]) ? $str[$k] : ""; ?></p>

            <p style="font-style: italic; text-align: center; margin: 0; margin-top: -5px; font-size: 10px;" class="date">
                Ngày <?php echo date('d', strtotime($created_at)); ?> Tháng <?php echo date('m', strtotime($created_at)); ?> Năm <?php echo date('Y', strtotime($created_at)); ?></p>
        </div>
        <div class="content_information" style="border: 1px solid #f182ab; margin: 0 20px; margin-top: 4px;">
            <table style="width: 94%; margin: 4px 10px; font-size: 12px;">
                <tbody>
                <tr>
                    <td>Tên học viên: <?php echo $student_name; ?></td>
                    <td>ĐT: <?php echo !empty($phone) ? $phone : ''; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Lý do thu: <?php echo $type; ?></td>
                    <!--<td>Ngày học:  Kết thúc: </td>-->
                </tr>
                <!--<tr>
                    <td>Khóa: Lớp: </td>
                    <td>Giờ học: </td>
                </tr>-->
                <?php if($type == INVOICE_TYPE_4) : ?>
                <tr>
                    <?php if (!empty($current_branch_name)): ?>
                    <td>Trung tâm hiện tại: <?php echo $current_branch_name; ?></td>
                    <?php endif ?>
                    <?php if (!empty($to_branch_name)): ?>
                    <td>Trung tâm chuyển : <?php echo $to_branch_name; ?></td>
                    <?php endif ?>
                </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="content_detail" style="margin: 10px 20px; margin-bottom: 0px;">
            <table style="width: 100%; line-height: 18px;" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; width:40%; font-weight:bold;">
                        Diễn giải
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; width:15%; font-weight:bold;">
                        Số lượng
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; width:15%; font-weight:bold;">
                        Đơn giá
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; width:15%; font-weight:bold;">
                        Chiết khấu
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; font-weight:bold;">
                        Thành tiền
                    </td>
                </tr>
                </thead>
                <tbody>
                <?php
                $p_total = 0;
                $is_discount = false;
                $is_surcharge = false;

                if ($type == INVOICE_TYPE_6 || $type == INVOICE_TYPE_3 || $type == INVOICE_TYPE_4 || $type == INVOICE_TYPE_5 || $type == INVOICE_TYPE_7) : // Đặt cọc
                    ?>
                    <tr>
                        <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-right:none; border-bottom:none; border-top:none; text-align:left;"><?php echo $type ?></td>
                        <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none;">
                            1
                        </td>
                        <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none;"><?php echo number_format($total, 0) ?></td>
                        <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-bottom:none; border-top:none;"><?php echo number_format($total, 0) ?></td>
                    </tr>
                    <?php
                endif;

                foreach ($detail as $key => $row) :
                    if ($row['type'] == '1') :
                ?>
                  <tr>
                      <td colspan="5" style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab; text-align:left;">
                          Chương trình <?php echo $row['name'] ?>
                      </td>
                  </tr>
                  <tr>
                      <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-right:none; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab; text-align:left;">- Học phí</td>
                      <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab;"><?php echo $row['quantity'] ?></td>
                      <td style="border: 1px solid #f182ab; text-align: right;padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab;"><?php echo number_format($row['unit_price'], 0) ?></td>
                      <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab;"><?php echo $row['discount'] ?>%</td>
                      <td style="border: 1px solid #f182ab; text-align: right;padding: 3px; font-size: 11px; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab;"><?php echo number_format($row['total'], 0) ?></td>
                  </tr>
                <?php
                        $p_total += $row['total'];
                    endif;

                    if ($row['type'] == '2') :
                ?>
                    <tr>
                      <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-right:none; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab; text-align:left;">- <?php echo $row['name'] ?></td>
                      <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px; border-right:none;border-bottom:none;border-top:none;border-bottom:1px dotted #f182ab;"><?php echo $row['quantity'] ?></td>
                      <td style="border: 1px solid #f182ab; text-align: right;padding: 3px; font-size: 11px; border-right:none;border-bottom:none;border-top:none;border-bottom:1px dotted #f182ab;"><?php echo number_format($row['unit_price'], 0) ?></td>
                      <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px; border-right:none;border-bottom:none;border-top:none;border-bottom:1px dotted #f182ab;"><?php echo $row['discount'] ?>%</td>
                      <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-bottom:none; border-top:none; border-bottom:1px dotted #f182ab;"><?php echo number_format($row['total'], 0) ?></td>
                    </tr>
                  <?php
              $p_total += $row['total'];
                endif;
/*
                if (($row['type'] == '1' || $row['type'] == '2') &&
                    (!isset($detail[$key + 1]) ||
                        (isset($detail[$key + 1]) && $detail[$key + 1]['type'] == 1) ||
                        (isset($detail[$key + 1]) && $detail[$key + 1]['type'] != 2))) :
            ?>
                    <tr>
                        <td colspan="3" style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-right:none; border-bottom:none; border-top:none; text-align:left;">
                            Tổng tiền
                        </td>
                        <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-bottom:none; border-top:none;">
                            <?php echo number_format($p_total, 0); ?>
                        </td>
                    </tr>
            <?php
                    $p_total = 0;
                endif;
*/
                if (!$is_discount && in_array($row['type'], array(3, 4, 5, 6, 7, 8))) :
            ?>
              <tr>
              <tr>
                  <td colspan="5" style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-bottom:none; border-bottom:1px dotted #f182ab; text-align:left; border-top:none;">
                      Giảm trừ
                  </td>
              </tr>
          </tr>
          <?php
              $is_discount = true;
          endif;

          if (!$is_surcharge && in_array($row['type'], array(9))) :
      ?>
          <tr>
              <tr>
                  <td colspan="5" style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; padding: 0px 10px; border-bottom:none; border-bottom:1px dotted #f182ab; text-align:left; border-top:none;">
                      Phụ thu
                  </td>
              </tr>
          </tr>
      <?php
              $is_surcharge = true;
          endif;

          if (in_array($row['type'], array(3, 4, 5, 6, 7, 8, 9))) :
      ?>
        <tr>
            <td style="border: 1px solid #f182ab; text-align: center; padding: 0px 10px; font-size: 11px; border-right:none; border-bottom:none; border-top:none; text-align:left;">- <?php echo $row['name'] ?></td>
            <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none;"><?php echo $row['quantity'] ?></td>
            <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-right:none; border-bottom:none; border-top:none;"><?php echo number_format($row['unit_price'], 0) ?></td>
            <td style="border: 1px solid #f182ab; text-align: right; padding: 3px; font-size: 11px; border-bottom:none; border-top:none;"><?php echo number_format($row['total'], 0) ?></td>
        </tr>

      <?php
          endif;

      endforeach;
                ?>
                </tbody>
            </table>
            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="border: 1px solid #f182ab; text-align: center; padding: 3px; font-size: 11px; width: 55%; border-right: none;">
                        Số tiền viết bằng chữ: <b><?php echo convert_number_to_words($total); ?></b></td>
                    <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;padding: 0;border: 0;">
                        <table style="width: 100%;" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none; border-right:none; text-align:left; padding: 2px 10px; width: 49%;">
                                    Tổng tiền:
                                </td>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none;border-left:none; text-align:left; padding: 2px 10px; width: 49%;"><?php echo number_format($sub_total, 0) ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none; border-right:none; text-align:left; padding: 2px 10px; width: 49%;">
                                    Chiết khấu:
                                </td>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none;border-left:none; text-align:left; padding: 2px 10px;"><?php echo number_format($discount, 0) ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none; border-right:none; text-align:left; padding: 2px 10px; width: 49%;">
                                    Phụ thu:
                                </td>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border-bottom:none;border-left:none; text-align:left; padding: 2px 10px;"><?php echo number_format($surcharge, 0) ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px; text-align:left; border-right:none; padding: 0px 10px; width: 49%;">
                                    Còn lại:
                                </td>
                                <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px; text-align:left;border-left:none;padding: 2px 10px;">
                                    <b><?php echo number_format($total, 0) ?></b></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width: 100%;margin-top:10px;">
                <tbody>
                <tr>
                    <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border:none;">
                        Giám đốc
                        <br>(Ký tên)
                        <br>
                        <br>
                        <br>
                        <br>.......................
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border:none;">
                        KTT
                        <br>(Ký tên)
                        <br>
                        <br>
                        <br>
                        <br>.......................
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border:none;">
                        Thủ quỹ
                        <br>(Ký tên)
                        <br>
                        <br>
                        <br>
                        <br>.......................
                    </td>
                    <td style="border: 1px solid #f182ab; text-align: center;padding: 3px; font-size: 11px;border:none;">
                        Người nộp tiền
                        <br>(Ký tên)
                        <br>
                        <br>
                        <br>
                        <br>.......................
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer">
        <p class="warning" style="text-align:center; font-size: 12px; margin-top:0px; margin-bottom: 3px;">
            (Cần kiểm tra đối chiếu khi <b>lập</b>, <b>giao</b>, <b>nhận</b> hóa đơn)
        </p>
    </div>
    <p style="margin: 0; text-align: right; font-size: 12px; margin-right: 20px; position: relative; bottom: 0px; float:right;">
        Ngày in: <?php echo date('d/m/Y'); ?>
    </p>
</div>
<div style="div-break-after: always; clear: both;"></div>
<?php endfor; ?>
</body>

</html>
