<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Legder Master
        <small>Work Orders</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Work Order </h3>
              <a href="<?php echo site_url("masters/view_ledger/".$ledger_id);?>" class="btn btn-xs btn-primary float-right" style="margin-left:2px;width: 6rem;">Back</a>
              <?php if ($did>0) { ?>

              <a href="<?=site_url("masters/ledger_workorder?ledger_id=".$rec[0]['ledger_id']);?>" class="btn btn-xs btn-primary float-right" style="width: 6rem;">Add New</a>

             <?php }?>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/ledger_workorder?ledger_id=".$ledger_id."&did=".$did);?>" method="post">
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
              <div class="col-md-12" style="margin-top:15px;border : 1px solid #ddd;padding: 15px;">
                        <div class="icon icon-lg icon-shape" style="margin-top: -28px!important;">
                            <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Work Order Details</span>
                        </div>
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
                          <p><b style="color:blue;"><?=$ledger[0]['group_name'];?></b></p>
                      </div>
                </div> 

                <div class="row form-group"> 
                      <div class="col-md-2">
                          <label for="wo_no">W.O / P.O No. : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="wo_no" id="wo_no" value="<?php echo isset($rec[0]['wo_no'])?$rec[0]['wo_no']:'';?>" placeholder="W.O / P.O No." required> 
                             
                      </div>
                      <div class="col-md-2">
                          <label for="acholder_name">Security Amount : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="number" class="form-control form-control-sm" name="security_amt" id="wo_date" value="<?php echo isset($rec[0]['security_amt'])?$rec[0]['security_amt']:'0.00';?>" required> 
                             
                      </div>
                      
                </div>

                 <div class="row form-group">
                      <div class="col-md-2">
                          <label for="acholder_name">W.O / P.O Date : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="date" class="form-control form-control-sm" name="wo_date" id="wo_date" value="<?php echo isset($rec[0]['wo_date'])?date("Y-m-d",strtotime($rec[0]['wo_date'])):'';?>" required> 
                             
                      </div>
                      <div class="col-md-2">
                          <label for="bankbranch_name">Deposit Mode : </label>
                      </div>
                      <div class="col-md-3">
                          <select class="form-control form-control-sm" name="deposit_mode" id="deposit_mode" >
                          <option value="NONE">NONE</option> 
                          <option value="NEFT">NEFT</option> 
                          <option value="BG">BG</option> 
                          <option value="RTGS">RTGS</option> 
                          <option value="DD">DD</option> 
                          </select>
                             
                      </div>
                </div>

                <div class="row form-group">
                      <div class="col-md-2">
                          <label for="acholder_name">W.O / P.O Exp Date : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="date" class="form-control form-control-sm" name="woexp_date" id="woexp_date" value="<?php echo isset($rec[0]['woexp_date'])?date("Y-m-d",strtotime($rec[0]['woexp_date'])):'';?>" > 
                             
                      </div>
                      <div class="col-md-2">
                          <label for="remarks">Remarks : </label>
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" value="<?php echo isset($rec[0]['remarks'])?$rec[0]['remarks']:'';?>" placeholder="Remarks"> 
                             
                      </div>
                      
                </div>

                
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
              <h3 class="box-title">List Work Orders</h3>
            </div>
            <div class="box-body">
              <form role="form" action="<?php echo site_url("masters/ledger_workorder?ledger_id=".$ledger_id);?>" method="post">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Default W.O</th>
                  <th>W.O No.</th>
                  <th>W.O Date</th>
                  <th>Exp Date</th>
                  <th>Security Amt</th>
                  <th>Mode</th>
                  <th>Remarks</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><input type="radio" name="default_wo" value="<?php echo $records[$i]['workorder_id'];?>" onchange="this.form.submit()" <?php echo $records[$i]['default_wo'] == 'Active' ? 'checked="checked"' : '';?>></td>
                  <td><?php echo $records[$i]['wo_no'];?></td>
                  <td><?php echo $records[$i]['wo_date'];?></td>
                  <td><?php echo $records[$i]['woexp_date'];?></td>
                  <td><?php echo $records[$i]['security_amt'];?></td>
                  <td><?php echo $records[$i]['deposit_mode'];?></td>
                  <td><?php echo $records[$i]['remarks'];?></td>
                 
                  <td>
                    <?php if(in_array('workorderedit', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
                    <a href="<?php echo site_url("masters/ledger_workorder?ledger_id=".$records[$i]['ledger_id']."&did=".$records[$i]['workorder_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('workorderdelete', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
                    <a href="<?php echo site_url("masters/deletework_order/".$records[$i]['workorder_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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