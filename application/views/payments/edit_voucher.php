<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Voucher
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Voucher - <?=$voucher[0]['voucher_id'];?></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("payments/edit_voucher/".$voucher[0]['voucher_id']);?>" method="post">
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
                    <label for="expense_type">Expense Type</label>
                    <select class="form-control" id="expense_type" name="expense_type">
                      <option>select</option>
                      <?php if($expense_types){ for($i=0;$i<count($expense_types);$i++){?>
                      <option value="<?php echo $expense_types[$i]['id'];?>" <?=$voucher[0]['expense_type'] == $expense_types[$i]['id'] ? 'selected="selected"' : '';?>><?php echo $expense_types[$i]['expense_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cheque_no">Cheque/Receipt No</label>
                    <input type="text" class="form-control nocash" id="cheque_no" name="cheque_no" value="<?=$voucher[0]['cheque_no']?>" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control nocash" id="bank_name" name="bank_name" value="<?=$voucher[0]['bank_name']?>" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_branch">Bank Branch</label>
                    <input type="text" class="form-control nocash" id="bank_branch" name="bank_branch" value="<?=$voucher[0]['bank_branch']?>" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="mobile">Mobile No</label>
                    <input type="text" class="form-control " id="mobile" name="mobile" value="<?=$voucher[0]['mobile']?>" />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="saveandprint"><input type="checkbox" class="" name="saveandprint" value="Yes"> Save and Print the voucher</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control " id="remarks" name="remarks" required="required"><?=$voucher[0]['remarks']?></textarea>
                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
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
  $('#expense_type').select2();
</script>
</body>
</html>