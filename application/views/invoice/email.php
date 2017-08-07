<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Phiếu thu</title>
    <style type="text/css">
    @page {
        size: auto;   /* auto is the current printer page size */
        margin: 5mm;  /* this affects the margin in the printer settings */
    }

    .page-logo {
        float: left;
        display: block;
        height: 68px;
        width: auto;
        margin: 0;
    }

    .page-logo img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
        display: inline-block;
        vertical-align: middle;
    }
    .text-center {
            text-align:center;
    }
    .text-right {
        text-align:right;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd !important;
    }
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
        float: left;
    }

    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>
                <span class="page-logo">
                    <img style="width:25%;" src="<?php echo base_url() ?>resources_admin/images/logo.png" alt="Logo">
                </span>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1 style="text-align:center;">Phiếu thu</h1>
            <h2 style="text-align:center;">
                <small>Ngày <?php echo date('d') ?> Tháng <?php echo date('m') ?> Năm <?php echo date('Y') ?></small>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body" style="border:1px solid #ddd;">
                <div class="col-xs-5" style="padding:5px;float:left;">
                    <p>Tên học viên:
                        <?php echo $student_name ?>
                    </p>

                    <p>Mã học viên:
                        <?php echo $student_code ?>
                    </p>

                    <?php if (!empty($phone)): ?>
                        <p>ĐT:
                            <?php echo $phone ?>
                        </p>
                    <?php endif ?>
                    <?php if (!empty($email)): ?>
                        <p>Email:
                            <?php echo $email ?>
                        </p>
                    <?php endif ?>
                    <?php if($type == INVOICE_TYPE_4) : ?>
                        <?php if (!empty($current_branch_name)): ?>
                            <p>Trung tâm hiện tại:
                                <?php echo $current_branch_name; ?>
                            </p>
                        <?php endif ?>
                        <?php if (!empty($to_branch_name)): ?>
                            <p>Trung tâm chuyển :
                                <?php echo $to_branch_name; ?>
                            </p>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="col-xs-5 col-xs-offset-2 text-right" style="padding:5px;float:right;">
                    <p>Mã phiếu thu:
                        <?php echo $invoice_code ?>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
    <!-- / end client details section -->
    <div class="row">
        <table class="table table-bordered" style="width:100%;border: 1px solid #ddd !important;">
            <thead>
            <tr>
                <th class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    <h4>Diễn giải</h4>
                </th>
                <th class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    <h4>Số lượng</h4>
                </th>
                <th class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    <h4>Đơn giá</h4>
                </th>
                <th class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    <h4>Chiết khấu</h4>
                </th>
                <th class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    <h4>Thành tiền</h4>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $p_total = 0;
            $is_discount = false;
            $is_surcharge = false;

            if ($type == INVOICE_TYPE_6 || $type ==  INVOICE_TYPE_3 || $type == INVOICE_TYPE_4 || $type == INVOICE_TYPE_5 || $type == INVOICE_TYPE_7) : // Đặt cọc
            ?>
                <tr>
                    <td style="border: 1px solid #ddd !important;">
                        <?php echo $type ?>
                    </td>
                    <td class="text-center" style="text-align:;border: 1px solid #ddd !important;">
                        1
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                       0
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($total, 0) ?>
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($total, 0) ?>
                    </td>
                </tr>
            <?php
            endif;

            foreach ($detail as $key => $row) :
                if ($row['type'] == '1') :
            ?>
                    <tr>
                        <td colspan="5"center style="border: 1px solid #ddd !important;">
                            Chương trình <?php echo $row['name'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd !important;">
                            - Học phí
                        </td>
                        <td class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                            <?php echo $row['quantity'] ?>
                        </td>

                        <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                            <?php echo number_format($row['unit_price'], 0) ?>
                        </td>
                        <td class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                            <?php echo $row['discount'] ?>%
                        </td>
                        <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                            <?php echo number_format($row['total'], 0) ?>
                        </td>
                    </tr>
            <?php
                    $p_total += $row['total'];
                endif;

                if ($row['type'] == '2') :
            ?>
                <tr>
                    <td style="border: 1px solid #ddd !important;">
                        - <?php echo $row['name'] ?>
                    </td>
                    <td class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                        <?php echo $row['quantity'] ?>
                    </td>
                    <td class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                        <?php echo $row['discount'] ?>
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($row['unit_price'], 0) ?>
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($row['total'], 0) ?>
                    </td>
                </tr>
            <?php
                    $p_total += $row['total'];
                endif;

                if (($row['type'] == '1' || $row['type'] == '2') &&
                    (!isset($detail[$key + 1]) || 
                                        (isset($detail[$key + 1]) && $detail[$key + 1]['type'] == 1) ||
                                        (isset($detail[$key + 1]) && $detail[$key + 1]['type'] != 2))) :
            ?>
                    <tr>
                        <td class="text-right" colspan="3" style="text-align:right;border: 1px solid #ddd !important;">
                            Tổng tiền:
                        </td>
                        <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                            <?php echo number_format($p_total, 0); ?>
                        </td>
                    </tr>
            <?php
                    $p_total = 0;
                endif;

                if (!$is_discount && in_array($row['type'], array(3, 4, 5, 6, 7, 8))) :
            ?>
                <tr>
                    <tr>
                        <td colspan="5" style="border: 1px solid #ddd !important;">
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
                        <td colspan="5" style="border: 1px solid #ddd !important;">
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
                    <td style="border: 1px solid #ddd !important;">
                        - <?php echo $row['name'] ?>
                    </td>
                    <td class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                        <?php echo $row['quantity'] ?>
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($row['unit_price'], 0) ?>
                    </td>
                    <td class="text-right" style="text-align:right;border: 1px solid #ddd !important;">
                        <?php echo number_format($row['total'], 0) ?>
                    </td>
                </tr>
            <?php
                endif;

            endforeach;
            ?>
            </tbody>
            <tfoot>
            <tr class="text-right" style="text-align:right;">
                <td colspan="3" rowspan="4" class="text-center" style="text-align:center;border: 1px solid #ddd !important;">
                    Số tiền viết bằng chữ: <strong><?php echo html_entity_decode(convert_number_to_words($total), ENT_QUOTES, 'UTF-8'); ?></strong>
                </td>
                <td style="border: 1px solid #ddd !important;">Tổng tiền:</td>
                <td style="border: 1px solid #ddd !important;">
                    <?php echo number_format($sub_total, 0) ?>
                </td>
            </tr>
            <tr class="text-right" style="text-align:right;">
                <td style="border: 1px solid #ddd !important;">Chiết khấu:</td>
                <td style="border: 1px solid #ddd !important;">
                    <?php echo number_format($discount, 0) ?>
                </td>
            </tr>
            <tr class="text-right" style="text-align:right;">
                <td style="border: 1px solid #ddd !important;">Phụ thu:</td>
                <td style="border: 1px solid #ddd !important;">
                    <?php echo number_format($surcharge, 0) ?>
                </td>
            </tr>
            <tr class="text-right" style="text-align:right;">
                <td style="border: 1px solid #ddd !important;"><strong>Thanh toán:</strong></td>
                <td style="border: 1px solid #ddd !important;">
                    <strong><?php echo number_format($total, 0) ?></strong>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <!-- <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Bank details</h4>
                </div>
                <div class="panel-body">
                    <p>Your Name</p>
                    <p>Bank Name</p>
                    <p>SWIFT : --------</p>
                    <p>Account Number : --------</p>
                    <p>IBAN : --------</p>
                </div>
            </div> -->
        </div>
        <div class="col-xs-7">
            <div class="span7 text-right"  style="text-align:right;">
                Ngày in: <?php echo date('d/m/Y'); ?>
                <!-- <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Contact Details</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Email : you@example.com
                            <br>
                            <br> Mobile : --------
                            <br>
                            <br> Twitter : <a href="https://twitter.com/tahirtaous">@TahirTaous</a>
                        </p>
                        <h4>Payment should be made by Bank Transfer</h4>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

</body>

</html>
