<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Legder Master
        <small>Bank Details</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><b><span style="color: #1a4152;"><?=$ledger[0]['ledger_name'];?></span></b> Bank Details</h3>
              <a href="<?php echo site_url("masters/view_ledger/".$ledger_id);?>" class="btn btn-xs btn-primary float-right">Back</a>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/ledgerbank_details?ledger_id=".$ledger_id."&did=".$did);?>" method="post">
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
              
              if($this->session->flashdata('error')){
              ?>
              <div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
              </div>
              <?php
              }
              ?>
               <div class="row form-group"> 
                      <div class="col-md-2">
                          <label for="ledger_name">Ledger Name : </label>
                      </div>
                      <div class="col-md-3">
                          <p><b><?=$ledger[0]['ledger_name'];?></b></p>
                      </div>
                      <div class="col-md-2">
                          <label for="excisereg_no">Account Group : </label>
                      </div>
                      <div class="col-md-3">
                          <p><b style="color:red;"><?=$ledger[0]['group_name'];?></b></p>
                      </div>
                </div> 

                <div class="row form-group"> 
                      <div class="col-md-2">
                          <label for="bankac_no">Bank Account No. : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="bankac_no" id="bankac_no" value="<?php echo isset($rec[0]['bankac_no'])?$rec[0]['bankac_no']:'';?>"> 
                             
                      </div>
                      <div class="col-md-2">
                          <label for="acholder_name">Account Holder Name : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="acholder_name" id="acholder_name" value="<?php echo isset($rec[0]['acholder_name'])?$rec[0]['acholder_name']:'';?>"> 
                             
                      </div>
                      
                </div>

                <div class="row form-group">
                      <div class="col-md-2">
                          <label for="bank_name">Bank Name : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="bank_name" id="bank_name" value="<?php echo isset($rec[0]['bank_name'])?$rec[0]['bank_name']:'';?>"> 
                             
                      </div> 
                      <div class="col-md-2">
                          <label for="bankbranch_name">Bank Branch Name : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="bankbranch_name" id="bankbranch_name" value="<?php echo isset($rec[0]['bankbranch_name'])?$rec[0]['bankbranch_name']:'';?>"> 
                             
                      </div>
                </div>

                <div class="row form-group">
                      <div class="col-md-2">
                          <label for="bank_city">Bank City : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="bank_city" id="bank_city" value="<?php echo isset($rec[0]['bank_city'])?$rec[0]['bank_city']:'';?>"> 
                             
                      </div> 
                      <div class="col-md-2">
                          <label for="ifsc_code">IFSC Code: </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="ifsc_code" id="ifsc_code" value="<?php echo isset($rec[0]['ifsc_code'])?$rec[0]['ifsc_code']:'';?>"> 
                             
                      </div>
                      
                </div>

                <div class="row form-group">
                      <div class="col-md-2">
                          <label for="micr_code">MICR Code : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="micr_code" id="micr_code" value="<?php echo isset($rec[0]['micr_code'])?$rec[0]['micr_code']:'';?>"> 
                             
                      </div>
                      <!-- <div class="col-md-5">
                        <input type="checkbox" name="default_ac" id="default_ac" value="active">
                           <label for="default_ac">Treat this as Default (Main A/c.)</label>   
                      </div> -->
                </div>

                
                
              <input type="hidden" class="form-control form-control-sm" name="ledger_id" id="ledger_id" value="<?=$ledger_id;?>">
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Bank Details</h3>
            </div>
            <div class="box-body">
              <form role="form" action="<?php echo site_url("masters/ledgerbank_details?ledger_id=".$ledger_id);?>" method="post">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Default A/c.</th>
                  <th>Account No.</th>
                  <th>Bank Name</th>
                  <th>Bank Branch</th>
                  <th>Bank City</th>
                  <th>IFSC Code</th>
                  <th>Account Holder</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><input type="radio" name="default_ac" value="<?php echo $records[$i]['bankdetails_id'];?>" onchange="this.form.submit()" <?php echo $records[$i]['default_ac'] == 'Active' ? 'checked="checked"' : '';?>></td>
                  <td><?php echo $records[$i]['bankac_no'];?></td>
                  <td><?php echo $records[$i]['bank_name'];?></td>
                  <td><?php echo $records[$i]['bankbranch_name'];?></td>
                  <td><?php echo $records[$i]['bank_city'];?></td>
                  <td><?php echo $records[$i]['ifsc_code'];?></td>
                  <td><?php echo $records[$i]['acholder_name'];?></td>
                 
                  <td>
                    <?php if(/*in_array('classedit', $accessar) || */$this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/ledgerbank_details?ledger_id=".$records[$i]['ledger_id']."&did=".$records[$i]['bankdetails_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(/*in_array('classdelete', $accessar) || */$this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletebank_details/".$records[$i]['bankdetails_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
            </form>
            </div>
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