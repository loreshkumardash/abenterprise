<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Branch Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Branch</h3>
              <a href="<?=site_url("masters/branch");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
            </div>
            <form method="post" action="<?php echo site_url("masters/edit_branch/".$branch[0]['branch_id']);?>">
            <div class="box-body" style="padding: 20px;">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="branch_name">Branch Name</label> <span style="color:red;"> *</span>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="branch_name" name="branch_name" required value="<?=$branch[0]['branch_name'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="branch_manager">Branch Manager</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="branch_manager" name="branch_manager" value="<?=$branch[0]['branch_name'];?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="bank_name">Mobile Number</label>
                    </div>
                    <div class="col-md-7">
                      <input type="mobile" class="form-control input-sm" id="mobile_no" name="mobile_no" maxlength="10" value="<?=$branch[0]['mobile_no'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="fax_no">Fax Number</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="fax_no" name="fax_no" value="<?=$branch[0]['fax_no'];?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="email">Email</label>
                    </div>
                    <div class="col-md-7">
                      <input type="email" class="form-control" id="email" name="email" value="<?=$branch[0]['email'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="website">Website</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control input-sm" id="website" name="website" placeholder="Enter Corporate Id" value="<?=$branch[0]['website'];?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="address">Address</label>
                    </div>
                    <div class="col-md-7">
                      <textarea class="form-control" id="address" name="address" placeholder="Enter Bank Address" rows="2"><?=$branch[0]['address'];?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="city">City</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="city" name="city" value="<?=$branch[0]['city'];?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="balance">Pincode</label>
                    </div>
                    <div class="col-md-7">
                      <input type="number" class="form-control" id="pincode" name="pincode" placeholder="" value="<?=$branch[0]['pincode'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="state">State</label>
                    </div>
                      <div class="col-md-7">
                        <select class="form-control" id="state" name="state"> 
                          <option value="">Select State</option>
                          <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                              <option value="<?=$state[$i]['state_id'];?>" <?=$state[$i]['state_id']==$branch[0]['state']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
                          <?php } } ?>
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