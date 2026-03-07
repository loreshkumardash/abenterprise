<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Receipt No : <small><?php echo $receipt[0]['receipt_no'];?></small>
      </h1>
    </section>

    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-4">
          <img src="<?=base_url();?>assets/img/phoenix.png" alt="O>P>JINDAL SCHOOL" width="100%"><br/>
          <address>
            O.P. Jindal School Jindal Nagar, SH 63,
Chhendipada Road, Angul,
<br/>
Odisha - 759 111, INDIA
            Phone No - +91 9777444489
          </address>
        </div>
        <div class="col-xs-4 pull-right">
          <?php if($student){?>
          <address>
            <strong><?php echo $student[0]['student_first_name'].' '.$student[0]['student_last_name'];?></strong><br>
            Class - <?php echo $class ? $class[0]['class_name'] : '';?><br>
            Session - <?php echo $class ? $session[0]['session_name'] : '';?>
          </address>
          <?php }else{?>
          <address>
            <strong><?php echo $receipt[0]['cname'];?></strong><br>
            <?php echo $receipt[0]['cmobile'];?><br>
            <?php echo $receipt[0]['cdetails'];?>
          </address>
          <?php }?>
          <b>Receipt #<?php echo $receipt[0]['receipt_no'];?></b><br>
          <b>Receipt Date:</b> <?php echo date("d/m/Y", strtotime($receipt[0]['receipt_date']));?><br>
          <b>Receipt By:</b> <?php $usr = getFetchData("users", "firstname, lastname", "user_id = ".$receipt[0]['created_by']);echo $usr[0]['firstname'].' '.$usr[0]['lastname'];?>
        </div>
        <!-- /.col -->
      </div>
      
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Unit Price</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php if($items){ for($i=0;$i<count($items);$i++){?>
            <tr>
              <td><?=$items[$i]['item_quantity'];?></td>
              <td><?=$items[$i]['item_name'];?></td>
              <td><?=$items[$i]['item_price'];?></td>
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
          <p>Payment Methods: <?=$receipt[0]['payment_mode'];?></p>
          <p>Amount In Words : <?=translateToWords($receipt[0]['total_amount']);?> only</p>
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
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">

</script>
</body>
</html>