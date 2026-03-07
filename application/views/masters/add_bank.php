<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Bank Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Banks</h3>
              <a href="<?=site_url("masters/banks");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
            </div>
            <form method="post" action="<?php echo site_url("masters/add_bank");?>">
            <div class="box-body" style="padding: 20px;">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Bank Name</label> <span style="color:red;"> *</span>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="bank_name" name="bank_name" placeholder="Enter Bank Name" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Branch Code / MICR Code</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="micr_code" name="micr_code" placeholder="Enter Branch Code">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Bank A/C Number</label> <span style="color:red;"> *</span>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="account_no" name="account_no" placeholder="Enter Account Number" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="branch_name">Branch Name</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="branch_name" name="branch_name" placeholder="Enter Branch Name">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_ifsc">IFSC Code</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" placeholder="Enter Bank IFSC">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="corporate_id">Corporate Id</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="corporate_id" name="corporate_id" placeholder="Enter Corporate Id">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_address">Bank Address</label>
                    </div>
                    <div class="col-md-7">
                      <textarea class="form-control" id="bank_address" name="bank_address" placeholder="Enter Bank Address" rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="remark">Remark</label>
                    </div>
                    <div class="col-md-7">
                      <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remarks" rows="2"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="balance">Bank Balance</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="balance" name="balance" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="status">Status</label>
                    </div>
                    <div class="col-md-7">
                      <select class="form-control" id="status" name="status"> 
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
                    </div>
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
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
</body>
</html>