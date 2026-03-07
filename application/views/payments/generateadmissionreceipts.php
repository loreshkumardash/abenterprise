<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Students
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Pending Admission Receipts</h3>
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
                  if($this->session->flashdata('saveandprint')){
                    ?>
                  <script type="text/javascript">
                    window.open('<?php echo site_url("payments/print_receipt/".$this->session->flashdata('saveandprint'))?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650');
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
                </div>
                <form role="form" action="" method="get" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="class_id">Class</label>
                    <select class="form-control addadmissionfields" id="class_id" name="class_id">
                      <option value=""></option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                
                
                <div class="col-md-4" style="padding-top:25px;">
                  <button type="submit" class="btn bg-navy btn-flat btn-sm">Search</button>
                </div>
                </form>
              </div>
              <form action="" method="post">
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                    <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                        <tr>
                            <th><input type="checkbox" name="checkall" class="checkall"></th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Student Type</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Receipt Amount</th>
                        </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                        <td><input type="checkbox" class="checkthis" value="<?=$records[$i]['receipt_id'];?>" name="invoice_id[]"></td>
                        <td><?php echo $records[$i]['student_id'];?></td>
                        <td>
                            <?php echo $records[$i]['student_first_name'].' '.$records[$i]['student_last_name'];?>
                        </td>
                        <td><?php echo $records[$i]['student_email'].'<br/>'.$records[$i]['student_mobile'];?></td>
                        <td><?php echo $records[$i]['parent_type'];?></td>
                        <td><?php echo $records[$i]['class_name'];?></td>
                        <td><?php echo $records[$i]['session_name'];?></td>
                        <td><?php echo $records[$i]['total_amount'];?></td>
                    </tr>
                    <?php }} ?>
                    </table>
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat btn-sm">Generate Receipts</button>
                </div>
              </div>
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
<link href="<?=base_url();?>assets/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?=base_url();?>assets/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>
<script type="text/javascript">

$(".checkall").click(function () {
    $('.checkthis').not(this).prop('checked', this.checked);
});
</script>

</body>
</html>