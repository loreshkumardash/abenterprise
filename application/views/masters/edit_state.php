<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>State Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit State</h3>
              <a href="<?=site_url("masters/state");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
            </div>
            <form method="post" action="<?php echo site_url("masters/edit_state/".$rec[0]['state_id']);?>">
            <div class="box-body" style="padding: 20px;">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="state">State</label>
                    </div>
                      <div class="col-md-7">
                        <input type="text" id="state_id" name="state_id" class="form-control" readonly value="<?=$rec[0]['state_title'];?>"> 
                          
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  
                </div>
              </div>
              <br>
              <label style="color: #5c8230;text-decoration: underline;"><span style="color: #5c8230!important;">LWF</span> Setting :</label>
              <br>
              
              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="balance">LWF Percent(%)</label>
                    </div>
                    <div class="col-md-7">
                      <input type="number" class="form-control" id="lwf_percent" name="lwf_percent" placeholder="" value="<?=$rec[0]['lwf_percent'];?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="state">Emp. Share/Max Limit</label>
                    </div>
                      <div class="col-md-7">
                        <input type="number" class="form-control" id="lwfemp_share" name="lwfemp_share" placeholder="" value="<?=$rec[0]['lwfemp_share'];?>">
                      </div>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-top: 5px;">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="balance">LWF Deduction Period</label>
                    </div>
                    <div class="col-md-7">
                      <select class="form-control" id="lwfdeduction_period" name="lwfdeduction_period" placeholder="" value="<?=$rec[0]['lwfdeduction_period'];?>">
                        <option value="None">None</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-5">
                      <label for="state">Empr. Share/Max Limit</label>
                    </div>
                      <div class="col-md-7">
                        <input type="number" class="form-control" id="lwfempr_share" name="lwfempr_share" placeholder="" value="<?=$rec[0]['lwfempr_share'];?>">
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