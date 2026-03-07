
<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Receipt - <?=$receipt[0]['receipt_no']?></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("payments/edit_receipt/".$receipt[0]['receipt_id']);?>" method="post">
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
                window.open('<?php echo site_url("payments/print_receipt/".$this->session->flashdata('saveandprint'))?>','winname');
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cheque_no">Cheque/Receipt No</label>
                    <input type="text" class="form-control nocash" id="cheque_no" name="cheque_no" value="<?=$receipt[0]['cheque_no']?>" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control nocash" id="bank_name" name="bank_name" value="<?=$receipt[0]['bank_name']?>" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_branch">Bank Branch</label>
                    <input type="text" class="form-control nocash" id="bank_branch" name="bank_branch" value="<?=$receipt[0]['bank_branch']?>" />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="payment_remarks">Remarks</label>
                    <textarea class="form-control " id="remarks" name="remarks" required="required"><?=$receipt[0]['remarks']?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="saveandprint"><input type="checkbox" class="" name="saveandprint" value="Yes"> Save and Print the receipt</label>
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
<script src="<?=base_url();?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
	$(".payment_remarks").select2({
		tags: true
	});
</script>

</body>
</html>