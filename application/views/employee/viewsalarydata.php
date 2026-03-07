<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Salary Data Of :- <?php echo $employee[0]['employee_name'];?>
        <small>For the year of <?=$curSession;?></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Salary Month Wise</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>#Sl No</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Session</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo ($i+1);?></td>
                  <td><?php echo date('F',strtotime(date('Y-'.$records[$i]['month'].'-d')));;?></td>
                  <td><?php echo $records[$i]['year'];?></td>
                  <td><?php echo $records[$i]['session'];?></td>
                  <td><?php if($records[$i]['credit_status'] == 0){ if(strtotime(date('Y-m')) > strtotime(date($records[$i]['year'].'-'.$records[$i]['month']))){?><a href="<?php echo site_url("employee/salarycalculate/".$records[$i]['transaction_id'].'/'.$employeeId.'/'.$records[$i]['month'].'/'.$records[$i]['year']);?>" class="btn btn-xs btn-success">Review & Pay</a><?php }else{ echo '---';} }else{ ?> <a class="btn btn-xs btn-warning">Paid</a> | <a href="<?php echo site_url("employee/viewsalaryreceipt/".$records[$i]['transaction_id'].'/'.$employeeId.'/'.$records[$i]['month'].'/'.$records[$i]['year']);?>" class="btn btn-xs btn-default">View Receipt</a>' <?php } ?></td>
                </tr>
                <?php }} ?>
              </table>
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
<script type="text/javascript">
  $('.clockpick').clockpicker({
            autoclose:true
        });
</script>
</body>
</html>