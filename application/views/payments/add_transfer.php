<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Transfer
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Bank Transfer</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("payments/add_transfer");?>" method="post">
            <div class="box-body">
              <?php
              if($this->session->flashdata('success')){
              ?>
              <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
              </div>
              <?php
              }
              if($this->session->flashdata('saveandprint')){
                ?>
              <script type="text/javascript">
                window.open('<?php echo site_url("payments/print_voucher/".$this->session->flashdata('saveandprint'))?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650');
              </script>
                <?php
              }
              if($this->session->flashdata('error')){
              ?>
              <div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
              </div>
              <?php
              }
              ?>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" class="form-control"  id="payment_date" name="payment_date" required="required" <?=$this->session->userdata("usertype") != 'Admin' ? 'readonly="readonly" value="'.date("Y-m-d").'"' : 'value=""';?>>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control " id="amount" name="amount" required="required" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_id1">Source Bank</label>
                    <select class="form-control" id="bank_id1" name="bank_id1" required="required">
                      <option>select</option>
                      <?php if($banks){ for($i=0;$i<count($banks);$i++){?>
                      <option value="<?php echo $banks[$i]['bank_id'];?>"><?php echo $banks[$i]['bank_name'].' ('.$banks[$i]['account_no'].')';?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-bank_id2">
                    <label for="bank_id2">Destination Bank</label>
                    <select class="form-control" id="bank_id2" name="bank_id2" required="required">
                      <option>select</option>
                      
                    </select>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control " id="remarks" name="remarks" required="required"></textarea>
                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $("#bank_id1").change(function(e){
    $.ajax({
      url: '<?php echo site_url("payments/remainingbanks");?>',
      data: {bank_id : $(this).val()},
      dataType: "HTML",
      type: "POST",
      success: function(data){
        $("#bank_id2").html(data);
      }
    });
  });
  
</script>
</body>
</html>