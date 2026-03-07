<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee Salary Configuration
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <form role="form" action="<?php echo site_url("employee/salaryconfig/").$employeeId;?>" autocomplete="off" method="post">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Salary Structure</h3>
            </div>
            <!-- /.box-header -->
            
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
              <?php if(!empty($getPaymentHeads)){
                $totalSal = 0;
                foreach ($getPaymentHeads as $k => $v) {
                  if(!empty($empoyeeSalary)){
                    $getkey = array_search($v['wages_id'], array_column($empoyeeSalary, 'salary_head'));
                    //if($getkey != '' || $getkey == 0){
                    if(is_numeric($getkey)){
                      $existingVal = $empoyeeSalary[$getkey];
                    }
                    $totalSal = ($totalSal+$existingVal['salary_value']);
                  }
                  //echo $existingVal['salary_value'];exit;
              ?>  
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="input_value_<?php echo $v['wages_id'];?>[]"><?php echo $v['wages_name'];?></label>
                        <!---start for salary config ID (table auto inc ID)--->
                        <input type="hidden" name="input_value_<?php echo $v['wages_id'];?>[]" value="<?php echo (!empty($empoyeeSalary) && is_numeric($getkey))?$existingVal['config_id']:0;?>">
                        <!---End--->

                        <!---start for salary head ID--->
                        <input type="hidden" name="input_value_<?php echo $v['wages_id'];?>[]" value="<?php echo $v['wages_id'];?>">
                        <!---End--->

                        <!---start for salary Amount--->
                        <input type="text" class="form-control salaryamt" onkeyup="return calculateEpfval();" onkeypress="return isDecimal(event);" maxlength="8" value="<?php echo (!empty($empoyeeSalary) && is_numeric($getkey))?$existingVal['salary_value']:'0.00';?>" id="" name="input_value_<?php echo $v['wages_id'];?>[]" placeholder="Enter <?php echo $v['wages_name'];?> Value" required="required">
                        <!---End--->

                      </div>
                    </div>
                </div>
              <?php }}?>


              <div class="row epfdiv" <?php echo (!empty($empoyeeSalary) && $totalSal > 20000)?'style="display:none;"':'';?>>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="epfpercentile">EPF Amount (in Rs.)</label>
                    <input type="text" class="form-control" onkeypress="return isDecimal(event);" maxlength="8" value="<?php echo ($empoyeeEpf[0]['epf_status'] > 0)?$empoyeeEpf[0]['epf_percentile']:'0.00'?>" id="epfpercentile" name="epfpercentile" placeholder="Enter epfpercentile Value">
                  </div>
                </div>
              </div>
            </div>
            <?php if(!empty($getPaymentHeads)){?>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <button type="reset" name="reset" value="reset" class="btn btn-default">Reset</button>
            </div>
            <?php }?>
          </div>
        </div>
        </form>
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
  function calculateEpfval(){
    var addSalaryvalue = 0.00;
    $('.salaryamt').each(function(){
      //console.log(this.value)
       addSalaryvalue = addSalaryvalue+(parseFloat(this.value));
    });
    //console.log(addSalaryvalue);

    if(addSalaryvalue < <?php echo $getepfAmt[0]['apply_below_amt']?>){
      //console.log(111111111111)
      $('.epfdiv').show();
      $('#epfpercentile').attr('required',true);
    }else{
      $('.epfdiv').hide();
      $('#epfpercentile').attr('required',false);
    }

  }
</script>
</body>
</html>
