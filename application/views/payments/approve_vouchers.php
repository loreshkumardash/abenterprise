<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment Vouchers
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Vouchers</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
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
                </div>
                <form role="form" action="<?php echo site_url("payments/download_vouchers");?>" method="post" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <select class="form-control " id="purpose" name="purpose">
                      <option value="">select</option>
                      <option value="Expense">Expense</option>
                      <option value="Salary">Salary</option>
                      <option value="Deposite">Deposite</option>
                      <option value="Withdraw">Withdraw</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="expense_type">Expenses Type</label>
                    <select class="form-control " id="expense_type" name="expense_type" style="height: 34px;">
                      <option value="">select</option>
                      <?php if($expense_types){ for($i=0;$i<count($expense_types);$i++){?>
                      <option value="<?php echo $expense_types[$i]['id'];?>" <?=isset($_REQUEST['expense_type']) && $_REQUEST['expense_type'] == $expense_types[$i]['id'] ? 'selected="selected"' : '';?>><?php echo $expense_types[$i]['expense_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                
                
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="user_id">Created By</label>
                    <select class="form-control " id="user_id" name="user_id">
                      <option value="">select</option>
                      <?php if($users){ for($i=0;$i<count($users);$i++){?>
                      <option value="<?php echo $users[$i]['user_id'];?>" <?=isset($_REQUEST['user_id']) && $_REQUEST['user_id'] == $users[$i]['user_id'] ? 'selected="selected"' : '';?>><?php echo $users[$i]['firstname'].' '.$users[$i]['lastname'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="payment_mode">Payment Mode</label>
                    <select class="form-control " id="payment_mode" name="payment_mode">
                      <option value="">select</option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Bank Deposite">Bank Deposite</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="payment_date_from">Payment date from</label>
                    <input type="date" class="form-control" id="payment_date_from" name="payment_date_from" value="<?php echo set_value("payment_date_from");?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="payment_date_to">Payment date to</label>
                    <input type="date" class="form-control" id="payment_date_to" name="payment_date_to" value="<?php echo set_value("payment_date_to");?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select class="form-control " id="employee_id" name="employee_id">
                      <option value="">select</option>
                      <?php if($employees){ for($i=0;$i<count($employees);$i++){?>
                      <option value="<?php echo $employees[$i]['employee_id'];?>"><?php echo $employees[$i]['employee_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4" style="margin:5px auto; padding-top: 20px;">
                  <button type="submit" class="btn bg-navy btn-flat" formmethod="get" formaction="<?=site_url("payments/approve_vouchers");?>">Search</button>
                  <!--<button type="submit" name="submitBtn" value="submit" class="btn bg-maroon btn-flat">Download</button>-->
                </div>
                </form>
              </div>
              <div class="row">
                
                <div class="col-md-12" id="dataTablediv">
                  <div class="table-responsive mb-0" data-pattern="priority-columns">
                  <table width="100%" class="table table-condensed table-small-font table-bordered table-striped">
                    <thead>
                    <tr>
                      <th data-priority="1">ID</th>
                      <th data-priority="1">Action</th>
                      <th data-priority="1">Date</th>
                      <th data-priority="1">Amount</th>
                      <th data-priority="1">Payment Mode</th>
                      <th data-priority="1">Purpose</th>
                      <th data-priority="1">Expense Type</th>
                      <th data-priority="1">Employee</th>
                      <th data-priority="1">Remarks</th>
                    </tr>
                  </thead>
                  <tbody class="font11">
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['voucher_id'];?></td>
                      <td>
                        <?php if(in_array('voucher_approver', $accessar) || $this->session->userdata('usertype') == 'Admin'){ if($records[$i]['is_approved'] == '0'){ ?>
                        <a href="<?php echo site_url("payments/approve_voucher/".$records[$i]['voucher_id']);?>" class="btn btn-success btn-xs" onclick="return confirm('Are you sure to approve this?');"><i class="fa fa-check"></i> Approve</a>
                        <a href="<?php echo site_url("payments/delete_approve_voucher/".$records[$i]['voucher_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this?');"><i class="fa fa-edit"></i> Delete</a>
                        <?php }} ?>
                      </td>
                      <td><?php echo date("d/m/Y", strtotime($records[$i]['payment_date']));?></td>
                      <td><?php echo $records[$i]['amount'];?></td>
                      <td><?php echo $records[$i]['payment_mode'];?></td>
                      <td><?php echo $records[$i]['purpose'];?></td>
                      <td><?php echo $records[$i]['expense_name'];?></td>
                      <td><?php echo $records[$i]['employee_name'];?></td>
                      <td><?php echo stripslashes($records[$i]['remarks']);?></td>
                    </tr>
                    <?php }} ?>
                  </tbody>
                  </table>
                </div>
                  <?php if($records){echo $sPages;} ?>
                </div>
              </div>
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
<link href="<?=base_url();?>assets/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?=base_url();?>assets/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: false
        });
    });
</script>
<script type="text/javascript">

  function searchForm(){
    $.ajax({
      url:"<?php echo site_url('payments/list_vouchers_ajax');?>",
      type:"POST",
      data: $("#searchForm").serialize(),
      dataType:"html",
      success: function(data){
        $('#dataTablediv').html(data);
      }
    });
  }
  $('#expense_type').select2();
</script>
</body>
</html>