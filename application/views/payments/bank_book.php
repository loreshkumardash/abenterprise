<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Book
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bank Transaction</h3>
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
                <form role="form" action="" method="get" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="mode">Bank</label>
                    <select class="form-control" id="bank_id" name="bank_id">
                      <option value="">select</option>
                      <?php if($banks){ for($i=0;$i<count($banks);$i++){ ?>
                      <option value="<?=$banks[$i]['bank_id']?>"><?=$banks[$i]['bank_name']?></option>
                      <?php  }} ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="mode">Mode</label>
                    <select class="form-control " id="mode" name="mode">
                      <option value="">select</option>
                      <option value="Credit">Credit</option>
                      <option value="Debit">Debit</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_from">Create date from</label>
                    <input type="date" class="form-control" id="datefrom" name="datefrom" value="<?php echo set_value("created_on_from");?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_to">Create date to</label>
                    <input type="date" class="form-control" id="dateto" name="dateto" value="<?php echo set_value("created_on_to");?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                </div>
                </form>
              </div>
              <div class="row">
                
                <div class="col-md-12" id="dataTablediv">
                  <div class="table-responsive mb-0" data-pattern="priority-columns">
                  <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                    <tr>
                      <th>ID</th>
                      <th>Mode</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>From</th>
                      <th>Bank Name</th>
                      <th>Remarks</th>
                      <th>Status</th>
                      <th>Balance</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['id'];?></td>
                      <td><?php echo $records[$i]['transaction_type'];?></td>
                      <td><?php echo date("d/m/Y g:i A", strtotime($records[$i]['transaction_date']));?></td>
                      <td><?php echo $records[$i]['transaction_amount'];?></td>
                      <td><?php echo $records[$i]['voucher_no'] == '' ? 'Receipt No: '.$records[$i]['receipt_no'] : 'Voucher No: '.$records[$i]['voucher_no'];?></td>
                      <th><?php echo $records[$i]['bank_name'];?></th>
                      <td>
                        <?php echo $records[$i]['remarks'];?>
                      </td>
                      <th><?php echo $records[$i]['voucher_status'];?></th>
                      <th><?php echo $records[$i]['balance_amount'];?></th>

                    </tr>
                    <?php }} ?>
                  </table>
                </div>
                  <?php if($records){echo $sPages;}?>
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
    /*$(function () {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: false
        });
    });*/
</script>
<script type="text/javascript">

</script>
</body>
</html>