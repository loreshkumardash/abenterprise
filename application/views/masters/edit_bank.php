<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Classes</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Bank</h3>
              <a href="<?=site_url("masters/banks");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
            </div>
            <form method="post" action="<?php echo site_url("masters/edit_bank/".$bank[0]['bank_id']);?>">
            <div class="box-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Bank Name</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="bank_name" name="bank_name" placeholder="Enter Bank Name" value="<?=$bank[0]['bank_name'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Branch Code / MICR Code</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="micr_code" name="micr_code" placeholder="Enter Branch Code" value="<?=$bank[0]['micr_code'];?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Bank A/C Number</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="account_no" name="account_no" placeholder="Enter Account Number" value="<?=$bank[0]['account_no'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="branch_name">Branch Name</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="branch_name" name="branch_name" placeholder="Enter Branch Name" value="<?=$bank[0]['branch_name'];?>">
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
                      <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" placeholder="Enter Bank IFSC" value="<?=$bank[0]['bank_ifsc'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="corporate_id">Corporate Id</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="corporate_id" name="corporate_id" placeholder="Enter Corporate Id" value="<?=$bank[0]['corporate_id'];?>">
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
                      <textarea class="form-control" id="bank_address" name="bank_address" placeholder="Enter Bank Address" rows="2"><?=$bank[0]['bank_address'];?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="remark">Remark</label>
                    </div>
                    <div class="col-md-7">
                      <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remarks" rows="2"><?=$bank[0]['remark'];?></textarea>
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
                      <input type="text" class="form-control" id="balance" name="balance" placeholder="" value="<?=$bank[0]['balance'];?>" readonly disabled>
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
                        <option value="1" <?=$bank[0]['status'] == '1' ? 'selected="selected"' : '';?>>Active</option>
                        <option value="0" <?=$bank[0]['status'] == '0' ? 'selected="selected"' : '';?>>Inactive</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- <div class="form-group">
                <label for="bank_name">Bank Name</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name" value="<?=$bank[0]['bank_name'];?>">
              </div>
              <div class="form-group">
                <label for="account_no">Account Number</label>
                <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Enter Account Number" value="<?=$bank[0]['account_no'];?>">
              </div>
              <div class="form-group">
                <label for="bank_ifsc">Bank IFSC</label>
                <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" placeholder="Enter Bank IFSC" value="<?=$bank[0]['bank_ifsc'];?>">
              </div>
              <div class="form-group">
                <label for="bank_address">Bank Branch</label>
                <input type="text" class="form-control" id="bank_address" name="bank_address" placeholder="Enter Bank Branch" value="<?=$bank[0]['bank_address'];?>">
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status"> 
                  <option value="1" <?=$bank[0]['status'] == '1' ? 'selected="selected"' : '';?>>Active</option>
                  <option value="0" <?=$bank[0]['status'] == '0' ? 'selected="selected"' : '';?>>Inactive</option>
                </select>
              </div> -->
              
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
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
</body>
</html>