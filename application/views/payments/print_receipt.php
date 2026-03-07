<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IMPRONEX SECURITY SERVICES | Payment Receipt</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url()?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url()?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <style type="text/css">
    @media print {
      .no-print,
      .main-sidebar,
      .left-side,
      .main-header,
      .content-header {
        display: none !important;
      }
      .content-wrapper,
      .right-side,
      .main-footer {
        margin-left: 0 !important;
        min-height: 0 !important;
        -webkit-transform: translate(0, 0) !important;
        -ms-transform: translate(0, 0) !important;
        -o-transform: translate(0, 0) !important;
        transform: translate(0, 0) !important;
      }
      .fixed .content-wrapper,
      .fixed .right-side {
        padding-top: 0 !important;
      }
      .invoice {
        width: 100%;
        border: 0;
        margin: 0;
        padding: 0;
      }
      .invoice-col {
        float: left;
        width: 33.3333333%;
      }
      .table-responsive {
        overflow: auto;
      }
      .table-responsive > .table tr th,
      .table-responsive > .table tr td {
        white-space: normal !important;
      }
    }
  </style>
</head>
<body onload="window.print();">
<div class="wrapper" style="font-size: 11px;">
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-6">
          <img src="<?=base_url();?>assets/img/phoenix.png" alt="Young Phoenix" width="80%"><br/>
          <address>
            BBSR-2, Odisha<br/>
            Phone No - 8658 599 505, 0674-2343851<br/>
            Aff No: 1530218/16, NOC No: 14890/18
          </address>
        </div>
        <div class="col-xs-6 pull-right">
          <address>
            <strong><?php echo $student[0]['student_first_name'].' '.$student[0]['student_last_name'];?></strong><br>
            Class - <?php echo $class ? $class[0]['class_name'] : '';?><br>
            Session - <?php echo $class ? $session[0]['session_name'] : '';?>
          </address>
          <b>Receipt #<?php echo $receipt[0]['receipt_no'];?></b><br>
          <b>Receipt Date:</b> <?php echo date("d/m/Y", strtotime($receipt[0]['receipt_date']));?><br>
          <b>Receipt By:</b> <?php if($receipt[0]['payment_mode'] == 'Online'){ echo 'Self'; }else{ $usr = getFetchData("users", "firstname, lastname", "user_id = ".$receipt[0]['created_by']);echo $usr[0]['firstname'].' '.$usr[0]['lastname']; }?>
        </div>
        <!-- /.col -->
      </div>
      
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table width="100%" border="1" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php if($items){ for($i=0;$i<count($items);$i++){?>
            <tr>
              <td><?=$items[$i]['item_quantity'];?></td>
              <td><?=$items[$i]['item_name'];?></td>
              <td><?=$items[$i]['final_amount'];?></td>
            </tr>
            <?php }}?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p>Payment Methods: <?=$receipt[0]['payment_mode'];?>
            <?=$receipt[0]['cheque_no'] != '' ? '<br/>Cheque No-'.$receipt[0]['cheque_no'] : '';?>
            <?=$receipt[0]['bank_name'] != '' ? '<br/>Bank Name-'.$receipt[0]['bank_name'] : '';?>
            <?=$receipt[0]['bank_branch'] != '' ? '<br/>Branch-'.$receipt[0]['bank_branch'] : '';?>
          </p>
          <p>Amount In Words : <b><?=translateToWords($receipt[0]['total_amount']);?></b> only</p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">

          <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr>
                <th>Grand Total:</th>
                <td><?=$receipt[0]['total_amount'];?></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <div class="col-xs-12">
          <small>NB: The tution fees is to be paid before 10th of every subsequent month. If it is not paid within the said period then Rs. 50/- will be charged as fine till 10th of next subsequent month. After this Rs. 100/- will be charged as fine till rest 10th. Finally if the fees is not paid  double of tution fees will be charged as fine. If tution fee is not paid for 3 months the school has right to expel the student without any further notice.</small>
        </div>

        <div class="col-md-4 pull-right" align="center" style="border-top: 1px solid #000; margin-top: 70px;">
          Account Seal with Signature
        </div>
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="<?php echo site_url("payments/print_receipt/".$receipt[0]['receipt_id']);?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>

</div>
</body>
<script type="text/javascript">
  document.onkeyup = function(e) {
    if (e.which == 117) {
      window.history.back();
    }
  };
</script>
</html>